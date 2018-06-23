<?php


namespace KBS\Hash;


class Hash
{
    /**
     * Hashes as string.
     *
     * @param $string
     *
     * @return int
     */
    public function hash($string)
    {
        return password_hash($string, PASSWORD_DEFAULT);
    }

    /**
     * Checks if a hash equals the given string.
     *
     * @param $string
     *
     * @return bool
     */
    public function equals($password, $hash)
    {
        return password_verify($password, $hash);
    }
}