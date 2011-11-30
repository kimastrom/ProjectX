<?php
	require_once dirname(__FILE__) . '/simpletest/autorun.php';
	
	/**
	 * 
	 */
	class AllTests extends TestSuite {
		function __construct() {
        	parent::__construct();
            $this->addFile( dirname(__FILE__) . '/snippetHandlerTest.php' );
            $this->addFile( dirname(__FILE__) . '/TestCRUDSnippet.php' );
		}
	}
	
	