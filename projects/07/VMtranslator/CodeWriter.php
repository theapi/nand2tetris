<?php

class CodeWriter
{
    protected $file;

    protected $filename;

    // File pointer to the output .asm file.
    protected $fp;

    public function __construct($file)
    {
        $this->file = $file;
        // Open the file for writing.
        if (!$this->fp = fopen($file, "w")) {
            throw new Exception("unable to open input file: $file.");
        }
    }

    public function setFileName($filename)
    {
        $this->filename = $filename;
    }

    public function writeArithmatic($command)
    {
        $asm = '';
        switch ($command) {
            case 'add':
                $this->writePushPop('C_POP', null, null);
                $this->write('D=M    // the last entered value' . "\n");
                $this->writePushPop('C_POP', null, null);
                $this->write('D=D+M  // add the value to the pervious one' . "\n");
                $this->writePushPop('C_PUSH', null, null);
                break;
        }

        $this->write($asm);
    }

    public function writePushPop($command, $segment, $index)
    {
        $asm = '';

        if ($command == 'C_POP') {
            $asm .= "// POP\n";
            $asm .= '@SP' . "\n";
            $asm .= 'M=M-1  // decrement (pop) the stack pointer' . "\n";
            $asm .= 'A=M    // set the address to where the SP is pointing' . "\n\n";
        }

        switch ($segment) {
            case 'constant':
                $asm .= '// constant' . "\n";
                $asm .= '@' . $index . "\n";
                $asm .= 'D=A   // Store the numeric value in D'. "\n\n";
                break;
        }

        if ($command == 'C_PUSH') {
            $asm .= "// PUSH\n";
            $asm .= '@SP' . "\n";
            $asm .= 'A=M   // set the address to where the SP is pointing' . "\n";
            $asm .= 'M=D   // store the value in the stack' . "\n";
            $asm .= '@SP' . "\n";
            $asm .= 'M=M+1 // Advance the stack pointer' . "\n\n";
        }

        $this->write($asm);
    }

    public function close()
    {
        fclose($this->fp);
    }

    protected function write($asm)
    {
        //echo $asm;
        if (fwrite($this->fp, $asm) === FALSE) {
            throw new Exception('Unable to write to: ' . $this->file);
        }
    }
}
