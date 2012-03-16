<?php

class GravatarHandler
{
	private $_topDefault = "s";
	private $_topSize = 25;

	private $_postDefault = "s";
	private $_postSize = 40;

	private $_profileDefault = "s";
	private $_profileSize = 150;

	/**
	 * Get the url of the topbar gravatar
	 * @param 	string	$email 	Requested gravatars's email
	 * @return	string			Url to the image
	 */
	public function getTopGravatar($email = "")
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($this->_topDefault) . "&amp;s=" . $this->_topSize . "&amp;d=mm";
	}

	/**
	 * Get the url of the post gravatar
	 * @param 	string	$email 	Requested gravatars's email
	 * @return	string			Url to the image
	 */
	public function getPostGravatar($email = "")
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($this->_postDefault) . "&amp;s=" . $this->_postSize . "&amp;d=mm";
	}

	/**
	 * Get the url of the profile gravatar
	 * @param 	string	$email 	Requested gravatars's email
	 * @return	string			Url to the image
	 */
	public function getProfileGravatar($email = "")
	{
		return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($this->_profileDefault) . "&amp;s=" . $this->_profileSize . "&amp;d=mm";
	}
}