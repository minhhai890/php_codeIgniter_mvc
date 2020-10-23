<!DOCTYPE html>
<html lang="vi">

<head>
    <?php
    // Title
    echo $this->getTitleTags();
    // Link
    echo $this->getLinkTags();
    // Meta
    echo $this->getMetaTags();
    // Css
    echo $this->getCssTags();
    // Js
    echo $this->getJsTags();
    ?>
</head>

<body>
    <?= $this->include('includes.templates.header') ?>
    <div id="main">
        <?php
        require $this->getFileViewContent();
        ?>
    </div>
    <?= $this->include('includes.templates.footer') ?>
    <?= $this->include('includes.templates.popup') ?>
</body>

</html>