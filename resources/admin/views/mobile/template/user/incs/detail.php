<?php
if(is_array($data)){
    return '<div class="theme theme-detail user" data-baricon="back,right">
                <div class="row scrollbarY">
                    <div class="title">
                        <h2>Tài khoản</h2>
                    </div>
                    <div class="content scrollbarX">
                        <table class="table tb-detail">
                            <tbody>
                                <tr>
                                    <td>Họ và tên</td>
                                    <td id="jsdetailid" data-id="'.$data['id'].'">'.$data['name'].'</td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ email</td>
                                    <td>'.$data['email'].'</td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại</td>
                                    <td>'.$data['phone'].'</td>
                                </tr>                               
                                <tr>
                                    <td>Ngày tạo</td>
                                    <td>'.\libs\Func::formatDay($data['created']).'</td>
                                </tr>
                                <tr>
                                    <td>Chức vụ</td>
                                    <td>'.($data['role'] == 'all'?'Quản lý':'Nhân viên').'</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
}
?>