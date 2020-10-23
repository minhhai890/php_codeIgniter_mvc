<!doctype html>
<html lang="vi" class="scrollbar">
<head>
<?=$this->include('includes.head')?>
</head>
<body>
    <div id="header">
        <div class="title">
            <h1 title="<?=$this->getTitle()?>"><?=$this->getTitle()?></h1>
        </div>
    </div>
    <div id="main">
    	<?php require_once $this->getFileViewContent(); ?>
    </div>
    <!-- FOOTER -->
    <?=$this->include('includes.footer')?>
    <!-- JS -->
    <?=$this->getJs()?>
</body>
</html>