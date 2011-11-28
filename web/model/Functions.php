<?php
//Require syntax_highlight
require_once ("geshi/geshi.php");

class Functions {
	//Highlight code with this language
    public function geshiHighlight($lang, $code) {
        $geshi = new GeSHi($code, $lang);
        return $geshi->parse_code();
    }
	
	//Strip snippet from indentations and newlines
    public function stripSnippetString($snippet) {
        $needles = array("\t", "\n", "\r");
        $snippet = str_replace($needles, "", $snippet);
        $snippet = str_replace("<?php", "<?php ", $snippet);
        $snippet = str_replace("?>", " ?>", $snippet);
        return $snippet;
    }
    
	//Strip zeros from date
    public function srtip_zeros_from_date($marked_string = "") {
        //first remove the zeros
        $no_zeros = str_replace('*0', '', $marked_string);
        $cleaned_string = str_replace('*' . '', $no_zeros);
        return $cleaned_string;
    }
	
    //Check that a string do not exceed maxlenght</p>
    public function valMaxLenght($str, $maxlenght) {
        if (strlen($str) < $maxlenght ? true : false);
    }
    
	 //Validate url
	 //with or without http:// and https://
    public function valUrl($value) {
        $value = trim($value);
        $validhost = true;
        if (strpos($value, 'http://') === false && strpos($value, 'https://') === false) {
            $value = 'http://' . $value;
        }
        //first check with php's FILTER_VALIDATE_URL
        if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === false) {
            $validhost = false;
        } else {
            //not all invalid URLs are caught by FILTER_VALIDATE_URL
            //use our own mechanism
            $host = parse_url($value, PHP_URL_HOST);
            $dotcount = substr_count($host, '.');
            //the host should contain at least one dot
            if ($dotcount > 0) {
                //if the host contains one dot
                if ($dotcount == 1) {
                    //and it start with www.
                    if (strpos($host, 'www.') === 0) {
                        //there is no top level domain, so it is invalid
                        $validhost = false;
                    }
                } else {
                    //the host contains multiple dots
                    if (strpos($host, '..') !== false) {
                        //dots can't be next to each other, so it is invalid
                        $validhost = false;
                    }
                }
            } else {
                //no dots, so it is invalid
                $validhost = false;
            }
        }
        //return false if host is invalid
        //otherwise return true
        return $validhost;
    }
    
     //Validate an email
    
     //This function verifies that the email address complies with the following
     //standards:
     //RFC 822, RFC 1035, RFC 2821, RFC 2822
     //It also ensures that the domain actually resolves.
    public function valEmail($email) {
        // get position of the final @ symbol
        $index = strrpos($email, "@");
        if (is_bool($index) && !$index) return false;
        // split up the email address into domain and local parts
        $domain = substr($email, $index + 1);
        $local = substr($email, 0, $index);
        // determine string length
        $l_len = strlen($local);
        $d_len = strlen($domain);
        // verify strings aren't too short or too long
        if ($l_len < 1 || $l_len > 64) return false;
        if ($d_len < 1 || $d_len > 255) return false;
        // verify that we don't start or end with a .
        if ($local[0] == '.' || $local[$l_len - 1] == '.') return false;
        if ($domain[0] == '.' || $domain[$d_len - 1] == '.') return false;
        // verify we don't have two .'s in succession
        if (preg_match('/\\.\\./', $local)) return false;
        if (preg_match('/\\.\\./', $domain)) return false;
        // check for disallowed characters
        if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) return false;
        if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\", "", $local))) {
            // check for invalid escape sequences in the local part
            if (!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\", "", $local))) return false;
            // check for valid DNS records
            if (!(checkdnsrr($domain, "MX") || checkdnsrr($domain, "A") || checkndsrr("AAAA"))) return false;
        }
        // return true, the email is valid.
        return true;
    }
    
	//Removes whitespace
    function removeWhitespace(sString) {
        while (sString . substring(0, 1) == ' ') {
            sString = sString . substring(1, sString . length);
        }
        while (sString . substring(sString . length - 1, sString . length) == ' ') {
            sString = sString . substring(0, sString . length - 1);
        }
        return sString;
    }
}
?>