<?php

class User
{
    private $mUserId = null;
    private $mUserName = null;

    private $_id;
    private $_name;
    private $_username;
    private $_email;

    /**
     * User::__construct()
     *
     * @return new User object
     */
    public function __construct($id, $name, $username, $email)
    {
        $this->_id = $id;
        $this->_name = $name;
        $this->_username = $username;
        $this->_email = $email;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getEmail()
    {
        return $this->_email;
    }

}
