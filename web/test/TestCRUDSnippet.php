<?php

	require_once dirname(__FILE__) . '/../model/CRUDSnippetModel.php';

	class TestCRUDSnippet extends UnitTestCase {
		public function testCreateSnippet() {
			$CRUDSnippetModel = new CRUDSnippetModel($this->mMysqliModel);
			$this->assertTrue($CRUDSnippetModel->createSnippet("SnippetNamn","SnippetCode"));
		}	
	}