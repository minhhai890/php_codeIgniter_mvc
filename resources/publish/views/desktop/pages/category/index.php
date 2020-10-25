<div id="main">
    <!-- Category Banner -->
    <?= $this->include('includes.data.banner1', [
        'url' => '#',
        'image' => 'slider/01.jpg',
        'title' => 'banner'
    ]) ?>
    <!-- Breadcrumb -->
    <?= $this->include('includes.data.breadcrumb') ?>
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
                    <?= $this->include('includes.data.product-list', [1, 2, 3, 4, 5, 6, 7, 8, 9]) ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->include('includes.data.pagination', [1]) ?>
</div>