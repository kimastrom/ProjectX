<?php
	
	require_once('MysqliModel.php');
	require_once('CRUDSnippetModel.php');
	require_once('CRUDSnippetView.php');

	class ListSnippetsController {
		private $mMysqliModel = null;
		private $mCRUDSnippetView = null;

		public function __construct() {
			$this->mMysqliModel = new MysqliModel("localhost", "root", "root", "snippets");
			$this->mCRUDSnippetModel = new CRUDSnippetModel($this->mMysqliModel);
			$this->mCRUDSnippetView = new CRUDSnippetView();
		}

		public function listSnippets() {
			if ($this->mCRUDSnippetView->triedToGotoCreateView() == true) {
				return $this->mCRUDSnippetView->createSnippet();
			}
			else if ($this->mCRUDSnippetView->triedTocreateSnippet() == true) {
				$this->mCRUDSnippetModel->createSnippet($this->mCRUDSnippetView->getcreateSnippetName(), $this->mCRUDSnippetView->getcreateSnippetCode());
			}
			else if ($this->mCRUDSnippetView->triedToDeleteSnippet() == true) {
				$this->mCRUDSnippetModel->deleteSnippet($this->mCRUDSnippetView->getSnippetID());
			}
			else if ($this->mCRUDSnippetView->triedToChangeSnippet() == true) {
				return $this->mCRUDSnippetView->updateSnippet($this->mCRUDSnippetModel->getSingleSnippetData($this->mCRUDSnippetView->getSnippetIDLink()));
			}
			else if ($this->mCRUDSnippetView->triedToSaveSnippet() == true) {
				$this->mCRUDSnippetModel($this->mCRUDSnippetView->getUpdateSnippetID, $this->mCRUDSnippetView->getUpdateSnippetName, $this->mCRUDSnippetView->getUpdateSnippetCode);
				echo 'Snippet has been updated!';
			}

			return $this->mCRUDSnippetView->listSnippets($this->mCRUDSnippetModel->listSnippets());
		}
	}

	$listSnippetsController = new ListSnippetsController();
	echo $listSnippetsController->listSnippets();