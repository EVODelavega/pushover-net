<?php

namespace PushOver;

use PushOver\Model\Credentials;
use PushOver\Model\ReceiptResponse;
use PushOver\Model\Response;

class Receipt extends Api
{
    const API_SECTION = 'receipts/%s';

    /**
     * @param Response $response
     * @param Credentials $credentials = null
     * @return ReceiptResponse
     * @throws \LogicException
     */
    public function getReceipt(Response $response, Credentials $credentials = null)
    {
        if (!$credentials && !$this->defaultCredentials)
        {
            throw new \LogicException(
                sprintf(
                    '%s requires credentials, no default credentials set, and no credentials were passed as argument',
                    __METHOD__
                )
            );
        }
        $credentials = $credentials ? : $this->defaultCredentials;
        if ($this->output !== self::OUTPUT_JSON)
        {
            throw new \LogicException(
                sprintf(
                    '%s output is not supported (yet)',
                    $this->output
                )
            );
        }
        if (!$response->getReceipt())
        {
            throw new \LogicException(
                sprintf(
                    'The response (which was %s) does not have a receipt value',
                    $response->getStatus() !== Response::STATUS_OK ? 'Unsuccessful' : 'Successful'
                )
            );
        }
        /** @var string apiUrl */
        //override apiUrl, filling in receipt
        //always force new apiUrl!
        $this->apiUrl = sprintf(
            $this->getApiUrl(true),
            $response->getReceipt()
        );
        $options = [
            \CURLOPT_POSTFIELDS => [
                'token' => $credentials->getToken()
            ]
        ];
        $curlResp = $this->getRawCurl(
            $response,
            $options
        );
        $receipt = json_decode($curlResp);
        $err = json_last_error();
        if ($err !== \JSON_ERROR_NONE)
        {
            throw new \RuntimeException(
                sprintf(
                    'JSON error %d - %s (response string: %s)',
                    $err,
                    json_last_error_msg(),
                    $curlResp
                )
            );
        }
        return new ReceiptResponse($receipt);
    }
}