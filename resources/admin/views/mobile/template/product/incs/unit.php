<?php
$units = [
    'option' => '<option value="0" class="empty">Chọn đơn vị tính</option>', 
    'tr' => '<tr><td colspan="2" class="empty">Không có dữ liệu!</td></tr>'
];
if($data && is_array($data)){
    $units['tr'] = $units['option'] = '';
    foreach($data as $key => $value){
        $units['tr']       .= '<tr><td>'. ($key+1) .'</td><td>'.$value['name'].'</td></tr>';
        $units['option']   .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
}
return $units;
?>