<?php
require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../model/DbHandler.php';
require_once dirname(__FILE__) . '/../view/SearchView.php';
require_once dirname(__FILE__) . '/../model/LanguageHandler.php';
class SearchController
{
    private $_dbHandler;
    private $_snippetHandler;
    private $_langHandler;
    private $_searchView;
    private $_snippetView;
    private $_html;
    
    public function __construct() {
        $this->_dbHandler = new DbHandler();
        $this->_snippetHandler = new SnippetHandler($this->_dbHandler);
        $this->_langHandler = new LanguageHandler($this->_dbHandler);
        $this->_searchView = new SearchView();
        $this->_snippetView = new SnippetView();
        $this->_pagingHandler = new PagingHandler($this->_snippetHandler->getAllSnippets(), 1, 3);
        $this->_html = '';
    }

    public function doControll() {

        $this->_html = $this->_searchView->doSearchForm($this->_langHandler->getAllLang());

        if($this->_searchView->doSearch()) {
            $searchQuery = $this->_searchView->getSearchQuery();
            $lang = $this->_searchView->getSearchLang();
            //För pageningen
            $arrToPreventError = array(1,1,1,1,1);
            
            //makes a full serch for description, code and titel, user must choose a lang or PHP as dafault
            $this->_html .= $this->_searchView->searchAnswerView($this->_snippetHandler->fullSearchWithLang($searchQuery, $lang),1,$arrToPreventError,1,false,false);  
        }
        return $this->_html;
    }
}
