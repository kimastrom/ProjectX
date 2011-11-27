<?php

require_once 'controller/MasterController.php';

$mc = new MasterController();
$html = $mc->doControll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>title</title>
<link rel="stylesheet" href="style.css">
<script src="script.js"></script>
</head>
<body>
<?php echo $html;?>
</body>
</html>