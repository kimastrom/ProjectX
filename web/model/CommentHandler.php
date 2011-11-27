<?php
require_once 'DbHandler.php';
require_once 'Comment.php';

class CommentHandler
{
	//modelen praatr med db
//    private $m_database = NULL;
//    
//	public function __construct(DatabaseConnection $database) 
//    {
//		$this->m_database = $database;
//	}
	private $mDbHandler;
	
	public function __construct() {
		$this->mDbHandler = new DbHandler();
	}
    
    public function getAllComments()
    {
        $commentsArray = array();
        $this->mDbHandler->__wakeup();
        
        if($stmt = $this->mDbHandler->PrepareStatement("SELECT snippetId, commentId, commentText, userId FROM comment"))
        {
            $stmt->execute();
            $stmt->bind_result($snippetId,$commentId,$commentText,$userId);
            
            $i = 0;
            
            while($stmt->fetch())
            {
                $commentsArray[$i]['names'] = array();
                $commentsArray[$i]['snippetId'] = $snippetId;
                $commentsArray[$i]['commentId'] = $commentId;
                $commentsArray[$i]['commentText'] = $commentText;
                $commentsArray[$i]['userId'] = $userId;
                $i++;
            }
            $stmt->close();
            
            $commentCount = count($commentsArray);
            
            for($i = 0; $i < $commentCount; $i++)
            {
                $userId = $commentsArray[$i]['userId'];
                $statement = $this->mDbHandler->PrepareStatement("SELECT userName FROM user WHERE userId = ?");
                $statement->bind_param('i', $userId);
                $statement->execute();
                $statement->bind_result($userName);
                
                while($statement->fetch())
                {
                    $commentsArray[$i]['names'][] = $userName;
                }
                $statement->close();
            }
        }
        $this->mDbHandler->Close();
        return $commentsArray;
    }
    
    public function getAllCommentsForSnippet($snippetId)
    {
        $commentsArray = array();
        $stmt = $this->mDbHandler->PrepareStatement("SELECT snippetId, commentId, commentText, userId FROM comment WHERE snippetId = $snippetId");
        $stmt->execute();
        $stmt->bind_result($snippetId,$commentId,$commentText,$userId);
        
        $i = 0;
        
        while($stmt->fetch())
        {
            $commentsArray[$i]['names'] = array();
            $commentsArray[$i]['snippetId'] = $snippetId;
            $commentsArray[$i]['commentId'] = $commentId;
            $commentsArray[$i]['commentText'] = $commentText;
            $commentsArray[$i]['userId'] = $userId;

            $i++;
        }
        $stmt->close();
        $commentCount = count($commentsArray);
        
        for($i = 0; $i < $commentCount; $i++)
        {
            $userId = $commentsArray[$i]['userId'];
            $statement = $this->mDbHandler->PrepareStatement("SELECT userName FROM user WHERE userId = ?");
            $statement->bind_param('i', $userId);
            $statement->execute();
            $statement->bind_result($userName);
            
            while($statement->fetch())
            {
                $commentsArray[$i]['names'][] = $userName;
            }
            $statement->close();
        }
        return $commentsArray;
    }
    
    public function addComment($snippetId, $commentText, $userId)
    {
        if($stmt = $this->mDbHandler->PrepareStatement("INSERT INTO comment (snippetId, commentText, userId) VALUES(?,?,?)"))
		{
            $stmt->bind_param("isi", $snippetId,$commentText, $userId);
  			$stmt->execute();
  			$stmt->close();
            return true;
		}
        else
        {
            return false;
        }
    }
    
    public function updateComment($commentId, $commentText)
    {
        //använder RealEscapeString för att säkerhetsställa data
        $commentText = $this->mDbHandler->RealEscapeString($commentText);
        
        $SqlStatement = "UPDATE comment SET commentText=? WHERE commentId=?";
       
        if ($stmt = $this->m_database->PrepareStatement($SqlStatement))
        {              
            $stmt->bind_param("si", $commentText, $commentId);
           
            if ($stmt->execute())
            {
                    $stmt->close();
                    return true;
            }
        }
        return false;
    }
    
    public function deleteComment($commentId)
    {
        $sqlStatement = "DELETE FROM comment WHERE commentId=?";

        if ($stmt = $this->mDbHandler->PrepareStatement($sqlStatement))
        {      
            $stmt->bind_param("i", $commentId);

            if ($stmt->execute())
            {
                return true;    
                $stmt->close();
            }
        }
        return false;
    }
    
    public function removeAllComments()
    {
        $sqlStatement = "DELETE FROM comment";

        if ($stmt = $this->mDbHandler->PrepareStatement($sqlStatement))
        {
            $stmt->execute();
            $stmt->close();
        }
    }

    public function GetCommentToEditByCommentId($commentId)
    {
        $commentsArray = array();
        $stmt = $this->m_database->PrepareStatement("SELECT snippetId, commentId, commentText, userId FROM comment WHERE commentId = $commentId");
        $stmt->execute();
        $stmt->bind_result($snippetId,$commentId,$commentText,$userId);
        
        $i = 0;
        
        while($stmt->fetch())
        {
            $commentsArray[$i]['names'] = array();
            
            $commentsArray[$i]['snippetId'] = $snippetId;
            $commentsArray[$i]['commentId'] = $commentId;
            $commentsArray[$i]['commentText'] = $commentText;
            $commentsArray[$i]['userId'] = $userId;

            $i++;
        }
        $stmt->close();
        
        $commentCount = count($commentsArray);
        
        for($i = 0; $i < $commentCount; $i++)
        {
            $userId = $commentsArray[$i]['userId'];
            $statement = $this->m_database->PrepareStatement("SELECT userName FROM user WHERE userId = ?");
            $statement->bind_param('i', $userId);
            $statement->execute();
            $statement->bind_result($userName);
            
            while($statement->fetch())
            {
                $commentsArray[$i]['names'][] = $userName;
            }
            $statement->close();
        }
        return $commentsArray;
    }
}
