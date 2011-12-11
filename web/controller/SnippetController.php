<?php
require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../view/SnippetView.php';
require_once dirname(__FILE__) . '/../model/DbHandler.php';
require_once dirname(__FILE__) . '/../controller/CommentController.php';
require_once dirname(__FILE__) . '/../model/CommentHandler.php';
require_once dirname(__FILE__) . '/../view/CommentView.php';

class SnippetController
{
    private $mDbHandler;
    private $mSnippetHandler;
    private $mSnippetView;
    private $mHtml;
    private $mCommentController;

    public function __construct(){
        
        $this->mDbHandler = new DbHandler();
        $this->mSnippetHandler = new SnippetHandler($this->mDbHandler);
        $this->mSnippetView = new SnippetView();
        $this->mCommentController = new CommentController($this->mDbHandler);
        $this->mHtml = '';
    }
    public function doControll() {
        
        if (isset($_GET['snippet'])) {
            
            $this->mHtml .= $this->mSnippetView->singleView($this->mSnippetHandler->getSnippetById($this->mSnippetView->getSnippetId()));
            $this->mHtml .= "<br /><a href='index.php'>Till startsidan</a><br /><br />";
            $this->mHtml .= $this->mCommentController->doControll();
        }
        else{
            
            $this->mHtml .= $this->mSnippetView->listView($this->mSnippetHandler->getAllSnippets());
        }
        
        if(isset($_GET['ctrl']) && $_GET['ctrl'] == 'createNewSnippetView') {
          
          $this->mHtml = null;
          $this->mHtml .= $this->mSnippetView->addSnippet();
          $this->mHtml .= "<br /><a href='index.php'>Till startsidan</a><br />";
        }
        
        if($this->mSnippetView->triedToSubmitSnippet()) {
            
            $snippetAuthor = $this->mSnippetView->getAuthorId();
            $snippetCode = $this->mSnippetView->getSnippetCode();
            $snippetTitle = $this->mSnippetView->getSnippetTitle();
            $snippetDesc = $this->mSnippetView->getSnippetDesc();
            $snippetLanguage = $this->mSnippetView->getSnippetLanguage();
            
            if($this->mSnippetHandler->addSnippet($snippetAuthor, $snippetCode, $snippetTitle, $snippetDesc, $snippetLanguage)) {
                
                header('Location: index.php');
            }
        }
        
        if($this->mSnippetView->triesToRemoveSnippet()) {
            $this->mSnippetHandler->deleteSnippet($this->mSnippetView->getSnippetId());
        }
        
        if(isset($_GET['snippet']) && isset($_GET['deleteSnippet'])) {
            
            header('Location: index.php');
        }
 
        return $this->mHtml;
    }
}