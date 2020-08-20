<?php
namespace resources\home\libs;
use libs\Cookie;
class View extends \libs\View{

	public function __construct($params){
		parent::__construct($params);		
		$this->load(false);
	}
	
}
?>