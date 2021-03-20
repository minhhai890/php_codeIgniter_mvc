<?php
namespace libs;
class Json {
	
	/*
	 * Phương thức đọc tập tin Json
	 * $pathFile: Đường dẫn tập tin cần tạo
	 * $assoc: True giá trị trả về là mảng, False giá trị trả về là đối tượng
	 */
	public function read($pathFile, $assoc = true) {
		if (file_exists ( $pathFile )) {
			return json_decode ( file_get_contents ( $pathFile ), $assoc );
		}
		return false;
	}
	
	/*
	 * Phương thức tạo tập tin Json
	 * $pathFile: Đường dẫn tập tin
	 * $data: Dữ liệu dạng mảng
	 */
	public function write($pathFile, $data) {
		$fp = @fopen ( $pathFile, 'w' );	
		if ($fp) {
			fwrite ( $fp, json_encode ( $data ) );
			fclose ( $fp );
			if (file_exists ( $pathFile )) {
				return true;
			}
		}
		return false;
	}
	
	/* Phương thức lấy ra một phần tử từ file json */
	public function loadRow($pathFile, $key, $value) {
		$dataJson = $this->read ( $pathFile );
		if ($dataJson) {
			return Func::getRowArray ( $dataJson, $key, $value );
		}
		return false;
	}
	
	/*
	 * Phương thức thêm một phần tử vào phía trước của tập tin json
	 * $pathFile: Đường dẫn tập tin
	 * $value: Giá trị mảng hoặc chuỗi
	 */
	public function insertRow($pathFile, $value) {
		$dataJson = $this->read($pathFile);
        if($dataJson){
        	$dataJson = Func::insertRowArray($dataJson, $value);
            $this->write($pathFile, $dataJson);
            return true;
        }
        return false;
    }
    
    /* Phương thức thêm một phần tử vào phía sau của tập tin json 
     * $pathFile: Đường dẫn tập tin
     * $value: Giá trị mảng hoặc chuỗi
     */
    public function appendRow($pathFile, $value){
        $dataJson = $this->read($pathFile);
        if($dataJson){
        	$dataJson = Func::appendRowArray($dataJson, $value);
            $this->write($pathFile, $dataJson);
            return true;
        }
        return false;
    }
    
    /* Phương thức chỉnh sử phần tử của tập tin json 
     * $pathFile: dường dẫn tập tin
     * $where: mảng điều kiện key = 1, key = 2,...
     * $newValue: Giá trị mới thay đổi giá trị cũ
     */
    public function updateRow($pathFile, $where, $newValue){
        $dataJson = $this->read($pathFile);
        if($dataJson){
        	$dataJson = Func::updateRowArray($dataJson, $where, $newValue);
            $this->write($pathFile, $dataJson);
            return true;
        }
        return false;
    }
    
    /* Phương thức xóa file */
    public function delete( $pathFile ){
        if(file_exists($pathFile)){
            return unlink($pathFile);
        }
        return false;
    }
}
