<?php
require_once dirname(__FILE__).'/../model/SnippetHandler.php';
require_once dirname(__FILE__).'/../view/SnippetView.php';
require_once dirname(__FILE__).'/../model/CommentHandler.php';
require_once dirname(__FILE__).'/../view/CommentView.php';
class MasterController {
    
    private $mSnippetHandler;
    private $mSnippetView;
    private $mCommentHandler;
    private $mCommentView;
    private $mHtml;
    
    
    public function __construct() {
        $this->mSnippetHandler = new SnippetHandler();
        $this->mSnippetView = new SnippetView();
        $this->mCommentHandler = new CommentHandler();
        $this->mCommentView = new CommentView();
        $this->mHtml = '';
    }
    
    public function doControll() {
        
        //user tries to add a comment for a single snippet
        if($this->mCommentView->triedToSubmitComment()) {
            $this->mCommentHandler->addComment($this->mCommentView->whichSnippetToComment(),$this->mCommentView->getCommentText(),$this->mCommentView->getAuthorId());
        }
        
        //user or admin tries to remove his own snippet (we will know that he has right to do it in a future)
        if($this->mCommentView->triesToRemoveComment()) {
            $this->mCommentHandler->deleteComment($this->mCommentView->whichCommentToDelete());
        }
            
/**
 *         den delen får jag inte att fungera på rätt sätt
 */
//        if($this->mCommentView->triesToUpdateComment())
//        {
//            $this->mCommentHandler->updateComment($this->mCommentView->whichCommentToEdit(), $this->mCommentView->getCommentText());
//        }
        
        if(isset($_GET['snippet'])) {
            $this->mHtml .= $this->mSnippetView->singleView($this->mSnippetHandler->getSnippetByID($_GET['snippet']));
            $this->mHtml .= $this->mCommentView->doCommentForm();
            $this->mHtml .= $this->mCommentView->showAllComments($this->mCommentHandler->getAllCommentsForSnippet($this->mCommentView->whichSnippetToComment()));
        } else {
            $this->mHtml = $this->mSnippetView->listView($this->mSnippetHandler->getAllSnippets());
        }

        $this->mHtml .= "<br /><a href='index.php'>Till startsidan</a>";
        
        return $this->mHtml;
    }
    
}

