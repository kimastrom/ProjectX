<?php

/**
 * SnippetObject
 * 
 * @category projectX
 * @package  ProjectX
 * @author   Pontus <bopontuskarlsson@hotmail.com>
 * @author   Tomas <tompen@telia.com>
 * @copyright 2012
 * @version $Id$
 * @access public
 */
class SnippetObject
{
    private $_username;
    private $_date;
    private $_sort;
    private $_language;
    private $_datefrom;
    private $_dateto;
    private $_code;
    private $_title;
    private $_rating;
    private $_id;
    private $_description;

    /**
     * SnippetObject::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        $this->_username = null;
        $this->_date = null;
        $this->_sort = null;
        $this->_language = null;
        $this->_datefrom = null;
        $this->_dateto = null;
        $this->_code = null;
        $this->_title = null;
        $this->_rating = null;
        $this->_id = null;
        $this->_description = null;
    }

    /**
     * SnippetObject::__get()
     * 
     * @param mixed $property
     * @return
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            return array('error' => $property . ' is not a valid action!');
        }
    }

    /**
     * SnippetObject::__set()
     * 
     * @param mixed $property
     * @param mixed $value
     * @return
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;

        } else {
            return array('error' => $property . ' is not a valid action!');
        }
        return $this;
    }

    /**
     * SnippetObject::__isset()
     * 
     * @param mixed $property
     * @return
     */
    public function __isset($property)
    {
        if (property_exists($this, $property)) {
            return isset($this->$property);
        } else {
            return array('error' => $property . ' is not a valid action!');
        }
    }

    /**
     * SnippetObject::select()
     * 
     * @return
     */
    public function select()
    {
        $select = "SELECT * FROM snippet LEFT JOIN rating ON snippet.id = rating.snippetId 
					INNER JOIN user ON snippet.userId = user.userId 
        			INNER JOIN snippet_language ON snippet.languageId = snippet_language.id";
        $type = '';
        $paramvalue = array();

        $first = true;
        $datefrom = false;
        $dateto = false;
        $sort = false;

        foreach ($this as $key => $value) {
            if ($value != null) {
                if ($key != '_datefrom' && $key != '_dateto' && $key != '_sort') {
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
        }
        return array($select, $type, $paramvalue);
    }
}
