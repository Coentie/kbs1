<?php

namespace KBS\Config\Loader;

interface LoaderContract
{
    /**
     * Function to parse different type of files as a config file.
     *
     * @return mixed
     */
    public function parse();

}