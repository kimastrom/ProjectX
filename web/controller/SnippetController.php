<?php

require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../view/SnippetView.php';
require_once dirname(__FILE__) . '/../model/DbHandler.php';
require_once dirname(__FILE__) . '/../controller/CommentController.php';
require_once dirname(__FILE__) . '/../model/CommentHandler.php';
require_once dirname(__FILE__) . '/../view/CommentView.php';

class SnippetController
{
    private $_dbHandler;
    private $_snippetHandler;
    private $_snippetView;
    private $_html;
    private $_commentController;

    public function __construct()
    {

        $this->_dbHandler = new DbHandler();
        $this->_snippetHandler = new SnippetHandler($this->_dbHandler);
        $this->_snippetView = new SnippetView();
        $this->_commentController = new CommentController($this->_dbHandler);
        $this->_html = '';
    }

    public function doControll($page)
    {
        if ($page == 'list') {
            if (isset($_GET['snippet'])) {
    
                $this->_html .= $this->_snippetView->singleView($this->_snippetHandler->getSnippetByID($_GET['snippet']));
                $this->_html .= $this->_commentController->doControll();
            } else {
    
                $this->_html .= $this->_snippetView->listView($this->_snippetHandler->getAllSnippets());
            }
        } else if ($page == 'add') {

            $this->_html = null;
            $this->_html .= $this->_snippetView->createSnippet($this->_snippetHandler->getLanguages());

            if ($this->_snippetView->triedToCreateSnippet()) {

                $snippet = new Snippet('kimsan', $this->_snippetView->getCreateSnippetCode(), $this->_snippetView->getSnippetTitle(), $this->_snippetView->getSnippetDescription(), $this->_snippetView->getSnippetLanguage());
                $this->_snippetHandler->createSnippet($snippet);
            }
        }

        return $this->_html;
    }

}
