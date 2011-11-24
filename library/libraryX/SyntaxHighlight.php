<?php
/**
 * class SyntaxHighLight
 *
 * @author Pontus <bopontuskarlsson@hotmail.com>
 * @version 1.0
 * @category projectX
 * @package ProjectX
 */
/**
 * @see geshi_geshi.php
 */
require_once ("geshi/geshi.php");
/**
 * Highlight every possible language with GeSHi
 *
 * <p>This class can highlight most types of languages.</p>
 * <p>Uses geSHi library to do this.</p>
 * @author Pontus
 * @version 1.0
 * @category projectX
 * @package ProjectX
 */
class SyntaxHighlight {
    /**
     * <p>View website for supported languages.</p>
     * <p>http://qbnz.com/highlighter/</p>
	 * <p>Usage:</p>
	 * <code>
	 * $sh = new Syntax_highlight();
	 * $highlightedCode = $sh->geshiHighlight("php", $code));
	 * </code>
     *
     * @param  string $lang
     * @param  string $code
     * @return string $highlightedCode
	 * @access public
     */
    public function geshiHighlight($lang, $code) {
        $geshi = new GeSHi($code, $lang);
        return $geshi->parse_code();
    }
}
?>