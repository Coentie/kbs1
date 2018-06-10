<?php

namespace KBS\Config\Loader;

/**
 * Loads arrays from the config.
 *
 * Class ArrayLoader
 */
class ArrayLoader implements LoaderContract
{
    /**
     * Files that contain PHP arrays.
     *
     * @var array
     */
    protected $files;

    /**
     * ArrayLoader constructor.
     *
     * @param array $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }

    /**
     * Returns a parsed array of the file.
     *
     * @return array|mixed
     */
    public function parse()
    {
        $parsed = [];

        foreach($this->files as $name => $path) {
            try {
                $parsed[$name] = require $path;
            }catch(\Exception $e) {

            }
        }

        return $parsed;
    }
}