<?php
class trackingSheet extends BaseModel  {
	
	protected $table = 'tracking_sheet_date_param';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tracking_sheet_date_param.* FROM tracking_sheet_date_param";
	}
	public static function queryWhere(  ){
		
		return " WHERE tracking_sheet_date_param.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
