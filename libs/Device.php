<?php

namespace libs {

	class Device
	{

		static $_userAgent = '';
		static $_flatform = 'Unknown';
		static $_name = 'Unknown';
		static $_device = 'desktop'; //Unknown
		static $_version = '';

		const platforms = array(
			"desktop" => "Windows|Linux|Macintosh|Chrome OS",
			"mobile" => "Android|iPhone|iPad|iPod Touch|Windows Phone OS|Kindle|Kindle Fire|BlackBerry|Playbook|Tizen"
		);

		// Lấy ra thông tin thiết bị truy cập
		public static function set()
		{
			// Kiểm tra			
			if (!Cookie::get('userAgent')) {
				// Check
				self::checkBrowser();
				// set Cookie
				Cookie::set([
					'name' => 'userAgent',
					'value' => [
						'name' => self::$_name,
						'flatform' => self::$_flatform,
						'device' => self::$_device,
						'version' => self::$_version
					],
					'expires' => strtotime("+7 days")
				]);
			} else {
				// set
				$browser = Cookie::get('userAgent');
				self::$_name = $browser['name'];
				self::$_flatform = $browser['flatform'];
				self::$_device = $browser['device'];
				self::$_version = $browser['version'];
			}
		}

		// Phương thức trả về device
		public static function get()
		{
			return self::$_device;
		}

		// Phương thức trả về platform
		public static function getPlatform()
		{
			return self::$_flatform;
		}

		// Phương thức trả về browser
		public static function getName()
		{
			return self::$_name;
		}

		// Phương thức trả về version
		public static function getVersion()
		{
			return self::$_version;
		}

		// Phương thức kiểm tra trình duyệt
		public static function checkBrowser()
		{
			if (isset($_SERVER['HTTP_USER_AGENT'])) {

				self::$_userAgent = $_SERVER['HTTP_USER_AGENT'];

				//First get the platform?
				preg_match_all('/(?P<platform>BB\d+;|Android|CrOS|Tizen|iPhone|iPad|iPod|Linux|(Open|Net|Free)BSD|Macintosh|Windows(\ Phone)?|Silk|linux-gnu|BlackBerry|PlayBook|X11|(New\ )?Nintendo\ (WiiU?|3?DS|Switch)|Xbox(\ One)?)(?:\ [^;]*)?(?:;|$)/imx', self::$_userAgent, $match);
				if (count($match['platform']) > 0) {
					self::$_flatform = array_pop($match['platform']);
					if (self::$_flatform == 'linux-gnu' || self::$_flatform == 'X11') {
						self::$_flatform = 'Linux';
					} elseif (self::$_flatform == 'CrOS') {
						self::$_flatform = 'Chrome OS';
					}
					// Device
					foreach (self::platforms as $device => $platforms) {
						if (preg_match("/($platforms)/i", self::$_flatform)) {
							self::$_device = $device;
						}
					}
				}

				// Next get the name of the useragent yes seperately and for good reason
				$ub = '';
				if (preg_match('/MSIE/i', self::$_userAgent) && !preg_match('/Opera/i', self::$_userAgent)) {
					self::$_name = 'Internet Explorer';
					$ub = "MSIE";
				} elseif (preg_match('/Firefox/i', self::$_userAgent)) {
					self::$_name = 'Mozilla Firefox';
					$ub = "Firefox";
				} elseif (preg_match('/Chrome/i', self::$_userAgent)) {
					self::$_name = 'Google Chrome';
					$ub = "Chrome";
				} elseif (preg_match('/Safari/i', self::$_userAgent)) {
					self::$_name = 'Apple Safari';
					$ub = "Safari";
				} elseif (preg_match('/Opera/i', self::$_userAgent)) {
					self::$_name = 'Opera';
					$ub = "Opera";
				} elseif (preg_match('/Netscape/i', self::$_userAgent)) {
					self::$_name = 'Netscape';
					$ub = "Netscape";
				}

				// finally get the correct version number
				$known = array('Version', $ub, 'other');
				$pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
				if (preg_match_all($pattern, self::$_userAgent, $matches)) {
					// see how many we have					
					if (count($matches['browser']) > 1) {
						//we will have two since we are not using 'other' argument yet
						//see if version is before or after the name
						if (strripos(self::$_userAgent, "Version") < strripos(self::$_userAgent, $ub)) {
							self::$_version = $matches['version'][0];
						} else {
							self::$_version = $matches['version'][1];
						}
					} else {
						self::$_version = $matches['version'][0];
					}
				}
			}
		}
	}
}
