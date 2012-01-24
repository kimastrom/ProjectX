<?php

class GravatarHandler
{
	private $_topDefault = "";
	private $_topSize = 25;

	private $_postDefault = "";
	private $_postSize = 40;

	private $_profileDefault = "";
	private $_profileSize = 150;

	/**
	 * Get the url of the topbar gravatar
	 * @param 	string	$email 	Requested gravatars's email
	 * @return	string			Url to the image
	 */
	public function getTopGravatar($email = "")
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($this->_topDefault) . "&s=" . $this->_topSize;
	}

	/**
	 * Get the url of the post gravatar
	 * @param 	string	$email 	Requested gravatars's email
	 * @return	string			Url to the image
	 */
	public function getPostGravatar($email = "")
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($this->_postDefault) . "&s=" . $this->_postSize;
	}

	/**
	 * Get the url of the profile gravatar
	 * @param 	string	$email 	Requested gravatars's email
	 * @return	string			Url to the image
	 */
	public function getProfileGravatar($email = "")
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($this->_profileDefault) . "&s=" . $this->_profileSize;
	}
}