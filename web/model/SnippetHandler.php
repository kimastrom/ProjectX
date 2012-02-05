<?php

require_once 'DbHandler.php';
require_once 'Snippet.php';
require_once 'API.php';

class SnippetHandler
{

    private $_dbHandler;
    private $_api;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_api = new API();
    }

    /**
     *Get a snippet by id
     * @param int $aID id of a snippet
     * @return Snippet
     */
    public function getSnippetByID($id)
    {
        
        $snippet = null;
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet WHERE id = ?")) {

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt->bind_result($snippetID, $author, $code, $title, $desc, $language, $created, $updated);
            while ($stmt->fetch()) {
                $snippet = new Snippet($author, $code, $title, $desc, $language, $created, $updated, $snippetID);
            }

            $stmt->close();

        }
        $this->_dbHandler->Close();
        return $snippet;
    }

    /**
     * Get all the snippets
     * @return array
     */
    public function getAllSnippets()
    {
        $snippets = array();
        
        $jsonsnippet = json_decode(file_get_contents($this->_api->GetURL() . "snippets"));

        foreach ($jsonsnippet as $snippet) {
            $snippets[] = new Snippet($snippet->username, $snippet->code, $snippet->title, $snippet->description, $snippet->languageid, $snippet->date, "0000-00-00 00:00:00", $snippet->id);
        }
        
        return $snippets;
    }

    /**
     * @return Array Snippets
     * @param id of user
     *
     */
    public function getSnippetsByUser($id)
    {
        $snippetArr = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->prepareStatement("SELECT * FROM snippet WHERE user_id = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($id, $userID, $code, $title, $description, $languageID, $created, $updated);

            while ($stmt->fetch()) {
                $temtSnippet = new Snippet($userID, $code, $title, $description, $languageID, $created, $updated, $id);
                array_push($snippetArr, $temtSnippet);
            }
            $stmt->close();
        } else {
            $stmt->close();
            $this->_dbHandler->close();
            return false;
        }
        $this->_dbHandler->close();
        return $snippetArr;
    }

    /**
     * @param int ID of user
     * @return array snippet objects
     */
    public function getRatedSnippetsByUser($id, $rating)
    {
        $snippetArr = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->prepareStatement("SELECT snippet.id, snippet.title, snippet.description, snippet.language
                                                        FROM snippet
                                                        INNER JOIN rating
                                                        ON rating.snippetId = snippet.id
                                                        WHERE rating.rating = ?
                                                        AND rating.userId = ?")) {
            $stmt->bind_param('ii', $rating, $id);
            $stmt->execute();
            $stmt->bind_result($id, $title, $description, $lang);
            while ($stmt->fetch()) {
                $snippet = new Snippet(null, null, $title, $description, $lang, null, null, $id);
                array_push($snippetArr, $snippet);
            }
            $stmt->close();
        }
        $this->_dbHandler->close();
        return $snippetArr;
    }

    /**
     * @param int ID of user
     * @return Array
     */
    public function getCommentedSnippetByUser($id)
    {
        $snippetArr = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->prepareStatement("SELECT snippet.id, snippet.title, snippet.description,comment.comment
                                                        FROM snippet
                                                        INNER JOIN comment
                                                        ON comment.snippet_id = snippet.id
                                                        WHERE comment.user_id = ?")) {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($id, $title, $description,$comment);
            $i = 0;
            while ($stmt->fetch()) {
                $snippetArr[$i]['id'] = $id;
                $snippetArr[$i]['title'] = $title;
                $snippetArr[$i]['description'] = $description;
                $snippetArr[$i]['comment'] = $comment;
                $i++;
            }
            $stmt->close();
        }
        $this->_dbHandler->close();
        return $snippetArr;
    }

    public function createSnippet(Snippet $snippet)
    {
        $this->_dbHandler->__wakeup();
        $author = $snippet->getAuthorId();
        $code = $snippet->getCode();
        $title = $snippet->getTitle();
        $desc = $snippet->getDesc();
        $language = $snippet->getLanguageID();
        $created = $snippet->getCreatedDate();

        if ($databaseQuery = $this->_dbHandler->PrepareStatement("INSERT INTO snippet (user_id, code, title, description, language, created, updated) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
            $databaseQuery->bind_param('sssssss', $author, $code, $title, $desc, $language, $created, $updated);
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
    }

    //kom ihåg att anropa snippetHandler->SetDate i Controllen för att få $updated korrekt
    public function updateSnippet($snippetName, $snippetCode, $snippetID, $updated)
    {
        $databaseQuery = $this->_dbHandler->PrepareStatement("UPDATE SnippetsTable SET snippetName = ?, snippetCode = ?, updated = ? WHERE snippetID = ?");
        $databaseQuery->bind_param('ssis', $snippetName, $snippetCode, $snippetID, $updated);
        $databaseQuery->execute();
        if ($databaseQuery->affected_rows == null) {
            return false;
        }
        $databaseQuery->close();
        return true;
    }

    public function deleteSnippet($snippetID)
    {
        $databaseQuery = $this->_dbHandler->PrepareStatement("DELETE FROM SnippetsTable WHERE snippetID = ?");
        $databaseQuery->bind_param('i', $snippetID);
        $databaseQuery->execute();
        if ($databaseQuery->affected_rows == null) {
            return false;
        }
        $databaseQuery->close();
    }

    /**
     * returns a defined number of snippets
     * @param int number of snippets to return
     * @return array with snippets
     */
    public function getNrOfSnippets($nr)
    {
        if ($nr == 0) {
            $nr = 1;
        }
        $snippets = array();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet LIMIT ?")) {
            $stmt->bind_param("i", $nr);
            $stmt->execute();

            $stmt->bind_result($id, $code, $author, $title, $description, $language, $created, $updated);
            while ($stmt->fetch()) {
                $snippet = new Snippet($code, $author, $title, $description, $language, $id, $created, $updated);
                array_push($snippets, $snippet);
            }

            $stmt->close();
        } else {
            return null;
        }

        $this->_dbHandler->close();

        return $snippets;
    }

    /**
     * returns array with namne and id of language
     * @param int id of language
     * @return Array
     */
    public function getLanguageByID($id)
    {
        $language = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet_language WHERE id = ?")) {

            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt->bind_result($id, $name);
            while ($stmt->fetch()) {
                $language = array('id' => $id, 'name' => $name);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $language;

    }

    /**
     * returns array with namne and id of all languages
     *@return Array
     */
    public function getLanguages()
    {
        $languages = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT * FROM snippet_language")) {
            $stmt->execute();

            $stmt->bind_result($id, $name);
            while ($stmt->fetch()) {
                $language = array('id' => $id, 'name' => $name);
                array_push($languages, $language);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $languages;
    }

    /**
     * returns array with total votes, likes and dislikes
     * @param int id of snippet
     * @return Array
     */
    public function getSnippetRating($id)
    {
        $rating = array();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT COUNT(IF(`rating` = 1, 1, null)) AS Likes, COUNT(IF(`rating` = 0, 1, null)) AS Dislikes FROM `rating` WHERE `snippetId` = ?")) {
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $stmt->bind_result($likes, $dislikes);
            if ($stmt->fetch()) {
                $rating['total'] = $likes + $dislikes;
                $rating['likes'] = $likes;
                $rating['dislikes'] = $dislikes;
            }

            $stmt->close();

        }

        $this->_dbHandler->Close();

        return $rating;
    }

    public function searchByTitle($title)
    {
        $titles = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author ,code, title, description, language, created, updated FROM (snippet) WHERE MATCH title AGAINST (?) ")) {
            $stmt->bind_param("s", $title);
            $stmt->execute();

            $stmt->bind_result($id, $author,$code,$title,$description,$language, $created, $updated);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id, $created, $updated);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }

    public function searchByDescription($description)
    {
        $titles = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author,code,title,description,language, created, updated FROM (snippet) WHERE MATCH description AGAINST (?) ")) {
            $stmt->bind_param("s", $description);
            $stmt->execute();

            $stmt->bind_result($id, $author,$code,$title,$description,$language, $created, $updated);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id, $created, $updated);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }

    public function searchByCode($code)
    {
        $titles = array();
        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author,code,title,description,language, created, updated FROM (snippet) WHERE MATCH code AGAINST (?) ")) {
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $stmt->bind_result($id, $author,$code,$title,$description,$language, $created, $updated);
            
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id, $created, $updated);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }

    public function fullSearch($q)
    {
        $titles = array();
        $this->_dbHandler->__wakeup();
        
        if ($stmt = $this->_dbHandler->PrepareStatement("SELECT id, author, code, title, description, language, created, updated FROM (snippet) WHERE MATCH code,title,description AGAINST (?) ")) {
            $stmt->bind_param("s", $q);
            $stmt->execute();

            $stmt->bind_result($id, $author, $code, $title, $description, $language, $created, $updated);
            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id, $created, $updated);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }

    public function fullSearchWithLang($q, $lang)
    {
        $titles = array();
        $this->_dbHandler->__wakeup();
        
        $sqlQuery = "   SELECT snippet.id, snippet.author, snippet.code, snippet.title, snippet.description, snippet.language, snippet.created, snippet.updated
                        FROM snippet
                        LEFT JOIN snippet_language ON snippet.language = snippet_language.id
                        WHERE MATCH code, title, description
                        AGAINST (?)
                        AND snippet_language.id = ?";

        if ($stmt = $this->_dbHandler->PrepareStatement($sqlQuery)) {
            $stmt->bind_param("si", $q, $lang);
            $stmt->execute();
            $stmt->bind_result($id, $author,$code,$title,$description,$language, $created, $updated);

            while ($stmt->fetch()) {
                $answer = new Snippet($author, $code, $title, $description, $language, $id, $created, $updated);
                array_push($titles, $answer);
            }

            $stmt->close();

        } else {
            return null;
        }
        $this->_dbHandler->Close();
        return $titles;
    }
    
    public function SetDate()
    {
        return date("Y-m-d H:i:s");
    }

}
