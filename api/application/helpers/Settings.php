<?php

// 
//  Settings.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

class Settings
{
    private $m_dbname = "";
    private $m_password = "";
    private $m_host = "";
    private $m_username = "";

    
    public function __construct()
    {
        $this->m_dbname = "projectx";
        $this->m_host = "localhost";
        $this->m_username = "root";
        $this->m_password = "";
    }
  
    public function GetDbName()
    {
        return $this->m_dbname;
    }

    public function GetPassword()
    {
        return $this->m_password;
    }

    public function GetHost()
    {
        return $this->m_host;
    }

    public function GetUsername()
    {
        return $this->m_username;
    }

}
