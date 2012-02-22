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
			$this->build();
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
				//var_dump(json_encode($this->_snippets));
			}
            return $this->_snippets;
	}
	
	public function update()
    {
		// create indexes
        $index = Zend_Search_Lucene::open(APPLICATION_PATH . '/indexes');
        
		$hits = $index->find('id:'.$id);
		  foreach ($hits as $hit) {
			 $index->delete($hit->id);
		  }

		// fetch all of the current pages
        $snippets = $this->_snippetModel->getSnippet($_REQUEST);
		
        if (count($snippets) > 0) { // create a new search document for each page
            foreach ($snippets as $key=>$value) {
				$doc = new Zend_Search_Lucene_Document();
                // you use an unindexed field for the id because you want the id
                // to be included in the search results but not searchable
                //$doc->addField(Zend_Search_Lucene_Field::unIndexed('id', $value['id']));
                // you use text fields here because you want the content to be searchable
                // and to be returned in search results
				$doc->addField(Zend_Search_Lucene_Field::text('snippetid', $value['id']));
                $doc->addField(Zend_Search_Lucene_Field::text('title', $value['title']));
				$doc->addField(Zend_Search_Lucene_Field::text('description', $value['description']));
				$doc->addField(Zend_Search_Lucene_Field::text('code', $value['code']));
                // add the document to the index
                $index->addDocument($doc);
            }
        }
        // optimize the index
        $index->optimize();
        // pass the view data for reporting
        //return $index->numDocs();
    }
	
    public function build()
    {
		// create indexes
        $index = Zend_Search_Lucene::create(APPLICATION_PATH . '/indexes');
        
		// fetch all of the current pages
        $snippets = $this->_snippetModel->getSnippet($_REQUEST);
		//var_dump($snippets);
		
        if (count($snippets) > 0) { // create a new search document for each page
            foreach ($snippets as $key=>$value) {
				$doc = new Zend_Search_Lucene_Document();
                // you use an unindexed field for the id because you want the id
                // to be included in the search results but not searchable
                //$doc->addField(Zend_Search_Lucene_Field::unIndexed('id', $value['id']));
                // you use text fields here because you want the content to be searchable
                // and to be returned in search results
				$doc->addField(Zend_Search_Lucene_Field::text('snippetid', $value['id']));
                $doc->addField(Zend_Search_Lucene_Field::text('title', $value['title']));
				$doc->addField(Zend_Search_Lucene_Field::text('description', $value['description']));
				$doc->addField(Zend_Search_Lucene_Field::text('code', $value['code']));
                // add the document to the index
                $index->addDocument($doc);
            }
        }
        // optimize the index
        $index->optimize();
        // pass the view data for reporting
        //return $index->numDocs();
    }
}
