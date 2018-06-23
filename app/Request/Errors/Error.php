<?php


namespace KBS\Request\Errors;

class Error
{

    /**
     * @var array
     */
    protected static $errorBag = [];

    /**
     * Adds an error to the error bag
     *
     * @param $message
     * @param $value
     */
    public static function add($key, $message)
    {
        self::$errorBag[$key] = $message;
    }

    /**
     * Retreives an error from the bag
     *
     * @param $key
     *
     * @return mixed
     */
    public static function get($key)
    {
        return self::$errorBag[$key];
    }

    /**
     * Checks if an error is set.
     *
     * @param $key
     *
     * @return bool
     */
    public static function has($key)
    {
        return key_exists($key, self::$errorBag);
    }

    /**
     * Returns all the errors.
     *
     * @return array
     */
    public static function all()
    {
        return self::$errorBag;
    }

    /**
     * Clears all the errors.
     */
    public static function clear()
    {
        self::$errorBag = [];
    }
}