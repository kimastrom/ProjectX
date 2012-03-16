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
     * Check response and content
     * @param string URL, url to API
     * @return json content on succsess or FALSE failiure
     */
    private function getJson($url) {
        if($content = @file_get_contents($url)) {
            $header = get_headers($url);
            if($header[0] != 'HTTP/1.1 200 OK') return false;
            if($json = json_decode($content)) {
                return $json;
            }
        }
        Log::apiError('could not get content ' , $url);
        return false;
    }

    public function getComments($id) {

        $comments = array();
        $url = $this->_api->GetURL() . 'comments?snippetid=' . $id;  
        if($json = $this->getJson($url)) {
            if (!$json->error) {
                foreach($json as $j) {
                    $comments[] = new Comment($j->snippetId, $j->commentId, $j->userId, $j->comment, $j->comment_created_date);
                }
                return $comments;
            }
        }
        return false;
    }

    /**
     * CommentHandler::addComment()
     *
     * @return true if successful
     * use it if you want to add a new commet för a snippet
     * @param snippetId, userId, commentText and apikey
     */
    public function addComment($snippetID, $userID, $comment) {
        $url = $this->_api->GetUrl() . 'comments';
        $data = array('snippetid' => $snippetID, 'userid' => $userID, 'comment' => $comment, 'apikey' => AuthHandler::getApiKey());
        $data = $this->formtaData($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);     

        if($httpCode == 200) return true;

        Log::apiError('could not create comment on snippet: ' . $snippetID, $url);
        return $result;
    }
    /**
     * CommentHandler::updateComment()
     *
     * @return true if successful
     * use it if you want to update a comment that exists in the database
     * @param commentId, userId, commentText and apikey
     */
    public function updateComment($commentID, $userID, $comment) {
        $url = $this->_api->GetUrl() . 'comments';
        $data = array('commentid' => $commentID, 'userid' => $userID, 'comment' => $comment, 'apikey' => AuthHandler::getApiKey());
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
     * CommentHandler::deleteComment()
     *
     * @return true if successful
     * use it if you want to delete a comment
     * @param an id of the comment to delete
     */
    public function deleteComment($comment)
    {

        $url = $this->_api->GetURL() . 'comments/' . $comment->getID() . '/' . $comment->getUserId() . '/' . AuthHandler::getApiKey();
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $result = curl_exec($ch);

        if(!$result) {
            Log::apiError('could not delete snippet:' . $comment->getID(), $url);
        }
        
        return $result;
    }

    /**
     * CommentHandler::getCommentToEditByCommentId()
     *
     * @return Comment object to edit
     * @param id of the comment you want to edit
     *
     */
    public function getCommentByID($id)
    {
        $comment = null;
        $url = $this->_api->GetURL() . "comments?commentid=" . $id;
        if($json = $this->getJson($url)) {
            foreach($json as $j)
            {
                $comment = new Comment($j->snippetid, $j->commentid, $j->userid, $j->comment);
            }
            return $comment;
        }
        return false;
    }

    /**
     * @return Array Comment
     * @param id of user
     *
     */
    public function getCommentsByUser($id)
    {
        $comments = null;
        $url = $this->_api->GetURL() . "api/comments?userid=" . $id;
        if($json = $this->getJson($url)) {
            foreach($json as $j)
            {
                $comments[] = new Comment($j->snippetid, $j->commentid, $j->userid, $j->comment);
            }
            return $comments;
        }
        return false;
    }

}
