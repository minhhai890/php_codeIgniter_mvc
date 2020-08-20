<?=$this->include('includes.breadcaump', 'Đăng ký')?> 
<!-- Page Conttent -->
<main class="page-content">

    <!-- Checkout Page Start -->
    <div class="checkout_area pt--80 pb--150">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Checkout Form s-->
                    <form action="<?=$this->route('checkout', ['timeout'=>$this->_params['timeout']])?>" class="checkout-form" method="post">
                        <div class="row">
                            <div class="col-lg-7 mb--20">
                                <!-- Billing Address -->
                                <div id="billing-form" class="mb--40">
                                    <h4 class="checkout-title">Thông tin</h4>
                                    <div class="row">
                                        <div class="col-12 mb--20 checkinput inputlabel">
                                            <label>Tên cửa hàng *</label>
                                            <input type="text" name="storename" class="checkEmpty" placeholder="Tên cửa hàng">
                                        </div>
                                        <div class="col-md-12 col-12 mb--20 checkinput inputlabel">
                                            <label>Họ và tên *</label>
                                            <input type="text" name="name"  class="checkEmpty" placeholder="Họ và tên">
                                        </div>
                                        <div class="col-md-12 col-12 mb--20 checkinput inputlabel">
                                            <label>Số điện thoại *</label>
                                            <input type="text" name="phone" class="checkEmpty checkNumeric" placeholder="Số điện thoại">
                                        </div>
                                        <div class="col-md-12 col-12 mb--20 checkinput inputlabel">
                                            <label>Địa chỉ Email *</label>
                                            <input type="email" name="email" class="checkEmail" placeholder="Địa chỉ Email">
                                        </div>
                                        <div class="col-md-12 col-12 mb--20 checkinput inputlabel">
                                            <label>Mật khẩu *</label>
                                            <input type="password" name="password" class="checkPassword" id="register-form-email" placeholder="Mật khẩu">
                                            <p style="font-size: 13px;">Mật khẩu hợp lệ có độ dài 6 ký tự trở lên.</p>
                                        </div>                                                                               
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="row">

                                    <!-- Cart Total -->
                                    <div class="col-12 mb--60">
                                        <h4 class="checkout-title">Chi tiết</h4>
                                        <div class="checkout-cart-total">                                          
                                            <p>Phí sử dụng phần mềm quản lý bán hàng ThuNganOnline</p> 
                                            <p>Đơn giá<span>99.000<sup>đ</sup></span></span></p>
                                            <p>Thời gian sử dụng
                                                <span>
                                                    <select class="select" style="width: auto;height:30px;border:0" name="month">
                                                        <option value="0" class="hidden">Miễn phí</option>
                                                        <option value="3" selected="selected">3 tháng</option>
                                                        <option value="6">6 tháng</option>
                                                        <option value="12">12 tháng</option>
                                                        <option value="24">24 tháng</option>
                                                    </select>
                                                </span>
                                            </p>   
                                            <p class="checkout-sale">Giảm giá<span>0<sup>%</sup></span></span></p>                                            
                                            <h4 class="checkout-total">Thanh toán <span>297.000<sup>đ</sup></span></h4>
                                            <div class="checkout-cart-free">
                                                <input type="checkbox" name="checkbox" value="free" id="checkfree">
                                                <label for="checkfree">Sử dụng miễn phí 15 ngày</label>
                                            </div>   
                                        </div>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="col-12 mb--60">
                                        <h4 class="checkout-title">Ngân hàng</h4>
                                        <div class="checkout-payment-method">
                                            <p>Ngân hàng Á Châu (ACB)</p>
                                            <p>Chủ tài khoản: Trương Minh Hải</p>
                                            <p>Số tài khoản: 929517</p>
                                            <p>Chi nhánh: Tân Chánh Hiệp (Q.12)</p>
                                        </div>
                                        <div class="plceholder-button mt--50">
                                            <button type="submit" class="brook-btn bk-btn-theme btn-sd-size btn-rounded space-between btn full" style="line-height: normal;">Đăng ký</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout Page End -->
</main>
<!--// Page Conttent -->