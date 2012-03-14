<?php
// 
//  SnippetModel.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once 'RequestObject.php';

class SnippetModel
{

    private $_dbHandler;
    private $_requestObject;
	
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_requestObject = new RequestObject();
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

    public function getSnippet($request)
    {
        foreach ($request as $action => $value) {
            if (is_array($this->_requestObject->__isset('_' . $action))) {
                return $this->_requestObject->__isset('_' . $action);
            } else {
                $this->_requestObject->__set('_' . $action, $value);
            }
        }

        $snippets = array();
        $select = $this->_requestObject->select();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement($select[0])) {
            if ($select[1] != '') {
            	//DEPRECATED 5.3.0 <
            	//call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt, $select[1]), $select[2]));
                
            	call_user_func_array(array($stmt, 'bind_param'), $this->refValues(array_merge(array( $select[1]), $select[2])));    
            }
            $stmt->execute();

            $stmt->bind_result($id, $userId, $code, $title, $description, $languageId, $date, $updated, $userId, $name, $username, $apikey, $role_id, $languageid, $language, $thumbsup, $thumbsdown);
            while ($stmt->fetch()) {
                $snippet = array('language' => $language, 'languageid' => $languageid, 'title' =>
                    $title, 'description' => $description, 'code' => $code, 'username' => $username, 'userid' => $userId,
                    'id' => $id, 'date' => $date, 'updated' => $updated, 'thumbsup' => $thumbsup, 'thumbsdown' => $thumbsdown);
                array_push($snippets, $snippet);
            }

            $stmt->close();
        }
        $this->_dbHandler->close();

        if (count($snippets) > 0) {
            return $snippets;
        } else {
            throw new RestException(204);
        }
    }
    private function validateUser($userId, $apikey)
    {
        $this->_dbHandler->__wakeup();
        $databaseQuery = $this->_dbHandler->PrepareStatement("SELECT apikey FROM user WHERE userId = ? AND apikey = ?");
        $databaseQuery->bind_param('ss', $userId, $apikey);
        $databaseQuery->execute();
        while ($databaseQuery->fetch()) {
            return true;
        }
        $databaseQuery->close();
        return false;
    }

    public function createSnippet(SnippetObject $snippet)
    {
        $this->_dbHandler->__wakeup();

        $code = $snippet->__get('_code');
        $title = $snippet->__get('_title');
        $desc = $snippet->__get('_desc');
        $languageid = $snippet->__get('_languageid');
        $id = $snippet->__get('_id');
        $userid = $snippet->__get('_userid');
        $apikey = $snippet->__get('_apikey');
		$date = $snippet->__get('_date');
		$updated = $snippet->__get('_updated');

        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("INSERT INTO snippet (userId, code, title, description, languageId, date, updated) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
                $databaseQuery->bind_param('sssssss', $userid, $code, $title, $desc, $languageid, $date, $updated);
                $databaseQuery->execute();
				$id = $databaseQuery->insert_id;
                if ($databaseQuery->affected_rows == null) {
                    $databaseQuery->close();
                    return array('status' => false);
                }
                $databaseQuery->close();
            } else {
                return array('status' => false);
            }	
            $this->_dbHandler->close();
			
			//Uppdatera indexet
			$this->updateIndex($snippet, $id);
			
			
			return array('status' => true, 'id' => $id);
        } else {
            throw new RestException(401);
        }
    }

    public function updateSnippet(SnippetObject $snippet)
    {
        $this->_dbHandler->__wakeup();

        $id = $snippet->__get('_id');
        $code = $snippet->__get('_code');
        $title = $snippet->__get('_title');
        $desc = $snippet->__get('_desc');
        $languageid = $snippet->__get('_languageid');
        $userid = $snippet->__get('_userid');
        $apikey = $snippet->__get('_apikey');

        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("UPDATE snippet SET userId = ?, code= ?, title= ?, description= ?, languageId= ? WHERE id = ? AND userId = ?")) {
                $databaseQuery->bind_param('sssssss', $userid, $code, $title, $desc, $languageid,
                    $id, $userid);
                $databaseQuery->execute();
                if ($databaseQuery->affected_rows == null) {
                    $databaseQuery->close();
                    return array('status' => false);
                }
                $databaseQuery->close();
            } else {
                return array('status' => false);
            }

			$this->_dbHandler->close();
			$this->deleteIndex($id);
			$this->updateIndex($snippet, $id);
			
			return array('status' => true);
        } else {
            throw new RestException(401);
        }
    }

    public function deleteSnippet(SnippetObject $snippet)
    {
        $this->_dbHandler->__wakeup();

        $id = $snippet->__get('_id');
        $userid = $snippet->__get('_userid');
        $apikey = $snippet->__get('_apikey');

        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("DELETE FROM snippet WHERE id = ? AND userId = ?")) {
                $databaseQuery->bind_param('ss', $id, $userid);
                $databaseQuery->execute();
                if ($databaseQuery->affected_rows == null) {
                    $databaseQuery->close();
                    return array('status' => false);
                }
                $databaseQuery->close();
            } else {
                return array('status' => false);
            }

            $this->_dbHandler->close();
			$this->deleteIndex($id);
            return array('status' => true);
        } else {
            throw new RestException(401);
        }
    }
	
	public function updateIndex($snippet, $snippetid)
    {
		// create index
		$index = Zend_Search_Lucene::open(APPLICATION_PATH . '/indexes');
		Zend_Search_Lucene_Analysis_Analyzer::setDefault( 
			new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive() 
		); 
		
        
		$doc = new Zend_Search_Lucene_Document();
		// Store document URL to identify it in search result.
		$doc->addField(Zend_Search_Lucene_Field::text('snippetid', $snippetid));
		$doc->addField(Zend_Search_Lucene_Field::text('title', $snippet->__get('_title')));
		$doc->addField(Zend_Search_Lucene_Field::text('description', $snippet->__get('_desc')));
		$doc->addField(Zend_Search_Lucene_Field::text('code', $snippet->__get('_code')));
		$doc->addField(Zend_Search_Lucene_Field::text('language', $snippet->__get('_language')));
		 
		// Add document to the index.
		$index->addDocument($doc);
		$index->optimize();
    }
	
	public function deleteIndex($snippetid)
    {
		$index = Zend_Search_Lucene::open(APPLICATION_PATH . '/indexes');

		$snippetId = $index->TermDocs(new Zend_Search_Lucene_Index_Term($snippetid, 'snippetid')); 
		foreach ($snippetId as $deleteId) { 
			$index->delete($deleteId); 
		}
		$index->optimize();
    }
}
