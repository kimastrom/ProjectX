<?php

class AuthConfig
{
    private $_application_domain = 'https://snippt.rpxnow.com/';
    private $_app_id = 'llnbdnldlhddkbhjnial';
    private $_api_key = '0e3ba63b5f60b6998d5f77257683d1d444e6781d';
    private $_engage_pro = false;
    
    public function getAppId() {
        return $this->_app_id;
    }
    
    public function getAppDomain() {
        return $this->_application_domain;
    }
    
    public function getApiKey() {
        return $this->_api_key;
    }
    
    public function isPro() {
        return $this->_engage_pro;
    }
}

$application_domain = 'https://snippt.rpxnow.com/';
$app_id = 'llnbdnldlhddkbhjnial';
$api_key = '0e3ba63b5f60b6998d5f77257683d1d444e6781d';
/**
 * Set $engage_pro to false for this demo.
 */
$engage_pro = false;
