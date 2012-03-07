<?php

require_once dirname(__FILE__) . '/../model/janrain-engage/lib.php';
require_once dirname(__FILE__) . '/../model/janrain-engage/auth.php';
require_once dirname(__FILE__) . '/../model/janrain-engage/config.php';
require_once dirname(__FILE__) . '/../model/UserHandler.php';
require_once dirname(__FILE__) . '/../model/AuthHandler.php';

class AuthController
{
    private $_lib;
    private $_auth;
    private $_conf;
    private $_userHandler;

    function __construct()
    {
        $this->_lib = new lib();
        $this->_auth = new auth($this->_lib);
        $this->_conf = new AuthConfig();
        $this->_userHandler = new UserHandler();
    }

    function checkAuthToken()
    {
        $user = null;
        //Check if a valid token isset
        if (!empty($_POST['token'])) {
            $token = $_POST['token'];
            
            //Get user information from janrain-engage api
            $result = $this->_auth->engage_auth_info($this->_conf->getApiKey(), $token);
            if ($result != false) {
                $result = $this->_lib->engage_parse_result($result);
            }

            //if user exists and the result status == ok
            if ($result['stat'] == 'ok') {
                //get data from result json object
                $name = $result['profile']['name']['formatted'];
                $identifier = $result['profile']['identifier'];
                $provider = $result['profile']['providerName'];
                
                //Twitter accounts doesn't return a email adress
                //Set email to null if provider is Twitter
                if(!empty($result['profile']['email'])) {
                    $email = $result['profile']['email'];
                } else {
                    $email = null;
                }
                
                //If provider is Twitter, check user database against
                //account identifier instead of email
                if ($result['profile']['providerName'] == 'Twitter') {
                    //if user does not exists in out db, add user
                    if (!$this->_userHandler->twitterExists($identifier)) {
                        $this->_userHandler->addUser($identifier, $provider, $name);
                    }
                    $user = $this->_userHandler->getUserByIdentifier($identifier);
                } else {
                    //If user not exist, add users
                    if (!$this->_userHandler->doesUserExist($email)) {
                        $this->_userHandler->addUser($identifier, $provider, $name, $email);
                    } else if(!$this->_userHandler->getUserByIdentifier($identifier)) {
                        //Add user_auth info if user exists with andother provider
                        $user = $this->_userHandler->getUserByEmail($email);
                        $this->_userHandler->ExtendUser($email, $provider, $identifier, $user->getId());
                    }
                    
                    if($user == null) {
                        $user = $this->_userHandler->getUserByEmail($email);
                    }
                    
                }
                AuthHandler::login($user);

            } else {
                Log::siteError('login failed, unknown user or serverproblem');
                return false;
            }
        } else {
            Log::siteError('login failed, token not set');
        }
        
        header('location: /');
    }

}
