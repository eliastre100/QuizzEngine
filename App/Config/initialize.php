<?php

use Core\MVC\Database;
use Core\Kernel;

Database::connect([
    'host' => '127.0.0.1',
    'port' => 3306,
    'username' => 'user',
    'password' => 'password',
    'database' => 'project'
]);

Kernel::registerService('flash', new \App\Services\FlashService());
Kernel::registerBeforeAction('flash', 'retrieveLastFlash');
Kernel::registerAfterAction('flash', 'saveFlash');

$securityService = new \App\Services\SecurityService();
Kernel::registerService('security', $securityService);
Kernel::registerBeforeAction('security', 'loadUser');
Kernel::registerBeforeAction('security', 'protectRoute');