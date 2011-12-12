<?php
require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../view/SnippetView.php';
require_once dirname(__FILE__) . '/SnippetController.php';

class MasterController
{
    private $_snippetController;
    private $_html;

    public function __construct()
    {
        $this->_snippetController = new SnippetController();
        $this->_html = '';
    }

    public function doControll()
    {
        session_start();
        $this->_html .= $this->_snippetController->doControll();
        $this->_html .= "<br /><a href='index.php'>Till startsidan</a> <br /><a href='?page=addsnippet'>Add snippet</a>";
        return $this->_html;
    }

}
