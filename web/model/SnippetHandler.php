<?php

require_once 'DbHandler.php';
require_once 'Snippet.php';
require_once 'User.php';

class SnippetHandler
{
    private $mDbHandler;

    public function __construct()
    {
        $this->mDbHandler = new DbHandler();
    }
    
    /**
     * Get all the snippets
     * @return array of all snippets
     */
    public function getAllSnippets()
    {
        $sqlQuery = "   SELECT snippet.snippetId ,snippet.userId, snippet.code, snippet.title, snippet.desc, snippet.snippetLang ,user.userName
                        FROM snippet
                        INNER JOIN user ON user.userId = snippet.userId
                        ORDER by snippet.snippetId DESC";
        $stmt = $this->mDbHandler->PrepareStatement($sqlQuery);
        $stmt->execute();
        $stmt->bind_result($aSnippetId, $aUserId, $aCode, $aTitle, $aDesc, $aLang, $aUserName);

        $objects = array();

        while ($stmt->fetch()) {
            $user = new User($aUserId, $aUserName);
            $snippet = new Snippet($aSnippetId, $aUserId, $aCode, $aTitle, $aDesc, $aLang);
            $snippet->SetUser($user);
            $objects[] = $snippet;
        }
        $stmt->close();

        return $objects;
    }
    
    /**
     * SnippetHandler::getSnippetById()
     * 
     * @param int $aSnippetId
     * @return Snippet object
     */
    public function getSnippetById($aSnippetId)
    {
        $sqlQuery = "   SELECT snippet.snippetId ,snippet.userId, snippet.code, snippet.title, snippet.desc, snippet.snippetLang ,user.userName
                        FROM snippet
                        INNER JOIN user ON user.userId = snippet.userId
                        WHERE snippetId = $aSnippetId";
        $stmt = $this->mDbHandler->PrepareStatement($sqlQuery);
        $stmt->execute();
        $stmt->bind_result( $aSnippetId, $aUserId, $aCode, $aTitle, $aDesc, $aLang, $aUserName );

        $objects = array();

        while ($stmt->fetch()) {
            $user = new User($aUserId, $aUserName);
            $snippet = new Snippet($aSnippetId, $aUserId, $aCode, $aTitle, $aDesc, $aLang);
            $snippet->SetUser($user);
            $objects[] = $snippet;
        }
        $stmt->close();
        return $objects;
    }
    
    /**
     * SnippetHandler::addSnippet()
     * 
     * @param mixed $aUserId
     * @param mixed $aCode
     * @param mixed $aTitle
     * @param mixed $aDesc
     * @param mixed $aLang
     * @return true if success, false if fail
     * create a new snippet in the db
     */
    public function addSnippet($aUserId, $aCode, $aTitle, $aDesc, $aLang)
    {
        $sqlQuery = "INSERT INTO snippet (snippet.userId, snippet.code, snippet.title, snippet.desc, snippet.snippetLang) VALUES(?,?,?,?,?)";
        if ($stmt = $this->mDbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("issss", $aUserId, $aCode, $aTitle, $aDesc, $aLang);
            $stmt->execute();
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * SnippetHandler::deleteSnippet()
     * 
     * @param int $aSnippetId
     * @return deletes a snippet with sine given id
     */
    public function deleteSnippet($aSnippetId)
    {
        $sqlQuery = "DELETE FROM snippet WHERE snippetId=?";

        if ($stmt = $this->mDbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("i", $aSnippetId);

            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
        }
        return false;
    }
}
