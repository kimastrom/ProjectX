<?php
class CommentView
{
    public function doCommentForm()
    {
        $form = ("
					<form action='' method='POST'>
                        <label for='commentText'>Kommentar: </label><br/> 
                        <textarea name='commentText' rows = '5' cols ='40' maxlength='1500'></textarea>
                        <br/>
                        <label for='author'>Namn:(ange siffran 6 så länge)</label><br/> 
                        <input type='text' name='commentAuthor' value = ''/>                        
                        <br/>
    					<input type='submit' name='submitComment' value='Skriv'/>
					</form>
			    ");
		return $form;
    }
    
    public function showAllComments($comments)
    {
        $message ="";
        if(!empty($comments))
        {
            for($i = 0; $i < count($comments); $i++)
            {   
                $message .= "<div>";
                $message .= "<p>kommentar till snippetId: ".$comments[$i]['snippetId']."</p>";  
				$message .= "<p>komentarens text: ".$comments[$i]['commentText']."</p>";
				//$message .= "<p> userId: ".$comments[$i]['userId']."</p>";
                $message .= "<p> Kommentaren skrivet av: ".$comments[$i]['names'][0]."</p>";
                $message .= "</div>";
                
                $message .= "<a onclick=\"javascript: return confirm('Vill du verkligen ta bort kommentar? [".$comments[$i]['commentId']."]')\" href='index.php?snippet=".$comments[$i]['snippetId']."&controller=commentcontroller&deleteComment=".$comments[$i]['commentId']."'>Radera</a>";
                $message .= "</br>";
                //nästa rad kommer användas vid editering
                //$message .= "<a href='index.php?controller=commentcontroller&editComment=".$comments[$i]['commentId']."'>Redigera</a>";
				$message .= "<hr>";
            }  
        }
        else
        {
            $message .= "<br/>Det finns inga kommentarer för denna snippet.";
        }
        
        return $message;
    }
/**
 * jag får inte den att fungera rätt
 */
//    public function EditComment($comment)
//    {
//        $form = ("
//					<form action='' method='POST'>
//                        <label for='commentText'>Kommentar: </label><br/> 
//                        
//                        <textarea name='commentText' rows ='5' cols ='40' maxlength='1500' value='".$comment[0]['commentText']."'></textarea>
//                        <br/>
//                        <label for='author'>Namn:(man kan ej redigera vem som skrev, det är redan skrivet av någon)</label><br/> 
//                        
//                        <input type='text' name='commentAuthor' readonly='readonly' value = '".$comment."'/>                        
//                        <br/>
//    					<input type='submit' name='updateComment' value='Skriv'/>
//					</form>
//			    ");
//		return $form;
//    }
    public function editComment($comment)
    {
        $mess = "<textarea name='commentText' rows ='5' cols ='40' maxlength='1500' value='".$comment['commentText'][0]."'></textarea>";
        $mess = "DUPA";
        return $mess;
    }

    public function triedToSubmitComment()
    {
        if(isset($_POST['submitComment']))
        {
            return true;
        }
        else return false;
    }

    public function getCommentText()
    {
        if(isset($_POST['commentText']))
        {
            return trim($_POST['commentText']);
        }
        else return false;
    }
    
    public function getAuthorId()
    {
        if(isset($_POST['commentAuthor']))
        {
            return trim($_POST['commentAuthor']);
        }
        else return false;
    }
    
    public function triesToRemoveComment() 
	{
		if (isset($_GET["deleteComment"])) 
		{
			return true;
		}
		return false;
	}
    public function whichCommentToDelete()
	{
		if (isset($_GET["deleteComment"]))
	 	{
			return urldecode($_GET["deleteComment"]);
		}
		return false;
	}
    
    public function triesToEditComment() 
	{
		if (isset($_GET["editComment"])) 
		{
			return true;
		}
		return false;
	}

	public function whichCommentToEdit()
	 {
		if (isset($_GET["editComment"]))
	 	{
			return urldecode($_GET["editComment"]);
		}
		return false;
	}
	
	public function triesToUpdateComment()
	{
		if (isset($_POST["updateComment"]))
		{
			return true;
		}
		return false;
	}
    
    public function whichSnippetToComment()
    {
        if (isset($_GET["snippet"]))
	 	{
			return urldecode($_GET["snippet"]);
		}
		return false;
    }
}
