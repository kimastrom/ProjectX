<?php
class CommentController
{
    private $mDbHandler = NULL;

    public function __construct()
    {
        $this->mDbHandler = new DbHandler();
    }

    public function doControll()
    {
        $xhtml = "";
        $commentHandler = new CommentHandler($this->mDbHandler);
        $commentView = new CommentView();

        if ($commentView->triesToEditComment()) {
            $xhtml .= $commentView->editComment($commentHandler->GetCommentToEditByCommentId($commentView->WhichCommentToEdit()));
        } 
        else {
            $xhtml .= $commentView->doCommentForm();
        }
        
        if ($commentView->triedToSubmitComment()) {
            $text = $commentView->getCommentText();
            $author = $commentView->getAuthorId();
            $id = $commentView->whichSnippetToComment();
            $commentHandler->addComment($id, $text, $author);
            //Det vill inte fungera med captcha??? why??
//            if ($commentView->getCaptchaAnswer() == $_SESSION['security_number']) 
//            {
//                $commentHandler->addComment($id, $text, $author);
//            }
        }
        
        /**
         *sedan får man kolla med rättigheter så att man kan ta bort en kommentar, antingen är man:
         *-admin
         *-author
         *-kommentaren har fått många(hur måånga?) röster ner
         */
        if ($commentView->triesToRemoveComment()) {
            $commentHandler->deleteComment($commentView->whichCommentToDelete());
        }

        if ($commentView->triesToUpdateComment()) {
            $commentHandler->updateComment($commentView->whichCommentToEdit(), $commentView->getCommentText());
        }

        $xhtml .= $commentView->showAllCommentsForSnippet($commentHandler->getAllCommentsForSnippet($commentView->whichSnippetToComment()));
        return $xhtml;
    }

}
