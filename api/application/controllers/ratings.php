<?php
// 
//  ratings.php
//  ProjectX
//  
//  Created by Pontus & Tomas on 2012-03-12.
//  Copyright 2012 Pontus & Tomas. All rights reserved.
//

require_once APPLICATION_PATH . '/helpers/DbHandler.php';
require_once APPLICATION_PATH . '/models/RatingModel.php';
require_once APPLICATION_PATH . '/models/RatingObject.php';

class Ratings
{
    private $_dbHandler;
    private $_ratingModel;
    private $_rating;

    public function __construct()
    {
        $this->_dbHandler = new DbHandler();
        $this->_ratingModel = new RatingModel();
        $this->_rating = new RatingObject();
    }

    public function index($request_data = null)
	{ 	
	 	return $this->_ratingModel->getRating($request_data);
    }

    public function post($request_data = null)
    {
    	if (isset($request_data['rating']) && ($request_data['rating'] == 1 || $request_data['rating'] == 0)) {
			$this->setValues($request_data);
			return $this->_ratingModel->createRating($this->_rating);
    	}
    	return array('error' => 'Rating must be 1 or 0 (1=thumbup, 0=thumbdown)');	
    }

    public function put($request_data = null)
    {
    	if (isset($request_data['rating']) && ($request_data['rating'] == 1 || $request_data['rating'] == 0)) {
	        $this->setValues($request_data);
	        return $this->_ratingModel->updateRating($this->_rating);
	    }
	    return array('error' => 'Rating must be 1 or 0 (1=thumbup, 0=thumbdown)');
    }

    public function delete($id = null, $userid = null, $apikey = null)
    {
        $request_data = array('ratingid' => $id, 'userid' => $userid, 'apikey' => $apikey);

        $this->setValues($request_data);
        return $this->_ratingModel->deleteRating($this->_rating);
    }

    public function setValues($values)
    {
        foreach ($values as $action => $value) {
            if (is_array($this->_rating->__isset('_' . $action))) {
                return $this->_rating->__isset('_' . $action);
            } else {
                $this->_rating->__set('_' . $action, $value);
            }
        }
    }
}
