<?php

require_once dirname(__FILE__) . '/../model/AuthHandler.php';
require_once dirname(__FILE__) . '/../model/GravatarHandler.php';
require_once dirname(__FILE__) . '/../view/HeaderView.php';

class HeaderController
{
    private $_headerView;
    private $_gravatarHandler;
    private $_html;

    public function __construct()
    {
        $this->_headerView = new HeaderView();
        $this->_gravatarHandler = new GravatarHandler();
        $this->_html = '';
    }

    public function doControll()
    {
        $user = AuthHandler::getUser();
        $userPic = '';
        if ($user != null) {
            if($user->getEmail() != 'null') {
                $userPic = $this->_gravatarHandler->getTopGravatar($user->getEmail());
            } else {
                $userPic = $this->_gravatarHandler->getTopGravatar();
            }
            $this->_html = $this->_headerView->inloggedHeader($user->getName(),$userPic,$user->getEmail());  
        } else {
            $this->_html = $this->_headerView->notLoggedInHeader();
        }
        
        return $this->_html;
    }
}
