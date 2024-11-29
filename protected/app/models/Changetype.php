<?php
class Changetype extends BaseModel  {
	
	protected $table = 'tbl_change_type';
	protected $primaryKey = 'change_type_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tbl_change_type.* FROM tbl_change_type  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tbl_change_type.change_type_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
