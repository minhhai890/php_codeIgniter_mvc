<div class="theme theme-list inventory hidden" data-baricon="left,search">
<?php
    $data = $this->getData('viewList');    
    if($data){
        echo '<ul data-action="'.$data['action'].'" data-scroll="'.$data['scroll'].'">'.$data['rows'].'</ul>';
    }   
?>
</div>
<?=$this->getData('viewAdd')?>
<?=$this->getData('viewEdit')?>
<?=$this->getData('viewDetail')?>
