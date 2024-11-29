<?php
class Subdepartment extends BaseModel  {
	
	protected $table = 'subdepartments';
	protected $primaryKey = 'sub_dep_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT subdepartments.* FROM subdepartments  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE subdepartments.sub_dep_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	 public function Subdep(){
	 	
     return $this->belongsTo('Department');
   }

	

}
