<?php
class CustomerCommunication extends BaseModel  {
	
	protected $table = 'tb_dynamicCustComm';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT tb_dynamicCustComm.* FROM tb_dynamicCustComm";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_dynamicCustComm.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
