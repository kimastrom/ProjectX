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
        $this->_html = '';
    }

    public function doControll()
    {
        session_start();
        if (isset($_GET['page'])) {
            if ($_GET['page'] == 'listsnippets') {
                $this->_snippetController = new SnippetController();
                $this->_html .= $this->_snippetController->doControll('list');
            }
            else if ($_GET['page'] == 'addsnippet') {
                $this->_snippetController = new SnippetController();
                $this->_html .= $this->_snippetController->doControll('add');
            }
        } else {
            $this->_html = '<div class="search">
                <img src="content/image/logo.png" />
                <input type="text" />
                <input type="submit" value="Search" class="searchbutton" /><br />
                
                <a href="#">Advanced search</a> &bull; <a href="#">Browse</a>
            </div>';
        }
        
        return $this->_html;
    }

}
