<?php

require_once 'DbHandler.php';
require_once 'Comment.php';
require_once 'User.php';
require_once 'API.php';

class CommentHandler
{

    private $_dbHandler;
    private $_api;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_api = new API();
    }

    /**
     * Format array before posting via curl
     * @param Array data
     * @return Array
     */
    private function formtaData($data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');
        return $data;
    }

    /**
     * CommentHandler::addComment()
     *
     * @return true if successful
     * use it if you want to add a new commet för a snippet
     * @param snippetId, userId, commentText and apikey
     */
    public function addComment($snippetID, $userID, $comment, $apikey) {
        $url = $this->_api->GetUrl() . 'comments';
        $data = array('snippetid' => $snippetID, 'userid' => $userID, 'comment' => $comment, 'apikey' => $apikey);
        $data = $this->formtaData($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        if(!$result) Log::apiError('could not create comment on snippet: ' . $snippetID, $url);
        return $result;
    }
    /**
     * CommentHandler::updateComment()
     *
     * @return true if successful
     * use it if you want to update a comment that exists in the database
     * @param commentId, userId, commentText and apikey
     */
    public function updateComment($commentID, $userID, $comment, $apikey) {
        $url = $this->_api->GetUrl() . 'comments';
        $data = array('commentid' => $commentID, 'userid' => $userID, 'comment' => $comment, 'apikey' => $apikey);
        $data = $this->formtaData($data);

        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);
        if(!$result) Log::apiError('could not update comment: ' . $commentID, $url);   
        
        return $result;
    }

    /**
     * CommentHandler::getAllCommentsForSnippet()
     *
     * @return an array with all comments for one snippet
     * together with data of the User object
     */
    public function getAllCommentsForSnippet($snippetId)
    {

        $commentsArray = array();
        $sqlQuery = "SELECT comment.snippet_id, comment.id, comment.comment, user.name, user.id
                        FROM comment
                        INNER JOIN user 
                        ON user.id= comment.user_id
                        WHERE comment.snippet_id = ?
                        ORDER by comment.id DESC
        ";

        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param('i', $snippetId);
            $stmt->execute();
            $stmt->bind_result($snippetId, $commentId, $commentText, $username, $userId);

            while ($stmt->fetch()) {
                $comment = new Comment($snippetId, $commentId, $userId, $commentText);
                $comment->setUsername($username);
                array_push($commentsArray, $comment);
            }
            $stmt->close();
        }

        return $commentsArray;
    }

    /**
     * CommentHandler::deleteComment()
     *
     * @return true if successful
     * use it if you want to delete a comment
     * @param an id of the comment to delete
     */
    public function deleteComment($commentId)
    {

        $sqlQuery = "DELETE FROM comment WHERE id=?";

        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("i", $commentId);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
        }
        return false;
    }

    /**
     * CommentHandler::removeAllComments()
     *
     * @return true if successful
     * taking away all comments from the db
     */
    public function removeAllComments()
    {

        $sqlQuery = "DELETE FROM comment";

        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->execute();
            $stmt->close();
            return true;
        }
        return false;
    }

    /**
     * CommentHandler::getCommentToEditByCommentId()
     *
     * @return Comment object to edit
     * @param id of the comment you want to edit
     *
     */
    public function getCommentByID($commentId)
    {
        $comment = null;
        $sqlQuery = "   SELECT comment.snippet_id, comment.id, comment.comment, comment.user_id, user.username
                        FROM comment
                        INNER JOIN user ON user.id = comment.user_id
                        WHERE comment.id = ?
                    ";
        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param('i', $commentId);
            $stmt->execute();
            $stmt->bind_result($snippetId, $commentId, $commentText, $userId, $username);

            if ($stmt->fetch()) {
                $comment = new Comment($snippetId, $commentId, $userId, $commentText);
            }
        }
        $stmt->close();
        return $comment;
    }

    /**
     * @return Array Comment
     * @param id of user
     *
     */
    public function getCommentsByUser($id)
    {
        $commentArr = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->prepareStatement("SELECT * FROM comment WHERE user_id = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($id, $snippetID, $comment, $userID);

            while ($stmt->fetch()) {
                $tempComment = new Comment($snippetID, $id, $userID, $comment);
                array_push($commentArr, $tempComment);
            }
            $stmt->close();
        } else {
            $stmt->close();
            $this->_dbHandler->close();
            return false;
        }
        $this->_dbHandler->close();
        return $commentArr;
    }

}
