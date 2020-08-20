<!-- Page Conttent -->
<main class="page-content"> <!-- Start 404 Area -->
<div class="error-not-found">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="error-inner text-center">
					<div class="image mb--55">
						<img src="<?=$this->getFolderImage(false)?>icons/image_404.png"
							alt="Multipurpose imaages">
					</div>
					<h3 class="heading heading-h3 text-white">Không tìm thấy</h3>
					<div class="error-text mt--20">
						<p class="text-white">Không thể tìm thấy tài nguyên được yêu cầu trên máy chủ này!</p>
						<div class="error-button-group mt--40">
							<a
								class="brook-btn bk-btn-theme btn-sd-size btn-rounded space-between"
								href="javascript:history.go(-1)">Quay lại</a> <a
								class="brook-btn bk-btn-white btn-sd-size btn-rounded space-between"
								href="<?=$this->route('home')?>">Trang chủ</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End 404 Area --> </main>
<!--// Page Conttent -->