<?php
$url = $this->route('app/inventory/index');
$title = 'Thêm mới';
$class = 'add';
$name = $address = $note = '';
if (is_array($data) && $data) {
    $title = 'Chỉnh sửa';
    $class = 'edit';
    extract($data);
}
return <<<HTML
<div class="theme theme-form inventory" data-baricon="back">
    <form class="form $class" action="$url" method="post" autocomplete="off">
        <div class="information scrollbarY">
            <div class="title">
                <h2>$title</h2>
            </div>
            <div class="content scrollbarY">
                <div class="form-group checkinput inputlabel">
                    <label>Tên kho</label>
                    <input type="text" name="name" value="$name" data-autofocus="true" data-require="true" class="input full" />
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" value="$address" data-require="true" class="input full" />
                </div> 
                <div class="form-group checkinput inputlabel">
                    <label>Ghi chú</label>
                    <textarea name="note" rows="5" class="input full checkEmpty">$note</textarea>                    
                </div>                                        
            </div>
        </div>
        <div class="control clearfix">
            <div class="col col4 alignleft">
                <input type="reset" class="input small hover reset" value="Làm mới" />
            </div>
            <div class="col col8 alignright">
                <input type="submit" class="input small hover submitadd" name="submit" value="Thực hiện" />
            </div>
        </div>
    </form>
</div>
HTML;
