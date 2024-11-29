<?php
class Plantcode extends BaseModel  {
	
	protected $table = 'plant_code';
	protected $primaryKey = 'plant_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT plant_code.* FROM plant_code  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE plant_code.plant_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
