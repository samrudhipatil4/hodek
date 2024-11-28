<?php
class Cftteamrepresentative extends BaseModel  {
	
	protected $table = 'tb_dynamiccftteamrepresentative';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT  tb_dynamiccftteamrepresentative.* FROM  tb_dynamiccftteamrepresentative";
	}
	public static function queryWhere(  ){
		
		return " WHERE  tb_dynamiccftteamrepresentative.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
