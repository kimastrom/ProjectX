<?php
// 
//  CommentModel.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once 'RequestObjectComment.php';

class CommentModel
{
    private $_dbHandler;
    private $_requestObjectComment;
	
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_requestObjectComment = new RequestObjectComment();
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
    public function getComment($request)
    {
        foreach ($request as $action => $value) {
            if (is_array($this->_requestObjectComment->__isset('_' . $action))) {
                return $this->_requestObjectComment->__isset('_' . $action);
            } else {
                $this->_requestObjectComment->__set('_' . $action, $value);
            }
        }

        $comments = array();
        $select = $this->_requestObjectComment->select();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement($select[0])) {
            if ($select[1] != '') {    
                call_user_func_array(array($stmt, 'bind_param'), $this->refValues(array_merge(array( $select[1]), $select[2])));     
            }
            $stmt->execute();

            $stmt->bind_result($commentId, $snippetId, $userId, $comment, $comment_created_date, $username, $apikey, $title);
            while ($stmt->fetch()) {
                $comment = array('commentId' => $commentId, 'snippetId' => $snippetId, 'title' => $title, 'userId' =>
                    $userId, 'comment' => $comment, 'comment_created_date' => $comment_created_date, 'username' => $username);
                array_push($comments, $comment);
            }

            $stmt->close();
        }
        $this->_dbHandler->close();

        if (count($comments) > 0) {
            return $comments;
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
    
    private function validateSnippetOwner($userId, $snippetid)
    {
        $this->_dbHandler->__wakeup();
        $databaseQuery = $this->_dbHandler->PrepareStatement("SELECT userId FROM snippet WHERE id = ?");
        $databaseQuery->bind_param('s', $snippetid);
        $databaseQuery->execute();
        $databaseQuery->bind_result($snippetUserId);
        
        while ($databaseQuery->fetch()) {
            if ($snippetUserId != $userId) {
            	return true;
            }
        }
        $databaseQuery->close();
        return false;
    }

    public function createComment(CommentObject $comment)
    {
        $this->_dbHandler->__wakeup();
        
        //var_dump($comment);
		
        $snippetid = $comment->__get('_snippetid');
        $userid = $comment->__get('_userid');
        $apikey = $comment->__get('_apikey');
        $comment = $comment->__get('_comment');


        if ($this->validateUser($userid, $apikey) && $this->validateSnippetOwner($userid, $snippetid)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("INSERT INTO comment (snippetId, userId, comment) VALUES (?, ?, ?)")) {
                $databaseQuery->bind_param('sss', $snippetid, $userid, $comment);
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
			
			
			return array('status' => true, 'id' => $id);
        } else {
            throw new RestException(401);
        }
    }

    public function updateComment(CommentObject $comment)
    {
        $this->_dbHandler->__wakeup();

		$commentid = $comment->__get('_commentid');
        $snippetid = $comment->__get('_snippetid');
        $userid = $comment->__get('_userid');
        $apikey = $comment->__get('_apikey');
        $comment = $comment->__get('_comment');


        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("UPDATE comment SET comment= ? WHERE commentId = ? AND userId = ?")) {
                $databaseQuery->bind_param('sss', $comment, $commentid, $userid);
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
			
			return array('status' => true);
        } else {
            throw new RestException(401);
        }
    }

    public function deleteComment(CommentObject $comment)
    {
        $this->_dbHandler->__wakeup();

        $commentid = $comment->__get('_commentid');
        $userid = $comment->__get('_userid');
        $apikey = $comment->__get('_apikey');

        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("DELETE FROM comment WHERE commentId = ? AND userId = ?")) {
                $databaseQuery->bind_param('ss', $commentid, $userid);
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
            
            return array('status' => true);
        } else {
            throw new RestException(401);
        }
    }
}
