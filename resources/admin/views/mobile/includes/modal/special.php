<?php
return <<<HTML
<div class="absolute auto special">
    <form action="#" method="post">
        <div class="title">
            <h3>Giảm giá</h3>
        </div>
        <div class="content">
            <div class="checkinput inputlabel">
                <label>Số tiền</label>
                <input type="text" name="price" value="" data-require="true" data-autofocus="true" class="input full formatNumeric"/>
            </div>
        </div>
        <div class="control">
            <input type="submit" class="input full small hover" name="submit" value="Thực hiện"/>
        </div>
    </form>
</div>
HTML;