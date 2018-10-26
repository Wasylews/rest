<?php

/**
 * Config file for doctrine console tool
*/

require_once __DIR__.'/vendor/autoload.php';

$app = new \App\Bootstrap\Application();
$app->bootstrap();
$entityManager = $app->getContainer()->get(\Doctrine\ORM\EntityManager::class);

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);