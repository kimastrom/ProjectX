<?php
require_once dirname(__FILE__) . '/simpletest/autorun.php';
require_once dirname(__FILE__) . '/../model/PagingHandler.php';
require_once dirname(__FILE__) . '/../model/SnippetHandler.php';

class PagingHandlerTest extends unitTestcase
{
    private $_snippets;
    private $_page;
    private $_limit;
    private $_pagingHandler;
    private $_totalSnippets;
    private $_totalPages;
    private $_expectedSnippets = array("test1", "test2", "test3");
    private $_expectedLinks = array(1, 2);
    
    function __construct()
    {
        $this->_snippets = array("test1", "test2", "test3", "test4", "test5", "test6");
        $this->_page = 1;
        $this->_limit = 3;
        
        $this->_totalSnippets = count ($this->_snippets);
        $this->_totalPages = $this->_totalSnippets / $this->_limit;
        
        $this->_pagingHandler = new PagingHandler($this->_snippets, $this->_page, $this->_limit);
    }
    
    public function testGetTotal () {
       
        $this->assertEqual($this->_totalPages, $this->_pagingHandler->getTotal());
    }
    
    public function testGetPrevious () {
        
        $this->assertEqual(0, $this->_pagingHandler->getPrevious());
    }
    
    public function testGetNext () {
        
        $this->assertEqual(2, $this->_pagingHandler->getNext());
    }
}