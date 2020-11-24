<?php

/**
 * Login
 */
use steamLogin\steamAuth;

class login
{
    public static function steam()
    {
        require_once __DIR__.'/vendor/autoload.php';

        echo steamAuth::login([]);
    }
}

echo login::steam();