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
    public function equals($unhashed, $hashed)
    {
        return $this->hash($unhashed) === $hashed;
    }
}