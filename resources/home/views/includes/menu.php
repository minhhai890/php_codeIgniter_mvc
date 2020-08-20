<!-- Start Popup Menu -->
<div class="popup-mobile-manu popup-mobile-visiable">
    <div class="inner">
        <div class="mobileheader">
            <div class="logo">
                <a href="index.html">
                    <img src="<?=$this->getFolderImage(false)?>thunganonline.png" alt="Thu Ngân Online">
                </a>
            </div>
            <a class="mobile-close" href="#"></a>
        </div>
        <div class="menu-content">
            <ul class="menulist object-custom-menu">
                <li><a href="<?=$this->route('home')?>"><span>Trang chủ</span></a></li>
            	<li><a href="<?=$this->route('about')?>"><span>Giới thiệu</span></a></li>                                
                <li><a href="<?=$this->route('pricing')?>"><span>Bảng giá</span></a></li>                
                <li><a href="<?=$this->route('contact')?>"><span>Liên hệ</span></a></li>
                <li><a href="<?=$this->route('register')?>"><span>Đăng ký</span></a></li>
                <li><a href="<?=$this->route('app/user/login')?>" target="_blank"><span>Đăng nhập</span></a></li>
            </ul>
        </div>
    </div>
</div>
<!-- End Popup Menu -->