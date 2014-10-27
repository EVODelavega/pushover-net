<?php

namespace PushOver;

use PushOver\Model\Data,
    PushOver\Model\Response;

abstract class Api
{
    const API_SECTION = '';

    const OUTPUT_JSON = '.json';
    const OUTPUT_XML = '.xml';

    const SECTION_PUSH = 1;
    const SECTION_RECEIPT = 2;
    const SECTION_VALIDATE = 3;

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
    protected $apiUrl = null;

    /**
     * @var string
     */
    private $responseMethod = 'processJson';

    /**
     * @var array
     */
    private static $Sections = [
        self::SECTION_PUSH      => null,
        self::SECTION_RECEIPT   => null,
        self::SECTION_VALIDATE  => null
    ];

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
     * @param $section
     * @param array $args
     * @return \PushOver\Api
     * @throws \InvalidArgumentException
     */
    final public static function GetApiSection($section, array $args = [])
    {
        if (!array_key_exists($section, static::$Sections))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s is not a valid section, please use %s::SECTION_* constants',
                    $section,
                    __CLASS__
                )
            );
        }
        if (static::$Sections[$section] instanceof Api)
            return static::$Sections[$section];
        switch ($section)
        {
            case self::SECTION_VALIDATE:
                static::$Sections[$section] = new Validate($args);
                break;
            case self::SECTION_PUSH:
                static::$Sections[$section] = new Push($args);
                break;
            case self::SECTION_RECEIPT:
                static::$Sections[$section] = new Receipt($args);
                break;
        }
        return self::$Sections[$section];
    }

    /**
     * @param Data $data
     * @param array $curlOpts
     * @return resource
     */
    private function prepareCurl(Data $data, array $curlOpts = [])
    {
        if ($curlOpts && isset($curlOpts[\CURLOPT_RETURNTRANSFER]))
            $curlOpts[\CURLOPT_RETURNTRANSFER] = true;//make sure this is true
        $ch = curl_init(
            $this->getApiUrl()
        );
        if (!is_resource($ch))
        {
            throw new \RuntimeException(
                sprintf(
                    'Error initializing curl request for class %s',
                    get_class($this)
                )
            );
        }
        $options = [
            \CURLOPT_POSTFIELDS     => $data->toArray(),
            \CURLOPT_SAFE_UPLOAD    => true,
            \CURLOPT_RETURNTRANSFER => true
        ];
        foreach ($curlOpts as $key => $v)
            $options[$key] = $v;
        curl_setopt_array(
            $ch,
            $options
        );
        return $ch;
    }

    /**
     * @param Data $data
     * @param array $curlOpts
     * @return Response
     */
    protected function doCurl(Data $data, array $curlOpts = [])
    {
        $ch = $this->prepareCurl(
            $data,
            $curlOpts
        );
        $response = curl_exec($ch);
        curl_close($ch);
        return $this->{$this->responseMethod}($response);
    }

    /**
     * @param Data $data
     * @param array $opts
     * @return string|bool
     */
    protected function getRawCurl(Data $data, array $opts = [])
    {
        $ch = $this->prepareCurl(
            $data,
            $opts
        );
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    /**
     * @param string $string
     * @return Response
     * @throws \RuntimeException
     */
    protected function processJson($string)
    {
        $obj = json_decode($string);
        $err = json_last_error();
        if ($err !== \JSON_ERROR_NONE)
        {
            throw new \RuntimeException(
                sprintf(
                    'JSON error %d - %s (response: %s)',
                    $err,
                    json_last_error_msg(),
                    $string
                )
            );
        }
        return new Response($obj);
    }

    /**
     * @param string $xml
     * @throws \LogicException
     */
    protected function processXml($xml)
    {
        throw new \LogicException(
            'You should not have been able to do this, %s cannot be parsed yet',
            $xml
        );
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
        $this->responseMethod = 'process'.ucfirst(
                substr(
                    $output, 1
                )
            );
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
