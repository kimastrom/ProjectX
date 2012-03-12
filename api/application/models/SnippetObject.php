<?php
// 
//  SnippetObject.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

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
	private $_updated;

    public function __construct()
    {
		$datetime = date("Y-m-d h:i:s");
        $this->_id = null;
        $this->_userid = null;
        $this->_code = null;
        $this->_title = null;
        $this->_desc = null;
        $this->_languageid = null;
        $this->_apikey = null;
        $this->_date = $datetime;
		$this->_updated = $datetime;
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
