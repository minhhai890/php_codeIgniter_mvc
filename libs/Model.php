<?php

namespace libs;

class Model
{
    protected $_pdo                 = null;
    protected $_sta                 = null;
    protected $_host                = DB_HOST;
    protected $_user                = DB_USER;
    protected $_pwd                 = DB_PWD;
    protected $_db                  = DB_NAME;
    protected $_prefix              = TB_PREFIX;
    protected $_tableDefault        = '';
    protected $_tableTemp           = [];

    protected $_query               = [];
    protected $_column              = [];
    protected $_from                = '';
    protected $_data                = [];
    protected $_join                = false;
    protected $_where               = '';
    protected $_orderby             = '';
    protected $_limit               = '';
    protected $_transactionCount    = 0;


    // Phương thức khởi tạo
    public function __construct($params = array())
    {
        if (!$params) {
            $params = [
                'host' => $this->_host,
                'user' => $this->_user,
                'pwd' => $this->_pwd,
                'db' => $this->_db,
            ];
        }
        $this->connect($params);
    }

    // Phương thức kết nối cơ sở dữ liệu
    protected function connect($params)
    {
        try {
            $this->_pdo = new \PDO('mysql:host=' . $params['host'] . ';dbname=' . $params['db'], $params['user'], $params['pwd']);
            $this->_pdo->query('set names "utf8"');
        } catch (\PDOException $ex) {
            die($ex->getMessage());
        }
    }

    // Phương thức SAVEPOINT Trans
    public function beginTransaction()
    {
        if (!$this->_transactionCount++) {
            return $this->_pdo->beginTransaction();
        }
        $this->_pdo->exec('SAVEPOINT trans' . $this->_transactionCount);
        return $this->_transactionCount >= 0;
    }

    // Phương thức Commit
    public function commit()
    {
        if (!--$this->_transactionCount) {
            return $this->_pdo->commit();
        }
        return $this->_transactionCount >= 0;
    }

    // Phương thức rollback
    public function rollback()
    {
        if (--$this->_transactionCount) {
            $this->_pdo->exec('ROLLBACK TO trans' . ($this->_transactionCount + 1));
            return true;
        }
        return $this->_pdo->rollback();
    }

    // Phương thức thiết lập tên database
    public function setDatabase($database)
    {
        $this->_db = $database;
    }

    // Phương thức trả về tên database
    public function getDatabase()
    {
        return $this->_db;
    }

    // Phương thức trả về tất cả bảng của database
    public function getTablesName()
    {
        $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='" . $this->_db . "'";
        return $this->selectAll($query);
    }

    // Phương thức trả về tất cả cột của một bảng
    public function getTableColumns($tableName = '')
    {
        $tableName = ($tableName ? $this->_prefix . $tableName : $this->getTable());
        $query  = "SELECT COLUMN_NAME, DATA_TYPE, COLUMN_DEFAULT, NUMERIC_PRECISION, COLUMN_TYPE, COLUMN_KEY, EXTRA FROM INFORMATION_SCHEMA.COLUMNS ";
        $query .= "WHERE TABLE_SCHEMA='" . $this->_db . "' AND TABLE_NAME='" . $tableName . "'";
        return $this->selectAll($query);
    }

    // Phương thức trả về tất cả cột của một bảng
    public function getTableColumnNames($tableName = '')
    {
        $columns = [];
        if ($items = $this->getTableColumns($tableName)) {
            foreach ($items as $value) {
                $type = '';
                if ($value['COLUMN_DEFAULT']) {    // default
                    $type = $value['COLUMN_DEFAULT'];
                    if ($type == 'NULL' || $type == 'null') {
                        $type = null;
                    }
                }
                if ($value['NUMERIC_PRECISION']) {
                    if ($value['COLUMN_KEY'] && $value['EXTRA']) {
                        $type = null; // interger PRI auto_increment
                    } else {
                        $type = 0; // interger
                    }
                }
                $columns[$value['COLUMN_NAME']] = $type;
            }
        }
        return $columns;
    }

    // Phương thức thiết lập tên bảng mặc định
    public function tableDetault($tableName)
    {
        $this->_tableDefault = $tableName;
        return $this;
    }

    // Phương thức trả về tên bảng mặc định
    public function getTableDefault()
    {
        return $this->_prefix . $this->_tableDefault;
    }

    // Phương thức thiết lập bảng để thực hiện câu truy vấn
    public function table($tableName)
    {
        $this->_tableTemp = $tableName;
        $this->_from = ' FROM `' . $this->_prefix . $tableName . '` AS ' . $tableName;
        return $this;
    }

    // Phương thức trả về tên bảng hiện tại
    public function getTable()
    {
        if ($this->_tableTemp) {
            return $this->_prefix . $this->_tableTemp;
        }
        return $this->_prefix . $this->_tableDefault;
    }

    // Phương thức thiết lập tên cột cần lấy của một bảng
    public function column($options = array())
    {
        if (!$this->_tableTemp) {
            $this->_tableTemp = $this->_tableDefault;
        }
        if (!$options) {
            if ($columns = $this->getTableColumnNames()) {
                $options = array_keys($columns);
            }
        }
        $this->_column[$this->_tableTemp] = $options;
        return $this;
    }

    // Phương thức thiết lập dữ liệu cho câu truy vấn insert hoặc query update
    public function data($options)
    {
        $this->_data = $options;
        return $this;
    }

    // Phương thức thiết lập điều kiện câu truy vấn
    public function where($column, $operator, $value)
    {
        if (strpos($value, '(') === false) {
            $value = '"' . \addslashes($value) . '"';
        }
        $column = $this->convertColumn($column);
        if (strpos($column, '`') === false) {
            $column = '`' . $column . '`';
        }
        $this->_where .= ' ' . \addslashes($column) . ' ' . $operator . ' ' . $value;
        return $this;
    }

    // Phương thức thiết điều kiện câu truy vấn AND
    public function and($column, $operator, $value)
    {
        $this->_where .= ' AND ';
        return $this->where($column, $operator, $value);
    }

    // Phương thức thiết điều kiện câu truy vấn OR
    public function or($column, $operator, $value)
    {
        $this->_where .= ' OR ';
        return $this->where($column, $operator, $value);
    }

    // Phương thức tạo điều kiện truy vấn nhập chuỗi trực tiếp
    public function whereStr($str = '')
    {
        $this->_where .= ' ' . $str;
        return $this;
    }

    // Phương thức sắp xếp dữ liệu ASC hoặc DESC
    public function orderby($column, $type = 'DESC')
    {
        if (!$this->_orderby) {
            $this->_orderby .= ' ORDER BY ';
        } else {
            $this->_orderby .= ', ';
        }
        if (strpos($column, '.') === false) {
            $column = '`' . $column . '`';
        }
        $this->_orderby .= \addslashes($column) . ' ' . \addslashes($type);
        return $this;
    }

    // Phương thức giới hạn số dòng dữ liệu
    public function limit($position, $length = RD_LIMIT)
    {
        $this->_limit = ' LIMIT ' . \addslashes($position) . ', ' . \addslashes($length);
        return $this;
    }

    // Phương thức tạo string từ mảng truy vấn
    public function convertValueIn($option = array())
    {
        $array = array();
        if ($option) {
            foreach ($option as $value) {
                $value = trim($value);
                if (!empty($value)) {
                    $array[] = "'" . \addslashes(trim($value)) . "'";
                }
            }
        }
        return implode(',', $array);
    }

    // Hàng định dạng cột khi kết nối nhiều bảng
    public function convertColumn($column)
    {
        return preg_replace('/(\w+)\.(\w+)/im', ' $1.`$2`', $column);
    }

    // Kiểm tra FROM có được truyền hay không? và truyền FROM
    public function isFrom()
    {
        if (!$this->_from && $this->_tableDefault) {
            $this->table($this->_tableDefault);
        }
    }

    // Phương thức thiết lập điều kiện cho join bảng
    public function on($condition1, $operator, $condition2)
    {
        $this->_join = true;
        $this->_from .= ' ON (' . $this->convertColumn($condition1) . $operator . $this->convertColumn($condition2) . ')';
        return $this;
    }

    // Phương thức inner join
    public function innerJoin($tableName)
    {
        $this->isFrom();
        if ($this->_from) {
            $this->_from .= ' INNER JOIN `' . $this->_prefix . $tableName . '` AS ' . $tableName;
            $this->_tableTemp = $tableName;
        }
        return $this;
    }

    // Phương thức left join
    public function leftJoin($tableName)
    {
        $this->isFrom();
        if ($this->_from) {
            $this->_from .= ' LEFT JOIN `' . $this->_prefix . $tableName . '` AS ' . $tableName;
            $this->_tableTemp = $tableName;
        }
        return $this;
    }

    // Phương thức right join
    public function rightJoin($tableName)
    {
        $this->isFrom();
        if ($this->_from) {
            $this->_from .= ' RIGHT JOIN `' . $this->_prefix . $tableName . '` AS ' . $tableName;
            $this->_tableTemp = $tableName;
        }
        return $this;
    }

    // Phương thức thiết lập tên cột cần lấy của một bảng
    public function createColumn()
    {
        if (!$this->_column) {
            if ($columns = $this->getTableColumnNames()) {
                $this->_column[$this->getTable()] = array_keys($columns);
            }
        }
        if ($this->_column) {
            $listColumns = [];
            foreach ($this->_column as $table => $column) {
                foreach ($column as $name) {
                    if (strpos($name, '(')) {
                        $listColumns[] = preg_replace('/\((.+)\)/m', '(`$1`)', $name);
                    } else {
                        if ($this->_join) {
                            $listColumns[] = $table . '.`' . $name . '`  AS ' . $table . '_' . $name;
                        } else {
                            $listColumns[] = '`' . $name . '`';
                        }
                    }
                }
            }
            return \implode(',', $listColumns);
        }
        return '';
    }

    // Phương thức tạo câu truy vấn select
    public function querySelect()
    {
        $this->isFrom();
        if ($this->_from) {
            return $this->create('SELECT ' . $this->createColumn() . $this->_from);
        }
        return '';
    }

    // Phương thức trả về một dòng dữ liệu với type array
    public function select($query = '', $options = array())
    {
        if (!$query) {
            $query = $this->querySelect();
        }
        if (!$result = $this->execute($query, $options)) {
            return false;
        }
        return $result->fetch(\PDO::FETCH_ASSOC);
    }

    // Phương thức trả về nhiều dòng dữ liệu với type array
    public function selectAll($query = '', $options = array())
    {
        if (!$query) {
            $query = $this->querySelect();
        }
        if (!$result = $this->execute($query, $options)) {
            return false;
        }
        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Phương thức thêm một dòng dữ liệu
    public function insert($query = '', $options = array())
    {
        if (!$query) {
            if (($table = $this->getTable()) && $this->_data) {
                $cols = $vals = '';
                foreach ($this->_data as $column => $value) {
                    $cols .= ", `$column`";
                    $vals .= ", " . (\is_null($value) ? ("NULL") : ("'" . \addslashes($value) . "'"));
                }
                $query =  $this->create('INSERT INTO `' . $table . '` (' . \substr($cols, 2) . ') VALUES (' . \substr($vals, 2) . ')');
            }
        }
        if ($query) {
            $this->execute($query, $options);
            return $this->getLastId();
        }
    }

    // Phương thức cập nhật dữ liệu
    public function update($query = '', $options = array())
    {
        if (!$query) {
            if (($table = $this->getTable()) && $this->_data) {
                $data = '';
                foreach ($this->_data as $column => $value) {
                    $data .= ",`" . \addslashes($column) . "`='" . \addslashes($value) . "'";
                }
                $query =  $this->create('UPDATE `' . $table . '` SET ' . \substr($data, 1));
            }
        }
        if ($query) {
            $this->execute($query, $options);
            return $this->getRowCount();
        }
    }

    // Phương thức xóa dữ liệu
    public function delete($query = '', $options = array())
    {
        if (!$query) {
            if (($table = $this->getTable()) && $this->_where) {
                $query =  $this->create('DELETE FROM `' . $table . '`');
            }
        }
        if ($query) {
            $this->execute($query, $options);
            return $this->getRowCount();
        }
    }

    // Phương thức số dòng dữ liệu theo điều kiện where của câu truy vấn
    public function count($column)
    {
        if ($this->_query) {
            $query = current(array_reverse($this->_query));
            preg_match('/where(.+)(order?)(.*)(limit?)/im', $query, $match);
            if ($match) {
                $items = $this->select('SELECT COUNT(`' . $column . '`) as record WHERE ' . $match[1]);
                if ($items) {
                    return $items['record'];
                }
            }
        }
        return 0;
    }

    // Phương thức tạo câu truy vấn
    public function create($query)
    {
        if ($query) {
            if ($this->_where) {
                if (preg_match('/where/im', $query)) {
                    $query .=  $this->_where;
                } else {
                    $query .= ' WHERE ' . $this->_where;
                }
            }
            $query .= $this->_orderby . $this->_limit;
            $this->_query[] = $query;
            $this->reset();
        }
        return $query;
    }

    // Phương thức reset tham số
    public function reset()
    {
        $this->_tableTemp      = '';
        $this->_column         = [];
        $this->_from           = '';
        $this->_data           = [];
        $this->_join           = false;
        $this->_where          = '';
        $this->_orderby        = '';
        $this->_limit          = '';
    }

    // Phương thức thực thi câu truy vấn
    protected function execute($query, $options = array())
    {
        if ($query) {
            $this->_sta = $this->_pdo->prepare($query);
            if ($options) {
                for ($i = 0; $i < count($options); $i++) {
                    $this->_sta->bindParam($i + 1, $options[$i]);
                }
            }
            $this->_sta->execute();
            return $this->_sta;
        }
        return false;
    }

    // Phương thức đếm dòng trả về khi truy vấn
    public function getRowCount()
    {
        return $this->_sta->rowCount();
    }

    // Phương thức trả về id cuối cùng của bảng
    public function getLastId()
    {
        return $this->_pdo->lastInsertId();
    }

    // Phương thức hiển thị nhưng câu truy vấn
    public function showQuery()
    {
        $list = '';
        if ($this->_query) {
            foreach ($this->_query as $query) {
                $list .= '<h3>' . $query . '</h3><br/>';
            }
        }
        return $list;
    }

    // Phước thức ngắt kết nối database
    public function disconnect()
    {
        $this->_pdo = null;
    }

    // Phương thức ngắt kết nối database tự động
    public function __destruct()
    {
        $this->disconnect();
    }
}
