<?php
class TemplateMaster extends BaseModel  {
	
	protected $table = 'apqp_templatemaster';
	protected $primaryKey = 'template_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_templatemaster.* FROM apqp_templatemaster  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_templatemaster.template_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
