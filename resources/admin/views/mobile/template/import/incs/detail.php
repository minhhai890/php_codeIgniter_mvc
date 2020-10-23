<?php
if (is_array($data)) {
    return '<div class="theme theme-detail import" data-baricon="back">
                <div class="row scrollbarY">
                    <div class="title">
                        <h2>Chi tiết</h2>
                    </div>
                    <div class="content scrollbarX">
                        <table class="table tb-detail">
                            <tbody>
                                <tr>
                                    <td>Mã sản phẩm</td>
                                    <td>' . $data['products_key'] . '</td>
                                </tr>
                                <tr>
                                    <td>Lưu kho</td>
                                    <td>' . $data['inventorys_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Tên sản phẩm</td>
                                    <td id="jsdetailid" data-id="' . $data['imports_id'] . '" data-proid="' . $data['products_id'] . '">' . $data['products_name'] . '</td>
                                </tr>                               
                                <tr>
                                    <td>Số lượng nhập</td>
                                    <td>' . \libs\Func::formatPrice($data['imports_amount_import']) . '</td>
                                </tr>
                                <tr>
                                    <td>Số lượng tồn</td>
                                    <td>' . \libs\Func::formatPrice($data['imports_amount_exist']) . '</td>
                                </tr>                                                         
                                <tr>
                                    <td>Đơn vị tính</td>
                                    <td>' . $data['units_name'] . '</td>
                                </tr> 
                                <tr>
                                    <td>Trạng thái</td>
                                    <td>' . $this->status($data['imports_status'], 'title') . '</td>
                                </tr>   
                                <tr>
                                    <td>Người nhập</td>
                                    <td>' . $data['users_name'] . '</td>
                                </tr>  
                                <tr>
                                    <td>Ghi chú</td>
                                    <td>' . $data['imports_note'] . '</td>
                                </tr>                            
                                <tr>
                                    <td>Ngày nhập</td>
                                    <td>' . \libs\Func::formatDay($data['imports_modified']) . '</td>
                                </tr>                     
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
}