#!/usr/bin/php
<?php
require_once 'Parser.php';
require_once 'Code.php';
require_once 'SymbolTable.php';

if (empty($argv[1])) {
  echo "No .asm file provided\n";
  exit;
}

try {

  $parser = new Parser($argv[1]);
  $parser->parseLine();
  while ($parser->hasMoreCommands()) {
      $parser->advance();
      $parser->parseLine();
  }

  // Finished parsing.
  $parser->output();

} catch(Exception $e) {
  echo $e->getMessage() . "\n";
}
