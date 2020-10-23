<div class="login relative">
	<div class="absolute">
		<h3>Đăng nhập</h3>
		<form action="<?=$this->route('app/user/login')?>" method="post" name="frm-login">	
			<div class="row">
				<div class="checkinput inputlabel">
					<label>Email đăng nhập</label>
					<input type="text" class="input full checkEmail" name="email" value="" data-require="true" placeholder="Email">
				</div>
			</div>
			<div class="row">
				<div class="checkinput inputlabel">
					<label>Mật khẩu</label>
					<input type="password" class="input full checkPassword" name="password" data-require="true" value="" placeholder="Mật khẩu">
				</div>
			</div>
			<div class="row">
				<input type="submit" class="btn full hover" name="login" value="Đăng nhập">
			</div>
			<?php
			$error = $this->getData('error');
			if($error){
				echo '<div class="row"><p class="error">'.$error.'</p></div>';
			}
			?>			
		</form>		
	</div>
</div>



