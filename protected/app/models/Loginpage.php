<?php
class Loginpage extends BaseModel  {
	
	protected $table = 'login_management';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT login_management.* FROM login_management  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE login_management.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
