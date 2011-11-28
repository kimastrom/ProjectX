<?php

	class SnippetObject {
		private $mSnippetID = null;
		private $mSnippetName = null; 
		private $mSnippetCode = null; 

		public function __construct( $aSnippetID, $aSnippetName, $aSnippetCode) {
			$this->mSnippetID = $aSnippetID;
			$this->mSnippetName = $aSnippetName;
			$this->mSnippetCode = $aSnippetCode;
		}
		
		public function getSnippetID() {
			return $this->mSnippetID;
		}
		
		public function getSnippetName() {
			return $this->mSnippetName;
		}
		
		public function getSnippetCode() {
			return $this->mSnippetCode;
		}
	}