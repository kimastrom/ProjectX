<?php

	class CRUDSnippetView {
		public function createSnippet() {
			$view =
			'
				<div id="createSnippetContainer">
					<form action="" method="post">
						<div id="createSnippetNameDiv">
							<p>Name:</p>
							<input type="text" name="createSnippetNameInput" id="createSnippetNameInput" /> 
						</div>

						<div id="createSnippetCodeDiv">
							<p>Snippet:</p>
							<textarea cols="50" rows="20" name="createSnippetCodeInput" id="createSnippetCodeInput"></textarea>
						</div>

						<div id="createSnippetButton">
							<input type="submit" name="createSnippetSaveButton" id="createSnippetSaveButton" value="Create snippet" />
						</div>
					</form>
				</div>
			';
			return $view;
		}

		public function listSnippets($aSnippets) {
			$view = 
			'
				<div id="listSnippetsButtons">
					<form action="" method="post">
						<input type="submit" name="gotoCreateSnippetViewButton" id="gotoCreateSnippetViewButton" value="Create snippet" />
					</form>
				</div>
				
				<div id="listSnippetsTableDiv">
					<table id="listSnippetsTable">
						<thead>
							<th>Name:</th>
							<th>&nbsp;</th>
						</thead>
						<tbody>
			';
			foreach ($aSnippets as &$snippets) {
				$view .= 
				'			
							<form action="" method="post">
								<tr>
									<td><a href="?chsnippet='.$snippets->getSnippetID().'">'.$snippets->getSnippetName().'</a></td>
									<td><input type="hidden" name="snippetID" value="'.$snippets->getSnippetID().'" /><input type="submit" name="deleteSnippetButton" id="deleteSnippetButton" value="Delete snippet" /></td>
								<tr>
							</form>
				';
			}
			$view .=
			'
						</tbody>
					</table>
				</div>
			';
			return $view;
		}

		public function updateSnippet($aSnippet) {
			$view =
			'
				<div id="updateSnippetContainer">
					<form action="" method="post">
						<div id="updateSnippetNameDiv">
							<p>Name:</p>
							<input type="text" name="updateSnippetNameInput" id="updateSnippetNameInput" value="'.$aSnippet[0]->getSnippetName().'" /> 
						</div>

						<div id="updateSnippetCodeDiv">
							<p>Snippet:</p>
							<textarea cols="50" rows="50" name="updateSnippetCodeInput" id="updateSnippetCodeInput">'.$aSnippet[0]->getSnippetCode().'</textarea>
						</div>

						<div id="updateSnippetButton">
							<input type="hidden" name="updateSnippetID" value="'.$aSnippet[0]->getSnippetID().'" />
							<input type="submit" name="updateSnippetUpdateButton" id="updateSnippetUpdateButton" value="Update snippet" />
						</div>
					</form>
				</div>
			';
			return $view;
		}

		public function triedToCreateSnippet() {
			if (isset($_POST['createSnippetSaveButton'])) {
				return true;
			}
			else{
				return false;
			}
		}

		public function getCreateSnippetName() {
			$snippetName = $_POST["createSnippetNameInput"];
			if ($snippetName == null) {
				return null;
			}
			else {
				return $snippetName;
			}
			return false;
		}

		public function getCreateSnippetCode() {
			$snippetCode = $_POST["createSnippetCodeInput"];
			if ($snippetCode == null) {
				return null;
			}
			else {
				return $snippetCode;
			}
			return false;
		}
		
		public function triedToChangeSnippet() {
			if (isset($_GET["chsnippet"])) {
				return true;
			}
			else {
				return false;
			}
		}

		public function getSnippetIDLink() {
			$snippetID = $_GET["chsnippet"];
			if ($snippetID == null) {
				return null;
			}
			else {
				return $snippetID;
			}
			return false;
		}			

		public function triedToSaveSnippet() {
			if (isset($_POST['updateSnippetUpdateButton'])) {
				return true;
			}
			else{
				return false;
			}
		}	

		public function getUpdateSnippetName() {
			$snippetName = $_POST["updateSnippetNameInput"];
			if ($snippetName == null) {
				return null;
			}
			else {
				return $snippetName;
			}
			return false;
		}	

		public function getUpdateSnippetCode() {
			$snippetCode = $_POST["updateSnippetCodeInput"];
			if ($snippetCode == null) {
				return null;
			}
			else {
				return $snippetCode;
			}
			return false;
		}

		public function getUpdateSnippetID() {
			$snippetID = $_POST["updateSnippetID"];
			if ($snippetID == null) {
				return null;
			}
			else {
				return $snippetID;
			}
			return false;
		}	

		public function triedToDeleteSnippet() {
			if (isset($_POST['deleteSnippetButton'])) {
				return true;
			}
			else {
				return false;
			}
		}

		public function getSnippetID() {
			$snippetID = $_POST["snippetID"];
			if ($snippetID == null) {
				return null;
			}
			else {
				return $snippetID;
			}
			return false;
		}		

		public function triedToGotoCreateView() {
			if (isset($_POST['gotoCreateSnippetViewButton'])) {
				return true;
			}
			else {
				return false;
			}
		}
	}