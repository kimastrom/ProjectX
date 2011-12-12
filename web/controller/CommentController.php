<?php
class CommentController
{
    private $_dbHandler = NULL;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
    }

    public function doControll()
    {
        $html = "";
        $commentHandler = new CommentHandler($this->_dbHandler);
        $commentView = new CommentView();

        if ($commentView->triesToEditComment()) {
            $html .= $commentView->editComment($commentHandler->getCommentByID($commentView->WhichCommentToEdit()));
        } else {
            $html .= $commentView->doCommentForm();
        }

        if ($commentView->triedToSubmitComment()) {
            $text = $commentView->getCommentText();
            $author = $commentView->getAuthorId();
            $id = $commentView->whichSnippetToComment();
            $commentHandler->addComment($id, $text, $author);
            if ($commentView->getCaptchaAnswer() == $_SESSION['security_number']) {
                $commentHandler->addComment($id, $text, $author);
            }
        }

        if ($commentView->triesToRemoveComment()) {
            $commentHandler->deleteComment($commentView->whichCommentToDelete());
        }

        if ($commentView->triesToUpdateComment()) {
            $commentHandler->updateComment($commentView->whichCommentToEdit(), $commentView->getCommentText());
        }

        $html .= $commentView->showAllCommentsForSnippet($commentHandler->getAllCommentsForSnippet($commentView->whichSnippetToComment()));
        return $html;
    }

}
