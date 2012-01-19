<?php

class SessionHandler
{
    private $_cryptKey = 'cRyPtOkEy';

    public function createUserSession($userID)
    {
        $_SESSION['user'] = $this->encrypt($userID);
    }

    public function getUserSession()
    {
        if (isset($_SESSION['user'])) {
            return $this->decrypt($_SESSION['user']);
        } else {
            return false;
        }
    }

    public function destroyUserSession()
    {
        $_SESSION = array();
        session_destroy();
    }

    private function encrypt($text)
    {
        return trim(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->_cryptKey, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    private function decrypt($text)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->_cryptKey, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    } 
}