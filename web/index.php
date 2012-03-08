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
<!--
        <link rel="stylesheet" href="content/css/style.css">
-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript" src="content/js/janrain-engage.js"></script>
        
        
        
        <!-- Disable phone number linking -->
		<meta name="format-detection" content="telephone=no" />     
        
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
        
		<link rel="stylesheet" href="content/css/styleFinal.css" media="all" />
        
        
        
    </head>
    <body>
        <div id="wrapper">
            <?php echo $_mc->doHeader();?>
            <div class="content">
                <?php echo $_html;?>
            </div>
            <footer>copy right goes here</footer>
        </div>
    </body>
</html>