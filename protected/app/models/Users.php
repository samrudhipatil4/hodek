<?php
class Users extends BaseModel  {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return " SELECT tb_users . * , tb_groups.name, tb_departments.d_name, subdepartments.sub_dep_name, tb_role.role_id
FROM tb_users
LEFT JOIN tb_groups ON tb_groups.group_id = tb_users.group_id
LEFT JOIN tb_departments ON tb_departments.d_id = tb_users.department
LEFT JOIN subdepartments ON subdepartments.sub_dep_id = tb_users.department
LEFT JOIN tb_role ON tb_role.role_id = tb_users.user_role WHERE tb_users.group_id !=5 ";
	}
	public static function queryWhere(  ){
		
		//return "   WHERE tb_users.id !=''     ";
	}
	
	
	public static function queryGroup(){
		return "      ";
	}
	

}
