<?php

class CodeWriter
{
    protected $file;

    protected $filename;

    // File pointer to the output .asm file.
    protected $fp;

    // Autogenerated labels get unique numbers.
    protected $label_num = 0;

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
                break;
            case 'eq':
                $this->writeEq();
                break;
            case 'gt':
                $this->writeGt();
                break;
            case 'lt':
                $this->writeLt();
                break;
        }

        $this->write($asm);
    }

    public function writePushPop($command, $segment, $index)
    {
        switch ($segment) {
            case 'constant':
                $this->writePushPopConstant($command, $index);
                break;
            case 'local':
                $this->writePushPopLocal($command, $index);
                break;
            case 'argument':
                $this->writePushPopArgument($command, $index);
                break;
            case 'this':
                $this->writePushPopThis($command, $index);
                break;
            case 'that':
                $this->writePushPopThat($command, $index);
                break;
            case 'temp':
                $this->writePushPopTemp($command, $index);
                break;
            case 'pointer':
                $this->writePushPopPointer($command, $index);
                break;
        }
    }

    public function close()
    {
        fclose($this->fp);
    }

    protected function writeInit()
    {
        // set the same memory locations as BasicTestVME.tst
        $this->writeLine('// init SP pointing to 256');
        $this->writeLine('@256');
        $this->writeLine('D=A');
        $this->writeLine('@SP');
        $this->writeLine('M=D');
        $this->writeLine("");

        $this->writeLine('// init LCL pointing to 300');
        $this->writeLine('@300');
        $this->writeLine('D=A');
        $this->writeLine('@LCL');
        $this->writeLine('M=D');
        $this->writeLine("");

        $this->writeLine('// init ARG pointing to 400');
        $this->writeLine('@400');
        $this->writeLine('D=A');
        $this->writeLine('@ARG');
        $this->writeLine('M=D');
        $this->writeLine("");

        $this->writeLine('// init THIS pointing to 3000');
        $this->writeLine('@3000');
        $this->writeLine('D=A');
        $this->writeLine('@THIS');
        $this->writeLine('M=D');
        $this->writeLine("");

        $this->writeLine('// init THAT pointing to 3010');
        $this->writeLine('@3010');
        $this->writeLine('D=A');
        $this->writeLine('@THAT');
        $this->writeLine('M=D');
        $this->writeLine("");
    }

    /**
     * push constant index
     */
    protected function writePushPopConstant($command, $index)
    {
        if ($command == 'C_PUSH') {
            $this->writeLine('// constant');
            $this->writeLine('@' . $index);
            $this->writeLine('D=A   // Store the numeric value in D');
            $this->writeLine("");
            $this->writePush();
        }
        // There is no pop constant.
    }

    /**
     * Pop the top of the stack & store it in segment[index]
     */
    protected function writePopSegment($label, $index)
    {
        if ($index == 0) {
            // No need to waste cycles looking for base + index address.
            $this->writePop();
            // M now countains what was popped off the stack.
            $this->writeLine('D=M   // store popped value in D');
            $this->writeLine("@$label   // set address to $label");
            $this->writeLine("A=M   // use the value stored in $label as the next address");
            $this->writeLine('M=D   // store the value at the address');
        } else {
            // Find where to store the value.
            $this->writeLine('@' . $index);
            $this->writeLine('D=A    // Store the index value in D');
            $this->writeLine("@$label   // set address to $label");
            $this->writeLine("D=D+M  // store the address stored in $label + index in D");

            $this->writeLine('@R13  // temp store the address');
            $this->writeLine('M=D   // store the address in R13');

            $this->writePop();
            // M now countains what was popped off the stack.
            $this->writeLine('D=M   // store the value in D');

            $this->writeLine('@R13  // R13 address');
            $this->writeLine('A=M   // use the value stored in R13 as the next address');
            $this->writeLine('M=D   // store the value at the address');
        }
        $this->writeLine("");
    }

    /**
     * Push the value of segment[index] onto the stack
     */
    protected function writePushSegment($label, $index)
    {
        // Find where the value is stored.
        $this->writeLine('@' . $index);
        $this->writeLine('D=A       // Store the index value in D');
        $this->writeLine("@$label   // set address to $label");
        $this->writeLine("A=D+M     // set the address to be $label + index");
        $this->writeLine('D=M       // store the push value in D');
        $this->writePush();
    }

    /**
     * push/pop local
     */
    protected function writePushPopLocal($command, $index)
    {
        $this->writeLine('// local');
        if ($command == 'C_PUSH') {
            $this->writePushSegment('LCL', $index);
        } else {
            $this->writePopSegment('LCL', $index);
        }
    }

    /**
     * push/pop argument
     */
    protected function writePushPopArgument($command, $index)
    {
        $this->writeLine('// argument');
        if ($command == 'C_PUSH') {
            $this->writePushSegment('ARG', $index);
        } else {
            $this->writePopSegment('ARG', $index);
        }
    }

    /**
     * push/pop this
     */
    protected function writePushPopThis($command, $index)
    {
        $this->writeLine('// this');
        if ($command == 'C_PUSH') {
            $this->writePushSegment('THIS', $index);
        } else {
            $this->writePopSegment('THIS', $index);
        }
    }

    /**
     * push/pop that
     */
    protected function writePushPopThat($command, $index)
    {
        $this->writeLine('// that');
        if ($command == 'C_PUSH') {
            $this->writePushSegment('THAT', $index);
        } else {
            $this->writePopSegment('THAT', $index);
        }
    }

    /**
     * NB this code is slightly different to writePushSegment
     * in that it directly using the temp registries
     * rather than the registries pointing to the addresses.
     */
    protected function writePushPopSegmentDirect($label, $command, $index)
    {
        $this->writeLine('// segment direct');
        if ($command == 'C_PUSH') {
            // Find where the value is stored.
            $this->writeLine('@' . $index);
            $this->writeLine('D=A       // Store the index value in D');
            $this->writeLine("@$label   // set address to $label");
            $this->writeLine("A=D+A     // set the address to be address of $label + index");
            $this->writeLine('D=M       // store the push value in D');
            $this->writePush();
        } else {
            if ($index == 0) {
                $this->writePop();
                // M now countains what was popped off the stack.
                $this->writeLine('D=M   // store popped value in D');
                $this->writeLine("@$label   // set address to $label");
                $this->writeLine('M=D   // store the value at the address');
            } else {
                // Find where to store the value.
                $this->writeLine('@' . $index);
                $this->writeLine('D=A    // Store the index value in D');
                $this->writeLine("@$label   // set address to $label");
                $this->writeLine("D=D+A  // store the address of $label + index in D");

                $this->writeLine('@R13  // temp store the address');
                $this->writeLine('M=D   // store the address in R13');

                $this->writePop();
                // M now countains what was popped off the stack.
                $this->writeLine('D=M   // store the value in D');

                $this->writeLine('@R13  // R13 address');
                $this->writeLine('A=M   // use the value stored in R13 as the next address');
                $this->writeLine('M=D   // store the value at the address');
            }
        }
    }

    /**
     * push/pop temp
     */
    protected function writePushPopTemp($command, $index)
    {
        $this->writePushPopSegmentDirect('R5', $command, $index);
    }

    /**
     * push/pop pointer
     */
    protected function writePushPopPointer($command, $index)
    {
        $this->writePushPopSegmentDirect('R3', $command, $index);
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

        // x-y
        $this->writeLine('D=M-D  // x-y');
        $eq_true = $this->generateLabel('eq_true');

        // Goto true label if D == 0
        $this->writeLine("@$eq_true");
        $this->writeLine('D;JEQ  // jump if D == 0');

        // Not true so set D & jump to the eq_end
        $eq_end = $this->generateLabel('eq_end');
        $this->writeLine('D=0  // false');
        $this->writeLine("@$eq_end");
        $this->writeLine('0;JMP  // jump to eq_end');

        $this->writeLine("($eq_true)");
        $this->writeLine('D=-1  // true');

        $this->writeLine("($eq_end)");
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

        // x-y
        $this->writeLine('D=M-D  // x-y');
        $gt_true = $this->generateLabel('gt_true');

        // Goto true label if D > 0
        $this->writeLine("@$gt_true");
        $this->writeLine('D;JGT  // jump if D > 0');

        // Not true so set D & jump to the end
        $gt_end = $this->generateLabel('gt_end');
        $this->writeLine('D=0  // false');
        $this->writeLine("@$gt_end");
        $this->writeLine('0;JMP  // jump to gt_end');

        $this->writeLine("($gt_true)");
        $this->writeLine('D=-1  // true');

        $this->writeLine("($gt_end)");
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

        // x-y
        $this->writeLine('D=M-D  // x-y');
        $lt_true = $this->generateLabel('lt_true');

        // Goto true label if D < 0
        $this->writeLine("@$lt_true");
        $this->writeLine('D;JLT  // jump if D < 0');

        // Not true so set D & jump to the end
        $lt_end = $this->generateLabel('lt_end');
        $this->writeLine('D=0  // false');
        $this->writeLine("@$lt_end");
        $this->writeLine('0;JMP  // jump to lt_end');

        $this->writeLine("($lt_true)");
        $this->writeLine('D=-1  // true');

        $this->writeLine("($lt_end)");
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

    protected function generateLabel($prefix)
    {
        return $prefix . $this->label_num++;
    }
}
