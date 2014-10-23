<?php

namespace PushOver;

abstract class Api
{
    const API_SECTION = '';

    const OUTPUT_JSON = '.json';
    const OUTPUT_XML = '.xml';

    /**
     * @var string
     */
    protected $baseUrl = 'https://api.pushover.net/1/';

    /**
     * @var string
     */
    protected $output = self::OUTPUT_JSON;

    /**
     * @var string
     */
    private $apiUrl = null;

    /**
     * @param array $params = []
     */
    public function __construct(array $params = [])
    {
        if (static::API_SECTION === self::API_SECTION)
        {//constants MUST be overriden in child classes
            throw new \LogicException(
                sprintf(
                    '%s failed to override %s::API_SECTION constant',
                    get_class($this),
                    __CLASS__
                )
            );
        }
        foreach ($params as $key => $value)
        {
            $setter = 'set'.implode(
                '',
                array_map(
                    'ucfirst',
                    explode(
                        '_',
                        strtolower($key)
                    )
                )
            );
            if (method_exists($this, $setter))
                $this->{$setter}($value);
        }
    }

    /**
     * @param bool $forceNew = false
     * @return string
     */
    final public function getApiUrl($forceNew = false)
    {
        if ($forceNew === true)
            $this->apiUrl = null;
        if ($this->apiUrl === null)
            $this->apiUrl = $this->baseUrl.static::API_SECTION.$this->output;
        return $this->apiUrl;
    }

    /**
     * @param string $output
     * @return $this
     *
     * @throws \InvalidArgumentException
     * @throws \LogicException
     */
    public function setOutput($output)
    {
        if ($output !== self::OUTPUT_JSON && $output !== self::OUTPUT_XML)
        {
            throw new \InvalidArgumentException(
                sprintf(
                    'invalid output type "%s", use %s::OUTPUT_* constants',
                    $output,
                    __CLASS__
                )
            );
        }
        //XML is unsupported ATM
        if ($output === self::OUTPUT_XML)
            throw new \LogicException('XML output is not supported yet');
        $this->output = $output;
        return $this;
    }

    /**
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setBaseUrl($url)
    {
        $this->baseUrl = $url;
        return $this;
    }

    /**
     * @returns string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
}
