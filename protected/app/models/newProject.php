<?php
class newProject extends BaseModel  {
	
	protected $table = 'apqp_new_project_info';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_new_project_info.* FROM apqp_new_project_info";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_new_project_info.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
