<?php
return <<<HTML
<div class="absolute auto uid">
    <form action="#" method="post" autocomplete="off">
        <div class="title">
            <h3>Lấy uid facebook</h3>
        </div>
        <div class="content">
            <label>Đường dẫn url</label>
            <input type="text" class="input full" name="url" value="" data-autofocus="true" placeholder="https://www.facebook.com/YourProfileName" />
        </div>
        <div class="result"></div>
        <div class="control">
            <input type="submit" class="input full small hover" name="get-uid" value="Thực hiện" />
        </div>
    </form>
</div>
HTML;