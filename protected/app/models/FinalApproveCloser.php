<?php
class FinalApproveCloser extends BaseModel  {
	
	protected $table = 'tb_finalApprovCloser';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT tb_finalApprovCloser.* FROM tb_finalApprovCloser";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_finalApprovCloser.id IS NOT NULL";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
