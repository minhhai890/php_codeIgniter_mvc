<?php
return <<<HTML
<div class="absolute auto merge">
    <div class="title">
        <h3>Gọp đơn</h3>
        <form name="search" action="#" method="post">
            <input type="text" name="textsearch" value="" class="input small" placeholder="Tìm kiếm..." />
        </form>
    </div>
    <div class="content theme-list bill scrollbarY"></div>
    <div class="control">
        <form action="#" name="submit" method="post">
            <input type="submit" class="input hover" name="submit" value="Thực hiện" />
        </form>
    </div>
</div>
HTML;