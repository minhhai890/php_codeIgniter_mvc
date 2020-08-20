<!-- Footer -->
<footer class="page-footer bg_color--3 pl--150 pr--150 pl_lg--30 pr_lg--30 pl_md--30 pr_md--30 pl_sm--5 pr_sm--5">
    <!-- Start Footer Top Area -->
    <div class="bk-footer-inner pt--150 pb--30 pt_sm--100">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget text-var--2">
                        <div class="logo">
                            <a href="<?=$this->route('home')?>">
                                <img src="<?=$this->getFolderImage(false)?>thunganonline.png" alt="Thu Ngân Online">
                            </a>
                        </div>
                        <div class="footer-inner">
                            <p>ThuNganOnline - Phần mềm quản lý bán hàng PHỔ BIẾN NHẤT với hơn 97.000 cửa hàng đang sử dụng. Đơn giản, dễ dùng, tiết kiệm chi phí và phù hợp với cửa hàng vừa và nhỏ.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-6 col-12 mt_mobile--40">
                    <div class="footer-widget text-var--2 menu--about">
                        <h2 class="widgettitle">Chúng tôi</h2>
                        <div class="footer-menu">
                            <ul class="ft-menu-list bk-hover">  
                            	<li><a href="<?=$this->route('home')?>">Trang chủ</a></li>                             
                                <li><a href="<?=$this->route('about')?>">Giới thiệu</a></li>                                
                                <li><a href="<?=$this->route('pricing')?>">Bảng giá</a></li>                                
                                <li><a href="<?=$this->route('contact')?>">Liên hệ</a></li>
                                <li><a href="<?=$this->route('register')?>">Đăng ký</a></li>
                                <li><a href="<?=$this->route('app/user/login')?>" id="autologin" target="_blank">Đăng nhập</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt_md--40 mt_sm--40">
                    <div class="footer-widget text-var--2 menu--contact">
                        <h2 class="widgettitle">Liên hệ</h2>
                        <div class="footer-address">
                            <div class="bk-hover">
                                <p>107 Tân Chánh Hiệp <br> Quận 12, Hồ Chí Minh</p>
                                <p><a href="tel:truongminhhai890@gmail.com">truongminhhai890@gmail.com</a></p>
                                <p><a href="#">0932 097 576</a></p>
                            </div>
                            <div class="social-share social--transparent text-white">
                                <a href="//fb.com" target="_blank"><i class="fab fa-facebook"></i></a>
                                <a href="//twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="//instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="//dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                <a href="//pinterest.com/" target="_blank"><i class="fab fa-pinterest"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt_md--40 mt_sm--40">
                    <div class="footer-widget text-var--2 menu--instagram">
                        <h2 class="widgettitle">Fanpage</h2>
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=2004407906524060&autoLogAppEvents=1"></script>
                        <div class="fb-page col-12" data-href="https://www.facebook.com/Thu-Ng%C3%A2n-Online-108272507339604/?ref=bookmarks" data-tabs="timeline" data-height="220" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/Thu-Ng%C3%A2n-Online-108272507339604/?ref=bookmarks" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Thu-Ng%C3%A2n-Online-108272507339604/?ref=bookmarks">Thu Ngân Online</a></blockquote></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Start Footer Top Area -->

    <!-- Start Copyright Area -->
    <div class="copyright ptb--50 text-var-2">
        <div class="container">
            <div class="row align-items-center">                   
                <div class="col-12">
                    <div class="copyright-right text-md-right text-center">
                        <p>&copy; 2020. <a href="<?=$this->route('home')?>">Thu Ngân Online</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Copyright Area -->
</footer>
<!--// Footer -->
