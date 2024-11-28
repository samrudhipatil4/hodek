<?php
use Carbon\Carbon;

class AdvancesearchController extends BaseController  {

			
	public function index()
	{

		$user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('advance-search/advance_search');
        }
			else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
		 
		
	}		


	public function department()
	{
		
		//Returns All departments
		$departments = DB::table('tb_departments')->select('d_id','d_name')->where('d_id','!=',2)->get();
		
		return $departments;
   
 
	}	
	public function show($d_id)
	{

		//Returns sub-department of selected departmemt
		return $users = DB::table('subdepartments')->select('sub_dep_id','department_id','sub_dep_name')->where('department_id', '=', $d_id)->get();
		
	}


        
        
        
        public function advance_search_result() {
            $data=array();
            $input = (object)Input::all();
             
           
           
                $_SESSION['param'] = $input;
                $_SESSION['btntype'] = "summerySheet";
             if($input->startdate != "" && $input->enddate != ""){
            if(!strcmp((String)$input->startdate,(String)$input->enddate)){
                $std=explode('/',$input->startdate);


                $created_date=$std[2].'-'.$std[1].'-'.$std[0].' 00:00:00';
                $etd=explode('/',$input->enddate);
                $end_date=$etd[2].'-'.$etd[1].'-'.$etd[0].' 23:59:00';

            }else {
                $std = explode('/', $input->startdate);
               // print_r($std);exit;
                $created_date = $std[2] . '-' . $std[1] . '-' . $std[0] . ' 00:00:00';
                $etd = explode('/', $input->enddate);
                $end_date = $etd[2] . '-' . $etd[1] . '-' . $etd[0] . ' 23:59:00';
            }
          }else{
            $created_date="";
           $end_date="";
          }

        
          if($input->r_id != "") {
               $r_id=$input->r_id;
                
            }else{
               $r_id='';
            }

         //  echo $created_date.'     '.$end_date;exit;

            
            $query =DB::table('changerequests')
           // ->leftJoin('changerequests_customer', 'changerequests_customer.customer_id', '=', 'customer.CustomerId')
            ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
            ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
           // ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            ->leftJoin('changerequests_purposechange', 'changerequests.request_id', '=', 'changerequests_purposechange.request_id')
            ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
            ->leftJoin('changerequests_customer', 'changerequests.request_id', '=', 'changerequests_customer.request_id')
            ->select('changerequests.*', 'tb_departments.d_name', 'subdepartments.sub_dep_name','tb_change_stage.stage_name', 'tb_users.*', 'tbl_change_type.change_type_name')
             
            ->orderBy('changerequests.modified_date', 'DESC')
            ->groupBy('changerequests_customer.request_id')
            ->where('changerequests.status','<>',5)
            ->where('changerequests.status','<>',1);
            //->where('changerequests.dt', '>=', $created_date)
            
            //->where('changerequests.dt', '<=', $end_date);
            if($input->r_id != '')
             $query->where('changerequests.request_id',$input->r_id);
             if($input->startdate != '')
             $query->where('changerequests.dt', '>=', $created_date);
            if($input->enddate != '')
             $query->where('changerequests.dt', '<=', $end_date);
            if(isset($input->changeType)&& !empty($input->changeType)) {
                // $query-> where('changerequests.changeType','=',$input->changeType);
                $query->whereIn('changerequests.changeType', [implode(',', $input->changeType)]);
                $changeType=implode(',',$input->changeType);
            }else{
                $changeType='';
            }
            if(($input->change_stage_id[0] != '? string:not ?')) {
                // $query->where('changerequests.change_stage','=',$input->change_stage_id);
                $query->whereIn('changerequests.change_stage', [implode(',', $input->change_stage_id)]);
                $change_stage_id=implode(',',$input->change_stage_id);
            }
            else{
                $change_stage_id='';
            }
            
             if(isset($input->changerequest_plantcode)&& !empty($input->changerequest_plantcode)){
                 $query->whereIn('changerequests.plant_code',[implode(',',$input->changerequest_plantcode)]);
                 $plantcode= implode(',',$input->changerequest_plantcode);
             }else{
                 $plantcode='';
             }
            if(isset($input->changerequest_purpose)&& !empty($input->changerequest_purpose)){
                $query->whereIn('changerequests_purposechange.purpose_id',[implode(',',$input->changerequest_purpose)]);
                $purpose=implode(',',$input->changerequest_purpose);
            }else{
                $purpose='';
            }
            if(isset($input->customer_id)&& !empty($input->customer_id)){
                $query->whereIn('changerequests_customer.customer_id',[implode(',',$input->customer_id)]);
                $customer_id=implode(',',$input->customer_id);
            }else{
                $customer_id='';
            }
if(isset($input->changerequest_projectcode)&& !empty($input->changerequest_projectcode)){
                 $query->whereIn('changerequests.proj_code',[implode(',',$input->changerequest_projectcode)]);
                 $projectcode= implode(',',$input->changerequest_projectcode);
             }else{
                 $projectcode='';
             }

          
      $users=  $query->distinct('changerequests.request_id')->get();
  


            foreach ($users as $user){
                $data[] = array(
                    'request_id' => $user->request_id,
                   
                    'initiator_name'=>$user->first_name.' '.$user->last_name,
                    'changeType' =>$user->changeType,
                    'change_stage' => $user->change_stage,
                    'customers' => $this->get_request_customers($user->request_id),
                    'change_purpose' => $this->get_assigned_task_purpose($user->request_id),
                    'Approval_Authority' => $user->Approval_Authority,
                    'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                    'remark' => $user->remark,
                    'created_date' => Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
                    'status' => $user->status,
                    'stage_name' => $user->stage_name,
                    'change_type_name' => $user->change_type_name,
                  
                    'count_request_is_rejected' => $this->get_count_request_is_rejected($user->request_id),
                    'cmNo'=>$this->generate_cm_no($user->change_type_name,$user->created_date,$user->request_id,$user->status),
                    'cmNoview'=> $this->generate_cm_no_search($user->change_type_name,$user->created_date,$user->request_id),
                   'cooappstatus' =>$this->checkeCooApproval($user->request_id),
                   'HODapproval' =>$this->getHODApproval($user->request_id),
                    'DefineCFT' =>$this->getCFT($user->request_id)

                );
            }
          


            $formInput=array(
              'r_id' =>$r_id,
                'startdate'=>$created_date,
                'enddate'=>$end_date,
                'change_type'=>$changeType,
                'change_stage_id'=>$change_stage_id,
                'plantcode'=>$plantcode,
                'purpose'=>$purpose,
                'customer_id'=>$customer_id,
                'projectcode'=>$projectcode,
            );
             $allDepartment =$this->getDepartment();

           // return $data;
          //  echo '<pre>';
          //  print_r($allDepartment);exit;

            return View::make('advance-search/summery_sheet',compact('data','formInput','allDepartment'));

        }

    public function getHODApproval($id){


    $data = DB::table('request_progress_status')
       ->select(DB::raw('COUNT(id) as total'))
        ->where('request_progress_status.request_id', $id)
        ->where('request_progress_status.status', 1)
        ->where('request_progress_status.close', 0)
        ->get();



    

    if($data[0]->total==0){

       $status=array(
                  'status' => 'green', 
                  'text'   => 'G'
                  );

    }else if($data[0]->total!=0){
      $status=array(
                  'status' => 'yellow', 
                  'text'   => 'Y'
                  );

    }else{

       $status=array(
            'status' => '-', 
            'text'   => '-'
            );
    }

    return $status;

}

 public function getCFT($id){


    $data = DB::table('request_progress_status')
        ->select('request_progress_status.status','request_progress_status.close')
        ->where('request_progress_status.request_id', $id)
        ->where('request_progress_status.status', 2)
        ->get();



    if(empty($data)){
     
   $status=array(
            'status' => '-', 
            'text'   => '-'
            );
    }

    else if($data[0]->close==1){

       $status=array(
                  'status' => 'green', 
                  'text'   => 'G'
                  );

    }else{

      $status=array(
                  'status' => 'yellow', 
                  'text'   => 'Y'
                  );
}
    return $status;

}

public function checkeCooApproval($rid){
          $data=  DB::table('changerequests')
                  ->select('change_stage')
                  ->where('request_id',$rid)
                  ->get();
                  $status=[];
                  if($data[0]->change_stage == 1){
                    $app= DB::table('coo_approval_decision_status')
                          ->select('decision','status')
                          ->where('request_id',$rid)
                          ->get();
                          if(!empty($app)){
                          if($app[0]->decision == 2){
                            $status=array(
                              'status' => 'green', 
                              'text'   => 'G'
                              );
                          }else{
                            $checkopen=DB::table('request_progress_status')
                                       ->select('close')
                                       ->where('status',21)
                                       ->where('request_id',$rid)
                                       ->orderBy('id','desc')
                                       ->get();

                              if($checkopen[0]->close == 1 && $app[0]->status ==2){
                                 $status=array(
                              'status' => 'green', 
                              'text'   => 'G'
                              );
                              }else if($checkopen[0]->close == 1 && $app[0]->status ==3){
                                $status=array(
                              'status' => '-', 
                              'text'   => '-'
                              );
                              }else{
                                  $status=array(
                              'status' => 'yellow', 
                              'text'   => 'Y'
                              );
                              }
                          }
                        }
                  }else{
                     $status=array(
                              'status' => 'N/A', 
                              'text'   => 'N/A', 
                              );
                  } 
                  return $status;
         }

        public function advance_search_result_result_view() {

            $input= $_SESSION['param'];
            
               
           if(!strcmp((String)$input->startdate,(String)$input->enddate)){
                $std=explode('/',$input->startdate);


                $created_date=$std[2].'-'.$std[1].'-'.$std[0].' 00:00:00';
                $etd=explode('/',$input->enddate);
                $end_date=$etd[2].'-'.$etd[1].'-'.$etd[0].' 23:59:00';

            }else {
                $std = explode('/', $input->startdate);
               // print_r($std);exit;
                $created_date = $std[2] . '-' . $std[1] . '-' . $std[0] . ' 00:00:00';
                $etd = explode('/', $input->enddate);
                $end_date = $etd[2] . '-' . $etd[1] . '-' . $etd[0] . ' 23:59:00';
            }
         //  echo $created_date.'     '.$end_date;exit;

            
            $query =DB::table('changerequests')
           // ->leftJoin('changerequests_customer', 'changerequests_customer.customer_id', '=', 'customer.CustomerId')
            ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
            ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
           // ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            ->leftJoin('changerequests_purposechange', 'changerequests.request_id', '=', 'changerequests_purposechange.request_id')
            ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
            ->leftJoin('changerequests_customer', 'changerequests.request_id', '=', 'changerequests_customer.request_id')
            ->select('changerequests.*', 'tb_departments.d_name', 'subdepartments.sub_dep_name','tb_change_stage.stage_name', 'tb_users.*', 'tbl_change_type.change_type_name')
              //  ->select('changerequests.*', 'tb_departments.d_name', 'subdepartments.sub_dep_name','tb_change_stage.stage_name', 'tb_users.user_role', 'tbl_change_type.change_type_name', 'plant_code.plant_code','changerequests_purposechange.*'.'customer.*')
            ->orderBy('changerequests.modified_date', 'DESC')
            ->groupBy('changerequests_customer.request_id')
            ->where('changerequests.status','<>',5)
            ->where('changerequests.status','<>',1)
            ->where('changerequests.dt', '>=', $created_date)
            ->where('changerequests.dt', '<=', $end_date);
            if(isset($input->changeType)&& !empty($input->changeType)) {
                // $query-> where('changerequests.changeType','=',$input->changeType);
                $query->whereIn('changerequests.changeType', [implode(',', $input->changeType)]);
                $changeType=implode(',',$input->changeType);
            }else{
                $changeType='';
            }
            if(isset($input->change_stage_id)&& !empty($input->change_stage_id)) {
                // $query->where('changerequests.change_stage','=',$input->change_stage_id);
                $query->whereIn('changerequests.change_stage', [implode(',', $input->change_stage_id)]);
                $change_stage_id=implode(',',$input->change_stage_id);
            }
            else{
                $change_stage_id='';
            }
            /* if(isset($input->multi_user)&& !empty($input->multi_user)){
                 $query->whereIn('changerequests_customer.customer_id',[implode(',',$input->multi_user)]);
             }*/
             if(isset($input->changerequest_plantcode)&& !empty($input->changerequest_plantcode)){
                 $query->whereIn('changerequests.plant_code',[implode(',',$input->changerequest_plantcode)]);
                 $plantcode= implode(',',$input->changerequest_plantcode);
             }else{
                 $plantcode='';
             }
            if(isset($input->changerequest_purpose)&& !empty($input->changerequest_purpose)){
                $query->whereIn('changerequests_purposechange.purpose_id',[implode(',',$input->changerequest_purpose)]);
                $purpose=implode(',',$input->changerequest_purpose);
            }else{
                $purpose='';
            }
            if(isset($input->customer_id)&& !empty($input->customer_id)){
                $query->whereIn('changerequests_customer.customer_id',[implode(',',$input->customer_id)]);
                $customer_id=implode(',',$input->customer_id);
            }else{
                $customer_id='';
            }/*if(in_array(1,explode(',',Session::get('gid')))){
                $query->whereIn('changerequests_customer.customer_id',[implode(',',$input->customer_id)]);
                $customer_id=implode(',',$input->customer_id);
            }*/
if(isset($input->changerequest_projectcode)&& !empty($input->changerequest_projectcode)){
                 $query->whereIn('changerequests.proj_code',[implode(',',$input->changerequest_projectcode)]);
                 $projectcode= implode(',',$input->changerequest_projectcode);
             }else{
                 $projectcode='';
             }

           //  echo $query;exit;
      $users=  $query->distinct('changerequests.request_id')->get();
   //   return $userjobs;
          //  echo '<pre>';
           // print_r($users);exit;


            foreach ($users as $user){
                $data[] = array(
                    'request_id' => $user->request_id,
                    // 'request_info'=>$this->get_request_info_by_id($user->request_id),
                    // 'initiator_info' => $this->get_user_info_by_id($user->initiator_id),
                    'initiator_name'=>$user->first_name.' '.$user->last_name,
                    //'emp_id' =>$user->emp_id,
                    // 'dep_id' =>$user->dep_id,
                    // 'sub_dep_id' =>$user->sub_dep_id,
                    'changeType' =>$user->changeType,
                    'change_stage' => $user->change_stage,
                    'customers' => $this->get_request_customers($user->request_id),
                    'change_purpose' => $this->get_assigned_task_purpose($user->request_id),
                    'Approval_Authority' => $user->Approval_Authority,
                    // 'plant_code' => $user->plant_code,
                    'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                    'remark' => $user->remark,
                    'created_date' => Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
                    'status' => $user->status,
                    //'d_name' => $user->sub_dep_name,
                    // 'sub_dep_name' => $user->request_id,
                    'stage_name' => $user->stage_name,
                    // 'user_role' => $user->user_role,
                    'change_type_name' => $user->change_type_name,
                  //  'user_info'=>$this->get_user_info_by_id($user->assigned_to),
                 //   'last_status'=>$this->get_last_status($user->request_id),
                  //  'next_url'=>$user->next_url,
                    'count_request_is_rejected' => $this->get_count_request_is_rejected($user->request_id),
                    'cmNo'=>$this->generate_cm_no($user->change_type_name,$user->created_date,$user->request_id,$user->status),
                    'cmNoview'=> $this->generate_cm_no_search($user->change_type_name,$user->created_date,$user->request_id),
                   

                );
            }
          


            $formInput=array(
                'startdate'=>$created_date,
                'enddate'=>$end_date,
                'change_type'=>$changeType,
                'change_stage_id'=>$change_stage_id,
                'plantcode'=>$plantcode,
                'purpose'=>$purpose,
                'customer_id'=>$customer_id,
                'projectcode'=>$projectcode,
            );
             $allDepartment =$this->getDepartment();

           return View::make('advance-search/summery_sheet',compact('data','formInput','allDepartment'));


        }
    public function advance_search_result_download() {
        $data=array();
       // $removeddata1=array();
        $input = (object)Input::all();
       
     

         $query =DB::table('changerequests')
           // ->leftJoin('changerequests_customer', 'changerequests_customer.customer_id', '=', 'customer.CustomerId')
            ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
            ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
           // ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            ->leftJoin('changerequests_purposechange', 'changerequests.request_id', '=', 'changerequests_purposechange.request_id')
            ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
            ->leftJoin('changerequests_customer', 'changerequests.request_id', '=', 'changerequests_customer.request_id')
            ->select('changerequests.*', 'tb_departments.d_name', 'subdepartments.sub_dep_name','tb_change_stage.stage_name', 'tb_users.*', 'tbl_change_type.change_type_name')
             
            ->orderBy('changerequests.modified_date', 'DESC')
            ->groupBy('changerequests_customer.request_id')
            ->where('changerequests.status','<>',5)
            ->where('changerequests.status','<>',1);
            //->where('changerequests.dt', '>=', $created_date)
            
            //->where('changerequests.dt', '<=', $end_date);
            if($input->r_id != '')
             $query->where('changerequests.request_id', $input->r_id);
             if($input->startdate != '')
             $query->where('changerequests.dt', '>=', $input->startdate);
            if($input->enddate != '')
             $query->where('changerequests.dt', '<=', $input->enddate);
        if(isset($input->change_type)&& !empty($input->change_type)) {
            // $query-> where('changerequests.changeType','=',$input->changeType);
            $query->whereIn('changerequests.changeType', [implode(',', (array)$input->change_type)]);
            $changeType=implode(',',(array)$input->change_type);
        }else{
            $changeType='';
        }
        if(isset($input->change_stage_id)&& !empty($input->change_stage_id)) {
            // $query->where('changerequests.change_stage','=',$input->change_stage_id);
            $query->whereIn('changerequests.change_stage', [implode(',', (array)$input->change_stage_id)]);
            $change_stage_id=implode(',',(array)$input->change_stage_id);
        }
        else{
            $change_stage_id='';
        }
        /* if(isset($input->multi_user)&& !empty($input->multi_user)){
             $query->whereIn('changerequests_customer.customer_id',[implode(',',$input->multi_user)]);
         }*/
        if(isset($input->plantcode)&& !empty($input->plantcode)){
            $query->whereIn('changerequests.plant_code',[implode(',',(array)$input->plantcode)]);
            $plantcode= implode(',',(array)$input->plantcode);
        }else{
            $plantcode='';
        }
        if(isset($input->purpose)&& !empty($input->purpose)){
            $query->whereIn('changerequests_purposechange.purpose_id',[implode(',',(array)$input->purpose)]);
            $purpose=implode(',',(array)$input->purpose);
        }else{
            $purpose='';
        }
        if(isset($input->customer_id)&& !empty($input->customer_id)){
            $query->whereIn('changerequests_customer.customer_id',[implode(',',(array)$input->customer_id)]);
            $customer_id=implode(',',(array)$input->customer_id);
        }else{
            $customer_id='';
        }
if(isset($input->projectcode)&& !empty($input->projectcode)){
                 $query->whereIn('changerequests.proj_code',[implode(',',(array)$input->projectcode)]);
                 $projectcode= implode(',',(array)$input->projectcode);
             }else{
                 $projectcode='';
             }
       
       // print_r($input->changerequest_purpose);

        
        $users=  $query->distinct('changerequests.request_id')->get();
         
        //   return $userjobs;

        foreach ($users as $user){
            $data[] = array(
                'request_id' => $user->request_id,
                // 'request_info'=>$this->get_request_info_by_id($user->request_id),
                // 'initiator_info' => $this->get_user_info_by_id($user->initiator_id),
                'initiator_name'=>$user->first_name.' '.$user->last_name,
                //'emp_id' =>$user->emp_id,
                // 'dep_id' =>$user->dep_id,
                // 'sub_dep_id' =>$user->sub_dep_id,
                'changeType' =>$user->changeType,
                'change_stage' => $user->change_stage,
                'customers' => $this->get_request_customers($user->request_id),
                'change_purpose' => $this->get_assigned_task_purpose($user->request_id),
                'Approval_Authority' => $user->Approval_Authority,
                // 'plant_code' => $user->plant_code,
                'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                'remark' => $user->remark,
                'created_date' => Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
                'status' => $user->status,
                //'d_name' => $user->sub_dep_name,
                // 'sub_dep_name' => $user->request_id,
                'stage_name' => $user->stage_name,
                // 'user_role' => $user->user_role,
                'change_type_name' => $user->change_type_name,
                //  'user_info'=>$this->get_user_info_by_id($user->assigned_to),
                //   'last_status'=>$this->get_last_status($user->request_id),
                //  'next_url'=>$user->next_url,
                'count_request_is_rejected' => $this->get_count_request_is_rejected($user->request_id),
                'cmNo'=>$this->generate_cm_no($user->change_type_name,$user->created_date,$user->request_id,$user->status),
                'cooappstatus' =>$this->checkeCooApproval($user->request_id),
                'HODapproval' =>$this->getHODApproval($user->request_id),
                    'DefineCFT' =>$this->getCFT($user->request_id)


            );
        }

           
 $allDepartment =$this->getDepartment();

       $date = date('Y-m-d');

        // $stadt= Carbon::createFromFormat('Y-m-d H:i:s', $input->startdate)->format('d.m.Y');
        // $enddt= Carbon::createFromFormat('Y-m-d H:i:s', $input->enddate)->format('d.m.Y');
      //  $filename=$input->startdate.'-'.$input->enddate;
        $filename='Summary Sheet-'.$date;
       // $filename='Summery-sheet-'.$input->startdate.'-'.$input->enddate;
        DB::table('changerequests_customer')
           
            ->update(
                array('flag' => 0,
                )
            );

       // return View::make('advance-search/summery_sheet',compact('data','formInput'));
            if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('advance-search/summery_sheet_pdf', compact('data','allDepartment'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('advance-search/csv_download',compact('data','allDepartment'));

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

            }elseif($input->filetype=='csv'){



            }else if($input->filetype=='remove' && !empty($input->removeddata)){
                    $removeddata=$input->removeddata;
             //   echo '<pre>';

              //  print_r($removeddata);exit;
                foreach($removeddata as $remove){
                    $x=explode('/',$remove);
                    $request=$x[0];
                    $cust=$x[1];
                  //  echo $request.'   '.$cust.'<br/>';

                    $this->remove_customer_from_list($request,$cust);


                }

            }else if($input->filetype=='show' && !empty($input->showdata)){
                $showdata=$input->showdata;
              //  echo '<pre>';
              //  print_r($showdata);exit;
                foreach($showdata as $show){
                    $x=explode('/',$show);
                    $request=$x[0];
                    $cust=$x[1];
                    //  echo $request.'   '.$cust.'<br/>';

                    $this->show_customer_from_list($request,$cust);


                }
/*
 *
 * trial code
 *
 *
 */
            }else if($input->filetype=='hide_data' && !empty($input->removeddata1)) {
                $showdata = $input->removeddata1;

                    DB::table('changerequests_customer')
                        //->where('request_id', $request_id)
                        //->where('id', $id)
                        ->update(
                            array('flag' => 0,
                            )
                        );


                    foreach ($showdata as $show) {
                        $x = explode('/', $show);
                        $request = $x[0];
                        $cust = $x[1];

                        $this->show_customer_from_list_trial($request, $cust);


                    }

            }




        return Redirect::to('advance-search')->with(compact('data'));


    }
    public function get_count_request_is_rejected($id){
        $users = DB::table('permanent_reject_close')
            ->select(DB::raw('COUNT(permanent_reject_close.id) as total'))

            ->where('permanent_reject_close.request_id', $id)
            //->where('request_progress_status.assigned_to', Session::get('uid'))
            ->get();
        if($users[0]->total >=1){
            $Name = DB::table('permanent_reject_close')
                ->select('permanent_reject_close.rejected_by_name')
                ->where('permanent_reject_close.request_id', $id)
                //->where('request_progress_status.assigned_to', Session::get('uid'))
                ->get();
            return "Request is Rejected and Closed by ".$Name[0]->rejected_by_name;
        }else{
            return "";
        }
    }

     public function getDepartment()
    {

      
        $departments = DB::table('tb_departments')
                    ->select('d_id', 'd_name')
                    ->where('d_id','!=',2)
                     ->where('d_id','!=',11)
                    // ->orderBy('d_id')
                    ->get();

        return $departments;


    }
    public function getChangeRequ(){
      

       $cmNo="";

        
             $requestId=DB::table('changerequests')
           ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id','request_id')
           ->select('tbl_change_type.change_type_name','changerequests.*')
           ->where('changerequests.status','<>',5)
            ->where('changerequests.status','<>',1)
           ->get();
           
      foreach($requestId as $row) {

            $data[] = array(
                'request_id' => $this->generate_cm_no_search($row->change_type_name, $row->created_date, $row->request_id),
                'r_id'      =>$row->request_id,
            );
        }
        return $data;

    }






}	