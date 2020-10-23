
<?php
return <<<HTML
<div class="absolute auto reason">
    <form action="#" method="post">
        <div class="title">
            <h3>Tiêu đề</h3>
        </div>
        <div class="content">
            <div class="checkinput inputlabel">
                <label>Nội dung</label>
                <textarea rows="3" name="content" data-require="true" data-autofocus="true" class="input full"></textarea>
            </div>
        </div>
        <div class="control">
            <input type="submit" class="input full small hover" name="submit" value="Thực hiện" />
        </div>
    </form>
</div>
HTML;