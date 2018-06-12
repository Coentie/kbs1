<?php

namespace KBS\Config;

use KBS\Config\Loader\LoaderContract;

class Config
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $cache = [];

    /**
     * Loops through the loaders and parses them to the config.
     *
     * @param array $loaders
     *
     * @return $this
     */
    public function from(array $loaders)
    {
        foreach($loaders as $loader) {
            if ( ! $loader instanceof LoaderContract) {
                continue;
            }

            $this->config = array_merge($this->config, $loader->parse());
        }

        return $this;
    }

    /**
     * Gets the value from the config.
     *
     * @param      $key
     * @param null $default
     *
     * @return array|mixed|null
     */
    public function get($key, $default = null)
    {
        if($this->exists($this->cache, $key)) {
            return $this->cache[$key];
        }

        return $this->extractFromConfig($key) ?? $default;
    }

    /**
     * Extracts a value from the loaded configuration files.
     *
     * @param $key
     *
     * @return array|mixed
     */
    protected function extractFromConfig($key)
    {
        $filtered = $this->config;

        foreach(explode('.', $key) as $segment) {
            if($this->exists($filtered, $segment)) {
                $filtered = $filtered[$segment];
            }
        }

        $this->addToCache($key, $filtered);

        return $filtered;
    }

    /**
     * Add values to the cache.
     *
     * @param $key
     * @param $value
     */
    protected function addToCache($key, $value)
    {
        $this->cache[$key] = $value;
    }

    /**
     * Check if an array key exists within the current config array
     *
     * @param array $config
     * @param       $key
     *
     * @return bool
     */
    protected function exists(array $config, $key)
    {
        return array_key_exists($key, $config);
    }

}