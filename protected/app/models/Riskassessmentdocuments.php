<?php
class Riskassessmentdocuments extends BaseModel  {
	
	protected $table = 'risk_assessment_document_upload';
	protected $primaryKey = 'risk_assessment_document_id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT risk_assessment_document_upload.* FROM risk_assessment_document_upload  ";
	}
	public static function queryWhere(  ){
		
		return " WHERE risk_assessment_document_upload.risk_assessment_document_id IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
