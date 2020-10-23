<?php
    echo '<base href="' . BASE_NAME . '/app"/>';
    echo '<title>' . $this->getTitle() . '</title>';
	echo $this->getMetaHttp();
	echo $this->getMetaName();
	//<!-- Favicon -->
	echo '<link href="' . $this->getFolderImage(false) . 'favicon.ico" type="image/png" sizes="64x64" rel="shortcut icon"/>';
	//<!-- Apple/Safari icon -->
    echo '<link rel="apple-touch-icon-precomposed" href="'.$this->getFolderImage(false).'icon180.png"/>';
    //<!-- Square Windows tiles -->
    echo '<meta name="msapplication-square70x70logo" content="'.$this->getFolderImage(false).'icon70.png"/>';
    echo '<meta name="msapplication-square150x150logo" content="'.$this->getFolderImage(false).'icon150.png"/>';
    echo '<meta name="msapplication-square310x310logo" content="'.$this->getFolderImage(false).'icon310.png"/>';
    //<!-- Rectangular Windows tile -->
    echo '<meta name="msapplication-wide310x150logo" content="'.$this->getFolderImage(false).'icon-rect-310.png"/>';
    //<!-- Windows application name -->
    echo '<meta name="application-name" content="ThuNgan"/>';
    echo '<meta name="theme-color" content="#000000">';
    echo '<meta name="msapplication-TileColor" content="#000000">';
    echo '<meta name="mobile-web-app-capable" content="yes">';
    echo '<link rel="manifest" href="'.$this->route('app/manifest').'">';	
	echo $this->getCss();
?>
    <!--[if IE]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->  