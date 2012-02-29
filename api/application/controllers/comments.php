<?php

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once APPLICATION_PATH . '/models/CommentModel.php';
require_once APPLICATION_PATH . '/models/CommentObject.php';

class Comments
{
    private $_dbHandler;
    private $_commentModel;
    private $_comment;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_commentModel = new CommentModel();
        $this->_comment = new CommentObject();
    }

    public function index($request_data = null)
    {
    	if (isset($request_data['snippetid'])) {
    		return $this->_commentModel->getComment($request_data);
    	}
	 	return array('error' => ' You have to enter a snippetid. (comments?snippetid=...)');
    }

    public function post($request_data = null)
    {
        $this->setValues($request_data);
        return $this->_commentModel->createComment($this->_comment);
    }

    public function put($request_data = null)
    {
        $this->setValues($request_data);
        return $this->_commentModel->updateComment($this->_comment);
    }

    public function delete($id = null, $userid = null, $apikey = null)
    {
        $request_data = array('commentid' => $id, 'userid' => $userid, 'apikey' => $apikey);

        $this->setValues($request_data);
        return $this->_commentModel->deleteComment($this->_comment);
    }

    public function setValues($values)
    {
        foreach ($values as $action => $value) {
            if (is_array($this->_comment->__isset('_' . $action))) {
                return $this->_comment->__isset('_' . $action);
            } else {
                $this->_comment->__set('_' . $action, $value);
            }
        }
    }
}
