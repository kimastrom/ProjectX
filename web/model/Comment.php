<?php

class Comment
{
    private $mSnippetId = NULL;
    //private $mCommentDate = NULL;
    private $mCommentId = NULL;
    private $mUserId = NULL;
    private $mCommentText = NULL;
    //private $mCommentUp = NULL;
    //private $mCommentDown = NULL;
	
//	public function __construct($aSnippetId, $aCommentDate, $aCommentId, $aUserId, $aCommentText, $aCommentUp, $aCommentDown) 
//    {
//        $this->mSnippetId = $aSnippetId;
//		$this->mCommentDate = $aCommentDate;
//		$this->mCommentId = $aCommentId;
//        $this->mUserId = $aUserId;
//        $this->mCommentText = $aCommentText;
//        $this->mCommentUp = $aCommentUp;
//        $this->mCommentDown = $aCommentUp;
//        
//	}
    public function __construct($aSnippetId, $aCommentId, $aUserId, $aCommentText) 
    {
        $this->mSnippetId = $aSnippetId;
		$this->mCommentId = $aCommentId;
        $this->mUserId = $aUserId;
        $this->mCommentText = $aCommentText;
        
	}


    public function GetSnippetId() 
    {
        return $this->mSnippetId;
    }
	
	public function GetCommentDate() 
    {
		return $this->mCommentDate;
	}

	public function GetCommentId() 
    {
		return $this->mCommentId;
	}
    
    public function GetUserId()
    {
        return $this->mUserId;         
    }
    public function GetCommentText()
    {
        return $this->mCommentText;
    }
    public function GetCommentUp()
    {
        return $this->mCommentUp;
    }
    public function GetCommentDown()
    {
        return $this->mCommentDown;
    }
}
