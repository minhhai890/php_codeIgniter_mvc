<!-- Header -->
<header class="br_header header-default black-logo--version haeder-fixed-width haeder-fixed-150 headroom--sticky header-mega-menu clearfix headroom headroom--not-bottom headroom--pinned headroom--top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="header__wrapper mr--0">
                    <!-- Header Left -->
                    <div class="header-left">
                        <div class="logo">
                            <a href="<?=$this->route('home')?>">
                                <img src="<?=$this->getFolderImage(false)?>thunganonline.png" alt="Ứng dụng quản lý bán hàng - <?=$this->route('home')?>">
                            </a>
                        </div>
                    </div>
                    <!-- Mainmenu Wrap -->
                    <div class="mainmenu-wrapper d-none d-lg-block">
                        <nav class="page_nav">
                           <ul class="mainmenu">
                                <li class="lavel-1 slide--megamenu"><a href="<?=$this->route('home')?>" class="home"><span>Trang chủ</span></a></li>
                                <li class="lavel-1 slide--megamenu"><a href="<?=$this->route('about')?>" class="about"><span>Giới thiệu</span></a></li>
                                <li class="lavel-1 slide--megamenu"><a href="<?=$this->route('pricing')?>" class="pricing"><span>Bảng giá</span></a></li>
                                <li class="lavel-1 slide--megamenu"><a href="<?=$this->route('contact')?>" class="contact"><span>Liên hệ</span></a></li>                                
                                <li class="lavel-1 slide--megamenu"><a href="<?=$this->route('register')?>" class="register"><span>Đăng ký</span></a></li>
                                <li class="lavel-1 slide--megamenu"><a href="<?=$this->route('app/user/login')?>" target="_blank"><span>Đăng nhập</span></a></li>
                            </ul>
                        </nav>
                    </div>
                    <!-- Header Right -->
                    <div class="header-right">                        
                        <!-- Start Popup Search Wrap -->
                        <div class="popup-search-wrap">
                            <a class="btn-search-click" href="#">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <!-- End Popup Search Wrap -->
                        <!-- Start Hamberger -->
                        <div class="manu-hamber popup-mobile-click black-version d-block d-xl-none">
                            <div>
                                <i></i>
                            </div>
                        </div>
                        <!-- End Hamberger -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</header>
<!--// Header -->