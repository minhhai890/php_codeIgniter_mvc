<!doctype html>
<html lang="vi" class="scrollbar">
<head>
<?=$this->include('includes.head')?>
</head>
<body>
	<?=$this->include('includes.header')?> 
    <!-- MAIN -->
    <div id="main">
        <?=$this->include('includes.menu')?>
        <div class="container scrollbarY">
            <?php  require_once $this->getFileViewContent();?> 
        </div>
    </div>
    <!-- POPUP -->
    <?=$this->include('includes.modal.default')?>
    <?=$this->getJs()?>
</body>
</html>