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
            $this->assertObjectHasAttribute($response->getReceipt(), $this->data->receipts);
        }
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