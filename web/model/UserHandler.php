<?php

class UserHandler
{
    private $mDbHandler;
    public function __construct()
    {
        $this->mDbHandler = new DbHandler();
    }

    /**
     * UserHandler::getAllUsers()
     *
     * @return an array with User objects
     */
    public function getAllUsers()
    {

        $userArray = array();
        $result = array();

        if ($stmt = $this->$mDbHandler->PrepareStatement("SELECT userId, userName FROM user")) {
            $stmt->execute();
            $stmt->bind_result($result[0], $result[1]);
            while ($stmt->fetch()) {
                $resultObject = new User($result[0], $result[1]);
                $userArray[] = $resultObject;
            }
            $stmt->close();
        }
        return $userArray;
    }

}
