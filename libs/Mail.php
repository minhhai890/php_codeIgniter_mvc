<?php

namespace libs;
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

@include Config::get('app.dir.vendor');

class Mail
{

	public $_mail;

	// Phương thức gửi Email khi khởi tạo
	public function __construct()
	{
		//Create
		$this->_mail = new PHPMailer;

		// Config
		$this->config();

		// Information
		$this->information();
	}

	// Thiết lập cấu hình gửi email
	public function config()
	{
		// Language
		$this->_mail->setLanguage('vi');

		//Tell PHPMailer to use SMTP
		$this->_mail->isSMTP();

		//Enable SMTP debugging
		// SMTP::DEBUG_OFF = off (for production use)
		// SMTP::DEBUG_CLIENT = client messages
		// SMTP::DEBUG_SERVER = client and server messages
		$this->_mail->SMTPDebug = 'off'; //SMTP::DEBUG_SERVER;

		//Whether to use SMTP authentication
		$this->_mail->SMTPAuth = true;

		//Set the hostname of the mail server
		$this->_mail->Host = 'smtp.gmail.com';
		// use
		// $mail->Host = gethostbyname('smtp.gmail.com');
		// if your network does not support SMTP over IPv6

		//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
		$this->_mail->Port = 465;

		//Set the encryption mechanism to use - STARTTLS or SMTPS
		$this->_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	}

	// Thiết lập thông tin gửi email
	public function information()
	{
		$config = Config::get('mail');
		$this->setUsername($config['username']);
		$this->setPassword($config['password']);
		$this->setFrom($config['from'], $config['name']);
		$this->setReplyTo($config['reply']);
	}

	// Thiết lập email gửi
	public function setUsername($username)
	{
		$this->_mail->Username = $username;
	}

	// Thiết lập password gửi
	public function setPassword($password)
	{
		$this->_mail->Password = $password;
	}

	// Thiết lập người gửi tin nhắn
	public function setFrom($email, $name = '')
	{
		$this->_mail->setFrom($email, $name);
	}

	// Thiết lập địa chỉ trả lời thay thế
	public function setReplyTo($email)
	{
		$this->_mail->addReplyTo($email);
	}

	// Thiết lập tiêu đề
	public function subject($subject)
	{
		$this->_mail->Subject = $subject;
	}

	// Thêm địa chỉ email nhận
	public function address($email, $name = '')
	{
		$this->_mail->addAddress($email, $name);
	}

	// Thêm địa chỉ email nhận
	public function addCC($email, $name = '')
	{
		$this->_mail->addCC($email, $name);
	}

	// Phương thức thiết lập nội dung gửi
	public function body($body, $msgHTML = false)
	{
		if ($this->_mail && $body) {
			if ($msgHTML == true) {
				$this->_mail->msgHTML($body);
			} else {
				$this->_mail->Body = $body;
			}
		}
	}

	// Phương thức gửi email
	public function send($save = false)
	{
		if ($this->_mail) {
			if (!$this->_mail->send()) {
				echo 'Mailer Error: ' . $this->_mail->ErrorInfo;
			} else {
				if ($save == true) {
					$this->save();
				}
			}
		}
	}

	// Phương thức lưu email gửi trong hộp thư
	public function save()
	{
		if ($this->_mail) {
			//You can change 'Sent Mail' to any other folder or tag
			$path = '{imap.gmail.com:993/imap/ssl}INBOX';

			//Tell your server to open an IMAP connection using the same username and password as you used for SMTP
			$imapStream = @imap_open($path, $this->_mail->Username, $this->_mail->Password);

			$result = @imap_append($imapStream, $path, $this->_mail->getSentMIMEMessage());
			@imap_close($imapStream);
		}
	}
}
