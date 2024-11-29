<?php
class veloParameter extends BaseModel  {
	
	protected $table = 'tb_dept_addRemove';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_dept_addRemove.* FROM tb_dept_addRemove  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_dept_addRemove.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
