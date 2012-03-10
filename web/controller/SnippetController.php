<?php

require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../view/SnippetView.php';
require_once dirname(__FILE__) . '/../model/DbHandler.php';
require_once dirname(__FILE__) . '/../controller/CommentController.php';
require_once dirname(__FILE__) . '/../model/CommentHandler.php';
require_once dirname(__FILE__) . '/../view/CommentView.php';
require_once dirname(__FILE__) . '/../model/AuthHandler.php';

class SnippetController
{
    private $_dbHandler;
    private $_snippetHandler;
    private $_snippetView;
    private $_html;
    private $_commentController;
    private $_pagingHandler;

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
            // Show single snippet
            if (isset($_GET['snippet'])) {
                //Check if snippet exist
                if($snippet = $this->_snippetHandler->getSnippetByID($_GET['snippet'])) {
                    $this->_html .= $this->_snippetView->singleView($snippet);
                    if(AuthHandler::isLoggedIn()) {
                        $this->_html .= $this->_snippetView->rateSnippet($_GET['snippet'], AuthHandler::getUser()->getId(), $this->_snippetHandler->getSnippetRating($_GET['snippet']));  
                    }
                    $this->_html .= $this->_commentController->doControll();
                } else {
                    return false;
                }
            }
        } else if ($page == 'add') {
            if (AuthHandler::isLoggedIn()) {
                $this->_html = null;
                $this->_html .= $this->_snippetView->createSnippet($this->_snippetHandler->getLanguages());
    
                if ($this->_snippetView->triedToCreateSnippet()) {
                    $authID = AuthHandler::getUser()->getID();
                    $snippet = new Snippet(2, $authID, $this->_snippetView->getCreateSnippetCode(), $this->_snippetView->getSnippetTitle(), $this->_snippetView->getSnippetDescription(), $this->_snippetView->getSnippetLanguage(), $this->_snippetHandler->SetDate(), $this->_snippetHandler->SetDate());
                    if($id = $this->_snippetHandler->createSnippet($snippet)){
                        header("Location: " . $_SERVER['PHP_SELF'] . "?page=listsnippets&snippet=" . $id);
                        exit();
                    } else {
                        return false;
                    }
                }
            } else {
                $this->_html = "<p>You must sign in to add a snippet.</p>";
            }
        } else if ($page == 'update') {
            $this->_html = null;
            $this->_html .= $this->_snippetView->updateSnippet($this->_snippetHandler->getSnippetByID($_GET['snippet']));
            
            if ($this->_snippetView->triedToUpdateSnippet()) {
                $this->_snippetHandler->updateSnippet($this->_snippetView->getUpdateSnippetName(), $this->_snippetView->getUpdateSnippetCode(), $this->_snippetView->getUpdateSnippetDesc(), $_GET['snippet'], $this->_snippetHandler->SetDate());
                $_GET['page'] = 'listsnippets';
                header("Location: " . $_SERVER['PHP_SELF'] . "?page=listsnippets&snippet=" . $_GET['snippet']);
                exit();
            }
        } else if ($page == 'remove') {
            $this->_snippetHandler->deleteSnippet($this->_snippetHandler->getSnippetByID($_GET['snippet']));
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        return $this->_html;
    }

}