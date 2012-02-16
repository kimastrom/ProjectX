<?php
require_once 'MailView.php';
class MailController
{
    private $_mailView;
    private $_html;
    
    public function __construct() {
        $this->_mailView = new MailView();
        $this->_html = '';
    }

    public function doControll() {
            
        $this->_html .= $this->_mailView->mailView();
        return $this->_html;
    }
}
