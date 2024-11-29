<?php
use Carbon\Carbon;

class dtlsOfChangeRequestController extends BaseController
{

    public function index()
    {

        $user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('DtlsOfChangeRequest/changeRequest_search');
        }
            else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
         
        
    }       


    public function dtlsOfChangeRequest_search_result(){
        $data=array();
            $input = (object)Input::all();
            // print_r($input);exit();
         
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

             $query =DB::table('changerequests')
                     ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                    ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
                    ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                   ->leftJoin('tb_change_stage','changerequests.change_stage','=','tb_change_stage.change_stage_id')
                    ->leftJoin('plant_code','changerequests.plant_code','=','plant_code.plant_id')
                   // ->leftJoin('tbl_parts_info','changerequests.request_id','=','tbl_parts_info.request_ids')
                   // ->leftJoin('changerequests_purposechange','changerequests.request_id','=','changerequests_purposechange.request_id')
                   // ->leftJoin('changerequest_purpose','changerequests_purposechange.purpose_id','=','changerequest_purpose.id')
                   ->leftJoin('add_update_initial_sheet','changerequests.request_id','=','add_update_initial_sheet.request_id')
                   // ->leftJoin('changerequests_customer','changerequests.request_id','=','changerequests_customer.request_id')
                   // ->leftJoin('customer','changerequests_customer.customer_id','=','customer.CustomerId')
                   ->leftJoin('tb_projectmaster','changerequests.proj_code','=','tb_projectmaster.id')
                   ->leftJoin('tb_businessmaster','changerequests.business','=','tb_businessmaster.id')
                   ->leftJoin('tb_stakeholder','changerequests.stakeholder','=','tb_stakeholder.id')
                   ->leftJoin('request_progress_status','request_progress_status.request_id','=','changerequests.request_id')
                     ->select('changerequests.request_id','changerequests.dt', 'tb_users.first_name','changerequests.created_date','tb_users.last_name','tbl_change_type.change_type_name','tb_departments.d_name','tb_change_stage.stage_name','changerequests.Purpose_Modification_Details','changerequests.remark','add_update_initial_sheet.currentTime','changerequests.status','tb_projectmaster.project_code','tb_projectmaster.project_description','tb_businessmaster.busi_code','tb_businessmaster.Description','tb_stakeholder.name','request_progress_status.message','plant_code.plant_code')
                     ->orderBy('changerequests.request_id','asc')
                    // ->where('changerequests.status','<>',5)
                     ->where('changerequests.dt', '>=', $created_date)
                     ->where('changerequests.dt', '<=', $end_date)
                     //->where('request_progress_status.close',0)
                     ->groupBy('request_progress_status.request_id');
                     // ->get();
                     if($input->plant!= '? undefined:undefined ?'){
                        $query->where('changerequests.plant_code', $input->plant);
                        $plant_id=$input->plant;
                    }else{
                        $plant_id='';
                        }
                        if($input->stage!= '? undefined:undefined ?'){
                        $query->where('changerequests.change_stage', $input->stage);
                        $stage_id=$input->stage;
                    }else{
                        $stage_id='';
                        }
                     if($input->department!= '? undefined:undefined ?'){
                        $query->where('changerequests.dep_id', $input->department);
                        $dept_id=$input->department;
                    }else{
                        $dept_id='';
                        }
                     if($input->user!= '? undefined:undefined ?'){
                        $query->where('changerequests.initiator_id',$input->user);
                         $user_id=$input->user;
                    }else{
                        $user_id='';
                        }
                    if($input->projectcode!= '? undefined:undefined ?'){
                        $query->where('changerequests.proj_code',$input->projectcode);
                         $project_code=$input->projectcode;
                    }else{
                        $project_code='';
                        }
                     
             //        $users=$query->get();
             //   echo '<pre>';
             // print_r($users);exit();       
           $users=  $query->distinct('changerequests.request_id')
                          ->get();
          // echo '<pre>';
          //    print_r($users);exit();
             foreach ($users as $user){

                $data[] = array(
                    'request_id' => $user->request_id,
                    'plant'=> $user->plant_code,
                    'initiation_dt'=>$this->get_custom_date($user->dt),
                    'initiator'=>$user->first_name.' '.$user->last_name,
                    'dept'=>$user->d_name,
                    'cust'=>$this->get_customer($user->request_id),
                    'stage'=>$user->stage_name,
                    'type'=>$user->change_type_name,
                    'partno'=>$this->get_partsInfo($user->request_id),
                    // 'partname'=>$user->part_name,
                    'purpose'=>$this->get_purpose($user->request_id),
                    'modDtls'=>$user->Purpose_Modification_Details,
                    'remark'=>$user->remark,
                    'business'=>$user->busi_code,
                    'stakeholder'=>$user->name,
                    'projectcode'=>$user->project_code,
                    'impdate'=>$this->get_custom_date($user->currentTime),
                    'status'=>$this->getstatus($user->status,$user->request_id),
                    'cmNoview'=> $this->generate_cm_no_search($user->change_type_name,$user->created_date,$user->request_id),
                    // 'PendingDays'=>$this->get_pendingDays($assigned_to[0]->status),
                    );
             }
            
            $formInput=array(
                'startdate'=>$created_date,
                'enddate'=>$end_date,
                'dept_id'=>$dept_id,
                'user_id'=>$user_id,
                'plant_id'=>$plant_id,
                'stage_id'=>$stage_id,
                'project'=>$project_code,
                // 'purpose'=>$purpose,
                // 'customer_id'=>$customer_id,
                // 'projectcode'=>$projectcode,
            );    
            //  echo '<pre>';
            // print_r($data);exit();
            if ($this->check_permission(1)) {
            return View::make('DtlsOfChangeRequest/taskSheet',compact('data','formInput'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

    public function getstatus($status,$r_id){
        if($status == 5){
            $msg="Change Request is drafted";
        }else{
            $data=DB::table('request_progress_status')
                    ->select('message')
                    ->where('request_id',$r_id)
                    ->where('close',0)
                    ->get();
                    if(!empty($data)){
                        $msg=$data[0]->message;
                    }else{
                        $data1=DB::table('request_progress_status')
                    ->select('message')
                    ->where('request_id',$r_id)
                    ->orderBy('status','desc')
                    ->get();
                     $msg=$data1[0]->message;
                    }
        }
        return $msg;

    }

    public function get_customer($r_id){
      $data=DB::table('changerequests_customer')
            ->join('customer','changerequests_customer.customer_id','=','customer.CustomerId')
            ->select(DB::Raw('CONCAT(customer.FirstName," ",customer.LastName) as cust'))
            ->where('changerequests_customer.request_id',$r_id)
            ->get();
       return $data;
      }

    public function get_partsInfo($r_id){
      $data=DB::table('tbl_parts_info')
            ->select('part_number','part_name')
            ->where('tbl_parts_info.request_ids',$r_id)
            ->get();
       return $data;
      }

    public function get_purpose($r_id){
      $data=DB::table('changerequests_purposechange')
            ->join('changerequest_purpose','changerequest_purpose.id','=','changerequests_purposechange.purpose_id')
            ->select('changerequest_purpose')
            ->where('changerequests_purposechange.request_id',$r_id)
            ->get();
       return $data;
      }

    
    public function advance_search_result_download(){
         $data=array();
        $input = (object)Input::all();
        // print_r($input);exit();
             $query =DB::table('changerequests')
                     ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                    ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
                    ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                   ->leftJoin('tb_change_stage','changerequests.change_stage','=','tb_change_stage.change_stage_id')
                   ->leftJoin('plant_code','changerequests.plant_code','=','plant_code.plant_id')
                   // ->leftJoin('tbl_parts_info','changerequests.request_id','=','tbl_parts_info.request_ids')
                   // ->leftJoin('changerequests_purposechange','changerequests.request_id','=','changerequests_purposechange.request_id')
                   // ->leftJoin('changerequest_purpose','changerequests_purposechange.purpose_id','=','changerequest_purpose.id')
                   ->leftJoin('add_update_initial_sheet','changerequests.request_id','=','add_update_initial_sheet.request_id')
                   // ->leftJoin('changerequests_customer','changerequests.request_id','=','changerequests_customer.request_id')
                   // ->leftJoin('customer','changerequests_customer.customer_id','=','customer.CustomerId')
                   ->leftJoin('tb_projectmaster','changerequests.proj_code','=','tb_projectmaster.id')
                   ->leftJoin('tb_businessmaster','changerequests.business','=','tb_businessmaster.id')
                   ->leftJoin('tb_stakeholder','changerequests.stakeholder','=','tb_stakeholder.id')
                   ->leftJoin('request_progress_status','request_progress_status.request_id','=','changerequests.request_id')
                     ->select('changerequests.request_id','changerequests.dt', 'tb_users.first_name','changerequests.created_date','tb_users.last_name','tbl_change_type.change_type_name','tb_departments.d_name','tb_change_stage.stage_name','changerequests.Purpose_Modification_Details','changerequests.remark','add_update_initial_sheet.currentTime','changerequests.status','tb_projectmaster.project_code','tb_projectmaster.project_description','tb_businessmaster.busi_code','tb_businessmaster.Description','tb_stakeholder.name','request_progress_status.message','plant_code.plant_code')
                     ->where('changerequests.status','<>',5)
                     ->where('changerequests.dt', '>=', $input->startdate)
                     ->where('changerequests.dt', '<=', $input->enddate)
                     ->where('request_progress_status.close',0);
                     // ->get();
                       if(isset($input->dept_id)&& !empty($input->dept_id)){
                        $query->where('changerequests.dep_id', $input->dept_id);
                        $dept_id=$input->dept_id;
                        }else{
                        $dept_id='';
                        }
                      if(isset($input->user_id)&& !empty($input->user_id)){
                        $query->where('changerequests.initiator_id', $input->user_id);
                        $user_id=$input->user_id;
                        }else{
                        $user_id='';
                        }
                      if(isset($input->stage)&& !empty($input->stage)){
                        $query->where('changerequests.change_stage', $input->stage);
                        $stage_id=$input->stage;
                        }else{
                        $stage_id='';
                        }
                      if(isset($input->plant)&& !empty($input->plant)){
                        $query->where('changerequests.plant_code', $input->plant);
                        $plant_id=$input->plant;
                        }else{
                        $plant_id='';
                        }
                      if(isset($input->project)&& !empty($input->project)){
                        $query->where('changerequests.proj_code', $input->project);
                        $project=$input->project;
                        }else{
                        $project='';
                        }
             //        $users=$query->get();
             //   echo '<pre>';
             // print_r($users);exit();       
           $users=  $query->distinct('changerequests.request_id')
                          ->get();
          
             foreach ($users as $user){

                $data[] = array(
                    'request_id' => $user->request_id,
                    'plant'=> $user->plant_code,
                    'initiation_dt'=>$this->get_custom_date($user->dt),
                    'initiator'=>$user->first_name.' '.$user->last_name,
                    'dept'=>$user->d_name,
                    'cust'=>$this->get_customer($user->request_id),
                    'stage'=>$user->stage_name,
                    'type'=>$user->change_type_name,
                    'partno'=>$this->get_partsInfo($user->request_id),
                    // 'partname'=>$user->part_name,
                    'purpose'=>$this->get_purpose($user->request_id),
                    'modDtls'=>$user->Purpose_Modification_Details,
                    'remark'=>$user->remark,
                    'business'=>$user->busi_code,
                    'stakeholder'=>$user->name,
                    'projectcode'=>$user->project_code,
                    'impdate'=>$this->get_custom_date($user->currentTime),
                    'status'=>$user->message,
                    'cmNoview'=> $this->generate_cm_no_search($user->change_type_name,$user->created_date,$user->request_id),
                    // 'PendingDays'=>$this->get_pendingDays($assigned_to[0]->status),
                    );
             }

             $stadt= Carbon::createFromFormat('Y-m-d H:i:s', $input->startdate)->format('d.m.Y');
             $enddt= Carbon::createFromFormat('Y-m-d H:i:s', $input->enddate)->format('d.m.Y');
      //  $filename=$input->startdate.'-'.$input->enddate;
             $filename='ChangeRequestDetails-'.$stadt.'-'.$enddt;

             if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('DtlsOfChangeRequest/taskSheetPDF', compact('data'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('DtlsOfChangeRequest/taskSheetExcel',compact('data'));

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
    }

    public function getProjAccToStage($stage){
        if($stage== 0)
        {
            $projectMaster = DB::table('tb_projectMaster')
            ->select('id', 'project_code')
            ->get();
            return $projectMaster;
        }else{
          $projectMaster = DB::table('tb_projectMaster')
            ->select('id', 'project_code')
            ->where('change_stage',$stage)
            ->get();
              return $projectMaster;
        }
    }
   
}
