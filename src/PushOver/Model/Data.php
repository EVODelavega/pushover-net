<?php
namespace PushOver\Model;


abstract class Data
{
    /**
     * @param bool $includeNull = false
     * @return array
     */
    public function toArray($includeNull = false)
    {

        $properties = get_object_vars($this);
        $array = array();
        foreach ($properties as $prop => $value)
        {
            $value = $this->{$prop};
            if ($value !== null || $includeNull === true)
                $array[$prop] = $value;
        }
        return $array;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setByArray(array $data)
    {
        foreach ($data as $key => $val)
        {
            $set = 'set'.implode(
                '',
                array_map(
                    'ucfirst',
                    explode(
                        '_',
                        strtolower($key)
                    )
                )
            );
            if (method_exists($this, $set))
                $this->{$set}($val);
        }
        return $this;
    }
}