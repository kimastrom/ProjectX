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
        $this->_html = '';
    }

    public function doControll() {

        
        if($this->_searchView->wantsAdvSearch()) {
            
            $this->_html .= $this->_searchView->doAdvSearchForm($this->_langHandler->getAllLang());
        }
        else {
            $this->_html .= $this->_searchView->doSearchForm();
        }
    
        if($this->_searchView->doSearch()) {
            $searchQuery = $this->_searchView->getSearchQuery();
            //För pageningen
            $arrToPreventError = array(1, 1, 1, 1, 1);
            $this->_html .= $this->_searchView->searchAnswerView($this->_snippetHandler->fullSearch($searchQuery), 1, $arrToPreventError, 1, false, false);  
        }
        
        if($this->_searchView->doAdvSearch()) {
            $searchQuery = $this->_searchView->getSearchQuery();
            $lang = $this->_searchView->getSearchLang();
            //För pageningen
            $arrToPreventError = array(1, 1, 1, 1, 1);
            $this->_html .= $this->_searchView->searchAnswerView($this->_snippetHandler->fullSearchWithLang($searchQuery, $lang), 1, $arrToPreventError, 1, false, false);  
        }
        
        
        return $this->_html;
    }
}
