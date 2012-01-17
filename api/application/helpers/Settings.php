<?php

/**
 * Settings
 * 
 * @package ProjectX 
 * @author ProjectX
 * @copyright ProjectX
 * @version 2012
 * @access public
 */
class Settings
{
    private $m_dbname = "";
    private $m_password = "";
    private $m_host = "";
    private $m_username = "";

    /**
     * Settings::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        $this->m_dbname = "projectx";
        $this->m_host = "localhost";
        $this->m_username = "root";
        $this->m_password = "";
    }

    /**
     * Settings::GetDbName()
     * 
     * @return
     */
    public function GetDbName()
    {
        return $this->m_dbname;
    }

    /**
     * Settings::GetPassword()
     * 
     * @return
     */
    public function GetPassword()
    {
        return $this->m_password;
    }

    /**
     * Settings::GetHost()
     * 
     * @return
     */
    public function GetHost()
    {
        return $this->m_host;
    }

    /**
     * Settings::GetUsername()
     * 
     * @return
     */
    public function GetUsername()
    {
        return $this->m_username;
    }

}
