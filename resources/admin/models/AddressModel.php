<?php

namespace resources\app\models;

use resources\app\libs\Model;

class AddressModel extends Model
{

    // Phương thức trả về danh sách tỉnh thành
    public function provinces($keyword, $limit = RD_LIMIT, $position = 0)
    {
        return $this->table('provinces')
            ->data(['id', 'name'])
            ->where('keyword', 'LIKE', '%' . $keyword . '%')
            ->limit($position, $limit)
            ->selectAll();
    }

    // Phương thức trả về danh sách tỉnh thành
    public function districts($provinceid, $keyword, $limit = RD_LIMIT, $position = 0)
    {
        return $this->table('districts')
            ->data(['id', 'name'])
            ->where('provinceid', '=', $provinceid)
            ->and('keyword', 'LIKE', '%' . $keyword . '%')
            ->limit($position, $limit)
            ->selectAll();
    }

    // Phương thức trả về danh sách tỉnh thành
    public function wards($districtid, $keyword, $limit = RD_LIMIT, $position = 0)
    {
        return $this->table('wards')
            ->data(['id', 'name'])
            ->where('districtid', '=', $districtid)
            ->and('keyword', 'LIKE', '%' . $keyword . '%')
            ->limit($position, $limit)
            ->selectAll();
    }
}