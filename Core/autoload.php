<?php

spl_autoload_register(function ($class) {
    $sourcePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $class;
    $replaceDirectorySeparator = str_replace('\\', DIRECTORY_SEPARATOR, $sourcePath);
    $filePath = $replaceDirectorySeparator . '.php';
    if (file_exists($filePath)) {
        require($filePath);
    } else {
        throw new Exception("Unable to load class " . $class . " in $filePath", 500);
    }
});