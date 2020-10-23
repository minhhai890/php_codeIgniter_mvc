<?php
if(is_array($data)){
    return '<!DOCTYPE html><html><body>
				<table style="max-width: 600px; margin: auto; border: 1px solid #CCC">
       				<tr>
            			<td style="padding: 15px; background: #F8F8F8" valign="top">
            				<a href="'.$this->route('home').'" target="_blank" style="color: blue; text-decoration: underline;">
                    			<img src="'.$this->getFolderImage(false).'thunganonline.png" alt="Thu Ngân Online" width="30%" height="auto" style="display: block;" />
                			</a>
            			</td>
       				 </tr>
        			<tr>
	        			<td>
				            <table style="padding: 20px; width: 100%">
				                <tr>
				                    <td style="padding: 10px 0">
				                        Kính chào quý khách hàng '.$data['name'].',
				                    </td>
				                </tr>
				                <tr>
				                    <td style="padding: 10px 0">
				                        Cảm ơn quý khách đã tin tưởng và sử dụng dịch vụ <a href="'.$this->route('home').'" target="_blank" style="color: blue; text-decoration: underline;">thunganonline.com</a>
				                    </td>
				                </tr>
				                <tr>
				                    <td style="padding: 10px 0">
				                        Quý khách vui lòng vào đây để <a href="'.$data['url'].'" target="_blank" style="color: blue; text-decoration: underline;">Xác nhận tài khoản</a> và sử dụng phần mềm quản lý bán hàng <a href="'.$this->route('home').'" target="_blank" style="color: blue; text-decoration: underline;">thunganonline.com</a>
				                    </td>
				                </tr>
				                <tr>
				                    <td style="padding: 25px 0 0 0; text-align: center;">
				                        <a href="'.$this->route('home').'" target="_blank" style="color: blue; text-decoration: underline; padding: 0 10px; border-right: 1px solid #CCC">Trang chủ</a>
				                        <a href="'.$this->route('register').'" target="_blank" style="color: blue; text-decoration: underline; padding: 0 10px; border-right: 1px solid #CCC">Đăng ký</a>
				                        <a href="https://app.thunganonline.com" target="_blank" style="color: blue; text-decoration: underline; padding: 0 10px">Đăng nhập</a>
				                        <span style="display: block; font-size: 13px;">Copyright © thunganonline.com | All rights reserved.</span>
				                    </td>
				                </tr>
				            </table>
		        		</td>
        			</tr>
    			</table>
			</body></html>';
}
?>