<?php
use PushOver\Model\User;

class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider userConstructorProvider
     */
    public function testUserConstructor(array $values)
    {
        $user = new User(
            (object) $values
        );
        $compare = new User;
        $compare->setByArray($values);
        $this->assertEquals(
            $compare,
            $user
        );
        $this->assertEquals(
            json_encode(
                $compare->toArray()
            ),
            json_encode(
                $user->toArray()
            )
        );
        $includeNull = false;
        if (in_array(null, $values, true)) {
            $includeNull = true;
        }
        $this->assertEquals(
            json_encode(
                $values
            ),
            json_encode(
                $user->toArray(
                    $includeNull
                )
            )
        );
        $this->assertEquals(
            json_encode(
                $values
            ),
            json_encode(
                $compare->toArray(
                    $includeNull
                )
            )
        );
        //manually check equals
        foreach ($values as $key => $val)
        {
            $getter = 'get' . implode(
                    '',
                    array_map(
                        'ucfirst',
                        explode(
                            '_',
                            strtolower(
                                $key
                            )
                        )
                    )
                );
            if (method_exists($user, $getter))
            {
                $this->assertEquals(
                    $val,
                    $user->{$getter}()
                );
                $this->assertEquals(
                    $val,
                    $compare->{$getter}()
                );
            }
        }
    }

    /**
     * @dataProvider invalidUserProvider
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessageRegExp /Invalid user token [^:]+: /
     */
    public function testInvalidUser($uName)
    {
        $user = new User;
        $user->setUser($uName);
    }

    /**
     * @dataProvider invalidDeviceProvider
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessageRegExp /Invalid device name "[^"]+": /
     */
    public function testInvalidDevice($device)
    {
        $user = new User;
        $user->setDevice($device);
    }

    /**
     * @return array
     */
    public function invalidDeviceProvider()
    {
        return array(
            array('!@#'),
            array('devidenamethatiswaaaaaaaaytoolongshouldthrowexception'),
            array(new stdClass)
        );
    }

    /**
     * @return array
     */
    public function invalidUserProvider()
    {
        return array(
            array(123),
            array('user'),
            array(new stdClass)
        );
    }

    /**
     * @return array
     */
    public function userConstructorProvider()
    {
        return array(
            array(
                array(
                    'user'      => 'abcdefghijklmno1234567890zxyvw',
                    'device'    => 'abcdefghijklmno1234567890'
                )
            ),
            array(
                array(
                    'user'      => 'abcdefghijklmno1234567890zxyvw',
                    'device'    => 'abcdefghijklmno1234567890'
                )
            )

        );
    }
}