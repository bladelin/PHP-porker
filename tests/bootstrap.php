<?php
spl_autoload_register(
    function ($class_name) {
        $pathPrefix = '../';
        $paths[] = $pathPrefix . 'class'.'/'. $class_name . '.php';
        $paths[] = './TestCases.php';

        foreach ($paths as $path) {
            if (file_exists($path)) {
                include_once $path;
                return;
            }
        }
    }
);
