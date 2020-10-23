<?php
$items = $this->getItem('print', 'value');
if ($items) {
    extract(json_decode($items, true));
}
?>
<div class="theme them-form setting" data-baricon="left">
    <div class="content scrollbarY clearfix">
        <div class="item shipping-area">
            <div class="title">
                <h2>Sử dụng máy in nhiệt (POS)</h2>
            </div>
            <div class="form">
                <form action="#" method="post" data-continue="false">
                    <div class="row clearfix bdbottom">
                        <div class="col col6">
                            <label class="label">Có
                                <input type="radio" value="1" <?php echo (isset($active) && $active == 1) ? 'checked' : ''; ?> class="radio" name="active" />
                            </label>
                        </div>
                        <div class="col col6">
                            <label class="label">Không
                                <input type="radio" value="0" <?php echo (isset($active) && $active == 0) ? 'checked' : ''; ?> class="radio" name="active" />
                            </label>
                        </div>
                    </div>
                    <div class="row bdbottom printtemp">
                        <h4>Mẫu in đơn hàng</h4>
                        <div class="clearfix printbutton">
                            <div class="col col4">
                                <label class="label">Mẫu 1
                                    <input type="radio" value="1" <?php echo (isset($printtemp01) && $printtemp01 == 1) ? 'checked' : ''; ?> class="radio" name="printtemp01" />
                                </label>
                            </div>
                            <div class="col col4">
                                <label class="label">Mẫu 2
                                    <input type="radio" value="2" <?php echo (isset($printtemp01) && $printtemp01 == 2) ? 'checked' : ''; ?> class="radio" name="printtemp01" />
                                </label>
                            </div>
                            <div class="col col4">
                                <label class="label">Mẫu 3
                                    <input type="radio" value="3" <?php echo (isset($printtemp01) && $printtemp01 == 3) ? 'checked' : ''; ?> class="radio" name="printtemp01" />
                                </label>
                            </div>
                        </div>
                        <div class="printview">
                            <img src="<?= $this->getFolderImage(false) ?>printview01.png" alt="">
                        </div>
                    </div>
                    <div class="row bdbottom printtemp">
                        <h4>Mẫu in gửi đơn hàng</h4>
                        <div class="clearfix printbutton">
                            <div class="col col4">
                                <label class="label">Mẫu 1
                                    <input type="radio" value="1" <?php echo (isset($printtemp02) && $printtemp02 == 1) ? 'checked' : ''; ?> class="radio" name="printtemp02" />
                                </label>
                            </div>
                            <div class="col col4">
                                <label class="label">Mẫu 2
                                    <input type="radio" value="2" <?php echo (isset($printtemp02) && $printtemp02 == 2) ? 'checked' : ''; ?> class="radio" name="printtemp02" />
                                </label>
                            </div>
                            <div class="col col4">
                                <label class="label">Mẫu 3
                                    <input type="radio" value="3" <?php echo (isset($printtemp02) && $printtemp02 == 3) ? 'checked' : ''; ?> class="radio" name="printtemp02" />
                                </label>
                            </div>
                        </div>
                        <div class="printview">
                            <img src="<?= $this->getFolderImage(false) ?>printview01.png" alt="">
                        </div>
                    </div>
                    <div class="row printtemp">
                        <h4>Mẫu in chốt đơn</h4>
                        <div class="clearfix printbutton">
                            <div class="col col4">
                                <label class="label">Mẫu 1
                                    <input type="radio" value="1" <?php echo (isset($printtemp03) && $printtemp03 == 1) ? 'checked' : ''; ?> class="radio" name="printtemp03" />
                                </label>
                            </div>
                            <div class="col col4">
                                <label class="label">Mẫu 2
                                    <input type="radio" value="2" <?php echo (isset($printtemp03) && $printtemp03 == 2) ? 'checked' : ''; ?> class="radio" name="printtemp03" />
                                </label>
                            </div>
                            <div class="col col4">
                                <label class="label">Mẫu 3
                                    <input type="radio" value="3" <?php echo (isset($printtemp03) && $printtemp03 == 3) ? 'checked' : ''; ?> class="radio" name="printtemp03" />
                                </label>
                            </div>
                        </div>
                        <div class="printview">
                            <img src="<?= $this->getFolderImage(false) ?>printview01.png" alt="">
                        </div>
                    </div>
                    <div class="control">
                        <input type="submit" name="submit" value="Thực hiện" class="input small hover setprint" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>