<?php 
namespace libs;
// Thiết lập đường dẫn cho chương trình
class Url{    
        
    /* Phương thức chuyển trang
     * $link: đường dẫn cần chuyển
     */
	static function redirect($link){    	
    	header('Location: ' . $link);
        exit();
    }

}

?>