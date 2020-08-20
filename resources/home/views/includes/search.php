 <!-- Start Brook Search Popup -->
<div class="brook-search-popup">
    <div class="inner">
        <div class="search-header">
            <div class="logo">
                <a href="index.html">
                    <img src="<?=$this->getFolderImage(false)?>thunganonline.png" alt="Thu Ngân Online">
                </a>
            </div>
            <a href="#" class="search-close"></a>
        </div>
        <div class="search-content">
            <form action="<?=$this->route('home')?>" method="post">
                <label>
                    <input type="search" placeholder="Nhập từ khóa tìm kiếm…">
                </label>
                <button class="search-submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</div>
<!-- End Brook Search Popup -->