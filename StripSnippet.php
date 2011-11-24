<?php
	/**
	 * Strip Snippet
	 * 
	 * Cleans up the snippet from indentation and newlines
	 * @author Rickard Magnusson
	 * @version 1.0
	 */
	class StripSnippet {
		/**
		 * Function to strip snippet from indentation and newlines
		 * @param string $snippet name to declare
		 * @return string 
		 */
		public function stripSnippetString($snippet) {
			$needles = array("\t", "\n", "\r");
			$snippet = str_replace($needles, "", $snippet);
			$snippet = str_replace("<?php", "<?php ", $snippet);
			$snippet = str_replace("?>", " ?>", $snippet);
			
			return $snippet;
		}
	}
	