<?php
$column = $status = $timefrom = $timeto = '';
if($data = \libs\Session::get(APPLOGIN['SESSION_LOGIN'])){    
    extract($data['search']);
}
return '
<div class="absolute auto search">
    <div class="title">
        <h3>Cài đặt tìm kiếm</h3>
        <form action="#" method="post">
            <input type="submit" name="submit" value="Thực hiện" class="input hover" />
        </form>
    </div>   
    <div class="content scrollbarY" data-column="'.$column.'" data-status="'.$status.'" data-timefrom="'.$timefrom.'" data-timeto="'.$timeto.'">                
        <div class="clearfix">
            <h4>Giá trị</h4>
            <div class="col col6">
                <label class="label">
                    Tên khách hàng
                    <input type="radio" name="column" class="radio" value="name" />
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Điện thoại
                    <input type="radio" name="column" class="radio" value="phone" />
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Mã đơn hàng
                    <input type="radio" name="column" class="radio" value="madon" />
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Mã vận đơn
                    <input type="radio" name="column" class="radio" value="mavandon" />
                </label>
            </div>
        </div>
        <div class="clearfix">
            <h4>Trạng thái</h4>
            <div class="col col6">
                <label class="label">
                    Đơn mới
                    <input type="checkbox" name="status" class="checkbox" value="'.STATUS['UNSEND'].'"/>
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Đã gửi
                    <input type="checkbox" name="status" class="checkbox" value="'.STATUS['SEND'].'"/>
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Chưa nhận
                    <input type="checkbox" name="status" class="checkbox" value="'.STATUS['UNRECEIVED'].'"/>
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Đã nhận
                    <input type="checkbox" name="status" class="checkbox" value="'.STATUS['RECEIVED'].'"/>
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Thanh toán
                    <input type="checkbox" name="status" class="checkbox" value="'.STATUS['SUCCESS'].'"/>
                </label>
            </div>
            <div class="col col6">
                <label class="label">
                    Đơn hủy & hoàn
                    <input type="checkbox" name="status" class="checkbox" value="'.STATUS['RETURN'].'"/>
                </label>
            </div>
        </div>
        <div class="clearfix">
            <h4>Thời gian</h4>
            <div class="col col6">
                <label>Từ ngày</label>
                <input type="text" name="timefrom" value="" class="datepick input full" data-millisecond="" />
            </div>
            <div class="col col6">
                <label>Đến ngày</label>
                <input type="text" name="timeto" value="" class="datepick input full" data-millisecond="" />
            </div>
        </div>
    </div>
</div>';