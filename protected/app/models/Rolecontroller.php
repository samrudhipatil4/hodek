<?php
class Rolecontroller extends BaseModel  {
	
	protected $table = 'tb_role';
	protected $primaryKey = 'role_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_role.* FROM tb_role  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_role.role_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
