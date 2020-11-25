<?php
define("url", "http://localhost:3330");
/**
 * Login
 */

use steamLogin\steamAuth;

class login
{
    public static function steam()
    {
        require_once __DIR__ . '/vendor/autoload.php';

        $loginSteam = steamAuth::login([
            'apikey'     => '2C2B1FFEF87C06A430319DFFBB52DB38',
            'domainname' => url,
            'logoutpage' => url . '/logout',
            'loginpage'  => url . '/test.php'
        ]);
        
        print_r($loginSteam);
    }
}

login::steam();