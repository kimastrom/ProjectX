<?php
	
	require_once dirname(__FILE__).'/../model/SnippetHandler.php';
	require_once dirname(__FILE__).'/../view/SnippetView.php';
    require_once dirname(__FILE__).'/../model/DbHandler.php';

	class SnippetController {
		private $mDbHandler = null;
		private $mSnippetView = null;

		public function __construct() {
			$this->mDbHandler = new DbHandler();
			$this->mSnippetHandler = new SnippetHandler($this->mDbHandler);
			$this->mSnippetView = new SnippetView();
		}

		public function listSnippets() {
			    
			if ($this->mSnippetView->triedToGotoCreateView() == true) {
				return $this->mSnippetView->createSnippet();
			}
			else if ($this->mSnippetView->triedTocreateSnippet() == true) {
                $code = $this->mSnippetView->getCreateSnippetCode();
                $title = $this->mSnippetView->getSnippetTitle();
                $desc = $this->mSnippetView->getSnippetDescription();
                $language = $this->mSnippetView->getSnippetLanguage();
                
			    $snippet = new Snippet('kimsan', $code, $title, $desc, $language);
				$this->mSnippetHandler->createSnippet($snippet);
			}
			else if ($this->mSnippetView->triedToDeleteSnippet() == true) {
				$this->mSnippetHandler->deleteSnippet($this->mSnippetView->getSnippetID());
			}
			else if ($this->mSnippetView->triedToChangeSnippet() == true) {
				return $this->mSnippetView->updateSnippet($this->mSnippetHandler->getSingleSnippetData($this->mSnippetView->getSnippetIDLink()));
			}
			else if ($this->mSnippetView->triedToSaveSnippet() == true) {
				$this->mSnippetHandler($this->mSnippetView->getUpdateSnippetID, $this->mSnippetView->getUpdateSnippetName, $this->mSnippetView->getUpdateSnippetCode);
				echo 'Snippet has been updated!';
			}

			return $this->mSnippetView->createSnippet();
		}
	}