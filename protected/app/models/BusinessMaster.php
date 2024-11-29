<?php
class BusinessMaster extends BaseModel  {
	
	protected $table = 'tb_businessMaster';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_businessMaster.* FROM tb_businessMaster";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_businessMaster.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
