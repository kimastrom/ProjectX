<?php

require_once 'restler/restler.php';
require_once 'application/models/snippets.php';

spl_autoload_register('spl_autoload');

$r = new Restler();
$r->setSupportedFormats('JsonFormat', 'XmlFormat');
$r->addAPIClass('Snippets');
$r->handle();

?>