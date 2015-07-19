<?php
require_once 'CodeWriter.php';

class Parser
{

    // The command being parsed.
    protected $cmd;

    // File pointer to the current .vm file.
    protected $fp;

    public function __construct($file)
    {
        // Open the first file for reading.
        if (!$this->fp = fopen($file, "r")) {
            throw new Exception("unable to open input file: $file.");
        }
    }

    /**
     * Are there any more commands in the input?
     */
    public function hasMoreCommands()
    {
        return !feof($this->fp);
    }

    /**
     * Read the next command and make it current.
     */
    public function advance()
    {
        $this->cmd = fgets($this->fp);
        $this->removeWhitespace();
    }

    /**
     *
     */
    public function commandType()
    {
        if (empty($this->cmd)) {
            return null;
        }

        $pos = strpos($this->cmd, ' ');
        if ($pos !== false) {
            $type = substr($this->cmd, 0, $pos);
        } else {
            $type = $this->cmd;
        }

        switch ($type) {
            case 'add':
            case 'sub':
            case 'neg':
            case 'eq':
            case 'gt':
            case 'lt':
            case 'and':
            case 'or':
            case 'not':
                return 'C_ARITHMETIC';
            case 'push':
                return 'C_PUSH';
            case 'pop':
                return 'C_POP';
            case 'pop':
                return 'C_POP';
            case 'label':
                return 'C_LABEL';
            case 'goto':
                return 'C_GOTO';
            case 'if':
                return 'C_IF';
            case 'function':
                return 'C_FUNCTION';
            case 'return':
                return 'C_RETURN';
            case 'call':
                return 'C_CALL';
            default:
                return null;
        }

    }

    /**
     * Remove comments & whitespace.
     */
    protected function removeWhitespace()
    {
        $this->cmd = trim($this->cmd);
        $pos = strpos($this->cmd, '/');
        if ($pos !== false) {
            $this->cmd = substr($this->cmd, 0, $pos);
            $this->cmd = trim($this->cmd);
        }
        // Replace multiple spaces with single ones.
        $this->cmd = preg_replace('|\s+|', ' ', $this->cmd);
    }

    /**
     * The first argument of the current command.
     */
    public function arg1()
    {
        $parts = explode(' ', $this->cmd);
        if (count($parts) == 1) {
            return $parts[0];
        }

        return $parts[1];
    }

    /**
     * The second argument of the current command.
     *
     * Should be called only if the current command is:
     *  C_PUSH
     *  C_POP
     *  C_FUNCTION
     *  C_CALL
     */
    public function arg2()
    {
        $parts = explode(' ', $this->cmd);
        return $parts[2];
    }

}

