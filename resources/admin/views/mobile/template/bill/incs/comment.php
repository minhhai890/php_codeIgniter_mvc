<?php
if($data && is_array($data)){
    $idx = 0;
    $title = '';
    $row = '';
    $str = '';
    foreach($data as $value){
        if($idx != $value['tpt_idx']){           
            $idx = $value['tpt_idx'];
            $title = '<h4>Thời gian: '.\libs\Func::formatDay($value['tpt_created']).'</h4>';
            if($row){
                $str .= $title . '<table class="table">' . $row . '</table>';
            }
            $row = '';
        }
        $row .= '<tr>
                    <td><a href="'.$value['tpt_link'].'" target="_blank">Xem</a></td>
                    <td>'.$value['tcm_message'].'</td>
                </tr>';
    }
    return $str . $title . '<table class="table">' . $row . '</table>';
}
return '<table class="table"><tr><td class="empty aligncenter" colspan="2">Chưa có bình luận</td></tr></table>';
?>