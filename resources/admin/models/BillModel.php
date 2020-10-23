<?php

namespace resources\app\models;

use resources\app\libs\Model;
use resources\app\libs\Func;

class BillModel extends Model
{

    // Phương thức khởi tạo
    public function __construct()
    {
        parent::__construct();
        $this->tableDetault('bills');
    }

    // Phương thức tạo câu sql từ 3 bảng customers, address, bills
    public function sqlList()
    {
        $this->table('customers')
            ->column(['id', 'name', 'keyword', 'picture', 'link', 'phone', 'profileid', 'socialid'])
            ->innerJoin('address')
            ->column(['provinceid', 'districtid', 'wardid', 'fulladdress'])
            ->on('customers.id', '=', 'address.customerid')
            ->innerJoin('bills')
            ->column(['id', 'amount', 'collect', 'created', 'send', 'many', 'purchase', 'note', 'status'])
            ->on('customers.id', '=', 'bills.customerid')
            ->where('customers.storeid', '=', $this->_storeid)
            ->and('address.status', '=', STATUS['ALLOW']);
        return $this;
    }

    // Phương thức tạo câu sql từ 3 bảng customers, address, bills
    public function sqlDetail()
    {
        $this->table('customers')
            ->column(['id', 'name', 'keyword', 'picture', 'link', 'phone', 'profileid', 'socialid', 'amount', 'note'])
            ->innerJoin('address')
            ->column()
            ->on('customers.id', '=', 'address.customerid')
            ->innerJoin('bills')
            ->column()
            ->on('customers.id', '=', 'bills.customerid')
            ->where('customers.storeid', '=', $this->_storeid)
            ->and('address.status', '=', STATUS['ALLOW']);
        return $this;
    }

    // Phương thức thêm một khách hàng mới
    public function add($params)
    {
        // Khởi tạo
        $this->beginTransaction();
        if ($customerid = $this->addCustomer($params)) {
            if ($this->addAddress($customerid, $params)) {
                if ($billid = $this->addBill($customerid)) {
                    $this->commit();
                    return $billid;
                }
            }
        }
        $this->rollback();
        return false;
    }

    // Phương thức chỉnh sửa khách hàng
    public function edit($cid, $camount, $params)
    {
        // Khởi tạo
        $this->beginTransaction();
        // add customer
        if ($this->editCustomer($cid, $params)) {
            if ($camount > 0) {
                $this->table('address')
                    ->data(['status' => STATUS['PAUSE']])
                    ->where('customerid', '=', $cid)
                    ->update();
                $addressid = $this->addAddress($cid, $params);
            } else {
                $addressid = $this->editAddress($cid, $params);
            }
            if ($addressid) {
                $this->commit();
                return $cid;
            }
        }
        $this->rollback();
        return false;
    }

    // Phương thước trả về danh sách đơn hàng
    public function list($page = 1)
    {
        return $this->$this->sqlList()
            ->orderby('created', 'DESC', 'tbl')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thước trả về danh sách đơn hàng theo id 
    public function listBid($bid, $page = 1)
    {
        return $this->$this->sqlList()
            ->whereStr('AND tbl.`id`=' . $bid)
            ->orderby('created', 'DESC', 'tbl')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thước trả về danh sách đơn hàng theo id khách hàng
    public function listCid($cid, $page = 1)
    {
        return $this->$this->sqlList()
            ->whereStr('AND tcs.`id`=' . $cid)
            ->orderby('created', 'DESC', 'tbl')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thước trả về danh sách đơn hàng cho tìm kiếm
    public function search($params, $keyword, $page = 1)
    {
        $columns = ['name' => 'tcs.`keyword`', 'phone' => 'tcs.`phone`', 'madon' => 'tbl.`id`', 'mavandon' => 'tbl.`ship_idx`'];
        return $this->$this->sqlList()
            ->whereStr('AND ' . $columns[$params['column']] . ' LIKE "%' . $keyword . '%"')
            ->whereStr('AND tbl.`status`IN (' . $params['status'] . ')')
            ->orderby('created', 'DESC', 'tbl')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thước trả về giá trị của một đơn hàng
    public function detail($id)
    {
        return $this->$this->sqlDetail()->whereStr('AND tbl.`id`=' . $id)->select();
    }

    // Phương thức trả về dữ liệu khách hàng
    public function customer($cid)
    {
        return $this->table('custmers')
            ->column(['id', 'name', 'phone', 'email', 'socialid', 'note', 'amount'])
            ->innerJoin('address')
            ->column(['provinceid', 'districtid', 'wardid', 'province', 'district', 'ward', 'address'])
            ->on('customers.id', '=', 'address.customerid')
            ->where('customers.storeid', '=', $this->_storeid)
            ->and('address.status', '=', STATUS['ALLOW'])
            ->and('customers.id', '=', $cid)
            ->select();
    }

    // Phương thức trả về dữ liệu đơn hàng
    public function bill($id)
    {
        return $this->where('id', '=', $id)->select();
    }

    // Phương thức hiển thị người gửi chung
    public function many($id)
    {
        return $this->table('customers')
            ->data(['id', 'name'])
            ->where('id', '=', $id)
            ->select();
    }

    // Phương thức thêm địa chỉ
    public function addAddress($cid, $params)
    {
        return $this->table('address')
            ->data([
                'provinceid'    => $params['provinceid'],
                'districtid'    => $params['districtid'],
                'wardid'        => $params['wardid'],
                'province'      => $params['province'],
                'district'      => $params['district'],
                'ward'          => $params['ward'],
                'address'       => $params['address'],
                'fulladdress'   => $params['fulladdress'],
                'created'       => $this->_time,
                'status'        => STATUS['ALLOW'],
                'customerid'    => $cid
            ])
            ->insert();
    }

    // Phương thức chỉnh sửa địa chỉ
    public function editAddress($cid, $params)
    {
        return $this->table('address')
            ->data([
                'provinceid'    => $params['provinceid'],
                'districtid'    => $params['districtid'],
                'wardid'        => $params['wardid'],
                'province'      => $params['province'],
                'district'      => $params['district'],
                'ward'          => $params['ward'],
                'address'       => $params['address'],
                'fulladdress'   => $params['fulladdress'],
                'modified'      => $this->_time
            ])
            ->where('customerid', '=', $cid)
            ->and('status', '=', STATUS['ALLOW'])
            ->update();
    }

    // Phương thức thêm mới đơn hàng
    public function addBill($cid)
    {
        return $this->data([
            'created'       => $this->_time,
            'created_by'    => $this->_loginid,
            'status'        => STATUS['UNSEND'],
            'customerid'    => $cid
        ])->insert();
    }

    // Phương thức thêm thông tin khách hàng
    public function addCustomer($params)
    {
        return $this->table('customers')
            ->data([
                'name'       => $params['name'],
                'keyword'    => Func::convertUnicode($params['name']),
                'phone'      => $params['phone'],
                'email'      => $params['email'],
                'picture'    => $params['picture'],
                'link'       => $params['link'],
                'profileid'  => $params['profileid'],
                'created'    => $this->_time,
                'created_by' => $this->_loginid,
                'note'       => $params['note'],
                'status'     => STATUS['ALLOW'],
                'storeid'    => $this->_storeid
            ])
            ->insert();
    }

    // Phương thức chỉnh sửa thông tin khách hàng
    public function editCustomer($cid, $params)
    {
        return $this->table('customers')
            ->data([
                'name'          => $params['name'],
                'keyword'       => Func::convertUnicode($params['name']),
                'phone'         => $params['phone'],
                'email'         => $params['email'],
                'picture'       => $params['picture'],
                'link'          => $params['link'],
                'profileid'     => $params['profileid'],
                'modified'      => $this->_time,
                'modified_by'   => $this->_loginid,
                'note'          => $params['note']
            ])
            ->where('id', '=', $cid)
            ->update();
    }

    // Phương thức cập nhật ghi chú của khách hàng
    public function noteCustomer($cid, $note)
    {
        return $this->table('customers')
            ->data(['note' => $note])
            ->where('id', '=', $cid)
            ->update();
    }

    // Phương thước trả về danh sách bình luận
    public function comment($cid, $page = 1)
    {
        return $this->table('comments')
            ->column(['message'])
            ->innerJoin('posts')
            ->column(['idx', 'title', 'message', 'link', 'created'])
            ->on('comments.postid', '=', 'posts.id')
            ->where('comments.customerid', '=', $cid)
            ->orderby('comments.created', 'DESC', 'tcm')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức cập nhật ngày tạo đơn hàng
    public function updateCreated($id)
    {
        $update = $this->data(['created' => $this->_time])
            ->where('id', '=', $id)
            ->update();
        if ($update) {
            return $this->_time;
        }
    }

    // Phương thức trả về danh sách dòng
    public function listProduct($page = 1)
    {
        return $this->productImportInventoryUnitUser()
            ->and('imports.status', '=', STATUS['ALLOW'])
            ->orderby('imports.created', 'ASC')
            ->orderby('imports.amount_exist', 'ASC')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức tìm kiếm sản phẩm nhập
    public function searchProduct($keyword, $page = 1)
    {
        return $this->productImportInventoryUnitUser()
            ->and('imports.status', '=', STATUS['ALLOW'])
            ->and('products.keyword', 'LIKE', "%$keyword%")
            ->orderby('imports.created', 'ASC')
            ->orderby('imports.amount_exist', 'ASC')
            ->limit(($page * RD_LIMIT - RD_LIMIT), RD_LIMIT)
            ->selectAll();
    }

    // Phương thức trả về danh sách sản phẩm của một đơn hàng
    public function billProducts($arrID)
    {
        return $this->table('details')
            ->column()
            ->innerJoin('products')
            ->column(['id', 'key', 'name'])
            ->on('products.id', '=', 'details.productid')
            ->where('details.billid', 'IN', '(' . $this->convertValueIn($arrID) . ')')
            ->orderby('details.created', 'DESC')
            ->selectAll();
    }

    // Phương thức trả về danh sách sản phẩm của một đơn hàng
    public function detailProduct($productid)
    {
        return $this->table('details')
            ->where('productid', '=', $productid)
            ->select();
    }

    // Phương thức trả về một dòng trong bảng import
    public function imports($productid)
    {
        return $this->table('imports')
            ->where('productid', '=', $productid)
            ->orderby('created', 'ASC')
            ->orderby('amount_exist', 'DESC')
            ->selectAll();
    }

    // Phương thức cập nhật số lượng tồn cho import
    public function updateImport($id, $amountExist)
    {
        return $this->table('imports')
            ->data(['amount_exist' => $amountExist])
            ->where('id', '=', $id)
            ->update();
    }

    // Phương thức thêm một sản phẩm vào đơn hàng
    public function addProduct($params)
    {
        return $this->table('details')
            ->data([
                'amount'        => $params['amount'],
                'price_import'  => $params['price_import'],
                'price_export'  => $params['price_export'],
                'price_seller'  => $params['price_seller'],
                'created'       => $this->_time,
                'created_by'    => $this->_loginid,
                'productid'     => $params['productid'],
                'billid'        => $params['billid']
            ])
            ->insert();
    }

    // Phương thức cập nhật một sản phẩm vào đơn hàng
    public function updateProduct($params)
    {
        return $this->table('details')
            ->data([
                'amount'        => $params['amount'],
                'price_import'  => $params['price_import'],
                'price_export'  => $params['price_export'],
                'price_seller'  => $params['price_seller'],
                'modified'       => $this->_time,
                'modified_by'    => $this->_loginid
            ])
            ->update();
    }

    // Phương thức cập nhật đơn hàng
    public function updateBill($id, $params)
    {
        return $this->table('bills')
            ->data([
                'amount'  => $params['amount'],
                'price'   => $params['price'],
                'collect' => $params['collect'],
                'total'   => $params['total']
            ])
            ->where('id', '=', $id)
            ->update();
    }
}