<?php

set_include_path(APPLICATION_PATH . '/helpers');
require_once 'Zend/Search/Lucene.php';
require_once APPLICATION_PATH . '/models/SnippetModel.php';

class Search
{
	private $_snippetModel;
    private $_snippets = array();

    public function __construct()
    {
        $this->_snippetModel = new SnippetModel();
    }
    public function index($keywords){
			if(strpos($keywords, '*') && strlen($keywords) <= 3){
				 return array('error' => 'You must specify at least three characters in a wildcard search.');
			}
            Zend_Search_Lucene::setResultSetLimit('50');
			$query = Zend_Search_Lucene_Search_QueryParser::parse($keywords);
            $index = Zend_Search_Lucene::open(APPLICATION_PATH . '/indexes');
            $hits = $index->find($query);
			foreach ($hits as $result) { 
                $snippet = $this->_snippetModel->getSnippet(
                    array("id" => $result->snippetid)
                );	
                array_push($this->_snippets, $snippet[0]);
			}
            return $this->_snippets;
	}
}