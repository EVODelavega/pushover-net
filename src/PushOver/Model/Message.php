<?php
namespace PushOver\Model;

class Message extends Data
{

    const PRIORITY_LOWEST       = -2;
    const PRIORITY_LOW          = -1;
    const PRIORITY_NORMAL       = 0;
    const PRIORITY_HIGH         = 1;
    const PRIORITY_EMERGENCY    = 1;

    const SOUND_PUSHOVER    = 'pushover';
    const SOUND_BIKE        = 'bike';
    const SOUND_BUGLE       = 'bugle';
    const SOUND_CASHREG     = 'cashregister';
    const SOUND_CLASSIC     = 'classical';
    const SOUND_COSMIC      = 'cosmic';
    const SOUND_FALL        = 'falling';
    const SOUND_GAME        = 'gamelan';
    const SOUND_INC         = 'incoming';
    const SOUND_INTERM      = 'intermission';
    const SOUND_MAGIC       = 'magic';
    const SOUND_MECHANIC    = 'mechanical';
    const SOUND_PIANO       = 'pianobar';
    const SOUND_SIREN       = 'siren';
    const SOUND_SPACE       = 'spacealarm';
    const SOUND_TUG         = 'tugboat';
    //long
    const SOUND_ALIEN       = 'alien';
    const SOUND_CLIMB       = 'climb';
    const SOUND_PERSIST     = 'persistent';
    const SOUND_ECHO        = 'echo';
    const SOUND_UPDOWN      = 'updown';
    //silent
    const SOUND_NO          = 'none';

    /**
     * @var Credentials
     */
    private $credentials = null;

    /**
     * @var string
     */
    protected $message = null;

    /**
     * @var string
     */
    protected $device = null;

    /**
     * @var string
     */
    protected $title = null;

    /**
     * @var int
     */
    protected $timestamp = null;

    /**
     * @var int
     */
    protected $priority = null;

    /**
     * @var string
     */
    protected $url = null;

    /**
     * @var string
     */
    protected $urlTitle = null;

    /**
     * @var string
     */
    protected $sound = null;

    /**
     * @param array $values = []
     * @param Credentials $credentials = null
     */
    public function __construct(array $values = [], Credentials $credentials = null)
    {
        $this->setByArray($values);
        if ($credentials)
            $this->credentials = $credentials;
    }

    /**
     * @return Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param Credentials $credentials
     * @return $this
     */
    public function setCredentials(Credentials $credentials)
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param string $device
     * @return $this
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        if ($priority < static::PRIORITY_LOWEST || $priority > static::PRIORITY_EMERGENCY)
        {
            throw new \InvalidArgumentException(
                sprintf(
                    '%d is an invalid priority level, use %s::PRIORITY_* constants',
                    (int) $priority,
                    __CLASS__
                )
            );
        }
        $this->priority = (int) $priority;

        return $this;
    }

    /**
     * @return string
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * @param string $sound
     * @return $this
     */
    public function setSound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     * @return $this
     */
    public function setTimestamp($timestamp)
    {
        if ($timestamp instanceof \DateTime)
            $timestamp = $timestamp->format('U');
        $this->timestamp = (int) $timestamp;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlTitle()
    {
        return $this->urlTitle;
    }

    /**
     * @param string $urlTitle
     * @return $this
     */
    public function setUrlTitle($urlTitle)
    {
        $this->urlTitle = $urlTitle;

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setByArray(array $data)
    {
        if (isset($data['credentials']))
            $this->setCredentials($data['credentials']);
        return parent::setByArray($data);
    }

    /**
     * @param bool $includeNull = false
     * @return array
     */
    public function toArray($includeNull = false)
    {
        $array = parent::toArray($includeNull);
        $credentials = $this->credentials->toArray($includeNull);
        return array_merge($credentials, $array);
    }

}