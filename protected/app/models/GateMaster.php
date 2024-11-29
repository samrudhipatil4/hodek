<?php
class GateMaster extends BaseModel  {
	
	protected $table = 'apqp_gate_management_master';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_gate_management_master.* FROM apqp_gate_management_master";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_gate_management_master.id IS NOT NULL  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
