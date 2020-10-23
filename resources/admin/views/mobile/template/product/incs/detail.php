<?php
if (is_array($data)) {
    return '<div class="theme theme-detail product" data-baricon="back,right">
                <div class="row scrollbarY">
                    <div class="title">
                        <h2>Sản phẩm</h2>
                    </div>
                    <div class="content scrollbarX">
                        <table class="table tb-detail">
                            <tbody>
                                <tr>
                                    <td>Tên sản phẩm</td>
                                    <td id="jsdetailid" data-id="' . $data['products_id'] . '">' . $data['products_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Mã sản phẩm</td>
                                    <td>' . $data['products_key'] . '</td>
                                </tr>                                               
                                <tr>
                                    <td>Đơn vị tính</td>
                                    <td>' . $data['units_name'] . '</td>
                                </tr> 
                                <tr>
                                    <td>Trạng thái</td>
                                    <td>' . $this->status($data['products_status'], 'title') . '</td>
                                </tr>
                                <tr>
                                    <td>Ngày tạo</td>
                                    <td>' . \libs\Func::formatDay($data['products_created']) . '</td>
                                </tr>    
                                <tr>
                                    <td>Người tạo</td>
                                    <td>' . $data['users_name'] . '</td>
                                </tr>                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
}
