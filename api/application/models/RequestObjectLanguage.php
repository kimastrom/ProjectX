<?php
// 
//  RequestObjectLanguage.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

class RequestObjectLanguage
{
    
    private $_language;
    private $_languageid;
    private $_limit;
    private $_page;
    private $_sort;
    private $_desc;
    
    
    public function __construct()
    {
        $this->_language = null;
        $this->_languageid = null;
        $this->_limit = null;
        $this->_page = null;
        $this->_sort = null;
        $this->_desc = null;
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            return array('error' => $property . ' is not a valid action!');
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;

        } else {
            return array('error' => $property . ' is not a valid action!');
        }
        return $this;
    }

    public function __isset($property)
    {
        if (property_exists($this, $property)) {
            return isset($this->$property);
        } else {
            return array('error' => $property . ' is not a valid action!');
        }
    }
    
    //This fuctions is used to create dynamic calls for snippets without the 
    //concern of parameter order. 
    public function select()
    {
        $select = "SELECT * FROM snippet_language";
        $type = '';
        $paramvalue = array();

        $first = true;
        $sort = false;

        foreach ($this as $key => $value) {
            if ($value != null) {
                if ($key != '_sort' && $key != '_desc' && $key != '_page' && $key != '_limit') {				
                	
                	if ($key == '_languageid') {
                		$key = '_snippet_languageid';
                	}
                	
                	if ($first) {
						$select .= ' WHERE ' . substr($key, 1) . ' = ?';
						$first = false;
                    } else {
						$select .= ' AND ' . substr($key, 1) . ' = ?';
					}   
                    $type .= 's';
                    array_push($paramvalue, $value);
                }

                if ($key == '_sort') {
                    $sort = true;
                    $sortvalue = $value;
                }
            }
        }
    
        if ($sort) {
            $select .= ' ORDER BY ' . $sortvalue;
            if ($this->__isset('_desc')) {
                $select .= ' DESC';
            }   
        }
        if ($this->__isset('_limit')) {
            if ($this->__isset('_page')) {
                $select .= ' LIMIT ' . (((int)$this->__get('_page')-1) * (int)$this->__get('_limit')) . ', ' . (int)$this->__get('_limit');
            } else {
                $select .= ' LIMIT ' . (int)$this->__get('_limit');
            }
        }       
        return array($select, $type, $paramvalue);
    }
}
