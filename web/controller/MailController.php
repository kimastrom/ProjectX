<?php
require_once dirname(__FILE__) . '/../view/MailView.php';
require_once dirname(__FILE__) . '/../view/SnippetView.php';
require_once dirname(__FILE__) . '/../model/MailHandler.php';
class MailController
{
    private $_mailView;
    private $_snippetView;
    private $_mailHandler;
    private $_html;
    
    public function __construct() {
        $this->_mailView = new MailView();
        $this->_snippetView = new SnippetView();
        $this->_mailHandler = new MailHandler();
        $this->_html = '';
    }

    public function doControll() {
            
        //$this->_html .= $this->_mailView->mailView();
        
        if($this->_snippetView->sendByMail()) {
            
            //$mail = $this->_mailView->getMail();
//            $subject = $this->_mailView->getSubject();
//            $text = $this->_mailView->getText();
//            
//            if($this->_mailHandler->sendMail($mail, $subject, $text))
//            {
//                $this->_html .= "SUCCESSS!!!!";
//            }
//            else
//            {
//                $this->_html .= "DUPA BLADA!!!";
//            }
            mail('martajohnsson@gmail.com', 'subject', 'message från doControll i mail controllen');
            
            //$this->_html .= "WANT TO SEND FUCKING MAIL!!!!";
        }
//        $mail = $_POST['mail'];
//        $subject = $_POST['subject'];
//        $text = $_POST['text'];

        //mail('martajohnsson@gmail.com', 'subject', 'message från mail controllen');
        //mail($mail, $subject, $text);
        //$this->_html .= "WANT TO SEND FUCKING MAIL!!!!";
        return $this->_html;
    }
}
