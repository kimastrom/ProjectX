<?php

class User
{
    private $mUserId = NULL;
    private $mUserName = NULL;
	
	public function __construct($aUserId, $aUserName) 
    {
        $this->mUserId = $aUserId;
        $this->mUserName = $aUserName;
	}

    public function GetUserId() 
    {
        return $this->mUserId;
    }
	
	public function GetUserName() 
    {
		return $this->mUserName;
	}
}
