<?php

namespace resources\app\models;

use resources\app\libs\Model;

class InventoryModel extends Model
{

    // Phương thức khởi tạo
    public function __construct()
    {
        parent::__construct();
        $this->tableDetault('inventorys');
    }

    // Phương thức thêm mới một dòng
    public function add($params)
    {
        return $this->data([
            'name'       => $params['name'],
            'keyword'    => $params['keyword'],
            'address'    => $params['address'],
            'note'       => $params['note'],
            'created'    => $this->_time,
            'created_by' => $this->_loginid,
            'status'     => STATUS['ALLOW'],
            'storeid'    => $this->_storeid
        ])->insert();
    }

    // Phương thức trả về một dòng theo id
    public function detail($id)
    {
        return $this->where('storeid', '=', $this->_storeid)
            ->and('id', '=', $id)
            ->and('status', '=', STATUS['ALLOW'])
            ->select();
    }

    // Phương thức trả về danh sách dòng
    public function list($page = 1)
    {
        return $this->where('storeid', '=', $this->_storeid)
            ->and('status', '=', STATUS['ALLOW'])
            ->orderby('created', 'DESC')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức trả về tất cả các dòng
    public function listAll()
    {
        return $this->data(['id'])
            ->where('storeid', '=', $this->_storeid)
            ->and('status', '=', STATUS['ALLOW'])
            ->selectAll();
    }

    // Phương thức tìm kiếm kho
    public function search($keyword, $page = 1)
    {
        return $this->where('storeid', '=', $this->_storeid)
            ->whereStr('AND `keyword` LIKE "%' . $keyword . '%"')
            ->and('status', '=', STATUS['ALLOW'])
            ->orderby('created', 'DESC')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức cập nhật một dòng
    public function edit($id, $data)
    {
        return $this->data([
            'name'          => $data['name'],
            'keyword'       => $data['keyword'],
            'address'       => $data['address'],
            'note'          => $data['note'],
            'modified'      => $this->_time,
            'modified_by'   => $this->_loginid
        ])
            ->where('storeid', '=', $this->_storeid)
            ->and('id', '=', $id)
            ->update();
    }
}
