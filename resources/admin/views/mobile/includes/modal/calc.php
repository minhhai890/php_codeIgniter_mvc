<?php
return <<<HTML
<div class="absolute auto calc">
    <div class="title">
        <h3 class="result">0</h3>
    </div>
    <div class="content clearfix">
        <div class="price">
        <?php
            $listPrice = $this->getData('listPrice'); 
            if($listPrice){ 
                foreach($listPrice as $value){ 
                    echo '<button type="button" class="btn hover">'.$value.'</button>'; 
                } 
            }else{ 
                echo '<button type="button" class="btn hover">0</button>';
            } 
        ?>
        </div>
        <div class="col col9">
            <div class="row clearfix">
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">1</button>
                </div>
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">2</button>
                </div>
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">3</button>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">4</button>
                </div>
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">5</button>
                </div>
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">6</button>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">7</button>
                </div>
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">8</button>
                </div>
                <div class="col col4">
                    <button type="button" class="btn hover full numeric">9</button>
                </div>
            </div>
            <div class="row clearfix">
                <div>
                    <button type="button" class="btn hover full numeric">0</button>
                </div>
            </div>
        </div>
        <div class="col col3">
            <div class="row clearfix">
                <div>
                    <button type="button" class="btn hover full clear btncontrol">Xóa</button>
                </div>
            </div>
            <div class="row clearfix" style="margin-top: 63px;">
                <div>
                    <button type="button" class="btn hover full btncontrol enter">Nhập</button>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;