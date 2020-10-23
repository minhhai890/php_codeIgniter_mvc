<!DOCTYPE html>
<html lang="vi">
<?php require('includes/head.php') ?>

<body>
    <?php require('includes/header.php') ?>
    <div id="main">
        <!-- Category Banner -->
        <div class="category-banner">
            <a href="" title="">
                <img src="images/slider/01.jpg" alt="">
            </a>
        </div>
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <ul>
                <li><a href="" title="">Trang chủ</a></li>
                <li><a href="" title="">Làm đẹp</a></li>
                <li><a href="" title="">Chăm sóc da mặt</a></li>
            </ul>
        </div>
        <!-- Category product -->
        <div class="category-products clearfix">
            <div class="col-left col">
                <div class="filter-box filter-category">
                    <h3>
                        <i class="fas fa-bars"></i>
                        <span>Làm đẹp</span>
                    </h3>
                    <ul>
                        <li>
                            <a href="" title="">Chăm sóc da mặt</a>
                            <ul>
                                <li><a href="" title="">Sữa rửa mặt, mặt nạ</a></li>
                                <li><a href="" title="">Kem dưỡng ẩm, dưởng trắng</a></li>
                                <li><a href="" title="">Nước hoa hồng</a></li>
                                <li><a href="" title="">Kem chống nắng</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="" title="">Chăm sóc cơ thể</a>
                            <ul>
                                <li><a href="" title="">Sữa tắm</a></li>
                                <li><a href="" title="">Nước hoa</a></li>
                                <li><a href="" title="">Khử mùi</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="" title="">Chăm sóc tóc</a>
                            <ul>
                                <li><a href="" title="">Dầu gọi - dầu xả</a></li>
                                <li><a href="" title="">Dưỡng tóc, ủ tóc</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="filter-box filter-price">
                    <h3>
                        <i class="fas fa-dollar-sign"></i>
                        <span>Khoản giá</span>
                    </h3>
                    <form action="" method="get">
                        <div class="frm-group frm-price clearfix">
                            <input type="text" class="input" name="price-from" value="" placeholder="₫ TỪ">
                            <span><i class="fas fa-long-arrow-alt-right"></i></span>
                            <input type="text" class="input" name="price-to" value="" placeholder="₫ ĐẾN">
                        </div>
                        <div class="frm-group">
                            <input type="submit" class="btn full hover" value="Áp dụng">
                        </div>
                    </form>
                </div>
                <div class="filter-box filter-brand">
                    <h3>
                        <i class="fas fa-copyright"></i>
                        <span>Thương hiệu</span>
                    </h3>
                    <ul>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 1
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 2
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 3
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 1
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 2
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 3
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 1
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 2
                                </label>
                            </a>
                        </li>
                        <li>
                            <a href="" title="">
                                <label class="label">
                                    <input type="checkbox" class="checkbox" name="brand" value="">
                                    Thương hiệu 3
                                </label>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-right col">
                <div class="sort clearfix">
                    <div class="ctr-left">
                        <span>Sắp xếp theo:</span>
                        <ul class="clearfix">
                            <li>
                                <a href="" class="active" title="">Phổ biến</a>
                            </li>
                            <li>
                                <a href="" title="">Mới nhất</a>
                            </li>
                            <li>
                                <a href="" title="">Bán chạy</a>
                            </li>
                            <li>
                                <a href="" title="">Giá cao</a>
                            </li>
                            <li>
                                <a href="" title="">Giá thấp</a>
                            </li>
                        </ul>
                    </div>
                    <div class="ctr-right">
                        <span class="current">1</span><span>/</span><span>224</span>
                        <button type="button" class="previous"><i class="fas fa-chevron-left"></i></button>
                        <button type="button" class="next"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <!-- PRODUCT -->
                <div class="products">
                    <div class="content">
                        <ul class="clearfix">
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-01.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-40%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-01.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-40%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-02.png" alt="">
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-03.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-17%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-04.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-15%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-05.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-10%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-01.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-40%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-02.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-33%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-03.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-17%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-04.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-15%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-05.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-10%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-01.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-40%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-02.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-33%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-03.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-17%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-04.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-15%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-05.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-10%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-01.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-40%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-02.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-33%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-03.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-17%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                            <li class="item">
                                <div class="imgbox">
                                    <a href="" title="">
                                        <img src="images/product/product-04.png" alt="">
                                    </a>
                                </div>
                                <div class="boxsale">
                                    <a href="" title="">
                                        <h4>-15%</h4>
                                        <span>Giảm</span>
                                    </a>
                                </div>
                                <div class="infobox">
                                    <a href="" title="">
                                        <h3>Sản phẩm của bạn được đặt tên như thế nào Sản phẩm của bạn được đặt tên như thế nào</h3>
                                        <span class="price"><span>₫</span><strong>9.999.999</strong></span>
                                        <span class="sold">đã bán 169</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination">
            <div class="item">
                <ul>
                    <li><a href="" title="">&lt;&lt;&lt;</a></li>
                    <li><a href="" title="">1</a></li>
                    <li><a class="active" href="" title="">2</a></li>
                    <li><a href="" title="">3</a></li>
                    <li><a href="" title="">4</a></li>
                    <li><a href="" title="">5</a></li>
                    <li><a href="" title="">&gt;&gt;&gt;</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php require('includes/footer.php') ?>
    <?php require('includes/popup.php') ?>
</body>

</html>