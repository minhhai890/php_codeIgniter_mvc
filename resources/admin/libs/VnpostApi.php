<?php
namespace resources\app\libs;

class VnpostApi{

	protected $_username 	= VNPOST_USERNAME; 								// username
	protected $_password 	= VNPOST_PASSWORD; 								// password
	protected $_host 		= 'https://donhang.vnpost.vn/api/api'; 			// host
	protected $_path 		= ''; 											// path
	protected $_url 		= ''; 											// url
	protected $_token 		= 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJTb0RpZW5UaG9haSI6IjA5MzIwOTc1NzYiLCJFbWFpbCI6IiIsIk1hQ1JNIjoiNzMxMDBHNDc5OTc3MDAwMDAiLCJFeHBpcmVkVGltZSI6NjQwNDE2MjIzMTc0OTUuODM2LCJSb2xlcyI6Wzk5OSwxMSw0XSwiTmd1b2lEdW5nSWQiOiIzN2RlOTIyOC1lYjU5LTQ2ZjctYjljYS0zMWRmMTlmNmY5NjYiLCJNYVRpbmhUaGFuaCI6IjcwIiwiVGVuTmd1b2lEdW5nIjoiTkdVWeG7hE4gVEjhu4ogw5pUIExJw4pOIiwiTmdheVRhb1Rva2VuIjoiXC9EYXRlKDE1OTA3MjY3MTc0OTUpXC8iLCJUaW1lTGFzdFJlYWRDb21tZW50IjpudWxsLCJNYUJ1dUN1YyI6bnVsbCwiTWFUaW5oVGhhbmhRdWFuTHkiOm51bGwsIkNSTV9FbXBsb3llZUlkIjpudWxsfQ.YeKcHimIjY_Nbzau6RCA1KpsC6rAcEkS3NMOrLh_EDj2AcvMH8cvuqSCfTK67GdQPsYW4qIf7fNbkbNjWqYffAypnMliU-0uvOIOSL6FGHEoL8OX0N39-qM6kg3MTvkpLSwnxRvGBdH8_i1Lo5o5zLMPZML_uNeCSChtHe2v1SfNyEgppox415RAIEvi-bA95DxRTqRTLKnFV4pca9QgZee8rmrkCpPiD-K8OwiPVlyFqGA_0DPBA7mswhR1dT_bqmVcQVU1xk2sBXUTzrWA08jyjdNj4LsI6D_1vBYFyy1z5OEddGPZmIipucI0Jin0APOahfdKQvEOjp0JyeyPTg';

	// Phương thức thiết lập url
	public function setUrl($path){
		if($path){
			$this->_url = $this->_host . $path;
		}
	}

	// Phương thức thiết lập header
	public function setHeader($token){
		$header = [
			"Content-Type: application/json",
			"Cookie: SRVNAME=D2"
		];
		if($token == true){
			$header[] = "h-token:".$this->_token;
		}	
		return $header;
	}

	// Phương thức thực hiện truy xuất api
	public function excute($method, $path, $data = array(), $token = true){
		// set url
		$this->setUrl($path);
		// set Header
		$header = $this->setHeader($token);	
		// Kiểm tra
		if($this->_url && $header){
			$curl = curl_init();
			curl_setopt_array($curl, array(			
			  CURLOPT_URL => $this->_url,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => $method,
			  CURLOPT_POSTFIELDS =>json_encode($data),
			  CURLOPT_HTTPHEADER => $header,
			));			
			$response = curl_exec($curl);						
			curl_close($curl);			
			return $response;
		}
	}

	// Phương thức thực hiện POST API
	public function post($path, $data = array(), $token = true){
		return $this->excute('POST', $path, $data, $token = true);
	}

	// Phương thức thực hiện GET API
	public function get($path, $data = array(), $token = true){
		return $this->excute('GET', $path, $data, $token = true);
	}


	// ========================================= USE API ================================//
	
	// Phương thức reset token
	public function resetToken(){
		$path = '/Token/RefreshToken';
		$data = [
			'Token'=>$this->_token,
			'DeviceId'=>'',
		];
		return $this->post($path, $data, true);
	}

	// Phương thức đăng nhập
	public function login(){
		$path = '/MobileAuthentication/GetAccessToken';
		$data = [
			'TenDangNhap'=>$this->_username,
			'MatKhau'=>$this->_password,
		];
		return $this->post($path, $data, false);
	}

	// Phương thức tạo đơn hàng
	public function createOrder($data){
		$path = '/Order/CreateOrder';
		$data = [
			"OrderCode" 			=> "DH034564765586785",	// string
			"VendorId" 				=> 1,		// integer (Unknown:0; MerchantSite:1; Mobile:2; Lazada: 3;  Tiki:4; Adayroi: 5; Sendo:6; Lotte 7)
			"PickupType" 			=> 1,		// require|integer (1: Pickup - Thu gom tận nơi - 2: Dropoff - Gửi hàng tại bưu cục )
			"IsPackageViewable"		=> true, // Boolean (true: xem hàng; false không xem hàng)
			"PackageContent" 		=> "Đơn hàng Test không thu gom",	// string (nội dung hàng hóa)
			"ServiceName" 			=> "BK",		// require|string (EMS: chuyển phát nhanh; BK: chuyển phát thường)
			"SenderFullname" 		=> "Trần Văn A",	// require|string (Họ tên người gửi)
			"SenderAddress" 		=> "125 Hai Bà Trưng,Quận 1, TP HCM", // require|string (Địa chỉ người gửi)
			"SenderTel" 			=> "0909999999",	// require|string (số điện thoại người gửi)
			"SenderProvinceId" 		=> "70",		// require|string (mã tình thành người gửi)
			"SenderDistrictId" 		=> "7100",	// require|string (mã quận huyện người gửi)
			"SenderWardId" 			=> "",			// require|string (mã phường xã người gửi)
			"ReceiverFullname" 		=> "Nguyễn Văn B",	// require|string (họ tên người nhận)
			"ReceiverAddress" 		=> "123 Đoàn Văn Bơ ,Phường 15, Quận 4",	// require|string (địa chỉ người nhận)
			"ReceiverTel" 			=> "0284088888",	// reuqire|string (điện thoại người nhận)
			"ReceiverProvinceId" 	=> "70",	// require|string (mã tỉnh thành người nhận)
			"ReceiverDistrictId" 	=> "7540", // require|string (mã quận huyện người nhận)
			"ReceiverWardId" 		=> "",	// require|string (mã phường xã người nhận)		
			"CodAmountEvaluation" 	=> 500000,	// integer (Tiền thu hộ tạm tính > 0 có thu COD, ngược lại không thu)
			"OrderAmountEvaluation" => 500000, // integer (Giá trị hàng hóa > 0 có sử dụng dịch vụ ngược lại không sử dụng)
			"WeightEvaluation" 		=> 100,
			"WidthEvaluation" 		=> 10,
			"LengthEvaluation" 		=> 20,
			"HeightEvaluation" 		=> 30,
			"IsReceiverPayFreight" 	=> true,		// boolean (true: thu cước người nhận)
			"CustomerNote" 			=> "Phát vào buổi chiều", // string (ghi chú cho khách hàng)
			"SenderAddressType" 	=> 1,	// integer (địa chỉ người gửi => 1: nhà riêng; 2 cơ quan)
			"ReceiverAddressType" 	=> 1 // integer (địa chỉ người nhận => 1: nhà riêng; 2 cơ quan)
		  
		];
		return $this->post($path, $data, true);
	}

	// Kiểm tra trạng thái bưu gửi
	public function getStatus($data = array()){
		$path = '/Order/TraCuuDanhSachBuuGuiBCCP';
		$data = [
			"LstItemCode" => $data
		];
		/*$data = [
			"CV749233795VN",
			"CV749233795VN",
			'EN340902457VN' // mới tạo
		]*/
		return $this->post($path, $data, true);
	}

	// Phương thức tra cứu thông tin đơn hàng gửi
	public function getOrder($data = array()){
		$path = '/Order/GetListOrderByManagerWithCustomCode';
		$data = [
			"PageSize" => 100,
			"ListItemCode" => $data
		];
		/*$data = [
			"CV749233795VN",
			"CV749233795VN",
			'EN340902457VN' // mới tạo
		]*/
		return $this->post($path, $data, true);
	}

	// Phương thức tra cứu thông tin chi tiết đơn hàng gửi
	public function getOrderInfo($itemCode){
		$path = '/Order/TraCuuBuuGuiBCCP';
		$data = [
			"ItemCode" => $itemCode
		];
		/*$data = [
			"CV749233795VN",
			"CV749233795VN",
			'EN340902457VN' // mới tạo
		]*/
		return $this->post($path, $data, true);
	}


}
?>