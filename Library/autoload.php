<?php
require_once 'helpers.php';

spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)){
        require_once  $file;
    } else {
        print "$file doesn't exist";
    }
});

\Library\Container::init();
