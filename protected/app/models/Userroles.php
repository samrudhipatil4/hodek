<?php
class Userroles extends BaseModel  {
	
	protected $table = 'tb_groups';
	protected $primaryKey = 'group_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_groups.* FROM tb_groups  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_groups.group_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
