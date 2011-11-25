<?php

    require_once dirname(__FILE__) . '/../model/SnippetHandler.php';

    class SnippetHandlerTest extends unitTestcase {
    	
    	private $mSnippetHandler;
    	
    	function __construct() {
    		$this->mSnippetHandler = new SnippetHandler();
    	}
    	
    	public function testIfGetSnippetByIDreturnObject()
    	{
    		$snippet = $this->mSnippetHandler->getSnippetByID(1);
    		$this->assertTrue(is_object($snippet));
    	}
    	
    }