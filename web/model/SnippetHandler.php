<?php

require_once 'DbHandler.php';
require_once 'Snippet.php';
require_once 'API.php';
require_once 'AuthHandler.php';

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
     * Check response and content
     * @param string URL, url to API
     * @return json content on succsess or FALSE failiure
     */
    private function getJson($url) {
        if($content = @file_get_contents($url)) {
            if($json = json_decode($content)) {
                return $json;
            }
        }
        return false;
    }

    /**
     *Get a snippet by id
     * @param int $aID id of a snippet
     * @return Snippet
     */
    public function getSnippetByID($id)
    {
        $snippet = null;
        $url = $this->_api->GetURL() . "snippets/?id=" . $id;
        if($json = $this->getJson($url)) {
            foreach($json as $j)
            {
                $snippet = new Snippet($j->userid, $j->username, $j->code, $j->title, $j->description, $j->languageid, $j->date, $j->updated, $j->id, $j->language);
            }
            
            return $snippet;
        }
        return false;
    }

    /**
     * @return Array Snippets
     * @param id of user
     *
     */
    public function getSnippetsByUser($userid)
    {
        $snippets = null;
        $url = $this->_api->GetURL() . "snippets/?userid=" . $userid;
        if($json = $this->getJson($url)) {
            foreach($json as $j)
            {
                $snippets[] = new Snippet($j->userid, $j->username, $j->code, $j->title, $j->description, $j->languageid, $j->date, $j->updated, $j->id, $j->language);
            }
            return $snippets;
        }
        return false;
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
    
    /**
     * Creates a snippet via the API
     * @param Snippet $snippet
     * @return bool
     */
    public function createSnippet(Snippet $snippet)
    {
        $author = $snippet->getAuthorId();
        $code = $snippet->getCode();
        $title = $snippet->getTitle();
        $desc = $snippet->getDesc();
        $language = $snippet->getLanguageID();
        $created = $snippet->getCreatedDate();
        
        $url = $this->_api->GetURL() . "snippets";
        $query = array('userid' => $snippet->getAuthorId(), 'code' => $snippet->getCode(), 'desc' => $snippet->getDesc(), 'title' => $snippet->getTitle(), 'languageid' => $snippet->getLanguageID(), 'apikey' => AuthHandler::getApiKey());
        
        $fields = '';
        foreach ($query as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');
        
        $post = curl_init();

        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_POST, count($query));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

        $result = json_decode(curl_exec($post));

        curl_close($post);
        
        if(!$result) {
            Log::apiError('could not create snippet', $url);
            return false;
        }

        return $result->id;
    }

    /**
     * Updates a snippet via the API
     * @param string $snippetName, string $snippetCode, string $snippetDesc, int $snippetID, date $updated
     * @return bool
     */
    public function updateSnippet($snippetName, $snippetCode, $snippetDesc, $snippetID, $updated)
    {
        $url = $this->_api->GetURL() . "snippets";
        $query = array('id' => $snippetID, 'userid' => 2, 'code' => $snippetCode, 'desc' => $snippetDesc, 'title' => $snippetName, 'languageid' => '2', 'apikey' => '5435gdfhghdghdf');
        
        $fields = '';
        foreach ($query as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');
        
        $post = curl_init();
        
        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($post);

        curl_close($post);
        if(!$post) {
            Log::apiError('could not update snippe:'. $snippetID, $url);
        }

        return $result;
    }

    public function deleteSnippet(Snippet $snippet)
    {
        $url = $this->_api->GetURL() . 'snippets/' . $snippet->getID() . '/' . $snippet->getAuthorId() . '/' . AuthHandler::getApiKey();
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $result = curl_exec($ch);

        if(!$result) {
            Log::apiError('could not delete snippet:' . $snippet->getID(), $url);
        }
        
        return $result;
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
    
    public function SetDate()
    {
        return date("Y-m-d H:i:s");
    }

}
