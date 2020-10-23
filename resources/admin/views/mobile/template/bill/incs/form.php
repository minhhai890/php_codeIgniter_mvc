<?php
$cls = 'add';
$title = 'Thêm mới';
$tcs_name = $tcs_phone = $tcs_email = $tcs_profileid = $tcs_note = '';
$tad_provinceid = $tad_districtid = $tad_wardid = $tad_province = $tad_district = $tad_ward = $tad_address = '';
if($data && is_array($data)){
    $cls = 'edit';
    $title = 'Chỉnh sửa';
    extract($data);
    if($phone = json_decode($tcs_phone, true)){
        $tcs_phone = $phone['default'];
    }
    if(($profile = json_decode($tcs_profileid, true)) && isset($profile['uid'])){    
        $tcs_profileid = $profile['uid'];
    }else{
        $tcs_profileid = '';
    }
}
return <<<HTML
<div class="theme theme-form bill" data-baricon="back">
    <form class="form $cls" action="" method="post" autocomplete="off">
        <div class="information scrollbarY">
            <div class="title">
                <h2>$title</h2>
            </div>
            <div class="content">
                <div class="form-group checkinput inputlabel">
                    <label>Tên khách hàng</label>
                    <input type="text" name="name" value="$tcs_name" class="input full capitalize" data-require="true" data-autofocus="true"/>
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" value="$tcs_phone" class="input full checkPhone"/>
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Địa chỉ Email</label>
                    <input type="text" name="email" value="$tcs_email" class="input full checkEmail"/>
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Social ID <a href="#" class="get-uid" title="Click vào đây để lấy uid facebook">FB UID</a></label>
                    <input type="text" name="profileid" value="$tcs_profileid" class="input full checkNumeric checkEmpty"/>
                </div>
                <div class="form-group checkinput inputlabel form-address">
                    <label>Tỉnh / TP</label>
                    <input type="text" name="province" data-province="$tad_provinceid" value="$tad_province" class="input full capitalize checkEmpty"/>                   
                </div>
                <div class="form-group checkinput inputlabel form-address">
                    <label>Quận / huyện</label>
                    <input type="text" name="district" data-district="$tad_districtid" value="$tad_district" class="input full capitalize checkEmpty"/>
                </div>
                <div class="form-group checkinput inputlabel form-address">
                    <label>Phường / xã</label>
                    <input type="text" name="ward" data-ward="$tad_wardid" value="$tad_ward" class="input full capitalize checkEmpty"/>
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" value="$tad_address" class="input full capitalize checkEmpty"/>
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Ghi chú</label>
                    <textarea rows="4" name="note" class="input full capitalize checkEmpty">$tcs_note</textarea>
                </div>
            </div>
        </div>
        <div class="control clearfix">
            <div class="col alignleft">
                <input type="reset" class="input small hover" value="Làm mới"/>
            </div>
            <div class="col alignright">
                <input type="submit" class="input small hover" name="submit" value="Thực hiện"/>
            </div>
        </div>
    </form>
</div>
HTML;
?>