<?php
class SteeringCommiteeMember extends BaseModel  {
	
	protected $table = 'tb_dynamicSteeringCommitee';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_dynamicSteeringCommitee.* FROM tb_dynamicSteeringCommitee";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_dynamicSteeringCommitee.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
