<?php namespace Bootstrap;


trait Loader
{

    public function loadDir($dir)
    {
        $directory = LEVEL_PLACEMENT_DIR . $dir;

        foreach (glob("{$directory}/*.php") as $filename)
        {
            require_once $filename;
        }
    }

    public function loadFile($file)
    {
        require_once LEVEL_PLACEMENT_DIR . $file . '.php';
    }
}