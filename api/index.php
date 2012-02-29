<?php

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

require_once 'restler/restler.php';
require_once APPLICATION_PATH . '/controllers/snippets.php';
require_once APPLICATION_PATH . '/controllers/search.php';
require_once APPLICATION_PATH . '/controllers/build.php';
require_once APPLICATION_PATH . '/controllers/comments.php';
require_once APPLICATION_PATH . '/controllers/ratings.php';

spl_autoload_register('spl_autoload');

$r = new Restler();
$r->setSupportedFormats('JsonFormat', 'XmlFormat');
$r->addAPIClass('Snippets');
$r->addAPIClass('Search');
$r->addAPIClass('Build');
$r->addAPIClass('Comments');
$r->addAPIClass('Ratings');
$r->handle();

?>