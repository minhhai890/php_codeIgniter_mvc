<?php

namespace resources\app\models;

use resources\app\libs\Model;
use resources\app\libs\Func;

class UserModel extends Model
{
    // loadStoreName

    // Phương thức khởi tạo
    public function __construct()
    {
        parent::__construct();
        $this->tableDetault('users', true);
    }

    // Phương thức đăng nhập
    public function login($params)
    {
        return $this->table('users')
            ->column(['id', 'name', 'key', 'storeid', 'status', 'role'])
            ->innerJoin('stores')
            ->column(['status'])
            ->on('users.storeid', '=', 'stores.id')
            ->where('users.email', '=', $params['email'])
            ->and('users.password', '=', $params['password'])
            ->and('users.status', '=', STATUS['ALLOW'])
            ->select();
    }

    // Phương thức đăng nhập
    public function cookieLogin($params)
    {
        return $this->table('users')
            ->column(['id', 'name', 'key', 'storeid', 'status', 'role'])
            ->innerJoin('stores')
            ->column(['status'])
            ->on('users.storeid', '=', 'stores.id')
            ->where('stores.id', '=', $params['storeid'])
            ->and('users.id', '=', $params['id'])
            ->and('users.status', '=', STATUS['ALLOW'])
            ->select();
    }

    // Phương thức lấy ra danh sách tất cả menu với role và status = 1
    public function menus($role, $status = STATUS['ALLOW'])
    {

        $this->table('menus')->where('status', '=', $status);
        if (strtolower($role) !== 'all') {
            $role = json_decode($role, true);
            if ($role && is_array($role)) {
                $this->whereStr('AND `id` IN (' . $this->convertValueIn($role) . ')');
            }
        }
        $this->orderby('parent', 'ASC');
        $this->orderby('ordering', 'ASC');
        return $this->selectAll();
    }

    // Phương thức kiểm tra email tồn tại
    public function checkEmail($email)
    {
        return $this->data(['name'])
            ->where('email', '=', trim($email))
            ->and('status', '=', STATUS['ALLOW'])
            ->select();
    }

    // Phương thức thêm mới tài khoản
    public function add($data)
    {
        return $this->data([
            'key'           => $data['key'],
            'name'          => $data['name'],
            'keyword'       => $data['keyword'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'password'      => $data['password'],
            'status'        => STATUS['ALLOW'],
            'created'       => $this->_time,
            'created_by'    => $this->_loginid,
            'storeid'       => $this->_storeid,
        ])->insert();
    }

    // Phương thức trả về danh sách tài khoản
    public function detail($id)
    {
        return $this->where('storeid', '=', $this->_storeid)
            ->and('id', '=', $id)
            ->and('status', '=', STATUS['ALLOW'])
            ->select();
    }

    // Phương thức trả về danh sách tài khoản
    public function list($page = 1)
    {
        return $this->where('storeid', '=', $this->_storeid)
            ->and('status', '=', STATUS['ALLOW'])
            ->orderby('created', 'DESC')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức trả về danh sách tất cả tài khoản
    public function listAll()
    {
        return $this->data(['id'])
            ->where('storeid', '=', $this->_storeid)
            ->and('status', '=', STATUS['ALLOW'])
            ->selectAll();
    }

    // Phương thức cập nhật quyền cho người dùng
    public function updatePermission($id, $role)
    {
        return $this->data(['role' => $role])
            ->where('id', '=', $id)
            ->and('role', '<>', 'all')
            ->update();
    }

    // Phương thức tìm kiếm tài khoản
    public function search($keyword, $page = 1)
    {
        return $this->where('storeid', '=', $this->_storeid)
            ->whereStr('AND `keyword` LIKE "%' . $keyword . '%"')
            ->and('status', '=', STATUS['ALLOW'])
            ->orderby('created', 'DESC')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức cập nhật mật khẩu mới
    public function updatePassword($password)
    {
        return $this->data([
            'password'      => Func::md5Password($password),
            'modified'      => $this->_time,
            'modified_by'   => $this->_loginid
        ])
            ->where('id', '=', Func::getIdUserLogin())
            ->update();
    }

    // Phương thức xóa một tài khoản
    public function remove($id)
    {
        return $this->data([
            'status'        => STATUS['DELETE'],
            'modified'      => $this->_time,
            'modified_by'   => $this->_loginid
        ])
            ->where('storeid', '=', $this->_storeid)
            ->and('id', '=', $id)
            ->update();
    }
}
