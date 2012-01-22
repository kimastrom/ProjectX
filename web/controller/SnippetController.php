<?php

require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../view/SnippetView.php';
require_once dirname(__FILE__) . '/../model/DbHandler.php';
require_once dirname(__FILE__) . '/../controller/CommentController.php';
require_once dirname(__FILE__) . '/../model/CommentHandler.php';
require_once dirname(__FILE__) . '/../view/CommentView.php';
require_once dirname(__FILE__) . '/../model/PagingHandler.php';

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
        $this->_pagingHandler = new PagingHandler($this->_snippetHandler->getAllSnippets(), 1, 3);
        $this->_html = '';
    }

    public function doControll($page)
    {
        if ($page == 'list') {
            if (isset($_GET['snippet'])) {
                $this->_html .= $this->_snippetView->singleView($this->_snippetHandler->getSnippetByID($_GET['snippet']));
                $this->_html .= $this->_snippetView->rateSnippet($_GET['snippet'], $this->_snippetHandler->getSnippetRating($_GET['snippet']));
                $this->_html .= $this->_commentController->doControll();
            } else {
                if (isset($_GET['pagenumber']) == false || $_GET['pagenumber'] < 1) {        
                    $_GET['pagenumber'] = 1;
                } else {
                    $this->_pagingHandler->setPage($_GET['pagenumber']);
                }
                
                $this->_pagingHandler->setOffset($_GET['pagenumber']);
                
                if ($_GET['pagenumber'] - 1 == 0) {
                    $this->_html .= $this->_snippetView->listView($this->_pagingHandler->fetchSnippets(), 1,$this->_pagingHandler->getLinks(), $this->_pagingHandler->getBeforeLinks(), $this->_pagingHandler->getAfterLinks(),  $this->_pagingHandler->getNext(), false, true);
                } else if ($_GET['pagenumber'] == $this->_pagingHandler->getTotal()) {
                    $this->_html .= $this->_snippetView->listView($this->_pagingHandler->fetchSnippets(), $this->_pagingHandler->getPrevious(),$this->_pagingHandler->getLinks(), $this->_pagingHandler->getBeforeLinks(), $this->_pagingHandler->getAfterLinks(), $this->_pagingHandler->getTotal(), true, false);    
                } else {
                    $this->_html .= $this->_snippetView->listView($this->_pagingHandler->fetchSnippets(), $this->_pagingHandler->getPrevious(),$this->_pagingHandler->getLinks(), $this->_pagingHandler->getBeforeLinks(), $this->_pagingHandler->getAfterLinks(), $this->_pagingHandler->getNext(), true, true);    
                }
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
