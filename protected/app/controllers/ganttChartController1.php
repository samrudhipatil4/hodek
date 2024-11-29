<?php
ini_set('max_execution_time', 300);
use Carbon\Carbon;
class ganttChartController extends BaseController  {

			
	public function index()
	{
        //if($this->check_permission(3)) {

       // if ($this->check_permission(5)) {
            return View::make('ganttChart/ganttChart');
       // } else {

        //    return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
       // }
	}

  public function getProjectDate(){
    $input = Input::all();
    
     $data=DB::table('apqp_draft_project_plan')
          ->select('activity_end_date')
          ->where('project_id',$input['id'])
          ->orderBy('activity_end_date')
          ->get();

        foreach ($data as $key) {
          $date_arr[]=$key->activity_end_date;
        }
        for ($i = 0; $i < count($date_arr); $i++)
        {
          if ($i == 0)
          {
              $max_date = date('Y-m-d H:i:s', strtotime($date_arr[$i]));
              
          }
          else if ($i != 0)
          {
              $new_date = date('Y-m-d H:i:s', strtotime($date_arr[$i]));
              if ($new_date > $max_date)
              {
                  $max_date = $new_date;
              }
              
          }
        }
        echo $max_date;exit();
  }
 public function getProject(){
    
    $data=DB::table('apqp_draft_project_plan')
          ->select('apqp_draft_project_plan.*')
          ->where('release_project',1)
          ->groupBy('project_id')
          ->get();
          if(!empty($data)){
          return $data;
        }
  }
 public function gnattChart(){
  $input=Input::all();
  
    $project_id = $input['proj_no'];
    $chart = new Chart();

    /* ------- Start Project Details -------*/
    $data['project_details'] = $project_details = $chart->getProjectById($project_id);
    $project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
    $project_details->date = date('d F y',strtotime($project_start_date));
    /* ------- End Project Details -------*/

    /* ----- Start Date column Create ------ */
    $project_end_date_details = $chart->getProjectEndDate($project_id);
    $project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);

    $today='';
    $row_date = strtotime($project_end_date_details->activity_end_date);
    if(!empty($project_actual_end_date_details)){
    $today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
  }
  if(!empty($project_actual_end_date_details)){
    $project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
  }

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
   
    $data['activities'] =  $chart->getAllActivity($project_id);
    $data['project_all_dates'] = $project_all_dates;
    $plan = array();
    $actual = array();
  
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
   
    return View::make('pages.projectActivity',$data);
   
  }

  function excelDownload($project_id){
    
    Excel::create('GnattChart', function($excel) use($project_id){
      //echo $project_id;exit;
        $excel->sheet('Excel sheet', function($sheet) use($project_id) {
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

    
    $today = '';
    if( count($project_actual_end_date_details) > 0 ){
        $project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
        $today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
    }

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
      
      $project_activity = array();
      $main_activity_didetails = array();
      $cnt = 0;
      foreach($data['activities'] as $row){

       $main_activity_didetails[$cnt]['id'] =  $row->id;
       $main_activity_didetails[$cnt]['project_id'] =  $row->project_id;
       $main_activity_didetails[$cnt]['gate_id'] =  $row->gate_id;
       $main_activity_didetails[$cnt]['plan_start_date'] = date('d F y',strtotime($row->activity_start_date));
       $main_activity_didetails[$cnt]['plan_end_date'] = date('d F y',strtotime($row->activity_end_date));
       $main_activity_didetails[$cnt]['activity'] =  $row->activity;
       $main_activity_didetails[$cnt]['Gate_Description'] =  $row->Gate_Description;
       $main_activity_didetails[$cnt]['activityName'] =  $row->activityName;
       $main_activity_didetails[$cnt]['department_name'] =  $row->department_name;
       $main_activity_didetails[$cnt]['department'] =  $row->department;
       $main_activity_didetails[$cnt]['lead_time'] =  $row->lead_time;
       $main_activity_didetails[$cnt]['type'] =  0;


        $plan_date1 = new DateTime($row->activity_start_date);
        $plan_date2 = new DateTime($row->activity_end_date);
        
        $plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
        $plan_arr = array();
        $plan_start_date = $row->activity_start_date;
        for($i = 0;$i<$plan_diff;$i++){
          $plan_arr[$i] = date('d F y',strtotime($plan_start_date));
          $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days")); 
        }
        for($i = 0;$i<count($project_all_dates);$i++){
            $project_activity[$i] = 0;
            //$project_activity[$i]['actual'] = 0;
            for($j=0;$j<count($plan_arr);$j++){
              if($project_all_dates[$i] == $plan_arr[$j]){
                $project_activity[$i] = 1;
                //break;
              }
            }   
        }

        $actuall_arr = array();
        $main_activity_didetails[$cnt]['date_activity'] =  $project_activity;

        $row->actual_start_date = '';
        $row->actual_end_date = '';


       $main_activity_didetails[$cnt+1]['id'] =  $row->id;
       $main_activity_didetails[$cnt+1]['project_id'] =  $row->project_id;
       $main_activity_didetails[$cnt+1]['gate_id'] =  $row->gate_id;
       $main_activity_didetails[$cnt+1]['plan_start_date'] = '';
       $main_activity_didetails[$cnt+1]['plan_end_date'] = '';
       $main_activity_didetails[$cnt+1]['activity'] =  $row->activity;
       $main_activity_didetails[$cnt+1]['Gate_Description'] =  $row->Gate_Description;
       $main_activity_didetails[$cnt+1]['activityName'] =  $row->activityName;
       $main_activity_didetails[$cnt+1]['department_name'] =  $row->department_name;
       $main_activity_didetails[$cnt+1]['department'] =  $row->department;
       $main_activity_didetails[$cnt+1]['lead_time'] =  '';
       $main_activity_didetails[$cnt+1]['type'] =  1;
        $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
        $row->actual_duaration = '';
        if(count($AtualActivityDetails) > 0){
           $main_activity_didetails[$cnt+1]['plan_start_date'] = date('d F y',strtotime($AtualActivityDetails->actual_start_date));
           $main_activity_didetails[$cnt+1]['plan_end_date'] = date('d F y',strtotime($AtualActivityDetails->actual_end_date));
          
          
          $actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
          $actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
          
          $actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
          
          $main_activity_didetails[$cnt+1]['lead_time'] =  $actual_diff;
          
          $actual_start_date = $AtualActivityDetails->actual_start_date;

          for($k = 0;$k<$actual_diff;$k++){
            $actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
            $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days")); 
          }
          
        }


        for($i = 0;$i<count($project_all_dates);$i++){
            $project_activity_plan[$i] = 0;
            

            for($l=0;$l<count($actuall_arr);$l++){
              if($project_all_dates[$i] == $actuall_arr[$l]){
                $project_activity_plan[$i] = 1;
                //break;
              }
            }       
        }

        $main_activity_didetails[$cnt+1]['date_activity'] =  $project_activity_plan;

       


        
        $row->activity_row = $project_activity;
        $cnt = $cnt+2;
      }
      //print_r($main_activity_didetails);exit;
      $data['mail_activity_details'] = $main_activity_didetails;

      //print_r($data);exit;
      if (ob_get_level() > 0) { 
        ob_end_clean();
         }
          $sheet->loadView('excel.projectActivity',$data);

          $x=10;
          
          for($m=0;$m<count($data['activities']);$m++){
            $y=$x+1;
            $sheet->mergeCells('A'.$x.':A'.$y);
            $sheet->mergeCells('B'.$x.':B'.$y);
            $sheet->mergeCells('C'.$x.':C'.$y);
            $sheet->mergeCells('D'.$x.':D'.$y);
            $x = $x+2;
          }
          


      });

})->export('xlsx');
}


function gnattChartPdf($project_id){

    
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
    //print_r($project_all_dates);exit;
    $plan = array();
    $actual = array();
    $total_row_count = floor(count($project_all_dates)/124);
    $actual_row_count = count($project_all_dates)/124;
    $last_row_data_count = count($project_all_dates)%124;
    if($actual_row_count > $total_row_count)
      $total_row_count = $total_row_count+1;
    //$total_row_count ;exit;
    //exit;
    $project_activity = array();
    $total_date_array_all = array();
    $all_data = array();
    $th_cnt = 0;
    for($l = 1;$l<=$total_row_count;$l++){
        if($l != $total_row_count){
          for($m = 0;$m<60;$m++){
            $total_date_array_all[$l][$m] = $project_all_dates[$th_cnt];
            $th_cnt++;
          }

            foreach($data['activities'] as $key=>$row){
              $all_data[$l][$key]['project_id'] = $row->project_id;
              $all_data[$l][$key]['activity'] = $row->activity;
              $all_data[$l][$key]['gate_id'] = $row->gate_id;
              $all_data[$l][$key]['Gate_Description'] = $row->Gate_Description;
              
              $all_data[$l][$key]['activityName'] = $row->activityName;
              $all_data[$l][$key]['department_name'] = $row->department_name;
              $all_data[$l][$key]['lead_time'] = $row->lead_time;
              



              $all_data[$l][$key]['plan_start_date'] = date('d F y',strtotime($row->activity_start_date));
              $all_data[$l][$key]['plan_end_date'] = date('d F y',strtotime($row->activity_end_date));

              $plan_date1 = new DateTime($row->activity_start_date);
              $plan_date2 = new DateTime($row->activity_end_date);
              $plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
              $plan_arr = array();
              $plan_start_date = $row->activity_start_date;
              for($i = 0;$i<$plan_diff;$i++){
                $plan_arr[$i] = date('d F y',strtotime($plan_start_date));
                $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days")); 
              }
              
              $all_data[$l][$key]['plan_date'] = $plan_arr;



              $actuall_arr = array();

              $all_data[$l][$key]['actual_start_date'] = '';
              $all_data[$l][$key]['actual_end_date'] = '';


              $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
              $all_data[$l][$key]['actual_duaration'] = '';
              if(count($AtualActivityDetails) > 0){
                //echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
                $all_data[$l][$key]['actual_start_date'] = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
                $all_data[$l][$key]['actual_end_date'] = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
                $actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
                $actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
                
                $actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
                
                $all_data[$l][$key]['actual_duaration'] = $actual_diff;
                
                $actual_start_date = $AtualActivityDetails->actual_start_date;

                for($k = 0;$k<$actual_diff;$k++){
                  $actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
                  $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days")); 
                }
                
              }
              $all_data[$l][$key]['actual_date'] = $actuall_arr;

              //print_r($total_date_array_all[$l]);exit;
              //echo 66;
              $project_activity = array();
              for($z = 0;$z<count($total_date_array_all[$l]);$z++){
                  $project_activity[$z]['plan'] = 0;
                  $project_activity[$z]['actual'] = 0;
                  $project_activity[$z]['date_1'] = $total_date_array_all[$l][$z];
                  //$project_activity[$z]['date_2'] = $$actuall_arr[$y];
                  for($j=0;$j<count($plan_arr);$j++){
                    if($total_date_array_all[$l][$z] == $plan_arr[$j]){
                      $project_activity[$z]['plan'] = 1;
                      //break;
                    }
                  }

                  for($y=0;$y<count($actuall_arr);$y++){
                    if($total_date_array_all[$l][$z] == $actuall_arr[$y]){
                      $project_activity[$z]['actual'] = 1;
                      //break;
                    }
                  }     
              }

              $all_data[$l][$key]['activity_date'] = $project_activity ; 


          }
        
        }
        else{
          for($m = 0;$m<$last_row_data_count;$m++){
            $total_date_array_all[$l][$m] = $project_all_dates[$th_cnt];
            
            $th_cnt++;
          }

          foreach($data['activities'] as $key=>$row){

              $all_data[$l][$key]['project_id'] = $row->project_id;
              $all_data[$l][$key]['activity'] = $row->activity;
              $all_data[$l][$key]['gate_id'] = $row->gate_id;
              $all_data[$l][$key]['Gate_Description'] = $row->Gate_Description;
              
              $all_data[$l][$key]['activityName'] = $row->activityName;
              $all_data[$l][$key]['department_name'] = $row->department_name;
              $all_data[$l][$key]['lead_time'] = $row->lead_time;

              $all_data[$l][$key]['plan_start_date'] = date('d F y',strtotime($row->activity_start_date));
              $all_data[$l][$key]['plan_end_date'] = date('d F y',strtotime($row->activity_end_date));

              $plan_date1 = new DateTime($row->activity_start_date);
              $plan_date2 = new DateTime($row->activity_end_date);
              $plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
              $plan_arr = array();
              $plan_start_date = $row->activity_start_date;
              for($i = 0;$i<$plan_diff;$i++){
                $plan_arr[$i] = date('d F y',strtotime($plan_start_date));
                $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days")); 
              }
              
              $all_data[$l][$key]['plan_date'] = $plan_arr;



              $actuall_arr = array();

              $all_data[$l][$key]['actual_start_date'] = '';
              $all_data[$l][$key]['actual_end_date'] = '';


              $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
              $all_data[$l][$key]['actual_duaration'] = '';
              if(count($AtualActivityDetails) > 0){
                //echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
                $all_data[$l][$key]['actual_start_date'] = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
                $all_data[$l][$key]['actual_end_date'] = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
                $actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
                $actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
                
                $actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
                
                $all_data[$l][$key]['actual_duaration'] = $actual_diff;
                
                $actual_start_date = $AtualActivityDetails->actual_start_date;

                for($k = 0;$k<$actual_diff;$k++){
                  $actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
                  $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days")); 
                }
                
              }
              $all_data[$l][$key]['actual_date'] = $actuall_arr;

             
              $project_activity = array();
              for($z = 0;$z<count($total_date_array_all[$l]);$z++){
                //echo $z.'|';
                  $project_activity[$z]['plan'] = 0;
                  $project_activity[$z]['actual'] = 0;
                  $project_activity[$z]['date_1'] = $total_date_array_all[$l][$z];
                  
                  for($j=0;$j<count($plan_arr);$j++){
                    if($total_date_array_all[$l][$z] == $plan_arr[$j]){
                      $project_activity[$z]['plan'] = 1;
                      //break;
                    }
                  }

                  for($y=0;$y<count($actuall_arr);$y++){
                    if($total_date_array_all[$l][$z] == $actuall_arr[$y]){
                      $project_activity[$z]['actual'] = 1;
                      //break;
                    }
                  }     
              }

              $all_data[$l][$key]['activity_date'] = $project_activity ; 


          }
        }
        
    }
   
    $data['total_date_array_all'] = $total_date_array_all;
    $data['all_data'] = $all_data;
      $filename='ganttChartPdf';

    /*$pdf=PDF::loadView('pages.projectActivityPdf', compact('data'));

                $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf');*/
      return View::make('pages.projectActivityPdf',$data);  
    
     
  }

  public function getPdftest($project_id)
  {
    
    
    /*$myProjectDirectory =  Config::get('app.site_root');
   
    $snappy = new PDF($myProjectDirectory . 'protected/vendor/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="gnatt_cahrt.pdf"');
    $snappy->setOption('page-size', 'A0');
     echo $myProjectDirectory;exit();
    echo $snappy->getOutput(url().'/pdf-download/'.$project_id);*/


    /*$myProjectDirectory =  base_path();
    $snappy = new PDF($myProjectDirectory . '/protected/vendor/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="gnatt_cahrt.pdf"');
    $snappy->setOption('page-size', 'A0');
    //$snappy->setOption('page-height', '139.7');
    echo $snappy->getOutput(url().'/pdf-download/'.$project_id);*/

                   
    // $pdf = App::make('dompdf');


     $chart = new Chart();

    /* ------- Start Project Details -------*/
    $data['project_details'] = $project_details = $chart->getProjectById($project_id);
    $project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
    $project_details->date = date('d F y',strtotime($project_start_date));
    /* ------- End Project Details -------*/

    /* ----- Start Date column Create ------ */
    $project_end_date_details = $chart->getProjectEndDate($project_id);
    $project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);
    //print_r($project_actual_end_date_details);exit;

    $row_date = strtotime($project_end_date_details->activity_end_date);

    
    $today = '';
    if( count($project_actual_end_date_details) > 0 ){
        $project_end_date_check = date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date));
        $today = strtotime(date('Y-m-d',strtotime($project_actual_end_date_details->actual_end_date)));
    }

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
    //print_r($project_all_dates);exit;
    $plan = array();
    $actual = array();
    $total_row_count = floor(count($project_all_dates)/60);
    $actual_row_count = count($project_all_dates)/60;
    $last_row_data_count = count($project_all_dates)%60;
    if($actual_row_count > $total_row_count)
      $total_row_count = $total_row_count+1;
    //$total_row_count ;exit;
    //exit;
    $project_activity = array();
    $total_date_array_all = array();
    $all_data = array();
    $th_cnt = 0;
    for($l = 1;$l<=$total_row_count;$l++){
        if($l != $total_row_count){
          for($m = 0;$m<60;$m++){
            $total_date_array_all[$l][$m] = $project_all_dates[$th_cnt];
            $th_cnt++;
          }

            foreach($data['activities'] as $key=>$row){
              $all_data[$l][$key]['project_id'] = $row->project_id;
              $all_data[$l][$key]['activity'] = $row->activity;
              $all_data[$l][$key]['gate_id'] = $row->gate_id;
              $all_data[$l][$key]['Gate_Description'] = $row->Gate_Description;
              
              $all_data[$l][$key]['activityName'] = $row->activityName;
              $all_data[$l][$key]['department_name'] = $row->department_name;
              $all_data[$l][$key]['lead_time'] = $row->lead_time;
              



              $all_data[$l][$key]['plan_start_date'] = date('d F y',strtotime($row->activity_start_date));
              $all_data[$l][$key]['plan_end_date'] = date('d F y',strtotime($row->activity_end_date));

              $plan_date1 = new DateTime($row->activity_start_date);
              $plan_date2 = new DateTime($row->activity_end_date);
              $plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
              $plan_arr = array();
              $plan_start_date = $row->activity_start_date;
              for($i = 0;$i<$plan_diff;$i++){
                $plan_arr[$i] = date('d F y',strtotime($plan_start_date));
                $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days")); 
              }
              
              $all_data[$l][$key]['plan_date'] = $plan_arr;



              $actuall_arr = array();

              $all_data[$l][$key]['actual_start_date'] = '';
              $all_data[$l][$key]['actual_end_date'] = '';


              $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
              $all_data[$l][$key]['actual_duaration'] = '';
              if(count($AtualActivityDetails) > 0){
                //echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
                $all_data[$l][$key]['actual_start_date'] = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
                $all_data[$l][$key]['actual_end_date'] = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
                $actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
                $actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
                
                $actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
                
                $all_data[$l][$key]['actual_duaration'] = $actual_diff;
                
                $actual_start_date = $AtualActivityDetails->actual_start_date;

                for($k = 0;$k<$actual_diff;$k++){
                  $actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
                  $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days")); 
                }
                
              }
              $all_data[$l][$key]['actual_date'] = $actuall_arr;

              //print_r($total_date_array_all[$l]);exit;
              //echo 66;
              $project_activity = array();
              for($z = 0;$z<count($total_date_array_all[$l]);$z++){
                  $project_activity[$z]['plan'] = 0;
                  $project_activity[$z]['actual'] = 0;
                  $project_activity[$z]['date_1'] = $total_date_array_all[$l][$z];
                  //$project_activity[$z]['date_2'] = $$actuall_arr[$y];
                  for($j=0;$j<count($plan_arr);$j++){
                    if($total_date_array_all[$l][$z] == $plan_arr[$j]){
                      $project_activity[$z]['plan'] = 1;
                      //break;
                    }
                  }

                  for($y=0;$y<count($actuall_arr);$y++){
                    if($total_date_array_all[$l][$z] == $actuall_arr[$y]){
                      $project_activity[$z]['actual'] = 1;
                      //break;
                    }
                  }     
              }

              $all_data[$l][$key]['activity_date'] = $project_activity ; 


          }
        
        }
        else{
          for($m = 0;$m<$last_row_data_count;$m++){
            $total_date_array_all[$l][$m] = $project_all_dates[$th_cnt];
            
            $th_cnt++;
          }

          foreach($data['activities'] as $key=>$row){

              $all_data[$l][$key]['project_id'] = $row->project_id;
              $all_data[$l][$key]['activity'] = $row->activity;
              $all_data[$l][$key]['gate_id'] = $row->gate_id;
              $all_data[$l][$key]['Gate_Description'] = $row->Gate_Description;
              
              $all_data[$l][$key]['activityName'] = $row->activityName;
              $all_data[$l][$key]['department_name'] = $row->department_name;
              $all_data[$l][$key]['lead_time'] = $row->lead_time;

              $all_data[$l][$key]['plan_start_date'] = date('d F y',strtotime($row->activity_start_date));
              $all_data[$l][$key]['plan_end_date'] = date('d F y',strtotime($row->activity_end_date));

              $plan_date1 = new DateTime($row->activity_start_date);
              $plan_date2 = new DateTime($row->activity_end_date);
              $plan_diff = $plan_date2->diff($plan_date1)->format("%a")+1;
              $plan_arr = array();
              $plan_start_date = $row->activity_start_date;
              for($i = 0;$i<$plan_diff;$i++){
                $plan_arr[$i] = date('d F y',strtotime($plan_start_date));
                $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days")); 
              }
              
              $all_data[$l][$key]['plan_date'] = $plan_arr;



              $actuall_arr = array();

              $all_data[$l][$key]['actual_start_date'] = '';
              $all_data[$l][$key]['actual_end_date'] = '';


              $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity);
              $all_data[$l][$key]['actual_duaration'] = '';
              if(count($AtualActivityDetails) > 0){
                //echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
                $all_data[$l][$key]['actual_start_date'] = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
                $all_data[$l][$key]['actual_end_date'] = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
                $actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
                $actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
                
                $actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
                
                $all_data[$l][$key]['actual_duaration'] = $actual_diff;
                
                $actual_start_date = $AtualActivityDetails->actual_start_date;

                for($k = 0;$k<$actual_diff;$k++){
                  $actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
                  $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days")); 
                }
                
              }
              $all_data[$l][$key]['actual_date'] = $actuall_arr;

             
              $project_activity = array();
              for($z = 0;$z<count($total_date_array_all[$l]);$z++){
                //echo $z.'|';
                  $project_activity[$z]['plan'] = 0;
                  $project_activity[$z]['actual'] = 0;
                  $project_activity[$z]['date_1'] = $total_date_array_all[$l][$z];
                  
                  for($j=0;$j<count($plan_arr);$j++){
                    if($total_date_array_all[$l][$z] == $plan_arr[$j]){
                      $project_activity[$z]['plan'] = 1;
                      //break;
                    }
                  }

                  for($y=0;$y<count($actuall_arr);$y++){
                    if($total_date_array_all[$l][$z] == $actuall_arr[$y]){
                      $project_activity[$z]['actual'] = 1;
                      //break;
                    }
                  }     
              }

              $all_data[$l][$key]['activity_date'] = $project_activity ; 


          }
        }
        
    }
   
    $data['total_date_array_all'] = $total_date_array_all;
    $data['all_data'] = $all_data;
      $filename='ganttChartPdf';

    /*$pdf=PDF::loadView('pages.projectActivityPdf', compact('data'));

                $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf');*/
      //return View::make('pages.projectActivityPdf',$data);  




    $pdf=PDF::loadView('pages.projectActivityPdf',$data);
     $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
     // return $pdf->stream();
     // view file in browser 
     return $pdf->download('gantt.pdf');
      //forcely download  
    
  }


	
}	