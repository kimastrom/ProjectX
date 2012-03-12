<?php
// 
//  LanguageModel.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once 'RequestObjectLanguage.php';


class LanguageModel
{
    private $_dbHandler;
    private $_requestObjectLanguage;
	
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_requestObjectLanguage = new RequestObjectLanguage();
    }
    private function refValues($arr){
        if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+
        {
            $refs = array();
            foreach($arr as $key => $value)
                $refs[$key] = &$arr[$key];
            return $refs;
        }
        return $arr;
    }
    public function getLanguage($request)
    {
        foreach ($request as $action => $value) {
            if (is_array($this->_requestObjectLanguage->__isset('_' . $action))) {
                return $this->_requestObjectLanguage->__isset('_' . $action);
            } else {
                $this->_requestObjectLanguage->__set('_' . $action, $value);
            }
        }

        $languages = array();
        $select = $this->_requestObjectLanguage->select();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement($select[0])) {
            if ($select[1] != '') {
                call_user_func_array(array($stmt, 'bind_param'), $this->refValues(array_merge(array( $select[1]), $select[2])));     
            }
            $stmt->execute();

            $stmt->bind_result($languageId, $language);
            while ($stmt->fetch()) {
                $language = array('languageId' => $languageId, 'language' => $language);
                array_push($languages, $language);
            }

            $stmt->close();
        }
        $this->_dbHandler->close();

        if (count($languages) > 0) {
            return $languages;
        } else {
            throw new RestException(204);
        }
    }
}
