<?php
$url = $this->route('app/user/index');
return <<<HTML
<div class="theme theme-form user" data-baricon="back">
    <form class="form add" action="$url" method="post" autocomplete="off">
        <div class="information scrollbarY">
            <div class="title">
                <h2>Thêm mới</h2>
            </div>
            <div class="content scrollbarY">
                <div class="form-group checkinput inputlabel">
                    <label>Họ và tên</label>
                    <input type="text" name="name" value="" data-autofocus="true" data-require="true" class="input full" />
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" value="" class="input full checkNumeric checkPhone" />
                </div> 
                <div class="form-group checkinput inputlabel">
                    <label>Địa chỉ email</label>
                    <input type="text" name="email" value="" data-require="true" class="input full checkEmail" />
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" value="" data-require="true" class="input full checkPassword"/>
                </div>                               
            </div>
        </div>
        <div class="control clearfix">
            <div class="col col4 alignleft">
                <input type="reset" class="input small hover reset" value="Làm mới" />
            </div>
            <div class="col col8 alignright">
                <input type="submit" class="input small hover" name="submit" value="Thực hiện" />
            </div>
        </div>
    </form>
</div>
HTML;
