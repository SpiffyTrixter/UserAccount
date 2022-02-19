<?php

if (file_exists(__DIR__ . '/../bootstrap.php')) {
    require_once __DIR__ . '/../bootstrap.php';
}

$hello = new \Skeleton\Hello();
echo $hello->sayHello();
