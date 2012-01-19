<?php

require_once 'controller/MasterController.php';

$_mc = new MasterController();
$_html = $_mc->doControll();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Snippt</title>
        <link rel="stylesheet" href="content/css/reset.css">
        <link rel="stylesheet" href="content/css/style.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="topbar-wrapper">
            <div class="topbar">
                <div class="topbar-inner">
                    <ul class="nav">
                        <li>
                            <a href="index.php">Home</a> /
                        </li>
                        <li>
                            <a href="?page=listsnippets">Snippets</a> /
                        </li>
                        <li>
                        <a href='?page=addsnippet'>Add snippet</a> /
                        </li>
                        <li>
                            <a href="#">News</a> /
                        </li>
                        <li>
                            <a href="#">Downloads</a> /
                        </li>
                        <li>
                            <a href="#">About</a> /
                        </li>
                        <li>
                            <a href="#">Register</a>
                        </li>
                        <li class="right">
                            <a href="#">Log in</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="content">
                <?php echo $_html;?>
            </div>
        </div>
    </body>
</html>