<?php

require_once 'Settings.php';

/**
 * DbHandler
 * 
 * @package ProjectX  
 * @author ProjectX
 * @copyright ProjectX
 * @version 2012
 * @access public
 */
class DbHandler
{
    private $mMySqliObject = null;
    private $mSettings = null;

    /**
     * DbHandler::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * DbHandler::connect()
     * 
     * @return
     */
    public function connect()
    {
        $this->mSettings = new Settings();
        $this->mMySqliObject = new mysqli($this->mSettings->GetHost(), $this->mSettings->
            GetUsername(), $this->mSettings->GetPassword(), $this->mSettings->GetDbName());

        $this->mMySqliObject->set_charset("utf8");

        if (mysqli_connect_errno()) {
            exit();
            return false;
        }
        return true;
    }

    /**
     * DbHandler::__wakeup()
     * 
     * @return
     */
    public function __wakeup()
    {
        $this->connect();
    }

    /**
     * DbHandler::close()
     * 
     * @return
     */
    public function close()
    {
        $this->mMySqliObject->Close();
    }

    /**
     * DbHandler::prepareStatement()
     * 
     * @param mixed $aSqlStatement
     * @return
     */
    public function prepareStatement($aSqlStatement)
    {
        return $this->mMySqliObject->prepare($aSqlStatement);
    }

    /**
     * DbHandler::error()
     * 
     * @return
     */
    public function error()
    {
        return $this->mMySqliObject->error;
    }

}
