<?php
namespace libs;
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require DIR_VENDOR;

class SendMail{
	
	public $_mail;
	
	// Phương thức gửi Email khi khởi tạo
	public function __construct(){
		
		//Create a new PHPMailer instance
		$this->_mail = new PHPMailer;
				
		// Language
		$this->_mail->setLanguage('vi');
		
		//Tell PHPMailer to use SMTP
		$this->_mail->isSMTP();
		
		//Enable SMTP debugging
		// SMTP::DEBUG_OFF = off (for production use)
		// SMTP::DEBUG_CLIENT = client messages
		// SMTP::DEBUG_SERVER = client and server messages
		$this->_mail->SMTPDebug = 'off';//SMTP::DEBUG_SERVER;
		
		//Set the hostname of the mail server
		$this->_mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6
		
		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$this->_mail->Port = 587;
		
		//Set the encryption mechanism to use - STARTTLS or SMTPS
		$this->_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		
		//Whether to use SMTP authentication
		$this->_mail->SMTPAuth = true;
		
		// Thiết lập thông tin mặc định
		$this->setUsername();
		$this->setPassword();
		$this->setFrom();
		$this->setReplyTo();
	}

	// Thiết lập email gửi
	public function setUsername($username = SEND_EMAIL['username']){
		$this->_mail->Username = $username;
	}

	// Thiết lập password gửi
	public function setPassword($password = SEND_EMAIL['password']){
		$this->_mail->Password = $password;
	}

	// Thiết lập người gửi tin nhắn
	public function setFrom($email = SEND_EMAIL['from'], $name = SEND_EMAIL['name']){
		$this->_mail->setFrom($email, $name);
	}

	// Thiết lập địa chỉ trả lời thay thế
	public function setReplyTo($email = SEND_EMAIL['reply']){
		$this->_mail->addReplyTo($email);
	}
	
	// Thêm địa chỉ email nhận
	public function address($email, $name){
		$this->_mail->addAddress($email, $name);
	}

	// Thiết lập tiêu đề
	public function subject($subject){
		$this->_mail->Subject = $subject;
	}	

	// Phương thức thiết lập nội dung gửi
	public function body($body, $msgHTML = false){
		if($this->_mail && $body){
			if($msgHTML == true){
				$this->_mail->msgHTML($body);
			}else{
				$this->_mail->Body = $body;
			}
		}
	}
	
	// Phương thức gửi email
	public function send($save = false){
		if($this->_mail){		
			if (!$this->_mail->send()) {
				echo 'Mailer Error: '. $this->_mail->ErrorInfo;
			} else {
				if($save == true){
					$this->save();
				}				
			}
		}
	}
	
	// Phương thức lưu email gửi trong hộp thư
	public function save(){
		if($this->_mail){
			//You can change 'Sent Mail' to any other folder or tag
			$path = '{imap.gmail.com:993/imap/ssl}INBOX';
			
			//Tell your server to open an IMAP connection using the same username and password as you used for SMTP
			$imapStream = @imap_open($path, $this->_mail->Username, $this->_mail->Password);
			
			$result = @imap_append($imapStream, $path, $this->_mail->getSentMIMEMessage());
			@imap_close($imapStream);
		}
	}
}
