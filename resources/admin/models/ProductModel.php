<?php

namespace resources\app\models;

use resources\app\libs\Model;

class ProductModel extends Model
{

    // Phương thức khởi tạo
    public function __construct()
    {
        parent::__construct();
        $this->tableDetault('products');
    }

    // Phương thức thêm đơn vị tính
    public function addUnit($name)
    {
        return $this->table('units')
            ->data([
                'name'          => mb_convert_case($name, MB_CASE_TITLE, "UTF-8"),
                'created'       => $this->_time,
                'created_by'    => $this->_loginid
            ])->insert();
    }

    // Phương thức trả về unit chi tiết
    public function unit($id)
    {
        return $this->table('units')
            ->where('id', '=', $id)
            ->select();
    }

    // Phương thức load all units
    public function listUnits($page = 1)
    {
        return $this->table('units')
            ->orderby('id')
            // ->limit(($page*RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức thêm mới một dòng
    public function add($data)
    {
        return $this->data([

            'key'           => $data['key'],
            'name'          => $data['name'],
            'keyword'       => $data['keyword'],
            'image'         => $data['image'],
            'created'       => $this->_time,
            'created_by'    => $this->_loginid,
            'status'        => $data['status'],
            'unitid'        => $data['unitid']

        ])
            ->insert();
    }


    // Phương thức trả về một dòng theo id
    public function detail($id)
    {
        return $this->column()
            ->innerJoin('units')
            ->column(['id', 'name'])
            ->on('products.unitid', '=', 'units.id')
            ->innerJoin('users')
            ->column(['name'])
            ->on('products.created_by', '=', 'users.id')
            ->where('products.id', '=', $id)
            ->select();
    }

    // Phương thức trả về danh sách dòng
    public function list($page = 1)
    {
        return $this->column()
            ->innerJoin('units')
            ->column(['name'])
            ->on('products.unitid', '=', 'units.id')
            ->orderby('products.created')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức trả về tất cả các dòng
    public function listAll()
    {
        return $this->column()
            ->innerJoin('units')
            ->column(['name'])
            ->on('products.unitid', '=', 'units.id')
            ->orderby('products.created')
            ->selectAll();
    }

    // Phương thức tìm kiếm sản phẩm nhập
    public function search($keyword, $page = 1)
    {
        return $this->column()
            ->innerJoin('units')
            ->column(['name'])
            ->on('products.unitid', '=', 'units.id')
            ->where('products.keyword', 'LIKE', "%$keyword%")
            ->orderby('products.created')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức cập nhật một dòng
    public function edit($id, $data)
    {
        return $this->data([
            'key'       => $data['key'],
            'name'      => $data['name'],
            'keyword'   => $data['keyword'],
            'status'    => $data['status'],
            'unitid'    => $data['unitid']
        ])
            ->where('id', '=', $id)
            ->update();
    }

    // Phương thức xóa một dòng
    public function remove($id)
    {
        return $this->data(['status' => STATUS['DELETE']])
            ->where('storeid', '=', $this->_storeid)
            ->and('id', '=', $id)
            ->update();
    }
}
