<!doctype html>
<html class="no-js" lang="vi">
<head>
	<!-- Title -->
	<title><?=$this->getTitle()?></title>
	<!-- Favicon -->
    <link rel="shortcut icon" href="<?=$this->getFolderImage(false)?>favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?=$this->getFolderImage(false)?>icon.png">
    <!-- Css -->
	<?=$this->getMetaHttp().$this->getMetaName().$this->getCss()?>
</head>
<body class="template-color-1 template-font-1">
	<!-- Loading -->
	<?=$this->include('public.includes.loading')?>
	 <!-- Wrapper -->
	<div id="wrapper" class="wrapper">   
	    <?php require_once $this->getFileViewContent();?>
 	</div>
	<!-- Script -->
	<?=$this->getJs()?>
</body>
</html>