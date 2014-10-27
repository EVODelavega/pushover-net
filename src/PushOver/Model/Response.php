<?php

namespace PushOver\Model;


class Response extends Data
{
    const STATUS_OK = 1;

    /**
     * @var int
     */
    protected $status = null;

    /**
     * @var string
     */
    protected $request = null;

    /**
     * @var null|string
     */
    protected $receipt = null;

    /**
     * @var null|array
     */
    protected $errors = null;

    /**
     * @var null|string
     */
    protected $user = null;

    /**
     * @var array
     */
    protected $devices = null;

    /**
     * @param \stdClass $obj
     */
    public function __construct(\stdClass $obj)
    {
        $this->setByArray((array) $obj);
    }

    /**
     * @param array $devices
     * @return $this
     */
    public function setDevices(array $devices)
    {
        $this->devices = $devices;
        return $this;
    }

    /**
     * @return array
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return ($this->status === 1);
    }

    /**
     * @return array|null
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param int $offset
     * @return null|string
     */
    public function getErrorAt($offset)
    {
        if ($this->errors && isset($this->errors[$offset]))
            return $this->errors[$offset];
        return null;
    }

    /**
     * @param array|null $errors
     * @return $this
     */
    public function setErrors(array $errors = null)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getReceipt()
    {
        return $this->receipt;
    }

    /**
     * @param null|string $receipt
     * @return $this
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $request
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = (int) $status;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param null|string $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

}