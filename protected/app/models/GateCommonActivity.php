<?php
class GateCommonActivity extends BaseModel  {
	
	protected $table = 'apqp_gate_activity_master';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_gate_activity_master.* FROM apqp_gate_activity_master";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_gate_activity_master.id IS NOT NULL && apqp_gate_activity_master.activity_type='C'  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
