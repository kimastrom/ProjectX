<?php

require_once dirname(__FILE__) . '/../model/DbHandler.php';
require_once dirname(__FILE__) . '/../model/BlogHandler.php';
require_once dirname(__FILE__) . '/../view/BlogView.php';
require_once dirname(__file__) . '/../model/AuthHandler.php';

class BlogController
{
    private $_dbHandler;
    private $_blogHandler;
    private $_blogView;
    private $_html;
    
    
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_blogHandler = new BlogHandler();
        $this->_blogView = new BlogView();
        $this->_html = '';
    }
    
    public function doControll($page)
    {
        if($page == 'list') {
            if (isset($_GET['blogpost'])) {
                $this->_html .= $this->_blogView->singleView($this->_blogHandler->getBlogpostById($_GET['blogpost']));     
            }else {
                $this->_html .= $this->_blogView->listView($this->_blogHandler->getAllBlogposts());
            }  
        }else if($page == 'add') {
            $this->_html .= $this->_blogView->addBlogpost();
            
            if ($this->_blogView->triedToAddBlogpost()) { 
                $this->_blogHandler->addBlogpost($this->_blogView->getBlogpostTitle(), $this->_blogView->getBlogpostContent(), AuthHandler::getUser()->getId());
                header("Location: " . $_SERVER['PHP_SELF'] . "?page=listblogposts");
                exit();
            }
        }else if($page == 'edit') {
            $this->_html = null;
            $this->_html .= $this->_blogView->editBlogpost($this->_blogHandler->getBlogpostById($_GET['blogpost']));
            
            if ($this->_blogView->triedToEditBlogpost()) {
                $this->_blogHandler->editBlogpost($_GET['blogpost'], $this->_blogView->getEditBlogpostTitle(), $this->_blogView->getEditBlogpostContent());
                header("Location: " . $_SERVER['PHP_SELF'] . "?page=listblogposts&blogpost=" . $_GET['blogpost']);
                exit();
            }  
        }else if($page == 'remove') {
            $this->_blogHandler->deleteBlogpost($_GET['blogpost']);
            header("Location: " . $_SERVER['PHP_SELF'] . "?page=listblogposts");
            exit();  
        }
        
        return $this->_html;
    }        
}
