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
                                        Kính chào quý khách hàng '.$data['conname'].',
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0">
                                        Một yêu cầu hỗ trợ của quý khách đã được tạo ra tại website: <a href="'.$this->route('home').'" target="_blank" style="color: blue; text-decoration: underline;">thunganonline.com</a> và chúng tôi sẽ phản hồi ngay với quý khách trong thời gian sớm nhất.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0">
                                        Chúng tôi luôn sẵn sàng hỗ trợ quý khách 24/7/365 và quý khách có thể cần đợi khoảng từ 5 - 20 phút để chúng tôi xem xét yêu cầu hỗ trợ của quý khách. Tuy nhiên trong một số trường hợp thời gian phản hồi sẽ có thể lâu hơn với các vấn đề phức tạp.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0">
                                        Quý khách sẽ nhận được một thông báo qua email ngay khi <a href="'.$this->route('home').'" target="_blank" style="color: blue; text-decoration: underline;">thunganonline.com</a> phản hồi trong yêu cầu hỗ trợ.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0">
                                            Nội dung: '.$data['conmessage'].'
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