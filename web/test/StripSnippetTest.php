<?php
	require_once dirname(__FILE__) . '/../model/StripSnippet.php';
	
	/**
	 * 
	 */
	class TestOfSnippetValidation extends UnitTestCase {
		public function testValidateSnippet() {
			$stripSnippet = new StripSnippet();
			
			$validSnippet = "<?php\n\tfunction phptag(\$args0) {\n\t\techo \"first\";\n\t}\n?>";
			$validStrippedSnippet = "<?php function phptag(\$args0) {echo \"first\";} ?>";

			$strippedSnippet = $stripSnippet->stripSnippetString($validSnippet);
			$this->assertIdentical($validStrippedSnippet, $strippedSnippet);
			
			$snippetWithoutPHPTag = "function nophptag(\$args0) {\n\t\techo \"second\";\n\t}";
			$validStrippedSnippet = "function nophptag(\$args0) {echo \"second\";}";
			
			$strippedSnippet = $stripSnippet->stripSnippetString($snippetWithoutPHPTag);
			$this->assertIdentical($validStrippedSnippet, $strippedSnippet);
		}
	}
