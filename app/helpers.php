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