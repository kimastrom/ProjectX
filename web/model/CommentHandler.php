<?php

require_once 'DbHandler.php';
require_once 'Comment.php';
require_once 'User.php';

class CommentHandler
{

    private $mDbHandler;
    
    public function __construct()
    {
        $this->mDbHandler = new DbHandler();
    }

    /**
     * CommentHandler::getAllCommentsForSnippet()
     *
     * @return an array with all comments for one snippet
     * together with data of the User object
     */
    public function getAllCommentsForSnippet($aSnippetId)
    {
        $sqlQuery = "   SELECT comment.snippetId, comment.commentId, comment.commentText, comment.userId, user.userName
                        FROM comment
                        INNER JOIN user ON user.userId = comment.userId
                        WHERE snippetId = $aSnippetId
                        ORDER by comment.commentId DESC
        ";
        $stmt = $this->mDbHandler->PrepareStatement($sqlQuery);
        $stmt->execute();
        $stmt->bind_result($aSnippetId, $aCommentId, $aCommentText, $aUserId, $aUserName);

        $objects = array();

        while ($stmt->fetch()) {
            $user = new User($aUserId, $aUserName);
            $comment = new Comment($aSnippetId, $aCommentId, $aUserId, $aCommentText);
            $comment->SetUser($user);
            $objects[] = $comment;
        }
        $stmt->close();

        return $objects;
    }

    /**
     * CommentHandler::addComment()
     *
     * @return true if successful
     * use it if you want to add a new commet för a snippet
     * @param snippetId, commentText and userId
     */
    public function addComment($aSnippetId, $aCommentText, $aUserId)
    {

        $sqlQuery = "INSERT INTO comment (snippetId, commentText, userId) VALUES(?,?,?)";
        if ($stmt = $this->mDbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("isi", $aSnippetId, $aCommentText, $aUserId);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }

    /**
     * CommentHandler::updateComment()
     *
     * @return true if successful
     * use it if you want to update a comment that exists in the database
     * @param commentId, commentText
     */
    public function updateComment($aCommentId, $aCommentText)
    {

        $sqlQuery = "UPDATE comment SET commentText=? WHERE commentId=?";

        if ($stmt = $this->mDbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("si", $aCommentText, $aCommentId);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
        }
        return false;
    }

    /**
     * CommentHandler::deleteComment()
     *
     * @return true if successful
     * use it if you want to delete a comment
     * @param an id of the comment to delete
     */
    public function deleteComment($aCommentId)
    {

        $sqlQuery = "DELETE FROM comment WHERE commentId=?";

        if ($stmt = $this->mDbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("i", $aCommentId);

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

        if ($stmt = $this->mDbHandler->PrepareStatement($sqlQuery)) {
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
    public function getCommentToEditByCommentId($aCommentId)
    {

        $sqlQuery = "   SELECT comment.snippetId, comment.commentId, comment.commentText, comment.userId, user.userName
                        FROM comment
                        INNER JOIN user ON user.userId = comment.userId
                        WHERE commentId = ?";
                        
        $stmt = $this->mDbHandler->PrepareStatement($sqlQuery);
        $stmt->bind_param('i', $aCommentId);
        $stmt->execute();
        $stmt->bind_result($aSnippetId, $aCommentId, $aCommentText, $aUserId, $aUserName);

        $comment = null;

        if ($stmt->fetch()) {
            $user = new User($aUserId, $aUserName);
            $comment = new Comment($aSnippetId, $aCommentId, $aUserId, $aCommentText);
            $comment->SetUser($user);
        }
        $stmt->close();

        return $comment;
    }

}
