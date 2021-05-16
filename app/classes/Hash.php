<?php

class Hash
{
    public static function make($plainText): string
    {
        return password_hash($plainText, PASSWORD_BCRYPT, ['cost'=>10]);
    }

    public static function verify($plainText, $hashed): bool
    {
        return password_verify($plainText, $hashed);
    }

    public static function generateToken($id)
    {
        return hash('sha256', $id . round(microtime(true)*1000) . strrev($id) . rand());
    }
}