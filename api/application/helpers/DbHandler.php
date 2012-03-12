<?php

// 
//  DbHandler.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

require_once 'Settings.php';

class DbHandler
{
    private $mMySqliObject = null;
    private $mSettings = null;

    public function __construct()
    {
        $this->connect();
    }

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

    public function __wakeup()
    {
        $this->connect();
    }

    public function close()
    {
        $this->mMySqliObject->Close();
    }

    public function prepareStatement($aSqlStatement)
    {
        return $this->mMySqliObject->prepare($aSqlStatement);
    }

    public function error()
    {
        return $this->mMySqliObject->error;
    }

}
