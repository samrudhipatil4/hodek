<?php
class draftProject extends BaseModel  {
	
	protected $table = 'apqp_draft_project_plan';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_draft_project_plan.* FROM apqp_draft_project_plan";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_draft_project_plan.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
