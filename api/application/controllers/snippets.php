<?php

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once APPLICATION_PATH . '/models/SnippetModel.php';
require_once APPLICATION_PATH . '/models/SnippetObject.php';

class Snippets
{
    private $_dbHandler;
    private $_snippetModel;
    private $_snippet;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_snippetModel = new SnippetModel();
        $this->_snippet = new SnippetObject();
    }

    public function index($request_data = null)
    {
        return $this->_snippetModel->getSnippet($request_data);
    }

    public function post($request_data = null)
    {
        $this->setValues($request_data);
        return $this->_snippetModel->createSnippet($this->_snippet);
    }

    public function put($request_data = null)
    {
        $this->setValues($request_data);
        return $this->_snippetModel->updateSnippet($this->_snippet);
    }

    public function delete($id = null, $userid = null, $apikey = null)
    {
        $request_data = array('id' => $id, 'userid' => $userid, 'apikey' => $apikey);

        $this->setValues($request_data);
        return $this->_snippetModel->deleteSnippet($this->_snippet);
    }

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
