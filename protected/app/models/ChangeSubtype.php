<?php
class ChangeSubtype extends BaseModel  {
	
	protected $table = 'tbl_chage_sub_type';
	protected $primaryKey = 'sub_type_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tbl_chage_sub_type.* FROM tbl_chage_sub_type  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tbl_chage_sub_type.sub_type_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
