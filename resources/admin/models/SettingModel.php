<?php

namespace resources\app\models;

use resources\app\libs\Model;
use resources\app\libs\Func;

class SettingModel extends Model
{
    // loadStoreName

    // Phương thức khởi tạo
    public function __construct()
    {
        parent::__construct();
        $this->tableDetault('settings');
    }

    // Phương thức lấy ra thông tin cài đặt cửa hàng
    public function load()
    {
        return $this->where('storeid', '=', Func::getIdStoreLogin())->selectAll();
    }

    // Phương thức lấy ra thông tin cài đặt cửa hàng
    public function loadInfo()
    {
        return $this->whereStr('`storeid`=' . Func::getIdStoreLogin() . ' AND `key` NOT IN("print","post")')->selectAll();
    }

    // Phương thức kiểm tra info
    public function checkInfo($key)
    {
        if ($this->where('storeid', '=', Func::getIdStoreLogin())->and('key', '=', $key)->select()) {
            return true;
        } else {
            return false;
        }
    }

    // Phương thức thêm info
    public function addInfo($name, $value)
    {
        return $this->data([
            'key'       => $name,
            'value'     => $value,
            'status'    => STATUS['ALLOW'],
            'storeid'   => Func::getIdStoreLogin()
        ])->insert();
    }

    // Phương thức cập nhật info
    public function updateInfo($name, $value)
    {
        return $this->data([
            'value' => $value
        ])
            ->where('storeid', '=', Func::getIdStoreLogin())
            ->and('key', '=', $name)
            ->update();
    }

    // Phương thức lấy ra print
    public function loadPrint()
    {
        return $this->where('storeid', '=', Func::getIdStoreLogin())->and('key', '=', 'print')->select();
    }

    // Phương thức kiểm tra print đã được thiết lập chưa
    public function checkPrint()
    {
        if ($this->loadPrint()) {
            return true;
        } else {
            return false;
        }
    }

    // Phương thức thêm print
    public function addPrint($data)
    {
        return $this->data([
            'key'       => 'print',
            'value'     => json_encode($data),
            'status'    => STATUS['ALLOW'],
            'storeid'   => Func::getIdStoreLogin()
        ])->insert();
    }

    // Phương thức cập nhật
    public function updatePrint($data)
    {
        return $this->data([
            'value'     => json_encode($data)
        ])
            ->where('storeid', '=', Func::getIdStoreLogin())
            ->and('key', '=', 'print')
            ->update();
    }

    // Phương thức lấy ra print
    public function loadPost()
    {
        return $this->where('storeid', '=', Func::getIdStoreLogin())->and('key', '=', 'post')->select();
    }

    // Phương thức kiểm tra print đã được thiết lập chưa
    public function checkPost()
    {
        if ($this->loadPost()) {
            return true;
        } else {
            return false;
        }
    }

    // Phương thức thêm print
    public function addPost($value)
    {
        return $this->data([
            'key'       => 'post',
            'value'     => $value,
            'status'    => STATUS['ALLOW'],
            'storeid'   => Func::getIdStoreLogin()
        ])->insert();
    }

    // Phương thức cập nhật
    public function updatePost($value)
    {
        return $this->data([
            'value'     => $value
        ])
            ->where('storeid', '=', Func::getIdStoreLogin())
            ->and('key', '=', 'post')
            ->update();
    }
}
