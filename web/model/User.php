<?php

class User
{
    private $_userID = null;
    private $_userName = null;

    /**
     * User::__construct()
     *
     * @return new User object
     */
    public function __construct( $userID, $userName )
    {
        $this->_userID = $userID;
        $this->_userName = $userName;
    }

    /**
     * User::getUserID()
     *
     * @return int, id of the user
     */
    public function getUserID()
    {
        return $this->_userId;
    }

    /**
     * User::getUserName()
     *
     * @return string, name of the user
     */
    public function getUserName()
    {
        return $this->_userName;
    }

}