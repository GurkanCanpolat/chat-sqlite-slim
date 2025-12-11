<?php

require __DIR__ . '/../vendor/autoload.php';

// Convert deprecations to exceptions to surface their origin during tests
set_error_handler(function ($severity, $message, $file, $line) {
    if (($severity & (E_USER_DEPRECATED | E_DEPRECATED)) !== 0) {
        throw new \ErrorException($message, 0, $severity, $file, $line);
    }
    return false; // let normal PHP handler handle other errors
});
