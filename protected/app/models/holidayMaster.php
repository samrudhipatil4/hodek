<?php
class holidayMaster extends BaseModel  {
	
	protected $table = 'apqp_holiday_master';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_holiday_master.* FROM apqp_holiday_master";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_holiday_master.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
