<?php
// 
//  languages.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once APPLICATION_PATH . '/models/LanguageModel.php';
require_once APPLICATION_PATH . '/models/LanguageObject.php';

class Languages
{
    private $_dbHandler;
    private $_languageModel;
    private $_language;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_languageModel = new LanguageModel();
        $this->_language = new LanguageObject();
    }

    public function index($request_data = null)
	{ 	
	 	return $this->_languageModel->getLanguage($request_data);
    }
}
