<div class="theme them-form setting" data-baricon="left">
    <div class="content scrollbarY clearfix">
        <div class="item shipping">
            <div class="title">
                <h2>Đơn vị vận chuyển</h2>
            </div>
            <div class="form">
                <form action="#" method="post" data-continue="false">
                    <div class="row listpost">
                        <?php $post = $this->getItem('post', 'value'); ?>
                        <div>
                            <label class="label">
                                <input type="radio" class="radio" <?php echo ($post == 'vnpost' ? 'checked' : '') ?>
                                    value="vnpost" name="post" />
                                <img src="<?= $this->getFolderImage(false) ?>vnpost-logo.png">
                            </label>
                        </div>
                        <div>
                            <label class="label">
                                <input type="radio" class="radio" <?php echo ($post == 'viettepost' ? 'checked' : '') ?>
                                    value="viettepost" name="post" />
                                <img src="<?= $this->getFolderImage(false) ?>viettel-logo.png">
                            </label>
                        </div>
                        <div>
                            <label class="label">
                                <input type="radio" class="radio" <?php echo ($post == 'ghnpost' ? 'checked' : '') ?>
                                    value="ghnpost" name="post" />
                                <img src="<?= $this->getFolderImage(false) ?>ghn-logo.png">
                            </label>
                        </div>
                        <div>
                            <label class="label">
                                <input type="radio" class="radio" <?php echo ($post == 'ghtkpost' ? 'checked' : '') ?>
                                    value="ghtkpost" name="post" />
                                <img src="<?= $this->getFolderImage(false) ?>ghtk-logo.png">
                            </label>
                        </div>
                    </div>
                    <div class="notification">
                        <p><strong>Lưu ý: </strong>Lựa chọn đơn vị vận chuyển cho cửa hàng</p>
                    </div>
                    <div class="control">
                        <input type="submit" name="submit" value="Thực hiện" class="input small hover setpost" />
                    </div>
                </form>
            </div>
        </div>
        <div class="item shipping-new hidden">
            <div class="title">
                <h2>Tính tiền cước cho tạo mới đơn hàng</h2>
            </div>
            <div class="form">
                <form action="#" method="post" data-continue="false">
                    <div class="row">
                        <div>
                            <label class="label">Cước vận chuyển
                                <input type="radio" class="radio" value="" name="newbill" />
                            </label>
                        </div>
                        <div>
                            <label class="label">Cước cố định
                                <input type="radio" class="radio" value="" name="newbill" />
                            </label>
                        </div>
                        <div>
                            <label class="label">Miễn cước
                                <input type="radio" class="radio" value="" name="newbill" />
                            </label>
                        </div>
                    </div>
                    <div class="notification">
                        <p><strong>Lưu ý: </strong>Lựa chọn hình thức tính ship cho đơn hàng mới</p>
                    </div>
                    <div class="control">
                        <input type="submit" name="submit" value="Thực hiện" class="input small hover" />
                    </div>
                </form>
            </div>
        </div>
        <div class="item shipping-area hidden">
            <div class="title">
                <h2>Cài đặt tiền cước cố định</h2>
            </div>
            <div class="form">
                <form action="#" method="post" data-continue="false">
                    <div class="row clearfix bdbottom">
                        <div class="col col6">
                            <label class="label">Có
                                <input type="radio" class="radio" value="" name="" />
                            </label>
                        </div>
                        <div class="col col6">
                            <label class="label">Không
                                <input type="radio" class="radio" value="" name="" />
                            </label>
                        </div>
                    </div>
                    <div class="row bdbottom">
                        <div>
                            <label>Nhập giá tiền</label>
                            <input type="text" class="input full" value="20000" name="" />
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <label>Chọn tỉnh / TP</label>
                            <input type="text" class="input full" value="" name="" />
                            <div class="listaddress hidden">
                                <ul class="scrollbarY">
                                    <li data-province="79" data-district="" class="active">Thành phố Hồ Chí Minh</li>
                                    <li data-province="92" data-district="">Thành phố Cần Thơ</li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <ul class="list-area">
                                <li data-id="">
                                    <a href="#" class="remove-area" data-provinceid="79" title=""><i
                                            class="fas fa-times"></i></a>Thành phố Hồ Chí Minh
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="notification">
                            <p><strong>Lưu ý: </strong> Tiền cước cố định đơn vị tính nghìn đồng (VD: 35000 hoặc 35,000)
                            </p>
                        </div>
                    </div>
                    <div class="control">
                        <input type="submit" name="submit" value="Thực hiện" class="input small hover" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>