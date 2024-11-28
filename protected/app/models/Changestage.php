<?php
class Changestage extends BaseModel  {
	
	protected $table = 'tb_change_stage';
	protected $primaryKey = 'change_stage_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_change_stage.* FROM tb_change_stage  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_change_stage.change_stage_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
