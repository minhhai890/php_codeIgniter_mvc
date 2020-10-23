<?php
use resources\app\libs\Func;
if($data && is_array($data)){ 
    extract($data);    
    $phone = '';
    if($arPhone = json_decode($tcs_phone, true)){
        if(isset($arPhone['default'])){
            $phone = $arPhone['default'];
        }
    } 
    $tbl_price = \libs\Func::formatPrice($tbl_price);
    $tbl_ship_post_price = \libs\Func::formatPrice($tbl_ship_post_price);
    $tbl_collect = \libs\Func::formatPrice($tbl_collect);
    $shipidx = ($tbl_ship_idx?'/<strong>$tbl_ship_idx</strong>':'');    
    $created = Func::formatDay($tbl_created);
    $send = ($tbl_send?'<span class="send">Ngày gửi: <span>'.Func::formatDay($tbl_send).'</span></span>':'');
    $tbody = '';
    if(isset($products) && $products){
        foreach($products as $key => $value){
            $tbody .= '<tr data-id="'.$value['pro_id'].'">
                            <td class="delete">'.($key+1).'</td>
                            <td class="update align-left" data-name="name">'.$value['pro_name'].'</td>                           
                            <td class="update" data-name="amount">'.Func::formatPrice($value['det_amount']).'</td>
                            <td class="update alignright" data-name="price">'.Func::formatPrice($value['det_price_seller']).'</td>
                            <td class="alignright">'.Func::formatPrice($value['det_price_export']).'</td>
                        </tr>';
        }
    }
    $note = $this->getItem('default', 'setting_note2');
return <<<HTML
<div class="theme theme-detail bill" data-baricon="back,right">
    <div class="information scrollbarY">       
        <div class="title">
            <h2>Đơn hàng</h2>
        </div>
        <div class="customer">            
            <p class="name overflow">
                Khách hàng: <a id="jsdetailid" href="$tcs_link" target="_blank" title="$tcs_keyword" data-id="$tbl_id" data-cid="$tcs_id">$tcs_name</a>
            </p>
            <p class="phone">Điện thoại: <a href="tel:$phone">$phone</a></p>
            <p class="address">Địa chỉ: <strong>$tad_fulladdress</strong></p>
            <p class="code">Mã đơn: <strong>$tbl_id</strong>$shipidx</p>
            <p class="time"><span>Ngày tạo: <span class="create">$created</span></span>$send</p>
        </div>
        <div class="content scrollbarX">
            <table class="table">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>S.phẩm</td>
                        <td>SL</td>
                        <td>Đ.giá</td>
                        <td>T.tiền</td>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">Tổng tiền</td>
                        <td class="alignright">$tbl_price</td>
                    </tr>                                
                    <tr>
                        <td colspan="4">Tiền vận chuyển</td>
                        <td class="alignright">$tbl_ship_post_price</td>
                    </tr>
                    <tr>
                        <td colspan="4">Thanh toán</td>
                        <td class="alignright">$tbl_collect</td>
                    </tr>
                </tfoot>
                <tbody>$tbody</tbody>
            </table>
        </div>
        <div class="note">$tcs_note$note</div>       
    </div>
    <div class="control">
        <div class="row1">
            <form action="" method="post" class="clearfix" autocomplete="off">                
                <input class="input full addproduct" type="text" placeholder="Thêm sản phẩm..."/>                              
            </form>
        </div>
        <div class="row2">
            <form action="" method="post" class="clearfix" autocomplete="off">
                <div class="col col6 alignleft">
                    <input type="button" class="input hover" name="send" value="In &amp; Gửi" title="In &amp; Gửi"/>
                    <input type="button" class="input hover" name="send" value="Gửi" title="Gửi"/>
                </div>
                <div class="col col6 alignright">
                    <input type="button" class="input hover" name="success" value="Thanh toán" title="Thanh toán đơn hàng"/>
                </div>
            </form>
        </div>
    </div>
</div>
HTML;
}?>