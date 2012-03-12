<?php
// 
//  CommentObject.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

class CommentObject
{
	private $_commentid;
    private $_snippetid;
    private $_userid;
    private $_comment;
    private $_apikey;
    private $_date;
   

    public function __construct()
    {
    	$this->_commentid = null;
        $this->_snippetid = null;
        $this->_userid = null;
        $this->_comment = null;
        $this->_apikey = null;
        $this->_date = date("Y-m-d h:i:s");
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
