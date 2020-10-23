<?php
if(is_array($data)){
    return '<div class="theme theme-detail inventory" data-baricon="back,right">
                <div class="row scrollbarY">
                    <div class="title">
                        <h2>Kho bãi</h2>
                    </div>
                    <div class="content scrollbarX">
                        <table class="table tb-detail">
                            <tbody>
                                <tr>
                                    <td>Tên kho</td>
                                    <td id="jsdetailid" data-id="'.$data['id'].'">'.$data['name'].'</td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ</td>
                                    <td>'.$data['address'].'</td>
                                </tr>
                                <tr>
                                    <td>Ghi chú</td>
                                    <td>'.$data['note'].'</td>
                                </tr>                               
                                <tr>
                                    <td>Ngày tạo</td>
                                    <td>'.\libs\Func::formatDay($data['created']).'</td>
                                </tr>                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
}
?>