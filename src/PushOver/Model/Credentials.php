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
        $this->token = $token;
        $this->user = $user;
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
     */
    public function setUser($user)
    {
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
     */
    public function setToken($token)
    {
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