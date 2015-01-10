<?php

use PushOver\Model\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    protected $data = null;

    protected function setUp()
    {
        $this->data = json_decode(
            file_get_contents('./tests/_data/responses.json')
        );
    }

    public function testResponseConstructor()
    {
        foreach ($this->data->success as $vals)
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