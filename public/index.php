<?php
require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../config/define.local.php')) {
    require __DIR__ . '/../config/define.local.php';
} else {
    require __DIR__ . '/../config/define.php';
}

use \Slim\App;

$application = new App(require __DIR__ . '/../config/app.php');

require __DIR__ . '/../src/dependencies.php';
require __DIR__ . '/../src/routes.php';

$application->run();
