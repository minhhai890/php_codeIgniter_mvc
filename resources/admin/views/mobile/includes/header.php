<!-- HEADER -->
<div id="header">   
     <!-- Title -->  
    <div class="row">
        <div class="title">                        
            <h1 class="overflow"><?php echo $this->getTitle(); ?></h1>
        </div>
    </div>
    <!-- Search -->
    <div class="row">
        <div class="search cls<?=$this->_params['controller']?>">
            <form action="<?=$this->route('app/dashboard/view')?>" method="post" autocomplete="off">
                <input type="text" name="keyword" class="input small full" placeholder="Từ khóa tìm kiếm">
                <button type="button" class="hidden" name="setting"><i class="fas fa-cogs"></i></button>
            </form>
        </div>
    </div>
    <!-- Button -->
    <div class="row">
        <div class="icons">
            <button type="button" name="bars-left" class="bars-left hidden"><i class="fa fa-bars"></i>
            </button>
            <button type="button" name="bars-right" class="bars-right hidden"><i class="fa fa-ellipsis-h"></i>
            </button>
            <button type="button" name="bars-search" class="bars-search hidden"><i class="fa fa-search"></i>
            </button>
            <button type="button" name="bars-back" class="bars-back hidden"><i class="fa fa-chevron-left"></i>
            </button>
        </div>
    </div>
</div>