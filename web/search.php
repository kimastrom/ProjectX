<?php
require_once 'controller/MasterController.php';
require_once 'model/AuthHandler.php';

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
    </head>
    <body>
        <?php echo $_mc->doHeader();?>
        <div class="container">
            <div class="content">
                <?php echo $_html;?>
            </div>
        </div>
    </body>
</html>