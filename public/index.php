<?php
try {
    /**
     * Composer autoload.
     */
    require __DIR__ . '/../vendor/autoload.php';
    /**
     * Bootstrap application
     */
    include '../src/Bootstrap.php';
} catch (\Exception $e) {
    echo $e->getMessage();
}
