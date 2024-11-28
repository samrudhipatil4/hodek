<?php
class HorizontalDeployment extends BaseModel  {
	
	protected $table = 'tb_dynamicHorizDeploy';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT tb_dynamicHorizDeploy.* FROM tb_dynamicHorizDeploy";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_dynamicHorizDeploy.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
