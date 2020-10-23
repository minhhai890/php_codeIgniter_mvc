<div class="theme theme-list user hidden" data-baricon="left,search">
<?php
    $data = $this->getData('viewList');
    if($data){
        echo '<ul class="scrollbarY" data-action="'.$data['action'].'" data-scroll="'.$data['scroll'].'">'.$data['rows'].'</ul>';
    }   
?>
</div>
<?=$this->getData('viewAdd')?>
<?=$this->getData('viewDetail')?>
<?=$this->getData('viewPermission')?>
