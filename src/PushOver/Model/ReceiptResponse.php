<?php
use PushOver\Model\Response;
namespace PushOver\Model;


class ReceiptResponse extends Data
{
    /**
     * @var int
     */
    protected $status = null;

    /**
     * @var int
     */
    protected $acknowledged = 0;

    /**
     * @var \DateTime
     */
    protected $acknowledgedAt = null;

    /**
     * @var string
     */
    protected $acknowledgedBy = null;

    /**
     * @var \DateTime
     */
    protected $lastDeliveredAt = null;

    /**
     * @var int
     */
    protected $expired = 0;

    /**
     * @var \DateTime
     */
    protected $expiresAt = null;

    /**
     * @var int
     */
    protected $calledBack = 0;

    /**
     * @var \DateTime
     */
    protected $calledBackAt = null;

    /**
     * @var Response
     */
    protected $errorResponse = null;

    /**
     * @param \stdClass $obj
     */
    public function __construct(\stdClass $obj)
    {
        if (isset($obj->status) && $obj->status != Response::STATUS_OK && isset($obj->errors))
        {
            $this->errorResponse = new Response($obj);
        }
        $this->setByArray((array) $obj);
    }

    /**
     * @param Response|\stdClass $obj
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setErrorResponse($obj)
    {
        if (!$obj instanceof Response)
        {
            if ($obj instanceof \stdClass)
                $obj = new Response($obj);
            else
                throw new \InvalidArgumentException(
                    sprintf(
                        '%s expects Response instance, or stdClass %s given',
                        __METHOD__,
                        gettype($obj)
                    )
                );
        }
        $this->errorResponse = $obj;
        return $this;
    }

    /**
     * @return null|Response
     */
    public function getErrorResponse()
    {
        return $this->errorResponse;
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
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getAcknowledged()
    {
        return $this->acknowledged;
    }

    /**
     * @param int $acknowledged
     * @return $this
     */
    public function setAcknowledged($acknowledged)
    {
        $this->acknowledged = (int) $acknowledged;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAcknowledgedAt()
    {
        return $this->acknowledgedAt;
    }

    /**
     * @param \DateTime $acknowledgedAt
     * @return $this
     */
    public function setAcknowledgedAt($acknowledgedAt)
    {
        if ($acknowledgedAt != 0)
        {
            if (!$acknowledgedAt instanceof \DateTime)
            {
                if (is_numeric($acknowledgedAt))
                    $acknowledgedAt = \DateTime::createFromFormat('U', $acknowledgedAt);
                else
                    $acknowledgedAt = new \DateTime($acknowledgedAt);
            }
        }
        else
        {
            $acknowledgedAt = null;
        }
        $this->acknowledgedAt = $acknowledgedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getAcknowledgedBy()
    {
        return $this->acknowledgedBy;
    }

    /**
     * @param string $acknowledgedBy
     * @return $this
     */
    public function setAcknowledgedBy($acknowledgedBy)
    {
        $this->acknowledgedBy = $acknowledgedBy;

        return $this;
    }

    /**
     * @return int
     */
    public function getCalledBack()
    {
        return $this->calledBack;
    }

    /**
     * @param int $callBack
     * @return $this
     */
    public function setCalledBack($callBack)
    {
        $this->calledBack = (int) $callBack;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCalledBackAt()
    {
        return $this->calledBackAt;
    }

    /**
     * @param \DateTime $callBackAt
     * @return $this
     */
    public function setCalledBackAt($callBackAt)
    {
        if ($callBackAt != 0)
        {
            if (!$callBackAt instanceof \DateTime)
            {
                if (is_numeric($callBackAt))
                    $callBackAt = \DateTime::createFromFormat('U', $callBackAt);
                else
                    $callBackAt = new \DateTime($callBackAt);
            }
        }
        else
        {
            $callBackAt = null;
        }
        $this->calledBackAt = $callBackAt;

        return $this;
    }

    /**
     * @return int
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @param int $expired
     * @return $this
     */
    public function setExpired($expired)
    {
        $this->expired = (int) $expired;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param \DateTime $expiresAt
     * @return $this
     */
    public function setExpiresAt($expiresAt)
    {
        if (!$expiresAt instanceof \DateTime)
        {
            if (is_numeric($expiresAt))
                $expiresAt = \DateTime::createFromFormat('U', $expiresAt);
            else
                $expiresAt = new \DateTime($expiresAt);
        }
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastDeliveredAt()
    {
        return $this->lastDeliveredAt;
    }

    /**
     * @param \DateTime $lastDeliveredAt
     * @return $this
     */
    public function setLastDeliveredAt($lastDeliveredAt)
    {
        if ($lastDeliveredAt != 0)
        {
            if (!$lastDeliveredAt instanceof \DateTime)
            {
                if (is_numeric($lastDeliveredAt))
                    $lastDeliveredAt = \DateTime::createFromFormat('U', $lastDeliveredAt);
                else
                    $lastDeliveredAt = new \DateTime($lastDeliveredAt);
            }
        }
        else
        {
            $lastDeliveredAt = null;
        }
        $this->lastDeliveredAt = $lastDeliveredAt;

        return $this;
    }

}