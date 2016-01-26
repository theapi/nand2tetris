<?php
require_once 'Parser.php';
require_once 'CodeWriter.php';

class VMtranslator
{

    protected $writer;

    protected $dir;

    protected $filename;

    protected $is_dir;

    protected $files = array();

    public function __construct($file, $init)
    {
        $file = rtrim($file, '/');
        if (is_file($file)) {
            $info = pathinfo($file);
            if ($info['extension'] != 'vm') {
                throw new Exception('Files must have a .vm extension');
            }
            $this->filename = $info['filename'];
            $this->dir = $info['dirname'];
            $output_file = $this->dir . '/' . $this->filename . '.asm';
            $this->files[] = $file;
        } else if (is_dir($file)) {
            $this->dir = $file;
            $this->is_dir = true;
            $output_file = $this->dir . '/' . basename($this->dir) . '.asm';

            // Read the directory for .vm files
            foreach (glob($this->dir . '/*.vm') as $filename) {
                $this->files[] = $filename;
            }
            if (empty($this->files)) {
                throw new Exception('Found no files with a .vm extension');
            }

            $info = pathinfo($this->files[0]);
            $this->filename = $info['filename'];
        } else {
            throw new Exception('Unknown input file.');
        }

        $this->writer = new CodeWriter($output_file, $init);

    }

    public function run()
    {
        $this->writer->setFileName($this->filename);

        foreach ($this->files as $file) {
            $parser = new Parser($file);
            while ($parser->hasMoreCommands()) {
                $parser->advance();
                $type = $parser->commandType();
                if (empty($type)) {
                    // Empty line/comment, so advance to the next line.
                    continue;
                }

                $cmd = $parser->getCurrentCmd();
                $this->writer->writeLine('//** ' . $cmd . ' **//');

                switch ($type) {
                    case 'C_ARITHMETIC':
                        $this->writer->writeArithmatic($parser->arg1());
                        break;
                    case 'C_PUSH':
                    case 'C_POP':
                        $this->writer->writePushPop($type, $parser->arg1(), $parser->arg2());
                        break;
                    case 'C_LABEL':
                        $this->writer->writeLabel($parser->arg1());
                        break;
                    case 'C_GOTO':
                        $this->writer->writeGoto($parser->arg1());
                        break;
                    case 'C_IF':
                        $this->writer->writeIf($parser->arg1());
                        break;
                    case 'C_FUNCTION':
                        $this->writer->writeFunction($parser->arg1(), $parser->arg2());
                        break;
                    case 'C_RETURN':
                        $this->writer->writeReturn();
                        break;
                    case 'C_CALL':
                        $this->writer->writeCall($parser->arg1(), $parser->arg2());
                        break;
                }

                $this->writer->writeLine('');
            }
            $parser->close();
        }

        $this->writer->close();
    }

}

