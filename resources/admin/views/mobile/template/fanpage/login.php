<div class="theme theme-facebook">
    <div class="login scrollbarY">
        <!-- Login Facebook -->
        <div class="fblogin">
            <div class="head">
                <h3>Login Facebook</h3>
            </div>
            <div class="bottom">
                <p>Để quản lý được nội dung tin nhắn, bình luận của Fanpage trước tiên bạn phải đăng nhập Facebook.</p>
                <input type="button" name="fblogin" value="Đăng nhập bằng Facebook" class="input full hover">                    	
            </div>
        </div>
        <!-- Cập nhật dữ liệu -->
        <div class="fbimport">            
            <div class="load col3">
                <img src="<?=$this->getFolderImage(false)?>loading.svg" alt="loadding">
            </div>                  
            <div class="text">
                <h3>Đang tải: <strong data-import="0">0</strong>%</h3>
                <span>Không được tắt trình duyệt hoặc làm mới trang khi chưa hoàn tất./.</span>
                <input type="button" name="import-fanpage" class="importfanpage hidden">
            </div>
        </div>
    </div>        
</div>