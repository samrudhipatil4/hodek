public function getPdftestWeekly($project_id)
  {
    $input=Input::all();
    $project_id = $project_id;
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

   // $diff = $date2->diff($date1)->format("%a")+1;
    $cal_diff = strtotime($project_end_date, 0) - strtotime($project_start_date, 0);
    $diff = floor($cal_diff / 604800); 
    $project_all_dates = array();
    $start_date = $project_start_date;
    for($i = 0;$i< $diff;$i++){
      $project_all_dates[$i] = date('d F y',strtotime($start_date));
      $start_date = date('Y-m-d',strtotime($start_date . "+7 days"));
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
          $m = strtotime($actual_start_date);  
              $today =   date('l', $m);  
              $custom_date = strtotime( date('d-m-Y', $m) );   
              if ($today == 'Monday') {  
                $actuall_arr[$k] = date("d F y", $m);  
              } else {  
                $actuall_arr[$k] = date('d F y', strtotime('this week last monday', $custom_date));  
              }

              $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days"));
        }
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
     $filename='ganttChartPdfWeekly';

    
     $pdf=PDF::loadView('pages.projectActivityPdfWeekly',$data);
     $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
     $pdf->setTimeout(600);
     
     return $pdf->download('gantt.pdf');
      //forcely download  
  }

  public function getPdftestMonthly($project_id)
  {
    $input=Input::all();
    $project_id = $project_id;
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

   $diff = $date2->diff($date1)->format("%m")+1;
    
    $project_all_dates = array();
    $start_date = $project_start_date;
    for($i = 0;$i< $diff;$i++){
      $project_all_dates[$i] = date('M Y',strtotime($start_date));
        $start_date = date('Y-m-d',strtotime($start_date . "+1 months")); 
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
        $plan_arr[$i] = date('M Y',strtotime($plan_start_date));
        $plan_start_date = date('Y-m-d',strtotime($plan_start_date . "+1 days"));
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
           $actuall_arr[$k] = date('M Y',strtotime($actual_start_date));
              $actual_start_date = date('Y-m-d',strtotime($actual_start_date . "+1 days")); 
        }
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

     $filename='ganttChartPdfMonthly';

     $pdf=PDF::loadView('pages.projectActivityPdfMonthly',$data);
     $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
     $pdf->setTimeout(600);
     
     return $pdf->download('gantt.pdf');
      //forcely download  
  }
