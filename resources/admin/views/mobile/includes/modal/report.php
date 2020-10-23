<?php
return <<<HTML
<div class="absolute auto report">
    <form action="#" method="post">
        <div class="title">
            <h3>Báo cáo</h3>
        </div>
        <div class="content">
            <div class="form-csid hidden">
                <input type="text" name="csid" value="" class="input full" placeholder="Nhập mã khách hàng" />
            </div>
            <div class="form-all">
                <label>Từ ngày</label>
                <input type="text" name="inputfrom" value="" class="input full datepick inputfrom" data-millisecond="" />
                <label>Đến ngày</label>
                <input type="text" name="inputto" value="" class="input full datepick inputto" data-millisecond="" />
            </div>
        </div>
        <div class="control">
            <input type="submit" class="input full small hover" name="submit" value="Thực hiện" />
        </div>
    </form>
</div>
HTML;