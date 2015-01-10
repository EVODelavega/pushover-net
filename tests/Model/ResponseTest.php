<?php

use PushOver\Model\Response;
use PushOver\Model\ReceiptResponse;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $data = null;

    protected function setUp()
    {
        $this->data = json_decode(
            file_get_contents(
            	'./tests/_data/responses.json'
            )
        );
    }

    public function testResponseConstructor()
    {
        $receiptResponses = array();
        foreach ($this->data->success as $k => $vals)
        {
            $resp = new Response(
                $vals
            );
            $this->assertEquals(
                Response::STATUS_OK,
                $resp->getStatus()
            );
            $this->assertNull(
                $resp->getErrors()
            );
            $this->assertEquals(
                $vals->request,
                $resp->getRequest()
            );
            $this->assertEmpty(
                $resp->getErrors()
            );
            if (in_array($k, $this->data->receiptKeys))
            {
                $this->assertEquals(
                    $vals->receipt,
                    $resp->getReceipt()
                );
                $receiptResponses[] = $resp;
            }
        }
        return $receiptResponses;
    }

    /**
     * @depends testResponseConstructor
     */
    public function testResponseReceipts(array $responses)
    {
        /** @var Response $response */
        foreach ($responses as $response)
        {
            $this->assertObjectHasAttribute(
                $response->getReceipt(),
                $this->data->receipts
            );
            $vals = $this->data->receipts->{$response->getReceipt()};
            $receipt = new ReceiptResponse(
                $this->prepareReceipt(
                    $vals
                )
            );
            $this->assertEquals(
                $vals->status,
                $receipt->getStatus()
            );
            if ($receipt->getStatus())
            {
                $this->assertNull($receipt->getErrorResponse());
                $this->assertInstanceOf(
                	'DateTime',
                    $receipt->getExpiresAt()
                );
                $this->assertEquals(
                    $vals->acknowledged,
                    $receipt->getAcknowledged()
                );
                if ($vals->acknowledged)
                {
                    $this->assertInstanceOf(
                        'DateTime',
                        $receipt->getAcknowledgedAt()
                    );
                }
                $this->assertEquals(
                    $vals->called_back,
                    $receipt->getCalledBack()
                );
                if ($vals->called_back)
                {
                    $this->assertInstanceOf(
                        'DateTime',
                        $receipt->getCalledBackAt()
                    );
                }
                if ($vals->last_delivered_at != 0)
                {
                    $this->assertInstanceOf(
                        'DateTime',
                        $receipt->getLastDeliveredAt()
                    );
                }
                else
                {
                    $this->assertNull($receipt->getLastDeliveredAt());
                }
                //test error-response setter:
                $receipt->setErrorResponse($response);
                $this->assertEquals(
                    $response,
                    $receipt->getErrorResponse()
                );
            }
            else
            {
                $this->assertInstanceOf(
                    get_class($response),
                    $receipt->getErrorResponse()
                );
                $this->assertNotEmpty(
                    $receipt->getErrorResponse()
                        ->getErrors()
                );
            }
        }
    }

    protected function prepareReceipt(\stdClass $data)
    {
        if ($data->status == Response::STATUS_OK)
        {
            $data->expires_at += time();//timestamp required
            if ($data->acknowledged)
            {
                $time = new \DateTime($data->acknowledged_at);
                $data->acknowledged_at = $time->format('U');
            }
            if ($data->last_delivered_at != 0)
            {
                $time =  new \DateTime(
                    $data->last_delivered_at
                );
                $data->last_delivered_at = $time->format('U');
            }
            if ($data->called_back)
            {
                $time = new \DateTime(
                    $data->called_back_at
                );
                $data->called_back_at = $time->format('U');
            }
        }
        return $data;
    }

    public function testErrorResponses()
    {
        foreach ($this->data->error as $vals)
        {
            $resp = new Response(
                $vals
            );
            $this->assertNotEquals(
                Response::STATUS_OK,
                $resp->getStatus()
            );
            $this->assertNotEmpty(
                $resp->getErrors()
            );
            $this->assertEquals(
                $vals->request,
                $resp->getRequest()
            );
            if (isset($vals->user))
            {
                $this->assertEquals(
                    $vals->user,
                    $resp->getUser()
                );
            }
        }
    }
}