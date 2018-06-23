<?php


namespace KBS\Session;


class SessionManager
{

    /**
     * @var self | null
     */
    protected static $_instance = null;

    /**
     * Adds a key to the session.
     *
     * @param $key
     * @param $value
     */
    public static function add($key, $value)
    {
        ! self::$_instance ?:
            self::$_instance = new self();

        $_SESSION[$key] = $value;

        self::$_instance = null;
    }

    /**
     * Removes key from the session.
     *
     * @param $key
     * @param $value
     */
    public static function remove($key)
    {
        ! self::$_instance ?:
            self::$_instance = new self();

        unset($_SESSION['key']);

        self::$_instance = null;
    }

    public static function get($key)
    {
        ! self::$_instance ?:
            self::$_instance = new self();

        return $_SESSION[$key];
    }
}