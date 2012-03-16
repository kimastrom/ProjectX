<?php
require_once dirname(__FILE__) . '/../view/DownloadView.php';

class DownloadController
{
    private $_downloadView;
    private $_html;
    
    public function __construct() {
        $this->_downloadView = new DownloadView();
        $this->_html = '';
    }

    public function doControll() {

        $this->_html .= $this->_downloadView->doDownloadLinks();
        
        return $this->_html;
    }
}
