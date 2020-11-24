<?php
namespace steamAuth;

class steamAuth extends LightOpenID
{
    public static function login($steamauth)
    {
		try {
			$openid = new LightOpenID($steamauth['domainname']);
			 
			if(!$openid->mode) {
				$openid->identity = 'https://steamcommunity.com/openid';
                return $openid->authUrl();
			}elseif ($openid->mode == 'cancel') {
				return 'User has canceled authentication!';
			}else{
				if($openid->validate()) {
					$id = $openid->identity;
					$ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
					preg_match($ptn, $id, $matches);
					
					$url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".
						$steamauth['apikey'].
						"&steamids=".$matches[1]
					);

					$content = json_decode($url, true);

					$steam_data = (object)[
						'steam_steamid'                  => $content['response']['players'][0]['steamid'],
						'steam_communityvisibilitystate' => $content['response']['players'][0]['communityvisibilitystate'],
						'steam_profilestate'             => 'nd',
						'steam_personaname'              => $content['response']['players'][0]['personaname'], 
						'steam_profileurl'               => $content['response']['players'][0]['profileurl'], 
						'steam_avatar'                   => $content['response']['players'][0]['avatar'], 
						'steam_avatarmedium'             => $content['response']['players'][0]['avatarmedium'], 
						'steam_avatarfull'               => $content['response']['players'][0]['avatarfull'], 
						'steam_personastate'             => $content['response']['players'][0]['personastate'], 
						'steam_realname'                 => isset($content['response']['players'][0]['realname']) ? :'Real name not given', 
						'steam_timecreated'              => $content['response']['players'][0]['timecreated'], 
						'steam_uptodate'                 => time()
                    ];
                    
                    return $steam_data;
                }else{
                    return 'OpenID Error';
                }
			}
		}catch(\Throwable $e) {
			return $e->getMessage();
		}
    }
}