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

        $this->_html .= $this->_searchView->doSearchForm();
        
        return $this->_html;
    }
}
