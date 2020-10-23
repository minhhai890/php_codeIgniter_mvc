<div class="theme theme-form setting" data-baricon="left">
    <form class="form" action="" method="post" autocomplete="off">
        <div class="information scrollbarY">
            <div class="title">
                <h2>Cài đặt thông tin</h2>
            </div>
            <div class="content">
                <div class="form-group">
                    <label>Tên cửa hàng *</label>
                    <input type="text" name="name" value="<?= $this->getData('name') ?>" class="input full" />
                </div>
                <div class="form-group">
                    <label>Số điện thoại 1 *</label>
                    <input type="text" name="phone1" value="<?= $this->getData('phone1') ?>" class="input full" />
                </div>
                <div class="form-group">
                    <label>Số điện thoại 2</label>
                    <input type="text" name="phone2" value="<?= $this->getData('phone2') ?>" class="input full" />
                </div>
                <div class="form-group">
                    <label>Địa chỉ cửa hàng *</label>
                    <input type="text" name="address" value="<?= $this->getData('address') ?>" class="input full" />
                </div>
                <div class="form-group">
                    <label>Ghi chú phiếu in đơn hàng</label>
                    <textarea name="note1" class="input full ckeditor"
                        ck-code-1='note1'><?= $this->getData('note1') ?></textarea>
                </div>
                <div class="form-group">
                    <label>Ghi chú đơn hàng</label>
                    <textarea name="note2" class="input full ckeditor"
                        ck-code-2='note2'><?= $this->getData('note2') ?></textarea>
                </div>
            </div>
        </div>
        <div class="control">
            <div class="alignright">
                <input type="submit" name="submit" value="Thực hiện" class="input hover setinfo" />
            </div>
        </div>
    </form>
</div>