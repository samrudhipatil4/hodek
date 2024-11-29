<?php
class Enquiry extends BaseModel  {
	
	protected $table = 'customer_enquiry_form';
	protected $primaryKey = 'enquiryId';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		
		return "  SELECT customer_enquiry_form.* FROM customer_enquiry_form";
	}
	public static function queryWhere(  ){
		
		return " WHERE customer_enquiry_form.enquiryId IS NOT NULL   ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	// public function getEnquiryData($enquiry){
	// 	$data = DB::table('customer_enquiry_form')
 //             ->leftJoin('customer','customer.CustomerId','=','customer_enquiry_form.customer')
 //            ->select('customer_enquiry_form.*','customer.FirstName')
 //            ->where('customer_enquiry_form.enquiryId',$enquiry)
 //            ->get();
 //    	return $data;
	// }
	// public function getEnquiryFile($enquiry){
 //    $data = DB::table('enquiry_document')
 //    ->select('file_name','type')
 //    ->where('enquiry_id',$enquiry)
 //    ->get();
 //    // dd($data);
 //    return $data;
 //  }
	public function getEnquiryData($enquiry){
		$data = DB::table('customer_enquiry_form')
             ->leftJoin('customer','customer.CustomerId','=','customer_enquiry_form.customer')
            ->select('customer_enquiry_form.*','customer.FirstName')
            ->where('customer_enquiry_form.enquiryId',$enquiry)
            ->groupBy('customer_enquiry_form.enquiryId')
            ->get();
    	return $data;
	}

	public function getEnquiryFileData($enquiry){
		

        $data = DB::table('enquiry_document')
            ->select('enquiry_document.*')
            ->where('enquiry_document.enquiry_id',$enquiry)
            ->get();
            // dd(DB::getQueryLog());
    	return $data;
	}

}
