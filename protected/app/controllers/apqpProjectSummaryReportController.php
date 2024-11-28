<?php
unset($_SESSION['btntype']);
class apqpProjectSummaryReportController extends BaseController  {

	//protected $layout = "layouts.main";
	
	
	public function index(){
        if(Auth::check()):
         return View::make('apqpProjectSummaryReport/summaryReport');
      else:
         return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
        endif;
  }

  public function projectSummary_PieChartReport(){
     if(Auth::check()){

        $allProjectwithdrop =DB::select(DB::raw('select * from apqp_new_project_info as a where   
          project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  
              and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1)'));               
     
        $allProject =DB::select(DB::raw('select * from apqp_new_project_info as a where   
          project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  
          and a.id NOT IN(select project_id from apqp_drop_project) and hold_project != 1
      and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1)'));

        $dropPrj = DB::select(DB::raw('select * from apqp_new_project_info as a where  
        project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) 
         and   a.id  IN(select project_id from apqp_drop_project) '));

        $holdPrj = DB::select(DB::raw('select * from apqp_new_project_info as a where   
            project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) and hold_project = 1 '));

  $completedProject =[];
 $InprocessProj = [];
  if(!empty($allProject)){
            foreach ($allProject as $key) {
                $planact = DB::table('apqp_draft_project_plan')                  
                            ->select('apqp_draft_project_plan.project_id')
                            ->where('project_id',$key->id)
                            ->get();
              $comact = DB::table('apqp_all_task')
                        ->select('apqp_all_task.close')
                        ->where('apqp_all_task.project_id',$key->id)
                        ->where('close',1)
                        ->get();
                  $comactcomplete = DB::table('apqp_all_task')
                        ->select('apqp_all_task.close')
                        ->where('apqp_all_task.project_id',$key->id)
                         ->where('close',0)
                        ->get();
               if(count($comact) > count($planact) && empty($comactcomplete)){
                $completedProject[]=DB::table('apqp_new_project_info')                  
                            ->select('apqp_new_project_info.*')
                            ->where('id',$key->id)
                            ->get();
               }else{
                $InprocessProj[] = DB::table('apqp_new_project_info')                  
                            ->select('apqp_new_project_info.*')
                            ->where('id',$key->id)
                            ->get();
               }     
            }
          }

          $Inprocessontime = [];
          $Inprocessdelayed = [];
          $inprocessdelay = [];
          $currentDate = date('Y-m-d');
          foreach ($InprocessProj as  $value) {
            $maxDate= DB::table('apqp_all_task')
                                ->select(DB::raw('max(apqp_all_task.activity_end_date) as maxdate'))
                                ->join('apqp_user_task_details','apqp_user_task_details.activity_id','=','apqp_all_task.activity')
                               //->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->where('apqp_all_task.project_id',$value[0]->id)
                                ->where('apqp_all_task.close',1)
                                ->groupby('apqp_all_task.project_id')
                                ->get();
                if(!empty($maxDate)){
                                
         $inprocessdelay[] =DB::table('apqp_user_task_details')
                                ->join('apqp_all_task','apqp_all_task.activity','=','apqp_user_task_details.activity_id')
                                ->select('apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->maxdate)
                                //->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
                               }
              
          }
           $inprocessall = [];
           $delayproj = [];
          

          if(!empty($inprocessdelay)){
           foreach (array_filter($inprocessdelay) as  $value) {
           $delayproj[] = $value[0]->project_id;
          }
        }

         if(!empty($InprocessProj)){
          foreach (array_filter($InprocessProj) as  $value) {
           $inprocessall[] = $value[0]->id;
          }
        }

        if(!empty($inprocessall) && !empty($delayproj)){
            
            $Inprocessontime[] =DB::select(DB::raw('select id from apqp_new_project_info where id in('.  implode( "," , $inprocessall).') and id not in('.  implode( "," , $delayproj).' ) ' ));
        }elseif(!empty($inprocessall)){
        	$Inprocessontime[] =DB::select(DB::raw('select id from apqp_new_project_info where id in('.  implode( "," , $inprocessall).') '));
        }elseif(!empty($delayproj)){
        	 $Inprocessontime[] =DB::select(DB::raw('select id from apqp_new_project_info where id not in('.  implode( "," , $delayproj).' ) ' ));
        }else{
        	 $Inprocessontime=[]; 
        }
            //echo '<pre>';print_r($inprocessdelay);exit();
          $completeddelayed =[];
          
          foreach ($completedProject as  $value) {

            $maxDate =  DB::table('apqp_draft_project_plan')
                            ->select(DB::raw('max(apqp_draft_project_plan.activity_end_date) as project_end_date'))
                             ->where('project_id', $value[0]->id)
                             ->get();


           $completeddelayed[] = DB::table('apqp_user_task_details')
                                
                                ->select('apqp_user_task_details.activity_id','apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->project_end_date)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
                              //   echo '<pre>';print_r($maxDate[0]->project_end_date);
                  $completedtime[] = DB::table('apqp_user_task_details')
                
                ->select('apqp_user_task_details.activity_id','apqp_user_task_details.project_id')
                ->where('apqp_user_task_details.project_id',$value[0]->id)
                ->where('actual_end_date','<',$maxDate[0]->project_end_date)
                ->groupby('apqp_user_task_details.project_id')
                 ->get();

        
          }
          $completedelayproj= count(array_filter($completeddelayed));
          $compproj = count(array_filter($completedProject));
          $completedontime = $compproj-$completedelayproj;

           $Inprocessdelayproj= count(array_filter($inprocessdelay));
          $inprocessproj = count(array_filter($InprocessProj));
          $Inprocessontime = $inprocessproj-$Inprocessdelayproj;

           $totatProject = count($allProjectwithdrop);
           $holdProj =count($holdPrj);
           $dropProj =count($dropPrj);

         
            if ($this->check_permission(1)) {
            return View::make('apqpProjectSummaryReport/summaryPieChartReport',compact('completedelayproj','completedontime','Inprocessdelayproj','Inprocessontime','totatProject','holdProj','dropProj'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    
      
     }else{
         return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
        }
  }
  public function getReportDetails(){
  
    $data=array();

      $input = (object)Input::all();

      if(isset($input->charttype)){
           $allProject =DB::select(DB::raw('select * from apqp_new_project_info as a where   
          project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  
          and a.id NOT IN(select project_id from apqp_drop_project) and hold_project != 1
      and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1)'));

        $dropPrj = DB::select(DB::raw('select * from apqp_new_project_info as a where  
        project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) 
         and   a.id  IN(select project_id from apqp_drop_project) '));

        $holdPrj = DB::select(DB::raw('select * from apqp_new_project_info as a where   
            project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) and hold_project = 1 '));
  $completedProject =[];
 $InprocessProj = [];
  if(!empty($allProject)){
            foreach ($allProject as $key) {
                $planact = DB::table('apqp_draft_project_plan')                  
                            ->select('apqp_draft_project_plan.project_id')
                            ->where('project_id',$key->id)
                            ->get();
              $comact = DB::table('apqp_all_task')
                        ->select('apqp_all_task.close')
                        ->where('apqp_all_task.project_id',$key->id)
                        ->where('close',1)
                        ->get();
                  $comactcomplete = DB::table('apqp_all_task')
                        ->select('apqp_all_task.close')
                        ->where('apqp_all_task.project_id',$key->id)
                         ->where('close',0)
                        ->get();
               if(count($comact) > count($planact) && empty($comactcomplete)){
                $completedProject[]=DB::table('apqp_new_project_info')                  
                            ->select('apqp_new_project_info.*')
                            ->where('id',$key->id)
                            ->get();
               }else{
                $InprocessProj[] = DB::table('apqp_new_project_info')                  
                            ->select('apqp_new_project_info.*')
                            ->where('id',$key->id)
                            ->get();
               }     
            }
          }
           $currentDate = date('Y-m-d');  
          if($input->charttype ==1){
               $completeddelayed =[];
          if(!empty($completedProject)){
          foreach ($completedProject as  $value) {

            $maxDate =  DB::table('apqp_draft_project_plan')
                            ->select(DB::raw('max(apqp_draft_project_plan.activity_end_date) as project_end_date'))
                             ->where('project_id', $value[0]->id)
                             ->get();


           $projects[] = DB::table('apqp_user_task_details')
                                ->select('apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->project_end_date)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
                           
          }
        }
        }else if($input->charttype == 2){
          if(!empty($completedProject)){
          foreach ($completedProject as  $value) {
           
            $maxDate =  DB::table('apqp_draft_project_plan')
                            ->select(DB::raw('max(apqp_draft_project_plan.activity_end_date) as project_end_date'))
                             ->where('project_id', $value[0]->id)
                             ->get();

             $projects[] = DB::table('apqp_user_task_details')
                ->select('apqp_user_task_details.activity_id','apqp_user_task_details.project_id')
                ->where('apqp_user_task_details.project_id',$value[0]->id)
                ->where('actual_end_date','<',$maxDate[0]->project_end_date)
                ->groupby('apqp_user_task_details.project_id')
                 ->get();
              }
            }
        }elseif ($input->charttype == 3) {
           $Inprocessontime = [];
          $Inprocessdelayed = [];
         
         foreach ($InprocessProj as  $value) {
             $maxDate= DB::table('apqp_all_task')
                                ->select(DB::raw('max(apqp_all_task.activity_end_date) as maxdate'))
                                ->join('apqp_user_task_details','apqp_user_task_details.activity_id','=','apqp_all_task.activity')
                               //->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->where('apqp_all_task.project_id',$value[0]->id)
                                ->where('apqp_all_task.close',1)
                                ->groupby('apqp_all_task.project_id')
                                ->get();
                if(!empty($maxDate)){
                                
         $projects[] =DB::table('apqp_user_task_details')
                                ->join('apqp_all_task','apqp_all_task.activity','=','apqp_user_task_details.activity_id')
                                ->select('apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->maxdate)
                                ->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
                               }
              
          }
           
        }elseif ($input->charttype == 4) {
        	$inprocessdelay=[];
        	$delayproj=[];
          foreach ($InprocessProj as  $value) {
              $maxDate= DB::table('apqp_all_task')
                                ->select(DB::raw('max(apqp_all_task.activity_end_date) as maxdate'))
                                ->join('apqp_user_task_details','apqp_user_task_details.activity_id','=','apqp_all_task.activity')
                               //->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->where('apqp_all_task.project_id',$value[0]->id)
                                ->where('apqp_all_task.close',1)
                                ->groupby('apqp_all_task.project_id')
                                ->get();
                if(!empty($maxDate)){
                                
         $inprocessdelay[] =DB::table('apqp_user_task_details')
                                ->join('apqp_all_task','apqp_all_task.activity','=','apqp_user_task_details.activity_id')
                                ->select('apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->maxdate)
                                ->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
                               }
          }
          foreach (array_filter($inprocessdelay) as  $value) {
           $delayproj[] = $value[0]->project_id;
          }
          foreach (array_filter($InprocessProj) as  $value) {
           $inprocessall[] = $value[0]->id;
          }
            if(!empty($delayproj)){
            $projects=DB::select(DB::raw('select id as project_id from apqp_new_project_info where id in('.  implode( "," , $inprocessall).') and id not in('.  implode( "," , $delayproj).' ) ' ));
        	}else{
        		$projects=DB::select(DB::raw('select id as project_id from apqp_new_project_info where id in('.  implode( "," , $inprocessall).')  ' ));
        	}
        }else if($input->charttype == 5){
            $projects = DB::select(DB::raw('select id as project_id from apqp_new_project_info as a where  
        project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) 
         and   a.id  IN(select project_id from apqp_drop_project) '));
        }else if($input->charttype==6){
           $projects = DB::select(DB::raw('select id as project_id from apqp_new_project_info as a where   
            project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) and hold_project = 1 '));
        }
        $summaryData=[];
          //echo '<pre>';print_r($projects);exit();
            if(!empty($projects)){
              if($input->charttype==4 || $input->charttype==5 ||$input->charttype==6)
              {
                 foreach(array_filter($projects) as $row){
              
           
          $summaryData[] =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 )  and a.id='.$row->project_id.' order by id'));
              }
              }else{
         foreach(array_filter($projects) as $row){
          $summaryData[] =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 )  and a.id='.$row[0]->project_id.' order by id'));
          }
         }
        }

           
        
          foreach ($summaryData as $row) {
            foreach ($row as $key) {
             
              $data[]  = array(
                'proj_id'  => $key->id,
                'Project_no' => $key->project_no,
                'revision'  => $key->project_revision,
                'project_name'=> $key->project_name,
                'mfg_location' => $key->plant_code,
                'proj_start_date' => $key->project_start_date,
               'checkDrop' => $this->getCheckDrop($key->id),
                'checkHold' =>$this->getCheckHold($key->id),
                'ActivityStatus' => $this->getActivityStatus($key->id)
                );
            }
        }

       // echo '<pre>';print_r($data);exit();

       $formInput=array(
              'proj_no' =>"",
              'charttype' => $input->charttype
                );
       
      }else{
    if($input->proj_no == ""){
        
      $summaryData =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 ) order by id'));
      }else{
        
          $summaryData =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 )  and a.id='.$input->proj_no.' order by id'));
          }
              
          foreach ($summaryData as $row) {
              $data[]  = array(
                'proj_id'  => $row->id,
                'Project_no' => $row->project_no,
                'revision'  => $row->project_revision,
                'project_name'=> $row->project_name,
                'mfg_location' => $row->plant_code,
                'proj_start_date' => $row->project_start_date,
               'checkDrop' => $this->getCheckDrop($row->id),
                'checkHold' =>$this->getCheckHold($row->id),
                'ActivityStatus' => $this->getActivityStatus($row->id)
                );
        }

      //echo '<pre>';print_r($data);exit();
    
       $formInput=array(
              'proj_no' =>$input->proj_no,
              'charttype' => ""
                );

     }
       $activity = $this->getTempWiseActivity();
        if ($this->check_permission(1)) {
            return View::make('apqpProjectSummaryReport/viewSummerySheet',compact('data','formInput','activity','getMaterial'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }

      }

      

      
      public function getMaterial($temp){
        $material = DB::table('apqp_draft_project_plan')
                    ->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_draft_project_plan.project_id')
                    ->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_draft_project_plan.material_id')
                    ->select('material_id','material_description')
                    ->where('apqp_new_project_info.template',$temp)
                    ->where('apqp_draft_project_plan.material_id','!=',0)
                    ->groupby('material_id')
                   ->get();
                   if(!empty($material)){
                    return $material;
                   }
}

 public  function getActivityStatus($proj_id){
  $activity = $this->getTempWiseActivity();
 
  foreach ($activity as $key) {
       $chkApp = DB::table('apqp_draft_project_plan')
                  ->select('project_no')
                  ->where('activity',$key->id)
                  ->where('project_id',$proj_id)
                  ->get();
      

       
    


          if(empty($chkApp)){
            $data[] =
              array(
              'class'=>"lightgrey",
              'text' => 'N/A',
              'activity' => $key->id,
              'project' => $proj_id
              );
          }else{
          $actdet = DB::table('apqp_user_task_details')
                        ->leftjoin('apqp_all_task','apqp_all_task.id','=','apqp_user_task_details.act_id')
                        ->select('actual_start_date','actual_end_date','apqp_all_task.activity_end_date','apqp_all_task.close')
                        ->where('apqp_user_task_details.project_id',$proj_id)
                        ->where('apqp_user_task_details.activity_id',$key->id)
                        ->get();

                  $checkact = DB::table('apqp_all_task')
                        ->select('activity')
                        ->where('apqp_all_task.project_id',$proj_id)
                        ->where('apqp_all_task.activity',$key->id)
                        ->get(); 

            if(empty($actdet)){
             $data[] =
             array(
              'class'=>"white",
              'text' => ' ',
               'activity' => $key->id,
              'project' => $proj_id
              
              );
             }elseif($actdet[0]->actual_start_date == "0000-00-00" && $actdet[0]->actual_end_date == '0000-00-00 00:00:00' &&  $actdet[0]->close==0){
               $data[] =
             array(
              'class'=>"white",
              'text' => ' ',
               'activity' => $key->id,
              'project' => $proj_id
              
              );

            }elseif((!empty( $checkact)) && ($actdet[0]->actual_start_date == "0000-00-00" || $actdet[0]->actual_start_date != "") && ( $actdet[0]->actual_end_date ==null) && $actdet[0]->close==0)
            {
             // echo '1';exit();
               $data[] =
              array(
              'class'=>"#F9CC29",
              'text' => 'Y',
               'activity' => $key->id,
              'project' => $proj_id
              );
             
            }elseif((!empty( $checkact)) && $actdet[0]->actual_start_date != "0000-00-00" && $actdet[0]->actual_end_date != '0000-00-00 00:00:00' && (date("Y-m-d",strtotime($actdet[0]->actual_end_date)))  > (date("Y-m-d",strtotime($actdet[0]->activity_end_date))))
            {//echo '2';exit();
             $data[] =
              array(
              'class'=>"red",
              'text' => 'R',
               'activity' => $key->id,
              'project' => $proj_id
              );
            }elseif((!empty( $checkact)) && $actdet[0]->actual_start_date != "0000-00-00" && $actdet[0]->actual_end_date != '0000-00-00 00:00:00' && (date("Y-m-d",strtotime($actdet[0]->actual_end_date)))  <= (date("Y-m-d",strtotime($actdet[0]->activity_end_date))) ) 
            {//echo '3';exit();
               $data[] =
              array(
              'class'=>"green",
              'text' => 'G',
               'activity' => $key->id,
              'project' => $proj_id
              );
             
            }elseif((!empty( $checkact)) && ($actdet[0]->actual_end_date == '0000-00-00 00:00:00' || $actdet[0]->activity_end_date != "") && $actdet[0]->close==1) 
            {//echo '4';exit();
               $data[] =
              array(
              'class'=>"green",
              'text' => 'G',
               'activity' => $key->id,
              'project' => $proj_id
              );
             
            }
          }
      }
            return $data;
      }


      public static function getActDetails($proj_id,$activity){
        $chkApp = DB::table('apqp_draft_project_plan')
                  ->select('project_no')
                  ->where('activity',$activity)
                  ->where('project_id',$proj_id)
                  ->get();


          if(empty($chkApp)){
            $data =
              array(
              'class'=>"lightgrey",
              'text' => 'N/A'
              );
          }else{
          $actdet = DB::table('apqp_user_task_details')
                        ->leftjoin('apqp_all_task','apqp_all_task.id','=','apqp_user_task_details.act_id')
                        ->select('actual_start_date','actual_end_date','apqp_all_task.activity_end_date','apqp_all_task.close')
                        ->where('apqp_user_task_details.project_id',$proj_id)
                        ->where('apqp_user_task_details.activity_id',$activity)
                        ->get();

                        $alltask = DB::table('apqp_all_task')
                        ->select('apqp_all_task.close')
                        ->where('apqp_all_task.project_id',$proj_id)
                        ->where('apqp_all_task.activity',$activity)
                        ->get();

                       // echo '<pre>';print_r($actdet);exit();

            if(empty($actdet)){
             $data =
             array(
              'class'=>"white",
              'text' => ' '
              );
            }elseif(($actdet[0]->actual_start_date == "0000-00-00" || $actdet[0]->actual_start_date != "") && ($actdet[0]->actual_end_date == '0000-00-00 00:00:00' || $actdet[0]->actual_end_date ==null) && $actdet[0]->close==0)
            {
             // echo '1';exit();
               $data =
              array(
              'class'=>"#F9CC29",
              'text' => 'Y'
              );
             
            }elseif((!empty($alltask)) && $actdet[0]->actual_start_date != "0000-00-00" && $actdet[0]->actual_end_date != '0000-00-00 00:00:00' && (date("Y-m-d",strtotime($actdet[0]->actual_end_date)))  > (date("Y-m-d",strtotime($actdet[0]->activity_end_date))))
            {//echo '2';exit();
             $data =
              array(
              'class'=>"red",
              'text' => 'R'
              );
            }elseif((!empty($alltask)) && $actdet[0]->actual_start_date != "0000-00-00" && $actdet[0]->actual_end_date != '0000-00-00 00:00:00' && (date("Y-m-d",strtotime($actdet[0]->actual_end_date)))  <= (date("Y-m-d",strtotime($actdet[0]->activity_end_date))) ) 
            {//echo '3';exit();
               $data =
              array(
              'class'=>"green",
              'text' => 'G'
              );
             
            }elseif((!empty($alltask)) && ($actdet[0]->actual_end_date == '0000-00-00 00:00:00' || $actdet[0]->activity_end_date != "") && $actdet[0]->close==1) 
            {//echo '4';exit();
               $data =
              array(
              'class'=>"green",
              'text' => 'G'
              );
             
            }
          }
            return $data;
      }
      public function getTempWiseActivity(){
        $data = DB::table('apqp_gate_activity_master')
                ->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_gate_activity_master.gate_id')
                ->select('apqp_gate_management_master.id as gate_id','apqp_gate_management_master.Gate_Description','apqp_gate_activity_master.*')
                //->where('template',$temp)
                ->where('activity_type','C')
                ->orderby('apqp_gate_activity_master.template','asc')
                ->orderby('apqp_gate_activity_master.gate_id','asc')
                ->orderby('sequence_no')
                ->get();
                if(!empty($data)){
                  return $data;
                }
              }
    public static function countAct($temp,$gate){
                  $data = DB::table('apqp_gate_activity_master')
                ->select('apqp_gate_activity_master.id')
                ->where('template',$temp)
                ->where('activity_type','C')
                ->where('gate_id',$gate)
                ->get();
                //print_r(count($data));exit();
                if(!empty($data)){
                  return count($data);
                }
                
      }
public function getCheckHold($pid){
      $checkHold = DB::table('apqp_new_project_info')
                  ->select('hold_project')
                  ->where('id', $pid)
                  ->get();
                  $hold=[];
         if(!empty($checkHold)){
          if($checkHold[0]->hold_project == 1){
            $hold= 'Is On Hold.';
          }else{
             $hold='';
          }
        }
                  return $hold;
  }
       public function getCheckDrop($pid){
    $data = DB::table('apqp_drop_project')
        ->leftJoin('tb_users','tb_users.id','=','apqp_drop_project.drop_proj_user_id')
        ->select('tb_users.first_name','tb_users.last_name','apqp_drop_project.remark')
        ->where('project_id',$pid)
        ->get();
        if(!empty($data)){
          return $data;
        }
    }
   public function getTemplate(){
    $data = DB::table('apqp_new_project_info')
  ->leftjoin('apqp_templatemaster','apqp_templatemaster.template_id','=','apqp_new_project_info.template')
  ->select('apqp_templatemaster.*')
  //->where('apqp_new_project_info.project_no',$projNo)
  ->groupby('template_id')
  ->get();
  return $data;
   }
   
	
 

 public function downloadReport(){
 $data=array();
      $input = (object)Input::all();
     
      if($input->charttype !=""){
           $allProject =DB::select(DB::raw('select * from apqp_new_project_info as a where   
          project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  
          and a.id NOT IN(select project_id from apqp_drop_project) and hold_project != 1
      and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1)'));

        $dropPrj = DB::select(DB::raw('select * from apqp_new_project_info as a where  
        project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) 
         and   a.id  IN(select project_id from apqp_drop_project) '));

        $holdPrj = DB::select(DB::raw('select * from apqp_new_project_info as a where   
            project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) and hold_project = 1 '));
  $completedProject =[];
 $InprocessProj = [];
  if(!empty($allProject)){
            foreach ($allProject as $key) {
                $planact = DB::table('apqp_draft_project_plan')                  
                            ->select('apqp_draft_project_plan.project_id')
                            ->where('project_id',$key->id)
                            ->get();
              $comact = DB::table('apqp_all_task')
                        ->select('apqp_all_task.close')
                        ->where('apqp_all_task.project_id',$key->id)
                        ->where('close',1)
                        ->get();
                  $comactcomplete = DB::table('apqp_all_task')
                        ->select('apqp_all_task.close')
                        ->where('apqp_all_task.project_id',$key->id)
                         ->where('close',0)
                        ->get();
               if(count($comact) > count($planact) && empty($comactcomplete)){
                $completedProject[]=DB::table('apqp_new_project_info')                  
                            ->select('apqp_new_project_info.*')
                            ->where('id',$key->id)
                            ->get();
               }else{
                $InprocessProj[] = DB::table('apqp_new_project_info')                  
                            ->select('apqp_new_project_info.*')
                            ->where('id',$key->id)
                            ->get();
               }     
            }
          }
           $currentDate = date('Y-m-d');  
          if($input->charttype ==1){
               $completeddelayed =[];
          if(!empty($completedProject)){
          foreach ($completedProject as  $value) {

            $maxDate =  DB::table('apqp_draft_project_plan')
                            ->select(DB::raw('max(apqp_draft_project_plan.activity_end_date) as project_end_date'))
                             ->where('project_id', $value[0]->id)
                             ->get();


           $projects[] = DB::table('apqp_user_task_details')
                                ->select('apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->project_end_date)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
                           
          }
        }
        }else if($input->charttype == 2){
          if(empty($completedProject)){
          foreach ($completedProject as  $value) {

            $maxDate =  DB::table('apqp_draft_project_plan')
                            ->select(DB::raw('max(apqp_draft_project_plan.activity_end_date) as project_end_date'))
                             ->where('project_id', $value[0]->id)
                             ->get();

             $projects[] = DB::table('apqp_user_task_details')
                ->select('apqp_user_task_details.activity_id','apqp_user_task_details.project_id')
                ->where('apqp_user_task_details.project_id',$value[0]->id)
                ->where('actual_end_date','<',$maxDate[0]->project_end_date)
                ->groupby('apqp_user_task_details.project_id')
                 ->get();
              }
            }
        }elseif ($input->charttype == 3) {
           $Inprocessontime = [];
          $Inprocessdelayed = [];
         
          foreach ($InprocessProj as  $value) {
            $maxDate= DB::table('apqp_all_task')
                                ->select(DB::raw('max(apqp_all_task.activity_end_date) as maxdate'))
                               ->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->where('apqp_all_task.project_id',$value[0]->id)
                                ->groupby('apqp_all_task.project_id')
                                ->get();
                                // echo'<pre>';print_r($value);
                                // print_r($maxDate[0]->maxdate);
         $projects[] =DB::table('apqp_user_task_details')
                                ->join('apqp_all_task','apqp_all_task.project_id','=','apqp_user_task_details.project_id')
                                ->select('apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->maxdate)
                                ->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
          }
           
        }elseif ($input->charttype == 4) {
          foreach ($InprocessProj as  $value) {
            $maxDate= DB::table('apqp_all_task')
                                ->select(DB::raw('max(apqp_all_task.activity_end_date) as maxdate'))
                               ->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->where('apqp_all_task.project_id',$value[0]->id)
                                ->groupby('apqp_all_task.project_id')
                                ->get();
                                // echo'<pre>';print_r($value);
                                // print_r($maxDate[0]->maxdate);
         $inprocessdelay[] =DB::table('apqp_user_task_details')
                                ->join('apqp_all_task','apqp_all_task.project_id','=','apqp_user_task_details.project_id')
                                ->select('apqp_user_task_details.project_id')
                                ->where('apqp_user_task_details.project_id',$value[0]->id)
                                ->where('actual_end_date','>',$maxDate[0]->maxdate)
                                ->where('apqp_all_task.activity_end_date','<',$currentDate)
                                ->groupby('apqp_user_task_details.project_id')
                                 ->get();
          }
          foreach (array_filter($inprocessdelay) as  $value) {
           $delayproj[] = $value[0]->project_id;
          }
          foreach (array_filter($InprocessProj) as  $value) {
           $inprocessall[] = $value[0]->id;
          }
            
            $projects=DB::select(DB::raw('select id as project_id from apqp_new_project_info where id in('.  implode( "," , $inprocessall).') and id not in('.  implode( "," , $delayproj).' ) ' ));
        }else if($input->charttype == 5){
            $projects = DB::select(DB::raw('select id as project_id from apqp_new_project_info as a where  
        project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) 
         and   a.id  IN(select project_id from apqp_drop_project) '));
        }else if($input->charttype==6){
           $projects = DB::select(DB::raw('select id as project_id from apqp_new_project_info as a where   
            project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no ) and hold_project = 1 '));
        }
      
            if(!empty($projects)){
              if($input->charttype==4 || $input->charttype==5 ||$input->charttype==6)
              {
                 foreach(array_filter($projects) as $row){
              
           
          $summaryData[] =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 )  and a.id='.$row->project_id));
              }
              }else{
         foreach(array_filter($projects) as $row){
          $summaryData[] =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 )  and a.id='.$row[0]->project_id));
          }
         }
        }

           
           
          foreach ($summaryData as $row) {
            foreach ($row as $key) {
             // echo '<pre>';print_r($key);exit();
              $data[]  = array(
                'proj_id'  => $key->id,
                'Project_no' => $key->project_no,
                'revision'  => $key->project_revision,
                'project_name'=> $key->project_name,
                'mfg_location' => $key->plant_code,
                'proj_start_date' => $key->project_start_date,
               'checkDrop' => $this->getCheckDrop($key->id),
                'checkHold' =>$this->getCheckHold($key->id),
                'ActivityStatus' => $this->getActivityStatus($row->id)
                );
            }
        }

       

       $formInput=array(
              'proj_no' =>"",
              'charttype' =>$input->charttype
                );
       
      }else{
    
        if($input->proj_no == ""){
        
      $summaryData =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 ) order by id'));
      }else{
        
          $summaryData =DB::select(DB::raw('select a.id,a.project_no,a.project_name,a.project_start_date,plant_code,a.template,a.project_revision from apqp_new_project_info as a left join plant_code on plant_code.plant_id = a.mfg_location where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1 )  and a.id='.$input->proj_no.' order by id'));
          }
          foreach ($summaryData as $row) {
              $data[]  = array(
                'proj_id'  => $row->id,
                'Project_no' => $row->project_no,
                'revision'  => $row->project_revision,
                'project_name'=> $row->project_name,
                'mfg_location' => $row->plant_code,
                'proj_start_date' => $row->project_start_date,
               'checkDrop' => $this->getCheckDrop($row->id),
         'checkHold' =>$this->getCheckHold($row->id),
         'ActivityStatus' => $this->getActivityStatus($row->id)
                );
        }

        
    
      $formInput=array(
              'proj_no' =>$input->proj_no,
              'charttype' =>''
                );

}$activity = $this->getTempWiseActivity();
        $date = date('Y-m-d');

        $filename='projectSummaryReport-'.$date;
        if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('apqpProjectSummaryReport/check', compact('data','activity','formInput'));

                $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('apqpProjectSummaryReport/csv_download',compact('data','activity','formInput'));

               // print_r($output);exit;
                $headers = array(
                    'Pragma' => 'public',
                    'Expires' => 'public',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Cache-Control' => 'private',
                    'Content-Type' => 'application/vnd.ms-excel',
                    'Content-Disposition' => 'attachment; filename='.$filename.'.xls',
                    'Content-Transfer-Encoding' => ' binary'
                );
                return Response::make($output, 200, $headers);

            }




        return Redirect::to('lesson_learned_report')->with(compact('data'));

 }

 public function getProject(){
  $data =DB::select(DB::raw('select * from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1) order by id '));
  $project =[];
  if(!empty($data)){
            foreach ($data as $key) {
              $project[]=array(
              'id'=> $key->id,
              'project_no'=>$key->project_no.' Revision'.$key->project_revision
              );
            }
      }
      return $project;
 }

			
	
}	