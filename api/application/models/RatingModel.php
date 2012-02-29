<?php

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once 'RequestObjectRating.php';


class RatingModel
{
    private $_dbHandler;
    private $_requestObjectRating;
	
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_requestObjectRating = new RequestObjectRating();
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
    public function getRating($request)
    {
        foreach ($request as $action => $value) {
            if (is_array($this->_requestObjectRating->__isset('_' . $action))) {
                return $this->_requestObjectRating->__isset('_' . $action);
            } else {
                $this->_requestObjectRating->__set('_' . $action, $value);
            }
        }

        $ratings = array();
        $select = $this->_requestObjectRating->select();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement($select[0])) {
            if ($select[1] != '') {
                call_user_func_array(array($stmt, 'bind_param'), $this->refValues(array_merge(array( $select[1]), $select[2])));     
            }
            $stmt->execute();

            $stmt->bind_result($ratingId, $snippetId, $userId, $rating, $rating_created_date, $username, $email, $apikey);
            while ($stmt->fetch()) {
                $rating = array('ratingId' => $ratingId, 'snippetId' => $snippetId, 'userId' =>
                    $userId, 'rating' => $rating, 'rating_created_date' => $rating_created_date, 'username' => $username);
                array_push($ratings, $rating);
            }

            $stmt->close();
        }
        $this->_dbHandler->close();

        if (count($ratings) > 0) {
            return $ratings;
        } else {
            throw new RestException(404);
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
        $databaseQuery = $this->_dbHandler->PrepareStatement("SELECT userid FROM snippet WHERE id = ?");
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
    
    private function hasAlreadyBeenRated($userId, $snippetid)
    {
        $this->_dbHandler->__wakeup();
        $databaseQuery = $this->_dbHandler->PrepareStatement("SELECT userid FROM rating WHERE snippetId = ? AND userId = ?");
        $databaseQuery->bind_param('ss', $snippetid, $userId);
        $databaseQuery->execute();
        
        while ($databaseQuery->fetch()) {
            return false;
        }
        $databaseQuery->close();
        return true;
    }

    public function createRating(RatingObject $rating)
    {
        $this->_dbHandler->__wakeup();
		
        $snippetid = $rating->__get('_snippetid');
        $userid = $rating->__get('_userid');
        $apikey = $rating->__get('_apikey');
        $rating = $rating->__get('_rating');


        if ($this->validateUser($userid, $apikey) && $this->validateSnippetOwner($userid, $snippetid) && $this->hasAlreadyBeenRated($userid, $snippetid)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("INSERT INTO rating (snippetid, userid, rating) VALUES (?, ?, ?)")) {
                $databaseQuery->bind_param('sss', $snippetid, $userid, $rating);
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

    public function updateRating(RatingObject $rating)
    {
        $this->_dbHandler->__wakeup();

		$ratingid = $rating->__get('_ratingid');
        $snippetid = $rating->__get('_snippetid');
        $userid = $rating->__get('_userid');
        $apikey = $rating->__get('_apikey');
        $rating = $rating->__get('_rating');


        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("UPDATE rating SET rating= ? WHERE ratingid = ? AND userid = ?")) {
                $databaseQuery->bind_param('sss', $rating, $ratingid, $userid);
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

    public function deleteRating(RatingObject $rating)
    {
       
    	$this->_dbHandler->__wakeup();

        $ratingid = $rating->__get('_ratingtid');
        $apikey = $rating->__get('_apikey');
        $userid = $rating->__get('_userid');
        

        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("DELETE FROM rating WHERE ratingid = ? AND userid = ?")) {
                $databaseQuery->bind_param('ii', $ratingid, $userid);
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
