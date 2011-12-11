<?php

class Snippet
{
    private $mSnippetId;
    private $mUserId;
    private $mCode;
    private $mTitle;
    private $mDesc;
    private $mSnippetLang;

    public function __construct( $aSnippetId, $aUserId, $aCode, $aTitle, $aDesc, $aSnippetLang )
    {
        $this->mSnippetId = $aSnippetId;
        $this->mUserId = $aUserId;
        $this->mCode = $aCode;
        $this->mTitle = $aTitle;
        $this->mDesc = $aDesc;
        $this->mSnippetLang = $aSnippetLang;
    }

    /**
     * @return int ID of the snippet
     */
    public function getSnippetId()
    {
        return $this->mSnippetId;
    }
    
    public function setUser($aUserId)
    {
        $this->mUserId = $aUserId;
    }
    
    /**
     * @return String The author of the snippet
     */
    public function getUser()
    {
        return $this->mUserId;
    }

    /**
     * @return String The code snippet
     */
    public function getSnippetCode()
    {
        return $this->mCode;
    }

    /**
     * @return String title of the snippet
     */
    public function getSnippetTitle()
    {
        return $this->mTitle;
    }

    /*
     * @return String description of the snippet
     */
    public function getSnippetDesc()
    {
        return $this->mDesc;
    }

    /*
     * @return String language of the snippet
     */
    public function getSnippetLanguage()
    {
        return $this->mSnippetLang;
    }

}
