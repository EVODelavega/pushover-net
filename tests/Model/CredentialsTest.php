<?php
use PushOver\Model\Credentials;

class CredentialsTest extends PHPUnit_Framework_TestCase
{//aUA1FxkRQNPjhg8VSJtvXQBAsiieoq
    /**
     * @dataProvider validConstructorProvider
     */
    public function testConstructorValid($token, $user, $app)
    {
        $credentials = new Credentials($token, $user, $app);
        $this->assertEquals(
            $credentials->getToken(),
            $token,
            sprintf(
                'Expected %s to match %s',
                $credentials->getToken(),
                $token
            )
        );
        $this->assertEquals(
            $credentials->getUser(),
            $user,
            sprintf(
                'Expected %s to match %s',
                $credentials->getUser(),
                $user
            )
        );
        $this->assertEquals(
            $credentials->getApplication(),
            $app,
            sprintf(
                'Expected %s to match %s',
                $credentials->getApplication(),
                $app
            )
        );
        if ($app === null)
        {
            $this->assertNull(
                $credentials->getApplication(),
                sprintf(
                    'Expected application to be null, instead saw %s',
                    $credentials->getApplication()
                )
            );
        }
    }

    /**
     * @return array
     */
    public function validConstructorProvider()
    {
        return array(
            array(
                'asdfghkj132456Nasdfghkj132456N',
                'userghkj132456Nasdfghkj132456N',
                null
            ),
            array(
                'asdfghkj132456Nasdfghkj132456N',
                'userghkj132456Nasdfghkj132456N',
                'application'
            )
        );
    }

}