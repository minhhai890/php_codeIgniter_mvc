<?php
    $str = '';
    $empty = '<li class="empty">Không có dữ liệu!</li>';
    if(is_array($data)){        
        foreach($data as $value){
            $str .= '<li>
                        <a href="'.$this->route('app/inventory/index').'" data-id="'.$value['id'].'" title="'.$value['name'].'">
                            <div class="clearfix">
                                <div class="image"><img src="'.$this->getPicture(null, $value['keyword']).'" alt="'.$value['keyword'].'" title="'.$value['name'].'" /></div>
                                <div class="item">
                                    <div class="row1">
                                        <h3 class="overflow">'.$value['name'].'</h3>
                                        <span class="time">'.$this->convertDate($value['created']).'</span>
                                    </div>
                                    <div class="row3 clearfix">
                                        <p class="address">ĐC: <span>'.$value['address'].'</span></p>                                       
                                    </div>                       
                                </div>
                            </div>
                        </a>
                    </li>';
        }       
    }
    return ($str?$str:$empty);
?>

