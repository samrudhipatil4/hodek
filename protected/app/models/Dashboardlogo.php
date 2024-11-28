<?php
class Dashboardlogo extends BaseModel  {
	
	protected $table = 'tb_dashboardlogo';
	protected $primaryKey = 'logo_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_dashboardlogo.* FROM tb_dashboardlogo  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_dashboardlogo.logo_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
