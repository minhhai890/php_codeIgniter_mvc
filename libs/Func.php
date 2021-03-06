<?php

namespace libs;

class Func
{

	// Phương thức chuyển đổi hình ảnh sang chuỗi base64
	public static function convertImageBase64($filename)
	{
		$type = pathinfo($filename, PATHINFO_EXTENSION);
		$data = file_get_contents($filename);
		return 'data:image/' . $type . ';base64,' . base64_encode($data);
	}

	// Phương thức chuyển đôi ký tự . thành ký tự / or \
	public static function convertCslashes($string)
	{
		return \str_replace('.', '/', $string);
	}

	// Phương thức lấy key cuối cùng của một mảng
	public static function getLastKeyArray($array = array())
	{
		$lastKey = 0;
		if ($array) {
			foreach (array_reverse(array_keys($array)) as $key) {
				$lastKey = $key;
				break;
			}
		}
		return $lastKey;
	}

	/*
	 * Phương thức trả về một phần tử của mảng
	 * $data: mảng dữ liệu
	 * $key: từ khóa
	 * $value: giá trị
	 */
	public static function getRowArray($data, $key, $value)
	{
		if ($data) {
			$result = [];
			foreach ($data as $rowValue) {
				if (isset($rowValue[$key]) && $rowValue[$key] == $value) {
					$result = $rowValue;
					break;
				}
			}
			return $result;
		}
		return false;
	}

	/*
	 * Phương thức trả về nhiều phần tử của mảng
	 * $data: mảng dữ liệu
	 * $key: từ khóa
	 * $value: giá trị
	 */
	public static function getRowsArray($data, $key, $value)
	{
		if ($data) {
			$result = [];
			foreach ($data as $rowValue) {
				if (isset($rowValue[$key]) && $rowValue[$key] == $value) {
					$result[] = $rowValue;
				}
			}
			return $result;
		}
		return false;
	}

	/*
	 * Phương thức thêm 1 phần tử mảng vào phía trước của mảng
	 * $data: mảng dữ liệu
	 * $insertArray: giá trị cần thêm vào [ chuỗi hoặc mảng con]
	 */
	public static function insertRowArray($data, $insertArray)
	{
		if ($data) {
			\array_unshift($data, $insertArray);
		}
		return $data;
	}

	/*
	 * Phương thức thêm 1 phần tử mảng vào phía sau của mảng
	 * $data: mảng dữ liệu
	 * $appendArray: giá trị cần thêm vào [ chuỗi hoặc mảng con]
	 */
	public static function appendRowArray($data, $appendArray)
	{
		if ($data) {
			\array_push($data, $appendArray);
		}
		return $data;
	}

	/*
	 * Phương thức trả về một mảng sau khi đã chỉnh sửa
	 * $data: mảng dữ liệu
	 * $where: mảng điều kiện key = 1, key = 2,...
	 * $newValue: Giá trị mới thay đổi giá trị cũ
	 */
	public static function updateRowArray($data, $where, $newValue)
	{
		if ($data && $newValue) {
			foreach ($data as $rowKey => $rowValue) {
				foreach ($where as $k => $v) {
					if (isset($rowValue[$k]) && $rowValue[$k] == $v) {
						$data[$rowKey] = $newValue;
						$newValue = [];
						break;
					}
				}
			}
			return $data;
		}
		return false;
	}

	/*
	 * Phương thức xóa 1 mảng con của 1 mảng cha
	 * $data: mảng dữ liệu
	 * $key: từ khóa
	 * $value: giá trị
	 */
	public static function deleteRowArray($data, $key, $value)
	{
		if ($data) {
			foreach ($data as $rowKey => $rowValue) {
				if (isset($rowValue[$key]) && $rowValue[$key] == $value) {
					unset($data[$rowKey]);
					break;
				}
			}
			return $data;
		}
	}

	/*
	 * Phương thức sắp xếp 1 mảng theo từ khóa
	 * $data: mảng dữ liệu
	 * $subkey: từ khóa trong mảng con
	 * $sortType: kiểu tăng dần SORT_ASC, giảm dần SORT_DESC
	 */
	public static function sortArrayBySubkey(&$array, $subkey, $sortType = SORT_ASC)
	{
		foreach ($array as $subarray) {
			$keys[] = $subarray[$subkey];
		}
		\array_multisort($keys, $sortType, $array);
	}

	// Chuyển đổi chuỗi tiếng việt có dấu thành chuỗi không dấu
	public static function convertUnicode($str, $ditan = ' ')
	{
		$quotedReplacement = preg_quote($ditan, '/');
		$default = array(
			'/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|Ä|å/' => 'a',
			'/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
			'/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î|ï/' => 'i',
			'/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|Ö|ø/' => 'o',
			'/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|Ü|ů|û|ü/' => 'u',
			'/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
			'/đ|Đ/' => 'd',
			'/ç/' => 'c',
			'/ñ/' => 'n',
			'/ä|æ/' => 'ae',
			'/ß/' => 'ss',
			'/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => '',
			'/-/' => '&',
			'/\s+/' => $ditan,
			sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
		);
		//Some URL was encode, decode first
		$str = urldecode($str);
		return strtolower(preg_replace(array_keys($default), array_values($default), $str));
	}

	// Phương thức đệ quy menu và trả về mảng
	public static function recursive($data, $parent = 0, $level = 0)
	{
		$result = [];
		foreach ($data as $key => $value) {
			if ($value['parent'] == $parent) {
				unset($data[$key]);
				$value['level'] = $level + 1;
				$result[] = $value;
				$childs = self::recursive($data, $value['id'], $value['level']);
				if ($childs) {
					foreach ($childs as $item) {
						$result[] = $item;
					}
				}
			}
		}
		return $result;
	}

	// Phương thức đệ quy menu và trả về mảng
	public static function recursiveChild($data, $parent = 0, $level = 0)
	{
		$result = [];
		foreach ($data as $key => $value) {
			if ($value['parent'] == $parent) {
				unset($data[$key]);
				$value['level'] = $level + 1;
				$value['data'] = self::recursiveChild($data, $value['id'], $value['level']);
				$result[] = $value;
			}
		}
		return $result;
	}

	// Phương thức lấy dữ liệu trong menu đệ quy
	public static function getRecursive($data, $key, $value)
	{
		$result = [];
		foreach ($data as $item) {
			if ($item[$key] == $value) {
				$result = $item;
				break;
			} else {
				if ($item['data']) {
					if ($result = self::getRecursive($item['data'], $key, $value)) {
						break;
					}
				}
			}
		}
		return $result;
	}

	// Phương thức kiểm tra tên đăng nhập
	public static function isUsername($str)
	{
		return \preg_match('#^[A-z0-9]{5,32}$#', $str);
	}

	// Phương thức kiểm tra mật khẩu
	public static function isPassword($str)
	{
		return \preg_match('#^\S{6,}$#', $str);
		//return \preg_match ( '#^(?=.*\d)(?=.*[A-Z])(?=.*\W).{8,}$#', $str );
	}

	// Phương thức kiểm tra Email
	public static function isEmail($email)
	{
		return \preg_match('#^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$#', $email);
	}

	// Phương thức trả về một chuỗi ký tự số 0-9	
	public static function getNumeric($string)
	{
		return \preg_replace('#\D#m', '', $string);
	}

	// Phương thức trả về một chuỗi ký tự chữ a-z A-Z
	public static function getString($string)
	{
		return \preg_replace('#\d#m', '', $string);
	}

	// Phương thức trả về số điện thoại từ một chuỗi ký tự
	public static function getPhone($string)
	{
		if (preg_match_all('#0?(2|3|5|7|8|9)(\d|\-|\s|\.){7,}\d#m', $string, $result)) {
			$data = [];
			foreach ($result[0] as $phone) {
				if ($phone = self::isPhone(self::getNumeric($phone))) {
					$data[$phone] = '';
				}
			}
			return array_keys($data);
		}
		return false;
	}

	// Phương thức kiểm tra số điện thoại và chuyển đổi số điện thoại từ 11 số thành 10 số
	public static function isPhone($phone)
	{
		if (preg_match('#^0?((3|5|7|8|9)\d{8}|2\d{9})$#', trim($phone), $result)) {
			return '0' . $result[1];
		}
		return false;
	}

	// Phương thức tạo 1 chuỗi có độ dài cho trước
	public static function strRandom($lenth = 15)
	{
		$arrCharacter = \array_merge(\range('A', 'Z'), \range('a', 'z'), \range(0, 9));
		$strCharacter = \implode('', $arrCharacter);
		$strCharacter = \str_shuffle($strCharacter);
		$result = \substr($strCharacter, 0, $lenth);
		return $result;
	}

	// Phương thức loại bỏ khoảng trắng dư thừa
	public static function trimSpace($string)
	{
		return \trim(\preg_replace('/\s+/m', ' ', $string));
	}

	// Phương thức định dạng số tiền
	public static function formatPrice($price)
	{
		if (\is_numeric($price)) {
			return \number_format($price, 0, ',', '.');
		}
		return 0;
	}

	// Phương thức định dạng ngày tháng năm
	public static function formatDay($date, $minute = false)
	{
		if (\is_numeric($date) && $date > 0) {
			if ($minute) {
				return \date('d/m/Y H:i:s', $date);
			}
			return \date('d/m/Y', $date);
		}
		return '';
	}

	// Phương thức chuyển đổi số tiền thành chữ
	public static function VietnameseNumberToWords($number)
	{
		$f = new \NumberFormatter('vi', \NumberFormatter::SPELLOUT);
		return \ucfirst($f->format($number)) . ' đồng';
	}

	// Phương thức chuyển đổi tất cả các ký tự có thể áp dụng thành các thực thể HTML
	public static function convertHtmlentities($data, &$newData)
	{
		if (\gettype($data) == 'array' && $data) {
			foreach ($data as $key => $value) {
				if (\gettype($value) == 'array') {
					self::convertHtmlentities($value, $newData[$key]);
				} else {
					$newData[$key] = \htmlentities($value);
				}
			}
		}
	}

	// Phương thức lấy địa chỉ ip của máy khách
	public static function getClientIp()
	{
		$ipaddress = '';
		if (\getenv('HTTP_CLIENT_IP'))
			$ipaddress = \getenv('HTTP_CLIENT_IP');
		else if (\getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = \getenv('HTTP_X_FORWARDED_FOR');
		else if (\getenv('HTTP_X_FORWARDED'))
			$ipaddress = \getenv('HTTP_X_FORWARDED');
		else if (\getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = \getenv('HTTP_FORWARDED_FOR');
		else if (\getenv('HTTP_FORWARDED'))
			$ipaddress = \getenv('HTTP_FORWARDED');
		else if (\getenv('REMOTE_ADDR'))
			$ipaddress = \getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}

	// Phương thức trả về host của một đường đẫn url
	public static function getHost($url)
	{
		return parse_url($url, PHP_URL_HOST);
	}

	// Phương thức mã hóa mật khẩu
	public static function md5Password($password)
	{
		return \md5(\md5('*)2dh(@*(4%%@&##' . $password . '#8$#@%^452#$!37'));
	}

	// Phương thức trả về kiểu của tập tin HEADER
	public static function getTypeFileExtension($extension)
	{
		if (array_key_exists($extension, $data = [
			'svg' => 'image/svg+xml',
			'png' => 'image/png',
			'gif' => 'image/gif',
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'webp' => 'image/webp',
			'ico' => 'image/vnd.microsoft.icon',
			'woff2' => 'application/font-woff2',
			'woff' => 'application/font-woff',
			'ttf' => 'application/x-font-ttf',
			'otf' => 'application/x-font-opentype',
			'eot' => 'application/vnd.ms-fontobject',
			'css' => 'text/css; charset: UTF-8',
			'js' => 'application/javascript'
		])) {
			return $data[$extension];
		}
	}

	// Phương thức mã hóa chuỗi ký tự
	public static function encryptString($string)
	{
		if ($string) {
			$index = 1;
			$encrypted_string = \base64_encode(time()) . self::strRandom(3) . $index;
			foreach (\str_split($string) as $item) {
				$index++;
				$encrypted_string .= \base64_encode($item) . self::strRandom(3) . $index;
			}
			return \rtrim(\strtr(\base64_encode($encrypted_string), '+/', '-_'), '=');
		}
		return '';
	}

	// Phương thức giải mã chuỗi ký tự
	public static function decryptString($string)
	{
		$result = '';
		$string = \base64_decode(\str_pad(\strtr($string, '-_', '+/'), \strlen($string) % 4, '=', STR_PAD_RIGHT));
		if ($string) {
			$letter = '==';
			$string = \explode($letter, $string);
			$time = \base64_decode(\array_shift($string));
			\array_pop($string);
			$result = ['time' => $time, 'data' => ''];
			foreach ($string as $item) {
				$vChar = \substr($item, -2) . $letter;
				$result['data'] .= \base64_decode($vChar);
			}
		}
		return $result;
	}
}
