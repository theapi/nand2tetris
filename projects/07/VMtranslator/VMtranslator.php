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

    //protected $file;

    public function __construct($file)
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
            //$this->file = $file;
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
            //$this->file = array_shift($this->files);
            $info = pathinfo($this->file);
            $this->filename = $info['filename'];
        } else {
            throw new Exception('Unknown input file.');
        }

        $this->writer = new CodeWriter($output_file);

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

                switch ($type) {
                    case 'C_ARITHMETIC':
                        $this->writer->writeArithmatic($parser->arg1());
                        break;
                    case 'C_PUSH':
                    case 'C_POP':
                        $this->writer->writePushPop($type, $parser->arg1(), $parser->arg2());
                        break;
                }

            }
            $parser->close();
        }

        $this->writer->close();
    }

}

