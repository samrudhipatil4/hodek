<?php
class Stakeholder extends BaseModel  {
	
	protected $table = 'tb_stakeholder';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_stakeholder.* FROM tb_stakeholder";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_stakeholder.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
