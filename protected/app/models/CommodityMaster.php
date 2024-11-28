<?php
class CommodityMaster extends BaseModel  {
	
	protected $table = 'apqp_commodity_master';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_commodity_master.* FROM apqp_commodity_master";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_commodity_master.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
