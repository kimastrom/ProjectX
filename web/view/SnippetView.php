<?php
require_once dirname(__FILE__) . '/../model/Functions.php';

class SnippetView
{
    
    /**
     * Transform an array of snippets to html-code
     * @param array $aSnippets is an array of snippets
     * @return string
     */
    public function listView($snippets)
    {
        $html = '';

        foreach ($snippets as $snippet) {
            $html .= '
                <div class="snippet-list-item">
                    <div class="snippet-title">
                        <h3><a href="?snippet=' . $snippet->getSnippetID() . '">' . $snippet->getSnippetTitle() . '</a></h3>
                    </div>
                    
                    <div class="snippet-description">
                        <p>' . $snippet->getSnippetDesc() . '</p>
                    </div>
                    
                    <div class="snippet-author">
                        <p>Posted by: <i>' . $snippet->getUser()->getUserName() . '</i></p>
                    </div>
                    
                </div>
            ';
        }
        $html .= "<br /><a href='index.php?ctrl=createNewSnippetView'>Lägg till en ny snippet</a>";
        return $html;
    }
    
    /**
     * return html code for a single snippet
     * @param Snippet a snippet Object
     * @return String
     */
    public function singleView($snippet)
    {

        $sh = new Functions();

        $html = "<h2>" . $snippet[0]->getSnippetTitle() . "</h2>
		<div class='snippet-desc'>
			<p>" . $snippet[0]->getSnippetDesc() . "</p>	
		</div>
		<div class='snippet-code'>
			<code>" . $sh->geshiHighlight($snippet[0]->getSnippetCode(), $snippet[0]->getSnippetLanguage()) . "</code>
		</div>
		<div class='snippet-author'>
			<span>" . $snippet[0]->getUser()->getUserName() . "</span>
		</div>";
        
        $html .=    "</br><a onclick=\"javascript: return confirm('Vill du verkligen ta bort snippet?[" . $snippet[0]->getSnippetId() . "]')\" href='index.php?snippet=" . $snippet[0]->getSnippetId() . "&deleteSnippet=" . $snippet[0]->getSnippetId() . "'>Radera snippet</a>";     
                       
        $html .=    "</br><a onclick=\"javascript: return confirm('Vill du verkligen editera snippet?[" . $snippet[0]->getSnippetId() . "]')\" href='index.php?snippet=" . $snippet[0]->getSnippetId() . "&editSnippet=" . $snippet[0]->getSnippetId() . "'>Redigera snippet</a>";
        return $html;
    }



    public function addSnippet()
    {
        $view = '
			<div id="createSnippetContainer">
				<form action="" method="POST">
					<div id="createSnippetNameDiv">
                    
						<p>Title:</p>
						<input type="text" name="snippetTitle" id="createSnippetNameInput" />
                        
                        <p>Description:</p>
                        <input type="text" name="snippetDesc" id="createSnippetNameInput" />
                        
                        <p>Language:</p>
                        <input type="text" name="snippetLang" id="createSnippetNameInput" />
					</div>

					<div id="createSnippetCodeDiv">
						<p>Snippet:</p>
						<textarea cols="50" rows="20" name="snippetCode" id="createSnippetCodeInput"></textarea>
					</div>
                    
                    <div id="createSnippetAuthor">
						<p>Author:(siffran 6 så länge)</p>
						<input type="text" name="snippetAuthor" id="createSnippetAuthor" />
					</div>
                    
                    <input type="submit" name="submitSnippet" value="Submit snippet"/>
                    
				</form>
			</div>
		';
        return $view;
    }
    
    public function doSuccessView()
    {
        $view = "Snippet har tagits bort";
        return $view;
    }
    
    /**
     * SnippetView::getSnippetId()
     * 
     * @return Id of the actual snippet
     */
    public function getSnippetId()
    {
         if (isset($_GET["snippet"])) {
            return urldecode($_GET["snippet"]);
        }
        return false;
    }
    
    /**
     * SnippetView::triedToAddSnippet()
     * 
     * @return
     * when user wants to go to create view
     */
    public function triedCreateNewSnippetView()
    {
        if (isset($_POST['createNewSnippetView'])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * SnippetView::triedToCreateSnippet()
     * 
     * @return
     * when user wants to create a new snippet and add it to the db
     */
    public function triedToSubmitSnippet()
    {
        if (isset($_POST['submitSnippet'])) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getSnippetTitle()
    {
        if (isset($_POST['snippetTitle'])) {
            return trim($_POST['snippetTitle']);
        } else
            return false;
    }
    
    public function getSnippetDesc()
    {
        if (isset($_POST['snippetDesc'])) {
            return trim($_POST['snippetDesc']);
        } else
            return false;
    }
    
    public function getSnippetLanguage()
    {
        if (isset($_POST['snippetLang'])) {
            return trim($_POST['snippetLang']);
        } else
            return false;
    }
    
    public function getSnippetCode()
    {
        if (isset($_POST['snippetCode'])) {
            return trim($_POST['snippetCode']);
        } else
            return false;
    }
    
    public function getAuthorId()
    {
        if (isset($_POST['snippetAuthor'])) {
            return trim($_POST['snippetAuthor']);
        } else
            return false;
    }
    
    public function triesToRemoveSnippet()
    {
        if (isset($_GET["deleteSnippet"])) {
            return true;
        }
        return false;
    }
}
