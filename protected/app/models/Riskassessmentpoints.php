<?php
class Riskassessmentpoints extends BaseModel  {
	
	protected $table = 'tb_risk_assessment_points_admin';
	protected $primaryKey = 'risk_assessment_id_admin';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT tb_risk_assessment_points_admin.* FROM tb_risk_assessment_points_admin  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE tb_risk_assessment_points_admin.risk_assessment_id_admin IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
