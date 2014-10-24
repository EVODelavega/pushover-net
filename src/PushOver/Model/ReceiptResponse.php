<?php
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
    protected $expiredAt = null;

    /**
     * @var int
     */
    protected $callBack = 0;

    /**
     * @var \DateTime
     */
    protected $callBackAt = null;

    /**
     * @param \stdClass $obj
     */
    public function __construct(\stdClass $obj)
    {
        $this->setByArray((array) $obj);
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
        if (!$acknowledgedAt instanceof \DateTime)
            $acknowledgedAt = new \DateTime($acknowledgedAt);
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
    public function getCallBack()
    {
        return $this->callBack;
    }

    /**
     * @param int $callBack
     * @return $this
     */
    public function setCallBack($callBack)
    {
        $this->callBack = (int) $callBack;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCallBackAt()
    {
        return $this->callBackAt;
    }

    /**
     * @param \DateTime $callBackAt
     * @return $this
     */
    public function setCallBackAt($callBackAt)
    {
        if (!$callBackAt instanceof \DateTime)
            $callBackAt = new \DateTime($callBackAt);
        $this->callBackAt = $callBackAt;

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
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * @param \DateTime $expiredAt
     * @return $this
     */
    public function setExpiredAt($expiredAt)
    {
        if (!$expiredAt instanceof \DateTime)
            $expiredAt = new \DateTime($expiredAt);
        $this->expiredAt = $expiredAt;

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
        if (!$lastDeliveredAt instanceof \DateTime)
            $lastDeliveredAt = new \DateTime($lastDeliveredAt);
        $this->lastDeliveredAt = $lastDeliveredAt;

        return $this;
    }

}