<?php
class Department extends BaseModel  {
	
	protected $table = 'tb_departments';
	protected $primaryKey = 'd_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_departments.* FROM tb_departments  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_departments.d_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}


   public function Dep(){
      return $this->hasMany('Subdepartment');
   }

 
	

}
