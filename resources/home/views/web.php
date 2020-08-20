<!doctype html>
<html class="no-js" lang="vi">
<head>
	<!-- Favicon -->
    <link rel="shortcut icon" href="<?=$this->getFolderImage(false)?>favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?=$this->getFolderImage(false)?>icon.png">	
	<!-- Title -->
	<title><?=$this->getTitle()?></title>
	<base href="<?=BASE_NAME?>"/>
	<!-- Css -->    
	<?=$this->getMetaHttp().$this->getMetaName().$this->getCss()?>
</head>
<body class="template-color-5 template-font-1">
	<!-- Loading -->
	<?=$this->include('includes.loading')?>
	 <!-- Wrapper -->
	<div id="wrapper" class="wrapper">   
	    <?php
	    $this->include('includes.header');
	    $this->include('includes.menu');
	    $this->include('includes.search');
	    require $this->getFileViewContent();
		?>
 	</div>
	<!-- Footer -->
	<?php 
		// Footer
		$this->include('includes.footer');
		// Popup
		$this->include('includes.popup');
	?>	
	<?=$this->getJs()?>
</body>
</html>