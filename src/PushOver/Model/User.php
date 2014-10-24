<?php
namespace PushOver\Model;


class User extends Data
{
    /**
     * @var Credentials
     */
    private $credentials = null;

    /**
     * @var string
     */
    protected $user = null;

    /**
     * @var string
     */
    protected $device = null;

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
     * @return Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param string $group
     * @return User
     */
    public function setGroup($group)
    {
        return $this->setUser($group);
    }

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->getUser();
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
     * @param $dev
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setDevice($dev)
    {
        $match = null;
        if (strlen($dev) > 25 || preg_match('/[^a-z0-9]/i', $dev, $match))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid device name "%s": %s',
                    $dev,
                    $match ? 'Contains invalid chars' : 'Too long'
                )
            );
        }
        $this->device = $dev;
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
     * @param array $data
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setByArray(array $data)
    {
        if (isset($data['user']) && isset($data['group']))
        {
            throw new \InvalidArgumentException(
                'Cannot set both group and user'
            );
        }
        return parent::setByArray($data);
    }

    /**
     * @param bool $includeNull = false
     * @return array
     */
    public function toArray($includeNull = false)
    {
        $array = parent::toArray(false);
        $array['token'] = $this->credentials->getToken();
        return $array;
    }
}