<?php

require_once dirname(__file__) . '/../model/AuthHandler.php';

class CommentController
{
    private $_dbHandler = NULL;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
    }

    public function doControll()
    {
        $html = "<h2>Comments</h2>";
        $commentHandler = new CommentHandler($this->_dbHandler);
        $commentView = new CommentView();

        if (AuthHandler::isLoggedIn()) {
            if ($commentView->triedToSubmitComment()) {
                $text = $commentView->getCommentText();
                $author = AuthHandler::getUser()->getId();
                $id = $commentView->whichSnippetToComment();

                if ($commentView->getCaptchaAnswer() == $_SESSION['security_number']) {
                    $commentHandler->addComment($id, $author, $text, AuthHandler::getApiKey());
                }
            }

            //Delete Comments
            if ($commentView->triesToRemoveComment()) {
                $comment = $commentHandler->getCommentByID($commentView->whichCommentToDelete());
                if ($comment != null) {
                    if ($comment->getUserId() == AuthHandler::getUser()->getId()) {
                        $commentHandler->deleteComment($commentView->whichCommentToDelete());
                    }
                }
            }

            //Edit Comment
            if ($commentView->triesToUpdateComment()) {
                $comment = $commentHandler->getCommentByID($commentView->whichCommentToEdit());
                if ($comment != null) {
                    if ($comment->getUserId() == AuthHandler::getUser()->getId()) {
                        $comment = $commentHandler->getCommentByID($commentView->whichCommentToDelete());
                        $commentHandler->updateComment($commentView->whichCommentToEdit(), $commentView->getCommentText());
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
            $comments = $commentHandler->getAllCommentsForSnippet($commentView->whichSnippetToComment());
            $html .= $commentView->showAllCommentsForSnippet($comments, $id);
        } else {
            $html .= $commentView->showAllCommentsForSnippet($commentHandler->getAllCommentsForSnippet($commentView->whichSnippetToComment()));
        }
        return $html;
    }

}
