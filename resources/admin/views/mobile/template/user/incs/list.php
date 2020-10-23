<?php
    $str = '';
    $empty = '<li class="empty">Không có dữ liệu!</li>';
    if(is_array($data)){      
        foreach($data as $value){
            $str .= '<li>
                        <a href="'.$this->route('app/user/index').'" data-id="'.$value['id'].'" title="'.$value['name'].'">
                            <div class="clearfix">
                                <div class="image"><img class="circle" src="'.$this->getPicture(null, $value['keyword']).'" alt="'.$value['keyword'].'" title="'.$value['name'].'" /></div>
                                <div class="item">
                                    <div class="row1">
                                        <h3 class="overflow">'.$value['name'].'</h3>
                                        <span class="time">'.$this->convertDate($value['created']).'</span>
                                    </div>
                                    <div class="row2 clearfix">
                                        <p class="username">Email: <strong>'.$value['email'].'</strong></p>
                                        <p class="phone">Phone: <strong>'.$value['phone'].'</strong></p> 
                                    </div>                       
                                </div>
                            </div>
                        </a>
                    </li>';
        }
    }  
    return ($str?$str:$empty);   
?>