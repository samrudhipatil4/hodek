<?php

use Illuminate\Support\Facades\DB;

class enquiryController extends BaseController {

	public function index(){

        if(Auth::check()):
              return View::make('enquiry/form');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }    

	public function saveEnquiry(){
		error_reporting(E_ALL);
		$input=Input::all();
		//dd($input);
		//$projNo='';
		if($input['enquiry_date'] == ""){
			$enquiry_date=null;
		}else{
			$enquiry_date=date('Y-m-d', strtotime($input['enquiry_date']));
		}
		if($input['proto_date'] == ""){
			$proto_date=null;
		}else{
			$proto_date=date('Y-m-d', strtotime($input['proto_date']));
		}
		if($input['pilot_date'] == ""){
			$pilot_date=null;
		}else{
			$pilot_date=date('Y-m-d', strtotime($input['pilot_date']));
		}
		if($input['ppap_date'] == ""){
			$ppap_date=null;
		}else{
			$ppap_date=date('Y-m-d', strtotime($input['ppap_date']));
		}
		if($input['sop_date'] == ""){
			$sop_date=null;
		}else{
			$sop_date=date('Y-m-d', strtotime($input['sop_date']));
		}
		// $_SESSION['sessionEnquiryId']=''; //to clear session

		$enqiury_id=( isset($_SESSION['sessionEnquiryId']))? $_SESSION['sessionEnquiryId'] : '';
		
		if($input['customer']==""){
			$cust="";
		}else{
			$cust=$input['customer'];
		}
		if($enqiury_id == ''){


				// try{
					//echo "enqiury_id is blank";

					//DB::enableQueryLog();

					$data = DB::table('customer_enquiry_form')->insert(
					array(
                            'enquiry_no'  		=>  $input['enquiry_no'],
                            'enquiry_date' 		=>  $enquiry_date,
                            'cust_part_no'  	=>  $input['cust_part_no'],
                            'engine_details'  	=>  $input['engine_details'],
                            'engine_appl_details'=> $input['engine_appl_details'],
                            'cust_rev'          =>  $input['cust_rev'],
                            'cust_cont_person'  =>  $input['cust_cont_person'],
                            'cust_person_no'    =>  $input['cust_person_no'],
                            'cust_person_email' =>  $input['cust_person_email'],
                            'similar_product_mfg'=> $input['similar_product_mfg'],
                            'internal_cust'     =>  $input['internal_cust'],
                            'customer'			=>  $cust,
                            'estimated_cost'  	=>  $input['estimated_cost'],
                            'deadline' 		    =>  $input['deadline'],
                            'annual_volY1'  	=>  $input['annual_volY1'],
                            'annual_volY2'  	=>  $input['annual_volY2'],
                            'annual_volY3'      =>  $input['annual_volY3'],
                            'annual_volY4'      =>  $input['annual_volY4'],
                            'annual_volY5'      =>  $input['annual_volY5'],
                            'proto_sample'      =>  $input['proto_sample'],
														'proto_date'		=>  $proto_date,
                            'pilot_batch'       =>  $input['pilot_batch'],
														'pilot_date'		=>  $pilot_date,
                            'ppap_batch'        =>  $input['ppap_batch'],
														'ppap_date'			=>  $ppap_date,
                            'sop_date'          =>  $sop_date,
                            'packaging'         =>  $input['packaging'],
                            'labeling'          =>  $input['labeling'],
                            'painting'          =>  $input['painting'],
                            'any_other'         =>  $input['any_other'],
                            'engine_data'       =>  $input['engine_data'],
                            'specific_req'      =>  $input['specific_req'],
                            'sop_quantity'			=>  $input['sop_quantity']			)
													);
					// dd(DB::getQueryLog());

					$sessionEnquiryId=DB::getPdo()->lastInsertId();

					$_SESSION['SessionEnquiryNo'] = $input['enquiry_no'];
					$_SESSION['sessionEnquiryId'] = $sessionEnquiryId;
					
					// file start
					if (!empty($_FILES)) {
						$destinationPath = 'uploads/enqDocument'; // upload path

						if (Input::hasFile('annual_volume')) {
							$files = Input::file('annual_volume');

							foreach ($files as $file) {
								$extension = $file->getClientOriginalName();

								$filename = rand(11111,99999).'-'.$extension; // renameing image
								$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
								

								if(	$file->move($destinationPath, $filename1)){

									echo 'file uploaded Successfully!Insert';
									//query for insert
									$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$sessionEnquiryId, $filename1, 'Annual Volume']);
		

								}else{
								echo 'error in file upload';
								}
							}
						}
						if (Input::hasFile('pack')) {
							$files = Input::file('pack');

							foreach ($files as $file) {
								$extension = $file->getClientOriginalName();

								$filename = rand(11111,99999).'-'.$extension; // renameing image
								$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
								

								if(	$file->move($destinationPath, $filename1)){

									echo 'file uploaded Successfully!';
									//query for insert
									$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$sessionEnquiryId, $filename1, 'Packing']);
		

								}else{
								echo 'error in file upload';
								}
							}
						}
						if (Input::hasFile('label')) {
							$files = Input::file('label');
							foreach ($files as $file) {
								$extension = $file->getClientOriginalName();
								$filename = rand(11111,99999).'-'.$extension; // renameing image
								$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
								if(	$file->move($destinationPath, $filename1)){
									echo 'file uploaded Successfully !';
									//query for insert
									$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$sessionEnquiryId, $filename1, 'Labeling']);
								}else{
								echo 'error in file upload';
								}
							}
						}
						if (Input::hasFile('paint')) {
							$files = Input::file('paint');
							foreach ($files as $file) {
								$extension = $file->getClientOriginalName();
								$filename = rand(11111,99999).'-'.$extension; // renameing image
								$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
								if(	$file->move($destinationPath, $filename1)){
									echo 'file uploaded Successfully!';
									//query for insert
									$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$sessionEnquiryId, $filename1, 'Painting']);
								}else{
								echo 'error in file upload';
								}
							}
						}
						if (Input::hasFile('any')) {
							$files = Input::file('any');
							foreach ($files as $file) {
								$extension = $file->getClientOriginalName();
								$filename = rand(11111,99999).'-'.$extension; // renameing image
								$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
								if(	$file->move($destinationPath, $filename1)){
									echo 'file uploaded Successfully!';
									//query for insert
									$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$sessionEnquiryId, $filename1, 'Any Other']);
								}else{
								echo 'error in file upload';
								}
							}
						}
						if (Input::hasFile('engine')) {
							$files = Input::file('engine');
							foreach ($files as $file) {
								$extension = $file->getClientOriginalName();
								$filename = rand(11111,99999).'-'.$extension; // renameing image
								$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
								if(	$file->move($destinationPath, $filename1)){
									echo 'file uploaded Successfully!';
									//query for insert
									$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$sessionEnquiryId, $filename1, 'Engine Data Sheet']);
								}else{
								echo 'error in file upload';
								}
							}
						}
						if (Input::hasFile('specific')) {
							$files = Input::file('specific');
							foreach ($files as $file) {
								$extension = $file->getClientOriginalName();
								$filename = rand(11111,99999).'-'.$extension; // renameing image
								$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
								if(	$file->move($destinationPath, $filename1)){
									echo 'file uploaded Successfully!';
									//query for insert
									$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$sessionEnquiryId, $filename1, 'Specific Requirement']);
								}else{
								echo 'error in file upload';
								}
							}
						}
					}
				// end file			
				
		}elseif ($enqiury_id != '' ) {
				//echo $enqiury_id;
				$data = DB::table('customer_enquiry_form')
					->where('enquiryId',$enqiury_id)
					->update(
						array(
                            'enquiry_no'  			=>  $input['enquiry_no'],
                            'enquiry_date' 			=>  $enquiry_date,
                            'cust_part_no'  		=>  $input['cust_part_no'],
                            'engine_details'  	=>  $input['engine_details'],
                            'engine_appl_details'=> $input['engine_appl_details'],
                            'cust_rev'          =>  $input['cust_rev'],
                            'cust_cont_person'  =>  $input['cust_cont_person'],
                            'cust_person_no'    =>  $input['cust_person_no'],
                            'cust_person_email' =>  $input['cust_person_email'],
                            'similar_product_mfg'=> $input['similar_product_mfg'],
                            'internal_cust'     =>  $input['internal_cust'],
                            'customer'					=>  $cust,
                            'estimated_cost'  	=>  $input['estimated_cost'],
                            'deadline' 		    	=>  $input['deadline'],
                            'annual_volY1'  		=>  $input['annual_volY1'],
                            'annual_volY2'  		=>  $input['annual_volY2'],
                            'annual_volY3'      =>  $input['annual_volY3'],
                            'annual_volY4'      =>  $input['annual_volY4'],
                            'annual_volY5'      =>  $input['annual_volY5'],
                            'proto_sample'      =>  $input['proto_sample'],
														'proto_date'				=>  $proto_date,
                            'pilot_batch'       =>  $input['pilot_batch'],
														'pilot_date'				=>  $pilot_date,
                            'ppap_batch'        =>  $input['ppap_batch'],
														'ppap_date'					=>  $ppap_date,
                            'sop_date'          =>  $sop_date,
                            'packaging'         =>  $input['packaging'],
                            'labeling'          =>  $input['labeling'],
                            'painting'          =>  $input['painting'],
                            'any_other'         =>  $input['any_other'],
                            'engine_data'       =>  $input['engine_data'],
                            'specific_req'      =>  $input['specific_req'],
                            'sop_quantity'			=>  $input['sop_quantity']
							)
					);
					//echo $enqiury_id;
					if (!empty($_FILES)) {
						if(isset($enqiury_id)){
							$destinationPath = 'uploads/enqDocument'; // upload path
							if (Input::hasFile('annual_volume')) {

								// delete old files
								$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Annual Volume' AND enquiry_id=?",[$enqiury_id]);
								// dd($all_files);

								foreach($all_files as $file){
									$file_name=$file->file_name;
									$filename = $destinationPath.'/'.$file_name;
									// \File::delete($filename);
									unlink($filename);	
									//delete row from db
									$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
								}

								$files = Input::file('annual_volume');
								//dd($files);
								foreach ($files as $file) {
									$extension = $file->getClientOriginalName();
									$filename = rand(11111,99999).'-'.$extension; // renaming image
									$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
									if(	$file->move($destinationPath, $filename1)){
										echo 'file uploaded Successfully Update!';
										$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Annual Volume']);
										echo $enqiury_id;
									}else{
									echo 'error in file upload';
									}
								}
							}
							if (Input::hasFile('pack')) {

								// delete old files
								$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Packing' AND enquiry_id=?",[$enqiury_id]);
								// dd($all_files);

								foreach($all_files as $file){
									$file_name=$file->file_name;
									$filename = $destinationPath.'/'.$file_name;
									// \File::delete($filename);
									unlink($filename);	
									//delete row from db
									$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
								}

								$files = Input::file('pack');
								//dd($files);
								foreach ($files as $file) {
									$extension = $file->getClientOriginalName();
									$filename = rand(11111,99999).'-'.$extension; // renaming image
									$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
									if(	$file->move($destinationPath, $filename1)){
										echo 'file uploaded Successfully Update!';
										$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Packing']);
										echo $enqiury_id;
									}else{
									echo 'error in file upload';
									}
								}
							}
							if (Input::hasFile('label')) {

								// delete old files
								$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Labeling' AND enquiry_id=?",[$enqiury_id]);
								// dd($all_files);

								foreach($all_files as $file){
									$file_name=$file->file_name;
									$filename = $destinationPath.'/'.$file_name;
									// \File::delete($filename);
									unlink($filename);	
									//delete row from db
									$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
								}

								$files = Input::file('label');
								//dd($files);
								foreach ($files as $file) {
									$extension = $file->getClientOriginalName();
									$filename = rand(11111,99999).'-'.$extension; // renaming image
									$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
									if(	$file->move($destinationPath, $filename1)){
										echo 'file uploaded Successfully Update!';
										$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Labeling']);
										//echo $enqiury_id;
									}else{
									echo 'error in file upload';
									}
								}
							}
							if (Input::hasFile('paint')) {

								// delete old files
								$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Painting' AND enquiry_id=?",[$enqiury_id]);
								// dd($all_files);

								foreach($all_files as $file){
									$file_name=$file->file_name;
									$filename = $destinationPath.'/'.$file_name;
									// \File::delete($filename);
									unlink($filename);	
									//delete row from db
									$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
								}

								$files = Input::file('paint');
								//dd($files);
								foreach ($files as $file) {
									$extension = $file->getClientOriginalName();
									$filename = rand(11111,99999).'-'.$extension; // renaming image
									$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
									if(	$file->move($destinationPath, $filename1)){
										echo 'file uploaded Successfully Update!';
										$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Painting']);
										echo $enqiury_id;
									}else{
									echo 'error in file upload';
									}
								}
							}
							if (Input::hasFile('any')) {

								// delete old files
								$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Any Other' AND enquiry_id=?",[$enqiury_id]);
								// dd($all_files);

								foreach($all_files as $file){
									$file_name=$file->file_name;
									$filename = $destinationPath.'/'.$file_name;
									// \File::delete($filename);
									unlink($filename);	
									//delete row from db
									$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
								}

								$files = Input::file('any');
								//dd($files);
								foreach ($files as $file) {
									$extension = $file->getClientOriginalName();
									$filename = rand(11111,99999).'-'.$extension; // renaming image
									$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
									if(	$file->move($destinationPath, $filename1)){
										echo 'file uploaded Successfully Update!';
										$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Any Other']);
										echo $enqiury_id;
									}else{
									echo 'error in file upload';
									}
								}
							}
							if (Input::hasFile('engine')) {

								// delete old files
								$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Engine Data Sheet' AND enquiry_id=?",[$enqiury_id]);
								// dd($all_files);

								foreach($all_files as $file){
									$file_name=$file->file_name;
									$filename = $destinationPath.'/'.$file_name;
									// \File::delete($filename);
									unlink($filename);	
									//delete row from db
									$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
								}

								$files = Input::file('engine');
								//dd($files);
								foreach ($files as $file) {
									$extension = $file->getClientOriginalName();
									$filename = rand(11111,99999).'-'.$extension; // renaming image
									$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
									if(	$file->move($destinationPath, $filename1)){
										echo 'file uploaded Successfully Update!';
										$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Engine Data Sheet']);
										echo $enqiury_id;
									}else{
									echo 'error in file upload';
									}
								}
							}
							if (Input::hasFile('specific')) {

								// delete old files
								$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Specific Requirement' AND enquiry_id=?",[$enqiury_id]);
								// dd($all_files);

								foreach($all_files as $file){
									$file_name=$file->file_name;
									$filename = $destinationPath.'/'.$file_name;
									// \File::delete($filename);
									unlink($filename);
									//delete row from db
									$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
								}

								$files = Input::file('specific');
								//dd($files);
								foreach ($files as $file) {
									$extension = $file->getClientOriginalName();
									$filename = rand(11111,99999).'-'.$extension; // renaming image
									$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
									if(	$file->move($destinationPath, $filename1)){
										echo 'file uploaded Successfully Update!';
										$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Specific Requirement']);
										echo $enqiury_id;
									}else{
									echo 'error in file upload';
									}
								}
							}
						}
						
					}				
					echo 'not null';exit();		
		}else{
				echo 'last else';exit();
		}
		exit();			
	}

	public function SaveVoice()
	{
		$input=Input::all();
		// $enqiury_id=$_SESSION['sessionEnquiryId'];
		$enqiury_id=( isset($_SESSION['sessionEnquiryId']))? $_SESSION['sessionEnquiryId'] : '';
		// dd($_SESSION['sessionEnquiryId']);
		if($enqiury_id != '')
		$data = DB::table('customer_enquiry_form')
			->where('enquiryId',$enqiury_id)
			->update(
				array(
					'cust_interview'  	=>  $input['cust_interview'],
					'name_interview' 	=>  $input['name_interview'],
					'name_interviewer'  =>  $input['name_interviewer'],
					'input_data'  	    =>  $input['input_data'],
					'competitors'       =>  $input['competitors'],
					'product_name'      =>  $input['product_name'],
					'product_quality'   =>  $input['product_quality'],
					'tgr_report'        =>  $input['tgr_report'],
					'tgw_product_name'  =>  $input['tgw_product_name'],
					'discrepancy'       =>  $input['discrepancy'],
					'cause_discrepancy' =>  $input['cause_discrepancy'],
					'return_reject'  	=>  $input['return_reject'],
					'field_return' 	    =>  $input['field_return']  
					)
			);
	}

	public function TeamExperience()
	{
		$input=Input::all();
		$enqiury_id=( isset($_SESSION['sessionEnquiryId']))? $_SESSION['sessionEnquiryId'] : '';
		// $enqiury_id=$_SESSION['sessionEnquiryId'];
		// dd($_SESSION['sessionEnquiryId']);
		if($enqiury_id != '')
		$data = DB::table('customer_enquiry_form')
			->where('enquiryId',$enqiury_id)
			->update(
				array(
					'cust_suggestions'  =>  $input['cust_suggestions'],
					'service_report' 	=>  $input['service_report'],
					'transportation'    =>  $input['transportation'],
					'requirement_regulation'=>  $input['requirement_regulation'],
					'internal_custo'      =>  $input['internal_custo'],
					'tgr_tgw'      =>  $input['tgr_tgw']
					
					)
			);
	}

	public function CustBussiness()
	{
		$input=Input::all();
		$enqiury_id=( isset($_SESSION['sessionEnquiryId']))? $_SESSION['sessionEnquiryId'] : '';
		// $enqiury_id=$_SESSION['sessionEnquiryId'];
		//dd($_SESSION['sessionEnquiryId']);
		if($enqiury_id != '')
		$data = DB::table('customer_enquiry_form')
			->where('enquiryId',$enqiury_id)
			->update(
				array(
					'time_constriants'  =>  $input['time_constriants'],
					'cost_constraint'    =>  $input['cost_constraint'],
					'investment'         =>  $input['investment'],
					'key_competitor'     =>  $input['key_competitor']					
					)
			);
	}

	public function ProductBenchmark()
	{
		$input=Input::all();
		$enqiury_id=( isset($_SESSION['sessionEnquiryId']))? $_SESSION['sessionEnquiryId'] : '';
		// $enqiury_id=$_SESSION['sessionEnquiryId'];
		//dd($_SESSION['sessionEnquiryId']);
		$data='';
		if($enqiury_id != '')
		$data = DB::table('customer_enquiry_form')
			->where('enquiryId',$enqiury_id)
			->update(
				array(
					'performance'   =>  $input['performance'],
					'cost'   		=>  $input['cost'],
					'n_techno'      =>  $input['n_techno'],
					'new_resources' =>  $input['new_resources']				
					)
			);
			return $data;
	}

	public function RiskManagement()
	{
		$input=Input::all();
		$enqiury_id=( isset($_SESSION['sessionEnquiryId']))? $_SESSION['sessionEnquiryId'] : '';
		// $enqiury_id=$_SESSION['sessionEnquiryId'];
		//$_SESSION['sessionEnquiryId']=''; //unset session
		$data='';
		if($enqiury_id != '')
		$data = DB::table('customer_enquiry_form')
			->where('enquiryId',$enqiury_id)
			->update(
				array(
					'risk_mgmt'  =>  $input['risk_mgmt']
					)
			);
			if (!empty($_FILES)) {
				if(isset($enqiury_id)){
					$destinationPath = 'uploads/enqDocument'; // upload path
					if (Input::hasFile('risk')) {

						// delete old files
						$all_files = DB::select("SELECT * FROM enquiry_document  WHERE type='Risk Management' AND enquiry_id=?",[$enqiury_id]);

						foreach($all_files as $file){
							$file_name=$file->file_name;
							$filename = $destinationPath.'/'.$file_name;
							// \File::delete($filename);
							unlink($filename);	
							//delete row from db
							$delete_file = DB::DELETE("DELETE FROM enquiry_document WHERE file_name=?",[$file_name]);
						}

						$files = Input::file('risk');
						foreach ($files as $file) {
							$extension = $file->getClientOriginalName();
							$filename = rand(11111,99999).'-'.$extension; // renaming image
							$filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
							if(	$file->move($destinationPath, $filename1)){
								echo 'file uploaded Successfully Update!';
								$store_file=DB::insert('INSERT INTO enquiry_document (enquiry_id,file_name,type) VALUES(?,?,?)',[$enqiury_id, $filename1, 'Risk Management']);
								//echo $enqiury_id;
							}else{
							echo 'error in file upload of file risk';
							}
						}
					}
				}
			}
			$_SESSION['sessionEnquiryId']=''; //unset session
			return $data;
	}
	
	public function getCust(){
		$data = DB::table('customer') 
		        ->select('CustomerId','FirstName')
		        ->where('status','active')
		        ->get();
		        $select = "--Please Select--";
		        echo '<option value="">';
		        echo $select.'</option>';
		        foreach($data as $d){
		        	echo '<option value="'.$d->CustomerId.'">';
		        	echo $d->FirstName.'</option>';
		        }
		        exit();
	}

	public function changeFlag(){
		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
			
			$proj_id=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
		
			$proj_id=$_SESSION['searchPro'];
		}else{
		
			$proj_id='';
		}
		$data =DB::table('customer_enquiry_form')
				->where('enquiryId',$proj_id)
				->update(
						 array(
								 'flag'  => 1,
						  )
					);
				exit();
}

			
}