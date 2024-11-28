<?php
class DepartmentList extends BaseModel  {
	
	protected $table = 'tb_dynamicDepartment';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_dynamicDepartment.* FROM tb_dynamicDepartment";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_dynamicDepartment.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
