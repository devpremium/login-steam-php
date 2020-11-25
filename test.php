<?php
define("url", "http://localhost:3330");
/**
 * Login
 */
use steamLogin\steamAuth;

class login
{
    private static $apikey     = '2C2B1FFEF87C06A430319DFFBB52DB38';
    private static $domainname = url;
    private static $logoutpage = url.'/logout';
    private static $loginpage  = url.'/test.php';

    private static function dataLoginSteam()
    {
        return [
            'apikey'     => self::$apikey,
            'domainname' => self::$domainname,
            'logoutpage' => self::$logoutpage,
            'loginpage'  => self::$loginpage
        ];
    }

    public static function steamGetLink()
    {
        require_once __DIR__.'/vendor/autoload.php';

        return steamAuth::getUrlLogin(self::dataLoginSteam());
    }

    public static function steamLogin()
    {
        require_once __DIR__.'/vendor/autoload.php';

        return steamAuth::getLoginData(self::dataLoginSteam());
    }
}

print_r(login::steamGetLink());

print_r(login::steamLogin());