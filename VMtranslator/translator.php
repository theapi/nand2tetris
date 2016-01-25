#!/usr/bin/php
<?php
require_once 'VMtranslator.php';

if (empty($argv[1])) {
    echo "No file nor directory provided\n";
    exit();
}

if (!empty($argv[2]) && $argv[2] == '--no-init') {
    $init = FALSE;
} else {
    $init = TRUE;
}

try {

    $translator = new VMtranslator($argv[1], $init);
    $translator->run();
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
