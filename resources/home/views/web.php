<!doctype html>
<html class="no-js" lang="vi">

<head>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= $this->getFolderImage(false) ?>favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?= $this->getFolderImage(false) ?>icon.png">
    <!-- Title -->
    <title><?= $this->getTitle() ?></title>
    <base href="<?= URL_HOST ?>" />
    <!-- Css -->
    <?= $this->getMetaHttp() . $this->getMetaName() . $this->getCss() ?>
</head>

<body>
    <?php
    require $this->getFileViewContent();
    ?>
    <?= $this->getJs() ?>
</body>

</html>