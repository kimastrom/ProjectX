<?php

	require_once('SnippetObject.php');

	class CRUDSnippetModel
	{
		private $mDatabase = null;
	
		public function __construct($aDatabase) {
			$this->mDatabase = $aDatabase;
		}

		public function createSnippet($aSnippetName, $aSnippetCode) {
			$databaseQuery = $this->mDatabase->PrepareStatement("INSERT INTO SnippetsTable (snippetName, snippetCode) VALUES (?, ?)");
			$databaseQuery->bind_param('ss', $aSnippetName, $aSnippetCode);
			$databaseQuery->execute();
			if ($databaseQuery->affected_rows == null)
			{
				return false;
			}
			$databaseQuery->close();
			return true;
		}

		public function listSnippets() {
			$snippets = array();
			$databaseQuery = $this->mDatabase->PrepareStatement("SELECT * FROM SnippetsTable");
			$databaseQuery->execute();
			$databaseQuery->store_result();
			$databaseQuery->bind_result($SnippetName, $SnippetCode, $SnippetID);
			while ($databaseQuery->fetch())
			{
				$snippets[] = new SnippetObject($SnippetName, $SnippetCode, $SnippetID);
			}
			$databaseQuery->free_result(); 
			$databaseQuery->close();
			return $snippets;
		}

		public function getSingleSnippetData($aSnippetID) {
			$snippet = array();
			$databaseQuery = $this->mDatabase->PrepareStatement("SELECT * FROM SnippetsTable WHERE snippetID = ?");
			$databaseQuery->bind_param('i', $aSnippetID);
			$databaseQuery->execute();
			$databaseQuery->store_result();
			$databaseQuery->bind_result($SnippetName, $SnippetCode, $SnippetID);
			while ($databaseQuery->fetch())
			{
				$snippets[] = new SnippetObject($SnippetName, $SnippetCode, $SnippetID);
			}
			$databaseQuery->free_result(); 
			$databaseQuery->close();
			return $snippets;
		}

		public function updateSnippet($aSnippetName, $aSnippetCode, $aSnippetID) {
			$databaseQuery = $this->mDatabase->PrepareStatement("UPDATE SnippetsTable SET snippetName = ?, snippetCode = ? WHERE snippetID = ?");
			$databaseQuery->bind_param('ssi', $$aSnippetName, $aSnippetCode, $aSnippetID);
			$databaseQuery->execute();
			if ($databaseQuery->affected_rows == null)
			{
				return false;
			}
			$databaseQuery->close();
			return true;
		}

		public function deleteSnippet($aSnippetID) {
			$databaseQuery = $this->mDatabase->PrepareStatement("DELETE FROM SnippetsTable WHERE snippetID = ?");
			$databaseQuery->bind_param('i', $aSnippetID);
			$databaseQuery->execute();
			if ($databaseQuery->affected_rows == null)
			{
				return false;
			}
			$databaseQuery->close();
		}
	}