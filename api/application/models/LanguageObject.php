<?php
// 
//  LanguageObject.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

class LanguageObject
{
	private $_languageid;
    private $_language;

    public function __construct()
    {
    	$this->_languageid = null;
        $this->_language = null;
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
