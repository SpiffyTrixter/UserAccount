<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

//autoloader
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

//config
if (file_exists(__DIR__ . '/config/local.php')) {
    $config = require_once __DIR__ . '/config/local.php';
}

//cache
$cache = new FilesystemAdapter();

//doctrine
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

try {
    $entityManager = EntityManager::create($conn, $config);
} catch (ORMException|\Doctrine\ORM\ORMException $e) {
    echo $e->getMessage();
}
