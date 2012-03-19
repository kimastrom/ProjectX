<?php

require_once dirname(__file__) . '/../model/AuthHandler.php';
require_once dirname(__FILE__) . '/../model/recaptcha/recaptchalib.php';

class CommentController
{
    private $_dbHandler = NULL;
	private $_privateKey;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
		$this->_privateKey = '6LcjpsoSAAAAAH7uTWckrCZL87jizsHpUQuP-dRy';
    }

    public function doControll()
    {
        $html = "<h2>Comments</h2>";
        $commentHandler = new CommentHandler($this->_dbHandler);
        $commentView = new CommentView();
		$recaptchaAnswer = recaptcha_check_answer ($this->_privateKey, $_SERVER["REMOTE_ADDR"], $commentView->getRecaptchaChallenge(), $commentView->getRecaptchaResponse());

        if (AuthHandler::isLoggedIn()) {
            //add Comment
            if ($commentView->triedToSubmitComment()) {
                //if($recaptchaAnswer->is_valid) {
	                $text = $commentView->getCommentText();
	                $author = AuthHandler::getUser()->getId();
	                $id = $commentView->whichSnippetToComment();
	                
                    $result = $commentHandler->addComment($id, $author, $text);
                    //if($result !== true) {
                    //    echo print_r($result);
                    //}
				//}
            }
            //Delete Comments
            if ($commentView->triesToRemoveComment()) {
                $comment = $commentHandler->getCommentByID($commentView->whichCommentToDelete());
                if ($comment != null) {
                    if ($comment->getUserId() == AuthHandler::getUser()->getId()) {
                        $commentHandler->deleteComment($comment);
                    }
                }
            }

            //Edit Comment
            if ($commentView->triesToUpdateComment()) {
                $comment = $commentHandler->getCommentByID($commentView->whichCommentToEdit());
                if ($comment != null) {
                    if ($comment->getUserId() == AuthHandler::getUser()->getId()) {
                        $comment->setCommentText($commentView->getCommentText());
                        $commentHandler->updateComment($comment);
                    }
                }
            }
            //Get content of comment and present it in the form
            if ($commentView->triesToEditComment()) {
                $html .= $commentView->editComment($commentHandler->getCommentByID($commentView->WhichCommentToEdit()));
            } else {
                $html .= $commentView->doCommentForm();
            }


            $id = AuthHandler::getUser()->getId();
            $comments = $commentHandler->getComments($commentView->whichSnippetToComment());
            $html .= $commentView->showAllCommentsForSnippet($comments, $id);
            
        } else {
            //Show comments for a snippet
            $comments = $commentHandler->getComments($commentView->whichSnippetToComment());
            $html .= $commentView->showAllCommentsForSnippet($comments);
        }
        return $html;
    }

}
