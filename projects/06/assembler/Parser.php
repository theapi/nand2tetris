<?php

class Parser
{

  // The lines of the .asm file, with empty lines skipped & newlines removed.
  protected $commands = array();

  protected $parsed = array();

  protected $hack_file = '';

  // The command being parsed.
  protected $current_command = 0;

  protected $last_command = 0;

  // The SymbolTable
  protected $symbols;

  public function __construct($file)
  {
    // Read the file and ignore empty lines.
    if (!$this->commands = file($file, FILE_USE_INCLUDE_PATH | FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)) {
      throw new Exception("Failed to read file: $file\n");
    }
    $this->hack_file = str_replace('.asm', '.hack', $file);

    $this->removeWhitespace();
    $this->last_command = count($this->commands) - 1;

    $this->symbols = new SymbolTable();
    // First pass get all the labels (LOOP) etc.
    $this->parseLcommands();
  }

  /**
   * Remove comments & whitespace.
   */
  protected function removeWhitespace()
  {
    $remove = array();
    foreach ($this->commands as $i => $line) {
      $line = trim($line);
      // Store the trimmed line.
      $this->commands[$i] = $line;

      $pos = strpos($line, '/');
      if ($pos !== false) {
        $cmd = substr($line, 0, $pos);
        $cmd = trim($cmd);
        // Store the trimmed line.
        $this->commands[$i] = $cmd;
        if (empty($cmd)) {
          // now an empty line so remove it.
          $remove[] = $i;
        }
      }
    }

    foreach ($remove as $i) {
      unset($this->commands[$i]);
    }

    // Renumber the index, so the program counter knows what's what.
    $this->commands = array_merge($this->commands, array());

  }

  protected function parseLcommands()
  {
      $this->current_command = 0;

      while ($this->hasMoreCommands()) {
          if ($this->commandType() == 'L_COMMAND') {
              $this->parseLcommand();
          }
          $this->advance();
      }

      $this->current_command = 0;
  }

  public function output()
  {
      file_put_contents($this->hack_file, $this->parsed);
  }

  public function parseLine()
  {
    $type = $this->commandType();
    switch ($type) {
      case 'A_COMMAND':
        $this->parsed[] = $this->parseAcommand() . "\n";
        break;

      case 'C_COMMAND':
        $this->parsed[] = $this->parseCcommand() . "\n";
        break;

      default:
        // Shouldn't get here. throw error error?
        return;
    }

  }

  protected function parseAcommand()
  {
    return sprintf( "%016d", decbin($this->symbol()));
  }

  protected function parseCcommand()
  {
    $dest = Code::dest($this->dest());
    $comp = Code::comp($this->comp());
    $jump = Code::jump($this->jump());
    return '111' . $comp . $dest . $jump;
  }

  protected function parseLcommand()
  {
      $cmd = $this->commands[$this->current_command];

      $pos = strpos($cmd, ')');
      if ($pos === false) {
          throw new Exception("Syntax error: expected ) in $cmd, line " . __LINE__);
      }
      $symbol = substr($cmd, 1, $pos - 1);
      if ($this->symbols->contains($symbol)) {
        throw new Exception("Label already exists $symbol, line " . __LINE__);
      }

      $address = $this->current_command;
      $this->symbols->addEntry($symbol, $address);

      // Remove the label pseudo command & renumber the commands.
      unset($this->commands[$this->current_command]);
      $this->commands = array_merge($this->commands, array());

      // Reduce the current command number as this wasn't really a command.
      $this->current_command--;
      $this->last_command--;
  }

  /**
   * Are there any more commands in the input?
   */
  public function hasMoreCommands()
  {
    if ($this->current_command == $this->last_command) {
      return false;
    }
    return true;
  }

  /**
   * Read the next command and make it current.
   */
  public function advance()
  {
    $this->current_command++;
  }

  /**
   * A, C or "L" command.
   */
  public function commandType()
  {
    $cmd = $this->commands[$this->current_command];
    // All commands have already been trimed.
    switch ($cmd[0]) {
      case '@':
        return 'A_COMMAND';
        break;

      case '(':
        return 'L_COMMAND';
        break;

      default:
        return 'C_COMMAND';
        break;
    }
  }

  /**
   * The value of the A command.
   */
  public function symbol()
  {
    $cmd = $this->commands[$this->current_command];
    // remove the @ as the first character.
    $symbol = substr($cmd, 1);
    if (is_numeric($symbol)) {
        // Already an address.
        return $symbol;
    }

    if ($this->symbols->contains($symbol)) {
        return $this->symbols->getAddress($symbol);
    }

    return $this->symbols->addEntry($symbol);
  }


  protected function deconstructCcommand($part)
  {
    $cmd = $this->commands[$this->current_command];
    $parts = explode('=', $cmd);
    if ($part == 'dest') {
      return trim($parts[0]);
    }

    $comp = isset($parts[1]) ? $parts[1] : $parts[0];
    $sub_parts = explode(';', $comp);
    if ($part == 'comp') {
      return trim($sub_parts[0]);
    }
    if ($part == 'jump') {
      if (isset($sub_parts[1])) {
        return trim($sub_parts[1]);
      }
    }

    return 'null';
  }


  /**
   * The destination mnemonic (MD etc).
   */
  public function dest()
  {
    return $this->deconstructCcommand('dest');
  }

  /**
   * The comp mnemonic (D=M etc).
   */
  public function comp()
  {
    return $this->deconstructCcommand('comp');
  }

    /**
   * The jump mnemonic (JMP etc).
   */
  public function jump()
  {
    return $this->deconstructCcommand('jump');
  }

}

