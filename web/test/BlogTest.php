<?php

require_once dirname(__FILE__) . '/simpletest/autorun.php';
require_once dirname(__FILE__) . '/../model/Blogpost.php';

class BlogTest extends UnitTestCase
{
    private $_blogId;
    private $_title;
    private $_content;
    private $_date_posted;
    private $_userId;
    private $_author;
    private $_read_more;
    private $_blogpost;
    private $_correct_date;

    public function __construct()
    {
        $this->_blogId = 1;
        $this->_title = "En title";
        $this->_content = "Lite meningslöst content";
        $this->_date_posted = "0000-00-00 00:00:00";
        $this->_correct_date = "0000-00-00";
        $this->_userId = 3;
        $this->_read_more = "Lite meningslöst content";
        
        $this->_blogpost = new Blogpost($this->_blogId, $this->_title, $this->_content, $this->_date_posted, $this->_userId);
    }

    public function testGetId()
    {
        $this->assertEqual($this->_blogId, $this->_blogpost->getId());
    }
    
    public function testGetTitle()
    {
        $this->assertEqual($this->_title, $this->_blogpost->getTitle());    
    }        
    
    public function testGetContent()
    {
        $this->assertEqual($this->_content, $this->_blogpost->getContent());
    }
    
    public function testGetDate()
    {
        $this->assertEqual($this->_correct_date, $this->_blogpost->getDate());
    }
    
    public function testGetReadMoreContent()
    {
        $this->assertEqual($this->_read_more, $this->_blogpost->getReadMoreContent());    
    }
}
