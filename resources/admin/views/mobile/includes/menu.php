<!-- Menu-->
<div class="menu" data-active="cls<?=$this->_params['controller']?>">
    <div class="menu-left hidden">
        <div class="content scrollbarY">
            <div class="title">
                <div class="logo">
                    <img src="<?=$this->getFolderImage(false)?>thunganonline.png" alt="www.thunganonline.com" title="Thu Ngân Online - Ứng dụng quản lý bán hàng" />
                </div>
                <div class="user">
                    <p><a href="<?=$this->route('app/user/logout')?>" title="Đăng xuất" class="logout">Đăng xuất</a>&nbsp;|&nbsp;<a href="#" class="changepassword" title="Tài khoản cá nhân">Đổi mật khẩu</a></p>
                </div>
            </div>
            <div class="category"><?=$this->getItem('default', 'menuleft')?></div>
        </div>
        <div class="popupClose"></div>
    </div>
    <div class="menu-right hidden">
        <div class="content scrollbarY">           
            <div class="category"><?=$this->getItem('default', 'menuright')?></div>
        </div>
        <div class="popupClose"></div>
    </div>   
</div>

