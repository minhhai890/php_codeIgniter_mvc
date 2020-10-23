<?php

use resources\app\libs\Func;

$url = $this->route('app/product/index');
$title = 'Thêm sản phẩm';
$class = 'add';
$listUnit = $this->getItem('units', 'option');
$products_name = $products_key = $products_image = $units_id = '';
if ($data && is_array($data)) {
    $title = 'Chỉnh sửa sản phẩm';
    $class = 'edit';
    extract($data);
    if ($products_image) {
        $image = $this->getFolderView(false, false) . '/images/products/' . Func::getIdStoreLogin() . DS . $products_image;
        $products_image = '<img src="' . $image . '" alt="' . $products_name . '"/>';
    }
}
return <<<HTML
<div class="theme theme-form product" data-baricon="back">
    <form class="form $class" action="$url" data-action="add" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="information scrollbarY">
            <div class="title">
                <h2>$title</h2>
            </div>
            <div class="content scrollbarY">               
                <div class="form-group checkinput inputlabel">
                    <label>Tên sản phẩm</label>
                    <input type="text" name="name" value="$products_name" data-autofocus="true" data-require="true" class="input full" />
                </div>
                <div class="form-group checkinput inputlabel">
                    <label>Mã sản phẩm</label>
                    <input type="text" name="key" value="$products_key" data-require="true" class="input full" />
                </div> 
                <div class="form-group checkinput inputlabel">
                    <label>Hình ảnh</label> <label for="image_upload" class="input custom_input">Tải ảnh</label>      
                    <input type="file" name="image" id="image_upload" hidden accept="image/x-png,image/gif,image/jpeg"/>    
                    <div class="view-img">$products_image</div>
                </div>                
                <div class="form-group checkinput inputlabel">
                    <label>Đơn vị tính *</label>
                    <div class="clearfix">
                        <div class="col col9">
                            <select class="input full" id="select-list-units" name="unitid" data-selected="$units_id">$listUnit</select>   
                        </div>
                        <div class="col col3 aligncenter" style="padding:0 0 0 10px;">
                            <button type="button" class="input full hover popupunit">Thêm</button>
                        </div>
                    </div>                                 
                </div>                                        
            </div>
        </div>
        <div class="control clearfix">
            <div class="col col4 alignleft">
                <input type="reset" class="input hover reset" value="Làm mới" />
            </div>
            <div class="col col8 alignright">
                <input type="submit" class="input hover" name="submit" value="Thực hiện" />
            </div>
        </div>
    </form>
</div>
HTML;
