<?php
class ProjectManager extends BaseModel  {
	
	protected $table = 'tb_project_manager';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_project_manager.* FROM tb_project_manager";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_project_manager.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
