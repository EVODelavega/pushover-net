<?php
namespace PushOver\Model;


class Credentials extends Data
{
    /**
     * @var string
     */
    protected $token = null;

    /**
     * @var string
     */
    protected $user = null;

    /**
     * @var string
     */
    private $application = null;

    /**
     * @param string $token
     * @param string $user
     * @param string $application = null
     */
    public function __construct($token, $user, $application = null)
    {
        $this->setToken(
            $token
        )->setUser(
            $user
        );
        $this->application = $application;
    }

    /**
     * @param string $app
     * @return $this
     */
    public function setApplication($app)
    {
        $this->application = $app;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param string $user
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setUser($user)
    {
        $match = null;
        if (strlen($user) !== 30 || preg_match('/[^a-z0-9]/i', $user, $match))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid user token %s: %s',
                    $user,
                    $match ? 'Contains invalid chars' : 'Not 30 chars long'
                )
            );
        }
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string $token
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setToken($token)
    {
        $match = null;
        if (strlen($token) !== 30 || preg_match('/[^a-z0-9]/i', $token, $match))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid token %s: %s',
                    $token,
                    $match ? 'Contains invalid chars' : 'Not 30 chars long'
                )
            );
        }
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setByArray(array $data)
    {
        if (!isset($data['application']))
            $this->application = $data['application'];
        return parent::setByArray($data);
    }
}