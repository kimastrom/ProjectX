<?php
// 
//  build.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
// 

// =============================================
// = This file handles the building of indexes, 
//	use this only once and then remove it from server =
// =============================================
set_include_path(APPLICATION_PATH . '/helpers');
require_once 'Zend/Search/Lucene.php';
require_once APPLICATION_PATH . '/models/SnippetModel.php';

class Build
{
	private $_snippetModel;
    private $_snippets = array();

    public function __construct()
    {
        $this->_snippetModel = new SnippetModel();
    }
	
    public function index()
    {
		set_time_limit(10000);
		// create indexes
        $index = Zend_Search_Lucene::create(APPLICATION_PATH . '/indexes');
		Zend_Search_Lucene_Analysis_Analyzer::setDefault( 
			new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive()
		); 
        
		// fetch all of the current pages
        $snippets = $this->_snippetModel->getSnippet($_REQUEST);
		
        if (count($snippets) > 0) { // create a new search document for each page
		
			$doc = new Zend_Search_Lucene_Document();
		
            foreach ($snippets as $key=>$value) {
				//add fields
				$doc->addField(Zend_Search_Lucene_Field::text('snippetid', $value['id']));
                $doc->addField(Zend_Search_Lucene_Field::text('title', $value['title']));
				$doc->addField(Zend_Search_Lucene_Field::text('description', $value['description']));
				$doc->addField(Zend_Search_Lucene_Field::text('code', $value['code']));
				$doc->addField(Zend_Search_Lucene_Field::text('language', $value['language']));
                // add the document to the index
				$index->addDocument($doc);
            }
			
			
        }
        // optimize the index
        $index->optimize();
        // pass the view data for reporting
        return $index->numDocs();
    }
}
