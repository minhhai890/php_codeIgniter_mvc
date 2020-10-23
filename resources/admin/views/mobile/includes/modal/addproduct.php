<?php
return <<<HTML
<div class="absolute auto addproduct">
    <div class="title">
        <form action="#" method="post" autocomplete="off">
            <div class="clearfix">
                <button type="button" name="bars-back" class="bars-back col"><span class="fa fa-chevron-left"></span></button>
                <input type="text" name="keyword" data-autofocus="true" class="input full col" placeholder="Tên sản phẩm"/>
            </div>
        </form>
    </div>
    <div class="content scrollbarY theme-list">               
        <ul data-action="scroll-product" data-scroll="false">
            <li>
                <a title="" class="">
                    <div class="clearfix">                            
                        <div class="image col">
                            <img src="http://localhost/phpFramework/resources/app/views/mobile/../picture/h.png" alt="" title="">
                        </div>
                        <div class="item col clearfix">
                            <div class="col col6">
                                <h4 class="overflow">Tên sản phẩm</h4>
                                <p>SL còn: 456</p>
                            </div>
                            <div class="col col3">
                                <h4>Giá bán</h4>
                                <p>456.1235</p>
                            </div>
                            <div class="col col3">
                                <h4>Đã đặt</h4>
                                <form action class="change" method="post">
                                    <input type="text" value="0"/>
                                </form>                                    
                            </div>
                        </div>                            
                    </div>  
                </a>                      
            </li>
            <li class="active">
                <a title="" class="">
                    <div class="clearfix">                            
                        <div class="image col">
                            <img src="http://localhost/phpFramework/resources/app/views/mobile/../picture/h.png" alt="" title="">
                        </div>
                        <div class="item col clearfix">
                            <div class="col col6">
                                <h4 class="overflow">Tên sản phẩm</h4>
                                <p>SL còn: 456</p>
                            </div>
                            <div class="col col3">
                                <h4>Giá bán</h4>
                                <p>456.1235</p>
                            </div>
                            <div class="col col3">
                                <h4>Đã đặt</h4>
                                <form action class="change" method="post">
                                    <input type="text" value="1"/>
                                </form>                                    
                            </div>
                        </div>                            
                    </div>  
                </a>                      
            </li>
            <li>
                <a title="" class="">
                    <div class="clearfix">                            
                        <div class="image col">
                            <img src="http://localhost/phpFramework/resources/app/views/mobile/../picture/h.png" alt="" title="">
                        </div>
                        <div class="item col clearfix">
                            <div class="col col6">
                                <h4 class="overflow">Tên sản phẩm</h4>
                                <p>SL còn: 456</p>
                            </div>
                            <div class="col col3">
                                <h4>Giá bán</h4>
                                <p>456.1235</p>
                            </div>
                            <div class="col col3">
                                <h4>Đã đặt</h4>
                                <form action class="change" method="post">
                                    <input type="text" value="0"/>
                                </form>                                    
                            </div>
                        </div>                            
                    </div>  
                </a>                      
            </li>
        </ul>               
    </div>
</div>
HTML;