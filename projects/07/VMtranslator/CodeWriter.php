<?php

class CodeWriter
{
    protected $file;

    protected $filename;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function setFileName($filename)
    {
        $this->filename = $filename;
    }

    public function writeArithmatic($command)
    {
        var_dump(__FUNCTION__, $command);
    }

    public function writePushPop($command, $segment, $index)
    {
        var_dump(__FUNCTION__, $command, $segment, $index);
    }

    public function close()
    {}
}
