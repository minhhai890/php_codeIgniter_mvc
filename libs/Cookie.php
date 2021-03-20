<?php
namespace libs;
class Cookie{

	// Phương thức trả về tham số mặc định
	public static function getParams(){
		return [
			'name' =>'',
			'value' =>'',
			'expires' =>0,
			'path' =>'',			
			'domain' =>'',
			'secure' =>false,
			'httponly' =>false,
		];
	}

	// Phương thức thiết lập Cookie
	public static function set($option = [], $encodeUrl = true){
		if(is_array($option)){
			$params = array_merge(self::getParams(), $option);
			if(is_array($params['value'])){
				$params['value'] = serialize($params['value']);
			}
			if($encodeUrl == true){
				setcookie(
				$params['name'], 
				$params['value'],
				$params['expires'],
				$params['path'],
				$params['domain'],
				$params['secure'],
				$params['httponly']
				);
			}else{
				setrawcookie(
				$params['name'], 
				$params['value'],
				$params['expires'],
				$params['path'],
				$params['domain'],
				$params['secure']
				);
			}
		}
	}
	
	// Phương thức trả về giá trị Cookie theo từ khóa $name
	public static function get($name){
		if(isset($_COOKIE[$name])){		
			$data = @unserialize($_COOKIE[$name]);
			if ($data !== false) {
				return $data;
			} 
			return $_COOKIE[$name];
		}
	}
	
	// Phương thức xóa Cookie theo từ khóa $name
	public static function delete($name){
		if(isset($_COOKIE[$name])){
			setcookie($name, '', -1);
		}
	}
	
	// Phương thức xóa tất cả Cookie
	public static function destroy(){
		if(isset($_COOKIE) && $_COOKIE){
			foreach($_COOKIE as $name => $value){
				self::delete($name);
			}
		}
	}
}
