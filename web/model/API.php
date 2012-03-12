<?php

class API
{
    private $_url = "";

    public function __construct()
    {
        $this->_url = "http://tmpn.se/api/";
    }

    /**
     * return API url
     * @return string
     */
    public function GetURL()
    {
        return $this->_url;
    }
}