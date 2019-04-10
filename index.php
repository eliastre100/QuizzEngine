<?php

require_once 'Core/autoload.php';

use Core\Kernel;

session_start();

define('DR', DIRECTORY_SEPARATOR);

    $kernel = new Kernel();

try {
    register_shutdown_function( "fatal_error_handler", $kernel);

    foreach (glob(__DIR__.DR.'App'.DR.'Config'.DR."*.php") as $filename)
    {
        include_once $filename;
    }
    $kernel->resolve();

    $kernel->processBeforeActions();

    $kernel->process();

    $kernel->processAfterActions();

    $kernel->respond();

} catch (Exception $e) {
    $kernel->error($e->getCode(), $e->getFile().'#'.$e->getLine().': '. $e->getMessage() . '<br /><pre>'.$e->getTraceAsString().'</pre>');
}

function fatal_error_handler(Kernel $kernel) {
    $error = error_get_last();
    if ($error != null && $error['type'] == E_ERROR) {
        $kernel->error(500, '<pre>'.$error['file'].'#'.$error['line'].': '. $error['message'].'</pre>');
    }
}
