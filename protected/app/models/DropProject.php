<?php
class DropProject extends BaseModel  {
	
	protected $table = 'apqp_drop_project';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_drop_project.* FROM apqp_drop_project";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_drop_project.id IS NOT NULL  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
