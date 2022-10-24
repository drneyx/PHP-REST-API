<?php

class Factory
{
    private  array $dict;

    public function __construct(array $objectList) {
        $this->dict = $objectList;
    }

    public function getRules($params) {
        if (array_key_exists("type", $params)) {
            return $this->dict[$params["type"]]::listRules();
        }

        return false;
    }

    /* Check if product type exist */
    public function factProduct($params)
    {
        if (array_key_exists("type", $params)) {
            return new $this->dict[$params["type"]]($params);
        }

        return false;
    }

}