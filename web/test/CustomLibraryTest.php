<?php
    require_once dirname(__FILE__) . '/../model/FormValidation.php';
    
    class CustomLibraryTest extends UnitTestCase {
        function testStripHtmlTags() {
            $val = new FormValidation();
            $text = "<!DOCTYPE><a><abbr><acronym><address><applet><area/><b><base/><basefont/><bdo><big><blockquote><body><br/><button><caption><center><cite><col/><colgroup><dd><del><dfn><dir><div><dl><dt><em><fieldset><font><form><frame/><frameset><h1><h2></h2><h3></h3><h4></h4><h5></h5><h6><head><hr/><html><i><iframe><img/><input/><ins><isindex><kbd><label><legend><li><link/><map><menu><meta/><noframes><noscript><object><ol><optgroup><option><param/><pre><q><s><samp><script><select><small><span><strike><strong><style><sub><sup><table><tbody><td><textarea><tfoot><th><thead><title><tr><tt><u><ul><var><xmp>";
            $this->assertTrue(($val->strip_html_tags($text)) == "");
        }
    }