<div class="theme theme-form invoice">
    <form class="form" action="#" method="post" autocomplete="off">
        <div class="information scrollbarY">
            <div class="title">
                <h2>Thêm mới</h2>
            </div>
            <div class="content">
                <div class="form-group"><label>Họ &amp; tên</label><input type="text" name="fullname" value="" class="input full" /></div>
                <div class="form-group"><label>Số điện thoại</label><input type="text" name="phone" value="" class="input full" /></div>
                <div class="form-group"><label>Số tiền</label><input type="text" name="price" value="" class="input full formattedNumberField" /></div>
                <div class="form-group form-address"><label>Tỉnh / TP</label><input type="text" name="provinces" data-province="" data-district="" value="" class="input full" /></div>
                <div class="form-group form-address"><label>Quận / huyện</label><input type="text" name="districts" data-province="" data-district="" value="" class="input full" /></div>
                <div class="form-group form-address"><label>Phường / xã</label><input type="text" name="wards" data-province="" data-district="" value="" class="input full" /></div>
                <div class="form-group"><label>Địa chỉ</label><input type="text" name="address" value="" class="input full" /></div>
                <div class="form-group"><label>Nội dung</label><textarea rows="4" name="content" class="input full"></textarea></div>
                <div class="form-group aligncenter clearfix">
                    <div class="col">
                        <label class="label">Tiêu dùng <input type="radio" name="category" value="consumption" class="radio"/></label>
                    </div>
                    <div class="col">
                        <label class="label">Kinh doanh <input type="radio" name="category" value="business" class="radio"/></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="control clearfix no-print">
            <div class="col col6 alignleft">
                <input type="reset" class="input small hover" value="Làm mới" />
            </div>
            <div class="col col6 alignright">
                <input type="submit" class="input small hover" name="submit" value="Thực hiện" />
            </div>
        </div>
    </form>
</div>
