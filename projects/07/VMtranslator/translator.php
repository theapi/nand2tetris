#!/usr/bin/php
<?php
require_once 'VMtranslator.php';

if (empty($argv[1])) {
    echo "No file nor directory provided\n";
    exit();
}

try {

    $translator = new VMtranslator($argv[1]);
    $translator->run();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
