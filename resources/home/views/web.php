<!doctype html>
<html class="no-js" lang="vi">

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
    <?php
    require $this->getFileViewContent();
    ?>
</body>

</html>