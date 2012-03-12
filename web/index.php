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
        <script type="text/javascript" src="content/js/janrain-engage.js"></script>
        <script type="text/javascript" src="content/js/tinymce/tiny_mce.js" ></script>
        <script type="text/javascript" src="content/js/tinymce/tinymce_init.js" ></script>
        <script type="text/javascript" src="content/js/alert.js"></script>
    </head>
    <body>
        <?php echo $_mc->doHeader();?>
        <div class="container">
            <div class="content">
                <?php echo $_html;?>
            </div>
        </div>
      <!--
        <div id="learn-more-wrap">
        	<h2>Snippets at hand</h2>
        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
		<script type="text/javascript" src="content/js/lib/mootools-core.js"></script>
		<script type="text/javascript" src="content/js/lib/mootools-slide.js"></script>
		<script type="text/javascript" src="content/js/learn-more.js"></script>-->
    </body>
</html>
