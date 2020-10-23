<?php

namespace resources\app\models;

use resources\app\libs\Model;

class ImportModel extends Model
{

    // Phương thức khởi tạo
    public function __construct()
    {
        parent::__construct();
        $this->tableDetault('imports');
    }

    // Phương thức tạo câu query nhập kho
    public function productImportInventoryUnitUser()
    {
        parent::productImportInventoryUnitUser()
            ->and('imports.status', 'IN', '(' . STATUS['ALLOW'] . ',' . STATUS['PENDING'] . ')');
        return $this;
    }


    // Phương thức trả về danh sách dòng    
    public function list($page = 1)
    {
        return $this->productImportInventoryUnitUser()
            ->orderby('imports.created')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức trả về một dòng theo id
    public function detail($id)
    {
        return $this->productImportInventoryUnitUser()
            ->and('imports.id', '=', $id)
            ->select();
    }

    // Phương thức hiển thị người thực hiện
    public function user($id)
    {
        return $this->table('users')
            ->data(['name'])
            ->where('id', '=', $id)
            ->select();
    }

    // Phương thức xác nhận nhập kho
    public function confirm($id, $params)
    {
        return $this->data([
            'amount_exist' => $params['amount'],
            'note' => $params['note'],
            'status' => STATUS['ALLOW'],
            'modified' => $this->_time,
            'modified_by' => $this->_loginid
        ])
            ->where('id', '=', $id)
            ->update();
    }
}