<?php
/**
 * 
 */
class CommentController  
{
    private $m_database = NULL;
    
    public function __construct(DatabaseConnection $database)
    {
      $this->m_database = $database;
    }
	
	
	public function DoControll()
    {
        $xhtml = "";
        
        $commentHandler = new CommentHandler($this->m_database);
        $commentView = new CommentView();
        
        if($commentView->TriesToEditComment())
        {
            $xhtml .= $commentView->EditComment($commentHandler->GetCommentToEditByCommentId($commentView->WhichCommentToEdit()));
        }
        else
        {
            $xhtml .= $commentView->DoCommentForm();
        }
        
        if($commentView->TriedToSubmitComment() == true)
        {
			//Denna if-sats är tillagd för att kontrollera Captcha-svaret
			if($commentView->GetCaptchaAnswer() == $_SESSION['security_number']) {
			   //adderar inlägget till databasen, filtruje ev. html taggar+RealEscapeString innan jag sparar i db
			   $text = $commentView->GetCommentText();
			   $text = $this->m_database->RealEscapeString($text);
			   $author = $commentView->GetAuthorId();
			   $author = $this->m_database->RealEscapeString($author);
				/**
				* hårdkodade värden på snippetId
				*/
				$commentHandler->AddComment(1, $text, $author);
		   }        
        }
/**
*          sedan får man kolla med rättigheter så att man kan ta bort en kommentar, antingen är man:
*           -admin
*           -author
*           -kommentaren har fått många(hur måånga?) röster ner
*/      
        if($commentView->TriesToRemoveComment())
        {
            $commentHandler->DeleteComment($commentView->WhichCommentToDelete());
        }
        
        if($commentView->TriesToUpdateComment())
        {
            $commentHandler->UpdateComment($commentView->WhichCommentToEdit(),$commentView->GetCommentText());
        }
        
        $xhtml .= $commentView->ShowAllComments($commentHandler->GetAllCommentsForSnippet($commentView->WhichSnippetToComment()));
        //$xhtml .= $commentView->ShowAllComments($commentHandler->GetAllComments());
        return $xhtml;
    }
	
}
