<?php
/**
 * PLEASE NOTE - this code was copied from my dissertation, available at:
 *     https://github.com/ChrisBAshton/smartresolution
 */


// automatically load all external libraries (this file is generated by Composer)
require __DIR__ . '/../vendor/autoload.php';

// load our internal libraries too
require_all(__DIR__ . '/model');
require_all(__DIR__ . '/controller');

/**
 * Requires all of the files in a given directory, pulling in interfaces before classes
 * to remove dependency issues.
 *
 * @param  String $dir Directory to include
 */
function require_all($dir) {
    $files = glob($dir . '/*.php');

    $interfaces = array();
    $classes = array();

    foreach ($files as $file) {
        if (preg_match('/Interface\.php$/', $file)) {
            array_push($interfaces, $file);
        }
        else {
            array_push($classes, $file);
        }
    }

    foreach($interfaces as $interface) {
        require($interface);
    }

    foreach($classes as $class) {
        require($class);
    }
}
