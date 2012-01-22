<?php

class SearchView {
    
    public function doSearchForm($langs) {
            $searchForm =       '<div class="search">
                                    <form name="searchForm" action"" method="POST">
                                    <img src="content/image/logo.png" />
                                    <input type="text" name="q" />';
                $searchForm .=      '<select class="langDropdown" id="lang" name="lang">';
                            		foreach($langs as $lang)
                            		{
                                        $searchForm .= "<option value='".$lang->getLangId()."'>".$lang->getLanguage()."</option>";
                            		}
                $searchForm .=      '</select>';     
                $searchForm .=      '<input type="submit" name="submitSearch" value="Search" class="searchbutton" /><br />
                                    </form>
                                    <a href="#">Advanced search</a> &bull; <a href="#">Browse</a>
                                </div>';
            return $searchForm;
    }
    
    public function searchAnswerView($snippets) {
        $html = '';

        foreach ($snippets as $snippet) {
            $html .= '
                <div class="snippet-list-item">
                    <div class="snippet-title">
                        <h3><a href="?snippet=' . $snippet->getID() . '">' . $snippet->getTitle() . '</a></h3>
                    </div>
                    <div class="snippet-description">
                        <p>' . $snippet->getDesc() . '</p>
                    </div>
                    <div class="snippet-author">
                        <p>Posted by: <i>' . $snippet->getAuthor() . '</i></p>
                    </div>
                </div>
            ';
        }return $html;
    }
    
    /**
     * SearchView::doSearchLink()
     * 
     * @return html
     * if the user cklick on the serchLink we know that he want to use our search function
     */
    public function doSearchLink() {
        return $link = "<br /><a href='?page=search'>Search</a>";
    }
    
    public function getSearchQuery() {
        if (isset($_POST['q'])) {
            return trim($_POST['q']);
        } return false;
    }
    
    public function getSearchLang() {
        if (isset($_POST['lang'])) {
            return trim($_POST['lang']);
        } return false;
    }
    
    public function doSearch() {
        if (isset($_POST['submitSearch'])) {
            return true;
        } else {
            return false;
        }
    }

}
