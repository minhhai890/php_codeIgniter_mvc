<!-- Start Breadcaump Area --> 
<div class="brook-breadcaump-area pt--300 pt_md--250 pt_sm--200 pb--300 pb_md--250 pb_sm--200 bg_image--55 breadcaump-title-bar breadcaump-title-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcaump-inner text-center">
                    <h2 class="heading heading-h2 font-60 text-white">Liên hệ với chúng tôi</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcaump Area -->
<!-- Page Conttent -->
<main class="page-content">
    <!-- STart Contact Us Modern -->
    <div class="contact-modern pb--120 pb_md--80 pb_sm--80">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6 col-12 pr--50 ptb-md--80 ptb-sm--80">
                    <div class="contact-modern bg_color--18 space_dec--100 pt--120 pb--120 pl--60 pr--60">
                        <div class="inner">
                            <h2 class="heading heading-h2 text-white">Thông tin liên hệ</h2>
                            <div class="classic-address text-left mt--60">
                                <h4 class="heading heading-h4 text-white">Địa chỉ</h4>
                                <div class="desc mt--15">
                                    <p class="bk_pra line-height-2-22 text-white">107 Tân Chánh Hiệp Quận 12, Hồ Chí Minh</p>
                                </div>
                            </div>

                            <div class="classic-address text-left mt--60">
                                <h4 class="heading heading-h4 text-white">Hotline</h4>
                                <div class="desc mt--15 mb--30">
                                    <p class="bk_pra line-height-2-22 text-white">truongminhhai890@gmail.com <br> 093 209 7576</p>
                                </div>
                                <div class="social-share social--transparent text-white">
                                    <a href="//fb.com" target="_blank"><i class="fab fa-facebook"></i></a>
                                    <a href="//twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                    <a href="//instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                    <a href="//dribbble.com/" target="_blank"><i class="fab fa-dribbble"></i></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12 pl--50">
                    <div class="contact-form">
                        <form id="contact-form" action="<?=$this->route('contact')?>" method="POST">
                            <div class="row">
                                <div class="col-lg-12 checkinput">
                                    <input name="conname" type="text" class="checkEmpty" placeholder="Họ và tên *">                                   
                                </div>
                                <div class="col-lg-12 mt--30 checkinput">
                                    <input name="conemail" class="checkEmail" type="email" placeholder="Email *">                                   
                                </div>
                                <div class="col-lg-12 mt--30 checkinput">
                                    <input type="text" name="conphone" class="checkEmpty checkNumeric" placeholder="Điện thoại *">                                   
                                </div>
                                <div class="col-lg-12 mt--30 checkinput">
                                    <textarea name="conmessage" placeholder="Nội dung *" class="checkEmpty"></textarea>                                    
                                </div>
                                <div class="col-lg-12 mt--30">
                                    <input type="submit" value="Gửi">                                         
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Contact Us Modern -->
</main>