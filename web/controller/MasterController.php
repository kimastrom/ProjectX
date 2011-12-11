<?php
require_once dirname(__FILE__) . '/../model/SnippetHandler.php';
require_once dirname(__FILE__) . '/../view/SnippetView.php';
require_once dirname(__FILE__) . '/SnippetController.php';

class MasterController
{
    private $mSnippetController;
    private $mHtml;
    
    private $mSnippethandler;
    
    public function __construct()
    {
        $this->mSnippetController = new SnippetController();
        $this->mHtml = '';
        
        $this->mSnippethandler = new SnippetHandler();
    }
    //I Master Controllen ska bara andra controller istanseras som behövs vis starten av applikationen
    //alla andra controllers instanseras senare vid behov
    public function doControll(){
      ob_start();
      
      $this->mHtml .= $this->mSnippetController->doControll();
      
      //$this->mSnippethandler->addComment(1, "gugguy", 7);
      //$this->mSnippethandler->deleteSnippet(15);
      return $this->mHtml;
    }
}