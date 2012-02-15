<?php

class RequestObject
{
    private $_username;
    private $_date;
    private $_sort;
    private $_language;
    private $_languageid;
    private $_datefrom;
    private $_dateto;
    private $_code;
    private $_title;
    private $_rating;
    private $_id;
    private $_description;
    private $_desc;
    private $_page;
    private $_limit;
    private $_phrase;
    
    public function __construct()
    {
        $this->_username = null;
        $this->_date = null;
        $this->_sort = null;
        $this->_language = null;
        $this->_languageid = null;
        $this->_datefrom = null;
        $this->_dateto = null;
        $this->_code = null;
        $this->_title = null;
        $this->_rating = null;
        $this->_id = null;
        $this->_description = null;
        $this->_desc = null;
        $this->_page = null;
        $this->_limit = null;
        $this->_phrase = null;
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
    
    public function select()
    {
        $select = "SELECT * FROM snippet LEFT JOIN rating ON snippet.id = rating.snippetId 
					INNER JOIN user ON snippet.userId = user.userId 
        			INNER JOIN snippet_language ON snippet.languageId = snippet_language.snippet_languageid";
        $type = '';
        $paramvalue = array();

        $first = true;
        $datefrom = false;
        $dateto = false;
        $sort = false;

        foreach ($this as $key => $value) {
            if ($value != null) {
                if ($key != '_datefrom' && $key != '_dateto' && $key != '_sort' && $key != '_desc' && $key != '_page' && $key != '_limit') {
                    if ($first) {
                        $select .= ' WHERE ' . substr($key, 1) . ' = ?';
                        $first = false;
                    } else {
                        $select .= ' AND ' . substr($key, 1) . ' = ?';
                    }
                    $type .= 's';
                    array_push($paramvalue, $value);
                }

                if ($key == '_datefrom') {
                    $datefrom = true;
                    $datefromvalue = $value;
                }

                if ($key == '_dateto') {
                    $dateto = true;
                    $datetovalue = $value;
                }

                if ($key == '_sort') {
                    $sort = true;
                    $sortvalue = $value;
                }
            }
        }
        
        if ($datefrom && $dateto) {
            if ($first) {
                $select .= ' WHERE snippet.date BETWEEN ? AND ?';
                $first = false;
            } else {
                $select .= ' AND snippet.date BETWEEN ? AND ?';
            }
            $type .= 'ss';
            array_push($paramvalue, $datefromvalue, $datetovalue);
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
