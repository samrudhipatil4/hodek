<?php
use Carbon\Carbon;
class ViewController extends BaseController  {

			
	public function index()
	{
        //if($this->check_permission(3)) {

       // if ($this->check_permission(5)) {
            return View::make('scm/view_details');
       // } else {

        //    return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
       // }



		
	}

public  function get_change_request_attachment($id){

        $data=array();
        $users = DB::table('change_request_existing_attachments')
            ->select('change_request_existing_attachments.attached_file')
            ->where('change_request_existing_attachments.request_id', $id)
            ->get();

        foreach($users as $user){
            $data[]=array(
                'attachment_file'=>$user->attached_file,
            );

        }

        return $data;


    }

   public  function get_before_after_attachment_file($id){

       $data=array();
       $users = DB::table('befor_after_status_option_attachment')
           ->select('befor_after_status_option_attachment.attachment_file')
           ->where('befor_after_status_option_attachment.request_id', $id)
           ->get();

       foreach($users as $user){
           $data[]=array(
               'attachment_file'=>$user->attachment_file,
           );

       }

       return $data;


   }
   public  function get_ptrDocumet($id){

       $data=array();
       $users = DB::table('tb_PTRDocument')
           ->select('tb_PTRDocument.file_name')
           ->where('tb_PTRDocument.request_id', $id)
           ->get();

       foreach($users as $user){
           $data[]=array(
               'attachment_file'=>$user->file_name,
           );

       }

       return $data;


   }

    public function admin_closer_status($id){

        $users = DB::table('request_progress_status')

            ->select('request_progress_status.status', 'request_progress_status.comment','request_progress_status.close')
            ->where('request_progress_status.request_id', $id)
            ->orderBy('request_progress_status.id', 'DESC')
            // ->where('activity_monitering_verification_status.user_id', Session::get('uid'))
            ->first();

       // print_r($users);exit;
        // $data=(String)$users->verify_status;


        return $users;


    }

    public function get_steering_committee_approval($id){

        $users = DB::table('approval_for_risk_assessment_for_cost_involved')

            ->select('approval_for_risk_assessment_for_cost_involved.approval_status','approval_for_risk_assessment_for_cost_involved.sub_department_id')
            ->where('approval_for_risk_assessment_for_cost_involved.request_id', $id)
            ->groupBy('approval_for_risk_assessment_for_cost_involved.sub_department_id')
            ->get();


        return $users;

    }

   //  public function get_steering_commitee_member($r_id){

   //      $data = $member = DB::table('changerequests')
   //     ->select('plant_code','change_stage','stakeholder','changeType')
   //     ->where('request_id',$r_id)
   //     ->get();
       
   //    if($data[0]->change_stage ==1){
   //           $member = DB::table('tb_dynamicSteeringCommitee')
   //         ->select('tb_dynamicSteeringCommitee.steeringComm_id')
   //         ->where('plant_id',$data[0]->plant_code)
   //         ->where('change_stage',$data[0]->change_stage)
   //         ->where('stakeholder',$data[0]->stakeholder)
   //         ->where('change_type',$data[0]->changeType)
   //         ->get();
   //     }else{
   //         $member = DB::table('tb_dynamicSteeringCommitee')
   //         ->select('tb_dynamicSteeringCommitee.steeringComm_id')
   //         ->where('plant_id',$data[0]->plant_code)
   //         ->where('change_stage',$data[0]->change_stage)
   //         ->where('stakeholder',$data[0]->stakeholder)
   //         ->get();
   //      }
       
   //     $mem = explode(',', $member[0]->steeringComm_id);
   //     $cnt = count($mem);
   
   //      $allmember=[];
   //     if(!empty($mem)){
   //   for($i=0;$i<$cnt;$i++) {
           
   //          $allmember[]  = array(
   //                  'name' => $this->getSteerCommName($mem[$i]),
   //                  'sub_department_id' =>$this->getSubDept($mem[$i],$r_id),
   //                  'approval_status' => $this->getAppStatus($mem[$i],$r_id)
   //           );
   //     }
       
   // }

      
   //     return $allmember;

   //  }

    public function get_steering_commitee_member($r_id){

       $data = $member = DB::table('changerequests')
       ->select('plant_code','change_stage','stakeholder','changeType')
       ->where('request_id',$r_id)
       ->get();
      $allmember=[];
      if($data[0]->change_stage ==1){
             $member = DB::table('request_progress_status')
           ->select('assigned_to')
           ->where('request_id',$r_id)
           ->where('status',88)
           ->get();
      if(!empty($member)){
       
        foreach ($member as $value) { 
       
                $allmember[]  = array(
                        'name' => $this->getSteerCommName($value->assigned_to),
                        'sub_department_id' =>$this->getSubDept($value->assigned_to,$r_id),
                        'approval_status' => $this->getAppStatus($value->assigned_to,$r_id)
                 );
           }
       }
       }else{
        $allmember=[];
       }
  
       return $allmember;

    }

    public function getSteerCommName($id){
        $steerCommitee = DB::table('tb_users')
         ->select('first_name','last_name')
         ->where('tb_users.id',$id)
         ->get();
         $mem= [];
         foreach ($steerCommitee as $row) {
            $mem[] = array(
                'name' => $row->first_name." ".$row->last_name, 
                );
         }
         return $mem;


    }

    public function getSubDept($userId,$id){
        $users = DB::table('approval_for_risk_assessment_for_cost_involved')
            ->select('sub_department_id')
            ->where('request_id', $id)
            ->where('user_id', $userId)
            ->get();
            $mem = [];

            foreach ($users as $row) {
            $mem[] = array(
                'sub_department_id' => $row->sub_department_id, 
                );
         }

            return $mem;

    }
    public function getAppStatus($userId,$id){
        $users = DB::table('approval_for_risk_assessment_for_cost_involved')
            ->select('approval_status','comment')
            ->where('request_id', $id)
            ->where('user_id', $userId)
            ->get();

            $mem = [];
            foreach ($users as $row) {
            $mem[] = array(
                'approval_status' => $row->approval_status, 
                 'comment' => $row->comment, 
                );
        }
            return $mem;

    }

    public function get_responsibility_to_get_customer_approval($id){

        $responsible_person = DB::table('Customer_Communication_Decision')
            ->leftJoin('tb_users', 'Customer_Communication_Decision.user_id', '=', 'tb_users.id')
            ->select('tb_users.first_name','tb_users.last_name')
            ->where('Customer_Communication_Decision.request_id', $id)
            ->orderBy('Customer_Communication_Decision.id','desc')
            ->first();

        return $responsible_person;

    }

    function get_all_atachments($list_id,$request_id)
    {

        $attachments = DB::table('Customer_Communication_list_attachments')
            ->select('Customer_Communication_list_attachments.*')
            ->where('list_id', $list_id)
            ->where('request_id',$request_id)
            ->get();

        $purpose = [];

        foreach ($attachments as $attachment) {
            $purpose[] = array(
               // 'attachment_id' => $attachment->id,
                'doc_name' => $attachment->doc_name,
                'comment'   =>$attachment->comment
            );

        }


        return $purpose;


    }

    function get_customer_approval_list($customer_id,$request_id){

        $lists = DB::table('Customer_Communication_list')
            ->leftJoin('customer', 'Customer_Communication_list.description', '=', 'customer.CustomerId')
            ->select('Customer_Communication_list.*', 'customer.FirstName', 'customer.LastName', 'customer.CustomerId')
            ->where('request_id', $request_id)
            ->where('decision','!=',0)
            ->where('Customer_Communication_list.description',$customer_id)
            ->get();

        $data=array();
        foreach ($lists as $list) {

            $data= array(
                'FirstName' => $list->FirstName,
                'LastName' => $list->LastName,
                'attachments' => $this->get_all_atachments($list->id,$request_id),



            );
        }

        return $data;


    }

    public function get_cust_data_attachments($request_id)
    {

        $user_type=Session::get('gid');

        $query = DB::table('changerequests_customer')
            ->select('changerequests_customer.*')
            ->where('request_id', $request_id);
        if(isset($user_type)  && !empty($user_type) &&($user_type!=1)){
            $query->where('flag', 0);
        }
        $users=	$query->get();
        $purpose=array();
        foreach($users as $user){
            $purpose[]=array(

                'customer_approval_attachment_status'=>$this->get_customer_approval_list($user->customer_id,$request_id),

            );

        }

        return $purpose;

    }

    public function get_verification_status($id){

      $customer_verification = DB::table('activity_completion_sheet_verify')

            ->select('activity_completion_sheet_verify.status')
            ->where('activity_completion_sheet_verify.request_id', $id)
             ->orderBy('activity_completion_sheet_verify.activity_completion_sheet_verify_id','desc')
            ->get();

        return $customer_verification;
    }

    /**
     * @param $id
     * @return mixed
     */


    public function view_search_result($id) {
      
        if(Session::get('uid') == 1){
          $result = 0;
        }else{
          $result=$this->count_hide_data($id);
        }
        //hide functionality
     

        if($result!=1) {
            $query = DB::table('changerequests')
                //  ->leftJoin('customer', 'changerequests.customer_id', '=', 'customer.CustomerId')
                ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
                ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
                ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
                ->leftJoin('plant_code as dispatch', 'changerequests.dispatch_loc', '=', 'dispatch.plant_id')
                ->leftJoin('add_update_initial_sheet', 'changerequests.request_id', '=', 'add_update_initial_sheet.request_id')
                ->leftJoin('request_progress_status', 'changerequests.request_id', '=', 'request_progress_status.request_id')
                ->leftJoin('tb_users as user1', 'changerequests.Approval_Authority', '=', 'user1.id')
                ->leftJoin('tb_users as user2', 'changerequests.initiator_id', '=', 'user2.id')
                ->leftJoin('horizontal_deployment', 'changerequests.request_id', '=', 'horizontal_deployment.request_id')
                 ->leftJoin('tb_stakeholder','tb_stakeholder.id','=','changerequests.stakeholder')
                 ->leftJoin('tb_projectMaster', 'tb_projectMaster.id', '=', 'changerequests.proj_code')
                 ->leftJoin('tb_businessMaster', 'tb_businessMaster.id', '=', 'changerequests.business')
                  ->leftJoin('tbl_chage_sub_type', 'changerequests.change_sub_type', '=', 'tbl_chage_sub_type.sub_type_id')
                ->select('changerequests.*', 'tb_stakeholder.*','changerequests.status as cmstatus','tb_projectMaster.*', 'changerequests.request_id as r_id','changerequests.plant_code as plant', 'tb_departments.d_name', 'subdepartments.sub_dep_name','tb_change_stage.stage_name', 'user1.first_name as authority1', 'user1.last_name as authority2', 'user2.first_name as authority_1', 'user2.last_name as authority_2', 'tbl_change_type.change_type_name', 'plant_code.plant_code', 'horizontal_deployment.*', 'add_update_initial_sheet.selected as indexlevel', 'add_update_initial_sheet.currentTime as impdate','tbl_chage_sub_type.*','tbl_chage_sub_type.sub_type_name as type_name','tb_businessMaster.busi_code as busi','changerequests.change_stage as cr_stage','dispatch.plant_code as dispatchloc')
                ->orderBy('changerequests.request_id', 'DESC')
                ->orderBy('horizontal_deployment.created', 'DESC')
                ->where('changerequests.request_id', '=', $id);
            

            //$userjobs
            $users = $query->get();
            $user = $users[0];
            

            if ($user->impdate == '') {

                $user_created_data = '---';
            } else {

                $user_created_data = Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
            }


            // foreach ($users as $user){
            $data['userjobs'] = array(
                'request_id' => $user->r_id,
                'initiator_id' => $user->initiator_id,
                'remark' => $user->remark,
                'business' => $user->busi,
                'authority_name' => $user->authority1 . ' ' . $user->authority2,
                'initiator_name' => $user->authority_1 . ' ' . $user->authority_2,

                'emp_id' => $user->emp_id,
                'dep_id' => $user->dep_id,
                'sub_dep_id' => $user->sub_dep_id,
                'changeType' => $user->changeType,
                'changeSubType' => $this->getSubType($user->r_id),
                'change_stage' => $user->change_stage,
                'stakeholder'   =>$user->name,
                'project_code'  =>$user->project_code,
                'customers' => $this->get_request_customers($user->r_id),
                'change_purpose' => $this->get_assigned_task_purpose($user->r_id),
                'Approval_Authority' => $user->Approval_Authority,
                'plant_code' => $user->plant_code,
                'dispatchloc' => $user->dispatchloc,
                'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                 'count_request_is_remark' => $this->getClosecomment($id),
                'remark' => $user->remark,
                'created_date' => $this->get_custom_date($user->dt),
                'status' => $user->status,
                'd_name' => $user->sub_dep_name,
                'sub_dep_name' => $user->request_id,
                'stage_name' => $user->stage_name,
                //  'user_role' => $user->user_role,
                'before_after_attachement' => $this->get_before_after_attachment_file($user->r_id),
                'ptrDocument'       =>$this->get_ptrDocumet($user->r_id),
                'get_change_request_attachment' => $this->get_change_request_attachment($user->r_id),
                'count_request_is_rejected' => $this->get_count_request_is_rejected($id),
                'index_level' => $user->indexlevel,
                'impdate' => $user_created_data,
                'final_closer' => $this->admin_closer_status($user->r_id),
                'steering_committee_approval' => $this->get_steering_committee_approval($user->r_id),
                'steering_commitee_member' => $this->get_steering_commitee_member($user->r_id),
                'responsibility_to_get_customer_approval' => $this->get_responsibility_to_get_customer_approval($user->r_id),
                'customer_approval_attachment' => $this->get_cust_data_attachments($user->r_id),
                'verification_status' => $this->get_verification_status($user->r_id),
                'customer_to_be_communicated' => $this->get_customer_to_be_communicated($user->r_id),
                'hd' => $this->get_hd($user->r_id),
                'response_date' => $this->get_custom_date($user->projected_close_date),
                'hodApproveComment' => $this->getComment($user->r_id),
                'change_type_name' => $user->change_type_name,
                'horizontal_deployment_comment' => $user->comment,
                'horizontal_deployment_status' => $user->status,
                'horizontal_deployment_reason' => $this->get_hd($user->r_id),
                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->r_id, $user->cmstatus),

                'teamleader' => $this->get_team_leader_name($user->r_id),
                'totalcost' => $this->get_total_cost($user->r_id),
                'totcostperpiece' =>$this->get_total_cost_perpiece($user->r_id),
                'close_details' => $this->get_close_details($user->r_id),
                'cooapprovalstatus'=>$this->get_coo_approval_status($user->r_id),
                'custComDec'=>$this->check_customer_communication($user->r_id),
                'actual_date'=>$this->get_actual_date($user->r_id),
                'prjMgrComment' =>$this->getprjMgrComment($user->r_id),
                'projrct_mgr'=>$this->get_overallRisk_authority($user->cr_stage,$user->plant,$user->stakeholder,$user->proj_code),


            );


            $parts = DB::table('tbl_parts_info')
                ->select('tbl_parts_info.*')
                ->where('tbl_parts_info.request_ids', '=', $id)->get();
            $data['parts'] = $parts;
             
            return $data;
        }else{
            $status_=1;


        $data['userjobs'] = array(

            'result'=>$status_,

        );
       

           return $data;
        }


    }
    public function getprjMgrComment($r_id){
        $data=DB::table('approval_risk_assessment_from_admin')
              ->select('apprve_comment')
              ->where('request_id',$r_id)
              ->orderBy('id','desc')
              ->first();
              if(!empty($data)){
                return $data->apprve_comment;
              }
    }

    
public function getSubType($r_id){
         $data=DB::table('changerequests')
              ->select('change_sub_type')
              ->where('request_id',$r_id)
              ->get();

              $type_id=explode(',',$data[0]->change_sub_type);
             
             foreach ($type_id as $key) {
                
            $data1[]=DB::table('tbl_chage_sub_type')
              ->select('sub_type_name')
              ->where('sub_type_id',$key)
              ->get();
             }
             return $data1;

    }

    public function get_total_cost_perpiece($id){
        $users = DB::table('tb_risk_assessment_points')
                ->select(DB::raw('SUM(tb_risk_assessment_points.piececost) as total'))
                ->where('tb_risk_assessment_points.request_id', $id)
                //->where('tb_updatesheet_dep_team.team_member', $member)
                ->get();
            return $users[0]->total;
    }

 

    public function view_search_result_by_dashboard($id) {
      
        
        //hide functionality
     

       
            $query = DB::table('changerequests')
                //  ->leftJoin('customer', 'changerequests.customer_id', '=', 'customer.CustomerId')
                ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
                ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
                ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
                 ->leftJoin('plant_code as dispatch', 'changerequests.dispatch_loc', '=', 'dispatch.plant_id')
                ->leftJoin('add_update_initial_sheet', 'changerequests.request_id', '=', 'add_update_initial_sheet.request_id')
                ->leftJoin('request_progress_status', 'changerequests.request_id', '=', 'request_progress_status.request_id')
                ->leftJoin('tb_users as user1', 'changerequests.Approval_Authority', '=', 'user1.id')
                ->leftJoin('tb_users as user2', 'changerequests.initiator_id', '=', 'user2.id')
                ->leftJoin('horizontal_deployment', 'changerequests.request_id', '=', 'horizontal_deployment.request_id')
                 ->leftJoin('tb_stakeholder','tb_stakeholder.id','=','changerequests.stakeholder')
                 ->leftJoin('tb_projectMaster', 'tb_projectMaster.id', '=', 'changerequests.proj_code')
                ->leftJoin('tb_businessMaster', 'tb_businessMaster.id', '=', 'changerequests.business')
                ->leftJoin('tbl_chage_sub_type', 'changerequests.change_sub_type', '=', 'tbl_chage_sub_type.sub_type_id')
               ->select('changerequests.*', 'tb_stakeholder.*','changerequests.status as cmstatus','tb_projectMaster.*', 'changerequests.request_id as r_id','changerequests.plant_code as plant', 'tb_departments.d_name', 'subdepartments.sub_dep_name', 'tb_change_stage.stage_name', 'user1.first_name as authority1', 'user1.last_name as authority2', 'user2.first_name as authority_1', 'user2.last_name as authority_2', 'tbl_change_type.change_type_name', 'plant_code.plant_code', 'horizontal_deployment.*', 'add_update_initial_sheet.selected as indexlevel', 'add_update_initial_sheet.currentTime as impdate','tbl_chage_sub_type.sub_type_name as type_name','tb_businessMaster.busi_code as busi','changerequests.change_stage as cr_stage','dispatch.plant_code as dispatchloc')
         ->orderBy('changerequests.request_id', 'DESC')
                ->orderBy('horizontal_deployment.created', 'DESC')
                ->where('changerequests.request_id', '=', $id);
           


            //$userbsjo
            $users = $query->get();
            $user = $users[0];
            //print_r($user);exit;

            // print_r($users);exit;

            if ($user->impdate == '') {

                $user_created_data = '---';
            } else {

                $user_created_data = Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
            }


            // foreach ($users as $user){
            $data['userjobs'] = array(
                'request_id' => $user->r_id,
                'initiator_id' => $user->initiator_id,
                'remark' => $user->remark,
                'authority_name' => $user->authority1 . ' ' . $user->authority2,
                'initiator_name' => $user->authority_1 . ' ' . $user->authority_2,
                'dispatchloc' => $user->dispatchloc,
                'emp_id' => $user->emp_id,
                'dep_id' => $user->dep_id,
                'business' => $user->busi,
                'changeSubType' => $this->getSubType($user->r_id),
                'sub_dep_id' => $user->sub_dep_id,
                'changeType' => $user->changeType,
                'change_stage' => $user->change_stage,
                'stakeholder'   =>$user->description,
                'project_code'  =>$user->project_code,
                'customers' => $this->get_request_customers($user->r_id),
                'change_purpose' => $this->get_assigned_task_purpose($user->r_id),
                'Approval_Authority' => $user->Approval_Authority,
                'plant_code' => $user->plant_code,
                'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                'remark' => $user->remark,
                'created_date' => $this->get_custom_date($user->dt),
                'status' => $user->status,
                'd_name' => $user->sub_dep_name,
                'sub_dep_name' => $user->request_id,
                'stage_name' => $user->stage_name,
                //  'user_role' => $user->user_role,
                'before_after_attachement' => $this->get_before_after_attachment_file($user->r_id),
                'ptrDocument'       =>$this->get_ptrDocumet($user->r_id),
                'get_change_request_attachment' => $this->get_change_request_attachment($user->r_id),
                'count_request_is_rejected' => $this->get_count_request_is_rejected($id),
                
                'index_level' => $user->indexlevel,
                'impdate' => $user_created_data,
                'final_closer' => $this->admin_closer_status($user->r_id),
                'steering_committee_approval' => $this->get_steering_committee_approval($user->r_id),
                'steering_commitee_member' => $this->get_steering_commitee_member($user->r_id),
                'responsibility_to_get_customer_approval' => $this->get_responsibility_to_get_customer_approval($user->r_id),
                'customer_approval_attachment' => $this->get_cust_data_attachments($user->r_id),
                'verification_status' => $this->get_verification_status($user->r_id),
                'customer_to_be_communicated' => $this->get_customer_to_be_communicated($user->r_id),
                'hd' => $this->get_hd($user->r_id),
                'response_date' => $this->get_custom_date($user->projected_close_date),
                'hodApproveComment' => $this->getComment($user->r_id),


                //  'impdate' => Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y'),
                'change_type_name' => $user->change_type_name,
                'horizontal_deployment_comment' => $user->comment,
                'horizontal_deployment_status' => $user->status,
                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->r_id, $user->cmstatus),

                'teamleader' => $this->get_team_leader_name($user->r_id),
                'totalcost' => $this->get_total_cost($user->r_id),
                'totcostperpiece' =>$this->get_total_cost_perpiece($user->r_id),
                'close_details' => $this->get_close_details($user->r_id),
                'cooapprovalstatus'=>$this->get_coo_approval_status($user->r_id),
                'prjMgrComment' =>$this->getprjMgrComment($user->r_id),

                'projrct_mgr'=>$this->get_overallRisk_authority($user->cr_stage,$user->plant,$user->stakeholder,$user->proj_code),

            );


            $parts = DB::table('tbl_parts_info')
                ->select('tbl_parts_info.*')
                ->where('tbl_parts_info.request_ids', '=', $id)->get();
            $data['parts'] = $parts;

            return $data;
        


    }
    public function get_close_details($request_id){
        $data = DB::table('request_progress_status')

            ->select('request_progress_status.id','request_progress_status.next_url')
            ->where('request_progress_status.request_id', $request_id)
            ->where('request_progress_status.assigned_to', Session::get('uid'))
            ->where('request_progress_status.close', '=', 0)
            ->first();

        return $data;

    }

    public function getComment($r_id){
        $comment = DB::table('changerequests')
        ->select('comment')
        ->where('request_id',$r_id)
        ->get();
        return $comment[0]->comment;
    }

        public function get_hd($request_id){

            $hd = DB::table('horizontal_deployment')

                ->select('horizontal_deployment.status','horizontal_deployment.comment','horizontal_deployment.reason')
                ->where('horizontal_deployment.request_id', $request_id)
                ->orderBy('horizontal_deployment.horizontal_deployment_id','asc')

                ->first();
           // print_r($hd);exit;

            return $hd;
        }

    function get_customer_communication_list($customer_id,$request_id){
        $customer_communicated = DB::table('Customer_Communication_list')
            ->leftJoin('customer', 'Customer_Communication_list.description', '=', 'customer.CustomerId')
            ->select('customer.FirstName','customer.LastName','customer.CustomerId')
            ->where('Customer_Communication_list.request_id', $request_id)
            ->where('Customer_Communication_list.decision','!=',0)//done changes in this for new change request uncommented this line
            ->where('Customer_Communication_list.description',$customer_id)

            ->get();

        $purpose = [];

        foreach ($customer_communicated as $value) {
            $purpose = array('first_name' => $value->FirstName,
                'last_name' => $value->LastName,

            );

        }

        return $purpose;

    }

        public function get_customer_to_be_communicated($request_id){

            $user_type=Session::get('gid');

            $query = DB::table('changerequests_customer')
                ->select('changerequests_customer.*')
                ->where('request_id', $request_id);
            if(isset($user_type)  && !empty($user_type) &&($user_type!=1)){
                $query->where('flag', 0);
            }
            $users=	$query->get();
            $purpose=array();

           // print_r($users);exit;
            foreach($users as $user){


                $purpose[]=array(

                    'customer_name'=>$this->get_customer_communication_list($user->customer_id,$request_id),

                );

            }

            return $purpose;

        }
        function get_total_cost($id){

            $users = DB::table('tb_risk_assessment_points')
                ->select(DB::raw('SUM(tb_risk_assessment_points.cost) as total'))
                ->where('tb_risk_assessment_points.request_id', $id)
                //->where('tb_updatesheet_dep_team.team_member', $member)
                ->get();

            return $users[0]->total;
        }

    public function view_risk_asses_data($id){

        $risks1 = DB::table('subdepartments')->select('sub_dep_id','department_id','sub_dep_name')->where('department_id', '=', 2)->get();

        // print_r($risks1);exit;
        $data=array();
        foreach ($risks1 as  $value) {

            $data[]=array('sub_dep_id' =>$value->sub_dep_id ,
                'department_id' =>$value->department_id ,
                'sub_dep_name' =>$value->sub_dep_name ,
                'riskdata' =>$this->get_risk_by_request_id($value->sub_dep_id,$value->sub_dep_id),

            );


        }
            return $data;
    }


    public function view_risk_team_member($request_id){

        $risks1 = DB::table('subdepartments')->select('sub_dep_id','department_id','sub_dep_name')->where('department_id', '=', 2)->get();

        // print_r($risks1);exit;
        $data=array();
        foreach ($risks1 as  $value) {

            $data[]=array('sub_dep_id' =>$value->sub_dep_id ,
                            'sub_dep_name' =>$value->sub_dep_name ,
                          'team_member_name' =>$this->team_member_by_request($request_id,$value->sub_dep_id) ,


            );


        }
        return $data;
    }
    public function getClosecomment($id){
        $users = DB::table('permanent_reject_close')
        ->select(DB::raw('COUNT(permanent_reject_close.id) as total'))

        ->where('permanent_reject_close.request_id', $id)
        //->where('request_progress_status.assigned_to', Session::get('uid'))
        ->get();
        if($users[0]->total >=1){
            $Name = DB::table('permanent_reject_close')
                ->select('permanent_reject_close.remark')
                ->where('permanent_reject_close.request_id', $id)
                //->where('request_progress_status.assigned_to', Session::get('uid'))
                ->get();
            return $Name[0]->remark;
        }else{
            return "";
        }
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


     public function check_customer_communication($r_id){
      $lists = DB::table('Customer_Communication_list')
            ->select('Customer_Communication_list.decision')
            ->where('request_id', $r_id)
            ->get();
          return $lists;
    }
   
        
     public function get_overallRisk_authority($stage,$plant,$stakeholder,$project){

      $riskAppuser=array();
        if($stage==1){
          $riskApp = DB::table('tb_documentverifyconfig')
                    ->select('riskmember')
                    ->where('change_stage',$stage)
                    ->where('stakeholder',$stakeholder)
                    ->where('plant_code',$plant)
                    ->get();
          // print_r($plant);exit();
          $riskAppuser=$riskApp[0]->riskmember;
        }else if($stage==2 && $project!=''){
          $riskApp = DB::table('tb_projectMaster')
                    ->select('project_manager')
                    ->where('id',$project)
                    ->get();
          $riskAppuser=$riskApp[0]->project_manager;
        }else{
          $riskApp = DB::table('tb_project_manager')
                    ->select('proj_mgr_id')
                    ->where('change_stage',$stage)
                    ->where('stakeholder',$stakeholder)
                    ->where('plant_code',$plant)
                    ->get();
          $riskAppuser=$riskApp[0]->proj_mgr_id;
        }
        if(!empty($riskAppuser)){
        $manager=DB::table('tb_users')
                ->select('first_name','last_name')
                ->where('id',$riskAppuser)
                ->get();

        return $data=$manager[0]->first_name.' '.$manager[0]->last_name;
      }else{
        return '';
      }
    }     
   
	public function helpindex()
    {
            return View::make('scm/help_page');
       
    }     
   

   public function helpdownloaddev(){
    $filename =Config::get('app.site_root').'uploads/help/DevelopementMannual.pdf';
    
    header("Content-type: application/pdf");

    header("Content-Length: " . filesize($filename));

    readfile($filename);
       exit;

   }

  
  public function helpdownloadser(){
    $filename =Config::get('app.site_root').'uploads/help/SeriesMannual.pdf';
    
    header("Content-type: application/pdf");

    header("Content-Length: " . filesize($filename));

    readfile($filename);
       exit;

   }
    public function helpdownloadsummaryrepot(){
     $filename =Config::get('app.site_root').'uploads/help/summaryinterpretationreport.pdf';
    
    header("Content-type: application/pdf");

    header("Content-Length: " . filesize($filename));

    readfile($filename);
       exit;
   }

	
}	