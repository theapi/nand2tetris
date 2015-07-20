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

        $this->writeInit();
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
                $this->writeAdd();
                break;
            case 'sub':
                $this->writeSub();
                break;
            case 'neg':
                $this->writeNeg();
                break;
            case 'and':
                $this->writeAnd();
                break;
            case 'or':
                $this->writeOr();
                break;
            case 'not':
                $this->writeNot();
            case 'eq':
                $this->writeEq();
            case 'gt':
                $this->writeGt();
            case 'lt':
                $this->writeLt();
                break;
        }

        $this->write($asm);
    }

    public function writePushPop($command, $segment, $index)
    {

        if ($command == 'C_POP') {
            $this->writePop();
        }

        $asm = '';
        switch ($segment) {
            case 'constant':
                $asm .= '// constant' . "\n";
                $asm .= '@' . $index . "\n";
                $asm .= 'D=A   // Store the numeric value in D'. "\n\n";
                break;
        }
        $this->write($asm);

        if ($command == 'C_PUSH') {
            $this->writePush();
        }

    }

    public function close()
    {
        fclose($this->fp);
    }

    protected function writeInit()
    {
        $this->writeLine('// init to SP pointing to 256');
        $this->writeLine('@256');
        $this->writeLine('D=A');
        $this->writeLine('@SP');
        $this->writeLine('M=D');
        $this->writeLine("");
    }

    /**
     * x+y
     */
    protected function writeAdd()
    {
        $this->writeLine('//    add');
        // Get y
        $this->writePop();
        $this->writeLine('D=M    // the last entered value');
        // Get x
        $this->writePop();
        $this->writeLine('D=D+M  // x+y');
        $this->writePush();
    }

    /**
     * x-y
     */
    protected function writeSub()
    {
        $this->writeLine('//    sub');
        // Get y
        $this->writePop();
        $this->writeLine('D=M    // the last entered value');
        // Get x
        $this->writePop();
        $this->writeLine('D=M-D  // x-y');
        $this->writePush();
    }

    /**
     * -y
     */
    protected function writeNeg()
    {
        $this->writeLine('//    neg');
        // Get y
        $this->writePop();
        $this->writeLine('D=-D   // -y');
        $this->writePush();
    }

    /**
     * x AND y
     */
    protected function writeAnd()
    {
        $this->writeLine('//    and');
        // Get y
        $this->writePop();
        $this->writeLine('D=M    // the last entered value');
        // Get x
        $this->writePop();
        $this->writeLine('D=D&M  // x And y');
        $this->writePush();
    }

    /**
     * x Or y
     */
    protected function writeOr()
    {
        $this->writeLine('//    or');
        // Get y
        $this->writePop();
        $this->writeLine('D=M    // the last entered value');
        // Get x
        $this->writePop();
        $this->writeLine('D=D|M  // x Or y');
        $this->writePush();
    }

    /**
     * Not y
     */
    protected function writeNot()
    {
        $this->writeLine('//    not');
        // Get y
        $this->writePop();
        $this->writeLine('D=!D   // !y');
        $this->writePush();
    }

    /**
     * True if x = y, else false
     */
    protected function writeEq()
    {
        $this->writeLine('//    eq');
        // Get y
        $this->writePop();
        $this->writeLine('D=M    // y');
        // Get x
        $this->writePop();



        $this->writePush();
    }

    /**
     * True if x > y, else false
     */
    protected function writeGt()
    {
        $this->writeLine('//    gt');
        // Get y
        $this->writePop();
        $this->writeLine('D=M    // y');
        // Get x
        $this->writePop();



        $this->writePush();
    }

    /**
     * True if x < y, else false
     */
    protected function writeLt()
    {
        $this->writeLine('//    gt');
        // Get y
        $this->writePop();
        $this->writeLine('D=M    // y');
        // Get x
        $this->writePop();



        $this->writePush();
    }

    protected function writePop()
    {
        $asm = "// POP\n";
        $asm .= '@SP' . "\n";
        $asm .= 'M=M-1  // decrement (pop) the stack pointer' . "\n";
        $asm .= 'A=M    // set the address to where the SP is pointing' . "\n\n";
        $this->write($asm);
    }

    protected function writePush()
    {
        $asm = "// PUSH\n";
        $asm .= '@SP' . "\n";
        $asm .= 'A=M   // set the address to where the SP is pointing' . "\n";
        $asm .= 'M=D   // store the value in the stack' . "\n";
        $asm .= '@SP' . "\n";
        $asm .= 'M=M+1 // Advance the stack pointer' . "\n\n";
        $this->write($asm);
    }

    protected function writeLine($asm)
    {
        $this->write($asm . "\n");
    }

    protected function write($asm)
    {
        echo $asm;
        if (fwrite($this->fp, $asm) === FALSE) {
            throw new Exception('Unable to write to: ' . $this->file);
        }
    }
}
