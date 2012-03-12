<?php
require_once 'API.php';
require_once 'Snippet.php';

$api = new API();
$snippets = null;
$html = "";

$query = $_GET['query'];
$url = $api->GetURL() . "search/" . $query . "*";

if ($json = json_decode(@file_get_contents($url))) {
    foreach($json as $j)
    {
        $snippets[] = new Snippet($j->userid, $j->username, $j->code, $j->title, $j->description, $j->languageid, $j->date, $j->updated, $j->id, $j->language);
    }
    
    foreach ($snippets as $snippet) {
        $html .= '
            <div class="snippet-list-item">
                <div class="snippet-title">
                    <h3><a href="?page=listsnippets&snippet=' . $snippet->getID() . '">' . $snippet->getTitle() . '</a></h3>
                </div>
                <div class="snippet-description">
                    <p>' . $snippet->getDesc() . '</p>
                </div>
                <div class="snippet-author">
                    <p>Posted by: <i>' . $snippet->getAuthor() . '</i></p>
                </div>
            </div>
        ';
    }
    
    echo $html;
} else {
    echo "<p>No results</p>";
}