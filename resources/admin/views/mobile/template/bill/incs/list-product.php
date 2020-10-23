<?php
$str = '<li class="empty">Không có dữ liệu!</li>';
if($data && is_array($data)){
    $str = '';
    foreach($data as $key => $value){
        $str .= '<li>
                    <a title="'.$value['pro_name'].'" data-id="'.$value['pro_id'].'">
                        <div class="clearfix">                            
                            <div class="image col">
                                <img src="'.$this->getPicture(null, $value['pro_keyword']).'" alt="'.$value['pro_keyword'].'" title="'.$value['pro_name'].'">
                            </div>
                            <div class="item col clearfix">
                                <div class="col col6">
                                    <h4 class="overflow">'.$value['pro_name'].'</h4>
                                    <p>SL còn: '.\libs\Func::formatPrice($value['imp_amount_exist']).'</p>
                                </div>
                                <div class="col col3">
                                    <h4>Giá bán</h4>
                                    <p>'.\libs\Func::formatPrice($value['imp_price_seller']).'</p>
                                </div>
                                <div class="col col3">
                                    <h4>Đã đặt</h4>
                                    <form action class="change" method="post">
                                        <input type="text" value="0"/>
                                    </form>                                    
                                </div>
                            </div>                            
                        </div>  
                    </a>                      
                </li>';
    }
}
return $str;
?>