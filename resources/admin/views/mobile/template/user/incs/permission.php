<?php
if(is_array($data)){
    $str = $all = '';
    $permissionCurrent = [];
    if($data['user']['role'] != 'all'){       
        if($role = json_decode($data['user']['role'])){
            $permissionCurrent = $role;
        }
    }else{
        $all = ' checked';
    }
    $menu = \libs\Func::recursive($data['menu']);  
    foreach($menu as $value){
        if($value['position']){            
            $checked = (in_array($value['id'], $permissionCurrent)?' checked':$all);
            $str .= '<li><a><label class="label parent-permission">'.$value['name'].'<input type="checkbox" value="'.$value['id'].'" class="checkbox"'.$checked.'/></label></a>';
            if(isset($value['data'])){
                $str .= '<div class="item clearfix">';
                foreach($value['data'] as $v){
                    $str .= '<div class="form-group col col6">
                                <a><label class="label">'.$v['name'].'<input type="checkbox" value="'.$v['id'].'" class="checkbox"'.$checked.'/></label></a>
                            </div>';
                }
                $str .= '</div>';
            }            
        } 
    }
    return '<div class="theme theme-form user" data-baricon="back">
                <div class="row permission scrollbarY">
                    <div class="title">
                        <h2>Phân quyền</h2>
                        <p>(Thiết lập quyền hạng cho tài khoản người dùng theo từng danh mục)</p>
                    </div>
                    <div class="setuser">
                        <h3>Tài khoản: <span>'.$data['user']['email'].'('.($all?'Admin':'Member').')</span></h3>
                    </div>
                    <div class="content scrollbarX"><ul>'.$str.'</ul></div>
                </div>
                <div class="control">
                    <input type="button" class="input small hover submit-permission" name="excute" value="Thực hiện" />
                </div>
            </div>';
}
?>