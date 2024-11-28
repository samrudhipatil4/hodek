<?php
class Suppliercontroller extends BaseModel  {
	
	protected $table = 'tb_supplier';
	protected $primaryKey = 'supplier_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_supplier.* FROM tb_supplier  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_supplier.supplier_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
