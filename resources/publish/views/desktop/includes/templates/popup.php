<div id="popup" class="fixed">
    <!-- Đăng nhập / đăng ký -->
    <div class="relative member-form clearfix">
        <div class="col col5 banner">
            Banner
        </div>
        <div class="col col7 login">
            <ul class="tab clearfix">
                <li><a href="" title="" class="active" data-action="#login-form">Đăng nhập</a></li>
                <li><a href="" title="" data-action="#register-form">Đăng ký</a></li>
            </ul>
            <form id="login-form" action="" method="post">
                <div class="group">
                    <label>Email / Số điện thoại</label>
                    <input type="text" name="email_or_phone" data-focus="true" value="" class="input full">
                </div>
                <div class="group">
                    <label>Mật khẩu</label><a class="forget" href="" title="">Quên mật khẩu</a>
                    <input type="password" name="" value="" class="input full">
                </div>
                <div class="group">
                    <input type="submit" value="Đăng nhập" class="btn full hover">
                    <p class="wrong-login">Sai thông tin đăng nhập, vui lòng đăng nhập lại</p>
                </div>
                <div class="fast-login">
                    <div class="group">
                        <button type="button" class="google">
                            <span><i class="fab fa-google"></i></span>
                            Đăng nhập bằng Google
                        </button>
                        <button type="button" class="facebook">
                            <span><i class="fab fa-facebook-f"></i></span>
                            Đăng nhập bằng Facebook
                        </button>
                        <button type="button" class="zalo">
                            <span><i class="fab fa-facebook-f"></i></span>
                            Đăng nhập bằng Zalo
                        </button>
                    </div>
                </div>
            </form>
            <form id="register-form" action="" method="post">
                <div class="group">
                    <label>Họ và tên</label>
                    <input type="text" name="" data-focus="true" value="" class="input full">
                </div>
                <div class="group">
                    <label>Số điện thoại</label>
                    <input type="text" name="" value="" class="input full">
                </div>
                <div class="group">
                    <label>Email</label>
                    <input type="text" name="" value="" class="input full">
                </div>
                <div class="group">
                    <label>Mật khẩu</label>
                    <input type="text" name="" value="" class="input full">
                </div>
                <div class="group clearfix">
                    <div class="col col5">
                        <label>Ngày sinh / Giới tính</label>
                        <input type="text" name="" value="" class="input full" placeholder="ngày / tháng / năm">
                    </div>
                    <div class="col col7 aligncenter" style="height: 57px;">
                        <label class="label">Nam<input type="radio" class="radio" name="gender" value="1"></label>
                        <label class="label">Nữ<input type="radio" class="radio" name="gender" value="2"></label>
                    </div>
                </div>
                <div class="group">
                    <input type="submit" value="Đăng ký" class="btn full hover">
                </div>
                <div class="group">
                    <p class="rules">Khi bạn nhấn Đăng ký, bạn đã đồng ý thực hiện mọi giao dịch mua bán theo
                        <a href="" title="">điều kiện sử dụng và chính sách của Lina house.</a>
                    </p>
                </div>
            </form>
        </div>
        <button class="closelogin"><i class="far fa-times-circle"></i></button>
    </div>
    <!-- Thêm vào giỏ hàng -->
    <div class="add-to-cart absolute">
        <div class="label">
            <input type="radio" class="radio" checked>
            <p>Sản phẩm đã được thêm vào Giỏ hàng</p>
        </div>
    </div>
</div>