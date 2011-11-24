<?php
class Auth {
    var $user_id;
    var $username;
    var $password;
    var $ok;
    var $salt = "34asdf34";
    var $domain = ".domain.com";
    function Auth() {
        global $db;
        $this->user_id = 0;
        $this->username = "Guest";
        $this->ok = false;
        if (!$this->check_session()) $this->check_cookie();
        return $this->ok;
    }
    function check_session() {
        if (!empty($_SESSION['auth_username']) && !empty($_SESSION['auth_password'])) return $this->check($_SESSION['auth_username'], $_SESSION['auth_password']);
        else return false;
    }
    function check_cookie() {
        if (!empty($_COOKIE['auth_username']) && !empty($_COOKIE['auth_password'])) return $this->check($_COOKIE['auth_username'], $_COOKIE['auth_password']);
        else return false;
    }
    function login($username, $password) {
        global $db;
        $db->query("SELECT user_id FROM users WHERE username = '$username' AND password = '$password'");
        if (mysql_num_rows($db->result) == 1) {
            $this->user_id = mysql_result($db->result, 0, 0);
            $this->username = $username;
            $this->ok = true;
            $_SESSION['auth_username'] = $username;
            $_SESSION['auth_password'] = md5($password . $this->salt);
            setcookie("auth_username", $username, time() + 60 * 60 * 24 * 30, "/", $this->domain);
            setcookie("auth_password", md5($password . $this->salt), time() + 60 * 60 * 24 * 30, "/", $this->domain);
            return true;
        }
        return false;
    }
    function check($username, $password) {
        global $db;
        $db->query("SELECT user_id, password FROM users WHERE username = '$username'");
        if (mysql_num_rows($db->result) == 1) {
            $db_password = mysql_result($db->result, 0, 1);
            if (md5($db_password . $this->salt) == $password) {
                $this->user_id = mysql_result($db->result, 0, 0);
                $this->username = $username;
                $this->ok = true;
                return true;
            }
        }
        return false;
    }
    function logout() {
        $this->user_id = 0;
        $this->username = "Guest";
        $this->ok = false;
        $_SESSION['auth_username'] = "";
        $_SESSION['auth_password'] = "";
        setcookie("auth_username", "", time() - 3600, "/", $this->domain);
        setcookie("auth_password", "", time() - 3600, "/", $this->domain);
    }
}
?>