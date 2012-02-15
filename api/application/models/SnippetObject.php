<?php

class SnippetObject
{
    private $_id;
    private $_userid;
    private $_code;
    private $_title;
    private $_desc;
    private $_languageid;
    private $_apikey;
    private $_date;

    public function __construct()
    {
        $this->_id = null;
        $this->_userid = null;
        $this->_code = null;
        $this->_title = null;
        $this->_desc = null;
        $this->_languageid = null;
        $this->_apikey = null;
        $this->_date = date("Y-m-d");
    }
    
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            return array('error' => $property . ' property do not exist');
        }
    }
    
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;

        } else {
            return array('error' => $value . ' property do not exist');
        }
        return $this;
    }
    
    public function __isset($property)
    {
        if (property_exists($this, $property)) {
            return isset($this->$property);
        } else {
            return array('error' => $property . ' property do not exist');
        }
    }
}
