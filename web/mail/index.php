<?php
require_once 'MasterController.php';

$_mc = new MasterController();
$_html = $_mc->doControll();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Snippt</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="ajax.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <?php echo $_html;?>
                
                <h2 id="snippet-title" class='snippet-title'>Snippet title</h2>
        		<div class='snippet-description'>
        			<p>Snippet description</p>	
        		</div>
        		<div class='snippet-code'>
        			<code class="snippet-text">snippet code, snippet code, snippet code</code>
        		</div>
        		<div class='snippet-author'>
        			<span>snippet author</span>
        		</div>
                
                <a href='?page=mail'>Skicka snippet via mail</a>
                
            </div>
        </div>
    </body>
</html>
