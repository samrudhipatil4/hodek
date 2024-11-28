<?php
class Changerequestpurpose extends BaseModel  {
	
	protected $table = 'changerequest_purpose';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT changerequest_purpose.* FROM changerequest_purpose  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE changerequest_purpose.id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
