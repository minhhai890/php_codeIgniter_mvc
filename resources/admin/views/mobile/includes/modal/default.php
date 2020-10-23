<?php
$image = $this->getFolderImage(false) . 'loading.svg';
return <<<HTML
<div id="popup" class="fixed">
    <div class="relative">
        <div class="absolute loading">
            <img src="$image" alt="loadding"/>
        </div>
        <div class="absolute alert">
            <div class="title">
                <h3>Thông báo</h3>
            </div>
            <div class="content scrollbarY">
                <p>Nội dung thông báo</p>
            </div>
            <div class="control">
                <input type="button" class="input small hover popupClose" name="close" value="Đóng" />
            </div>
        </div>
        <div class="absolute confirm">
            <div class="title">
                <h3>Thông báo</h3>
            </div>
            <div class="content">
                <p>Nội dung thông báo</p>
            </div>
            <div class="control">
                <input type="button" class="input small hover continue" name="continue" value="Tiếp tục" />
                <input type="button" class="input small hover popupClose" name="cancel" value="Quay lại" />
            </div>            
        </div>
    </div>
    <div class="popupClose"></div>
</div>
HTML;
