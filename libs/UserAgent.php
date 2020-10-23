<?php

namespace libs{
    class UserAgent{

        const detectedPlatforms = array(
            "desktop" => "Windows|Linux|Macintosh|Chrome OS",
            "mobile" => "Android|iPhone|iPad|iPod Touch|Windows Phone OS|Kindle|Kindle Fire|BlackBerry|Playbook|Tizen" 
        );

        public static $_data;

        // Lấy ra thông tin thiết bị truy cập
        public static function set(){
            // Kiểm tra
            if(!Cookie::get('userAgent')){
                // Thực hiện code
                self::detect();
                // Tạo Cookie
                Cookie::set([
                    'name'=>'userAgent',
                    'value'=>self::$_data,
                    'expires'=>strtotime("+7 days")
                ]);
            }else{
                // Thiết lập lại _browser
                self::$_data = Cookie::get('userAgent');
            }
        }

        // Phương thức trả về platform
        public static function getPlatform(){
            return self::$_data['platform'];
        }

        // Phương thức trả về browser
        public static function getBrowser(){
            return self::$_data['browser'];
        }

        // Phương thức trả về version
        public static function getVersion(){
            return self::$_data['version'];
        }

        // Phương thức trả về device
        public static function getDevice(){
            if(isset(self::$_data['device'])){
                if(self::$_data['device'] == 'desktop' || self::$_data['device'] == 'mobile'){
                    return self::$_data['device'];
                }
            }
            return BROWSER_DEVICE;
		}
		// Phương thức trả về thông tin clients
		public static function getInfoClient(){
            return self::$_data;
		}
		// Phương thức so sánh thông tin client
		public static function checkEquals ($data) {
			if(strcmp(self::$_data["device"], $data["device"]) != 0) {
				return false;
			}
			if(strcmp(self::$_data["platform"], $data["platform"]) != 0) {
				return false;
			}
			if(strcmp(self::$_data["browser"], $data["browser"]) != 0) {
				return false;
			}
			if(strcmp(self::$_data["version"], $data["version"]) != 0) {
				return false;
			}
			return true;
		}
        // 
        public static function detect(){
            // $browser = get_browser(null, true);
            $browser = \parse_user_agent();
            $device = null;
            foreach( self::detectedPlatforms as $key => $platforms)
            {
                if ( preg_match("/($platforms)/i", $browser['platform']) )
                    $device = $key;
            }

            self::$_data = [
                    'device' => $device,
                    'platform' => $browser["platform"],
                    'browser' => $browser["browser"], 
                    'version' => $browser["version"]
            ];
        }
        
    }
}

namespace {

	/**
	 * Parses a user agent string into its important parts
	 *
	 * @param string|null $u_agent User agent string to parse or null. Uses $_SERVER['HTTP_USER_AGENT'] on NULL
	 * @return string[] an array with 'browser', 'version' and 'platform' keys
	 * @throws \InvalidArgumentException on not having a proper user agent to parse.
	 */
	function parse_user_agent( $u_agent = null ) {
		if( $u_agent === null && isset($_SERVER['HTTP_USER_AGENT']) ) {
			$u_agent = (string)$_SERVER['HTTP_USER_AGENT'];
		}

		if( $u_agent === null ) {
			throw new \InvalidArgumentException('parse_user_agent requires a user agent');
		}

		$platform = null;
		$browser  = null;
		$version  = null;

		$empty = array( PLATFORM => $platform, BROWSER => $browser, BROWSER_VERSION => $version );

		if( !$u_agent ) {
			return $empty;
		}

		if( preg_match('/\((.*?)\)/m', $u_agent, $parent_matches) ) {
			preg_match_all(<<<'REGEX'
/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|(Open|Net|Free)BSD|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS|Switch)|Xbox(\ One)?)
(?:\ [^;]*)?
(?:;|$)/imx
REGEX
				, $parent_matches[1], $result);

			$priority = array( 'Xbox One', 'Xbox', 'Windows Phone', 'Tizen', 'Android', 'FreeBSD', 'NetBSD', 'OpenBSD', 'CrOS', 'X11' );

			$result[PLATFORM] = array_unique($result[PLATFORM]);
			if( count($result[PLATFORM]) > 1 ) {
				if( $keys = array_intersect($priority, $result[PLATFORM]) ) {
					$platform = reset($keys);
				} else {
					$platform = $result[PLATFORM][0];
				}
			} elseif( isset($result[PLATFORM][0]) ) {
				$platform = $result[PLATFORM][0];
			}
		}

		if( $platform == 'linux-gnu' || $platform == 'X11' ) {
			$platform = 'Linux';
		} elseif( $platform == 'CrOS' ) {
			$platform = 'Chrome OS';
		}

		preg_match_all(<<<'REGEX'
%(?P<browser>Camino|Kindle(\ Fire)?|Firefox|Iceweasel|IceCat|Safari|MSIE|Trident|AppleWebKit|
TizenBrowser|(?:Headless)?Chrome|YaBrowser|Vivaldi|IEMobile|Opera|OPR|Silk|Midori|Edge|Edg|CriOS|UCBrowser|Puffin|OculusBrowser|SamsungBrowser|
Baiduspider|Googlebot|YandexBot|bingbot|Lynx|Version|Wget|curl|
Valve\ Steam\ Tenfoot|
NintendoBrowser|PLAYSTATION\ (\d|Vita)+)
(?:\)?;?)
(?:(?:[:/ ])(?P<version>[0-9A-Z.]+)|/(?:[A-Z]*))%ix
REGEX
			, $u_agent, $result);

		// If nothing matched, return null (to avoid undefined index errors)
		if( !isset($result[BROWSER][0]) || !isset($result[BROWSER_VERSION][0]) ) {
			if( preg_match('%^(?!Mozilla)(?P<browser>[A-Z0-9\-]+)(/(?P<version>[0-9A-Z.]+))?%ix', $u_agent, $result) ) {
				return array( PLATFORM => $platform ?: null, BROWSER => $result[BROWSER], BROWSER_VERSION => empty($result[BROWSER_VERSION]) ? null : $result[BROWSER_VERSION] );
			}

			return $empty;
		}

		if( preg_match('/rv:(?P<version>[0-9A-Z.]+)/i', $u_agent, $rv_result) ) {
			$rv_result = $rv_result[BROWSER_VERSION];
		}

		$browser = $result[BROWSER][0];
		$version = $result[BROWSER_VERSION][0];

		$lowerBrowser = array_map('strtolower', $result[BROWSER]);

		$find = function ( $search, &$key = null, &$value = null ) use ( $lowerBrowser ) {
			$search = (array)$search;

			foreach( $search as $val ) {
				$xkey = array_search(strtolower($val), $lowerBrowser);
				if( $xkey !== false ) {
					$value = $val;
					$key   = $xkey;

					return true;
				}
			}

			return false;
		};

		$findT = function ( array $search, &$key = null, &$value = null ) use ( $find ) {
			$value2 = null;
			if( $find(array_keys($search), $key, $value2) ) {
				$value = $search[$value2];

				return true;
			}

			return false;
		};

		$key = 0;
		$val = '';
		if( $findT(array( 'OPR' => 'Opera', 'UCBrowser' => 'UC Browser', 'YaBrowser' => 'Yandex', 'Iceweasel' => 'Firefox', 'Icecat' => 'Firefox', 'CriOS' => 'Chrome', 'Edg' => 'Edge' ), $key, $browser) ) {
			$version = $result[BROWSER_VERSION][$key];
		} elseif( $find('Playstation Vita', $key, $platform) ) {
			$platform = 'PlayStation Vita';
			$browser  = 'Browser';
		} elseif( $find(array( 'Kindle Fire', 'Silk' ), $key, $val) ) {
			$browser  = $val == 'Silk' ? 'Silk' : 'Kindle';
			$platform = 'Kindle Fire';
			if( !($version = $result[BROWSER_VERSION][$key]) || !is_numeric($version[0]) ) {
				$version = $result[BROWSER_VERSION][array_search('Version', $result[BROWSER])];
			}
		} elseif( $find('NintendoBrowser', $key) || $platform == 'Nintendo 3DS' ) {
			$browser = 'NintendoBrowser';
			$version = $result[BROWSER_VERSION][$key];
		} elseif( $find('Kindle', $key, $platform) ) {
			$browser = $result[BROWSER][$key];
			$version = $result[BROWSER_VERSION][$key];
		} elseif( $find('Opera', $key, $browser) ) {
			$find('Version', $key);
			$version = $result[BROWSER_VERSION][$key];
		} elseif( $find('Puffin', $key, $browser) ) {
			$version = $result[BROWSER_VERSION][$key];
			if( strlen($version) > 3 ) {
				$part = substr($version, -2);
				if( ctype_upper($part) ) {
					$version = substr($version, 0, -2);

					$flags = array( 'IP' => 'iPhone', 'IT' => 'iPad', 'AP' => 'Android', 'AT' => 'Android', 'WP' => 'Windows Phone', 'WT' => 'Windows' );
					if( isset($flags[$part]) ) {
						$platform = $flags[$part];
					}
				}
			}
		} elseif( $find(array( 'IEMobile', 'Edge', 'Midori', 'Vivaldi', 'OculusBrowser', 'SamsungBrowser', 'Valve Steam Tenfoot', 'Chrome', 'HeadlessChrome' ), $key, $browser) ) {
			$version = $result[BROWSER_VERSION][$key];
		} elseif( $rv_result && $find('Trident') ) {
			$browser = 'MSIE';
			$version = $rv_result;
		} elseif( $browser == 'AppleWebKit' ) {
			if( $platform == 'Android' ) {
				$browser = 'Android Browser';
			} elseif( strpos($platform, 'BB') === 0 ) {
				$browser  = 'BlackBerry Browser';
				$platform = 'BlackBerry';
			} elseif( $platform == 'BlackBerry' || $platform == 'PlayBook' ) {
				$browser = 'BlackBerry Browser';
			} else {
				$find('Safari', $key, $browser) || $find('TizenBrowser', $key, $browser);
			}

			$find('Version', $key);
			$version = $result[BROWSER_VERSION][$key];
		} elseif( $pKey = preg_grep('/playstation \d/i', $result[BROWSER]) ) {
			$pKey = reset($pKey);

			$platform = 'PlayStation ' . preg_replace('/\D/', '', $pKey);
			$browser  = 'NetFront';
		}

		return array( PLATFORM => $platform ?: null, BROWSER => $browser ?: null, BROWSER_VERSION => $version ?: null );
	}
}
