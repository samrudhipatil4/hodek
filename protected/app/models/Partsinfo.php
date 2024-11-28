<?php
class Partsinfo extends BaseModel  {
	
	protected $table = 'parts_info';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT parts_info.* FROM parts_info  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE parts_info.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
