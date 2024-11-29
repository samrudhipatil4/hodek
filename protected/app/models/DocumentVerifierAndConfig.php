<?php
class DocumentVerifierAndConfig extends BaseModel  {
	
	protected $table = 'tb_documentVerifyConfig';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT tb_documentVerifyConfig.* FROM tb_documentVerifyConfig";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_documentVerifyConfig.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
