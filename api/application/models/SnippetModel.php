<?php

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
                call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt, $select[1]),
                    $select[2]));
            }
            $stmt->execute();

            $stmt->bind_result($id, $userId, $code, $title, $description, $languageId, $date, $updated,
                $ratingId, $userId, $snippetId, $rating, $rating_created_date, $userId, $username,
                $email, $apikey, $languageid, $language);
            while ($stmt->fetch()) {
                $snippet = array('language' => $language, 'languageid' => $languageid, 'title' =>
                    $title, 'description' => $description, 'code' => $code, 'username' => $username,
                    'id' => $id, 'date' => $date, 'updated' => $updated, 'rating' => $rating);
                array_push($snippets, $snippet);
            }

            $stmt->close();
        }
        $this->_dbHandler->close();

        if (count($snippets) > 0) {
            return $snippets;
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

        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("INSERT INTO snippet (userid, code, title, description, languageid, date) VALUES (?, ?, ?, ?, ?, ?)")) {
                $databaseQuery->bind_param('ssssss', $userid, $code, $title, $desc, $languageid, $date);
                $databaseQuery->execute();
                if ($databaseQuery->affected_rows == null) {
                    $databaseQuery->close();
                    return false;
                }
                $databaseQuery->close();
            } else {
                return false;
            }

            $this->_dbHandler->close();
            return true;
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
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("UPDATE snippet SET userid = ?, code= ?, title= ?, description= ?, languageid= ? WHERE id = ? AND userid = ?")) {
                $databaseQuery->bind_param('sssssss', $userid, $code, $title, $desc, $languageid,
                    $id, $userid);
                $databaseQuery->execute();
                if ($databaseQuery->affected_rows == null) {
                    $databaseQuery->close();
                    return false;
                }
                $databaseQuery->close();
            } else {
                return false;
            }

            $this->_dbHandler->close();
            return true;
        } else {
            throw new RestException(404);
        }
    }

    public function deleteSnippet(SnippetObject $snippet)
    {
        $this->_dbHandler->__wakeup();

        $id = $snippet->__get('_id');
        $userid = $snippet->__get('_userid');
        $apikey = $snippet->__get('_apikey');

        if ($this->validateUser($userid, $apikey)) {
            if ($databaseQuery = $this->_dbHandler->PrepareStatement("DELETE FROM snippet WHERE id = ? AND userid = ?")) {
                $databaseQuery->bind_param('ss', $id, $userid);
                $databaseQuery->execute();
                if ($databaseQuery->affected_rows == null) {
                    $databaseQuery->close();
                    return false;
                }
                $databaseQuery->close();
            } else {
                return false;
            }

            $this->_dbHandler->close();
            return true;
        } else {
            throw new RestException(401);
        }
    }
}
