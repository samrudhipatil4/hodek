<?php

class newEnquiryController extends BaseController  
{
	public function selectEnq()
	{ 
            return View::make('enquiry/selectEnq');
	}
	public function getEnquiryDetails()
	{
		$data = DB::select(DB::raw('select enquiryId,enquiry_no from customer_enquiry_form'));
       	$select = "--Please Select--";
            echo '<option value="">';
            echo $select.'</option>';
            foreach($data as $d){
              echo '<option value="'.$d->enquiryId.'"';
              echo '>'.$d->enquiry_no.'</option>';
            }
    	exit();
	}
	public function viewEnq()
	{
		$input =Input::all();
	    $en = new Enquiry();
	    $enquiry = $input['enquiry'];
	    $enquiry_data= $en->getEnquiryData($enquiry);
	    $file_data= $en->getEnquiryFileData($enquiry);
	    return View::make('enquiry.viewEnq', array('enquiry_details' => $enquiry_data,'file_details' => $file_data));
	}
}