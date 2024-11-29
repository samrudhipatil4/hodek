<?php
class materialMaster extends BaseModel  {
	
	protected $table = 'apqp_material_master';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_material_master.* FROM apqp_material_master";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_material_master.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
