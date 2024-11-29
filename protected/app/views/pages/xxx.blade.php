<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}
	public function gnattChart(){
		$project_id = 1;
		$chart = new Chart();

		/* ------- Start Project Details -------*/
		$data['project_details'] = $project_details = $chart->getProjectById($project_id);
		$project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
		$project_details->date = date('d F y',strtotime($project_start_date));
		/* ------- End Project Details -------*/

		/* ----- Start Date column Create ------ */
		$project_end_date_details = $chart->getProjectEndDate($project_id);
		$project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);


		$row_date = strtotime($project_end_date_details->activity_end_date);
		$today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
		$project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
		if($row_date >= $today){
		    $project_end_date_check = $project_end_date_details->activity_end_date;
		}



		$project_end_date = date('Y-m-d',strtotime($project_end_date_check));
		
		$date1 = new DateTime($project_start_date);
		$date2 = new DateTime($project_end_date);

		$diff = $date2->diff($date1)->format("%a")+1;
		$project_all_dates = array();
		$start_date = $project_start_date;
		for($i = 0;$i< $diff;$i++){
			$project_all_dates[$i] = date('d F y',strtotime($start_date));
			$start_date = date('Y-m-d',strtotime($start_date . "+1 days"));			
		}
		//echo '<pre>';
		$data['activities'] =  $chart->getAllActivity($project_id);
		$data['project_all_dates'] = $project_all_dates;
		$plan = array();
		$actual = array();
		//print_r($project_all_dates);exit;
		$project_activity = array();
		foreach($data['activities'] as $row){

			$row->plan_start_date = date('d F y',strtotime($row->activity_start_date));
			$row->plan_end_date = date('d F y',strtotime($row->activity_end_date));

			$plan_date1 = new DateTime($row->activity_start_date);
			$plan_date2 = new DateTime($row->activity_end_date);
			
			$plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
			$plan_arr = array();
			$plan_start_date = $row->activity_start_date;
			for($i = 0;$i<$plan_diff;$i++){
				$plan_arr[$i] = date('d F y',strtotime($plan_start_date));
				$plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));	
			}
			$row->plan = $plan_arr;


			$actuall_arr = array();

			$row->actual_start_date = '';
			$row->actual_end_date = '';


			$AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
			$row->actual_duaration = '';
			if(count($AtualActivityDetails) > 0){
				//echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
				$row->actual_start_date = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
				$row->actual_end_date = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
				$actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
				$actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
				
				$actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
				
				$row->actual_duaration = $actual_diff;
				
				$actual_start_date = $AtualActivityDetails->actual_start_date;

				for($k = 0;$k<$actual_diff;$k++){
					$actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
					$actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));	
				}
				
			}
			$row->actual = $actuall_arr;


			/*--- Plan Actual ----*/

			for($i = 0;$i<count($project_all_dates);$i++){
					$project_activity[$i]['plan'] = 0;
					$project_activity[$i]['actual'] = 0;
					for($j=0;$j<count($plan_arr);$j++){
						if($project_all_dates[$i] == $plan_arr[$j]){
							$project_activity[$i]['plan'] = 1;
							//break;
						}
					}

					for($l=0;$l<count($actuall_arr);$l++){
						if($project_all_dates[$i] == $actuall_arr[$l]){
							$project_activity[$i]['actual'] = 1;
							//break;
						}
					}


			
			}
			$row->activity_row = $project_activity;

		}
		//exit;
		//$data = array();
		//print_r($data['activities']);exit;
		return View::make('pages.projectActivity',$data);
		//
		//print_r($activities);exit;
	}


	function excelDownload(){
		$project_id = 1;
		$chart = new Chart();

		/* ------- Start Project Details -------*/
		$data['project_details'] = $project_details = $chart->getProjectById($project_id);
		$project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
		$project_details->date = date('d F y',strtotime($project_start_date));
		/* ------- End Project Details -------*/

		/* ----- Start Date column Create ------ */
		$project_end_date_details = $chart->getProjectEndDate($project_id);
		$project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);


		$row_date = strtotime($project_end_date_details->activity_end_date);
		$today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
		$project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
		if($row_date >= $today){
		    $project_end_date_check = $project_end_date_details->activity_end_date;
		}



		$project_end_date = date('Y-m-d',strtotime($project_end_date_check));
		
		$date1 = new DateTime($project_start_date);
		$date2 = new DateTime($project_end_date);

		$diff = $date2->diff($date1)->format("%a")+1;
		$project_all_dates = array();
		$start_date = $project_start_date;
		for($i = 0;$i< $diff;$i++){
			$project_all_dates[$i] = date('d F y',strtotime($start_date));
			$start_date = date('Y-m-d',strtotime($start_date . "+1 days"));			
		}
		//echo '<pre>';
		$data['activities'] =  $chart->getAllActivity($project_id);
		$data['project_all_dates'] = $project_all_dates;
		$plan = array();
		$actual = array();
		//print_r($project_all_dates);exit;
		$project_activity = array();
		foreach($data['activities'] as $row){

			$row->plan_start_date = date('d F y',strtotime($row->activity_start_date));
			$row->plan_end_date = date('d F y',strtotime($row->activity_end_date));

			$plan_date1 = new DateTime($row->activity_start_date);
			$plan_date2 = new DateTime($row->activity_end_date);
			
			$plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
			$plan_arr = array();
			$plan_start_date = $row->activity_start_date;
			for($i = 0;$i<$plan_diff;$i++){
				$plan_arr[$i] = date('d F y',strtotime($plan_start_date));
				$plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));	
			}
			$row->plan = $plan_arr;


			$actuall_arr = array();

			$row->actual_start_date = '';
			$row->actual_end_date = '';


			$AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
			$row->actual_duaration = '';
			if(count($AtualActivityDetails) > 0){
				//echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
				$row->actual_start_date = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
				$row->actual_end_date = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
				$actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
				$actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
				
				$actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
				
				$row->actual_duaration = $actual_diff;
				
				$actual_start_date = $AtualActivityDetails->actual_start_date;

				for($k = 0;$k<$actual_diff;$k++){
					$actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
					$actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));	
				}
				
			}
			$row->actual = $actuall_arr;


			/*--- Plan Actual ----*/

			for($i = 0;$i<count($project_all_dates);$i++){
					$project_activity[$i]['plan'] = 0;
					$project_activity[$i]['actual'] = 0;
					for($j=0;$j<count($plan_arr);$j++){
						if($project_all_dates[$i] == $plan_arr[$j]){
							$project_activity[$i]['plan'] = 1;
							//break;
						}
					}

					for($l=0;$l<count($actuall_arr);$l++){
						if($project_all_dates[$i] == $actuall_arr[$l]){
							$project_activity[$i]['actual'] = 1;
							//break;
						}
					}


			
			}
			$row->activity_row = $project_activity;

		}
		$x = View::make('pages.projectActivityPrint',$data);	
		//print_r($data);exit;


		Excel::create('New file', function($excel) {

   		 $excel->sheet('New sheet', function($sheet) {

        		$sheet->loadView('view.template');

    });

})->export('xls');


		/*$output =  View::make('pages.projectActivityPrint',compact('alldata','project_id'),$data);
		$filename = 'gnat_chart';
		$headers = array(
		         'Pragma' => 'public',
		         'Expires' => 'public',
		         'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
		         'Cache-Control' => 'private',
		         'Content-Type' => 'application/vnd.ms-excel; name="excel"',
		         'Content-Disposition' => 'attachment; filename='.$filename.'.xls',
		         'Content-Transfer-Encoding' => 'binary'                );
		         return Response::make($output, 200, $headers);*/
	}

	public function getPdftest($project_id)
	{
		$myProjectDirectory = '/var/www/html/laravel_new';
		$snappy = new Pdf($myProjectDirectory . '/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="gnatt_cahrt.pdf"');
		echo $snappy->getOutput('http://localhost/laravel_new/public/pdf-download/'.$project_id);
		
	}

	function gnattChartPdf($project_id){
		$project_id = 1;
		$chart = new Chart();

		/* ------- Start Project Details -------*/
		$data['project_details'] = $project_details = $chart->getProjectById($project_id);
		$project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
		$project_details->date = date('d F y',strtotime($project_start_date));
		/* ------- End Project Details -------*/

		/* ----- Start Date column Create ------ */
		$project_end_date_details = $chart->getProjectEndDate($project_id);
		$project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);


		$row_date = strtotime($project_end_date_details->activity_end_date);
		$today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
		$project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
		if($row_date >= $today){
		    $project_end_date_check = $project_end_date_details->activity_end_date;
		}



		$project_end_date = date('Y-m-d',strtotime($project_end_date_check));
		
		$date1 = new DateTime($project_start_date);
		$date2 = new DateTime($project_end_date);

		$diff = $date2->diff($date1)->format("%a")+1;
		$project_all_dates = array();
		$start_date = $project_start_date;
		for($i = 0;$i< $diff;$i++){
			$project_all_dates[$i] = date('d F y',strtotime($start_date));
			$start_date = date('Y-m-d',strtotime($start_date . "+1 days"));			
		}
		//echo '<pre>';
		$data['activities'] =  $chart->getAllActivity($project_id);
		$data['project_all_dates'] = $project_all_dates;
		$plan = array();
		$actual = array();
		//print_r($project_all_dates);exit;
		$project_activity = array();
		foreach($data['activities'] as $row){

			$row->plan_start_date = date('d F y',strtotime($row->activity_start_date));
			$row->plan_end_date = date('d F y',strtotime($row->activity_end_date));

			$plan_date1 = new DateTime($row->activity_start_date);
			$plan_date2 = new DateTime($row->activity_end_date);
			
			$plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
			$plan_arr = array();
			$plan_start_date = $row->activity_start_date;
			for($i = 0;$i<$plan_diff;$i++){
				$plan_arr[$i] = date('d F y',strtotime($plan_start_date));
				$plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));	
			}
			$row->plan = $plan_arr;


			$actuall_arr = array();

			$row->actual_start_date = '';
			$row->actual_end_date = '';


			$AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
			$row->actual_duaration = '';
			if(count($AtualActivityDetails) > 0){
				//echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
				$row->actual_start_date = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
				$row->actual_end_date = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
				$actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
				$actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
				
				$actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
				
				$row->actual_duaration = $actual_diff;
				
				$actual_start_date = $AtualActivityDetails->actual_start_date;

				for($k = 0;$k<$actual_diff;$k++){
					$actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
					$actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));	
				}
				
			}
			$row->actual = $actuall_arr;


			/*--- Plan Actual ----*/

			for($i = 0;$i<count($project_all_dates);$i++){
					$project_activity[$i]['plan'] = 0;
					$project_activity[$i]['actual'] = 0;
					for($j=0;$j<count($plan_arr);$j++){
						if($project_all_dates[$i] == $plan_arr[$j]){
							$project_activity[$i]['plan'] = 1;
							//break;
						}
					}

					for($l=0;$l<count($actuall_arr);$l++){
						if($project_all_dates[$i] == $actuall_arr[$l]){
							$project_activity[$i]['actual'] = 1;
							//break;
						}
					}


			
			}
			$row->activity_row = $project_activity;

		}
		return View::make('pages.projectActivityPdf',$data);		
	}


function gnattChartPrint($project_id){
		$project_id = 1;
		$chart = new Chart();

		/* ------- Start Project Details -------*/
		$data['project_details'] = $project_details = $chart->getProjectById($project_id);
		$project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
		$project_details->date = date('d F y',strtotime($project_start_date));
		/* ------- End Project Details -------*/

		/* ----- Start Date column Create ------ */
		$project_end_date_details = $chart->getProjectEndDate($project_id);
		$project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);


		$row_date = strtotime($project_end_date_details->activity_end_date);
		$today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
		$project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
		if($row_date >= $today){
		    $project_end_date_check = $project_end_date_details->activity_end_date;
		}



		$project_end_date = date('Y-m-d',strtotime($project_end_date_check));
		
		$date1 = new DateTime($project_start_date);
		$date2 = new DateTime($project_end_date);

		$diff = $date2->diff($date1)->format("%a")+1;
		$project_all_dates = array();
		$start_date = $project_start_date;
		for($i = 0;$i< $diff;$i++){
			$project_all_dates[$i] = date('d F y',strtotime($start_date));
			$start_date = date('Y-m-d',strtotime($start_date . "+1 days"));			
		}
		//echo '<pre>';
		$data['activities'] =  $chart->getAllActivity($project_id);
		$data['project_all_dates'] = $project_all_dates;
		$plan = array();
		$actual = array();
		//print_r($project_all_dates);exit;
		$project_activity = array();
		foreach($data['activities'] as $row){

			$row->plan_start_date = date('d F y',strtotime($row->activity_start_date));
			$row->plan_end_date = date('d F y',strtotime($row->activity_end_date));

			$plan_date1 = new DateTime($row->activity_start_date);
			$plan_date2 = new DateTime($row->activity_end_date);
			
			$plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
			$plan_arr = array();
			$plan_start_date = $row->activity_start_date;
			for($i = 0;$i<$plan_diff;$i++){
				$plan_arr[$i] = date('d F y',strtotime($plan_start_date));
				$plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));	
			}
			$row->plan = $plan_arr;


			$actuall_arr = array();

			$row->actual_start_date = '';
			$row->actual_end_date = '';


			$AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
			$row->actual_duaration = '';
			if(count($AtualActivityDetails) > 0){
				//echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
				$row->actual_start_date = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
				$row->actual_end_date = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
				$actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
				$actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
				
				$actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
				
				$row->actual_duaration = $actual_diff;
				
				$actual_start_date = $AtualActivityDetails->actual_start_date;

				for($k = 0;$k<$actual_diff;$k++){
					$actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
					$actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));	
				}
				
			}
			$row->actual = $actuall_arr;


			/*--- Plan Actual ----*/

			for($i = 0;$i<count($project_all_dates);$i++){
					$project_activity[$i]['plan'] = 0;
					$project_activity[$i]['actual'] = 0;
					for($j=0;$j<count($plan_arr);$j++){
						if($project_all_dates[$i] == $plan_arr[$j]){
							$project_activity[$i]['plan'] = 1;
							//break;
						}
					}

					for($l=0;$l<count($actuall_arr);$l++){
						if($project_all_dates[$i] == $actuall_arr[$l]){
							$project_activity[$i]['actual'] = 1;
							//break;
						}
					}


			
			}
			$row->activity_row = $project_activity;

		}
		return View::make('pages.projectActivityPrint',$data);		
	}


	function excelProjectActivityDetails($project_id){
		$project_id = 1;
		$chart = new Chart();

		/* ------- Start Project Details -------*/
		$data['project_details'] = $project_details = $chart->getProjectById($project_id);
		$project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
		$project_details->date = date('d F y',strtotime($project_start_date));
		/* ------- End Project Details -------*/

		/* ----- Start Date column Create ------ */
		$project_end_date_details = $chart->getProjectEndDate($project_id);
		$project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);


		$row_date = strtotime($project_end_date_details->activity_end_date);
		$today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
		$project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
		if($row_date >= $today){
		    $project_end_date_check = $project_end_date_details->activity_end_date;
		}



		$project_end_date = date('Y-m-d',strtotime($project_end_date_check));
		
		$date1 = new DateTime($project_start_date);
		$date2 = new DateTime($project_end_date);

		$diff = $date2->diff($date1)->format("%a")+1;
		$project_all_dates = array();
		$start_date = $project_start_date;
		for($i = 0;$i< $diff;$i++){
			$project_all_dates[$i] = date('d F y',strtotime($start_date));
			$start_date = date('Y-m-d',strtotime($start_date . "+1 days"));			
		}
		//echo '<pre>';
		$data['activities'] =  $chart->getAllActivity($project_id);
		$data['project_all_dates'] = $project_all_dates;
		
		$main_array = array();
		$cnt = 0;
		foreach($data['activities'] as $key=>$row){
			$row->start_date = date('d F y',strtotime($row->activity_start_date));
			$row->end_date = date('d F y',strtotime($row->activity_end_date));

		}
		/*$project_activity = array();
		foreach($data['activities'] as $row){

			$row->plan_start_date = date('d F y',strtotime($row->activity_start_date));
			$row->plan_end_date = date('d F y',strtotime($row->activity_end_date));

			$plan_date1 = new DateTime($row->activity_start_date);
			$plan_date2 = new DateTime($row->activity_end_date);
			
			$plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
			$plan_arr = array();
			$plan_start_date = $row->activity_start_date;
			for($i = 0;$i<$plan_diff;$i++){
				$plan_arr[$i] = date('d F y',strtotime($plan_start_date));
				$plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));	
			}
			$row->plan = $plan_arr;


			$actuall_arr = array();

			$row->actual_start_date = '';
			$row->actual_end_date = '';


			$AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
			$row->actual_duaration = '';
			if(count($AtualActivityDetails) > 0){
				//echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
				$row->actual_start_date = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
				$row->actual_end_date = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
				$actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
				$actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
				
				$actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
				
				$row->actual_duaration = $actual_diff;
				
				$actual_start_date = $AtualActivityDetails->actual_start_date;

				for($k = 0;$k<$actual_diff;$k++){
					$actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
					$actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));	
				}
				
			}
			$row->actual = $actuall_arr;


			

			for($i = 0;$i<count($project_all_dates);$i++){
					$project_activity[$i]['plan'] = 0;
					$project_activity[$i]['actual'] = 0;
					for($j=0;$j<count($plan_arr);$j++){
						if($project_all_dates[$i] == $plan_arr[$j]){
							$project_activity[$i]['plan'] = 1;
							//break;
						}
					}

					for($l=0;$l<count($actuall_arr);$l++){
						if($project_all_dates[$i] == $actuall_arr[$l]){
							$project_activity[$i]['actual'] = 1;
							//break;
						}
					}


			
			}
			$row->activity_row = $project_activity;

		}*/
		//exit;
		//exit;
		//$data = array();
		//print_r($data['activities']);exit;
		//print_r($data);exit;
		print_r($data);exit;
		return $data;
		//
		//print_r($activities);exit;
	}

	function projectActivityDetails($project_id){
		//$project_id = 1;
		$project_id = 1;
		$chart = new Chart();

		/* ------- Start Project Details -------*/
		$data['project_details'] = $project_details = $chart->getProjectById($project_id);
		$project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
		$project_details->date = date('d F y',strtotime($project_start_date));
		/* ------- End Project Details -------*/

		/* ----- Start Date column Create ------ */
		$project_end_date_details = $chart->getProjectEndDate($project_id);
		$project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);


		$row_date = strtotime($project_end_date_details->activity_end_date);
		$today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
		$project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
		if($row_date >= $today){
		    $project_end_date_check = $project_end_date_details->activity_end_date;
		}



		$project_end_date = date('Y-m-d',strtotime($project_end_date_check));
		
		$date1 = new DateTime($project_start_date);
		$date2 = new DateTime($project_end_date);

		$diff = $date2->diff($date1)->format("%a")+1;
		$project_all_dates = array();
		$start_date = $project_start_date;
		for($i = 0;$i< $diff;$i++){
			$project_all_dates[$i] = date('d F y',strtotime($start_date));
			$start_date = date('Y-m-d',strtotime($start_date . "+1 days"));			
		}
		//echo '<pre>';
		$data['activities'] =  $chart->getAllActivity($project_id);
		$data['project_all_dates'] = $project_all_dates;
		$plan = array();
		$actual = array();
		//print_r($project_all_dates);exit;
		$project_activity = array();
		foreach($data['activities'] as $row){

			$row->plan_start_date = date('d F y',strtotime($row->activity_start_date));
			$row->plan_end_date = date('d F y',strtotime($row->activity_end_date));

			$plan_date1 = new DateTime($row->activity_start_date);
			$plan_date2 = new DateTime($row->activity_end_date);
			
			$plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
			$plan_arr = array();
			$plan_start_date = $row->activity_start_date;
			for($i = 0;$i<$plan_diff;$i++){
				$plan_arr[$i] = date('d F y',strtotime($plan_start_date));
				$plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));	
			}
			$row->plan = $plan_arr;


			$actuall_arr = array();

			$row->actual_start_date = '';
			$row->actual_end_date = '';


			$AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
			$row->actual_duaration = '';
			if(count($AtualActivityDetails) > 0){
				//echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
				$row->actual_start_date = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
				$row->actual_end_date = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
				$actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
				$actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
				
				$actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
				
				$row->actual_duaration = $actual_diff;
				
				$actual_start_date = $AtualActivityDetails->actual_start_date;

				for($k = 0;$k<$actual_diff;$k++){
					$actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
					$actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));	
				}
				
			}
			$row->actual = $actuall_arr;


			/*--- Plan Actual ----*/

			for($i = 0;$i<count($project_all_dates);$i++){
					$project_activity[$i]['plan'] = 0;
					$project_activity[$i]['actual'] = 0;
					for($j=0;$j<count($plan_arr);$j++){
						if($project_all_dates[$i] == $plan_arr[$j]){
							$project_activity[$i]['plan'] = 1;
							//break;
						}
					}

					for($l=0;$l<count($actuall_arr);$l++){
						if($project_all_dates[$i] == $actuall_arr[$l]){
							$project_activity[$i]['actual'] = 1;
							//break;
						}
					}


			
			}
			$row->activity_row = $project_activity;

		}
		//exit;
		//exit;
		//$data = array();
		//print_r($data['activities']);exit;
		//print_r($data);exit;
		return $data;
		//
		//print_r($activities);exit;
	}

}
