<!-- SLIDER -->
<?= $this->include('includes.data.home-slider', $this->getData('slider')) ?>
<!-- CATEGORY -->
<?= $this->include('includes.data.home-category', [1, 2, 3, 4, 5, 6]) ?>
<!-- BANNER -->
<?= $this->include('includes.data.home-banner', $this->getData('slider')) ?>
<!-- FLASH SALE -->
<div class="products flash-sale">
    <div class="title clearfix">
        <div class="col name">
            <h2>Flash Sale</h2>
        </div>
        <div class="col time">
            <span class="hours">00</span>
            <span class="minutes">24</span>
            <span class="seconds">43</span>
        </div>
        <div class="more">
            <a href="" title="">Xem tất cả <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
    <div class="content">
        <?= $this->include('includes.data.product-list', [1, 2, 3, 4, 5]) ?>
    </div>
</div>
<!-- BANNER -->
<?= $this->include('includes.data.home-banner', $this->getData('slider')) ?>
<!-- PRODUCT -->
<div class="products">
    <div class="title clearfix">
        <div class="col name">
            <h2 style="color:black">Gợi ý hôm nay</h2>
        </div>
        <div class="more">
            <a href="" title="">Xem tất cả <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
    <div class="content">
        <?= $this->include('includes.data.product-list', [1, 2, 3, 4, 5]) ?>
    </div>
    <div class="more">
        <button type="button" class="btn hover">Xem thêm <i class="fas fa-chevron-right"></i></button>
    </div>
</div>