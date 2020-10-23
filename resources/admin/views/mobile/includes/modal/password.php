<?php
return <<<HTML
<div class="absolute auto password">
    <form action="#" method="post">
        <div class="title">
            <h3>Thay đổi mật khẩu</h3>
        </div>
        <div class="content">
            <div class="checkinput inputlabel">
                <label>Tạo mật khẩu mới</label>
                <input type="password" name="password" value="" data-require="true" data-autofocus="true" class="input full checkPassword"/>
            </div>
            <div class="checkinput inputlabel">
                <label>Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm" value="" data-require="true" class="input full confirmPassword"/>
            </div>
        </div>
        <div class="control">
            <input type="submit" class="input full small hover" name="submit" value="Thực hiện" />
        </div>
    </form>
</div>
HTML;