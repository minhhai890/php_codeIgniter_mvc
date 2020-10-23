<?php
if ($data && is_array($data)) {
    $url = $this->route('app/import/index');
    extract($data);
    return <<<HTML
<div class="theme theme-form import" data-baricon="back">
    <form class="form confirmimport" action="$url" method="post" autocomplete="off">
        <div class="information scrollbarY">
            <div class="title">
                <h2>Xác nhận nhập kho</h2>
            </div>
            <div class="content scrollbarY">
                <div class="form-group">
                    <label>Lưu kho</label>
                    <input type="text" value="$inventorys_name" class="input full" disabled/>
                </div>
                <div class="form-group">
                    <label>Tên sản phẩm</label>
                    <input type="text" value="$products_name" class="input full" disabled/>
                </div>
                <div class="form-group">
                    <label>Mã sản phẩm</label>
                    <input type="text" value="$products_key" class="input full" disabled/>
                </div>
                <div class="form-group">
                    <label>Đơn vị tính</label>
                    <input type="text" value="$units_name" class="input full" disabled/>
                </div>
                <div class="form-group">
                    <label>Số lượng nhập</label>
                    <input type="text" value="$imports_amount_import" class="input full" disabled/>
                </div>                
                <div class="form-group checkinput inputlabel">
                    <label>Xác nhận số lượng nhập</label>
                    <input type="text" name="amount" value="" data-autofocus="true" data-require="true" class="input full formatNumeric"/>
                </div> 
                <div class="form-group checkinput inputlabel">
                    <label>Ghi chú</label>
                    <textarea name="note" rows="5" class="input full checkEmpty"></textarea>                    
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
}