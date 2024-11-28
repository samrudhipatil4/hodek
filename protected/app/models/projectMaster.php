<?php
class projectMaster extends BaseModel  {
	
	protected $table = 'tb_projectMaster';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_projectMaster.* FROM tb_projectMaster";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_projectMaster.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
