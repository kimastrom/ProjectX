<?php
require_once dirname(__FILE__) . '/../view/SearchView.php';

class SearchController
{
    private $_searchView;
    private $_snippetView;
    private $_html;
    
    public function __construct() {
        $this->_searchView = new SearchView();
        $this->_html = '';
    }

    public function doControll() {

        $this->_html .= $this->_searchView->doSearchForm();
        
        return $this->_html;
    }
}
