<?php
require_once dirname(__FILE__).'/../model/SyntaxHighlight.php';

class SnippetView {
	
	/**
	 * return html code for a single snippet
	 * @param Snippet a snippet Object
	 * @return String
	 */
	 //Todo: This function should also take an argument ($asnippet_language) ex php, javascript or css
	 //This variable is used by syntax highlighter.
	public function singleView($aSnippet) {
		$sh = new SyntaxHighlight();
		
		$html =  "<h2>".$aSnippet->getTitle()."</h2>
		<div class='snippet-desc'>
			<p>".$aSnippet->getDesc()."</p>	
		</div>
		<div class='snippet-code'>
			<code>".$sh->geshiHighlight('css', $aSnippet->getCode())."</code>
		</div>
		<div class='snippet-author'>
			<span>".$aSnippet->getAuthor()."</span>
		</div>";
		
		return $html;		
	}
    
    /**
     * Transform an array of snippets to html-code
     * @param array $aSnippets is an array of snippets
     * @return string
     */
    public function listView($aSnippets) {
        $html = '';
            
        foreach ($aSnippets as $snippet) {
            $html .= '
                <div class="snippet-list-item">
                    <div class="snippet-title">
                        <h3><a href="?snippet='.$snippet->getID().'">' . $snippet->getTitle() . '</a></h3>
                    </div>
                    <div class="snippet-description">
                        <p>' . $snippet->getDesc() . '</p>
                    </div>
                    <div class="snippet-author">
                        <p>Posted by: <i>' . $snippet->getTitle() . '</i></p>
                    </div>
                </div>
            ';
        }
        
        return $html;
    }
    
}
