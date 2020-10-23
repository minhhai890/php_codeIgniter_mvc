<?php
return <<<HTML
<div class="absolute auto unit">
    <div class="title">
        <h3>Đơn vị tính</h3>
    </div>
    <div class="control clearfix">
        <div class="col col9">
            <input type="text" class="input full capitalize" id="input-unitname" data-autofocus="true" name="unitname"/>
        </div>
        <div class="col col3 aligncenter">
            <button type="button" class="input hover addunit">Thêm</button>
        </div>
    </div>
    <div class="content scrollbarY">
        <table class="table">
            <thead>
                <tr>
                    <td>STT</td>
                    <td>Đơn vị tính</td>
                </tr>
            </thead>
            <tbody id="tr-list-unit"></tbody>
        </table>
    </div>
</div>
HTML;