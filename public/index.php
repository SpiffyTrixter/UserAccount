<?php

if (file_exists(__DIR__ . '/../bootstrap.php')) {
    require_once __DIR__ . '/../bootstrap.php';
}

$uri = $_SERVER['REQUEST_URI'];
$uriParts = explode('/', $uri);
$page = $uriParts[1];
$step = explode('?', $uriParts[2])[0];

require_once __DIR__ . "/page/$page.php";

include __DIR__ . '/view/index.phtml';
