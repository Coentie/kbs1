<?php

/*
 * Path helpers
 */
if(! function_exists('base_path')) {

    /**
     * Returns string representation of the base path.
     *
     * @param string $extension
     *
     * @return string
     */
    function base_path($extension = '') :string
    {
        return  __DIR__ . '/../' . $extension;
    }
}

if (! function_exists('route_path')) {

    /**
     * Returns string representation of the route path.
     *
     * @param string $extension
     *
     * @return string
     */
    function route_path($extension = '') :string
    {
        return base_path('/routes/') . $extension;
    }
}

if(! function_exists('resource_path')) {

    /**
     * Returns string representation of the resource path.
     *
     * @param string $extension
     *
     * @return string
     */
    function resource_path($extension = '') :string
    {
        return base_path('/resources/') . $extension;
    }
}

if(! function_exists('config_path')) {

    /**
     * Returns string representation of the config path.
     *
     * @param string $extension
     *
     * @return string
     */
    function config_path($extension = '') :string
    {
        return base_path('/config/') . $extension;
    }
}

if(! function_exists('env')) {

    /**
     * @param        $key
     * @param string $default
     *
     * @return array|bool|false|string
     */
    function env($key, $default = '')
    {
        $value = getenv($key);

        if($value === false) {
            return $default;
        }

        if($value === 'true' || $value === 'false')
        {
            return (bool) $value;
        }

        return $value;
    }
}