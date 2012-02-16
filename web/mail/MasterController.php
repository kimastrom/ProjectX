<?php
require_once 'MailController.php';
class MasterController
{
    private $_mailController;
    private $_html;

    public function __construct()
    {
        session_start();
        $this->_mailController = new MailController();
        $this->_html = '';
    }

    public function doControll()
    {
        if (isset($_GET['page'])) 
        {
            if ($_GET['page'] == 'mail') {
                $this->_mailController = new MailController();
                $this->_html .= $this->_mailController->doControll();
            } 
        }
        return $this->_html;
    }
}
