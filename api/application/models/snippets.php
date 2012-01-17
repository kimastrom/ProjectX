<?php

/**
 * @see DbHandler.php
 */
require_once ('application/helpers/DbHandler.php');
/**
 * @see SnippetObject.php
 */
require_once ('SnippetObject.php');

/**
 * Snippets class
 * 
 * <p>Creates snippet objects of REQUEST parameters.<br/>
 * It then dynamiclly build a query, that is used<br/>  
 * to get the requested data from the database.<br/>
 * Returns an array of snippets that is presented as Json<br/>
 * or XML with help of the restler API.<br/>
 * Example usage:</p>
 * 
 * <ol>
 *      <li>   
 *          /snippets<br/>
 *          Get all snippets in Json format
 *      </li> 
 *      <li>
 *          /snippets.xml?language=php&datefrom=20100101&dateto=20110101<br/>
 *          Get all Php snippets created between two dates in XML format<br/>
 *      </li>  
 *      <li>
 *          /snippets?language=csharp&sort=rating<br/>
 *          Get all C# snippets sorted on rating in Json format
 *      </li>     
 *      <li>
 *          /snippets.xml?lang=csharp&username=cesarsnipp&sort=title<br/>
 *          Get all C# snippets from user with username cesarsnipp sorted on title in Json format
 *      </li>     
 * </ol> 
 * 
 * Url Parameters
 * <ul>
 *      <li>sort = [language, title, description, code, username, id, date, rating]</li>
 *      <li>[language, title, description, code, username, id, date, rating] = ?</li>
 *      <li>datefrom = format(YYYY-MM-DD) && dateto = format(YYYY-MM-DD)</li>
 *      <li>date = format(YYYY-MM-DD)</li>
 * </ul>
 * 
 * @author   Pontus <bopontuskarlsson@hotmail.com>
 * @author   Tomas <tompen@telia.com>
 * @version  1.0
 * @category projectX
 * @package  ProjectX
 */
class Snippets
{
    private $_dbHandler;
    private $_snippetObject;

    /**
     * Snippets::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_snippetObject = new SnippetObject();
    }

    /**
     * Snippets::index()
     * 
     * @return Array $snippets
     */
    public function index()
    {
        foreach ($_REQUEST as $action => $value) {
            if (is_array($this->_snippetObject->__isset('_' . $action))) {
                return $this->_snippetObject->__isset('_' . $action);
            } else {
                $this->_snippetObject->__set('_' . $action, $value);
            }
        }

        $snippets = array();
        $select = $this->_snippetObject->select();

        $this->_dbHandler->__wakeup();
        if ($stmt = $this->_dbHandler->PrepareStatement($select[0])) {
            if ($select[1] != '') {
                call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt, $select[1]), $select[2]));
            }
            $stmt->execute();

            $stmt->bind_result($id, $userId, $code, $title, $description, $languageId, $date,
                $ratingId, $userId, $snippetId, $rating, $rating_created_date, $userId, $username,
                $email, $password, $apikey, $languageid, $language);
            while ($stmt->fetch()) {
                $snippet = array('language' => $language, 'title' => $title, 'description' => $description,
                    'code' => $code, 'username' => $username, 'id' => $id, 'date' => $date, 'rating' =>
                    $rating);
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
}
