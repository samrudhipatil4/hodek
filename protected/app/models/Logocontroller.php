<?php
class Logocontroller extends BaseModel  {
	
	protected $table = 'tb_logo';
	protected $primaryKey = 'company_logo_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_logo.* FROM tb_logo  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_logo.company_logo_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
