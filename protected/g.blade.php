<?php
ini_set('max_execution_time', 6000);
use Carbon\Carbon;
class ganttChartController extends BaseController  {

public function gnattChart(){
    $input=Input::all();
      // dd($input);
    $project_id = $input['proj_no'];
    $chart = new Chart();

    /* ------- Start Project Details -------*/
    $data['project_details'] = $project_details = $chart->getProjectById($project_id);
    $project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
    $project_details->date = date('d F Y',strtotime($project_start_date));
    $project_details->EndDate = $chart->projectEndDate($project_id);
    $project_details->logo_image = $chart->getLogo($project_id);
    $project_details->top_app = $chart->gettopApp($project_details->top_mgt_approval);
    $project_details->cust = $chart->getCust($project_details->customer);
    $project_details->ActivityDate = $chart->getActivityDate($project_id);
    $project_details->checkDrop = $chart->getCheckDrop($project_id);
    $project_details->checkHold = $chart->getCheckHold($project_id);
    $data['remark'] = $remark[] = $chart->getAllRemark($project_id);
    $data['upload_doc'] = $upload_doc[] = $chart->getUploadDoc($project_id);
    $data['responsibility'] = $responsibility[] =$chart->respUser($project_id);
    $data['refer'] = $refer[] = $chart->getRefActivity();
    // echo "<pre>";
    // print_r($upload_doc);
    
    $data['enquiry'] = $enquiry[] = $chart->getEnquiry($project_details->customer);
    
    // dd($enquiry);
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
    if($input['filter'] == 'weekly'){
      $cal_diff = strtotime($project_end_date, 0) - strtotime($project_start_date, 0);
      $diff = floor($cal_diff / 604800); 
     // echo  $diff = $date2->diff($date1)->format("%a")+7; exit;
    }else if($input['filter'] == 'monthly'){
      $diff = $date2->diff($date1)->format("%m")+1;
    }else{
      $diff = $date2->diff($date1)->format("%a")+1;
    }

    $project_all_dates = array();
    $start_date = $project_start_date;
    for($i = 0;$i<= $diff;$i++){
      
      if($input['filter'] == 'weekly'){
        $project_all_dates[$i] = date('d F y',strtotime($start_date));
        $start_date = date('Y-m-d',strtotime($start_date . "+7 days"));
      }else if($input['filter'] == 'monthly'){
        $project_all_dates[$i] = date('M Y',strtotime($start_date));
        $start_date = date('Y-m-d',strtotime($start_date . "+1 months")); 
      }else{
        $project_all_dates[$i] = date('d F y',strtotime($start_date));
        $start_date = date('Y-m-d',strtotime($start_date . "+1 days"));
      } 
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
        
        if($input['filter'] == 'weekly'){
          // $plan_arr[$i] = date('d F y',strtotime($plan_start_date ));
          $m = strtotime($plan_start_date);  
          $today =   date('l', $m);  
          $custom_date = strtotime( date('d-m-Y', $m) );   
          if ($today == 'Monday') {  
            $plan_arr[$i] = date("d F y", $m);  
          } else {  
            $plan_arr[$i] = date('d F y', strtotime('this week last monday', $custom_date));  
          } 
          // echo "First day of this week: ".$plan_arr[$i];

          $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));

        }else if($input['filter'] == 'monthly'){
          $plan_arr[$i] = date('M Y',strtotime($plan_start_date));
          $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));
        }else{
          $plan_arr[$i] = date('d F y',strtotime($plan_start_date));
          $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));
        } 

      }
      $row->plan = $plan_arr;


      $actuall_arr = array();

      $row->actual_start_date = '';
      $row->actual_end_date = '';

      $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity,$row->id);
      //echo '<pre>'; print_r($AtualActivityDetails);exit();
    
      $row->actual_duaration = '';
      if(count($AtualActivityDetails) > 0){
       
        if($AtualActivityDetails->actual_start_date != "" && $AtualActivityDetails->actual_start_date != '0000-00-00'){
          $row->actual_start_date = date('d F y',strtotime($AtualActivityDetails->actual_start_date));
        }
      
     
        if($AtualActivityDetails->actual_end_date != "" && $AtualActivityDetails->actual_end_date != '0000-00-00 00:00:00'){
           $row->actual_end_date = date('d F y',strtotime($AtualActivityDetails->actual_end_date));
        }
       
        $actual_date1 = new DateTime($AtualActivityDetails->actual_start_date);
        if($AtualActivityDetails->actual_end_date != ""  && $AtualActivityDetails->actual_end_date != '0000-00-00 00:00:00'){
          $actual_date2 = new DateTime(date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date)));
         //print_r($actual_date2);exit();
          
          $actual_diff = $actual_date2->diff($actual_date1)->format("%a")+1;
                    
          $row->actual_duaration = $actual_diff;
          
          $actual_start_date = $AtualActivityDetails->actual_start_date;

          for($k = 0;$k<$actual_diff;$k++){
            
            if($input['filter'] == 'weekly'){
              // $actuall_arr[$k] = date('d F y',strtotime($actual_start_date  ));
              $m = strtotime($actual_start_date);  
              $today =   date('l', $m);  
              $custom_date = strtotime( date('d-m-Y', $m) );   
              if ($today == 'Monday') {  
                $actuall_arr[$k] = date("d F y", $m);  
              } else {  
                $actuall_arr[$k] = date('d F y', strtotime('this week last monday', $custom_date));  
              }

              $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));
            }else if($input['filter'] == 'monthly'){
              $actuall_arr[$k] = date('M Y',strtotime($actual_start_date));
              $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days")); 
            }else{
              $actuall_arr[$k] = date('d F y',strtotime($actual_start_date));
              $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));
            }
          }
        }
      }
      $row->actual = $actuall_arr;
     // $row->remark = $chart->getAllRemark($project_id);

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
    // echo "<pre>"; print_r($project_all_dates);  echo "========="; exit;
    /*print_r($data['activities']); exit;*/
   
    if($input['filter'] == 'weekly'){
      return View::make('pages.projectActivityWeekly',$data);
    }else if($input['filter'] == 'monthly'){
      return View::make('pages.projectActivityMonthly',$data);
    }else{
      return View::make('pages.projectActivity',$data);
    }
   
  }




public function getPdftest($project_id)
  {
     $chart = new Chart();

    /* ------- Start Project Details -------*/
    $data['project_details'] = $project_details = $chart->getProjectById($project_id);
    $project_start_date = date('Y-m-d',strtotime($project_details->project_start_date));
    $project_details->date = date('d F y',strtotime($project_start_date));
    $project_details->EndDate = $chart->projectEndDate($project_id);
    $project_details->logo_image = $chart->getLogo($project_id);
    $project_details->top_app = $chart->gettopApp($project_details->top_mgt_approval);
    $project_details->cust = $chart->getCust($project_details->customer);
    $project_details->ActivityDate = $chart->getActivityDate($project_id);
    $project_details->checkDrop = $chart->getCheckDrop($project_id);
    $project_details->checkHold = $chart->getCheckHold($project_id);
    /* ------- End Project Details -------*/

    /* ----- Start Date column Create ------ */
    $project_end_date_details = $chart->getProjectEndDate($project_id);
    $project_actual_end_date_details = $chart->getProjectActualEndDate($project_id);
    //print_r($project_actual_end_date_details);exit;
    $data['remark'] = $remark[] = $chart->getAllRemark($project_id);
    $data['upload_doc'] = $upload_doc[] = $chart->getUploadDoc($project_id);
    $data['responsibility'] = $responsibility[] =$chart->respUser($project_id);
    $data['refer'] = $refer[] = $chart->getRefActivity();
    // echo "<pre>";
    // print_r($upload_doc);
    
    $data['enquiry'] = $enquiry[] = $chart->getEnquiry($project_details->customer);

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
              $all_data[$l][$key]['material_id'] = $row->material_id;
              



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


              $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity,$row->id);
              $all_data[$l][$key]['actual_duaration'] = '';
              if(count($AtualActivityDetails) > 0){
                //echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
                $all_data[$l][$key]['actual_start_date'] = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;
                if($AtualActivityDetails->actual_end_date != ""){
                $all_data[$l][$key]['actual_end_date'] = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
              }
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
                  //$project_activity[$z]['date_1'] = $total_date_array_all[$l][$z];
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
               $all_data[$l][$key]['material_id'] = $row->material_id;
              

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


             $AtualActivityDetails = $chart->getAtualActivityDetails($project_id,$row->activity,$row->id);
              $all_data[$l][$key]['actual_duaration'] = '';
              if(count($AtualActivityDetails) > 0){
                //echo date('Y-m-d',strtotime($AtualActivityDetails->actual_end_date));
                $all_data[$l][$key]['actual_start_date'] = date('d F y',strtotime($AtualActivityDetails->actual_start_date));;

                 if($AtualActivityDetails->actual_end_date != ""){
                $all_data[$l][$key]['actual_end_date'] = date('d F y',strtotime($AtualActivityDetails->actual_end_date));;
              }

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
                 // $project_activity[$z]['date_1'] = $total_date_array_all[$l][$z];
                  
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
    $pdf=PDF::loadView('pages.projectActivityPdf',$data);
    $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
    $pdf->setTimeout(600);
     // return $pdf->stream();
     // view file in browser 
    return $pdf->download('gantt.pdf');
      //forcely download  
  }
}