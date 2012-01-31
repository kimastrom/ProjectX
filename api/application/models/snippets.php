<?php

/**
 * @see DbHandler.php
 */
require_once ('application/helpers/DbHandler.php');
/**
 * @see SnippetObject.php
 */

require_once ('Snippet.php');

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
    private $_snippetHandler;
    private $_snippet;

    /**
     * Snippets::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_snippetHandler = new SnippetHandler();
        $this->_snippet = new Snippet();
    }

    /**
     * Snippets::index()
     * 
     * @param mixed $request_data
     * @return
     */
    public function index($request_data = null)
    {
        return $this->_snippetHandler->getSnipppet($request_data);
    }

    /**
     * Snippets::post()
     * 
     * @param mixed $request_data
     * @return
     */
    public function post($request_data = null)
    {
        $this->setValues($request_data);
        return $this->_snippetHandler->createSnippet($this->_snippet);
    }

    /**
     * Snippets::put()
     * 
     * @param mixed $request_data
     * @return
     */
    public function put($request_data = null)
    {
        $this->setValues($request_data);
        return $this->_snippetHandler->updateSnippet($this->_snippet);
    }

    /**
     * Snippets::delete()
     * 
     * @param mixed $id
     * @param mixed $userid
     * @param mixed $apikey
     * @return
     */
    public function delete($id = null, $userid = null, $apikey = null)
    {
        $request_data = array('id' => $id, 'userid' => $userid, 'apikey' => $apikey);

        $this->setValues($request_data);
        return $this->_snippetHandler->deleteSnippet($this->_snippet);
    }

    /**
     * Snippets::setValues()
     * 
     * @param mixed $values
     * @return
     */
    public function setValues($values)
    {
        foreach ($values as $action => $value) {
            if (is_array($this->_snippet->__isset('_' . $action))) {
                return $this->_snippet->__isset('_' . $action);
            } else {
                $this->_snippet->__set('_' . $action, $value);
            }
        }
    }
}
