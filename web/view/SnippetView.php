<?php
require_once dirname(__FILE__) . '/../model/Functions.php';

class SnippetView
{
    /**
     * return html code for a single snippet
     * @param Snippet a snippet Object
     * @return String
     */
    public function singleView($snippet)
    {
        $sh = new Functions();
        
        $html = "<h2 class='snippet-title'>" . $snippet->getTitle() . "</h2>
		<div class='snippet-description'>
			<p>" . $snippet->getDesc() . "</p>	
		</div>
		<div class='snippet-code'>
			<code>" . $sh->geshiHighlight($snippet->getCode(), $snippet->getLanguage()) . "</code>
		</div>
		<div class='snippet-author'>
			<span>Posted by " . $snippet->getAuthor();
        
        var_dump($snippet);
        
		if (AuthHandler::isLoggedIn() && $snippet->getAuthorID() === 2) {
		    $html .= "<a onclick=\"javascript: return confirm('Do you want to remove this snippet?')\" href='?page=removesnippet&snippet=" . $snippet->getID() . "'>Delete</a> 
		    <a href='?page=updatesnippet&snippet=" . $snippet->getID() . "'>Update</a>";
        }
		
		$html .= "</span>
	          </div>";
        
        return $html;
    }

    /**
     * Transform an array of snippets to html-code
     * @param array $aSnippets is an array of snippets
     * @return string
     */
    public function listView($snippets, $previousLink, $links, $beforeLinks, $afterLinks, $nextLink, $showPrevious, $showNext)
    {
        $html = '<h1>Snippets</h1>';

        foreach ($snippets as $snippet) {
            $html .= '
                <div class="snippet-list-item">
                    <div class="snippet-title">
                        <p><a href="?page=listsnippets&snippet=' . $snippet->getID() . '">' . $snippet->getTitle() . '</a></p>
                    </div>
                    <div class="snippet-author">
                        <p>' . $snippet->getDesc() . '</p>
                    </div>
                </div>
            ';
        }

        if ($showPrevious == true) {
            if($_GET['pagenumber'] != 2) {
                $html .= ' | <a href="?page=listsnippets&pagenumber=1">First</a> ';    
            }
            
            $html .= ' | <a href="?page=listsnippets&pagenumber=' . $previousLink . '"><</a> | ';
        }
        if (isset($_GET['pagenumber'])) {
            foreach ($beforeLinks as $i) {
                if ($i > 0) {
                    $html .= '<a href="?page=listsnippets&pagenumber=' . $i . '">' . $i . '</a> ';    
                }
            }

            foreach ($links as $i) {
                if ($i == $_GET['pagenumber']) {

                    $html .= '<a href="?page=listsnippets&pagenumber=' . $i . '"><span id="activePage">' . $i . '</span></a> ';
                }
            }

            foreach ($afterLinks as $i) {
                if ($i < (count($links) + 1 )) {
                    $html .= '<a href="?page=listsnippets&pagenumber=' . $i . '">' . $i . '</a> ';    
                }
            }
        }
        
        if ($showNext == true) {
            $html .= ' | <a href="?page=listsnippets&pagenumber=' . $nextLink . '">></a> ';
            
            if ($_GET['pagenumber'] != (count($links) - 1)) {
                $html .= ' | <a href="?page=listsnippets&pagenumber=' . count($links). '">Last</a> | ';
            }    
        }
        
        return $html;
    }

    public function createSnippet($languages)
    {
        $html = '<h1>Add a new snippet</h1>
            <div id="createSnippetContainer">
                <form action="" method="post">
                    <input type="text" name="snippetTitle" placeholder="Title" />
                    <input type="text" name="snippetDescription" placeholder="Description" />
                    <select name="snippetLanguage">
                        <option>Choose language</option>';
        foreach ($languages as &$languages) {
            $html .= '<option value="' . $languages['id'] . '">' . $languages['name'] . '</option>';
        }
        $html .= '</select>
                    <textarea name="createSnippetCodeInput" maxlength="1500" placeholder="Your snippet"></textarea>
                    <input type="submit" name="createSnippetSaveButton" id="createSnippetSaveButton" value="Create snippet" />
                </form>
            </div>
        ';
        return $html;
    }

    public function updateSnippet($snippet)
    {
        $html = '<h1>Update the snippet "' . $snippet->getTitle() . '"</h1>
            <div id="createSnippetContainer">
                <form action="" method="post">
                    <input type="text" name="updateSnippetTitle" placeholder="Title" value="' . $snippet->getTitle() . '" />
                    <input type="text" name="updateSnippetDescription" placeholder="Description" value="' . $snippet->getDesc() . '"  />
                    <textarea name="updateSnippetCodeInput" maxlength="1500" placeholder="Your snippet">' . $snippet->getCode() . '</textarea>
                    <input type="submit" name="updateSnippetUpdateButton" id="updateSnippetUpdateButton" value="Update snippet" />
                </form>
            </div>';
            
        return $html;
    }
    

    /**
     * Creates HTML for voting with jquery ajax
     * @param int $snippet_id, array $rating with total, likes and dislikes
     * @return string
     */
    public function rateSnippet($snippet_id, $user_id,$rating) {
        $html = '<div id="rating">
                    <button name="like" type="button" id="like"><img src="content/image/like.png" title="Like!" /></button>
                    <button name="dislike" type="button" id="dislike"><img src="content/image/dislike.png" title="Dislike!" /></button>
                
                    <div id="ratingbars">
                        <div class="likes" style="width: ' . ($rating['total'] != 0 ? round($rating['likes'] / $rating['total'] * 100) : 0) . '%"></div>
                        <div class="dislikes" style="width: ' . ($rating['total'] != 0 ? round($rating['dislikes'] / $rating['total'] * 100) : 0) . '%"></div>
                    </div>
                    <p>' . $rating['likes'] . ' likes, ' . $rating['dislikes'] . ' dislikes</p>
                    <div id="message"></div>
                </div>';
        $html .= "<script>
                    $('#like').click(function(){
                         $.ajax({ type: 'POST',
                            url: 'model/RateSnippet.php',
                            data: {
                                'snippet_id': " . $snippet_id . ",
                                'user_id': ". $user_id .",
                                rating: 1
                            },
                            dataType: 'html',
                            success: function(data) {
                                $('#message').html(data);
                            }
                        });
                    });
                    $('#dislike').click(function(){
                        $.ajax({ type: 'POST',
                            url: 'model/RateSnippet.php',
                            data: {
                                'snippet_id': " . $snippet_id . ",
                                'user_id': ". $user_id .",
                                rating: 0
                            },
                            dataType: 'html',
                            success: function(data) {
                                $('#message').html(data);
                            }
                        });
                    });
                </script>";
                
        return $html;
    }

    public function triedToCreateSnippet()
    {
        if (isset($_POST['createSnippetSaveButton'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getCreateSnippetName()
    {
        $snippetName = $_POST['createSnippetNameInput'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getSnippetTitle()
    {
        $snippetName = $_POST['snippetTitle'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getSnippetDescription()
    {
        $snippetName = $_POST['snippetDescription'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getSnippetLanguage()
    {
        $snippetName = $_POST['snippetLanguage'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
        return false;
    }

    public function getCreateSnippetCode()
    {
        $snippetCode = $_POST['createSnippetCodeInput'];
        if ($snippetCode == null) {
            return null;
        } else {
            return $snippetCode;
        }
        return false;
    }

    public function triedToUpdateSnippet()
    {
        if (isset($_POST['updateSnippetUpdateButton'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getSnippetIDLink()
    {
        $snippetID = $_GET['chsnippet'];
        if ($snippetID == null) {
            return null;
        } else {
            return $snippetID;
        }
        return false;
    }

    public function getUpdateSnippetName()
    {
        $snippetName = $_POST['updateSnippetTitle'];
        if ($snippetName == null) {
            return null;
        } else {
            return $snippetName;
        }
    }

    public function getUpdateSnippetCode()
    {
        $snippetCode = $_POST['updateSnippetCodeInput'];
        if ($snippetCode == null) {
            return null;
        } else {
            return $snippetCode;
        }
        return false;
    }
    
    public function getUpdateSnippetDesc() {
        $snippetDesc = $_POST['updateSnippetDescription'];
        if ($snippetDesc == null) {
            return null;
        } else {
            return $snippetDesc;
        }
        return false;
    }
    
    public function getUpdateSnippetID()
    {
        $snippetID = $_POST['updateSnippetID'];
        if ($snippetID == null) {
            return null;
        } else {
            return $snippetID;
        }
    }

    public function triedToDeleteSnippet()
    {
        if (isset($_POST['deleteSnippetButton'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getSnippetID()
    {
        $snippetID = $_POST['snippetID'];
        if ($snippetID == null) {
            return null;
        } else {
            return $snippetID;
        }
        return false;
    }

    public function triedToGotoCreateView()
    {
        if (isset($_POST['gotoCreateSnippetViewButton'])) {
            return true;
        } else {
            return false;
        }
    }

}
