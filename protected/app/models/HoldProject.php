<?php
class HoldProject extends BaseModel  {
	
	protected $table = 'apqp_new_project_info';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_new_project_info.* FROM apqp_new_project_info";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_new_project_info.id IS NOT NULL and apqp_new_project_info.flag=1 and project_revision = (select max(project_revision) from apqp_new_project_info as b  where apqp_new_project_info.project_no=b.project_no )    and apqp_new_project_info.id NOT IN(select project_id from apqp_drop_project) and apqp_new_project_info.id IN(select project_id from apqp_draft_project_plan where release_project= 1)  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
