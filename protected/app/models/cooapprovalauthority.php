<?php
class cooapprovalauthority extends BaseModel  {
	
	protected $table = 'tb_cooapprovalauthority';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT  tb_cooapprovalauthority.* FROM  tb_cooapprovalauthority";
	}
	public static function queryWhere(  ){
		
		return " WHERE  tb_cooapprovalauthority.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
