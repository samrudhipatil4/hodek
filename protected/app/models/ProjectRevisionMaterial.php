<?php
class ProjectRevisionDate extends BaseModel  {
	
	protected $table = 'apqp_project_revision_materialchange';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT apqp_project_revision_materialchange.* FROM apqp_project_revision_materialchange";
	}
	public static function queryWhere(  ){
		
		return " WHERE apqp_project_revision_materialchange.id IS NOT NULL  ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
