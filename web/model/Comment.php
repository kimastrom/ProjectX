<?php

class Comment
{

    private $_snippetId;
    private $_commentId;
    private $_userId;
    private $_commentText;
    private $_user;
    private $_getCommentUp;
    private $_getCommentDown;
    private $_commentDate;
    private $_username;
    private $_created;

    /**
     * Comment::__construct()
     *
     * @param int $aSnippetId
     * @param int $aCommentId
     * @param int $aUserId
     * @param int $aCommentText
     */
    public function __construct($snippetId, $commentId, $userId, $commentText, $commentDate)
    {
        $this->_snippetId = $snippetId;
        $this->_commentId = $commentId;
        $this->_userId = $userId;
        $this->_commentText = $commentText;
        $this->_commentDate = $commentDate;
    }

    /**
     * Comment::setUser()
     * settr User object
     * @param User
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * Comment::setUsername()
     * String username
     * @param string
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * Comment::getUsername()
     *
     * @return String username
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Comment::getUser()
     *
     * @return User object
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Comment::getSnippetId()
     *
     * @return int ID of the snippet
     */
    public function getSnippetId()
    {
        return $this->_snippetId;
    }

    /**
     * Comment::getCommentDate()
     *
     * @return date when the comment where written
     */
    public function getCommentDate()
    {
        return $this->_commentDate;
    }

    /**
     * Comment::getCommentId()
     *
     * @return int ID of the comment
     */
    public function getCommentId()
    {
        return $this->_commentId;
    }

    /**
     * Comment::getUserId()
     *
     * @return int ID of the user who wrote the comment
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * Comment::getCommentText()
     *
     * @return string; text of the comment
     */
    public function getCommentText()
    {
        return $this->_commentText;
    }

    /**
     * Comment::getCommentUp()
     *
     * @return int, how many finds the comment useful
     */
    public function getCommentUp()
    {
        return $this->_getCommentUp;
    }

    /**
     * Comment::getCommentDown()
     *
     * @return int, how many dosn't' find the comment useful
     */
    public function getCommentDown()
    {
        return $this->_getCommentDown;
    }

}
