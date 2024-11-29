<?php
use Carbon\Carbon;
class ChangerequestController extends BaseController
{


    public function index()
    {
        $u_id = Session::get('uid');

        $role = DB::table('tb_users')
                ->select('group_id')
                ->where('id',$u_id)
                ->get();
    
        $myArray = explode(',', $role[0]->group_id);
        $cnt = count($myArray);
       $flag =0;
        for($i=0;$i<$cnt;$i++) {

            if($myArray[$i]==2){
              $flag =1;
               break;
            }
        }
        if($flag==0){
              return Redirect::to('dashboard')
                      ->with('message', SiteHelpers::alert('error','You do not have authority to initiate new change request.'))
                      ->withInput();  
            }

        if ($this->check_permission(1)) {
            return View::make('changes/change_request');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }


    }

    /**
     * @return mixed
     * code for download attachments of anykind
     */

    public function download(){


        $filename=$_REQUEST['filename'];
        $path=$_REQUEST['path'];
        $file = Config::get('app.site_root').'uploads/'.$path.'/'.$filename;
        return Response::download($file, $filename, ['Content-Type: '.mime_content_type($file)]);

        return Response::download($file, 'canvas1.png', ['Content-Type: '.mime_content_type($filename)]);

    }

    public function change_password()
    {
        return View::make('change_password');

    }

    public function change_user_password()
    {//echo "inside";exit;

        if (Input::get('password') != '') {

            DB::table('tb_users')
                ->where('id', Session::get('uid'))

                ->update(['password' => Hash::make(Input::get('password')),
                ]);
            return Redirect::to('');

        }else{
            return Redirect::back()->with('error', 'Something went wrong');

        }
    }


    public function get_chart1_result($type)
    {

        $users = DB::table('changerequests')
            ->select(DB::raw('COUNT(changeType) as total_sales'))
            ->where('changerequests.changeType', $type)
            ->where('changerequests.initiator_id', Session::get('uid'))
            ->get();

        return $users[0]->total_sales;

    }

    public function get_chart1()
    {

        $users = DB::table('tbl_change_type')
            ->select('tbl_change_type.*')
            ->get();


        $data = array();
        foreach ($users as $value) {

            $data['name'][] =
                $value->change_type_name;

        }

        // print_r($data);exit;
        foreach ($users as $value) {

            $data['val'][] =
                $this->get_chart1_result($value->change_type_id);

        }

        return $data;


    }


    public function get_chart2_result($type)
    {

        $users = DB::table('changerequests')
            ->select(DB::raw('COUNT(change_stage) as total_sales'))
            ->where('changerequests.change_stage', $type)
            ->where('changerequests.initiator_id', Session::get('uid'))
            //->groupBy('changerequests.status')
            ->get();

        return $users[0]->total_sales;

    }


    public function get_hod_by_dep()
    {
        return $users = DB::table('tb_users')
            ->select('id', 'first_name', 'last_name')
            ->where('department', '=', Session::get('dep_id'))
            ->whereRaw("find_in_set(4,group_id)")
            ->get();
    }

    public function get_chart2()
    {

        $users = DB::table('tb_change_stage')
            ->select('tb_change_stage.*')
            ->get();

        foreach ($users as $value) {

            $data['name'][] =
                $value->stage_name;


        }
        foreach ($users as $value) {

            $data['val'][] =
                $this->get_chart2_result($value->change_stage_id);

        }
        return $data;
    }

    public function get_chart3_result($type)
    {

        $users = DB::table('changerequests_purposechange')
            ->leftJoin('changerequests', 'changerequests.request_id', '=', 'changerequests_purposechange.request_id')
            ->select(DB::raw('COUNT(purpose_id) as total_sales'))
            ->where('changerequests_purposechange.purpose_id', $type)
            ->where('changerequests.initiator_id', Session::get('uid'))
            //->groupBy('changerequests.status')
            ->get();

            
            /*
                    Below comment code is for departmen

             $users = DB::table('changerequests')
       
            ->select(DB::raw('COUNT(request_id) as total_sales'))
            ->where('changerequests.dep_id', $type)
            ->where('changerequests.initiator_id', Session::get('uid'))
          
            ->get();*/

        return $users[0]->total_sales;

    }

    public function get_chart3()
    {

        $users = DB::table('changerequest_purpose')
            ->select('changerequest_purpose.*')
            ->get();

         
        foreach ($users as $value) {

            $data['name'][] =
                $value->changerequest_purpose;

        }
        foreach ($users as $value) {

            $data['val'][] =
                $this->get_chart3_result($value->id);

        }

        return $data;
    }


    public function department()
    {

        //Returns All departments
        $departments = DB::table('tb_departments')->select('d_id', 'd_name')->where('d_id','!=',11)->get();

        return $departments;


    }

    public function department_for_rp()
    {
        $departments = DB::table('tb_departments')
            ->select('d_id', 'd_name')
            ->where('tb_departments.d_id','!=',11)
            ->get();

        return $departments;
    }

    public function provisionOfDept(){
         $provisionOfDept = DB::table('tb_dept_addRemove')
            ->select('tb_dept_addRemove.dept_add')
            ->get();
            if($provisionOfDept[0]->dept_add == 'Yes'){
              return 1;
            }else{
              return 0;
            }
    }
    public function checkTaskCom($id,$id1){
      if($id1 == 0){
         return 0;
      }
      $uid=Session::get('uid');
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1 && ($uid != 1 || $uid != 114)){
            return 1;
         }else{
            return 0;
         }
    }


    public function removeDept($r_id,$dept_id){

          DB::table('add_updated_risk_assessment_sheet')
          ->where('user_department',$dept_id)
          ->where('r_id', $r_id)
          ->delete();

           DB::table('tb_updatesheet_dep_team')
          ->where('department',$dept_id)
          ->where('request_id', $r_id)
          ->delete();
    }

    public function removeDeptByAdmin($r_id,$dept_id,$mem_id){
     
      DB::table('add_updated_risk_assessment_sheet')
          ->where('user_department',$dept_id)
          ->where('r_id', $r_id)
          ->delete();

           DB::table('tb_updatesheet_dep_team')
          ->where('department',$dept_id)
          ->where('request_id', $r_id)
          ->delete();

         DB::table('request_progress_status')
            ->where('request_id', $r_id)
            ->where('assigned_to',$mem_id)
            ->where('status',6)
            ->delete();
     
            $deptAtReq=DB::table('tracking_sheet_info')->where('request_id',$r_id)->where('status',3)->get();
          foreach ($deptAtReq as $row) {
           $findDept = explode(" ",$row->process);
            foreach ($findDept as $dept) {
              if($dept_id == $dept){
               DB::table('tracking_sheet_info')
              ->where('process','RiskAssessment By '.$dept_id)
              ->where('request_id', $r_id)
              ->delete();
               DB::table('tracking_sheet_info')
              ->where('process','Risk Assessment Approval by '.$dept_id.' HOD')
              ->where('request_id', $r_id)
              ->delete();
              }
            }
          }
           
    }

    

    public function checkAdminAddDept($id){
      

                 $hod_approval = DB::table('add_updated_risk_assessment_sheet')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('add_updated_risk_assessment_sheet.r_id', $id)
                ->where('add_updated_risk_assessment_sheet.user_dep_hod_approve',0)
                ->get();

                  if($hod_approval[0]->total >=1){

                    return 1;
                  }else{
                    return 0;
                  }

    }
    public function checkDeptAvl($r_id,$dept_id){

            $add_team = DB::table('tb_updatesheet_dep_team')
                ->select(DB::raw('COUNT(update_sheet_dep_id) as total'))
                ->where('tb_updatesheet_dep_team.request_id', $r_id)
                ->where('tb_updatesheet_dep_team.department',$dept_id)
                ->get();
              
                $risk_asess = DB::table('add_updated_risk_assessment_sheet')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('add_updated_risk_assessment_sheet.r_id', $r_id)
                ->where('add_updated_risk_assessment_sheet.user_department',$dept_id)
                ->get();
                if($add_team[0]->total == 0 && $risk_asess[0]->total == 0 ){
                  return 1;
                }else{
                  return 0;
                }
    }

    public function addDepartment($id,$dept_id){

      DB::table('tb_updatesheet_dep_team')->insert(
          array(
              'request_id' => $id,
              'department' => $dept_id,
              'fetch_status'=>1,
              'created'=>date('Y-m-d H:i:s')

          )
      );
 

        DB::table('add_updated_risk_assessment_sheet')->insert(
          array(
              'r_id' => $id,
              'user_department' => $dept_id,
          )
      );

       
    }

    public function addDeptAndUser($r_id,$dept_id,$user_id){
      $code = DB::table('changerequests')
              ->select('proj_code')
              ->where('request_id',$r_id)
              ->get();
      $p_code = DB::table('tb_projectMaster')
                ->select('project_code')
                ->where('id',$code[0]->proj_code)
                ->get();

      DB::table('tb_updatesheet_dep_team')->insert(
                array(
                  'request_id' => $r_id,
                  'department' => $dept_id,
                  'team_member' =>$user_id,
                  'fetch_status'=> 2,
                  'created'=>date('Y-m-d H:i:s')

                )
              );
              DB::table('add_updated_risk_assessment_sheet')->insert(
                array(
                    'r_id' => $r_id,
                    'user_id' => $user_id,
                    'user_department' => $dept_id,
                    'status'=>1,
                    'created'=>date('Y-m-d H:i:s')

                )
              );
    }

     public function addDepartmentByAdmin($id,$dept_id,$userId,$initiator){


     
   $add= DB::table('add_updated_risk_assessment_sheet')->insert(
          array(
              'r_id' => $id,
               'user_id' => $userId,
              'user_department' => $dept_id,
              'status'=>1

          )
      );

      DB::table('tb_updatesheet_dep_team')->insert(
          array(
              'request_id' => $id,
              'team_member' => $userId,
              'department' => $dept_id,
              'fetch_status'=>2,
              'created'=>date('Y-m-d H:i:s')

          )
      );

      
         
          $data2 = DB::table('add_updated_risk_assessment_sheet')
            ->select('add_updated_risk_assessment_sheet.user_id')
            ->where('add_updated_risk_assessment_sheet.r_id', $id)
            ->get();
           
          $checkReqSend=DB::table('add_update_initial_sheet')
          ->select(DB::raw('COUNT(initial_sheet_id) as total'))
          ->where('request_id',$id)
          ->get();
         

          foreach ($data2 as $row) {
            $userId = DB::table('request_progress_status')
                ->select(DB::raw('count(request_progress_status.id) as total'))
              ->where('request_progress_status.request_id',$id)
              ->where('request_progress_status.assigned_to',$row->user_id)
              ->where('status',6)
              ->get();
             
              if($userId[0]->total == 0){
                $userNotIn[] =$row->user_id;
              }
          }


        
          if(!empty($userNotIn)){

        $cnt= count($userNotIn);
          if($checkReqSend[0]->total != 0){
           for($i=0;$i<$cnt;$i++){
                $message='Pending clearance of Risk Assessment point activities from CFT Dept.';
                  $url = 'changes/update-risk-analysis-sheet/';
                     DB::table('request_progress_status')->insert(
              array('assigned_by' => $initiator,
                  'assigned_to' => $userNotIn[$i],
                  'request_id' => $id,
                  'created_date' => date('Y-m-d H:i:s'),
                  'message' => $message,
                  'next_url'=>$url,
                  'status'=> 6,
                  )
              );
           }
         }
        

          } 
       //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',3)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));


                
                
                 $riskAssDept='RiskAssessment By '.$dept_id;
                if($checkReqSend[0]->total != 0){
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>$riskAssDept,
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>3
                        )
                    );
                }
               
                  

                  //----end code for tracking Sheet----



        
    }

    public function adminProvisionForDept($id){
      $add_team = DB::table('approval_risk_assessment_from_admin')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('approval_risk_assessment_from_admin.request_id', $id)
                ->get();
                echo $add_team[0]->total;
    }

    public function department1($id)
    {
            $getData = DB::table('changerequests')
                ->select('plant_code','stakeholder','change_stage','proj_code')
                  ->where('request_id',$id)
                                ->get();


              $proj_code = DB::table('tb_projectMaster')
                          ->select('project_code')
                          ->where('id',$getData[0]->proj_code)
                          ->get();

                          $users = DB::table('tb_updatesheet_dep_team')
                      ->select(DB::raw('COUNT(update_sheet_dep_id) as total'))
                      ->where('tb_updatesheet_dep_team.request_id', $id)
                      ->get();


            if($getData[0]->change_stage == 2 && $getData[0]->proj_code != ""){
              
              if ($users[0]->total) {
                  
                  return $this->fetch_department($id);
              }else{
               
              return $this->getDeptAsPerProject($proj_code[0]->project_code,$id);
              }
            } else{
             
                $dept = DB::table('tb_dynamicDepartment')
                    ->select('department')
                    ->where('plantCode',$getData[0]->plant_code)
                    ->where('stakeholder',$getData[0]->stakeholder)
                     ->where('change_stage',$getData[0]->change_stage)
                    ->get();

                   
                    if ($users[0]->total) {
                        
                        return $this->fetch_department($id);
                    } else {
                      
         
                        $this->fetch_all_department($id,$dept);
                        $this->fetch_all_department_1($id,$dept);
                        return $this->fetch_department($id);
                        
                    }
            }                        



    }

    public function checkProject($r_id){
      $stage = DB::table('changerequests')
                ->select('change_stage')
                ->where('request_id',$r_id)
                ->get();
                if($stage[0]->change_stage == 1){
                  return 1;
                }else{
                  return 0;
                }
    }

    public function custCommunication($r_id){
       $data = DB::table('changerequests')
       ->select('proj_code','change_stage','plant_code','stakeholder')
       ->where('request_id',$r_id)
       ->get();

       if($data[0]->change_stage == 2 && $data[0]->proj_code != ""){

          $custComm = DB::table('tb_projectMaster')
                      ->select('cust_comm_repres')
                      ->where('id',$data[0]->proj_code)
                      ->get();
                      $user=$custComm[0]->cust_comm_repres;
        }
        if($data[0]->change_stage == 2 && $data[0]->proj_code == ""){
          $custComm = DB::table('tb_dynamicCustComm')
                      ->select('CC_member')
                      ->where('CC_stakeholder',$data[0]->stakeholder)
                      ->where('CC_plantCode',$data[0]->plant_code)
                      ->where('CC_changeStage',$data[0]->change_stage)
                      ->get();
                      $user = $custComm[0]->CC_member;
        }              
       
 
       $custMem = array();
       if(!empty($custComm)){
        $custMem = DB::table('tb_users')
                   ->select('id','first_name','last_name')
                  ->where('id',$user)
                  ->where('active',1)
                  ->get();
                }
                  return $custMem;

    }

    public function sub_department()
    {

        //Returns All departments
        $departments = DB::table('subdepartments')->select('sub_dep_id', 'sub_dep_name')->where('department_id', 2)->get();

        return $departments;


    }


    public function show($d_id)
    {

        //Returns sub-department of selected departmemt
        return $users = DB::table('subdepartments')->select('sub_dep_id', 'department_id', 'sub_dep_name')->where('department_id', '=', $d_id)->get();

    }


    public function customers()
    {


        $customers = DB::table('customer')
        ->select('CustomerId', 'FirstName', 'LastName')
        ->where('status','active')
        ->get();

        return $customers;


    }

    public function customers_for_edit(){

         $customers = DB::table('customer')->select('CustomerId', 'FirstName', 'LastName')->get();

          foreach ($customers as $data) {
            $res[] = array(
                'CustomerId' => $data->CustomerId,
                'FirstName' => $data->FirstName.' '.$data->LastName ,
             
            );
        }

    

        return $res;


    }

    public function customers_comm($id)
    {

        $customers = DB::table('changerequests_customer')
            ->leftJoin('customer', 'customer.CustomerId', '=', 'changerequests_customer.customer_id')
            ->select('customer.CustomerId', 'customer.FirstName', 'customer.LastName')
            ->where('changerequests_customer.request_id', $id)
            ->get();

        return $customers;


    }

    public function change_stage()
    {

        //Returns All change stage
        $data = DB::table('tb_change_stage')
        ->select('change_stage_id', 'stage_name')
        ->where('status','active')
        ->get();

        return $data;

        //return $query = DB::table('subdepartments')->select('sub_dep_id','department_id','sub_dep_name')->where('department_id', '=', $d_id)->get();

    }

    public function get_sub_dep($id = NULL)
    {

        //Returns sub-department of selected departmemt
        $query = DB::table('subdepartments')->select('sub_dep_id', 'department_id', 'sub_dep_name');

        if (isset($id) && !empty($id)) {
            $query->where('sub_dep_id', '=', $id);
        }

        $users = $query->get();
        return $users;

    }


    public function change_request_status($id)
    {

        DB::table('changerequests')
            ->where('request_id', $id)
            ->update(['status' => 2, 'created_date' => date('Y-m-d H:i:s')]);

        return 'success';

    }

    /*
     *
     *
     * Function to add New change Request
     *
     */

    public function checkAllCond(){
      $input = (object)Input::all();
     
      $dept = 'dept';
      $dept1 = 'Department matrix is not defined for this type of change.Please contact administrator@1';
      $riskApp = 'appMem';
     $riskApp1 = 'project manager is not defined for this type of change.Please contact administrator@1';
      $steer = 'steer';
      $steer1 = 'Steering commitee is not defined for this type of change.Please contact administrator@1';
       $custComm = 'custComm';
      $custComm1 = 'Customer communication authority is not defined for this type of change.Please contact administrator@1';
       $horizDep = 'horizDep';
      $horizDep1 = 'Horizontal deployment authority is not defined for this type of change.Please contact administrator@1';
      $error = 'noerror';
      
      
      if(isset($input->request_id)){
        $stage_id=$input->change_stage_id;
      }else{
        $stage_id=$input->change_stage_id;
      }


               

      if($dept == 'dept'){
          
          if($stage_id == 2 && $input->project_code == "" || $stage_id == 1){
          $department = DB::table('tb_dynamicDepartment')
                          ->select('department')
                          ->where('change_stage',$stage_id)
                          ->where('plantCode',$input->plant_id)
                          ->where('stakeholder',$input->stakeholder)
                          ->get();
            }
                        
              if($stage_id == 2 && $input->project_code != ""){
                $department = array(
                    'value' => 'avl'
                  );
              }
              
                 if(empty($department)){
                    return $dept1;
                  }
      } 

      if($riskApp == 'appMem'){

              if($stage_id == 1){
               
              $riskAppMem = DB::table('tb_dept_addRemove')
                              ->select('RiskAssApprove')
                              ->get();
               }
              if($stage_id == 2 && $input->project_code == ""){

                $riskAppMem = DB::table('tb_project_manager')
             
              ->select('proj_mgr_id')
              ->where('change_stage',$stage_id)
              ->where('plant_code',$input->plant_id)
              ->where('stakeholder',$input->stakeholder)
              ->get();
              }
              
              if($stage_id == 2 && $input->project_code != ""){
                $riskAppMem = array(
                    'value' => 'avl'
                  );
              }
              
                 if(empty($riskAppMem)){
                    return $riskApp1;
                  }else{

                  }
      }


      if($steer == 'steer'){
        // print_r($stage_id);exit;
        if($stage_id==1){
          $steering = DB::table('tb_dynamicSteeringCommitee')
                        ->select('steeringComm_id')
                        ->where('change_stage',$stage_id)
                        ->where('plant_id',$input->plant_id)
                        ->where('stakeholder',$input->stakeholder)
                        ->where('change_type',$input->changeType)
                        ->get();

                 if(empty($steering)){
                    return $steer1;
                  }
           }else{
        $steering = DB::table('tb_dynamicSteeringCommitee')
                        ->select('steeringComm_id')
                        ->where('change_stage',$stage_id)
                        ->where('plant_id',$input->plant_id)
                        ->where('stakeholder',$input->stakeholder)
                        ->get();

                 if(empty($steering)){
                    return $steer1;
                  }
           }  

        }     
     


      if($custComm == 'custComm'){
        
        if($stage_id == 2 && $input->project_code == "" || $stage_id == 1 ){
        $ccomm = DB::table('tb_dynamicCustComm')
                        ->select('CC_member')
                        ->where('CC_changeStage',$stage_id)
                        ->where('CC_plantCode',$input->plant_id)
                        ->where('CC_stakeholder',$input->stakeholder)
                        ->get();
                      }


             if($stage_id == 2 && $input->project_code != ""){
                $ccomm = array(
                    'value' => 'avl'
                  );
              }
              
                 if(empty($ccomm)){
                  
                    return $custComm1;
                  }
      }


      if($horizDep == 'horizDep'){

          if($stage_id == 1){
                $horDeplz = DB::table('tb_dept_addRemove')
                                ->select('horizDeploy')
                                ->get();
          }
          if($stage_id == 2 && $input->project_code == ""){

            
          $horDeplz = DB::table('tb_project_manager')
                ->select('proj_mgr_id')
               ->where('change_stage',$stage_id)
              ->where('plant_code',$input->plant_id)
              ->where('stakeholder',$input->stakeholder)
              ->get();
                 

          }

           if($stage_id == 2 && $input->project_code != ""){
                $horDeplz = array(
                    'value' => 'avl'
                  );
              }
              
          if(empty($horDeplz)){
                return $horizDep1;
          }
      }
      if($error == 'noerror'){
        return 0;
      }
   }

   public function checkUserActive($id){
      $data = DB::table('tb_users')
              ->select('id')
              ->where('active',1)
              ->where('id',$id)
              ->get();

              if(!empty($data)){
              return 1;exit;
              }else{
               return 0;exit;
              }
   }

    public function addrequest()
    { //exit;


        if (Request::isJson()) {

            $input = (object)Input::all();
           // print_r($input);exit();
         
            if(isset($input->remark)){
             
               $remark=$input->remark;
            }else{
              $remark='';
            }

            if (isset($input->sub_dep_id)) {
                $sub_dep = $input->sub_dep_id;
            } else {
                $sub_dep = '';
            }

            if($input->dt==''){

                $d_t='--';
            }else{

                $date1 = explode('/', $input->dt);
                $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];


            }

          $typeId='';
            if(isset($input->sub_type_id)){
           $typeId = implode(',',$input->sub_type_id);
         }

            
          if (isset($input->dispatch_loc)) {
                $dispatch_loc = $input->dispatch_loc;
            } else {
                $dispatch_loc = '';
            } 
          
            
            if($input->project_code !=""){
               $stage = DB::table('tb_projectMaster')
                      ->select('change_stage')
                      ->where('id',$input->project_code)
                      ->get();
                      $stage_id =$stage[0]->change_stage;
                }else{
                    $stage_id=$input->change_stage_id;
                }

            

               
		 $changeType=explode('@',$input->changeType);
              DB::table('changerequests')->insert(
                  array(//'initiator_name' => $input->initiator_name,
                      'initiator_id' => Session::get('uid'),
                      // 'emp_id' => $input->emp_id,
                      'dep_id' => $input->dep_id,
                      'sub_dep_id' => $sub_dep,
                      // 'currentTime' => $input->currentTime,
                      'changeType' => $changeType[0],
                      'change_sub_type' => $typeId,
                      'change_stage' => $stage_id,
                     
                      'Approval_Authority' => $input->Approval_Authority,
                      'plant_code' => $input->plant_id,
                      'stakeholder' => $input->stakeholder,
                      'business' => $input->business,
                       'proj_code' => $input->project_code,
                      'Purpose_Modification_Details' => $input->Purpose_Modification_Details,
                      'remark' => $remark,
                      'created_date' => date('Y-m-d H:i:s'),
                      'status' => $input->type,
                      'dt'=> $d_t,
                      'dispatch_loc'=>$dispatch_loc,


                  )
              );
             $last_id = DB::getPdo()->lastInsertId();

           
              
              $fileName =explode(",", $input->uploadFileName);
              
         if(!empty($input->uploadFileName)){
         
            foreach($fileName as $file){
               // print_r($file);
              $file = str_replace('"', "", $file);
              $file = str_replace('[', "", $file);
              $file = str_replace(']', "", $file);
             DB::table('change_request_existing_attachments')->insert(
                        array(
                            'request_id' => $last_id,
                            'attached_file'   =>$file,
                        )
                    );
            }
          }
        

              foreach ($input->multi_part as $value) {
                  DB::table('tbl_parts_info')->insert(
                      array('part_number' => $value['extNumber'],
                          'part_name' => $value['extName'],
                          'request_ids' => $last_id

                      )
                  );

              }


           

              if (is_array($input->changerequest_purpose)) {
                  foreach ($input->changerequest_purpose as $value) {
                      DB::table('changerequests_purposechange')->insert(
                          array(
                              'purpose_id' => $value,
                              'request_id' => $last_id

                          )
                      );

                  }
              } else {

                  DB::table('changerequests_purposechange')->insert(
                      array(
                          'purpose_id' => $input->multi_purpose,
                          'request_id' => $last_id

                      )
                  );
              }

              if (is_array($input->multi_user)) {
                  foreach ($input->multi_user as $value) {
                      DB::table('changerequests_customer')->insert(
                          array(
                              'customer_id' => $value,
                              'request_id' => $last_id

                          )
                      );

                  }
              } else {
                  DB::table('changerequests_customer')->insert(
                      array(
                          'customer_id' => $input->multi_user,
                          'request_id' => $last_id

                      )
                  );

              }

          }


            if ($input->type == 1) {
	


                $message = "New Change request is Pending for approval from Department HOD";

                 //----start code for tracking Sheet----
                $data=DB::table('tracking_sheet_date_param')->where('process','Hod Approval')->get();
                $Date=date('Y-m-d');
                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $last_id,
                          'process'     =>'Hod Approval',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>1
                        )
                    );

                 
                 //----end code for tracking Sheet----

                $url = 'changes/change_status/';
                  $last_id_req=$this->create_noticication_status($input->Approval_Authority, $last_id, $message, $url, $input->type);


                $data1 = $this->get_user_info_by_id($input->Approval_Authority);
                $initiator_id = $this->get_initiator_id_by_request_id($last_id);
                $initiator_name = $this->get_user_info_by_id($initiator_id);

                $request_id=$last_id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                $assignedto=$initiator_name['name'];
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'task_assigned_to'=>$assignedto,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);

				

                if($this->check_netconnection())
                {

                    Mail::send('emails/email-template', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });
                }else{



                }

            }

    }

    public function dashboard_counter_bak()
    {
        $users = DB::table('changerequests')
            ->select(DB::raw('COUNT(status) as total_sales'))
            // ->where('changerequests.status',$type)
            ->groupBy('changerequests.status')
            ->get();

        return $users;


    }
     

    public function changeReqUpload(){
      

         if (!empty($_FILES)) {


            $imageNameArray = array();

            $destinationPath = 'uploads/changeRequest'; // upload path
        
          

            if (Input::hasFile('uploadFile')) {

               
                $names = Input::file('uploadFile');
                
                foreach($names as $file) {

                    //$extension = $file->getClientOriginalName();
                  //$extension = preg_replace('/[^A-Za-z0-9\-]/', '', $file->getClientOriginalName());

                   $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $file->getClientOriginalName());

                    $filename = rand(11111, 99999) . '-' . $extension; 

                 
            array_push($imageNameArray, $filename);
                    
                    $upload_success = $file->move($destinationPath, $filename);
                }

                echo json_encode($imageNameArray); exit();



            }
        }
    }
        
 public function PtrDocUpload(){
  $file =Input::hasFile('uploadFile');
         if (!empty($_FILES)) {
            $imageNameArray = array();

            $destinationPath = 'uploads/Document'; // upload path
            if (Input::hasFile('uploadFile')) {
                $names = Input::file('uploadFile');
                
                foreach($names as $file) {

                    $extension = $file->getClientOriginalName();

                    $filename = rand(11111, 99999) . '-' . $extension; 

                 
            array_push($imageNameArray, $filename);
                    
                    $upload_success = $file->move($destinationPath, $filename);
                }

                echo json_encode($imageNameArray); exit();



            }
        }
    }
    

    public function getStockInfo($id){
        $file = DB::table('add_update_initial_sheet')
            ->select('add_update_initial_sheet.*')
            ->where('add_update_initial_sheet.request_id',$id)
            ->get();
        return $file;



    }
    public function deleteAttachment(){

        if (!empty(Input::get('dele_existAttachment'))) {

        $id=Input::get('attach_id');

            DB::table('change_request_existing_attachments')->where('id', $id)->delete();

            $filename = Config::get('app.site_root') . '/uploads/changeRequest/' . Input::get('ExistingAttach_name');
           

            if (File::exists($filename)) {
                File::delete($filename);
            }
            return Redirect::back()->with('success', 'You have posted successfully');
        }
    }
    public function deleteChangeReqAttachment($id,$name){
   
      
            DB::table('change_request_existing_attachments')->where('id', $id)->delete();

            $filename = Config::get('app.site_root') . '/uploads/changeRequest/' .$name;
           

            if (File::exists($filename)) {
                File::delete($filename);
            }

            echo 'Success';
            // return Redirect::back()->with('success', 'You have posted successfully');
       
    
    }


    public function dashboard_counter1($type)
    {
        $users = DB::table('changerequests')
            ->select(DB::raw('COUNT(status) as count'))
            ->where('changerequests.status', $type)
            ->where('changerequests.initiator_id', Session::get('uid'))
            ->groupBy('changerequests.status')
            ->get();

        if ($users) {
            return $users[0]->count;
        } else {
            return '0';
        }


    }

    public function dashboard_counter2()
    {
        $users = DB::table('changerequests')
            ->select(DB::raw('COUNT(status) as count'))
            ->where('changerequests.status', 1)
            ->where('changerequests.rej_status', 3)
            ->where('changerequests.initiator_id', Session::get('uid'))
            ->groupBy('changerequests.status')
            ->get();

        if ($users) {
            return $users[0]->count;
        } else {
            return '0';
        }


    }


    public function dashboard_counter()
    {
        $user['initiated'] = $this->dashboard_counter1(1);
        $user['accepted'] = $this->dashboard_counter1(2);
        $user['drafted'] = $this->dashboard_counter1(5);
        $user['rejected'] = $this->dashboard_counter2();

        return $user;


    }

    public function parts_list()
    {
        $parts = DB::table('parts_info')->select('id', 'Part_Name', 'Auto_Part_number')->get();

        return $parts;
    }

    public function assigned_task_to_me_dashboard()
    {
        $data = [];


        $users = DB::table('request_progress_status')
            ->leftJoin('changerequests', 'request_progress_status.request_id', '=', 'changerequests.request_id')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->leftJoin('tb_users as att', 'changerequests.initiator_id', '=', 'att.id')
            ->leftJoin('add_update_initial_sheet', 'request_progress_status.request_id', '=', 'add_update_initial_sheet.request_id')
            ->select('changerequests.*', 'changerequests.status as cmstatus','changerequests.created_date as new_date','add_update_initial_sheet.currentTime as impdate','tb_change_stage.stage_name', 'tbl_change_type.change_type_name', 'request_progress_status.*', 'att.first_name', 'att.last_name', 'request_progress_status.message as message', 'request_progress_status.id as close_id')
            ->groupBy('request_progress_status.request_id')
            //  ->distinct('changerequests.request_id')
            ->orderBy('request_progress_status.created_date', 'DESC')
            ->where('request_progress_status.close', '=', 0)
            // ->where('request_progress_status.assigned_to', '=', Session::get('uid'))
            ->whereRaw("find_in_set(" . Session::get('uid') . ",request_progress_status.assigned_to)")
              ->distinct('changerequests.request_id')
              ->distinct('request_progress_status.request_id')

            ->get();

  // print_r($users);exit;

        foreach ($users as $user) {
        // print_r($user);exit;
            if($user->impdate==''){

                $user_created_data='--';

            }else{

                $user_created_data= Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
            }
            if($user->comment==''){

                $comment='--';
            }else{

                $comment=$user->comment;
            }


            $data[] = array(
                'request_id' => $user->request_id,
                // 'request_info'=>$this->get_request_info_by_id($user->request_id),
                // 'initiator_info' => $this->get_user_info_by_id($user->initiator_id),
                'initiator_name' => $user->first_name . ' ' . $user->last_name,
                //'emp_id' =>$user->emp_id,
                // 'dep_id' =>$user->dep_id,
                // 'sub_dep_id' =>$user->sub_dep_id,
                'changeType' => $user->changeType,
                'change_stage' => $user->change_stage,
                'customers' => $this->get_request_customers($user->request_id),
                'change_purpose' => $this->get_assigned_task_purpose($user->request_id),
                'Approval_Authority' => $user->Approval_Authority,

                // 'plant_code' => $user->plant_code,
                'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                'remark' => $user->remark,
                'created_date' => Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
                'status' => $user->message,
                'comment'=>$comment,
                //'d_name' => $user->sub_dep_name,
                // 'sub_dep_name' => $user->request_id,
                'stage_name' => $user->stage_name,
                // 'user_role' => $user->user_role,
                'impdate' => $user_created_data,
              //  'impdate' => Carbon::createFromFormat('Y-d-m H:i:s', $user_created_data)->format('d.m.Y'),
                'change_type_name' => $user->change_type_name,
                'user_info' => $this->get_user_info_by_id($user->assigned_by),
                'last_status' => $this->get_last_status($user->request_id),
                'next_url' => $user->next_url,
                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->new_date, $user->request_id, $user->cmstatus),
                'cmNoSearch' => $this->generate_cm_no_search($user->change_type_name, $user->new_date, $user->request_id),
                'close_id' => $user->close_id
            );
            // print_r($data['customers']);exit;
        }
        // 

        return $data;

    }

    public function assigned_task_to_me()
    {
      return 0;
//         $data = [];


//         $users = DB::table('request_progress_status')
//             ->leftJoin('changerequests', 'request_progress_status.request_id', '=', 'changerequests.request_id')
//             ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
//             ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
//             ->leftJoin('tb_users as att', 'changerequests.initiator_id', '=', 'att.id')
//             ->leftJoin('add_update_initial_sheet', 'request_progress_status.request_id', '=', 'add_update_initial_sheet.request_id')
//             ->select('changerequests.*', 'changerequests.status as cmstatus','add_update_initial_sheet.currentTime as impdate','tb_change_stage.stage_name', 'tbl_change_type.change_type_name', 'request_progress_status.*', 'att.first_name', 'att.last_name', 'request_progress_status.message as message', 'request_progress_status.id as close_id')
//             ->groupBy('request_progress_status.request_id')
//             //  ->distinct('changerequests.request_id')
//             ->orderBy('request_progress_status.created_date', 'DESC')
//             ->where('request_progress_status.close', '=', 0)
//             // ->where('request_progress_status.assigned_to', '=', Session::get('uid'))
//             ->whereRaw("find_in_set(" . Session::get('uid') . ",request_progress_status.assigned_to)")
//               ->distinct('changerequests.request_id')
//               ->distinct('request_progress_status.request_id')

//             ->get();

// //print_r($users);exit;



//         foreach ($users as $user) {

//             if($user->impdate==''){

//                 $user_created_data='--';
//             }else{

//                 $user_created_data= Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
//             }
//             if($user->comment==''){

//                 $comment='--';
//             }else{

//                 $comment=$user->comment;
//             }


//             $data[] = array(
//                 'request_id' => $user->request_id,
//                 // 'request_info'=>$this->get_request_info_by_id($user->request_id),
//                 // 'initiator_info' => $this->get_user_info_by_id($user->initiator_id),
//                 'initiator_name' => $user->first_name . ' ' . $user->last_name,
//                 //'emp_id' =>$user->emp_id,
//                 // 'dep_id' =>$user->dep_id,
//                 // 'sub_dep_id' =>$user->sub_dep_id,
//                 'changeType' => $user->changeType,
//                 'change_stage' => $user->change_stage,
//                 'customers' => $this->get_request_customers($user->request_id),
//                 'change_purpose' => $this->get_assigned_task_purpose($user->request_id),
//                 'Approval_Authority' => $user->Approval_Authority,

//                 // 'plant_code' => $user->plant_code,
//                 'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
//                 'remark' => $user->remark,
//                 'created_date' => Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
//                 'status' => $user->message,
//                 'comment'=>$comment,
//                 //'d_name' => $user->sub_dep_name,
//                 // 'sub_dep_name' => $user->request_id,
//                 'stage_name' => $user->stage_name,
//                 // 'user_role' => $user->user_role,
//                 'impdate' => $user_created_data,
//               //  'impdate' => Carbon::createFromFormat('Y-d-m H:i:s', $user_created_data)->format('d.m.Y'),
//                 'change_type_name' => $user->change_type_name,
//                 'user_info' => $this->get_user_info_by_id($user->assigned_by),
//                 'last_status' => $this->get_last_status($user->request_id),
//                 'next_url' => $user->next_url,
//                 'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->request_id, $user->cmstatus),
//                 'cmNoSearch' => $this->generate_cm_no_search($user->change_type_name, $user->created_date, $user->request_id),
//                 'close_id' => $user->close_id
//             );
//         }
//         return $data;

    }


    /**
     * @return array
     */
    public function checkPrjApply($business){
      $data = DB::table('tb_businessMaster')
              ->select('project_apply')
              ->where('id',$business)
              ->get();
              if($data[0]->project_apply == 'Yes'){
                return 1;
              }else{
                return 0;
              }
    }

    function get_hod_by_user_dep()
    {

        $users  = DB::table('tb_users')
            ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
            ->whereRaw("find_in_set(4,tb_users.group_id)")
            ->where('tb_users.sub_department',Session::get('sub_dep_id'))
            ->where('tb_users.active',1)
            ->where('tb_users.department',Session::get('dep_id'))
            ->get();

        if($users==[]){//echo "blank";exit;

            $data = DB::table('tb_users')
                ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
                ->where('tb_users.department', '=', Session::get('dep_id'))
                ->where('tb_users.active',1)
                ->whereRaw("find_in_set(4,tb_users.group_id)")
                ->get();

            $res = array();
            foreach ($data as $point) {
                $res[] = array(
                    'name' => $point->first_name . ' ' . $point->last_name,
                    'email' => $point->email,
                    'id' => $point->id,
                );
            }
            return $res;




        }else {


            $res = array();
            foreach ($users as $point) {
                $res[] = array(
                    'name' => $point->first_name . ' ' . $point->last_name,
                    'email' => $point->email,
                    'id' => $point->id,
                );
            }
            return $res;

        }
        /*
         *
         * Old code below
         *
         */

       /* $data = DB::table('tb_users')
            ->select('tb_users.id', 'tb_users.first_name', 'tb_users.last_name')
            ->where('tb_users.department', '=', Session::get('dep_id'))
            // ->whereIn('tb_users.group_id','=',[5])
            ->whereRaw("find_in_set(4,tb_users.group_id)")
            ->get();

        return $data;*/


    }


    public function assigned_task_by_me_dashboard()
    {


        $query =DB::table('request_progress_status')
            ->leftJoin('changerequests', 'request_progress_status.request_id', '=', 'changerequests.request_id')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->leftJoin('tb_users as att', 'changerequests.initiator_id', '=', 'att.id')
            ->leftJoin('add_update_initial_sheet', 'changerequests.request_id', '=', 'add_update_initial_sheet.request_id')
            ->select('changerequests.*','changerequests.created_date as new_date', 'changerequests.status as cmstatus','add_update_initial_sheet.currentTime as impdate', 'tb_change_stage.stage_name', 'tbl_change_type.change_type_name', 'request_progress_status.*', 'att.first_name', 'att.last_name', 'request_progress_status.message as message', 'request_progress_status.id as close_id')
            ->groupBy('request_progress_status.request_id')
            //  ->distinct('changerequests.request_id')
            ->orderBy('request_progress_status.created_date', 'DESC');
            //  ->whereIn('request_progress_status.close', '=',[0,2]);
            $query->whereIn('request_progress_status.close',[0,2]);

           // ->where('changerequests.status', '<>', 20)
            // ->where('request_progress_status.assigned_to', '=', Session::get('uid'))
            //  ->whereRaw("find_in_set(".Session::get('uid').",request_progress_status.assigned_to)")
              $query ->distinct('changerequests.request_id');
            //  ->distinct('request_progress_status.request_id')
           $query ->where('changerequests.initiator_id', Session::get('uid'));
           $users=$query->get();

       // echo '<pre>';

        //print_r($users);exit;

            $data = [];
            foreach ($users as $user) {


                if ($user->impdate == '') {

                    $user_created_data = '--';
                } else {

                    $user_created_data = Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
                }


                $data[] = array(
                    'request_id' => $user->request_id,
                    // 'request_info'=>$this->get_request_info_by_id($user->request_id),
                    // 'initiator_info' => $this->get_user_info_by_id($user->initiator_id),
                    'initiator_name' => $user->first_name . ' ' . $user->last_name,
                    //'emp_id' =>$user->emp_id,
                    // 'dep_id' =>$user->dep_id,
                    // 'sub_dep_id' =>$user->sub_dep_id,
                    'changeType' => $user->changeType,
                    'change_stage' => $user->change_stage,
                    'customers' => $this->get_request_customers($user->request_id),
                    'change_purpose' => $this->get_assigned_task_purpose($user->request_id),
                    'Approval_Authority' => $user->Approval_Authority,
                    // 'plant_code' => $user->plant_code,
                    'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                    'remark' => $user->remark,
                    'created_date' => Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
                    'status' => $user->message,
                    'impdate' => $user_created_data,
                    //'d_name' => $user->sub_dep_name,
                    // 'sub_dep_name' => $user->request_id,
                    'stage_name' => $user->stage_name,
                    // 'user_role' => $user->user_role,
                    'change_type_name' => $user->change_type_name,
                    'user_info' => $this->get_user_info_by_id($user->assigned_to),
                    'last_status' => $this->get_last_status($user->request_id),
                    //  'next_url'=>$user->next_url,
                    'cmNo' => $this->generate_cm_no($user->change_type_name, $user->new_date, $user->request_id, $user->cmstatus),
                    'cmNoSearch' => $this->generate_cm_no_search($user->change_type_name, $user->new_date, $user->request_id)

                );
            }
            return $data;

    }

    public function assigned_task_by_me()
    {

      return 0;
       //  $query =DB::table('request_progress_status')
       //      ->leftJoin('changerequests', 'request_progress_status.request_id', '=', 'changerequests.request_id')
       //      ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
       //      ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
       //      ->leftJoin('tb_users as att', 'changerequests.initiator_id', '=', 'att.id')
       //      ->leftJoin('add_update_initial_sheet', 'changerequests.request_id', '=', 'add_update_initial_sheet.request_id')
       //      ->select('changerequests.*', 'changerequests.status as cmstatus','add_update_initial_sheet.currentTime as impdate', 'tb_change_stage.stage_name', 'tbl_change_type.change_type_name', 'request_progress_status.*', 'att.first_name', 'att.last_name', 'request_progress_status.message as message', 'request_progress_status.id as close_id')
       //      ->groupBy('request_progress_status.request_id')
       //      //  ->distinct('changerequests.request_id')
       //      ->orderBy('request_progress_status.created_date', 'DESC');
       //      //  ->whereIn('request_progress_status.close', '=',[0,2]);
       //      $query->whereIn('request_progress_status.close',[0,2]);

       //     // ->where('changerequests.status', '<>', 20)
       //      // ->where('request_progress_status.assigned_to', '=', Session::get('uid'))
       //      //  ->whereRaw("find_in_set(".Session::get('uid').",request_progress_status.assigned_to)")
       //        $query ->distinct('changerequests.request_id');
       //      //  ->distinct('request_progress_status.request_id')
       //     $query ->where('changerequests.initiator_id', Session::get('uid'));
       //     $users=$query->get();

       // // echo '<pre>';

       //  //print_r($users);exit;

       //      $data = [];
       //      foreach ($users as $user) {


       //          if ($user->impdate == '') {

       //              $user_created_data = '--';
       //          } else {

       //              $user_created_data = Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
       //          }


       //          $data[] = array(
       //              'request_id' => $user->request_id,
       //              // 'request_info'=>$this->get_request_info_by_id($user->request_id),
       //              // 'initiator_info' => $this->get_user_info_by_id($user->initiator_id),
       //              'initiator_name' => $user->first_name . ' ' . $user->last_name,
       //              //'emp_id' =>$user->emp_id,
       //              // 'dep_id' =>$user->dep_id,
       //              // 'sub_dep_id' =>$user->sub_dep_id,
       //              'changeType' => $user->changeType,
       //              'change_stage' => $user->change_stage,
       //              'customers' => $this->get_request_customers($user->request_id),
       //              'change_purpose' => $this->get_assigned_task_purpose($user->request_id),
       //              'Approval_Authority' => $user->Approval_Authority,
       //              // 'plant_code' => $user->plant_code,
       //              'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
       //              'remark' => $user->remark,
       //              'created_date' => Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
       //              'status' => $user->message,
       //              'impdate' => $user_created_data,
       //              //'d_name' => $user->sub_dep_name,
       //              // 'sub_dep_name' => $user->request_id,
       //              'stage_name' => $user->stage_name,
       //              // 'user_role' => $user->user_role,
       //              'change_type_name' => $user->change_type_name,
       //              'user_info' => $this->get_user_info_by_id($user->assigned_to),
       //              'last_status' => $this->get_last_status($user->request_id),
       //              //  'next_url'=>$user->next_url,
       //              'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->request_id, $user->cmstatus),
       //              'cmNoSearch' => $this->generate_cm_no_search($user->change_type_name, $user->created_date, $user->request_id)

       //          );
       //      }
       //      return $data;

    }

    public function saved_cr_by_me()
    {

        /*  $users = DB::table('changerequests')
              // ->leftJoin('customer', 'changerequests.customer_id', '=', 'customer.CustomerId')
              ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
              ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
              ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
              ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
              ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
              // ->leftJoin('changerequest_purpose', 'changerequests.change_purpose', '=', 'changerequest_purpose.id')
              ->leftJoin('tb_users', 'changerequests.Approval_Authority', '=', 'tb_users.id')
              ->leftJoin('tb_users as att', 'changerequests.initiator_id', '=', 'att.id')
              // ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
              ->select('changerequests.*', 'tb_departments.d_name', 'subdepartments.sub_dep_name', 'tb_change_stage.stage_name', 'tb_users.user_role', 'att.first_name', 'att.last_name', 'tbl_change_type.change_type_name', 'plant_code.plant_code')
              ->orderBy('changerequests.modified_date', 'DESC')
              ->where('changerequests.status', 5)
              ->where('changerequests.initiator_id', Session::get('uid'))
              ->get();

          */


        $users = DB::table('changerequests')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
            ->leftJoin('tb_users as att', 'changerequests.initiator_id', '=', 'att.id')
            ->select('changerequests.*', 'changerequests.created_date as new_date','tb_change_stage.stage_name', 'att.first_name', 'att.last_name', 'tbl_change_type.change_type_name')
            // ->select('changerequests.*', 'tb_change_stage.stage_name','tbl_change_type.change_type_name','request_progress_status.*','att.first_name', 'att.last_name')
            ->groupBy('changerequests.request_id')
            ->distinct('changerequests.request_id')
             ->orderBy('changerequests.created_date', 'DESC')
            ->where('changerequests.status', 5)
            ->where('changerequests.initiator_id', Session::get('uid'))
            ->get();
        $data = [];
        foreach ($users as $user) {
            $data[] = array(

                'request_id' => $user->request_id,
                // 'request_info'=>$this->get_request_info_by_id($user->request_id),
                // 'initiator_info' => $this->get_user_info_by_id($user->initiator_id),
                'initiator_name' => $user->first_name . ' ' . $user->last_name,
                //'emp_id' =>$user->emp_id,
                // 'dep_id' =>$user->dep_id,
                // 'sub_dep_id' =>$user->sub_dep_id,
                'changeType' => $user->changeType,
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
                'last_status' => $this->get_last_status($user->request_id),
                // 'next_url'=>$user->next_url,
                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->new_date, $user->request_id, $user->status),
                'cmNoSearch' => $this->generate_cm_no_search($user->change_type_name, $user->new_date, $user->request_id)
            );
        }
        return $data;


    }

    public function plantcode()
    {

        //Returns All plantcodes
        $plantcode = DB::table('plant_code')
        ->select('plant_id', 'plant_code', 'description')
        ->where('status','active')
        ->get();

        return $plantcode;


    }

    public function stakeholder()
    {

        //Returns All plantcodes
        $stakeholder = DB::table('tb_stakeholder')
        ->select('id', 'description','name')
        ->where('status','active')
        ->get();

        return $stakeholder;


    }

    public function projectMaster()
    {
        $projectMaster = DB::table('tb_projectMaster')
        ->select('id', 'project_code')
        ->get();
        return $projectMaster;
    }

    public function getProjectByStage($stage)
    {

      if($stage != 0){
       
        $projectMaster = DB::table('tb_projectMaster')
        ->select('id', 'project_code')
        ->where('change_stage',$stage)
        ->get();
        return $projectMaster;
      }else{
         
        $projectMaster = DB::table('tb_projectMaster')
        ->select('id', 'project_code')
        ->get();
        return $projectMaster;
      }
    }


    public function business()
    {
        $business = DB::table('tb_businessMaster')
        ->select('id', 'busi_code')
        ->where('status','active')
        ->get();
        return $business;
    }

    

    public function getStage($code){
       $stage = DB::table('tb_projectMaster')
        ->select('change_stage')
        ->where('id',$code)
        ->get();

        $data = DB::table('tb_change_stage')
        ->select('change_stage_id','stage_name')
        ->where('change_stage_id',$stage[0]->change_stage)
        ->get();

        $data1 = array(
            'change_stage_id' => $data[0]->change_stage_id,
            'stage_name'      => $data[0]->stage_name
          );

        return $data1;
    }


    public function changerequestModify()
    {

        //Returns All plantcodes
        $plantcode = DB::table('plant_code')->select('plant_id', 'plant_code', 'description')->get();

        return $plantcode;


    }

    public function purposechange()
    {

        //Returns All plantcodes
        $purposechange = DB::table('changerequest_purpose')
        ->select('id', 'changerequest_purpose')
        ->where('status','active')
        ->get();

        return $purposechange;


    }

    public function purposechange_for_edit()
    {

        //Returns All plantcodes
        $purposechange = DB::table('changerequest_purpose')
        ->select('id', 'changerequest_purpose')
          ->where('status','active')
        ->get();


        return $purposechange;

    }

    public function getcustMem($id){
      $data = DB::table('changerequests')
       ->select('change_stage','plant_code','stakeholder')
       ->where('request_id',$id)
       ->get();
      
       if($data[0]->change_stage == 1){
          $cust = DB::table('tb_dynamicCustComm')
                ->select('CC_member')
                ->where('CC_changeStage',$data[0]->change_stage)
                ->where('CC_plantCode',$data[0]->plant_code)
                ->where('CC_stakeholder',$data[0]->stakeholder)
                ->get();

       }   
       $custMem = array();
       if(!empty($cust)){
       $custMem = DB::table('tb_users')
                  ->select('id','first_name','last_name')
                  ->where('id',$cust[0]->CC_member)
                  ->where('active',1)
                  ->get();
                }
                  return $custMem;
    }

    public function getHorizDeploy($id){
      $data = DB::table('changerequests')
       ->select('change_stage','plant_code','stakeholder')
       ->where('request_id',$id)
       ->get();
      
       if($data[0]->change_stage == 1){
          $cust = DB::table('tb_dynamicHorizDeploy')
                ->select('member')
                ->where('change_stage',$data[0]->change_stage)
                ->where('plant_id',$data[0]->plant_code)
                ->where('stakeholder',$data[0]->stakeholder)
                ->get();

       }   
       $horizdply = array();
       if(!empty($cust)){
       $horizdply = DB::table('tb_users')
                  ->select('id','first_name','last_name')
                  ->where('id',$cust[0]->member)
                  ->where('active',1)
                  ->get();
                }
                  return $horizdply;
    }
    public function getdepartment($role_type)
    {

        return $this->get_user_by_role($role_type);

    }


    public function getdepartment1($id)
    {
      $res = [];

      $data = DB::table('changerequests')
                ->select('plant_code','stakeholder','change_stage')
                  ->where('request_id',$id)
                                ->get();
                                

      $custComm = DB::table('tb_dynamicCustComm')
        ->select('CC_member')
        ->where('CC_changeStage',$data[0]->change_stage)
        ->where('CC_stakeholder',$data[0]->stakeholder)
        ->where('CC_plantCode',$data[0]->plant_code)
        ->get();

      if(!empty($custComm)){
          $users  = DB::table('tb_users')
       
            ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
            ->where('id',$custComm[0]->CC_member)
            ->get();

      }
            if(!empty($users)){
        foreach($users as $point){
          $res[]=array(
            'name'=>$point->first_name.' '.$point->last_name,
            'email'=>$point->email,
            'user_id'=>$point->id,
          );
        }
      }
        return $res;

    }

    public function checkCustComm($id,$com){

      
      $data = DB::table('changerequests')
                ->select('plant_code','stakeholder','change_stage')
                  ->where('request_id',$id)
                                ->get();

        $steerComm = DB::table('tb_dynamicSteeringCommitee')
                    ->select('cust_comm_decision')
                    ->where('plant_id',$data[0]->plant_code)
                    ->where('change_stage',$data[0]->change_stage)
                    ->where('stakeholder',$data[0]->stakeholder)
                    ->get();
              $userId = Session::get('uid');
             if($userId === $steerComm[0]->cust_comm_decision){
              $custComm = '';
            
              if(!empty($data)){

                 $custComm = DB::table('tb_dynamicCustComm')
                ->select('CC_member')
                ->where('CC_changeStage',$data[0]->change_stage)
                ->where('CC_stakeholder',$data[0]->stakeholder)
                ->where('CC_plantCode',$data[0]->plant_code)
                ->get(); 
              
              }

           if(empty($custComm) && $com == 1){
             echo "1";exit;
            }else{
              echo "0";exit;
            }
          }

    }

   public function getchangetype()
    {

        //Returns All Change type
        $getchangetype = DB::table('tbl_change_type')->select('change_type_id', 'change_type_name','change_type_cust_mapping','change_type_part_mapping')->get();
        //print_r($getchangetype);exit;
        return $getchangetype;


    }

    public function getchangetype1($d_id)
    {

        //Returns All plantcodes
        $getchangetype = DB::table('tbl_change_type')->select('change_type_id', 'change_type_name')->get();

        return $getchangetype;


    }

    function change_status($id)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
              return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }else{   

          if ($this->check_permission(9) && $this->check_request_permission($id)) {

              return View::make('changes/change_status');
          } else {

              return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
          }
        }


    }

    public function recent_assigned_task_to_me()
    {
        $user_id = Session::get('uid');
        $data = array();

        $users = DB::table('changerequests')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->select('changerequests.*', 'tbl_change_type.change_type_name')
            ->orderBy('changerequests.modified_date', 'DESC')
            ->where('changerequests.initiator_id', $user_id)->take(5)
            ->get();

        foreach ($users as $user) {
            $data[] = array(

                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->request_id, $user->status),
                'cmNoSearch' => $this->generate_cm_no_search($user->change_type_name, $user->created_date, $user->request_id)
            );
        }
        return $data;


    }

    public function recent_assigned_task_by_me()
    {
        $user_id = Session::get('uid');
        $data = array();

        $users = DB::table('changerequests')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->select('changerequests.*', 'tbl_change_type.change_type_name')
            ->orderBy('changerequests.modified_date', 'DESC')
            ->where('changerequests.initiator_id', $user_id)->take(5)
            ->get();

        foreach ($users as $user) {
            $data[] = array(

                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->request_id, $user->status),
                'cmNoSearch' => $this->generate_cm_no_search($user->change_type_name, $user->created_date, $user->request_id)
            );
        }
        return $data;


    }

    public function get_request_info($id)
    {

        return $users = DB::table('changerequests')
            // ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            ->select('changerequests.*', 'tb_users.first_name', 'tb_users.first_name')
            ->where('changerequests.request_id', $id)
            ->get();

    }

    public function get_request_info_by_id($id)
    {


        $user = DB::table('changerequests')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->select('changerequests.request_id', 'tbl_change_type.change_type_name', 'changerequests.created_date', 'changerequests.status')
            ->where('changerequests.request_id', $id)
            ->get();

        return $this->generate_cm_no($user[0]->change_type_name, $user[0]->created_date, $user[0]->request_id, $user[0]->status);

    }

    public function get_request_info_by_id_for_status($id,$riskAssId)
    {


        $user = DB::table('request_progress_status')
            //    ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->select('request_progress_status.message')
            ->where('request_progress_status.request_id', $id)
            ->where('request_progress_status.assigned_to', $riskAssId)
            ->where('request_progress_status.close', '!=', 1)
            ->orderby('request_progress_status.id', 'ASC')
            ->get();
           
        if (!empty($user)) {
            return $user[0]->message;
        } else {
            return "completed by user";
        }

    }

    public function get_request_details($id)
    {

        $users = DB::table('changerequests')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            ->leftJoin('changerequest_purpose', 'changerequests.change_purpose', '=', 'changerequest_purpose.id')
            ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
            // ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            ->select('changerequests.request_id', 'changerequests.created_date', 'tb_change_stage.stage_name', 'tb_users.first_name', 'tb_users.last_name', 'tbl_change_type.change_type_name')
            ->where('changerequests.request_id', $id)
            ->get();


        /*
       $users = DB::table('changerequests')
            ->where('request_id', $id)
            ->get();
    */
        return $users;

    }

    public function edit_change_request()
    {
        $data = array(
            'request_id'  => "",
            'page'   => 'editByIni',

        );
         $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('');
         }else{  
          if ($this->check_session_set()) {
              return View::make('changes.change_request_edit')->with($data);
          }
        }
    }


    public function get_edit_change_request($id,$id1)
    {
        $users = DB::table('changerequests')
            ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
            ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            ->leftJoin('tb_stakeholder','tb_stakeholder.id','=','changerequests.stakeholder')
          ->leftJoin('tb_projectMaster', 'tb_projectMaster.id', '=', 'changerequests.proj_code')
          ->leftJoin('tb_businessMaster', 'tb_businessMaster.id', '=', 'changerequests.business')
            ->leftJoin('tbl_parts_info', 'changerequests.request_id', '=', 'tbl_parts_info.request_ids')
            ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
             ->leftJoin('tbl_chage_sub_type', 'changerequests.change_sub_type', '=', 'tbl_chage_sub_type.sub_type_id')
            ->select('changerequests.*','changerequests.status as changestatus', 'tb_departments.d_name', 'tbl_parts_info.part_number', 'tbl_parts_info.part_name', 'subdepartments.sub_dep_name', 'tb_change_stage.stage_name', 'tbl_change_type.change_type_name', 'tbl_change_type.change_type_cust_mapping', 'tbl_change_type.change_type_part_mapping', 'plant_code.plant_id', 'tb_users.*','tb_stakeholder.*','tb_projectMaster.project_code','tb_businessMaster.*')
            ->where('request_id', $id)
            ->get();

        $user = $users[0];

        // print_r($user);exit();
        $data= array(
            'request_id' => $user->request_id,
            'initiator_id' => $user->initiator_id,
            'initiator_name' => $user->first_name . ' ' . $user->last_name,
            'plant_id' => $user->plant_code,
            'emp_id' => $user->emp_id,
            'dep_id' => $user->dep_id,
            'sub_dep_id' => $user->sub_dep_id,
            'changeType' => $user->changeType.'@'.$user->change_type_cust_mapping.'@'.$user->change_type_part_mapping,
            'sub_type_id' =>$user->change_sub_type,
            'change_stage' => $user->change_stage,
            'customers_id' => $this->get_request_customers_edit($user->request_id),
            'customers_id_single' => $this->get_request_customers_edit_single($user->request_id),

            'Approval_Authority' => $this->get_dept_HOD($user->Approval_Authority),
            'Approval_Authority_id' =>$user->Approval_Authority,
            'plant_id' => $user->plant_code,
            'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
            'remark' => $user->remark,
            'part_number' => $user->part_number,
            'part_name' => $user->part_name,
            'change_purpose' => $this->get_assigned_task_purpose_id($user->request_id),
            'created_date' => $user->created_date,
            'status' => $user->changestatus,
            'stakeholder' =>$user->stakeholder,
            'code'  =>$user->proj_code,
            'business' => $user->business,
            'changeReqFile' =>$this->getChangeReqFile($user->request_id),
            'cntOfChangeReq'  =>$this->cntOfChangeReqFile($user->request_id),
           'dispatch_loc'=>$user->dispatch_loc,
        );

        // print_r($data);exit();
      
        return $data;


        /*
         $users = DB::table('changerequests')
                ->where('request_id', $id)
                ->get();
        */
        //  return $data;

    }
    public function get_cust_name_by_id($id)
    {
        $data = DB::table('customer')
            ->select('customer.FirstName')
            ->where('CustomerId', $id)
            ->get();

        // return $data[0]->FirstName;

    }
    public function getChangeReqFile($id){
        $file = DB::table('change_request_existing_attachments')
            ->select('change_request_existing_attachments.attached_file','change_request_existing_attachments.id')
            ->where('change_request_existing_attachments.request_id',$id)
            ->get();

        return $file;

    }
    public function cntOfChangeReqFile($id){
      $file = DB::table('change_request_existing_attachments')
             ->select(DB::raw('COUNT(id) as total'))
            ->where('change_request_existing_attachments.request_id',$id)
            ->get();

        return $file[0]->total;
    }

    public function get_user_name_by_id($id, $sub_dep_id)
    {
        $data = DB::table('tb_users')
            ->select('tb_users.*')
            ->where('tb_users.id', $id)->where('tb_users.sub_department', $sub_dep_id)
            ->get();

        return $data[0];


    }

    public function get_edit_change_request_cutmoer($id)
    {

        $data = DB::table('changerequests')
            ->select('changerequests.customer_id')
            ->where('request_id', $id)
            ->get();

        //   print_r(explode(',',$data[0]->customer_id));


        $cust_ids = explode(',', $data[0]->customer_id);

        foreach ($cust_ids as $value) {
            $cust_list[] = array(
                'id' => $value,
                'name' => $this->get_cust_name_by_id($value)

            );
            //echo $value."<br/>";
        }
//print_r($cust_ids);


        return $cust_list;

    }

    public function get_edit_change_request_parts($id)
    {
        $data = DB::table('tbl_parts_info')
            ->select('tbl_parts_info.*')
            ->where('request_ids', $id)
            ->get();

        return $data;

    }

    //   Delete Parts from edit page in add change request

    public function delete_parts_change_request($id)
    {

        return $data = DB::table('tbl_parts_info')
            ->where('parts_id', $id)
            ->delete();

    }

public function delete_all_parts_change_request($id)
    {

        return $data = DB::table('tbl_parts_info')
            ->where('request_ids', $id)
            ->delete();

    }

    function changerequeststatus($id, $id1)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();

         if($checkClose[0]->close ==1){
           echo 1;exit;
         }
        $input = (object)Input::all();

        if ($input->radioStatus == 3) {

           $init_id = $this->get_initiator_id_by_request_id($id);
           $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$init_id)
                    ->get();

                    if(empty($data)){
                      echo 0;exit;
                    }

            //echo "in first";exit;
            DB::table('reject_reason')->insert(
                array(
                    'reason' => $input->reject_reason,
                    'request_id' => $id

                )
            );

              //----trackingSheet hod reject---
             DB::table('tracking_sheet_info')->
             where('request_id',$id)
             ->where('status',1)
             ->delete();
              //-----------end----------

            DB::table('changerequests')
                ->where('request_id', $id)
                ->update(['rej_status' => 3]);

           // $message = 'Rejected';
            $message='Reinitiated due to Dept HOD rejected';
            $url = 'changes/edit_change_request/';
           
            
           
            $last_id_req=$this->save_noticication_status_for_reject($init_id, $id, $message, $url, $input->radioStatus,$input->reject_reason);

            $data1 = $this->get_user_info_by_id($init_id);
            $initiator_id = $this->get_data_id($last_id_req);
            $admin = $this->get_user_info_by_id(1);

            $initiator_name = $this->get_user_info_by_id($initiator_id['assigned_by']);

            $request_id=$id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $assignedto=$initiator_name['name'];
            $comment=$input->reject_reason;
            $admin_email=$admin['email'];

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'task_assigned_to'=>$assignedto,'url'=>$url,'request_id'=>$request_id,'Close_status'=>$close_status,'comment'=>$comment);

            Mail::send('emails/email-template-reject', $data_1, function ($message) use ($email_id,$admin_email) {

                $message->to($email_id);
                $message->bcc($admin_email)
                ->subject('You Have New Task');

            });
            $this->change_request_status_close($id, $id1);



        } else if($input->radioStatus == 2){
            $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$id)
            ->get();
            // print_r($checkParam);exit();
            if($checkParam[0]->change_stage == 1){
               $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();
                 
                if(empty($representative_id)){
                      echo 0;exit;
                    }else{
                      $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$representative_id[0]->representative_id)
                    ->get();

                    if(empty($data)){
                      echo 0;exit;
                    }
                  }
              $init_id=$representative_id[0]->representative_id;
            }else{
            $init_id = $this->get_initiator_id_by_request_id($id);
             $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$init_id)
                    ->get();

                    if(empty($data)){
                      echo 0;exit;
                    }
          }
           // print_r($init_id[0]->representative_id);exit();
            $date1 = explode('/', $input->dt);
            $d = $date1[2] . '-' . $date1[1] . '-' . $date1[0] . ' 00:00:00';


            DB::table('changerequests')
                ->where('request_id', $id)
                ->update(['projected_close_date' => $d, 'status' => $input->radioStatus,'comment' => $input->comment]);


                 //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',2)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));

                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'initial information sheet updation by Initaitor',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>2
                        )
                    );
                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 1)
                  ->update(['actual_date' => $Date]);

                
                 //----end code for tracking Sheet----

            $message='New Change request is Accepted by Dept HOD, Now Define Cross functional Team';
            $url = 'changes/update-initial-information-sheet/';
            
            
            $last_id_req=$this->save_noticication_status($init_id, $id, $message, $url, $input->radioStatus);
// print_r($init_id);exit();
            $data1 = $this->get_user_info_by_id($init_id);

            // $initiator_id = $this->get_initiator_id_by_request_id($id);
            // $initiator_name = $this->get_user_info_by_id($initiator_id);

            $request_id=$id;
            $close_status=$last_id_req;
            
            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $assignedto=$data1['name'];
             $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'task_assigned_to'=>$assignedto,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);

            if($this->check_netconnection())
            {
                Mail::send('emails/email-template', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }

            $this->change_request_status_close($id, $id1);



        }else{

           DB::table('permanent_reject_close')->insert(
                array(
                    'request_id' => $id,
                    'rejected_by_id' => Session::get('uid'),
                   'rejected_by_name' => Session::get('fid'),
                    'remark' => $input->close_reason,
                   'reject_date' => date('Y-m-d H:i:s'),
                    'created_date'=> date('Y-m-d')

                )
            );


             DB::table('changerequests')
                ->where('request_id', $id)
                 ->update(['status' => 2]);

            $init_id = $this->get_initiator_id_by_request_id($id);
            $data1 = $this->get_user_info_by_id($init_id);

            $initiatorId=DB::table('changerequests')
                ->select('changerequests.changeType','changerequests.created_date')
                ->where('changerequests.request_id', $id)
                ->get();



            $query1=DB::table('tbl_change_type')
                ->select('tbl_change_type.change_type_name')
                ->where('tbl_change_type.change_type_id',$initiatorId[0]->changeType)
                ->get();


            $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$initiatorId[0]->created_date,$id);

            $assignById=DB::table('tb_users')
                ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                ->where('tb_users.id', Session::get('uid'))
                ->groupBy('tb_users.id')
                ->get();

            $assignByName= $assignById[0]->first_name." ".$assignById[0]->last_name;
            $this->change_request_status_reject_and_close($id, $id1, $assignByName);

            $message = "Change Request ".$cmNo." is  Rejected and Closed by ".$assignByName.".";
            $comment=$input->close_reason;
            $contactName = $data1['name'];
            $email_id = $data1['email'];

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'comment'=>$comment);


            $admin = $this->get_user_info_by_id(1);
            $admincontactName = $admin['name'];
            $adminemail_id = $admin['email'];
            $data_2 = array('firstname'=>$admincontactName,'description'=>$message,'comment'=>$comment);



            if($this->check_netconnection())
            {

                Mail::send('emails/permanent-reject', $data_1, function ($message) use ($email_id) {


                    $message->to($email_id)
                        ->subject('Change request is Rejected and Closed');

                });

            }else{



            }
            if($this->check_netconnection())
            {

                Mail::send('emails/permanent-reject', $data_2, function ($message) use ($adminemail_id) {


                    $message->to($adminemail_id)
                        ->subject('Change request is Rejected and Closed');

                });

            }else{



            }

        }
    }


    function edit_request()
    {

        return View::make('changes/change_request_edit');
    }

    function profile()
    {


        return View::make('profile');
    }

    function get_profile_info($id)
    {

        $users = DB::table('tb_users')
            ->leftJoin('tb_departments', 'tb_users.department', '=', 'tb_departments.d_id')
            ->leftJoin('subdepartments', 'tb_users.sub_department', '=', 'subdepartments.sub_dep_id')
            ->leftJoin('tb_role', 'tb_users.user_role', '=', 'tb_role.role_id')
            ->select('tb_users.first_name', 'tb_users.avatar', 'tb_users.last_name', 'tb_users.email', 'tb_departments.d_name', 'subdepartments.sub_dep_name', 'tb_role.role_name')
            ->where('id', $id)
            ->get();
        return $users;

    }


    function set_profile_info()
    {

        //  print_r(Input::all());exit;

        $destinationPath = 'uploads/users'; // upload path


        Input::get('last_name');


        if (Input::hasFile('image') && Input::file('image')->isValid()) {

            if (!empty(Input::get('oldimage'))) {

                $filename = public_path() . '/uploads/users/' . Input::get('oldimage');
                // return $filename;

                //  if (File::exists($filename)) {
                File::delete($filename);
                //   }

            }

            $name = Input::file('image')->getClientOriginalName();

            $extension = Input::file('image')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . "-" . $name; // renaming image
            Input::file('image')->move($destinationPath, $fileName);
            // echo $fileName; exit;
            $imagename = $fileName;


        } else {

            $imagename = Input::get('oldimage');

        }


        DB::table('tb_users')
            ->where('id', Session::get('uid'))
            ->update(['first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'avatar' => $imagename]);

        //  return $imagename;

    }


    //Edit Function for Add change request
    public function updaterequest($id)
    {//exit;
        if (Request::isJson()) {


            $input = (object)Input::all();

            
            if (isset($input->sub_dep_id)) {
                $sub_dep = $input->sub_dep_id;
            } else {
                $sub_dep = '';
            }
            if($input->dt==''){

                $d_t='--';
            }else{

                $date1 = explode('/', $input->dt);
                $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

            }

          if (isset($input->sub_type_id)) {
            if (is_array($input->sub_type_id)) {
             $typeId = implode(',',$input->sub_type_id);
           }else{
            $typeId = $input->sub_type_id;
           }
         }else{
            $typeId='';
         }

           if (isset($input->dispatch_loc)) {
                $dispatch_loc = $input->dispatch_loc;
            } else {
                $dispatch_loc = '';
            }

             $stage = DB::table('tb_projectMaster')
                      ->select('change_stage')
                      ->where('id',$input->code)
                      ->get();
                      $stage_id =$input->change_stage_id;

            
		 $changeType=explode("@",$input->changeType);

            DB::table('changerequests')->where('request_id', $id)
                ->update(array(//'initiator_name' => $input->initiator_name,
                       'initiator_id' => $input->initiator_id,
                  
                        'dep_id' => $input->dep_id,
                        'sub_dep_id' => $sub_dep,
                       
                        'changeType' => $changeType[0],
                        'change_sub_type' => $typeId,
                       
                        'change_stage' => $stage_id,
                       
                        'Approval_Authority' => $input->Approval_Authority_id,
                        'plant_code' => $input->plant_id,
                        'Purpose_Modification_Details' => $input->Purpose_Modification_Details,
                        'remark' => $input->remark,
                        'created_date' => date('Y-m-d H:i:s'),
                        'dt'=>$d_t,
                        'stakeholder' => $input->stakeholder,
                        'proj_code'  =>$input->project_code,
                         'business' => $input->business,
                         'dispatch_loc'=>$dispatch_loc,

                    )
                );

                

          if(!empty($input->uploadFileName)){
          $fileName =explode(",", $input->uploadFileName);
            foreach($fileName as $file){
                
              $file = str_replace('"', "", $file);
              $file = str_replace('[', "", $file);
              $file = str_replace(']', "", $file);
             DB::table('change_request_existing_attachments')->insert(
                        array(
                            'request_id' => $id,
                            'attached_file'   =>$file,
                        )
                    );
            }
          }

            foreach ($input->multi_part as $value) {


                if (isset($value['parts_id']) && !empty($value['parts_id'])) {

                    DB::table('tbl_parts_info')->where('parts_id', $value['parts_id'])
                        ->update(array('part_number' => $value['part_number'],
                                'part_name' => $value['part_name']
                            )
                        );

                } else {

                    DB::table('tbl_parts_info')->insert(
                        array('part_number' => $value['part_number'],
                            'part_name' => $value['part_name'],
                            'request_ids' => $id

                        )
                    );

                }

            }

            if (is_array($input->multi_purpose)) {
                DB::table('changerequests_purposechange')->where('request_id', '=', $id)->delete();
                foreach ($input->multi_purpose as $value) {
                    DB::table('changerequests_purposechange')->insert(
                        array(
                            'purpose_id' => $value,
                            'request_id' => $id

                        )
                    );

                }
            } else {

                DB::table('changerequests_purposechange')->insert(
                    array(
                        'purpose_id' => $input->change_purpose,
                        'request_id' => $id

                    )
                );
            }

                if (is_array($input->multi_user)) {
                    DB::table('changerequests_customer')->where('request_id', '=', $id)->delete();
                    foreach ($input->multi_user as $value) {
                        DB::table('changerequests_customer')
                            ->insert(array(
                                'customer_id' => $value,
                                 'request_id' => $id

                            )
                        );

                    }
                } else {


                    DB::table('changerequests_customer')->where('request_id', '=', $id)->delete();
                    DB::table('changerequests_customer')->insert(
                        array(
                            'customer_id' => $input->multi_user,
                            'request_id' => $id


                        )
                    );

                }







        }
        echo "success";exit();
    }

     public function updaterequest1($id)
    {//exit;
        if (Request::isJson()) {


            $input = (object)Input::all();

            
            if (isset($input->sub_dep_id)) {
                $sub_dep = $input->sub_dep_id;
            } else {
                $sub_dep = '';
            }
            if($input->dt==''){

                $d_t='--';
            }else{

                $date1 = explode('/', $input->dt);
                $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];

            }

          if (isset($input->sub_type_id)) {
            if (is_array($input->sub_type_id)) {
             $typeId = implode(',',$input->sub_type_id);
           }else{
            $typeId = $input->sub_type_id;
           }
         }else{
            $typeId='';
         }

           if (isset($input->dispatch_loc)) {
                $dispatch_loc = $input->dispatch_loc;
            } else {
                $dispatch_loc = '';
            }

             $stage = DB::table('tb_projectMaster')
                      ->select('change_stage')
                      ->where('id',$input->code)
                      ->get();
                      $stage_id =$input->change_stage_id;

            
     $changeType=explode("@",$input->changeType);

            DB::table('changerequests')->where('request_id', $id)
                ->update(array(//'initiator_name' => $input->initiator_name,
                       'initiator_id' => $input->initiator_id,
                  
                        'dep_id' => $input->dep_id,
                        'sub_dep_id' => $sub_dep,
                       
                        'changeType' => $changeType[0],
                        'change_sub_type' => $typeId,
                       
                        'change_stage' => $stage_id,
                       
                        'Approval_Authority' => $input->Approval_Authority_id,
                        'plant_code' => $input->plant_id,
                        'Purpose_Modification_Details' => $input->Purpose_Modification_Details,
                        'remark' => $input->remark,
                   
                        'stakeholder' => $input->stakeholder,
                        'proj_code'  =>$input->project_code,
                         'business' => $input->business,
                         'dispatch_loc'=>$dispatch_loc,

                    )
                );

                

          if(!empty($input->uploadFileName)){
          $fileName =explode(",", $input->uploadFileName);
            foreach($fileName as $file){
                
              $file = str_replace('"', "", $file);
              $file = str_replace('[', "", $file);
              $file = str_replace(']', "", $file);
             DB::table('change_request_existing_attachments')->insert(
                        array(
                            'request_id' => $id,
                            'attached_file'   =>$file,
                        )
                    );
            }
          }

            foreach ($input->multi_part as $value) {


                if (isset($value['parts_id']) && !empty($value['parts_id'])) {

                    DB::table('tbl_parts_info')->where('parts_id', $value['parts_id'])
                        ->update(array('part_number' => $value['part_number'],
                                'part_name' => $value['part_name']
                            )
                        );

                } else {

                    DB::table('tbl_parts_info')->insert(
                        array('part_number' => $value['part_number'],
                            'part_name' => $value['part_name'],
                            'request_ids' => $id

                        )
                    );

                }

            }

            if (is_array($input->multi_purpose)) {
                DB::table('changerequests_purposechange')->where('request_id', '=', $id)->delete();
                foreach ($input->multi_purpose as $value) {
                    DB::table('changerequests_purposechange')->insert(
                        array(
                            'purpose_id' => $value,
                            'request_id' => $id

                        )
                    );

                }
            } else {

                DB::table('changerequests_purposechange')->insert(
                    array(
                        'purpose_id' => $input->change_purpose,
                        'request_id' => $id

                    )
                );
            }

                if (is_array($input->multi_user)) {
                    DB::table('changerequests_customer')->where('request_id', '=', $id)->delete();
                    foreach ($input->multi_user as $value) {
                        DB::table('changerequests_customer')
                            ->insert(array(
                                'customer_id' => $value,
                                 'request_id' => $id

                            )
                        );

                    }
                } else {


                    DB::table('changerequests_customer')->where('request_id', '=', $id)->delete();
                    DB::table('changerequests_customer')->insert(
                        array(
                            'customer_id' => $input->multi_user,
                            'request_id' => $id


                        )
                    );

                }







        }
        echo "success";exit();
    }


    /*
     *
     * Submit change request from draft or by rejected
     *
     */

    public function submitrequest($id,$temp_id,$type)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$temp_id)
              ->get();
         if($checkClose[0]->close ==1){
            return ;exit();
         }

        if (Request::isJson()) {

            $input = (object)Input::all();
          
            // print_r($input);exit();

            if (isset($input->sub_dep_id)) {
                $sub_dep = $input->sub_dep_id;
            } else {
                $sub_dep = '';
            }
            if($input->dt==''){

                $d_t='--';
            }else{

                $date1 = explode('/', $input->dt);
                $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
           }
           if (is_array($input->sub_type_id)) {
             $typeId = implode(',',$input->sub_type_id);
           }else{
            $typeId = $input->sub_type_id;
           }
             if (isset($input->dispatch_loc)) {
                $dispatch_loc = $input->dispatch_loc;
            } else {
                $dispatch_loc = '';
            }         
           
		 $changeType=explode("@",$input->changeType);
            DB::table('changerequests')->where('request_id', $id)
                ->update(array(//'initiator_name' => $input->initiator_name,
                        'initiator_id' => $input->initiator_id,
                        
                        'dep_id' => $input->dep_id,
                        'sub_dep_id' => $sub_dep,
                        
                        'changeType' => $changeType[0],
                        'change_sub_type' => $typeId,
                        
                        'change_stage' => $input->change_stage_id,
                        
                        'Approval_Authority' => $input->Approval_Authority_id,
                        'plant_code' => $input->plant_id,
                        'stakeholder' => $input->stakeholder,
                        'business' => $input->business,
                        'proj_code'   => $input->project_code,
                        'Purpose_Modification_Details' => $input->Purpose_Modification_Details,
                        'remark' => $input->remark,
                       // 'created_date' => date('Y-m-d H:i:s'),
                        'status' => $input->type,
                        //'dt'=>$d_t,
                        'dispatch_loc'=>$input->dispatch_loc

                    )
                );


               

          if(!empty($input->uploadFileName)){
          $fileName =explode(",", $input->uploadFileName);
            foreach($fileName as $file){
               // print_r($file);
              $file = str_replace('"', "", $file);
              $file = str_replace('[', "", $file);
              $file = str_replace(']', "", $file);
              DB::table('change_request_existing_attachments')->insert(
                        array(
                            'request_id' => $id,
                            'attached_file'   =>$file,
                        )
                    );
            }
          }
            foreach ($input->multi_part as $value) {


                if (isset($value['parts_id']) && !empty($value['parts_id'])) {

                    DB::table('tbl_parts_info')->where('parts_id', $value['parts_id'])
                        ->update(array('part_number' => $value['part_number'],
                                'part_name' => $value['part_name']
                            )
                        );

                } else {

                    DB::table('tbl_parts_info')->insert(
                        array('part_number' => $value['part_number'],
                            'part_name' => $value['part_name'],
                            'request_ids' => $id

                        )
                    );

                }

            }

            if (is_array($input->multi_purpose)) {
                DB::table('changerequests_purposechange')->where('request_id', '=', $id)->delete();
                foreach ($input->multi_purpose as $value) {
                    DB::table('changerequests_purposechange')->insert(
                        array(
                            'purpose_id' => $value,
                            'request_id' => $id

                        )
                    );

                }
            } else {
                DB::table('changerequests_purposechange')->where('request_id', '=', $id)->delete();
                DB::table('changerequests_purposechange')->insert(
                    array(
                        'purpose_id' => $input->multi_purpose,
                        'request_id' => $id

                    )
                );
            }

            if (is_array($input->multi_user)) {
                DB::table('changerequests_customer')->where('request_id', '=', $id)->delete();
                foreach ($input->multi_user as $value) {
                    DB::table('changerequests_customer')
                        ->insert(array(
                                'customer_id' => $value,
                                'request_id' => $id

                            )
                        );

                }
            }else{

                DB::table('changerequests_customer')->where('request_id', '=', $id)->delete();

                    DB::table('changerequests_customer')
                        ->insert(array(
                                'customer_id' => $input->multi_user,
                                'request_id' => $id

                            )
                        );

            }
        }




        if ($input->type == 1) {

            $message = "New Change request is Pending for approval from Department HOD";

             //----start code for tracking Sheet----
                $data=DB::table('tracking_sheet_date_param')->where('process','Hod Approval')->get();
                $Date=date('Y-m-d');
                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Hod Approval',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>1
                        )
                    );

                 
                 //----end code for tracking Sheet----
            $url = 'changes/change_status/';
            $last_id_req=$this->create_noticication_status($input->Approval_Authority_id, $id, $message, $url, $input->type);


            $data1 = $this->get_user_info_by_id($input->Approval_Authority_id);
            $initiator_id = $this->get_initiator_id_by_request_id($id);
            $initiator_name = $this->get_user_info_by_id($initiator_id);

            $request_id=$id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $assignedto=$initiator_name['name'];
             $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'task_assigned_to'=>$assignedto,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



            if($this->check_netconnection())
            {
                Mail::send('emails/email-template', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }

         //   $this->change_request_status_close($id, 0);

        }

        if($temp_id!=1){//print_r($temp_id);exit;

            $this->change_request_status_close($id, $temp_id);
        }else{


        }


    }




    public function getCustomerCommDecision($id)
    {
        $data = DB::table('Customer_Communication_list')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('request_id', $id)
            ->where('decision','!=',0)
            ->get();

        return $data[0]->total;

    }

    public function update_initial_information($id)
    {

      $getData = DB::table('changerequests')
                ->select('plant_code','stakeholder','change_stage','proj_code')
                  ->where('request_id',$id)
                                ->get();

 
      $dept = DB::table('tb_dynamicDepartment')
              ->select('department')
              ->where('plantCode',$getData[0]->plant_code)
              ->where('stakeholder',$getData[0]->stakeholder)
               ->where('change_stage',$getData[0]->change_stage)
              ->get();
            

           
          if(empty($dept) && $getData[0]->proj_code == "" && $getData[0]->change_stage == 2){
            return Redirect::to('dashboard')
                ->with('message', SiteHelpers::alert('error',' One department should be there as per configuration '))
                ->withInput();
          }
          if(empty($dept) &&  $getData[0]->change_stage == 1){
            return Redirect::to('dashboard')
                ->with('message', SiteHelpers::alert('error',' One department should be there as per configuration '))
                ->withInput();
          }

        $data=array(
            'page'      => 'modifyByUser',
            'request_id' =>$id,
            'initiator' => ""
        );

        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
      
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput(); 
         }else{ 
          if ($this->check_request_permission($id)) {

              return View::make('changes/updateinitia_information_sheet')->with($data);
          } else {

              return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
          }
        }


    }

    public function update_risk_analysis($id, $id1)
    {
      $dept_id =  Session::get('dep_id');

         $data  = DB::table('tb_risk_assessment_points_admin')
        ->select('tb_risk_assessment_points_admin.*')
        ->where('tb_risk_assessment_points_admin.risk_sub_department','=',$dept_id)
                ->where('tb_risk_assessment_points_admin.status','=','active')
        ->orderBy('tb_risk_assessment_points_admin.created', 'ASC')
        ->get();
        if(empty($data)){
           return Redirect::to('dashboard')
                      ->with('message', SiteHelpers::alert('error','Risk assessment points not defined for this department.Please contact administrator.'))
                      ->withInput();  
        }
        $data = array(
            'request_id'  => "",
            'page'        => 'modifybyriskAss',
            'dept_id'     =>   "",
            'risk_assessor_id'  => ""

        );
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
              return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }else{   

            if ($this->check_request_permission($id)) {

                return View::make('changes/update-risk-analysis-sheet')->with($data);
            } else {

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
            }
          }  


    }

   
     public function cntRiskPoint($dept){
      
      $add_team = DB::table('tb_risk_assessment_points_admin')
                ->select(DB::raw('COUNT(risk_assessment_id_admin) as total'))
                ->where('tb_risk_assessment_points_admin.risk_sub_department', $dept)
                ->where('tb_risk_assessment_points_admin.status','active')
                ->get();

               
                if($add_team[0]->total >= 11) {
                  return 1;
                }else{
                  return 0;
                }
     }
    

    public function add_risk_admin_sheet_to_user($id,$riskAssId,$dept_id)
    {


        $users = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('COUNT(risk_assessment_id) as total'))
            ->where('tb_risk_assessment_points.request_id', $id)
            ->where('tb_risk_assessment_points.responsibility', $riskAssId)
            ->get();

        if ($users[0]->total) {

            return $this->fetch_risk_assessment($id,$riskAssId,$dept_id);
        } else {

            $this->fetch_risk_assessment_from_admin($id,$riskAssId,$dept_id);
            return $this->fetch_risk_assessment($id,$riskAssId,$dept_id);
            // return 0;
        }

    }

    public function get_project($r_id){
      
      $proj_code = DB::table('changerequests')
                    ->select('proj_code','change_stage','plant_code','stakeholder')
                    ->where('request_id',$r_id)
                    ->get();
        if($proj_code[0]->change_stage == 2 && $proj_code[0]->proj_code == ""){
            $pro_mgr = DB::table('tb_project_manager')
                        ->select('proj_mgr_id')
                        ->where('change_stage',$proj_code[0]->change_stage)
                        ->where('plant_code',$proj_code[0]->plant_code)
                        ->where('stakeholder',$proj_code[0]->stakeholder)
                        ->get();
            if(!empty($pro_mgr)){
              $data = DB::table('tb_users')     
                    ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
                    ->where('tb_users.id', '=', $pro_mgr[0]->proj_mgr_id)
                    ->where('tb_users.active',1)
                    ->get();

           
            
            $res = array();
            foreach ($data as $point) {
                $res[] = array(
                    'name' => $point->first_name . ' ' . $point->last_name,
                    'email' => $point->email,
                    'id' => $point->id,
                );
            }
          }
            return $res;
  

        }else if($proj_code[0]->change_stage == 2 && $proj_code[0]->proj_code != ""){
            $pro_mgr = DB::table('tb_projectMaster')
                        ->select('project_manager')
                        ->where('id',$proj_code[0]->proj_code)
                        
                        ->get();

            $data = DB::table('tb_users')     
                    ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
                    ->where('tb_users.id', '=', $pro_mgr[0]->project_manager)
                     ->where('tb_users.active',1)
                    ->get();

           

            $res = array();
            foreach ($data as $point) {
                $res[] = array(
                    'name' => $point->first_name . ' ' . $point->last_name,
                    'email' => $point->email,
                    'id' => $point->id,
                );
            }
            return $res;
        }else{
            $users  = DB::table('tb_users')
              ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
              ->whereRaw("find_in_set(4,tb_users.group_id)")
              ->where('tb_users.sub_department',Session::get('sub_dep_id'))
              ->where('tb_users.department',Session::get('dep_id'))
              ->where('tb_users.active',1)
              ->get();

            if($users==[]){//echo "blank";exit;

              $data = DB::table('tb_users')
                  ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
                  ->where('tb_users.department', '=', Session::get('dep_id'))
                  ->whereRaw("find_in_set(4,tb_users.group_id)")
                  ->where('tb_users.active',1)
                  ->get();

              $res = array();
              foreach ($data as $point) {
                  $res[] = array(
                      'name' => $point->first_name . ' ' . $point->last_name,
                      'email' => $point->email,
                      'id' => $point->id,
                  );
              }
              return $res;




          }else {


              $res = array();
              foreach ($users as $point) {
                  $res[] = array(
                      'name' => $point->first_name . ' ' . $point->last_name,
                      'email' => $point->email,
                      'id' => $point->id,
                  );
              }
              return $res;

          }
        }


    }

    public function get_change_request_details($id)
    {
        $users = DB::table('changerequests')
            ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
            ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
            ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
            ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
            //  ->leftJoin('changerequest_purpose', 'changerequests.change_purpose', '=', 'changerequest_purpose.id')
            ->leftJoin('tbl_parts_info', 'changerequests.request_id', '=', 'tbl_parts_info.request_ids')
            ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
            ->leftJoin('tb_stakeholder', 'changerequests.stakeholder', '=', 'tb_stakeholder.id')
            ->leftJoin('tb_projectMaster', 'changerequests.proj_code', '=', 'tb_projectMaster.id')
            ->leftJoin('tb_businessMaster', 'tb_businessMaster.id', '=', 'changerequests.business')
            ->leftJoin('tbl_chage_sub_type', 'changerequests.change_sub_type', '=', 'tbl_chage_sub_type.sub_type_id')
            ->leftJoin('add_update_initial_sheet', 'changerequests.request_id', '=', 'add_update_initial_sheet.request_id')
            ->select('changerequests.*', 'tb_departments.d_name', 'tbl_parts_info.part_number', 'tbl_parts_info.part_name', 'subdepartments.sub_dep_name', 'tb_change_stage.stage_name', 'tbl_change_type.change_type_name', 'tbl_change_type.change_type_cust_mapping', 'tbl_change_type.change_type_part_mapping', 'plant_code.plant_id', 'tb_users.*','tb_stakeholder.*','tb_projectMaster.*','tbl_chage_sub_type.sub_type_name as type_name','tb_businessMaster.busi_code as busi','add_update_initial_sheet.currentTime as impdate','add_update_initial_sheet.stock','add_update_initial_sheet.selected as indexlevel')
            ->where('changerequests.request_id', $id)
            ->get();

        $user = $users[0];

         if ($user->impdate == '') {

                $user_created_data = '---';
            } else {

                $user_created_data = Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
            }

          if ($user->indexlevel == 1) {

                $indexLevel = 'Yes';
            } else {
                $indexLevel = 'No';
            }


        $data= array(
            'cmNo' => $this->generate_cm_no_search($user->change_type_name,$user->created_date,$user->request_id),
            'business' => $user->busi,
            'changeSubType' => $user->type_name,
            'initiator_name' => $user->first_name . ' ' . $user->last_name,
            'plant_id' => $user->plant_code,
            'emp_id' => $user->emp_id,
            'dep_id' => $user->dep_id,
            'sub_dep_id' => $user->sub_dep_id,
            'changeType' => $user->change_type_name,
            'change_stage' => $user->stage_name,
            'customers' => $this->get_change_request_customers($user->request_id),
            'Approval_Authority' => $this->get_dept_HOD($user->Approval_Authority),
            'plant_id' => $user->plant_code,
            'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
            'remark' => $user->remark,
            'parts' => $this->get_parts($user->request_id),
           // 'part_name' => $user->part_name,
            'change_purpose' => $this->get_assigned_task_purpose($user->request_id),

            'dt' =>Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
            'response_date' => $this->get_custom_date($user->projected_close_date),
            'stakeholder' =>$user->name,
            'proj_code' =>$user->project_code,
            'hodApproveComment' => $user->comment,
            'impDate'=>$user_created_data,
            'stock'=>$user->stock,
            'level'=>$indexLevel,
            'get_change_request_attachment' => $this->get_change_request_attachment($user->request_id),
        );


        return $data;

    }

    public function getCustomerVerification($id,$dept_id)
    {

        $data = DB::table('attachment_activity_monitoring_summerysheet')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('request_id',$id)
            ->where('dep_id',$dept_id)
            ->where('task_status','=',2)
            ->get();

        return $data[0]->total;

    }

    public function fill_team($id)
    {

        return $users = DB::table('tb_users')
            ->select('id', 'first_name', 'last_name')
            ->where('department', '=', $id)

           ->whereRaw("find_in_set(3,tb_users.group_id)")
          //  ->where('id', '<>', Session::get('uid'))
            ->get();

    }

    public function add_dep_team1($request_id)
    {

        $input = (object)Input::all();

        //print_r($input);exit;


        DB::table('tb_updatesheet_dep_team')->where('update_sheet_dep_id',$input->update_sheet_dep_id)
            ->update(array(

                    'team_member' => $input->team_member,
                 


                )
            );

        DB::table('add_updated_risk_assessment_sheet')->where('user_department',$input->department)->where('r_id',$request_id)
            ->update(array(
                    'user_id' => $input->team_member,
                )
            );



        $row= DB::table('request_progress_status')
            ->where('request_id', $request_id)
            ->where('assigned_to', $input->oldUserId)
            ->where('status',6)
            ->update(
                array(
                    'assigned_to' => $input->team_member,

                )
            );
             $row= DB::table('request_progress_status')
            ->where('request_id', $request_id)
            ->where('assigned_to', $input->oldUserId)
            ->where('status',99)
            ->update(
                array(
                    'assigned_to' => $input->team_member,

                )
            );
             $row= DB::table('request_progress_status')
            ->where('request_id', $request_id)
            ->where('assigned_to', $input->oldUserId)
            ->where('status',9)
            ->update(
                array(
                    'assigned_to' => $input->team_member,

                )
            );
            $row= DB::table('request_progress_status')
            ->where('request_id', $request_id)
            ->where('assigned_to', $input->oldUserId)
            ->where('status',11)
            ->update(
                array(
                    'assigned_to' => $input->team_member,

                )
            );
            $row= DB::table('request_progress_status')
            ->where('request_id', $request_id)
            ->where('assigned_by', $input->oldUserId)
            ->where('status',7)
            ->update(
                array(
                    'assigned_by' => $input->team_member,

                )
            );

        DB::table('request_progress_status')
            ->where('request_id', $request_id)
            ->where('assigned_to', $input->oldUserId)
            ->where('status',14)
            ->update(
                array(
                    'assigned_to' => $input->team_member,

                )
            );

             
      

        $rap=DB::table('tb_risk_assessment_points')
            ->where('request_id', $request_id)
            ->where('responsibility', $input->oldUserId)
            ->where('risk_dep',$input->department)
            ->update(
              array(
                  'responsibility' => $input->team_member,

              )
            );
           $ara=  DB::table('approval_risk_assessment')
            ->where('request_id', $request_id)
            ->where('user_id', $input->oldUserId)
            ->update(
                array(
                    'user_id' => $input->team_member,

                )
            );
           $aam= DB::table('attachment_activity_monitoring')
            ->where('request_id', $request_id)
            ->where('user_id', $input->oldUserId)
            ->update(
                array(
                    'user_id' => $input->team_member,

                )
            );
          $aams=  DB::table('attachment_activity_monitoring_summerysheet')
            ->where('request_id', $request_id)
            ->where('user_id', $input->oldUserId)
            ->update(
                array(
                    'user_id' => $input->team_member,

                )
            );
        


    }
    public function add_dep_team($request_id)
    {

        $input = (object)Input::all();
        DB::table('tb_updatesheet_dep_team')->where('update_sheet_dep_id',$input->update_sheet_dep_id)
            ->update(array(

                    'team_member' => $input->team_member,
                    'fetch_status' => 2


                )
            );

        DB::table('add_updated_risk_assessment_sheet')->where('user_department',$input->department)->where('r_id',$request_id)
            ->update(array(
                    'user_id' => $input->team_member,
                    'status' => 1,
                    'created_date'=>date('Y-m-d H:i:s')


                )
            );


    }
     public function count_applicability($request_id){

        $user1 = DB::table('attachment_activity_monitoring')
            ->select('attachment_id')
            ->where('attachment_activity_monitoring.request_id', $request_id)
            ->where('attachment_activity_monitoring.dep_id', Session::get('dep_id'))
            ->where('attachment_activity_monitoring.decision',1)
            ->groupBy('attachment_activity_monitoring.list_id')
            ->get();

        $user2 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('COUNT(risk_assessment_id) as total'))
            ->where('tb_risk_assessment_points.request_id', $request_id)
            ->where('tb_risk_assessment_points.risk_dep', Session::get('dep_id'))
            ->where('tb_risk_assessment_points.applicability', 1)
            ->get();

           

       // print_r(count($user1));
       //  echo '<pre>';
       //  print_r($user2);exit;

        if(count($user1)==$user2[0]->total || count($user1)>$user2[0]->total){

            return 1;

        }else{

            return 0;


        }


    }


    public function fetch_dep_team($id)
    {
        $data = DB::table('tb_updatesheet_dep_team')
            ->leftJoin('tb_departments', 'tb_updatesheet_dep_team.department', '=', 'tb_departments.d_id')
            ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
            ->select('tb_users.first_name', 'tb_users.last_name','tb_users.id', 'tb_departments.*', 'tb_updatesheet_dep_team.update_sheet_dep_id','tb_updatesheet_dep_team.fetch_status')
            ->where('tb_updatesheet_dep_team.request_id', '=', $id)

            ->get();

        return $data;


    }

    public function get_team_lead()
    {
        return $this->get_user_by_role(2);
    }
    public function get_total_cost_perpiece($id){
        $users = DB::table('tb_risk_assessment_points')
                ->select(DB::raw('SUM(tb_risk_assessment_points.piececost) as total'))
                ->where('tb_risk_assessment_points.request_id', $id)
                //->where('tb_updatesheet_dep_team.team_member', $member)
                ->get();
            return $users[0]->total;
    }
    public function get_total_cost($id){

            $users = DB::table('tb_risk_assessment_points')
                ->select(DB::raw('SUM(tb_risk_assessment_points.cost) as total'))
                ->where('tb_risk_assessment_points.request_id', $id)
                //->where('tb_updatesheet_dep_team.team_member', $member)
                ->get();

            return $users[0]->total;
        }


    public function destroy($id)
    {
        DB::table('tb_updatesheet_dep_team')->where('update_sheet_dep_id', '=', $id)->delete();

        return Response::json(array('success' => true));
    }

    public function add_initial_info_sheet($id)
    {
      
        if (Request::isJson()) {

             $input = (object)Input::all();

            $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$input->request_id)
              ->where('id',$id)
              ->get();
             if($checkClose[0]->close ==1){
                return 1;exit();
             }
            if (isset($input->txtComment)) {
                $comment = $input->txtComment;
            } else {
                $comment = '';
            }
            if (isset($input->stock)) {
                $stock_data = $input->stock;
            } else {
                $stock_data = '';
            }
            if (isset($input->currentTime) && !empty($input->currentTime)) {
                $currentTime = $input->currentTime;
                $date1 = explode('.', $currentTime);
                $currentTime = $date1[2] . '-' . $date1[0] . '-' . $date1[1] . ' 00:00:00';
            } else {
                $currentTime = '';
            }

           $checkuser=DB::table('tb_updatesheet_dep_team')
            ->select('team_member')
            ->where('request_id',$input->request_id)
            ->get();

           foreach ($checkuser as $key) {
            $inactiveuser=DB::table('tb_users')
            ->select('first_name','last_name')
            ->where('active',0)
            ->where('id',$key->team_member)
            ->get();
            if(!empty($inactiveuser)){
              $data[]=array(
                  'user'=>$inactiveuser[0]->first_name.' '.$inactiveuser[0]->last_name,
                  'inactive'=>'0',

                );
              return $data;exit();
            }
           }
            
            

            DB::table('tb_updatesheet_dep_team')->where('request_id',$input->request_id)
                ->update(array(

                        'initial_sheet_status' => 2

                    )
                );

                  $stock=DB::table('add_update_initial_sheet')
                  ->select('*')
                  ->where('request_id',$input->request_id)
                  ->get();
              // print_r($stock);exit();
            if(empty($stock)){

            DB::table('add_update_initial_sheet')->insert(
                array('team_leader_id' => Session::get('uid'),
                    // 'unique_id' => $input->unique_id,
                    'selected' => $input->selected,
                    'currentTime' => $currentTime,
                    'stock' => $stock_data,
                    'request_id' => $input->request_id,
                    'comment'  => $comment
                )
            );
            
          }else{
            DB::table('add_update_initial_sheet')->where('request_id',$input->request_id)
                ->update(
                    array('team_leader_id' => Session::get('uid'),
                    // 'unique_id' => $input->unique_id,
                    'selected' => $input->selected,
                    'currentTime' => $currentTime,
                    'stock' => $stock_data,
                    'comment'  => $comment
                    
                )
            );
               
          }

            //change status to 1 for departments
            DB::table('tb_updatesheet_dep_team')
                ->where('request_id', $input->request_id)
                ->update(['status' => 2]);



          //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',3)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));


                 $dta= DB::table('add_updated_risk_assessment_sheet')->select('user_department')->where('r_id',$input->request_id)->get();
                  $riskAssDept="";
                 foreach ($dta as $row) {
                 $riskAssDept='RiskAssessment By '.$row->user_department;
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>$riskAssDept,
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>3
                        )
                    );
                }
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 2)
                  ->update(['actual_date' => $Date]);

                 
                 //----end code for tracking Sheet----

            
            //==================mail section 2========================

                  



            $data_11 = DB::table('tb_users')
                ->leftJoin('tb_updatesheet_dep_team', 'tb_users.id', '=', 'tb_updatesheet_dep_team.team_member')
                ->select('tb_updatesheet_dep_team.team_member', 'tb_users.email','tb_users.department','tb_users.sub_department')->where('tb_updatesheet_dep_team.request_id', $input->request_id)->get();

            $message='Pending clearance of impact analysis  point activities from CFT Dept.';
            $url = 'changes/update-risk-analysis-sheet/';


            foreach ($data_11 as $value) {
                $initiator = (String)$value->team_member;

                $dep = (String)$value->department;
                   $sub_dep=(String)$value->sub_department;
                $last_id_req=$this->save_noticication_status($initiator, $input->request_id, $message, $url, 6);

                $data1 = $this->get_user_info_by_id($initiator);


                $initiator_id = $this->get_hod_by_user_department_subdept($dep,$sub_dep);

                $initiator_name = $this->get_user_info_by_id($initiator_id['id']);


                $request_id=$input->request_id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                $assignedto=$initiator_name['name'];
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'task_assigned_to'=>$assignedto,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'Comment'=>$comment);



                if($this->check_netconnection())
                {
                    Mail::send('emails/cft_email-template', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{



                }
            }

             $StageType = DB::table('changerequests')
                    ->select('change_stage','proj_code','changeType','created_date')
                    ->where('request_id',$input->request_id)
                    ->get();

                    $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$StageType[0]->changeType)
                    ->get();

                    if($StageType[0]->change_stage == 2 && $StageType[0]->proj_code != "" ){

                       $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$StageType[0]->created_date,$input->request_id); 
                      $prj_mgr = DB::table('tb_projectMaster')
                                ->select('project_manager')
                                ->where('id',$StageType[0]->proj_code)
                                ->get();

                                $data1 = $this->get_user_info_by_id($prj_mgr[0]->project_manager);
                                $contactName = $data1['name'];
                                $email_id = $data1['email'];
                                $message = 'CFT Team Has Defined For this Change Request';
                                $data2= $this->fetch_dep_team($input->request_id);


                                
                                $data_1 = array('firstname'=>$contactName,'description'=>$message,'allTeam'=>$data2,'cr'=>$cmNo,'comment'=>$comment);





                          if($this->check_netconnection())
                          {
                              Mail::send('emails/proj_mgr_mail', $data_1, function ($message) use ($email_id) {

                                  $message->to($email_id)->subject('Inform mail');
                              });

                          }else{

                          }
                    }

            $this->change_request_status_close($input->request_id, $id);

        }

    }

    public function saveInfo_sheet($id,$initiator)
    {  

        
           if (Request::isJson()) {

            $input = (object)Input::all();

            //  print_r($input);exit;
            if (isset($input->stock)) {

                $stock_data = $input->stock;
            } else {

                $stock_data = '';
            }
            if (isset($input->currentTime) && !empty($input->currentTime)) {

                $currentTime = $input->currentTime;

                $date1 = explode('.', $currentTime);
                $currentTime = $date1[2] . '-' . $date1[0] . '-' . $date1[1] . ' 00:00:00';
            } else {

                $currentTime = '';
            }

            if($input->selected == 2){
                $stock_data="";
            }else{
                $stock_data = $input->stock;
            }
            DB::table('add_update_initial_sheet')
                ->where('request_id', $id)
                ->update(
                    array(
                    'selected' => $input->selected,
                    'currentTime' => $currentTime,
                    'stock' => $stock_data,
                    'request_id' => $input->request_id


                )
            );
          }
         

    }


    public function update_risk_info_sheet()
    {
        if (Request::isJson()) {

            $input = (object)Input::all();
            if (isset($input->reason)) {
                $reason = $input->reason;
            } else {
                $reason = '---';
            }
            if (isset($input->cost)) {
                $cost = $input->cost;
            } else {
                $cost = '---';
            }
            if (isset($input->responsibility)) {
                $responsibility = $input->responsibility;
            } else {
                $responsibility = '---';
            }
            if (isset($input->currentTime)) {
                $currentTime = $input->currentTime;
            } else {
                $currentTime = '---';
            }
            if (isset($input->risk_sub_dep)) {
                $risk_sub_dep = $input->risk_sub_dep;
            } else {
                $risk_sub_dep = '---';
            }


            DB::table('tb_risk_assessment_points')->insert(
                array('request_id' => $input->request_id,
                    'assessment_point' => $input->description,
                    'reason' => $reason,
                    'risk_sub_dep' => $risk_sub_dep,
                    'cost' => $cost,
                    'applicability' => $input->selected,
                    'responsibility' => $responsibility,
                    'target_date' => $currentTime

                )
            );


        }

    }


     public function add_update_risk_analysis($request_id, $id, $user_id,$risk_ass_id,$dept_id)
    {
     $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$request_id)
              ->where('id',$id)
              ->get();
         if($checkClose[0]->close ==1){
            return 1;exit();
         }
       $StageType = DB::table('changerequests')
                    ->select('change_stage','proj_code','change_stage','plant_code','stakeholder')
                    ->where('request_id',$request_id)
                    ->get();
                  

      if($StageType[0]->change_stage == 1){
     
        $data2 = DB::table('request_progress_status')
            ->select(DB::raw('COUNT(id) as total'))

            ->where('request_progress_status.request_id', $request_id)
            ->where('request_progress_status.status', 11)
            ->where('request_progress_status.assigned_to',$risk_ass_id)
            ->where('request_progress_status.close', 0)
            ->get();

        $data3 = DB::table('request_progress_status')
            ->select(DB::raw('COUNT(id) as total'))

            ->where('request_progress_status.request_id', $request_id)
            ->where('request_progress_status.status', 9)
            ->where('request_progress_status.assigned_to',$risk_ass_id)
            ->where('request_progress_status.close', 0)
            ->get();

      
            DB::table('add_updated_risk_assessment_sheet')
                ->where('add_updated_risk_assessment_sheet.user_id',$risk_ass_id)
                ->where('add_updated_risk_assessment_sheet.r_id',$request_id)
                ->update(array(

                        'user_dep'=>$dept_id,
                        'hod' => $user_id,
                        'status' => 2,
                        'modified'=>date('Y-m-d H:i:s'),

                    )
                );


              //----start code for tracking Sheet----
               $data=DB::table('tracking_sheet_date_param')->where('id',4)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                   DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $request_id,
                          'process'     =>'Risk Assessment Approval by '.$dept_id.' HOD',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>4
                        )
                    );

                 
                $riskDept='RiskAssessment By '.$dept_id;

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $request_id)
                  ->where('status', 3)
                  ->where('process',$riskDept)
                  ->update(['actual_date' => $Date]);

                  
                 //----end code for tracking Sheet----
            $message="Pending Dept. HOD approval on Risk Assessment points";

            $url = 'changes/approval-pending-risk-assesment/';
            $last_id_req=$this->save_noticication_status($user_id, $request_id, $message, $url, 7);
            $this->change_request_status_close($request_id, $id);

            $this->update_risk_status_sheet($request_id,$dept_id);

            //=========================MAil====================
            $assignByname = DB::table('tb_users')
            ->select('tb_users.*')
            ->where('id', $risk_ass_id)
            ->get();
             $assignByName =$assignByname[0]->first_name." ".$assignByname[0]->last_name;

            $data1 = $this->get_user_info_by_id($user_id);//Assigned to task
            $request_id=$request_id;
            $close_status=$last_id_req;

            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=$assignByName;
             $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);


            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);
            if($this->check_netconnection())
            {
                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{
            }

              return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

          }else if($StageType[0]->change_stage == 2 && $StageType[0]->proj_code != ""){ 
              
               //----start code for tracking Sheet----
               $riskDept='RiskAssessment By '.$dept_id;
                $Date=date('Y-m-d');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $request_id)
                  ->where('status', 3)
                  ->where('process',$riskDept)
                  ->update(['actual_date' => $Date]);
                  
                 //----end code for tracking Sheet----

              DB::table('add_updated_risk_assessment_sheet')
                    ->where('add_updated_risk_assessment_sheet.user_department', Session::get('dep_id'))
                    ->where('add_updated_risk_assessment_sheet.r_id', $request_id)
                    ->update(array(
                             'user_dep'=>$dept_id,
                            'user_dep_hod_approve' => Session::get('dep_id'),
                            'hod' =>   $user_id,
                            'status' => 3,
                        )
                    );

                $riskApp = DB::table('tb_projectMaster')
                    ->select('project_manager')
                    ->where('id',$StageType[0]->proj_code)
                    ->get();
                    
                    
                
                      $data1 = DB::table('tb_users')
                            // ->leftJoin('subdepartments', 'tb_users.sub_department', '=', 'subdepartments.sub_dep_id')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', $riskApp[0]->project_manager)
                            ->get();


             foreach ($data1 as $value) {
                    $email_send = (String)$value->email;

                    $message = "Pending approval on Risk Assessment points.";

                    $url = 'changes/approve-all-risk-assesment/';
                    // $url = 'changes/approve-allrisk-assesment/';

                    $this->save_noticication_status_temp((String)$value->id, $request_id, $message, $url, 8);
                    $this->change_request_status_close($request_id, $id);

                    $id_user = DB::table('request_progress_status')
                        ->select('request_progress_status.assigned_to')
                        ->where('request_progress_status.id', $id)
                        ->first();


                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $request_id,
                            'status' => 1,
                            'user_id' => $id_user->assigned_to,
                            'comment' => '',


                        )
                    );

                }


                $data = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 6)
                    ->get();

                $data_1 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 7)
                    ->get();


                $data_2 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 9)
                    ->get();


                $data_3 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 11)
                    ->get();

                $data_4 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 99)
                    ->get();

                if ($data[0]->total == 0 && $data_1[0]->total == 0 && $data_2[0]->total == 0 && $data_3[0]->total == 0 && $data_4[0]->total == 0) {

                 //----start code for tracking Sheet----
                 $data=DB::table('tracking_sheet_date_param')->where('id',5)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                    DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $request_id,
                          'process'     =>'Superadmin Approval of Risk Approval',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>5
                        )
                    );
                  //----end code for tracking Sheet----


                    $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        //  ->distinct('request_progress_status_temp.assigned_to')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status', 8)
                        ->where('request_progress_status_temp.request_id', $request_id)
                        ->get();
                     
                    foreach ($data1 as $risk) {

                        $last_id_req = $this->save_noticication_status($risk->assigned_to, $request_id, $message, $url, 8);

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task


                        $request_id = $request_id;
                        $close_status = $last_id_req;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby = Session::get('fid');
                        $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status);


                        if ($this->check_netconnection()) {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        } else {


                        }

                    }

                }

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

              }else if($StageType[0]->change_stage == 2 && $StageType[0]->proj_code == ""){ 
               
                  //----start code for tracking Sheet----
               $riskDept='RiskAssessment By '.$dept_id;
                $Date=date('Y-m-d');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $request_id)
                  ->where('status', 3)
                  ->where('process',$riskDept)
                  ->update(['actual_date' => $Date]);
                  
                 //----end code for tracking Sheet----


               DB::table('add_updated_risk_assessment_sheet')
                    ->where('add_updated_risk_assessment_sheet.user_department', Session::get('dep_id'))
                    ->where('add_updated_risk_assessment_sheet.r_id', $request_id)
                    ->update(array(
                             'user_dep'=>$dept_id,
                            'user_dep_hod_approve' => Session::get('dep_id'),
                            'hod' =>   $user_id,
                            'status' => 3,
                        )
                    );

                $riskApp = DB::table('tb_project_manager')
                    ->select('proj_mgr_id')
                    ->where('change_stage',$StageType[0]->change_stage)
                    ->where('stakeholder',$StageType[0]->stakeholder)
                    ->where('plant_code',$StageType[0]->plant_code)
                    ->get();
                    
                    
                
                      $data1 = DB::table('tb_users')
                            // ->leftJoin('subdepartments', 'tb_users.sub_department', '=', 'subdepartments.sub_dep_id')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', $riskApp[0]->proj_mgr_id)
                            ->get();


             foreach ($data1 as $value) {
                    $email_send = (String)$value->email;

                    $message = "Pending approval on Risk Assessment points.";

                    $url = 'changes/approve-all-risk-assesment/';
                    // $url = 'changes/approve-allrisk-assesment/';

                    $this->save_noticication_status_temp((String)$value->id, $request_id, $message, $url, 8);
                    $this->change_request_status_close($request_id, $id);

                    $id_user = DB::table('request_progress_status')
                        ->select('request_progress_status.assigned_to')
                        ->where('request_progress_status.id', $id)
                        ->first();


                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $request_id,
                            'status' => 1,
                            'user_id' => $id_user->assigned_to,
                            'comment' => '',


                        )
                    );

                }


                $data = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 6)
                    ->get();

                $data_1 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 7)
                    ->get();


                $data_2 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 9)
                    ->get();


                $data_3 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 11)
                    ->get();

                $data_4 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 99)
                    ->get();

                //  print_r($data[0]->total);exit;

                if ($data[0]->total == 0 && $data_1[0]->total == 0 && $data_2[0]->total == 0 && $data_3[0]->total == 0 && $data_4[0]->total == 0) {
                   
                   if(empty($riskApp)){
                    return 0;
                   }else{
                    //----start code for tracking Sheet----
                 $data=DB::table('tracking_sheet_date_param')->where('id',5)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                    DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $request_id,
                          'process'     =>'Superadmin Approval of Risk Approval',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>5
                        )
                    );
                  //----end code for tracking Sheet----

                    $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        //  ->distinct('request_progress_status_temp.assigned_to')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status', 8)
                        ->where('request_progress_status_temp.request_id', $request_id)
                        ->get();
                     
                    foreach ($data1 as $risk) {

                        $last_id_req = $this->save_noticication_status($risk->assigned_to, $request_id, $message, $url, 8);

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task


                        $request_id = $request_id;
                        $close_status = $last_id_req;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby = Session::get('fid');
                        $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status);


                        if ($this->check_netconnection()) {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        } else {


                        }

                    }
                  }

                }

                //return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

              }

    }

   

    public function delete_table_data($id)
    {
        DB::table('tb_risk_assessment_points')->where('risk_assessment_id', '=', $id)->delete();

        return Response::json(array('success' => true));
    }

    public function edit_table_data($id,$risk_ass_id,$dept_id)
    {

         $data = DB::table('tb_risk_assessment_points')
            ->leftJoin('tb_risk_assessment_points_admin', 'tb_risk_assessment_points_admin.risk_assessment_id_admin', '=', 'tb_risk_assessment_points.risk_assessment_id_admin')
            ->select('tb_risk_assessment_points_admin.assessment_point_department', 'tb_risk_assessment_points.*')
            ->where('tb_risk_assessment_points.risk_dep', '=', $dept_id)
            ->where('tb_risk_assessment_points.responsibility', '=',$risk_ass_id)
            ->where('tb_risk_assessment_points.risk_assessment_id', '=', $id)
            ->get();

       // print_r($data);exit;

        if($data[0]->target_date=='0000-00-00'){
            $target_date='';
        }else if($data[0]->target_date==''){
            $target_date='';
        }else{


            $target_date=Carbon::createFromFormat('Y-m-d', $data[0]->target_date)->format('d.m.Y');

        }

        if($data[0]->cost=='0'){

            $cost='';

        }else{

            $cost=$data[0]->cost;

        }
         if($data[0]->piececost=='0'){

            $piececost='';

        }else{

            $piececost=$data[0]->piececost;

        }

        if($data) {

            $purpose = array(
                'assessment_point_department' => $data[0]->assessment_point_department,
                'risk_assessment_id' => $data[0]->risk_assessment_id ,
                'request_id' => $data[0]->request_id,
                'risk_dep' => $data[0]->risk_dep,
                'risk_assessment_id_admin' => $data[0]->risk_assessment_id_admin,
                'applicability' => $data[0]->applicability,
                'reason' => $data[0]->reason,
                'responsibility' => $data[0]->responsibility,
                'target_date' =>$target_date,
                'cost' =>$cost,
                'piececost'=>$piececost,
                'status' => $data[0]->status,
                'de_risking' => $data[0]->de_risking,
                'status_activity_monitoring' => $data[0]->status_activity_monitoring,
                'status_verification' => $data[0]->status_verification,

            );
            return $purpose;
        }

    }
    public function checkProjCodeAvl($id){
     $code = DB::table('changerequests')
        ->select('proj_code','change_stage')
        ->where('request_id',$id)
        ->get();
        if($code[0]->proj_code != "" && $code[0]->change_stage ==2) {
            return 1;
        }else{
          return 0;
        }

    }

    public function fetch_table_data($id)
    {


        return   $departments = DB::table('tb_updatesheet_dep_team')
            ->leftJoin('tb_users', 'tb_updatesheet_dep_team.department', '=', 'tb_users.department')
            ->leftJoin('tb_departments', 'tb_updatesheet_dep_team.department', '=', 'tb_departments.d_id')
            ->select('tb_updatesheet_dep_team.*','tb_departments.d_name','tb_users.first_name','tb_users.last_name','tb_users.id','tb_users.group_id')
            ->where('tb_updatesheet_dep_team.update_sheet_dep_id','=', $id)
            ->where('tb_users.id','!=', 1)
            ->where('tb_users.active',1)
		        ->where('tb_users.group_id','LIKE','%3%')  
            ->get();
 }

 

  public function fetch_table_data_asDept($id)
    {

        return   $departments = DB::table('tb_users')
            ->leftJoin('tb_departments', 'tb_users.department', '=', 'tb_departments.d_id')
            ->select('tb_departments.d_name','tb_users.first_name','tb_users.last_name','tb_users.id','tb_users.group_id')
            ->where('tb_departments.d_id','=', $id)
            ->where('tb_users.id','!=', 1)
            ->where('tb_users.active',1)
            ->where('tb_users.group_id','LIKE','%3%')  
            ->get();
 }



    //Edit Function for Add change request

 public function completeAllPoints($r_id,$d_id){

                $cost = '';
                $target_date = '';
                $de_risking = '';
                $reason = 'N/A';

      DB::table('tb_risk_assessment_points')
      ->where('request_id', $r_id)
      ->where('risk_dep',$d_id)
      ->where('status',1)
                ->update(array(

                        'reason' => $reason,
                        'de_risking' => $de_risking,
                        'cost' => $cost,
                        'applicability' =>2,
                        'target_date' => $target_date,
                        'status' => 2


                    )
                );
                
 }
    public function update_table_record($id)
    {

            $input = (object)Input::all();

            if(isset($input->piececost)){
              $piececost=$input->piececost;
            }else{
              $piececost= '';
            }
            if ($input->applicability == 2) {

                $cost = '';
              
                $target_date = '';
                $de_risking = '';
                $reason = $input->reason;
                $costperpiece='';

            } else {

                $costperpiece = $piececost;
                $cost = $input->cost;

                $target_date =Carbon::createFromFormat('d.m.Y',$input->target_date)->format('Y-m-d');
                $de_risking = $input->de_risking;
                $reason = '';
                $target_date1 = date("d-m-y", strtotime($input->target_date));
      if(date("d-m-y", strtotime($target_date1)) < date("d-m-y", strtotime(date('d-m-y'))) ){
       echo "0";exit;
      }
            }

          


            DB::table('tb_risk_assessment_points')->where('risk_assessment_id', $id)
                ->update(array(

                        'reason' => $reason,
                        'de_risking' => $de_risking,
                        'cost' => $cost,
                        'piececost'=>$costperpiece,
                        'applicability' => $input->applicability,
                        'target_date' => $target_date,
                        'status' => 2


                    )
                );
                echo "1";exit();


    }

    public function check_risk_admin_sheet_to_user_status($id, $id1,$resp)
    {

        $user1 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('COUNT(risk_assessment_id) as total'))
            ->where('tb_risk_assessment_points.request_id', $id)
            ->where('tb_risk_assessment_points.responsibility',$resp)
            ->get();

        $user2 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('COUNT(risk_assessment_id) as total'))
            ->where('tb_risk_assessment_points.request_id', $id)
            ->where('tb_risk_assessment_points.status', 2)
            ->where('tb_risk_assessment_points.responsibility',$resp)
            ->get();

        if ($user1[0]->total == $user2[0]->total) {
            return 1;
        } else {
            return 0;
        }
    }

    public function check_save_customer_communication_decision($id)
    {

        $user1 = DB::table('Customer_Communication_list')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('Customer_Communication_list.request_id', $id)
           // ->where('Customer_Communication_list.decision', 1)
            ->get();


        if ($user1[0]->total == 0) {
            return 1;
        } else {
            return 0;
        }

      

    }

    public function check_department_sheet_to_user_status($id, $id1)
    {
        
        $user1 = DB::table('tb_updatesheet_dep_team')
            ->select(DB::raw('COUNT(update_sheet_dep_id) as total'))
            ->where('tb_updatesheet_dep_team.request_id', $id)
           // ->where('tb_updatesheet_dep_team.responsibility', Session::get('uid'))
            ->get();



        $user2 = DB::table('tb_updatesheet_dep_team')
            ->select(DB::raw('COUNT(update_sheet_dep_id) as total'))
            ->where('tb_updatesheet_dep_team.request_id', $id)
            ->where('tb_updatesheet_dep_team.fetch_status', 2)
          //  ->where('tb_updatesheet_dep_team.responsibility', Session::get('uid'))
            ->get();

        if ($user1[0]->total == $user2[0]->total) {
            return 1;
        } else {
            return 0;
        }
    }
    public function check_filled_user($id)
    {
      
        $user1 = DB::table('tb_updatesheet_dep_team')
            ->select(DB::raw('COUNT(update_sheet_dep_id) as total'))
            ->where('tb_updatesheet_dep_team.request_id', $id)
           // ->where('tb_updatesheet_dep_team.responsibility', Session::get('uid'))
            ->get();

        $user2 = DB::table('tb_updatesheet_dep_team')
            ->select(DB::raw('COUNT(update_sheet_dep_id) as total'))
            ->where('tb_updatesheet_dep_team.request_id', $id)
            ->where('tb_updatesheet_dep_team.fetch_status', 2)
          //  ->where('tb_updatesheet_dep_team.responsibility', Session::get('uid'))
            ->get();

        if ($user1[0]->total == $user2[0]->total) {
            return 1;
        } else {
            return 0;
        }
    }



    //===============================================================
    //
    //  approval_pending_risk_assesment
    //
    //===============================================================
    public function approval_pending_risk_assesment($id, $id1)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
     }else{   
        if ($this->check_request_permission($id)) {

            return View::make('changes/approval-pending-risk-assesment');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }
      }


    }

    public function get_sterring_committee()
    {

        $data = DB::table('tb_users')
            ->select('tb_users.username', 'tb_users.group_id', 'tb_users.email')
            ->where('group_id', 6)
            ->get();

        return $data;
    }

    /*
    public function fetch_sub_dep(){

       $data = DB::table('subdepartments')
              ->select('subdepartments.sub_dep_id','subdepartments.sub_dep_name')
              ->where('department_id', 2)
              ->get();

              return $data;
      }*/

    public function fetch_sterring_committee_department($id,$r_id)
    {

        $res = [];
        

         $changeReqData = DB::table('changerequests')
         ->select('plant_code','stakeholder','change_stage','changeType')
         ->where('request_id',$r_id)
         ->get();
         
         if($changeReqData[0]->change_stage==1){
          $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
         ->select('steeringComm_id')
         ->where('plant_id',$changeReqData[0]->plant_code)
         ->where('stakeholder',$changeReqData[0]->stakeholder)
         ->where('change_stage',$changeReqData[0]->change_stage)
         ->where('change_type',$changeReqData[0]->changeType)
         ->get();
         }else{
         $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
         ->select('steeringComm_id')
         ->where('plant_id',$changeReqData[0]->plant_code)
         ->where('stakeholder',$changeReqData[0]->stakeholder)
         ->where('change_stage',$changeReqData[0]->change_stage)
         ->get();
         }

          if(!empty($steerCommMem)) {
           $memId = explode(',', $steerCommMem[0]->steeringComm_id);
          $count = count($memId);
         }else{
          echo 0;exit();
         }
         
        for($i=0;$i<$count;$i++){
            $res[] = array(
                'sub_dep_id' => $this->getSteeCommDept($memId[$i]),
                'sub_dep_name' => $this->getSteeCommDeptName($memId[$i]),
                'members' => $this->get_steering_committee_($memId[$i]),
            );
        }  
      
        
        return $res;



    }
    public function getSteeCommDept($id){
       $data = DB::table('tb_users')
            ->select('tb_users.sub_department')
            ->where('id', $id)
          
            ->get();
          

      $datas = DB::table('subdepartments')
            ->select('subdepartments.sub_dep_id', 'subdepartments.sub_dep_name')
            ->where('sub_dep_id',$data[0]->sub_department)
            ->get();

             return $datas[0]->sub_dep_id;

    }
    public function getSteeCommDeptName($id){
      $data = DB::table('tb_users')
            ->select('tb_users.sub_department')
            ->where('id', $id)
            ->get();
            
      $datas = DB::table('subdepartments')
            ->select('subdepartments.sub_dep_name')
            ->where('sub_dep_id',$data[0]->sub_department)
            ->get();
            return $datas[0]->sub_dep_name;

            
    }
    public function get_steering_committee_($id)
    {
        $data = DB::table('tb_users')
            ->select('tb_users.first_name', 'tb_users.last_name', 'tb_users.group_id', 'tb_users.id','tb_users.email')
            ->where('id', $id)
            ->where('tb_users.active',1)
            ->first();
        return $data;


    }

    public function steering_committee_($id)
    {
        $data = DB::table('tb_users')
            ->select('tb_users.first_name', 'tb_users.last_name', 'tb_users.group_id', 'tb_users.id')
            ->where('sub_department', $id)
             ->where('tb_users.active',1)
            ->get();
        return $data;


    }
    public function checkRiskPointSaved($id){
      $data = DB::table('tb_risk_assessment_points')
              ->select('risk_assessment_id_admin')
              ->where('request_id',$id)
              ->where('risk_dep',Session::get('dep_id'))
              ->get();
       if(!empty($data)){
         return 1;
       }else{
         return 0;
       }       
    }

     public function checkRiskPointSavedadmin($id){
      $data = DB::table('tb_updatesheet_dep_team')
              ->join('tb_departments','tb_departments.d_id','=','tb_updatesheet_dep_team.department')
              ->select('department','d_name')
              ->where('request_id',$id)
              ->get();
              $f=0;
       if(!empty($data)){
        foreach($data as $row){
        
           $data1 = DB::table('tb_risk_assessment_points')
             
              ->select('risk_assessment_id_admin')
              ->where('request_id',$id)
              ->where('risk_dep',$row->department)
              ->get();
              if(empty($data1)){
                return $row->d_name;
              }else{
                return 0;
              }
        }
       }       

          
    }



    public function add_pending_approval($id, $id1)
    {
        $input = (object)Input::all();

        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }

        if ($input->radioStatus == 2) {

          $holdId=DB::table('tb_holdchangerequests')
                  ->select('r_id')
                  ->where('r_id',$input->request_id)
                  ->where('userId',Session::get('uid')) 
                  ->get();
           // print_r($holdId);exit();
           if(!empty($holdId)){
              DB::table('tb_holdchangerequests')
                ->where('r_id', $input->request_id)
                ->where('userId',Session::get('uid'))
                ->update(
                  array('flag' => 0,
                  )
              );

         }  
         
          $user_id = $this->get_assigned_by_user_id($id1);

                $data = DB::table('tb_users')
                        ->select('id')
                        ->where('active',1)
                        ->where('id',$user_id)
                        ->get();
                        if(empty($data)){
                          return Redirect::back()
                        ->with('message', SiteHelpers::alert('error','User is not active you can not reject task'))
                        ->withInput();
                        }


          //reject mail code----
          if(isset($input->dept)){
                         
          foreach ($input->dept as $row) {
           $allUser[] = DB::table('add_updated_risk_assessment_sheet')
            ->select('user_id')
            ->where('user_department',$row)
            ->where('r_id',$input->request_id)
            ->get();

          }


              $initiator = DB::table('changerequests')
            ->select('changerequests.initiator_id')
            ->where('changerequests.request_id', $input->request_id)
            ->get(); 
           
          $sendIni = 'send';
          foreach ($allUser as $row){

            $hoddept[] = DB::table('tb_users')
                  ->select('department','sub_department')
                  ->where('id',$row[0]->user_id)
                  ->get();

                  if($initiator[0]->initiator_id == $row[0]->user_id){
                      $sendIni = 'nosend';
                  }
         
          }
          $cnt = 0;
           foreach ($hoddept as $row){
            
            $allhod[$cnt] = DB::table('tb_users')
                  ->select('id','department')
                  ->whereRaw("find_in_set(4,tb_users.group_id)")
                  ->where('department',$row[0]->department)
                  ->where('sub_department',$row[0]->sub_department)
                  ->get();


                  if($allhod[$cnt] == []){
                      $allhod[$cnt]= DB::table('tb_users')
                  ->select('id','department')
                  ->whereRaw("find_in_set(4,tb_users.group_id)")
                  ->where('department',$row[0]->department)
                  ->take(1)
                  ->get();
                  }
                  $cnt = $cnt+1;


          }

             $hod = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id',$input->request_id)
            ->get();
           


           $sendHOD = 'send';
           foreach ($allhod as $row){

               
                 $cftHodTeam[] = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$row[0]->id)
                  ->where('active',1)
                  ->get();
              
                
                  if($hod[0]->Approval_Authority == $row[0]->id){
                      $sendHOD = 'nosend';
                  }
         
                }
               
           
                foreach ($allUser as $row) {
                 
                  $cftTeam[] = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$row[0]->user_id)
                  ->get();
                }


              $all =  array_unique(array_merge($cftTeam,$cftHodTeam), SORT_REGULAR);

             
   
              $holdBy = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',Session::get('uid'))
                  ->get();
              
                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$input->request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();


                 $admin = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('group_id',1)
                  ->get();
                  
                  $toname=$admin[0]->first_name.' '.$admin[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Rejected By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name;

               
            $email_id = $admin[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'description' =>$input->comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-reject', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Reject Task');

                });
            } else {

            }
   

               if($sendIni == 'send' ){
                 $initiat = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$initiator[0]->initiator_id)
                  ->get(); 

                  $toname=$initiat[0]->first_name.' '.$initiat[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Rejected By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name;

               
            $email_id = $initiat[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'description' =>$input->comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-reject', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Reject Task');

                });
            } else {

            }
          }
            if($initiator[0]->initiator_id != $hod[0]->Approval_Authority){
             if($sendHOD == 'send'){
                 $HOD = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$hod[0]->Approval_Authority)
                  ->get(); 

                  $toname=$HOD[0]->first_name.' '.$HOD[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Rejected By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name
          
            ;

               
            $email_id = $HOD[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'description' =>$input->comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-reject', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Reject Task');

                });
            } else {

            }
          } 
        }


                  foreach ($all as $row) {
              
                
                    $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$input->request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();

                  
               $toname=$row[0]->first_name.' '.$row[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Rejected By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name;

               
            $email_id = $row[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'description' =>$input->comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-reject', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Reject Task');

                });
            } else {


            }
          }

          
        }
        //---------------------------------

            $data2 = DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_progress_status.request_id', $input->request_id)
                ->where('request_progress_status.status', 7)
                ->where('request_progress_status.assigned_to', Session::get('uid'))
                ->where('request_progress_status.close', 0)
                ->get();

            $data3 = DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_progress_status.request_id', $input->request_id)
                ->where('request_progress_status.status', 9)
                ->where('request_progress_status.assigned_to', Session::get('uid'))
                ->where('request_progress_status.close', 0)
                ->get();

                //------trackingSheet reject by hod------
               DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 3)
                  ->where('process','RiskAssessment By '.Session::get('dep_id'))
                  ->update(['actual_date' => 0]);

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 4)
                  ->where('process','Risk Assessment Approval by '.Session::get('dep_id').' HOD')
                  ->delete();

               //------------end------------   

            if ($data2[0]->total > 1) { //echo "in 
                if ($input != '') {


                    $id_user = DB::table('request_progress_status')

                        ->select('request_progress_status.assigned_by')
                        ->where('request_progress_status.id', $id1)
                        ->first();

                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $input->request_id,
                            'status' => $input->radioStatus,
                            'user_id' =>$id_user->assigned_by,
                            'comment' => $input->comment,
                            // 'sub_dep_id' => $input->cid[$i]

                        )
                    );

                 

                }

                $user_id = $this->get_assigned_by_user_id($id1);

                
                $users_detail = $this->get_user_info_by_id($user_id);


                $message="Rejected by Dept. HOD. Pending clearance of Risk Assessment point activities from CFT Dept.";

                $url = 'changes/update-risk-analysis-sheet/';

                $last_id_req=$this->save_noticication_status_for_reject($user_id, $id, $message, $url, 9,$input->comment);
                $admin = $this->get_user_info_by_id(1);
                $data1 = $this->get_user_info_by_id($user_id);//Assigned to task
                $comment=$input->comment;

                $request_id=$id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                $admin_email=$admin['email'];
                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'comment'=>$comment);



                if($this->check_netconnection())
                {
                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id,$admin_email) {
                        $message->to($email_id);
                        $message->bcc($admin_email)
                            ->subject('You Have New Task');
                    });

                }else{

                }

                $this->change_request_status_close($id, $id1);

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));


            }else if ($data3[0]->total > 1) {//echo 'in second';exit;

                if ($input != '') {

                    $id_user = DB::table('request_progress_status')
                        ->select('request_progress_status.assigned_by')
                        ->where('request_progress_status.id', $id1)
                        ->first();

                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $input->request_id,
                            'status' => $input->radioStatus,
                            'user_id' => $id_user->assigned_by,
                            'comment' => $input->comment,
                            // 'sub_dep_id' => $input->cid[$i]

                        )
                    );

                
                }

                $user_id = $this->get_assigned_by_user_id($id1);

                
                $users_detail = $this->get_user_info_by_id($user_id);


                $message = "Rejected by Dept. HOD. Pending clearance of Risk Assessment point activities from CFT Dept.";

                $url = 'changes/update-risk-analysis-sheet/';

                $last_id_req = $this->save_noticication_status_for_reject($user_id, $id, $message, $url, 9, $input->comment);
                $admin = $this->get_user_info_by_id(1);
                $data1 = $this->get_user_info_by_id($user_id);//Assigned to task
                $comment = $input->comment;

                $request_id = $id;
                $close_status = $last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby = Session::get('fid');
                $admin_email = $admin['email'];
                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status, 'comment' => $comment);


                if ($this->check_netconnection()) {
                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id, $admin_email) {


                        $message->to($email_id);
                        $message->bcc($admin_email)
                            ->subject('You Have New Task');

                    });

                } else {

                }

                $this->change_request_status_close($id, $id1);

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }else{ //echo "in last";exit;

                if ($input != '') {

                    $id_user = DB::table('request_progress_status')
                        ->select('request_progress_status.assigned_by')
                        ->where('request_progress_status.id', $id1)
                        ->first();

                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $input->request_id,
                            'status' => $input->radioStatus,
                            'user_id' => $id_user->assigned_by,
                            'comment' => $input->comment,
                            // 'sub_dep_id' => $input->cid[$i]

                        )
                    );

                    DB::table('add_updated_risk_assessment_sheet')
                        ->where('add_updated_risk_assessment_sheet.hod', Session::get('uid'))
                        ->where('add_updated_risk_assessment_sheet.r_id', $input->request_id)
                        ->update(array(
                                'user_dep' => 0,
                                'status' => 1,
                               // 'modified'=>date('Y-m-d H:i:s'),

                            )
                        );

                }

                $user_id = $this->get_assigned_by_user_id($id1);

                   

                $users_detail = $this->get_user_info_by_id($user_id);


                $message = "Rejected by Dept. HOD. Pending clearance of Risk Assessment point activities from CFT Dept.";

                $url = 'changes/update-risk-analysis-sheet/';

                $last_id_req = $this->save_noticication_status_for_reject($user_id, $id, $message, $url, 9, $input->comment);
                $admin = $this->get_user_info_by_id(1);
                $data1 = $this->get_user_info_by_id($user_id);//Assigned to task
                $comment = $input->comment;

                $request_id = $id;
                $close_status = $last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby = Session::get('fid');
                $admin_email = $admin['email'];
                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status, 'comment' => $comment);




                if ($this->check_netconnection()) {
                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id, $admin_email) {


                        $message->to($email_id);
                        $message->bcc($admin_email)
                            ->subject('You Have New Task');

                    });

                } else {

                }

                $this->change_request_status_close($id, $id1);

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));



            }

        } else if($input->radioStatus == 1){


            /*

                    Following function is for accept approval on risk assessment form

            */
           $holdId=DB::table('tb_holdchangerequests')
                  ->select('r_id')
                  ->where('r_id',$input->request_id)
                  ->where('userId',Session::get('uid')) 
                  ->get();
           // print_r($holdId);exit();
           if(!empty($holdId)){
              DB::table('tb_holdchangerequests')
                ->where('r_id', $input->request_id)
                ->where('userId',Session::get('uid'))
                ->update(
                  array('flag' => 0,
                  )
              );

         }   

            $data2 = DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_progress_status.request_id', $input->request_id)
                ->where('request_progress_status.status', 7)
                ->where('request_progress_status.assigned_to', Session::get('uid'))
                ->where('request_progress_status.close', 0)
                ->get();

            $data3 = DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_progress_status.request_id', $input->request_id)
                ->where('request_progress_status.status', 9)
                ->where('request_progress_status.assigned_to', Session::get('uid'))
                ->where('request_progress_status.close', 0)
                ->get();

                  //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',5)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));

                $cntHodapp=DB::table('add_updated_risk_assessment_sheet')
                          ->select(DB::raw('COUNT(id) as total'))
                          ->where('r_id',$input->request_id)
                          ->where('user_dep_hod_approve',0)
                          ->get();
                         

                  if($cntHodapp[0]->total == 1){
                    $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$input->authority)
                    ->get();

                     if($input->authority == "" || (empty($data))){   


                        return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }
                    
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'Superadmin Approval of Risk Approval',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>5
                        )
                    );
                }
              
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 4)
                  ->where('process','Risk Assessment Approval by '.Session::get('dep_id').' HOD')
                  ->update(['actual_date' => $Date]);

                 
                 //----end code for tracking Sheet----
                 
            if ($data2[0]->total > 1) { //echo 'in first';exit;
                  
             $stage=DB::table('changerequests')
                      ->select('change_stage','stakeholder','plant_code')
                      ->where('request_id',$input->request_id) 
                      ->get();
                if($stage[0]->change_stage==1){
                  $ini=DB::table('tb_documentverifyconfig')
                      ->select('riskmember')
                      ->where('change_stage',$stage[0]->change_stage)
                      ->where('plant_code',$stage[0]->plant_code)
                      ->where('stakeholder',$stage[0]->stakeholder)
                      ->get();
                      if(empty($ini[0]->riskmember)){ 
                          return Redirect::back()
                        ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                        ->withInput();
                      }else{  
                        $data1 = DB::table('tb_users')
                              ->select('tb_users.email', 'tb_users.id')
                              ->where('tb_users.id', $ini[0]->riskmember)
                              ->get();
                      }   
                }else{  

                $riskApp = DB::table('tb_dept_addRemove')
                    ->select('RiskAssApprove')
                    ->get();
                if($riskApp[0]->RiskAssApprove == 'Superadmin'){
                      $data1 = DB::table('tb_users')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', 1)
                            ->get();
                }else{
                      $ini = DB::table('changerequests')
                      ->select('initiator_id')
                      ->where('request_id',$id)
                      ->get();

                        $data1 = DB::table('tb_users')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', $ini[0]->initiator_id)
                            ->get();
                }

              }

        
                // print_r($data2);exit;


                foreach ($data1 as $value) {
                    $email_send = (String)$value->email;

                    $message = "Pending approval on Risk Assessment points.";

                    $url = 'changes/approve-all-risk-assesment/';
                    // $url = 'changes/approve-allrisk-assesment/';

                    $this->save_noticication_status_temp((String)$value->id, $input->request_id, $message, $url, 8);
                    $this->change_request_status_close($id, $id1);

                    $id_user = DB::table('request_progress_status')
                        ->select('request_progress_status.assigned_by')
                        ->where('request_progress_status.id', $id1)
                        ->first();


                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $input->request_id,
                            'status' => $input->radioStatus,
                            'user_id' => $id_user->assigned_by,
                            'comment' => '',


                        )
                    );

                }


                $data = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 6)
                    ->get();

                $data_1 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 7)
                    ->get();


                $data_2 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 9)
                    ->get();


                $data_3 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 11)
                    ->get();

                $data_4 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 99)
                    ->get();

                //  print_r($data[0]->total);exit;

                if ($data[0]->total == 0 && $data_1[0]->total == 0 && $data_2[0]->total == 0 && $data_3[0]->total == 0 && $data_4[0]->total == 0) {
                    $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        //  ->distinct('request_progress_status_temp.assigned_to')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status', 8)
                        ->where('request_progress_status_temp.request_id', $input->request_id)
                        ->get();
                    //  print_r($data1);exit;
                    foreach ($data1 as $risk) {

                        $last_id_req = $this->save_noticication_status($risk->assigned_to, $input->request_id, $message, $url, 8);

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task


                        $request_id = $id;
                        $close_status = $last_id_req;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby = Session::get('fid');
                  $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status);


                        if ($this->check_netconnection()) {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        } else {


                        }

                    }

                }

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));


            } else if ($data3[0]->total >=1) { //echo 'in second';exit;
               
                DB::table('add_updated_risk_assessment_sheet')
                    ->where('add_updated_risk_assessment_sheet.hod', Session::get('uid'))
                    ->where('add_updated_risk_assessment_sheet.r_id', $input->request_id)
                    ->update(array(
                            'user_dep' => 0,
                            'status' => 1,
                          //  'modified'=>date('Y-m-d H:i:s'),

                        )
                    );


                $stage=DB::table('changerequests')
                      ->select('change_stage','stakeholder','plant_code')
                      ->where('request_id',$input->request_id) 
                      ->get();
                if($stage[0]->change_stage==1){
                  $ini=DB::table('tb_documentverifyconfig')
                      ->select('riskmember')
                      ->where('change_stage',$stage[0]->change_stage)
                      ->where('plant_code',$stage[0]->plant_code)
                      ->where('stakeholder',$stage[0]->stakeholder)
                      ->get();
                      if(empty($ini[0]->riskmember)){ 
                          return Redirect::back()
                        ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                        ->withInput();
                      }else{  
                        $data1 = DB::table('tb_users')
                              ->select('tb_users.email', 'tb_users.id')
                              ->where('tb_users.id', $ini[0]->riskmember)
                              ->get();
                      }   
                }else{  

                $riskApp = DB::table('tb_dept_addRemove')
                    ->select('RiskAssApprove')
                    ->get();
                if($riskApp[0]->RiskAssApprove == 'Superadmin'){
                      $data1 = DB::table('tb_users')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', 1)
                            ->get();
                }else{
                      $ini = DB::table('changerequests')
                      ->select('initiator_id')
                      ->where('request_id',$id)
                      ->get();

                        $data1 = DB::table('tb_users')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', $ini[0]->initiator_id)
                            ->get();
                }

              }


                // print_r($data2);exit;


                foreach ($data1 as $value) {
                    $email_send = (String)$value->email;

                    $message = "Pending approval on Risk Assessment points.";

                    $url = 'changes/approve-all-risk-assesment/';
                    // $url = 'changes/approve-allrisk-assesment/';

                    $this->save_noticication_status_temp((String)$value->id, $input->request_id, $message, $url, 8);
                    $this->change_request_status_close($id, $id1);

                    $id_user = DB::table('request_progress_status')
                        ->select('request_progress_status.assigned_by')
                        ->where('request_progress_status.id', $id1)
                        ->first();


                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $input->request_id,
                            'status' => $input->radioStatus,
                            'user_id' => $id_user->assigned_by,
                            'comment' => '',
                        )
                    );

                }


                $data = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 6)
                    ->get();

                $data_1 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 7)
                    ->get();


                $data_2 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 9)
                    ->get();


                $data_3 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 11)
                    ->get();

                $data_4 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 99)
                    ->get();

                //  print_r($data[0]->total);exit;

                if ($data[0]->total == 0 && $data_1[0]->total == 0 && $data_2[0]->total == 0 && $data_3[0]->total == 0 && $data_4[0]->total == 0) {
                    $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status', 8)
                        ->where('request_progress_status_temp.request_id', $input->request_id)
                        ->get();
                    foreach ($data1 as $risk) {

                        $last_id_req = $this->save_noticication_status($risk->assigned_to, $input->request_id, $message, $url, 8);

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task


                        $request_id = $id;
                        $close_status = $last_id_req;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby = Session::get('fid');
                        $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status);


                        if ($this->check_netconnection()) {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        } else {


                        }

                    }

                }

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

            } else {  //echo 'in last';exit;

                DB::table('add_updated_risk_assessment_sheet')
                    ->where('add_updated_risk_assessment_sheet.hod', Session::get('uid'))
                    ->where('add_updated_risk_assessment_sheet.r_id', $input->request_id)
                    ->update(array(

                            'user_dep_hod_approve' => Session::get('dep_id'),
                            'hod' => Session::get('uid'),
                            'status' => 3,
                           // 'modified'=>date('Y-m-d H:i:s'),

                        )
                    );


                $stage=DB::table('changerequests')
                      ->select('change_stage','stakeholder','plant_code')
                      ->where('request_id',$input->request_id) 
                      ->get();
                if($stage[0]->change_stage==1){
                  $ini=DB::table('tb_documentverifyconfig')
                      ->select('riskmember')
                      ->where('change_stage',$stage[0]->change_stage)
                      ->where('plant_code',$stage[0]->plant_code)
                      ->where('stakeholder',$stage[0]->stakeholder)
                      ->get();
                      if(empty($ini[0]->riskmember)){ 
                          return Redirect::back()
                        ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                        ->withInput();
                      }else{  
                        $data1 = DB::table('tb_users')
                              ->select('tb_users.email', 'tb_users.id')
                              ->where('tb_users.id', $ini[0]->riskmember)
                              ->get();
                      }   
                }else{  

                $riskApp = DB::table('tb_dept_addRemove')
                    ->select('RiskAssApprove')
                    ->get();
                if($riskApp[0]->RiskAssApprove == 'Superadmin'){
                      $data1 = DB::table('tb_users')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', 1)
                            ->get();
                }else{
                      $ini = DB::table('changerequests')
                      ->select('initiator_id')
                      ->where('request_id',$id)
                      ->get();

                        $data1 = DB::table('tb_users')
                            ->select('tb_users.email', 'tb_users.id')
                            ->where('tb_users.id', $ini[0]->initiator_id)
                            ->get();
                }

              }


             foreach ($data1 as $value) {
                    $email_send = (String)$value->email;

                    $message = "Pending approval on Risk Assessment points.";

                    $url = 'changes/approve-all-risk-assesment/';
                    // $url = 'changes/approve-allrisk-assesment/';

                    $this->save_noticication_status_temp((String)$value->id, $input->request_id, $message, $url, 8);
                    $this->change_request_status_close($id, $id1);

                    $id_user = DB::table('request_progress_status')
                        ->select('request_progress_status.assigned_by')
                        ->where('request_progress_status.id', $id1)
                        ->first();


                    DB::table('approval_risk_assessment')->insert(
                        array('request_id' => $input->request_id,
                            'status' => $input->radioStatus,
                            'user_id' => $id_user->assigned_by,
                            'comment' => '',


                        )
                    );

                }


                $data = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 6)
                    ->get();

                $data_1 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 7)
                    ->get();


                $data_2 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 9)
                    ->get();


                $data_3 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 11)
                    ->get();

                $data_4 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 99)
                    ->get();

                //  print_r($data[0]->total);exit;

                if ($data[0]->total == 0 && $data_1[0]->total == 0 && $data_2[0]->total == 0 && $data_3[0]->total == 0 && $data_4[0]->total == 0) {
                    $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        //  ->distinct('request_progress_status_temp.assigned_to')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status', 8)
                        ->where('request_progress_status_temp.request_id', $input->request_id)
                        ->get();
                    //  print_r($data1);exit;
                    foreach ($data1 as $risk) {

                        $last_id_req = $this->save_noticication_status($risk->assigned_to, $input->request_id, $message, $url, 8);

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task


                        $request_id = $id;
                        $close_status = $last_id_req;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby = Session::get('fid');
                    $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status);


                        if ($this->check_netconnection()) {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        } else {


                        }

                    }

                }

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

            }
          
        }else{
          // ------ code for hold --------
           $input = (object)Input::all();
           $change_stage = DB::table('changerequests')
            ->select('changerequests.change_stage','plant_code','stakeholder','proj_code')
            ->where('changerequests.request_id', $input->request_id)
            ->get();
            $holdId=DB::table('tb_holdchangerequests')
                   ->select('r_id')
                   ->where('r_id',$input->request_id)
                   ->where('userId',Session::get('uid')) 
                   ->get();
           // print_r($holdId);exit();
           if(empty($holdId)){
               DB::table('tb_holdchangerequests')->insert(
                  array('r_id' => $input->request_id,
                  'userId' => Session::get('uid'),
                  'change_stage' =>$change_stage[0]->change_stage,
                  'flag'=>1,
                )
              );
         }else{
              DB::table('tb_holdchangerequests')
                ->where('r_id', $input->request_id)
                ->where('userId',Session::get('uid'))
                ->update(
                  array('change_stage' => $change_stage[0]->change_stage,
                        'flag' => 1,
                  )
              );

         }

         if($change_stage[0]->change_stage == 1){
               $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$change_stage[0]->change_stage)
                ->where('stakeholder',$change_stage[0]->stakeholder)
                ->where('plant_code',$change_stage[0]->plant_code)
                 ->get();
               }

          // print_r($representative_id);exit();
           if(!empty($input->dept)){
              foreach ($input->dept as $row) {
               $allUser[] = DB::table('add_updated_risk_assessment_sheet')
                ->select('user_id')
                ->where('user_department',$row)
                ->where('r_id',$input->request_id)
                ->get();

              }



              $initiator = DB::table('changerequests')
            ->select('changerequests.initiator_id')
            ->where('changerequests.request_id', $input->request_id)
            ->get();

           if(isset($representative_id) && !empty($representative_id)){ 
              $sendrepresentative='send';
              if($representative_id[0]->representative_id == $initiator[0]->initiator_id){
                      $sendrepresentative='nosend';
                    }
            }

          $sendIni = 'send';
          foreach ($allUser as $row){

            $hoddept[] = DB::table('tb_users')
                  ->select('department','sub_department')
                  ->where('id',$row[0]->user_id)
                  ->get();

                  if($initiator[0]->initiator_id == $row[0]->user_id){
                      $sendIni = 'nosend';
                  }

                  if(isset($representative_id) && !empty($representative_id)){
                    if($representative_id[0]->representative_id == $row[0]->user_id){
                      $sendrepresentative='nosend';
                    }
                  }
         
          }

            $cnt = 0;
           foreach ($hoddept as $row){
            
            $allhod[$cnt] = DB::table('tb_users')
                  ->select('id','department')
                  ->whereRaw("find_in_set(4,tb_users.group_id)")
                  ->where('department',$row[0]->department)
                  ->where('sub_department',$row[0]->sub_department)
                  ->get();


                  if($allhod[$cnt] == []){
                      $allhod[$cnt]= DB::table('tb_users')
                  ->select('id','department')
                  ->whereRaw("find_in_set(4,tb_users.group_id)")
                  ->where('department',$row[0]->department)
                  ->take(1)
                  ->get();
                  }
                  $cnt = $cnt+1;


          }
            $hod = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id',$input->request_id)
            ->get();
           
           $sendHOD = 'send';
           foreach ($allhod as $row){

                 $cftHodTeam[] = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$row[0]->id)
                  ->get();
                
                  if($hod[0]->Approval_Authority == $row[0]->id){
                      $sendHOD = 'nosend';
                  }

                  if(isset($representative_id) && !empty($representative_id)){
                    if($representative_id[0]->representative_id == $row[0]->id){
                      $sendrepresentative='nosend';
                    }
                  }
         
                }
              // print_r($sendrepresentative);exit();
         
                foreach ($allUser as $row) {
                 
                  $cftTeam[] = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$row[0]->user_id)
                  ->get();
                }


              $all =  array_unique(array_merge($cftTeam,$cftHodTeam), SORT_REGULAR);

             
   
              $holdBy = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',Session::get('uid'))
                  ->get();
              
                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$input->request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();


                 $admin = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('group_id',1)
                  ->get();
                  
                  $toname=$admin[0]->first_name.' '.$admin[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Hold By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name;
                $comment = $input->hold_comment;
               
            $email_id = $admin[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'comment'=>$comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-hold', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Hold Task');

                });
            } else {

            }
   

               if($sendIni == 'send' ){
                 $initiat = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$initiator[0]->initiator_id)
                  ->get(); 

                  $toname=$initiat[0]->first_name.' '.$initiat[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Hold By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name;
                $comment = $input->hold_comment;
               
            $email_id = $initiat[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'comment'=>$comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-hold', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Hold Task');

                });
            } else {

            }
          }

  //  Mail to CFT team Representative User
          if(isset($sendrepresentative)){
           if($sendrepresentative == 'send' ){
                 $initiat = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$representative_id[0]->representative_id)
                  ->get(); 

                  $toname=$initiat[0]->first_name.' '.$initiat[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Hold By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name;
                $comment = $input->hold_comment;
               
            $email_id = $initiat[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'comment'=>$comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-hold', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Hold Task');

                });
            } else {

            }
          }
        }
  // End of CFT team Representative User

            if($initiator[0]->initiator_id != $hod[0]->Approval_Authority){
             if($sendHOD == 'send'){
                 $HOD = DB::table('tb_users')
                  ->select('first_name','last_name','email')
                  ->where('id',$hod[0]->Approval_Authority)
                  ->get(); 

                  $toname=$HOD[0]->first_name.' '.$HOD[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Hold By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name ;
                
               
            $email_id = $HOD[0]->email;
             $comment = $input->hold_comment;
            $data_1 = array('user' => $demo,'to'=>$toname,'comment'=>$comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-hold', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have CM Pending Task');

                });
            } else {

            }
          } 
        }


                  foreach ($all as $row) {
              
                
                    $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$input->request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();

                  
               $toname=$row[0]->first_name.' '.$row[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo =  $cmNo . ' --> '  .'     Hold By --> '.$holdBy[0]->first_name.' '.$holdBy[0]->last_name;

               
            $email_id = $row[0]->email;

            $data_1 = array('user' => $demo,'to'=>$toname,'comment'=>$comment);

            if ($this->check_netconnection()) {

                Mail::send('emails/email-hold', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Hold Task');

                });
            } else {


            }
          }

          
        }
          return Redirect::to('dashboard');
         }
    }

    public function getChangeReqDept($id){
      

            $dept = DB::table('tb_updatesheet_dep_team')
            ->select('department')
            ->where('request_id',$id)
            ->get();
                

               
                  $data =[];
                foreach ($dept as $row) {
                  $data[]  = DB::table('tb_departments')
                 ->select('tb_departments.*')
                 ->where('tb_departments.d_id',$row->department)
                 ->orderBy('tb_departments.d_id', 'ASC')
                 ->get();
                }

                return $data;
    }

    public function get_all_data_as_ds($id)
    {
        $data = array();

        $users = DB::table('approve_for_risk_assessment')
            ->select('approve_for_risk_assessment.*')
            ->where('approve_for_risk_assessment.request_id', $id)
            ->get();

        foreach ($users as $value) {

            $dep_name = $this->get_sub_dep($value->sub_dep_id);
            $user_name = $this->get_user_name_by_id($value->user_id, $value->sub_dep_id);
            $data[] = array('dep_name' => $dep_name[0]->sub_dep_name,
                'dep_id' => $dep_name[0]->sub_dep_id,
                'user_name' => $user_name->first_name . ' ' . $user_name->last_name,
            );

        }
        return $data;
    }

    public function delete_pending_data_from_table($id)
    {

        return DB::table('approve_for_risk_assessment')->where('sub_dep_id', $id)->delete();

    }

    public function data_as_ds()
    {

        $input = (object)Input::all();

        $count = $this->check_data_as_ds($input->sub_dep_id, $input->id, $input->request_id);

        if ($count < 1) {
            DB::table('approve_for_risk_assessment')->insert(
                array('sub_dep_id' => $input->sub_dep_id,
                    'user_id' => $input->id,
                    'request_id' => $input->request_id,
                    'status' => 2
                )
            );
            /* $dep_name=$this->get_sub_dep($input->sub_dep_id);
             $user_name=$this->get_user_name_by_id($input->id,$input->sub_dep_id);

             $data = array('dep_name' => $dep_name[0]->sub_dep_name,
                 'dep_id' => $dep_name[0]->sub_dep_id,
                 'user_name'=>$user_name->first_name,

             );
             */

            return '1';
        } else {
            return '0';

        }


    }

    public function approve_allrisk_assesment($id, $id1)
    {

        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
              return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }else{ 
          if ($this->check_request_permission($id)) {

              return View::make('changes/approve-allrisk-assesment');
          } else {

              return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
          }
        }

    }

    public function approve_all_risk_assesment($id, $id1)
    {
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
              return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }else{   
        if(Auth::check()):
            return View::make('changes/approve-all-risk-assesment');

        else:
            return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
        endif;
      }


    }

    public function get_horizontal($id){

        $data = DB::table('horizontal_deployment')

            ->select('horizontal_deployment.status','horizontal_deployment.comment')
            ->orderBy('horizontal_deployment.created', 'DECS')
            ->where('request_id', $id)

            ->first();

        return $data;


    }

    public function get_risk_by_id($id, $dep_id)
    {
        $res = array();
        $points = DB::table('tb_risk_assessment_points')
            ->leftJoin('tb_departments', 'tb_risk_assessment_points.risk_dep', '=', 'tb_departments.d_id')
            ->leftJoin('tb_risk_assessment_points_admin', 'tb_risk_assessment_points.risk_assessment_id_admin', '=', 'tb_risk_assessment_points_admin.risk_assessment_id_admin')
            ->select('tb_risk_assessment_points.*', 'tb_risk_assessment_points_admin.assessment_point_department')
            ->orderBy('tb_risk_assessment_points_admin.created', 'ASC')
            ->where('request_id', $id)
            ->where('risk_dep', $dep_id)
            ->get();

        foreach ($points as $point) {

            if($point->target_date=='0000-00-00'){

                $target_date='';// Carbon::createFromFormat('Y.m.d', $point->target_date)->format('d.m.Y');


            }else{

                $target_date=$point->target_date;
            }

            if($point->cost=='0'){

                $cost='';// Carbon::createFromFormat('Y.m.d', $point->target_date)->format('d.m.Y');


            }else{

                $cost=$point->cost;
            }
             if($point->piececost=='0'){
                $piececost='';
            }else{
                $piececost=$point->piececost;
            }


            $res[] = array(
                'assessment_point' => $point->assessment_point_department,
                'applicability' => $point->applicability,
                'reason' => $point->reason,
                'de_risking' => $point->de_risking,
                'responsibility' => $this->get_user_info_by_id_for_report($point->responsibility),
                'target_date' => $target_date,
                'cost' => $cost,
                'piececost'=>$piececost,
                'horizontal_deployment'=>$this->get_horizontal($id),
                'attachments'=>$this->get_all_atachments_activity_monitoring_changes($point->risk_assessment_id,$id,$id),
                'verification_status'=>$this->get_verification_status($id),
                'hod_approval'=>$this->get_hod_approval($id,$point->responsibility),

            );
        }

        return $res;
    }

    public function get_hod_approval($request_id,$user_id){
          return $users = DB::table('approval_risk_assessment')
              ->select('approval_risk_assessment.status')
              ->where('approval_risk_assessment.request_id', '=', $request_id)
              ->where('approval_risk_assessment.user_id', '=', $user_id)
              ->orderBy('approval_risk_assessment.created','desc')
              ->first();
    }

    public function get_verification_status($id){


         return $users = DB::table('activity_completion_sheet_verify')
             ->select('activity_completion_sheet_verify.status')
             ->where('request_id', '=', $id)
             ->first();



    }

    public function get_allRisk_assessment_approval($id)
    {

        // $users = DB::table('tb_departments')->select('d_id','d_name')->get();
        $data=array();
        $users = DB::table('tb_departments')
            ->leftJoin('tb_risk_assessment_points', 'tb_departments.d_id', '=', 'tb_risk_assessment_points.risk_dep')
            ->select('tb_departments.d_id', 'tb_departments.d_name')
            ->where('tb_risk_assessment_points.request_id', $id)
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->get();


      //  print_r($users);exit;
        $count=1;
        foreach ($users as $value) {

            $data[] = array('sub_dep_id' => $value->d_id,
                'sub_dep_name' => $value->d_name,
                'count'=>$count,
                'riskdata' => $this->get_risk_by_id($id, $value->d_id),
                'riskdataformail' => $this->get_risk_by_id_formail($id, $value->d_id),

               // 'attachments'=>$this->get_all_atachments_activity_monitoring_changes($value->risk_assessment_id,$id),

            );

            $count++;
        }

                return $data;


    }

    public function get_risk_by_id_formail($id, $dep_id)
    {
        $res = array();
        $points = DB::table('tb_risk_assessment_points')
            ->leftJoin('tb_departments', 'tb_risk_assessment_points.risk_dep', '=', 'tb_departments.d_id')
            ->leftJoin('tb_risk_assessment_points_admin', 'tb_risk_assessment_points.risk_assessment_id_admin', '=', 'tb_risk_assessment_points_admin.risk_assessment_id_admin')
            ->select('tb_risk_assessment_points.*', 'tb_risk_assessment_points_admin.assessment_point_department')
            ->orderBy('tb_risk_assessment_points_admin.created', 'ASC')
            ->where('request_id', $id)
            ->where('risk_dep', $dep_id)
            ->where('tb_risk_assessment_points.applicability',1)
            ->get();

        foreach ($points as $point) {

            if($point->target_date=='0000-00-00'){

                $target_date='';// Carbon::createFromFormat('Y.m.d', $point->target_date)->format('d.m.Y');


            }else{

                $target_date=$point->target_date;
            }

            if($point->cost=='0'){
                $cost='';
            }else{
                $cost=$point->cost;
            }
            if($point->piececost=='0'){
                $piececost='';
            }else{
                $piececost=$point->piececost;
            }




            $res[] = array(
                'assessment_point' => $point->assessment_point_department,
                'applicability' => $point->applicability,
                'reason' => $point->reason,
                'de_risking' => $point->de_risking,
                'responsibility' => $this->get_user_info_by_id_for_report($point->responsibility),
                'target_date' => $target_date,
                'cost' => $cost,
                'piececost'=>$piececost,
                'horizontal_deployment'=>$this->get_horizontal($id),
                'attachments'=>$this->get_all_atachments_activity_monitoring_changes($point->risk_assessment_id,$id,$id),
                'verification_status'=>$this->get_verification_status($id),
                'hod_approval'=>$this->get_hod_approval($id,$point->responsibility),

            );
        }

        return $res;
    }


    public function get_risk_subdepartment()
    {

        return $users = DB::table('subdepartments')
            ->select('sub_dep_id', 'department_id', 'sub_dep_name')
            ->where('department_id', '=', 2)
            ->where('subdepartments.sub_dep_id', '=', Session::get('sub_dep_id'))
            ->get();

    }

    public function approval_risk_assesment_based_on_cost()
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
            ->get();
       if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
       }else{   
        if(Auth::check()):
            return View::make('changes/approval-risk-assesment-based-on-cost');

        else:
            return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
        endif;
      }



    }

    public function approval_risk_assesment_admin()
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
       if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
       }else{   
        if(Auth::check()):
            return View::make('changes/approval-risk-assessment-admin');

        else:
            return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
        endif;
      }



    }


    public function get_QA_HOD()
    {

        return $data = DB::table('tb_users')->select('first_name', 'last_name', 'id')->where('group_id', '=', 7)->get();


    }

    public function checkPrvOfCustComDecision($id){
      $data = DB::table('changerequests')
              ->select('change_stage','plant_code','stakeholder')
              ->where('request_id',$id)
              ->get();
      $steerComm = DB::table('tb_dynamicSteeringCommitee')
                    ->select('cust_comm_decision')
                    ->where('plant_id',$data[0]->plant_code)
                    ->where('change_stage',$data[0]->change_stage)
                    ->where('stakeholder',$data[0]->stakeholder)
                    ->get();
              $userId = Session::get('uid');
             if($userId === $steerComm[0]->cust_comm_decision){
                return 1;
             }else{
                return 0;
             }

    }

    public function addapproval_assessment_based_oncost($r_id,$cuComm,$perOfCustCom,$id,$idCCMem)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$r_id)
              ->where('id',$id)
              ->get();
         if($checkClose[0]->close ==1){
          $c='c';
            return $c ;exit();
         }
        $input = (object)Input::all();
       
        
                if($perOfCustCom == 1){
                  
                 if($cuComm == 1){
                  if($idCCMem == 'undefined'){
                     $s='1';
                    return $s;exit;
                  }else{
                    $data = DB::table('tb_users')
                                ->select('id')
                                ->where('active',1)
                                ->where('id',$input->custComm)
                                ->get();
                    }
                  
                    if((empty($data))){
                       $s='1';
                    return $s;exit;
                  }
                }
                  }
                

              if($input->comment != ""){
                  $comment = $input->comment;
              }else{
                  $comment="";
              }

        $data = DB::table('approval_for_risk_assessment_for_cost_involved')->insert(
            array('approval_status' => $input->radioStatus,
                'QA_HOD_id' => $input->id,
                'request_id' => $input->request_id,
                'user_id' => Session::get('uid'),
                'department_id' => Session::get('dep_id'),
                'sub_department_id' => Session::get('sub_dep_id'),
                'comment'           => $comment

            )
        );

       
          $changeReqData = DB::table('changerequests')
         ->select('changeType','plant_code','stakeholder','change_stage')
         ->where('request_id',$input->request_id)
         ->get();


         //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',7)->get();
                $Date=date('Y-m-d');

                
                $process='steering commitee approval by '.Session::get('uid');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 6)
                  ->where('process',$process)
                  ->update(['actual_date' => $Date]);
                   
                 
                 //----end code for tracking Sheet----
        
            if($perOfCustCom == 1){
               
               $changeReqData = DB::table('changerequests')
           ->select('plant_code','stakeholder','change_stage','proj_code','changeType','created_date')
           ->where('request_id',$r_id)
           ->get();

              if($cuComm == 1){
              
                  $custComm = DB::table('tb_dynamicCustComm')
                                ->select('CC_member')
                                ->where('CC_changeStage',$changeReqData[0]->change_stage)
                                ->where('CC_plantCode',$changeReqData[0]->plant_code)
                                ->where('CC_stakeholder',$changeReqData[0]->stakeholder)
                                ->get();

                  if(empty($custComm)){
                     return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','select customer communication member'))
                      ->withInput();
                  }      

                   $cComUsr = DB::table('tb_users')
                                      ->select('id','department','sub_department')
                                      ->where('id',$custComm[0]->CC_member)
                                      ->get();    

                   $cust = DB::table('changerequests_customer')
                          ->select('customer_id')
                          ->where('request_id',$input->request_id)
                          ->get();
                       foreach ($cust as $row) {
                                                 
                          DB::table('Customer_Communication_list')->insert(
                              array('request_id' => $input->request_id,
                                  'decision' => 1,
                                  'description' => $row->customer_id,
                                  // 'user_id' => $input->user_id,
                                  // 'created_date' => date('Y-m-d H:i:s'),
                              )
                          );
                        }
              


                    DB::table('Customer_Communication_Decision')->insert(
                        array('request_id' => $input->request_id,
                            'dep_id' => $cComUsr[0]->department,
                            'sub_dep_id' => $cComUsr[0]->sub_department,
                            'user_id' => $cComUsr[0]->id,
                            'created_date' => date('Y-m-d H:i:s'),
                            )
                        );




                      $message="Pending Customer Approval from responsible person.";

                    $url = 'changes/customer-communication-decision-attachments/';
                      $this->save_noticication_status_temp($custComm[0]->CC_member, $input->request_id, $message, $url, 12);
                      
                       $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status',12)
                        ->where('request_progress_status_temp.request_id',$input->request_id)
                        ->get();

                    foreach($data1 as $risk) {

                       
                        DB::table('request_progress_status')->insert(
                        array('assigned_by' => Session::get('uid'),
                            'assigned_to' => $risk->assigned_to,
                            'request_id' => $risk->request_id,
                            'created_date' => date('Y-m-d H:i:s'),
                            'message' => $message,
                            'next_url'=>$url,
                            'status'=>12,
                            'close'=>1
                       
                        )
                    );
     
                    }
              
                }else{


                $checkuser=DB::table('tb_updatesheet_dep_team')
            ->select('team_member')
            ->where('request_id',$input->request_id)
            ->get();

           foreach ($checkuser as $key) {
            $inactiveuser=DB::table('tb_users')
            ->select('first_name','last_name')
            ->where('active',0)
            ->where('id',$key->team_member)
            ->get();
            if(!empty($inactiveuser)){
              $data1[]=array(
                  'user'=>$inactiveuser[0]->first_name.' '.$inactiveuser[0]->last_name,
                  'inactive'=>'0',

                );
              return $data1;exit();
            }
           }

                
                  $cust = DB::table('changerequests_customer')
                          ->select('customer_id')
                          ->where('request_id',$input->request_id)
                          ->get();
                   foreach ($cust as $row) {
                                             
                      DB::table('Customer_Communication_list')->insert(
                          array('request_id' => $input->request_id,
                              'decision' => 0,
                              'description' => $row->customer_id,
                              // 'user_id' => $input->user_id,
                              // 'created_date' => date('Y-m-d H:i:s'),
                          )
                      );
                    }
                  DB::table('customer_Communication_Decision_wno')->insert(
                    array('request_id' => $input->request_id,
                        'assign_by_id' => Session::get('uid'),
                        'decision' => 0,

                    )
                );

                  DB::table('tb_updatesheet_dep_team')
                      ->where('request_id', $id)
                      ->update(['resp_emp_status' => 3]);//3 for task assign to responsibles employees

                  $data  = DB::table('tb_updatesheet_dep_team')
                      ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
                      ->select('tb_users.email','tb_users.id','tb_users.department')
                      ->where('tb_updatesheet_dep_team.request_id','=',$r_id)
                      ->get();

                  $message = "Pending from Responsible person to monitor activity completion status.";

                  $url = 'changes/activity-monitoring/';

                  foreach ($data as $value) {

                      $email_id = (String)$value->email;
                      $user_id = (String)$value->id;
                      $department = (String)$value->department;


                       $target_date1 = DB::table('tb_risk_assessment_points')
                  ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
                  ->groupBy('tb_risk_assessment_points.risk_dep')
                  ->where('tb_risk_assessment_points.request_id', $id)
                  ->where('tb_risk_assessment_points.responsibility', $user_id)
                  ->first();

                    DB::table('request_progress_status')->insert(
                    array('assigned_by' => Session::get('uid'),
                        'assigned_to' => $user_id,
                        'request_id' => $r_id,
                        'created_date' => date('Y-m-d H:i:s'),
                        'message' => $message,
                        'next_url'=>$url,
                        'status'=>14,
                        'close' =>1
                        //'progress'=>$progress

                    )
                );

                $this->save_task_status($user_id,$department,$r_id);
            }  
      
           }
        }
        $this->change_request_status_close($input->request_id, $id);
             $data = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 8)
                    ->get();

                $data_2 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 88)
                    ->get();

                $data_1 = DB::table('request_progress_status')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('request_progress_status.request_id', $input->request_id)
                    ->where('request_progress_status.close', 0)
                    ->where('request_progress_status.status', 11)
                    ->get();
        
                if($data[0]->total==0 && $data_1[0]->total==0 && $data_2[0]->total==0) {
                  
                    $checkWhomSend1 = DB::table('request_progress_status')
                                    ->select('request_progress_status.*')
                                     ->where('request_id',$input->request_id)
                                    ->where('close',1)
                                    ->where('status',12)
                                    ->get();
                                   
                     if(!empty($checkWhomSend1)){              
                              
                      if($checkWhomSend1[0]->status == 12){
                          
                             
                    $data1 = DB::table('request_progress_status_temp')
                          ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                          ->groupBy('request_progress_status_temp.assigned_to')
                          ->where('request_progress_status_temp.status',12)
                          ->where('request_progress_status_temp.request_id',$r_id)
                          ->get();

                        //----start code for tracking Sheet----

                
                  $data=DB::table('tracking_sheet_date_param')->where('id',8)->get();
                    $Date=date('Y-m-d');

                    $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));

                   
                      DB::table('tracking_sheet_info')->insert(
                          array(
                              'request_id' => $r_id,
                              'process'     =>'Customer Evidance Upload',
                              'target_date' =>$targetDate,
                              'actual_date'  =>0,
                              'status'      =>8
                            )
                        );


                 //----end code for tracking Sheet----


                    foreach($data1 as $risk) {

                       DB::table('request_progress_status')
                            ->where('status',12)
                            ->where('request_id',$risk->request_id)
                            ->update(array(
                               'created_date' => date('Y-m-d H:i:s'),
                                'close'=>0
                              )
                            );

                            $last_id_req = DB::table('request_progress_status')
                            ->select('id','assigned_by')
                            ->where('request_id',$risk->request_id)
                            ->where('status',12)
                            ->get();

                             

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task
                        $assignedbyuser = $this->get_user_info_by_id($last_id_req[0]->assigned_by);//Assigned by task


                        $request_id=$risk->request_id;
                        $close_status=$last_id_req[0]->id;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby=$assignedbyuser['name'];

                        $message="Pending Customer Approval from responsible person.";
                          $url = 'changes/customer-communication-decision-attachments/';
                  $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


                        if($this->check_netconnection())
                        {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        }else{

                        }

                     }
                  }
                }else{
                     
                     
                      $data  = DB::table('tb_updatesheet_dep_team')
                  ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
                  ->select('tb_users.email','tb_users.id','tb_users.department')
                  ->where('tb_updatesheet_dep_team.request_id','=',$input->request_id)
                  ->get();

                $message = "Pending from Responsible person to monitor activity completion status.";

                $url = 'changes/activity-monitoring/';
                
                foreach ($data as $value) {
                   
                    $email_id = (String)$value->email;
                    $user_id = (String)$value->id;
                    $department = (String)$value->department;


                     $target_date1 = DB::table('tb_risk_assessment_points')
                      ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
                      ->groupBy('tb_risk_assessment_points.risk_dep')
                      ->where('tb_risk_assessment_points.request_id', $input->request_id)
                      ->where('tb_risk_assessment_points.responsibility', $user_id)
                      ->first();
                    
                      if($target_date1->t_date=="0000-00-00"){

                       $target_date='';


                      }else{

                        $target_date=$target_date1->t_date;
                      }

                
                   //----start code for tracking Sheet----

                
                    $Date=date('Y-m-d');

                 
                    
                      DB::table('tracking_sheet_info')->insert(
                          array(
                              'request_id' => $r_id,
                              'process'     =>'Risk Activity Status Document Upload by '.$department,
                              'target_date' =>$target_date,
                              'actual_date'  =>0,
                              'status'      =>10
                            )
                        );
                
                 //----end code for tracking Sheet----
                    $data1 = $this->get_user_info_by_id($user_id);//Assigned to task


                    DB::table('request_progress_status')
                                ->where('status',14)
                                ->where('request_id',$r_id)
                                ->update(array(
                                   'created_date' => date('Y-m-d H:i:s'),
                                    'close'=>0
                                  )
                                );

                            $last_id_req = DB::table('request_progress_status')
                            ->select('id','assigned_by')
                            ->where('request_id',$input->request_id)
                            ->where('status',14)
                            ->get();
                           $assignedbyuser = $this->get_user_info_by_id($last_id_req[0]->assigned_by);

                        $request_id=$r_id;
                        $close_status=$last_id_req[0]->id;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby=$assignedbyuser['name'];
                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



                        if($this->check_netconnection())
                        {

                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        }else{

                        }
                    }
               }
              }
            return Redirect::to('dashboard');  

            
    }

    public function customer_communication_decision($id)
    {

        if ($this->check_request_permission($id)) {

            return View::make('changes/customer-communication-decision');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }


    }

    public function save_customer_communication_decision($id, $id1)
    {



        /*
         *
         * Below code is old working without new changes from client
         *
         */

        $user_type = Session::get('gid');


        if ($user_type != "") {
            $input = (object)Input::all();

            if (isset($input->sub_dep_id) && !empty($input->sub_dep_id)) {
                $sub_dep_id = $input->sub_dep_id;
            } else {
                $sub_dep_id = '';
            }



              //----start code for tracking Sheet----

                
                  $data=DB::table('tracking_sheet_date_param')->where('id',8)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));

               
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Customer Evidance Upload',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>8
                        )
                    );


                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 7)

                  ->update(['actual_date' => $Date]);
 
               
                 //----end code for tracking Sheet----

            DB::table('Customer_Communication_Decision')->insert(
                array('request_id' => $id,
                    'dep_id' => $input->dep_id,
                    'sub_dep_id' => $sub_dep_id,
                    'user_id' => $input->user_ids,
                    'created_date' => date('Y-m-d H:i:s'),
                )
            );

            DB::table('Customer_Communication_list')
                ->where('request_id', $id)

                ->update(['decision' => 1]);


            $message="Pending Customer Approval from responsible person.";

            $url = 'changes/customer-communication-decision-attachments/';
            $last_id_req= $this->save_noticication_status($input->user_ids, $id, $message, $url, 12);
            $this->change_request_status_close($id, $id1);

            $data1 = $this->get_user_info_by_id($input->user_ids);//Assigned to task


            $request_id=$id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }

         

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

        } else {
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

    public function save_customer_communication_decision_wno($id, $id1)
    {


        /*
         *
         * Below code is old working without new changes from client
         *
         */

        $user_type = Session::get('gid');


        if ($user_type != "") {
            $input = (object)Input::all();


             DB::table('customer_Communication_Decision_wno')->insert(
                array('request_id' => $id,
                    'assign_by_id' => Session::get('uid'),
                    'decision' => $input->decision,

                )
            );

            DB::table('Customer_Communication_list')
                ->where('request_id', $id)

                ->update(['decision' => 0]);


            DB::table('tb_updatesheet_dep_team')
                ->where('request_id', $id)
                ->update(['resp_emp_status' => 3]);//3 for task assign to responsibles employees

            $data  = DB::table('tb_updatesheet_dep_team')
                ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
                ->select('tb_users.email','tb_users.id','tb_users.department')
                ->where('tb_updatesheet_dep_team.request_id','=',$id)
                ->get();

            $message = "Pending from Responsible person to monitor activity completion status.";

            $url = 'changes/activity-monitoring/';

            foreach ($data as $value) {

                $email_id = (String)$value->email;
                $user_id = (String)$value->id;
                $department = (String)$value->department;


                 $target_date1 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->where('tb_risk_assessment_points.request_id', $id)
            ->where('tb_risk_assessment_points.responsibility', $user_id)
            ->first();

                  if($target_date1->t_date=="0000-00-00"){

                   $target_date='';


                  }else{

                    $target_date=$target_date1->t_date;
                  }

                
                   //----start code for tracking Sheet----

                
                $Date=date('Y-m-d');

             
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Risk Activity Status Document Upload by '.$department,
                          'target_date' =>$target_date,
                          'actual_date'  =>0,
                          'status'      =>10
                        )
                    );
                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 7)

                  ->update(['actual_date' => $Date]);

               
                 //----end code for tracking Sheet----

                  

                $last_id_req=$this->save_noticication_status($user_id, $id, $message, $url, 14);

                $this->save_task_status($user_id,$department,$id);

                $data1 = $this->get_user_info_by_id($user_id);//Assigned to task


                $request_id=$id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{



                }

                $this->change_request_status_close($id, $id1);
            }             

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

        } else {
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

    public function save_customer_communication_list($id)
    {

        $input = (object)Input::all();



        $count = $this->check_customer_list($input->description, $id);

       // print_r($count);exit;

        if ($count < 1) {

            DB::table('Customer_Communication_list')->insert(
                array('request_id' => $id,
                   // 'decision' => $input->decision,
                    'description' => $input->description,
                    // 'user_id' => $input->user_id,
                    // 'created_date' => date('Y-m-d H:i:s'),
                )
            );
            $last_id = DB::getPdo()->lastInsertId();

            $data = DB::table('Customer_Communication_list')
                ->select('Customer_Communication_list.*')
                ->where('id', $last_id)
                ->get();

            return $data;

        } else {
            return '0';

        }


    }

    function check_customer_list($description, $request_id)
    {

        $users = DB::table('Customer_Communication_list')
            ->select(DB::raw('COUNT(id) as total'))
            // ->where('Customer_Communication_list.decision', $decision)
            ->where('Customer_Communication_list.description', $description)
            ->where('Customer_Communication_list.request_id', $request_id)
            ->get();

        return $users[0]->total;

    }

    public function get_cust_data($id)
    {

        $data['list'] = DB::table('Customer_Communication_list')
            ->leftJoin('customer', 'Customer_Communication_list.description', '=', 'customer.CustomerId')
            ->select('Customer_Communication_list.*', 'customer.FirstName', 'customer.LastName', 'customer.CustomerId')
            ->where('request_id', $id)
            ->get();


        $data['cust'] = DB::table('Customer_Communication_Decision')
            ->select('Customer_Communication_Decision.*')
            ->where('request_id', $id)
            ->get();

        return $data;
    }

    public function delete_cust_list($id)
    {

        DB::table('Customer_Communication_list')->where('id', $id)->delete();

    }

    /*
     *
     * For Reject reject flow
     */

    public function customer_communication_decision_attachment($id){

        if ($this->check_request_permission($id)) {

            return View::make('changes/customer-communication-decision_attachment');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }

    }

    public function customer_communication_decision_attachments($id)
    {
        $data1 = array(
            'request_id'  => "",
            'page'        => 'modifyByRespPerson',
            'custCommPer'   => ""

        );

        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
              return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }else{   

          if ($this->check_request_permission($id)) {

              return View::make('changes/customer-communication-decision_attachments')->with($data1);
          } else {

              return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
          }
        }


    }

    public function uploaddoc($id)
    {


        if (!empty(Input::get('delete_attachment'))) {

            if (!empty(Input::get('attachment_name'))) {

               $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'You can not upload document.Task is already completed.'))
                   ->withInput();
     }

                DB::table('Customer_Communication_list_attachments')->where('id', Input::get('list_id'))->delete();

                $filename =  Config::get('app.site_root'). '/uploads/attachments/' . Input::get('attachment_name');


                if (File::exists($filename)) {
                    File::delete($filename);
                }
                return Redirect::back()->with('success', 'You have posted successfully');
            }

        } else if (!empty(Input::get('Upload'))) {
           $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'You can not upload document.Task is already completed.'))
                   ->withInput();
     }
            $ext1 = DB::table('tb_dept_addRemove')
              ->select('file_upload_type')
              ->get();
            $destinationPath = 'uploads/attachments'; // upload path

            if (Input::hasFile('doc')) {

                $names = Input::file('doc');

                foreach ($names as $name) {

                    $extension = $name->getClientOriginalName();

                    $filename = rand(11111,99999).'-'.$extension; // renameing image
                      $info = pathinfo($filename);

                      $ext = $info['extension'];
                      $a = array('tif','gif','png','jpg','jpeg','pdf');
                      if($ext1[0]->file_upload_type == "Specific"){
                       if (!in_array(strtolower($ext), $a)) {
                            return Redirect::back()->with('message', SiteHelpers::alert('error', 'Only image and file can be attached'));
                        }
                      }
                    $upload_success = $name->move($destinationPath, $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename));
                    $list_id = Input::get('list_id');
                    $comment = Input::get('comment');

                    $this->save_attachment_files($id, $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename), $list_id,$comment);


                    /*    $extension = Input::file('doc');
                        $fileName = rand(11111, 99999) . "-" . $name; // renaming image
                        Input::file('doc')->move($destinationPath, $fileName);
                        // echo $fileName; exit;
                        $imagename = $fileName;*/


                }

                //  $name = Input::file('doc')->getClientOriginalName();


                // return Redirect::to('customer_communication_decision_attachments/$id');

                return Redirect::back()->with('success', 'You have posted successfully');
            }
        } else {

            return Redirect::back()->with('success', 'You have posted successfully');

        }


    }

    public function save_attachment_files($id, $filename, $list_id,$comment)
    {

        DB::table('Customer_Communication_list_attachments')->insert(
            array('request_id' => $id,
                'doc_name' => $filename,
                'list_id' => $list_id,
                'comment'   => $comment
                // 'user_id' => $input->user_id,
                // 'created_date' => date('Y-m-d H:i:s'),
            )
        );
    }

    public function update_customer_list_status($selected_id, $request_id, $list_id)
    {

        DB::table('Customer_Communication_list')
            ->where('request_id', $request_id)
            ->where('id', $list_id)
            ->update(['status' => $selected_id]);


    }

    public function customer_communication_decision_status($request)
    {//print_r("in ccds");exit;

        $users = DB::table('Customer_Communication_list')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('Customer_Communication_list.request_id', $request)
            ->where('Customer_Communication_list.status', 0)
            ->get();

        return $users[0]->total;
        // exit;

    }

    public function submit_customer_communication_list_for_reject($id,$id1)
    {
       /* $input = (object)Input::all();

        $count = $this->customer_communication_decision_status($input->request_id);

        if ($count < 1) {

            $value = DB::table('tb_users')
                ->select('tb_users.email', 'tb_users.id')->where('id', 1)->get(); // 1 for super admin user id


            $email = (String)$value[0]->email;
            $user_id = (String)$value[0]->id;


            $message = "Pending Administrator verification on Customer approval.";

            $url = 'changes/customer_verification_for_reject/';
            $this->save_noticication_status_temp($user_id, $input->request_id, $message, $url, 13);

            $this->change_request_status_close($input->request_id, $id);

            $data = DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_progress_status.request_id', $input->request_id)
                ->where('request_progress_status.close', 0)
                ->where('request_progress_status.status', 12)
               // ->where('request_progress_status.created_date','DESC')
                ->get();

            if($data[0]->total==0) {
                $data1 = DB::table('request_progress_status_temp')
                    ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                    ->groupBy('request_progress_status_temp.assigned_to')
                    ->where('request_progress_status_temp.status',13)
                    ->where('request_progress_status_temp.next_url','!=', 'changes/customer_verification/')
                    ->orderBy('request_progress_status_temp.id', 'desc')

                    ->get();

                foreach($data1 as $risk) {

                    DB::table('request_progress_status')->insert(
                        array('assigned_by' => Session::get('uid'),
                            'assigned_to' => $risk->assigned_to,
                            'request_id' => $risk->request_id,
                            'created_date' => date('Y-m-d H:i:s'),
                            'message' => $message,
                            'next_url' => $url,
                            'status' => 13,
                            //'progress'=>$progress

                        )
                    );
                }

                Mail::send('emails/email-template', array('data' => (String)$value[0]->email), function ($message) use ($email) {

                    $message->to($email)->subject('Welcome!');
                    //$message->to($value[0]->ApprovalAuthority);
                });

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

            }

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));


        } else {
            return Redirect::Back()->with('message', SiteHelpers::alert('error', 'Please Change All Status'));

        }*/

        /*
         *
         * Old code below as per new client changes new code is above
         *
         */



        $input = (object)Input::all();

        $count = $this->customer_communication_decision_status($input->request_id);

        if ($count >= 1) {

            
          
                 $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$id)
            ->get();

            
            if($checkParam[0]->change_stage == 1){
              $users = DB::table('tb_users')
                ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                ->select('tb_users.id', 'tb_users.email')
                ->where('changerequests.request_id', $id)
                ->first();

                 $this->change_request_status_close($id, $id1);
            $message = "Pending for PTR document upload.";

            $url = 'changes/PTR_document/';

                 $last_id_req=$this->save_noticication_status($users->id, $id, $message, $url, 22);
            $data1 = $this->get_user_info_by_id($users->id);//Assigned to task
            }else if($checkParam[0]->change_stage == 2 && $checkParam[0]->proj_code == ""){

              

                 $users = DB::table('tb_project_manager')
                ->select('proj_mgr_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();

              
                      if(!empty($users)){
                    $meber = DB::table('tb_users')
                       ->select('tb_users.id', 'tb_users.email')
                       ->where('id',$users[0]->proj_mgr_id)
                      ->get();
                    }else{
                        
                         return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for horizontal deployment'));
                    }

                   $this->change_request_status_close($id, $id1);
                  $message = "Pending Decision of Horizontal Deployment applicability from Initiator.";

                  $url = 'changes/horizontal-deployment/';

                  $last_id_req=$this->save_noticication_status($meber[0]->id, $id, $message, $url, 17);
                  $data1 = $this->get_user_info_by_id($meber[0]->id);//Assigned to task
            }else{
                 $users = DB::table('tb_projectMaster')
                ->select('project_manager')
                ->where('id',$checkParam[0]->proj_code)
                 ->get();

              
                      if(!empty($users)){
                    $meber = DB::table('tb_users')
                       ->select('tb_users.id', 'tb_users.email')
                       ->where('id',$users[0]->project_manager)
                      ->get();
                    }else{
                        
                         return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for horizontal deployment'));
                    }

                   $this->change_request_status_close($id, $id1);
                  $message = "Pending Decision of Horizontal Deployment applicability from Initiator.";

                  $url = 'changes/horizontal-deployment/';

                  $last_id_req=$this->save_noticication_status($meber[0]->id, $id, $message, $url, 17);
                  $data1 = $this->get_user_info_by_id($meber[0]->id);//Assigned to task
            }

           $request_id=$id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            
               $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }

           return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

        } else {
            return Redirect::Back()->with('message', SiteHelpers::alert('error', 'Please Change All Status'));

        }


    }

    /**
     * @return mixed
     */
   public function submit_customer_communication_list($id1,$id)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id1)
              ->where('id',$id)
              ->get();
           //   print_r($checkClose);exit();
         if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }
         $input = (object)Input::all();

        $count = $this->customer_communication_decision_status($input->request_id);


        if ($count >= 1) {


    

             $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$input->request_id)
            ->get();
            if($checkParam[0]->change_stage == 2 ){

              $checkuser=DB::table('tb_updatesheet_dep_team')
            ->select('team_member')
            ->where('request_id',$input->request_id)
            ->get();

           foreach ($checkuser as $key) {
            $inactiveuser=DB::table('tb_users')
            ->select('first_name','last_name')
            ->where('active',0)
            ->where('id',$key->team_member)
            ->get();
            if(!empty($inactiveuser)){
              return Redirect::back()->with('message', SiteHelpers::alert('error','CFT member'. $inactiveuser[0]->first_name.' '.$inactiveuser[0]->last_name. '  inactive.Please contact administrator'));
            }
           }
              
                 DB::table('Customer_Communication_list')
                ->where('request_id', $input->request_id)

                ->update(['decision' => 1]);


                 DB::table('tb_updatesheet_dep_team')
                ->where('request_id', $input->request_id)
                ->update(['resp_emp_status' => 3]);





                  DB::table('tb_updatesheet_dep_team')
                      ->where('request_id', $input->request_id)
                      ->update(['resp_emp_status' => 3]);//3 for task assign to responsibles employees

                  $data  = DB::table('tb_updatesheet_dep_team')
                      ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
                      ->select('tb_users.email','tb_users.id','tb_users.department')
                      ->where('tb_updatesheet_dep_team.request_id','=',$input->request_id)
                      ->get();
                     

                  $message = "Pending from Responsible person to monitor activity completion status.";

                  $url = 'changes/activity-monitoring/';

                  foreach ($data as $value) {

                      $email_id = (String)$value->email;
                      $user_id = (String)$value->id;
                      $department = (String)$value->department;


                       $target_date1 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->where('tb_risk_assessment_points.request_id', $input->request_id)
            ->where('tb_risk_assessment_points.responsibility', $user_id)
            ->first();

                  if($target_date1->t_date=="0000-00-00"){

                   $target_date='';


                  }else{

                    $target_date=$target_date1->t_date;
                  }

                
                   //----start code for tracking Sheet----

                
                $Date=date('Y-m-d');

             
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'Risk Activity Status Document Upload by '.$department,
                          'target_date' =>$target_date,
                          'actual_date'  =>0,
                          'status'      =>10
                        )
                    );
                
                 DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 8)
                  ->update(['actual_date' => $Date]);

               
                 //----end code for tracking Sheet----

                    $last_id_req=$this->save_noticication_status($user_id, $input->request_id, $message, $url, 14);
                   
                    $this->save_task_status($user_id,$department,$input->request_id);
                     $data1 = $this->get_user_info_by_id($user_id);//Assigned to task


                $request_id=$input->request_id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                   $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{

                }
             
                $this->change_request_status_close($input->request_id, $id);

            }  

            }else{
               $users = DB::table('tb_dynamiccustcomm')
                ->select('CC_ApprovalMember')
                ->where('CC_changeStage',$checkParam[0]->change_stage)
                ->where('CC_stakeholder',$checkParam[0]->stakeholder)
                ->where('CC_plantCode',$checkParam[0]->plant_code)
                 ->get();

               
                 if(!empty($users) && $users[0]->CC_ApprovalMember != 0){
                    $value = DB::table('tb_users')
                       ->select('tb_users.id', 'tb_users.email')
                       ->where('id',$users[0]->CC_ApprovalMember)
                       ->where('active',1)
                      ->get();
                    }else{
                         return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for customer communication approval or inactive'));
                    }

                     $data=DB::table('tracking_sheet_date_param')->where('id',9)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
              
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'Customer evidance upload approve by superadmin',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>9
                        )
                    );
                
                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 8)
                  ->update(['actual_date' => $Date]);

                 
                 //----end code for tracking Sheet----

         


            $email = (String)$value[0]->email;
            $user_id = (String)$value[0]->id;


            $message = "Pending Administrator verification on Customer approval.";

            $url = 'changes/customer_verification/';
            $last_id_req=$this->save_noticication_status($user_id, $input->request_id, $message, $url, 13);

            $this->change_request_status_close($input->request_id, $id);


            $data1 = $this->get_user_info_by_id($user_id);//Assigned to task

            $request_id=$input->request_id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
               $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }
            }
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

        } else {
            return Redirect::Back()->with('message', SiteHelpers::alert('error', 'Please Change All Status'));

        }


    }
    function check_status_customer($request)
    {

        $users = DB::table('Customer_Communication_list')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('Customer_Communication_list.request_id', $request)
            ->where('Customer_Communication_list.status', 0)
            ->get();

        return $users[0]->total;

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
                'attachment_id' => $attachment->id,
                'doc_name' => $attachment->doc_name,
                'comment' => $attachment->comment,
            );

        }


        return $purpose;


    }

    public function get_cust_data_attachments($id)
    {

        $lists = DB::table('Customer_Communication_list')
            ->leftJoin('customer', 'Customer_Communication_list.description', '=', 'customer.CustomerId')
            ->select('Customer_Communication_list.*', 'customer.FirstName', 'customer.LastName', 'customer.CustomerId')
            ->where('request_id', $id)
            ->where('decision', 1)
            ->get();


        foreach ($lists as $list) {

            $data[] = array(
                'request_id' => $id,
                'list_id' => $list->id,
                'description' => $list->description,
                'decision' => $list->decision,
                'Responsibility' => $list->Responsibility,
                'attachments' => $this->get_all_atachments($list->id,$id),
                'FirstName' => $list->FirstName,
                'LastName' => $list->LastName,
                'CustomerId' => $list->CustomerId,
                'status' => $list->status,
                  'total'=>$this->calTotAtta($id)

            );
        }
        return $data;
    }

public function calTotAtta($id){
  $total=DB::table('Customer_Communication_list_attachments')
  ->select(DB::raw('count(id) as total'))
  ->where('Customer_Communication_list_attachments.request_id', '=',$id)
  ->get();

  return $total[0]->total;
} 
    public function delete_attachment_list($id)
    {
        if (!empty(Input::get('name'))) {


            DB::table('Customer_Communication_list_attachments')->where('id', $id)->delete();

            $filename = public_path() . '/uploads/attachments/' . Input::get('name');

            if (File::exists($filename)) {
                File::delete($filename);
            }

        }

    }






    public function get_sub_department_and_user($id)
    {

        $subdep = DB::table('subdepartments')
            ->select('subdepartments.sub_dep_id', 'subdepartments.sub_dep_name')
            ->where('department_id', $id)
            ->get();
        $data['subdep'] = $subdep;
        $users = DB::table('tb_users')
            ->select('tb_users.id', 'tb_users.first_name', 'tb_users.last_name')
            ->where('department', $id)
			->where('group_id','LIKE','%11%')
            ->get();
        $data['users'] = $users;

        return $data;
    }

    /**
     * @param $id
     * @return mixed
     */

    public function get_users_by_subdep($id)
    {

        $users = DB::table('tb_users')
            ->select('tb_users.id', 'tb_users.first_name', 'tb_users.last_name')
            ->where('sub_department', $id)
			->where('group_id','LIKE','%11%')
            ->get();
        $data['users'] = $users;

        return $data;


    }

    public function reject_risk_assessment_based_oncost($id, $id1)
    {

        $input = (object)Input::all();
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('');
         }
        DB::table('request_progress_status')
        ->where('request_id',$id)
        ->where('status',12)
        ->orWhere('status',14)
        ->delete();

         DB::table('customer_communication_decision')
        ->where('request_id',$id)
        ->delete();
        DB::table('customer_communication_list')
        ->where('request_id',$id)
        ->delete();
         DB::table('customer_communication_decision_wno')
        ->where('request_id',$id)
        ->delete();

        $i = 0;
        foreach ($input->comment as $value1) {



            if ($value1 != '') {

               $data = DB::table('tb_users')
                          ->select('id')
                          ->where('active',1)
                          ->where('id',$input->cid[$i])
                          ->get();

                          $data1 = DB::table('tb_users')
                          ->select('first_name','last_name')
                          ->where('id',$input->cid[$i])
                          ->get();
                          if(empty($data)){
                            return Redirect::back()
                      ->with('message', SiteHelpers::alert('error',$data1[0]->first_name.''.$data1[0]->last_name.' is inactive you can not reject task'))
                      ->withInput();
                          }

                DB::table('reject_of_risk_assessment_based_on_cost')->insert(
                    array('request_id' => $input->request_id,
                        'reject_status' => $input->radioStatus,
                        'comment' => $value1,
                        'user_id' => $input->cid[$i]

                    )
                );

                   //------trackingSheet reject by steering Commitee------

                    $dept_id = DB::table('tb_users')->select('department')->where('id',$input->cid[$i])->get();


               DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 3)
                  ->where('process','RiskAssessment By '.$dept_id[0]->department)
                  ->update(['actual_date' => 0]);

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 4)
                  ->where('process','Risk Assessment Approval by '.$dept_id[0]->department.' HOD')
                  ->delete();

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 5)
                  ->delete();

                   DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 6)
                  ->delete();

               //------------end------------   

                DB::table('add_updated_risk_assessment_sheet')
                    ->where('add_updated_risk_assessment_sheet.user_id',$input->cid[$i])
                    ->where('add_updated_risk_assessment_sheet.r_id',$id)
                    ->update(array(
                            'user_dep'=>0,
                            'user_dep_hod_approve'=>0,
                            'status' => 1

                        )
                    );


                $users = DB::table('reject_of_risk_assessment_based_on_cost')

                    ->select('reject_of_risk_assessment_based_on_cost.user_id','reject_of_risk_assessment_based_on_cost.comment')
                    ->where('request_id', $input->request_id)
                    ->where('user_id', $input->cid[$i])
                    ->groupBy('reject_of_risk_assessment_based_on_cost.user_id')
                    ->get();



                foreach ($users as $value) {

                    $user_id = (String)$value->user_id;

                   // $users_detail = $this->get_user_info_by_id($user_id);

                    //$message = "Reject Steering Committee Approval Pending (Based on cost involved).";
                    $message = "Rejected by Steering Committee. Pending clearance of Risk Assessment point activities from CFT Dept.";

                    $url = 'changes/update-risk-analysis-sheet/';


                    $last_id_req= $this->save_noticication_status_for_reject($user_id, $id, $message, $url, 11,$value1);
                    $this->change_request_status_close($id, $id1);

                      /*  DB::table('request_progress_status')
                            ->where('request_id', $id)
                            ->where('status', 88)
                            ->update(['close' => 1]);*/



                    DB::table('request_progress_status')
                           ->where('request_id', $id)
                           ->where('status', 88)
                           ->update(['close' => 1]);

                    $data1 = $this->get_user_info_by_id($user_id);//Assigned to task
                    $admin = $this->get_user_info_by_id(1);


                    $request_id=$id;
                    $close_status=$last_id_req;

                    $comment=$value1;
                    $contactName = $data1['name'];
                    $email_id = $data1['email'];
                    $assignedby=Session::get('fid');
                    $admin_email=$admin['email'];
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                    $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'comment'=>$comment);



                    if($this->check_netconnection())
                    {

                        Mail::send('emails/email-templates-reject', $data_1, function ($message) use ($email_id,$admin_email) {

                            $message->to($email_id);
                            $message->bcc($admin_email)
                                ->subject('You Have New Task');

                        });

                    }else{



                    }


                }

            }
            $i++;



        }

         $current_user=Session::get('uid');
        $aa=$this->send_mail_to_remaining_member($current_user,$id);


        foreach ($aa as $ans) {


            $user_id = $ans['user_id'];

            $message = "Rejected by Steering Committee. Pending clearance of Risk Assessment point activities from CFT Dept.";

            $data1 = $this->get_user_info_by_id($user_id);//Assigned to task

            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');


            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'request_id'=>$cmNo);

            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates-reject-steeringmail', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });


            }else{



            }

        }
        return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

        //     return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));



        /*
         *
         * Old code below new client changes code above which affected old code
         *
         */

        /*  $users = DB::table('tb_updatesheet_dep_team')
              // ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
              ->select('tb_updatesheet_dep_team.team_member')->where('request_id', $input->request_id)
              ->get();

          foreach ($users as $value) {
              // $email_send = (String)$value->email;
              //$email_send1 = (String)$value->id;
              $user_id = (String)$value->team_member;


              $users_detail = $this->get_user_info_by_id($user_id);

              //$message = "Reject Steering Committee Approval Pending (Based on cost involved).";
              $message = "Rejected by Steering Committee. Pending clearance of Risk Assessment point activities from CFT Dept.";

              $url = 'changes/update-risk-analysis-sheet/';
              $this->save_noticication_status($user_id, $id, $message, $url, 11);


              $email_send = $users_detail['email'];

              Mail::send('emails/email-template', array('data' => $email_send), function ($message) use ($email_send) {

                  $message->to($email_send)->subject('Welcome!');

              });
              $this->change_request_status_close($id, $id1);

              return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));



              */

        /*$users = DB::table('tb_departments')
            ->leftJoin('tb_risk_assessment_points', 'tb_departments.d_id', '=', 'tb_risk_assessment_points.risk_dep')
            ->select('tb_risk_assessment_points.responsibility')
            ->where('tb_risk_assessment_points.request_id', $id)
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->first();


        $user_id = $users->team_member;


        $users_detail = $this->get_user_info_by_id($user_id);

        //$message = "Reject Steering Committee Approval Pending (Based on cost involved).";
        $message="Rejected by Steering Committee. Pending clearance of Risk Assessment point activities from CFT Dept.";

        $url = 'changes/update-risk-analysis-sheet/';
        $this->save_noticication_status($user_id, $id, $message, $url, 11);


        $email_send = $users_detail['email'];

        Mail::send('emails/email-template', array('data' => $email_send), function ($message) use ($email_send) {

            $message->to($email_send)->subject('Welcome!');

        });
        $this->change_request_status_close($id, $id1);

        return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));*/



    }

    public function close_request($id)
    {


        $input = (object)Input::all();

        $id1=$input->request_progress_id;
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return ;exit();
         }
        $this->change_request_status_close($id, $id1);
        DB::table('request_progress_status')
            ->where('request_id', $id)
            ->where('status', 88)
            ->update(['close' => 1]);

        DB::table('approval_risk_assessment_from_admin')
            ->where('request_id', $id)
            ->update(['approve_status' => 3]);


      DB::table('permanent_reject_close')->insert(
            array(
                'request_id' => $id,
                'rejected_by_id' => Session::get('uid'),
                'rejected_by_name' => Session::get('fid'),
                'remark' => $input->reject_reason,
                'reject_date' => date('Y-m-d H:i:s'),
                'created_date'=> date('Y-m-d')

            )
        );

        $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$id)
            ->get();

            if($checkParam[0]->change_stage == 1){
               $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();
               }

        $first = DB::table('add_updated_risk_assessment_sheet')
            ->select('add_updated_risk_assessment_sheet.user_id')
            ->where('add_updated_risk_assessment_sheet.r_id', $id);


        $users = DB::table('add_updated_risk_assessment_sheet')
            ->select('add_updated_risk_assessment_sheet.hod')
            ->where('add_updated_risk_assessment_sheet.r_id', $id);


        $users1 = DB::table('changerequests')
            ->select('changerequests.initiator_id')
            ->where('changerequests.request_id', $id);

        $current_user=Session::get('uid');
        $steering=DB::table('request_progress_status')
            ->select('assigned_to')
            ->where('request_id', $id)
            ->where('assigned_to', '!=',$current_user)
            ->where('status',88)
            ->distinct('assigned_to');

        $adminId=DB::table('request_progress_status')
            ->select('assigned_by')
            ->where('request_id', $id)
            ->where('status',88)
            ->distinct('assigned_by');


          if(isset($representative_id) && !empty($representative_id)){

              $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code);

              $results = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id', $id)
                ->union($first)
                ->union($users)
                ->union($users1)
                ->union($steering)
                ->union($adminId)
                ->union($representative_id)
                ->get();
            }else{


        $results = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id', $id)
            ->union($first)
            ->union($users)
            ->union($users1)
            ->union($steering)
            ->union($adminId)
            ->get();
          }  
          // print_r($results);exit();
        $initiatorId=DB::table('changerequests')
            ->select('changerequests.changeType','changerequests.created_date')
            ->where('changerequests.request_id', $id)
            ->get();

        $query1=DB::table('tbl_change_type')
            ->select('tbl_change_type.change_type_name')
            ->where('tbl_change_type.change_type_id',$initiatorId[0]->changeType)
            ->get();






        $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$initiatorId[0]->created_date,$id);


        $assignById=DB::table('tb_users')
            ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
            ->where('tb_users.id', Session::get('uid'))
            ->groupBy('tb_users.id')
            ->get();

        $assignByName= $assignById[0]->first_name." ".$assignById[0]->last_name;

        foreach($results as $row){

            $allUser=DB::table('tb_users')
                ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                ->where('tb_users.id', $row->Approval_Authority)
                ->groupBy('tb_users.id')
                ->get();

            $message = "Change Request ".$cmNo." is  Rejected and Closed by ".$assignByName.".";
            $comment=$input->reject_reason;
            $contactName = $allUser[0]->first_name." ".$allUser[0]->last_name;
            $email_id = $allUser[0]->email;

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'comment'=>$comment);

            if($this->check_netconnection())
            {

                Mail::send('emails/permanent-reject', $data_1, function ($message) use ($email_id) {


                    $message->to($email_id)
                        ->subject('Change Request is Rejected and Closed');

                });

            }else{



            }

        }

        $this->change_request_status_reject_and_close($id, $id1, $assignByName);
        return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));




    }

    public function customer_verification($id)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
     }else{   
        if ($this->check_request_permission($id)) {

            return View::make('changes/customer_verification');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }
      }

    }

    public function customer_verification_for_reject($id)
    {


        if ($this->check_request_permission($id)) {

            return View::make('changes/customer_verification_for_reject');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }


    }

    public function customer_verify_for_reject($id1)
    {


        $input = (object)Input::all();
        $id=$input->request_id;

        if (isset($input->reject_reason)) {
            $reject_reason = $input->reject_reason;
        } else {
            $reject_reason = '';
        }

        if ($input->radioStatus == 1) {

            DB::table('customer_verification')->where('request_id', $id)->delete();

            DB::table('customer_verification')->insert(
                array('request_id' => $input->request_id,
                    'status' => $input->radioStatus,

                )
            );
            $users = DB::table('tb_users')
                ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                ->select('tb_users.id', 'tb_users.email')
                ->where('changerequests.request_id', $id)
                ->first();

            $message = "Pending Decision of Horizontal Deployment applicability from Initiator.";

            $url = 'changes/horizontal-deployment/';
            $last_id_req=$this->save_noticication_status($users->id, $id, $message, $url, 17);

            $this->change_request_status_close($id, $id1);

            $data1 = $this->get_user_info_by_id($users->id);//Assigned to task


            $request_id=$id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }

           /* $email_send = $users->email;

            Mail::send('emails/email-template', array('data' => (String)$email_send), function ($message) use ($email_send) {

                $message->to($email_send)->subject('Welcome!');

            });*/

        } else if ($input->radioStatus == 2) {

          /*  DB::table('customer_verification')->insert(
                array('request_id' => $input->request_id,
                    'status' => $input->radioStatus,
                    'comment' => $reject_reason,

                )
            );

            $QaHod = $this->get_user_by_role(6);

            $email_send = $QaHod[0]['email'];
            $id = $QaHod[0]['user_id'];

            $message = "Rejected by Admin. Pending Customer Approval from responsible person.";

            $url = 'changes/customer-communication-decision/';
            $this->save_noticication_status($id, $input->request_id, $message, $url, 15);


            Mail::send('emails/email-template', array('data' => $email_send), function ($message) use ($email_send) {
                $message->to($email_send)->subject('Welcome!');

            });

            $this->change_request_status_close($input->request_id, $id1);
        }


    }*/

            DB::table('customer_verification')->where('request_id', $id)->delete();

            DB::table('customer_verification')->insert(
                array('request_id' => $input->request_id,
                    'status' => $input->radioStatus,
                    'comment' => $reject_reason,

                )
            );

            $users = DB::table('Customer_Communication_Decision')

                ->select('Customer_Communication_Decision.user_id')
                ->where('request_id', $input->request_id)
                ->groupBy('Customer_Communication_Decision.user_id')
                ->first();


            $QaHod = $this->get_user_email_by_id($users->user_id);


            $email_send = $QaHod;
            $id = $users->user_id;

            $message = "Rejected by Admin. Pending Customer Approval from responsible person.";

            $url = 'changes/customer-communication-decision-attachment/';

            $last_id_req=$this->save_noticication_status_for_reject($id, $input->request_id, $message, $url, 15,$reject_reason);

            $data1 = $this->get_user_info_by_id($id);//Assigned to task

            $request_id=$input->request_id;
            $close_status=$last_id_req;

            $admin = $this->get_user_info_by_id(1);

            $comment=$input->reject_reason;

            $admin_email=$admin['email'];


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'comment'=>$comment);


            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id,$admin_email) {

                    $message->to($email_id);
                    $message->bcc($admin_email)
                        ->subject('You Have New Task');

                });


            }else{



            }

         /*   Mail::send('emails/email-template', array('data' => $email_send), function ($message) use ($email_send) {
                $message->to($email_send)->subject('Welcome!');

            });*/

            $this->change_request_status_close($input->request_id, $id1);
        }


    }

    public function customer_verify($id1)
    {

        $input = (object)Input::all();
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$input->request_id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
          $c='c';
            return $c;exit();
         }

        if (isset($input->reject_reason)) {
            $reject_reason = $input->reject_reason;
        } else {
            $reject_reason = '';
        }

        if ($input->radioStatus == 1) {

          $checkuser=DB::table('tb_updatesheet_dep_team')
            ->select('team_member')
            ->where('request_id',$input->request_id)
            ->get();

           foreach ($checkuser as $key) {
            $inactiveuser=DB::table('tb_users')
            ->select('first_name','last_name')
            ->where('active',0)
            ->where('id',$key->team_member)
            ->get();
            if(!empty($inactiveuser)){
              $data[]=array(
                  'user'=>$inactiveuser[0]->first_name.' '.$inactiveuser[0]->last_name,
                  'inactive'=>'0',

                );
              return $data;exit();
            }
           }


            DB::table('customer_verification')->insert(
                array('request_id' => $input->request_id,
                   'status' => $input->radioStatus,

                )
            );

            DB::table('tb_updatesheet_dep_team')
                ->where('request_id', $input->request_id)
                ->update(['resp_emp_status' => 3]);//3 for task assign to responsibles employees

            $data  = DB::table('tb_updatesheet_dep_team')
               ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
               ->select('tb_users.email','tb_users.id','tb_users.department')
               ->where('tb_updatesheet_dep_team.request_id','=',$input->request_id)
               ->get();

            $message = "Pending from Responsible person to monitor activity completion status.";

            $url = 'changes/activity-monitoring/';

            foreach ($data as $value) {


                   

                $email_id = (String)$value->email;
                $user_id = (String)$value->id;
                $department = (String)$value->department;


                   //----start code for tracking Sheet----


                  $target_date1 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->where('tb_risk_assessment_points.request_id', $input->request_id)
            ->where('tb_risk_assessment_points.responsibility', $user_id)
            ->first();

                  if($target_date1->t_date=="0000-00-00"){

                   $target_date='';


                  }else{

                    $target_date=$target_date1->t_date;
                  }


                
                $Date=date('Y-m-d');

             
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'Risk Activity Status Document Upload by '.$department,
                          'target_date' =>$target_date,
                          'actual_date'  =>0,
                          'status'      =>10
                        )
                    );
                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 9)

                  ->update(['actual_date' => $Date]);

               
                 //----end code for tracking Sheet----

                $last_id_req=$this->save_noticication_status($user_id, $input->request_id, $message, $url, 14);
                $this->save_task_status($user_id,$department,$input->request_id);

                $data1 = $this->get_user_info_by_id($user_id);//Assigned to task


                $request_id=$input->request_id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');

                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{



                }
             
                $this->change_request_status_close($input->request_id, $id1);
            }



        } else if ($input->radioStatus == 2) {

            DB::table('customer_verification')->insert(
                array('request_id' => $input->request_id,
                    'status' => $input->radioStatus,
                    'comment' => $reject_reason,

                )
            );

             //------trackingSheet reject by superadminCust Evd Upload------
             $update=  DB::table('tracking_sheet_info')
                  ->where('request_id',$input->request_id)
                  ->where('status', 8)
                  ->update(['actual_date' => 0]);

                 

               $delete= DB::table('tracking_sheet_info')
                ->where('request_id', $input->request_id)
                ->where('status', 9)
                ->delete();

               //------------end------------   


            $users = DB::table('Customer_Communication_Decision')

                ->select('Customer_Communication_Decision.user_id')
                ->where('request_id', $input->request_id)
                ->groupBy('Customer_Communication_Decision.user_id')
                ->orderBy('Customer_Communication_Decision.id','desc')
                ->first();


            $QaHod = $this->get_user_email_by_id($users->user_id);


            $email_send = $QaHod;
            $id = $users->user_id;

            $message = "Rejected by Admin. Pending Customer Approval from responsible person.";

            $url = 'changes/customer-communication-decision-attachments/';


            $last_id_req=$this->save_noticication_status_for_reject($id, $input->request_id, $message, $url, 15,$reject_reason);

            $admin = $this->get_user_info_by_id(1);

            $data1 = $this->get_user_info_by_id($id);//Assigned to task

            $request_id=$input->request_id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $comment=$reject_reason;
            $admin_email=$admin['email'];
             $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                    $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'comment'=>$comment);


            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'comment'=>$comment);



            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates-reject', $data_1, function ($message) use ($email_id,$admin_email) {

                    $message->to($email_id);
                    $message->bcc($admin_email)
                        ->subject('You Have New Task');

                });

            }else{



            }

            $this->change_request_status_close($input->request_id, $id1);
        }else{

            $id= $input->request_id;


                 DB::table('permanent_reject_close')->insert(
                     array(
                         'request_id' => $id,
                         'rejected_by_id' => Session::get('uid'),
                         'rejected_by_name' => Session::get('fid'),
                         'remark' => $input->close_reason,
                         'reject_date' => date('Y-m-d H:i:s'),
                         'created_date'=> date('Y-m-d')

                     )
                 );
           $this->change_request_status_close($input->request_id, $id1);

            $first = DB::table('add_updated_risk_assessment_sheet')
                ->select('add_updated_risk_assessment_sheet.user_id')
                ->where('add_updated_risk_assessment_sheet.r_id', $id);


            $users = DB::table('add_updated_risk_assessment_sheet')
                ->select('add_updated_risk_assessment_sheet.hod')
                ->where('add_updated_risk_assessment_sheet.r_id', $id);


            $users1 = DB::table('changerequests')
                ->select('changerequests.initiator_id')
                ->where('changerequests.request_id', $id);

            $steeringMember=DB::table('request_progress_status')
                ->select('assigned_to')
                ->where('request_id', $id)
                ->where('status',88)
                ->distinct('assigned_to');

            $resPersonId =DB::table('Customer_Communication_Decision')
                ->select('Customer_Communication_Decision.user_id')
                ->where('Customer_Communication_Decision.request_id',$id);

            $qaHodId =DB::table('approval_for_risk_assessment_for_cost_involved')
                ->select('approval_for_risk_assessment_for_cost_involved.QA_HOD_id')
                ->where('approval_for_risk_assessment_for_cost_involved.request_id',$id);



            $results = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id', $id)
                ->union($first)
                ->union($users)
                ->union($users1)
                ->union($steeringMember)
                ->union($resPersonId)
                ->union($qaHodId)
                ->get();


            $initiatorId=DB::table('changerequests')
                ->select('changerequests.changeType','changerequests.created_date')
                ->where('changerequests.request_id', $id)
                ->get();

            $query1=DB::table('tbl_change_type')
                ->select('tbl_change_type.change_type_name')
                ->where('tbl_change_type.change_type_id',$initiatorId[0]->changeType)
                ->get();
            $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$initiatorId[0]->created_date,$id);

            $assignById=DB::table('tb_users')
                ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                ->where('tb_users.id', Session::get('uid'))
                ->groupBy('tb_users.id')
                ->get();

            $assignByName= $assignById[0]->first_name." ".$assignById[0]->last_name;
            $this->change_request_status_reject_and_close($id, $id1, $assignByName);


            foreach($results as $row){

                $allUser=DB::table('tb_users')
                    ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                    ->where('tb_users.id', $row->Approval_Authority)
                    ->groupBy('tb_users.id')
                    ->get();


                $message = "Change Request ".$cmNo." is  Rejected and Closed by ".$assignByName.".";
                $comment=$input->close_reason;
                $contactName = $allUser[0]->first_name." ".$allUser[0]->last_name;
                $email_id = $allUser[0]->email;




                $data_1 = array('firstname'=>$contactName,'description'=>$message,'comment'=>$comment);



                if($this->check_netconnection())
                {

                    Mail::send('emails/permanent-reject', $data_1, function ($message) use ($email_id) {


                        $message->to($email_id)
                            ->subject('Change Request is Rejected and Closed');

                    });

                }else{

                }

            }


        }


    }

    public function activity_monitoring($id)
    {
        $data1 = array(
            'request_id'  => "",
            'page'        => 'modifyByUser',
            'dept_id'       =>"",
            'userId'        =>""

        );
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
     }else{   
        if ($this->check_request_permission($id)) {

            return View::make('changes/activity-monitoring')->with($data1);
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }
      }


    }


    public function get_allRisk_assessment_approval1($id)
    {//print_r($id);exit;
        $res = array();
        $points = DB::table('tb_risk_assessment_points')

          //  ->leftJoin('activity_monitering_document_attachment', 'tb_risk_assessment_points.request_id', '=', 'activity_monitering_document_attachment.request_id')
            ->leftJoin('tb_risk_assessment_points_admin', 'tb_risk_assessment_points.risk_assessment_id_admin', '=', 'tb_risk_assessment_points_admin.risk_assessment_id_admin')
            ->select('tb_risk_assessment_points.*', 'tb_risk_assessment_points.request_id as r_id',  'tb_risk_assessment_points_admin.assessment_point_department')
            ->where('tb_risk_assessment_points.request_id', $id)// ->where('request_id', $id)
            ->get();



        foreach ($points as $point) {

            if($point->target_date=='0000-00-00'){

                $target_date='';
            }else{

                $target_date=$point->target_date;

            }

            if($point->cost=='0'){

                $cost='';
            }else{

                $cost=$point->cost;
            }

            $res[] = array('request_id' => $point->r_id,
                'risk_assessment_id' => $point->risk_assessment_id,
                'assessment_point' => $point->assessment_point_department,
                'applicability' => $point->applicability,
                'reason' => $point->reason,
                'status_activity_monitoring' => $point->status_activity_monitoring,
                'status_verification' => $point->status_verification,
                'de_risking' => $point->de_risking,
                'responsibility' => $this->get_user_info_by_id($point->responsibility),
                'target_date' => $target_date,
                'cost' => $cost,
              //  'category' => $this->get_risk_category_byid($point->risk_dep,$point->risk_assessment_id,$point->r_id),
               // 'count' => $this->get_attachment_count_by_listid($point->risk_assessment_id, $point->request_id),

                'status' => $this->get_attached_file_status($point->risk_assessment_id,$point->risk_dep),
                'attachments'=>$this->get_all_atachments_activity_monitoring_changes($point->risk_assessment_id,$point->r_id,$id),

            );

        }
 //echo "<pre>";print_r($res);
        return $res;
    }

    public function getActivityUpload($id,$dept_id){
        $attachments =DB::table('attachment_activity_monitoring')
        ->select(DB::raw('count(attachment_id) as total'))
        ->where('dep_id',$dept_id)
        ->where('request_id',$id)
        ->get();

        return $attachments[0]->total;

    }


    function get_attached_file_status($list_id,$id){

         $points = DB::table('risk_assessment_document_upload')
            ->select('risk_assessment_document_upload.*')
            ->where('sub_dep_id', $id)
            ->first();

        return $points;


        $points1  = DB::table('attachment_activity_monitoring')
            // ->leftJoin('activity_monitering_document_attachment', 'tb_risk_assessment_points.risk_assessment_id', '=', 'activity_monitering_document_attachment.list_id')
            ->select('attachment_activity_monitoring.*')
            ->where('attachment_activity_monitoring.list_id', $list_id)
            ->where('attachment_activity_monitoring.category_id', (String)$points->risk_assessment_document_id)

            ->get();


        //  $res = array('risk_assessment_id' => $points->risk_assessment_id,

        //    'attachments' => $this->get_all_atachments_activity_monitoring1($id, $category_id, $list_id),

        ///   );

        return $points1;


}

    function get_attachment_count_by_listid($id, $id1)
    {


        $users = DB::table('attachment_activity_monitoring')
            ->select(DB::raw('COUNT(attachment_id) as count'))
            ->where('attachment_activity_monitoring.list_id', $id)
            // ->where('attachment_activity_monitoring.request_id', $id1)
            //->groupBy('changerequests.status')
            ->get();

        return $users[0]->count;

    }
    function get_risk_category_attachments_count($list_id,$sub_dep_id,$r_id){
      // return $list_id.'/'.$sub_dep_id.'/'.$r_id;
        //return $list_id;
        $users = DB::table('attachment_activity_monitoring')
            ->select(DB::raw('COUNT(attachment_id) as count'))
           ->where('attachment_activity_monitoring.list_id', $list_id)
            ->where('attachment_activity_monitoring.category_id', $sub_dep_id)
            ->where('attachment_activity_monitoring.request_id', $r_id)
            // ->where('attachment_activity_monitoring.request_id', $id1)
            //->groupBy('changerequests.status')
            ->get();

        return $users[0]->count;

    }

    /**
     * @param $id
     * @return mixed
     */
    function get_risk_category_byid($id,$risk_id,$r_id)
    {
         $points = DB::table('risk_assessment_document_upload')
            ->select('risk_assessment_document_upload.*')
            ->where('sub_dep_id', $id)
            ->get();

//print_r($points);exit;
        $res=array();

        foreach ($points as $point) {
            $res[] = array(

                'risk_assessment_document_id' => $point->risk_assessment_document_id,
                'sub_dep_id' => $point->sub_dep_id,
                'category' => $point->category,

                'attachments' => $this->get_risk_category_attachments_count($risk_id,$point->risk_assessment_document_id,$r_id),

            );
        }
        return $res;

    }

    /*
     *
     * Old function to upload file with proper count of file
     *
     *
     */

    public function uploaddoc_activity_monitoring($id, $id1)
    {//print_r($id);exit;

        // print_r($input =(object)Input::all());exit;
        //   print_r(Input::get('risk_assessment_document_id'));exit;

        if (!empty(Input::get('Upload'))) {


            $destinationPath = 'uploads/attachments'; // upload path

            if (Input::hasFile('doc') && Input::file('doc')->isValid()) {

                $name = Input::file('doc')->getClientOriginalName();

                $extension = Input::file('doc')->getClientOriginalExtension();
                $fileName = rand(11111, 99999) . "-" . $name; // renaming image
                Input::file('doc')->move($destinationPath, $fileName);
                // echo $fileName; exit;
                $imagename = $fileName;


                DB::table('activity_monitering_document_attachment')->insert(
                    array('request_id' => $id,
                        'document_category_file' => $imagename,
                        'list_id' => Input::get('list_id'),
                        'document_category_id' => Input::get('risk_assessment_document_id'),
                        // 'user_id' => $input->user_id,
                        // 'created_date' => date('Y-m-d H:i:s'),
                    )
                );

                // return Redirect::to('customer_communication_decision_attachments/$id');

                return Redirect::back()->with('success', 'You have posted successfully');
            }
        } else {

            return Redirect::back()->with('success', 'You have posted successfully');

        }


    }


    public function uploaddoc_activity_monitoring_file($id, $id1)
    {
        //$dept_id=Input::get('dept_id');
        if (!empty(Input::get('delete_attachment'))) {

            if (!empty(Input::get('attachment_name'))) {
               $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'You can not upload document.Task is already completed.'))
                   ->withInput();
     }
                DB::table('attachment_activity_monitoring')->where('attachment_id', Input::get('list_id'))->delete();
                $filename = public_path() . '/uploads/attachments/' . Input::get('attachment_name');
                if (File::exists($filename)) {
                    File::delete($filename);
                }
                return Redirect::back()->with('success', 'You have posted successfully');
            }

        } else if (!empty(Input::get('Upload'))) {
           $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'You can not upload document.Task is already completed.'))
                   ->withInput();
     }
            $ext1 = DB::table('tb_dept_addRemove')
                    ->select('file_upload_type')
                    ->get();

           $user_id = Input::get('user_id');
           $dept_id = Input::get('dept_id');

            if($user_id == ""){
                $user_id=Session::get('uid');

            }else{
                $user_id=Input::get('user_id');
            }

            if($dept_id == ""){
                $dep_id=Session::get('dep_id');

            }else{
                $dep_id=Input::get('dept_id');
            }

            $destinationPath = 'uploads/attachments'; // upload path

            if (Input::hasFile('doc')) {

                $names = Input::file('doc');

                foreach ($names as $name) {
                    $extension = $name->getClientOriginalName();
                    $filename = rand(11111,99999).'-'.$extension; // renameing image
                    $info = pathinfo($filename);
                    $ext = $info['extension'];
                    $a = array('tif','gif','png','jpg','jpeg','pdf');
                    if($ext1[0]->file_upload_type == "Specific"){
                     if (!in_array(strtolower($ext), $a)) {
                          return Redirect::back()->with('message', SiteHelpers::alert('error', 'Only image and file can be attached'));
                      }
                    }  
                    $upload_success = $name->move($destinationPath, $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename));
                   $risk_assessment_id = Input::get('risk_assessment_id');
                    $applicability = Input::get('applicability');
                    $this->save_attachment_files_activity_monitering($id, $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename), $risk_assessment_id,$applicability,$user_id,$dep_id);
                }
                return Redirect::back()->with('success', 'You have posted successfully');
            }
          } else {
              return Redirect::back()->with('success', 'You have posted successfully');
          }
    }

    /*
     *
     * Below function upload file on activity monitoring page new changes
     *
     *
     */

    public function save_attachment_files_activity_monitering($id, $filename, $list_id,$applicability,$user_id,$dep_id)
    {

        DB::table('attachment_activity_monitoring')->insert(
            array('request_id' => $id,
                'attachment_file' => $filename,
                'list_id' => $list_id,
                'decision'=>$applicability,
                'user_id'=>$user_id,
                'dep_id'=>$dep_id,

            )
        );
    }


    function get_all_atachments_activity_monitoring_changes($list_id, $get_id = NULL,$request_id)
    {

        $attachments = DB::table('attachment_activity_monitoring')
            ->select('attachment_activity_monitoring.*')
            ->where('list_id', $list_id)
            ->where('request_id', $request_id)
            ->get();

        $purpose = [];

        foreach ($attachments as $attachment) {
            $purpose[] = array('attachment_id' => $attachment->attachment_id,
                'request_id' => $attachment->request_id,
                'attachment_file' => $attachment->attachment_file,
                'list_id' => $attachment->list_id,
            );

        }


        return $purpose;


    }
    public function cntFile($list_id,$r_id,$dep_id){

      $attachments = DB::table('attachment_activity_monitoring')
            ->select(DB::raw('COUNT(attachment_id) as total'))
            ->where('list_id', $list_id)
            ->where('request_id', $r_id)
            ->where('dep_id',$dep_id)
            ->get();
            return $list_id."@".$attachments[0]->total;
    }


    function get_all_atachments_activity_monitoring($list_id, $get_id = NULL)
    {

        $query = DB::table('activity_monitering_document_attachment')
            ->select('activity_monitering_document_attachment.*')
            ->where('activity_id', $list_id);
        if (isset($get_id) && !empty($get_id))
            $query->where('activity_monitering_document_attachment.document_category_id', $get_id);
        $attachments = $query->get();

        $purpose = [];

        foreach ($attachments as $attachment) {
            $purpose[] = array('activity_id' => $attachment->activity_id,
                'attachment_id' => $attachment->activity_id,
                'document_category_file' => $attachment->document_category_file,
            );

        }


        return $purpose;


    }


   /* function delete_attachment_list_activity_monitoring($id)
    {//print_r($id);exit;
        if (!empty(Input::get('attachment_file'))) {

            DB::table('attachment_activity_monitoring')->where('attachment_id', $id)->delete();

            $filename = public_path() . '/uploads/attachments/' . Input::get('attachment_file');

            if (File::exists($filename)) {
                File::delete($filename);
            }

        }

    }*/
    /*
     * below code is for count delete in activity monitoring page
     *
     */
    /*function delete_attachment_list_activity_monitoring($id)
    {print_r($id);exit;
        if (!empty(Input::get('name'))) {

            DB::table('activity_monitering_document_attachment')->where('activity_id', $id)->delete();

            $filename = public_path() . '/uploads/attachments/' . Input::get('name');

            if (File::exists($filename)) {
                File::delete($filename);
            }

        }

    }*/

    public function update_status($id)
    {

        $input = Input::all();

        if ($input[0] == 1) {

            DB::table('tb_risk_assessment_points')
                ->where('risk_assessment_id', $id)
                ->update(['status_activity_monitoring' => 1]);

            return 'success';


        } else {

            DB::table('tb_risk_assessment_points')
                ->where('risk_assessment_id', $id)
                ->update(['status_activity_monitoring' => 2]);

            return 'success';

        }


    }

    public function update_verification($id)
    {

        $input = Input::all();


        if ($input[0] == 1) {

            DB::table('activity_monitering_verification_status')->insert(
                array('request_id' => $id,
                    'user_id'=>Session::get('uid'),
                    'verify_status' => 1,

                )
            );


         /*   DB::table('activity_monitering_verification_status')
                ->where('risk_assessment_id', $id)
                ->update(['status_verification' => 1]);

            return 'success';*/


        } else {

            DB::table('activity_monitering_verification_status')->insert(
                array('request_id' => $id,
                    'user_id'=>Session::get('uid'),
                    'verify_status' => 2,

                )
            );

        }


    }
    public function get_verification_data($id){



        $users = DB::table('activity_monitering_verification_status')

            ->select('activity_monitering_verification_status.verify_status')
            ->where('activity_monitering_verification_status.request_id', $id)
            ->orderBy('activity_monitering_verification_status.verify_id', 'DESC')
           // ->where('activity_monitering_verification_status.user_id', Session::get('uid'))
            ->first();


        $data=(String)$users->verify_status;


        return $data;
    }


    /* public function add_comment_for_verification($id){

             DB::table('activity_monitering_document_attachment')
         ->where('activity_monitering_document_attachment.request_id', $id)
         ->update(['comment'=> Input::get('comment')]);

         return Redirect::back()->with('success', 'You have posted successfully');

   }*/

   public function PTR_document($id)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
       if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
       }else{   
        return View::make('changes/PTR_document');
      

        return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
      }
      


    }

    public function activity_completion_sheet()
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
      if($checkClose[0]->close ==1){
              return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
      }else{   
        return View::make('changes/activity-completion-sheet');
      }

    }

    public function verify_activity_completion_sheet($id, $id1)
    {

      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();         
          }
        $input = (object)Input::all();

        if ($input->radioStatus == 1) {

            //----start code for tracking Sheet----

                
                $Date=date('Y-m-d');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 12)

                  ->update(['actual_date' => $Date]);

                 //----end code for tracking Sheet----



            $reject_reason='';
            DB::table('activity_completion_sheet_verify')->insert(
                array('request_id' => $id,
                    'status' => $input->radioStatus,
                    'reject_reason'=>$reject_reason,

                )
            );

            

            $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$id)
            ->get();

            
            if($checkParam[0]->change_stage == 1){
               /*tracking sheet*/
              $data=DB::table('tracking_sheet_date_param')->where('id',15)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'PTR Document Upload',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>16
                        )
                    );
                  /*-------------------*/

              $users = DB::table('tb_users')
                ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                ->select('tb_users.id', 'tb_users.email')
                ->where('changerequests.request_id', $id)
                ->first();

                 $this->change_request_status_close($id, $id1);
            $message = "Pending for PTR document upload.";

            $url = 'changes/PTR_document/';

                 $last_id_req=$this->save_noticication_status($users->id, $id, $message, $url, 22);
            $data1 = $this->get_user_info_by_id($users->id);//Assigned to task
            }else if($checkParam[0]->change_stage == 2 && $checkParam[0]->proj_code == ""){

                /*tracking sheet*/
              $data=DB::table('tracking_sheet_date_param')->where('id',12)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Horizontal Deployment',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>13
                        )
                    );
                  /*-------------------*/
              

                 $users = DB::table('tb_project_manager')
                ->select('proj_mgr_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();

              
                      if(!empty($users)){
                    $meber = DB::table('tb_users')
                       ->select('tb_users.id', 'tb_users.email')
                       ->where('id',$users[0]->proj_mgr_id)
                      ->get();
                    }else{
                        
                         return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for horizontal deployment'));
                    }

                   $this->change_request_status_close($id, $id1);
                  $message = "Pending Decision of Horizontal Deployment applicability from Initiator.";

                  $url = 'changes/horizontal-deployment/';

                  $last_id_req=$this->save_noticication_status($meber[0]->id, $id, $message, $url, 17);
                  $data1 = $this->get_user_info_by_id($meber[0]->id);//Assigned to task
            }else{
                /*tracking sheet*/
              $data=DB::table('tracking_sheet_date_param')->where('id',12)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Horizontal Deployment',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>13
                        )
                    );
                  /*-------------------*/
                 $users = DB::table('tb_projectMaster')
                ->select('project_manager')
                ->where('id',$checkParam[0]->proj_code)
                 ->get();
                 if(!empty($users)){
                    $meber = DB::table('tb_users')
                       ->select('tb_users.id', 'tb_users.email')
                       ->where('id',$users[0]->project_manager)
                      ->get();
                  }else{
                       return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for horizontal deployment'));
                    }

                   $this->change_request_status_close($id, $id1);
                  $message = "Pending Decision of Horizontal Deployment applicability from Initiator.";

                  $url = 'changes/horizontal-deployment/';

                  $last_id_req=$this->save_noticication_status($meber[0]->id, $id, $message, $url, 17);
                  $data1 = $this->get_user_info_by_id($meber[0]->id);//Assigned to task
            }

           $request_id=$id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }else if($input->radioStatus == 2){

          /* tracking sheet*/

           DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 12)
                  ->delete();

                
                  /*----------------*/


            $i = 0;
            foreach ($input->comment as $value1) {
                if ($value1 != '') {
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 10)
                    ->where('process','Risk Activity Status Document Upload by '.$input->did[$i])
                  ->update(['actual_date' => 0]);
                 
                    DB::table('activity_completion_sheet_verify')->insert(
                        array('request_id' => $id,
                            'status' => $input->radioStatus,
                            'reject_reason'=>$value1,
                            'user_id' => $input->cid[$i]

                        )
                    );


                    $users = DB::table('activity_completion_sheet_verify')
                        ->select('activity_completion_sheet_verify.user_id','activity_completion_sheet_verify.reject_reason')
                        ->where('activity_completion_sheet_verify.request_id', $id)
                        ->where('activity_completion_sheet_verify.user_id', $input->cid[$i])
                        ->groupBy('activity_completion_sheet_verify.user_id')
                        ->get();


                    foreach ($users as $value) {

                        $user_id = (String)$value->user_id;

                        $this->admin_reject_activity_completion_sheet($user_id,$id);//For summery sheet

                        $message = "Rejected by admin. Pending from Responsible person to monitor activity completion status.";

                        $url = 'changes/activity-monitoring/';

                        $last_id_req=$this->save_noticication_status_for_reject($user_id, $id, $message, $url, 14,$value1);

                        $admin = $this->get_user_info_by_id(1);

                        $data1 = $this->get_user_info_by_id($user_id);//Assigned to task

                        $request_id=$id;
                        $close_status=$last_id_req;

                        $comment=$value->reject_reason;
                        $admin_email=$admin['email'];
                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby=Session::get('fid');

                  $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                   

                        $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'comment'=>$comment);



                        if($this->check_netconnection())
                        {

                            Mail::send('emails/email-templates-reject', $data_1, function ($message) use ($email_id,$admin_email) {

                                $message->to($email_id);
                                $message->bcc($admin_email)
                                    ->subject('You Have New Task');

                            });

                        }else{



                        }

                      /*  $email_send = $users_detail['email'];

                        Mail::send('emails/email-template', array('data' => $email_send), function ($message) use ($email_send) {

                            $message->to($email_send)->subject('Welcome!');

                        });*/
                        $this->change_request_status_close($id, $id1);

                    }
                }

                $i++;

            }


            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

         
        }else{


           DB::table('permanent_reject_close')->insert(
                array(
                    'request_id' => $id,
                    'rejected_by_id' => Session::get('uid'),
                    'rejected_by_name' => Session::get('fid'),
                    'remark' => $input->close_reason,
                    'reject_date' => date('Y-m-d H:i:s'),
                    'created_date'=> date('Y-m-d')

                )
            );

             $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$id)
            ->get();

            if($checkParam[0]->change_stage == 1){
               $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();
               }

            $first = DB::table('add_updated_risk_assessment_sheet')
                ->select('add_updated_risk_assessment_sheet.user_id')
                ->where('add_updated_risk_assessment_sheet.r_id', $id);


            $users = DB::table('add_updated_risk_assessment_sheet')
                ->select('add_updated_risk_assessment_sheet.hod')
                ->where('add_updated_risk_assessment_sheet.r_id', $id);


            $users1 = DB::table('changerequests')
                ->select('changerequests.initiator_id')
                ->where('changerequests.request_id', $id);

            $steeringMember=DB::table('request_progress_status')
                ->select('assigned_to')
                ->where('request_id', $id)
                ->where('status',88)
                ->distinct('assigned_to');

            $resPersonId =DB::table('Customer_Communication_Decision')
                ->select('Customer_Communication_Decision.user_id')
                ->where('Customer_Communication_Decision.request_id',$id);

            $qaHodId =DB::table('approval_for_risk_assessment_for_cost_involved')
                ->select('approval_for_risk_assessment_for_cost_involved.QA_HOD_id')
                ->where('approval_for_risk_assessment_for_cost_involved.request_id',$id);

            if(isset($representative_id) && !empty($representative_id)){

              $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code);

              $results = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id', $id)
                ->union($first)
                ->union($users)
                ->union($users1)
                ->union($steeringMember)
                ->union($resPersonId)
                ->union($qaHodId)
                ->union($representative_id)
                ->get();
            }else{

            $results = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id', $id)
                ->union($first)
                ->union($users)
                ->union($users1)
                ->union($steeringMember)
                ->union($resPersonId)
                ->union($qaHodId)
                ->get();
            }
            // print_r($results);exit();

            $initiatorId=DB::table('changerequests')
                ->select('changerequests.changeType','changerequests.created_date')
                ->where('changerequests.request_id', $id)
                ->get();

            $query1=DB::table('tbl_change_type')
                ->select('tbl_change_type.change_type_name')
                ->where('tbl_change_type.change_type_id',$initiatorId[0]->changeType)
                ->get();
            $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$initiatorId[0]->created_date,$id);

            $assignById=DB::table('tb_users')
                ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                ->where('tb_users.id', Session::get('uid'))
                ->groupBy('tb_users.id')
                ->get();

            $assignByName= $assignById[0]->first_name." ".$assignById[0]->last_name;

            $this->change_request_status_reject_and_close($id, $id1, $assignByName);

            foreach($results as $row){

                $allUser=DB::table('tb_users')
                    ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                    ->where('tb_users.id', $row->Approval_Authority)
                    ->groupBy('tb_users.id')
                    ->get();


                $message = "Change Request ".$cmNo." is  Rejected and Closed by ".$assignByName.".";
                $comment=$input->close_reason;
                $contactName = $allUser[0]->first_name." ".$allUser[0]->last_name;
                $email_id = $allUser[0]->email;




                $data_1 = array('firstname'=>$contactName,'description'=>$message,'comment'=>$comment);




                    Mail::send('emails/permanent-reject', $data_1, function ($message) use ($email_id) {


                        $message->to($email_id)
                            ->subject('Change Request is Rejected and Closed');

                    });


            }
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }

        //return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

      //


    }

    public function horizontal_deployment($id)
    {


        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
         if($checkClose[0]->close ==1){
              return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }else{   

        return View::make('changes/horizontal-deployment');
        
        return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
       }


    }


    public function customers_horizontal($request_id)
    {


         $users = DB::table('changerequests_customer')
             ->select('changerequests_customer.customer_id')
             ->where('changerequests_customer.request_id', $request_id)
             ->get();

        $purpose = array();
        foreach($users as $device){
            $purpose[] = $device->customer_id;
        }

        $customers = DB::table('customer')
            ->select('CustomerId', 'FirstName', 'LastName')
            ->whereNotIn('customer.CustomerId',$purpose)
            ->get();

        return $customers;


    }

    public function horizontal_deployment_approval($id, $id1)
    {
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return 1;exit();
         }
        $input = (object)Input::all();
        // print_r($input);exit();


  //----start code for tracking Sheet----

         $data=DB::table('tracking_sheet_date_param')->where('id',13)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Change Implementation Date & Before After Status',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>14
                        )
                    );
                
                $Date=date('Y-m-d');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                 
                  ->where('status', 13)

                  ->update(['actual_date' => $Date]);

                 //----end code for tracking Sheet----
        $data1 = DB::table('Customer_Communication_list')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('Customer_Communication_list.request_id', $id)
            ->where('Customer_Communication_list.decision', 0)
            ->get();

        if ($input->radioStatus == 1) {


            if ($data1[0]->total > 0) {


                $comment = $input->comment;
                DB::table('horizontal_deployment')->insert(
                    array('request_id' => $id,
                        'status' => $input->radioStatus,
                        'comment' => $comment,
                        'reason'  => $input->reason

                    )
                );

                if (is_array($input->customer_id)) {


                    foreach ($input->customer_id as $value) {


                        DB::table('changerequests_customer')->insert(
                            array(
                                'customer_id' => $value,
                                'request_id' => $id

                            )
                        );

                    }
                }



                $users = DB::table('tb_users')
                    ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                    ->select('tb_users.id', 'tb_users.email')
                    ->where('changerequests.request_id', $id)//1 for super admin id
                    ->first();

                $email_send = $users->email;


                $message = "Pending decision on Cut-Off Date & before-after status.";

                $url = 'changes/before-after-status-option/';
                $last_id_req = $this->save_noticication_status($users->id, $id, $message, $url, 18);
                $this->change_request_status_close($id, $id1);

                $data1 = $this->get_user_info_by_id($users->id);//Assigned to task

                $request_id = $id;
                $close_status = $last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby = Session::get('fid');
                  $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status);


                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{



                }



            }else {

             $comment = $input->comment;
                DB::table('horizontal_deployment')->insert(
                    array('request_id' => $id,
                        'status' => $input->radioStatus,
                        'comment' => $comment,
                        'reason'  => $input->reason

                    )
                );

                if (is_array($input->customer_id)) {


                    foreach ($input->customer_id as $value) {


                        DB::table('changerequests_customer')->insert(
                            array(
                                'customer_id' => $value,
                                'request_id' => $id

                            )
                        );

                    }
                }



                $users = DB::table('tb_users')
                    ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                    ->select('tb_users.id', 'tb_users.email')
                    ->where('changerequests.request_id', $id)//1 for super admin id
                    ->first();

                $email_send = $users->email;


                $message = "Pending decision on Cut-Off Date & before-after status.";

                $url = 'changes/before-after-status-option/';
                $last_id_req = $this->save_noticication_status($users->id, $id, $message, $url, 18);
                $this->change_request_status_close($id, $id1);

                $data1 = $this->get_user_info_by_id($users->id);//Assigned to task

                $request_id = $id;
                $close_status = $last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby = Session::get('fid');
                  $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo, 'Close_status' => $close_status);


                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{



                }


            }

            } else {

              // In 'No' section
              if(isset($input->Nocomment)){
               $comment = $input->Nocomment;
             }else{
              $comment='';
             }

                DB::table('horizontal_deployment')->insert(
                    array('request_id' => $id,
                        'status' => $input->radioStatus,
                        'comment' => $comment,
                        

                    )
                );




                $users = DB::table('tb_users')
                    ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                    ->select('tb_users.id', 'tb_users.email')
                    ->where('changerequests.request_id', $id)//1 for super admin id
                    ->first();

                $email_send = $users->email;


                $message = "Pending decision on Cut-Off Date & before-after status.";

                $url = 'changes/before-after-status-option/';
                $last_id_req=$this->save_noticication_status($users->id, $id, $message, $url, 18);
                $this->change_request_status_close($id, $id1);

                $data1 = $this->get_user_info_by_id($users->id);//Assigned to task

                $request_id=$id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



            if($this->check_netconnection())
            {

                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('You Have New Task');

                });

            }else{



            }

            }



    }

    public function before_after_status_option($id)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
       if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
       }else{   

        if ($this->check_request_permission($id)) {

            return View::make('changes/before-after-status-option');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }
      }


    }

    /*
     *
     *
     *
     *
     */


    public function checkCustDrivenChange(){
      $input = (object)Input::all();
     
      $data = DB::table('changerequests')
              ->select('stakeholder')
              ->where('request_id',$input->request_id)
              ->get();
              
              if($data[0]->stakeholder == 2 || $data[0]->stakeholder == 4 ||$data[0]->stakeholder == 6){

                return 1;
              }else{
                return 0;
              }
    }

    public function PTR_doc_upload($r_id,$id){
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$r_id)
              ->where('id',$id)
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('');
         }
      $input = (object)Input::all();
      $destinationPath = 'uploads/PTRDocument'; // upload path

        if (Input::hasFile('doc')) {
            $files = Input::file('doc');

            foreach ($files as $file) {
                $extension = $file->getClientOriginalName();

                $filename = rand(11111,99999).'-'.$extension; // renameing image
                $filename1= preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename);
                $upload_success = $file->move($destinationPath, $filename1);

                DB::table('tb_PTRDocument')->insert(
                array('request_id' => $r_id,
                'comment' => $input->comment,
                'file_name'=> $filename1,
               )
             );
            }
        }

         $users = DB::table('tb_users')
                ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                ->select('tb_users.id', 'tb_users.email')
                ->where('changerequests.request_id', $r_id)
                ->first();

                 /*tracking sheet*/
                 $Date=date('Y-m-d');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $r_id)
                  ->where('status', 16)
                  ->update(['actual_date' => $Date]);

              $data=DB::table('tracking_sheet_date_param')->where('id',12)->get();
                $Date=date('Y-m-d');
                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $r_id,
                          'process'     =>'Horizontal Deployment',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>13
                        )
                    );
                  /*-------------------*/
              
                
            $message = "Pending Decision of Horizontal Deployment applicability from Initiator.";
            $url = 'changes/horizontal-deployment/';

            $last_id_req=$this->save_noticication_status($users->id, $r_id, $message, $url, 17);
            $data1 = $this->get_user_info_by_id($users->id);
            $this->change_request_status_close($r_id, $id);
            $request_id=$r_id;
            $close_status=$last_id_req;

            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
             $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);
            if($this->check_netconnection())
            {
                Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {
                    $message->to($email_id)->subject('You Have New Task');
                });
            }else{

            }
            $involveusers=DB::table('request_progress_status')
                    ->select('assigned_to')
                    ->where('request_id',$r_id)
                    ->distinct('assigned_to')
                    ->get();
          $CM_dtls=DB::table('changerequests')
                    ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                    ->select('change_type_name','created_date','changerequests.status','change_stage')
                    ->where('request_id',$r_id)
                    ->get();

          $dataview2= $this->view_search_result($r_id) ;
             $summeries = $dataview2['userjobs'];
            $pdf=PDF::loadView('scm/email-steering',compact('summeries'));
               $pdf->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
               $datetime= new DateTime();
               $result = $datetime->format('Y-m-d-H-i-s');

               $pdffilename='ChangeRequestDetails'.$result;
                $pdffile = Config::get('app.site_root').'uploads/email/'.$pdffilename.'.pdf';
               $pdf->save($pdffile);   

                 
         $CMNo=$this->generate_cm_no($CM_dtls[0]->change_type_name, $CM_dtls[0]->created_date, $r_id, $CM_dtls[0]->status);
                  $filename2 = Config::get('app.site_root').'uploads/PTRDocument/'.$filename1;
                  // print_r($filename2);exit();
        foreach ($involveusers as $key => $value) {
           $usersdtls = DB::table('tb_users')
                      ->select((DB::raw('CONCAT(first_name," ",last_name) as full_name')),'email','id')
                      ->where('id',$value->assigned_to)
                      ->get();

                $assignedby=Session::get('fid');
                $message = "PTR document is uploaded by the ".$assignedby;
                $email_id=$usersdtls[0]->email;

             $data_1 = array('firstname'=>$usersdtls[0]->full_name,'description'=>$message,'CMNo'=>$CMNo);
             $loginuser=Session::get('uid');
             // print_r($usersdtls[0]->id);exit();
            if($loginuser!=$usersdtls[0]->id){
            if($this->check_netconnection())
            {
                Mail::send('emails/email-ptr', $data_1, function ($message) use ($email_id,$filename2,$pdffile) {

                    $message->to($email_id)->subject('PTR document uploaded');
                    $message->attach($filename2);
                    $message->attach($pdffile);   

                });
                
            }else{

            }
           
          }
            
        }
         
      return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
    }
    public function add_before_after_status_option($id, $id1)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }

       $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code','changeType')
            ->where('request_id',$id)
            ->get();

            $ext1 = DB::table('tb_dept_addRemove')
              ->select('file_upload_type')
              ->get();
        $input = (object)Input::all();
        if($checkParam[0]->change_stage == 1){
          $date=$input->actualdate;
        }else{
          $date=$input->startdate;
        }
       // echo '<pre>'; print_r($input);exit();

        if($checkParam[0]->change_stage == 2 && $checkParam[0]->proj_code != ""){
              $users = DB::table('tb_projectMaster')
                          ->select('finalApproval')
                          ->where('id',$checkParam[0]->proj_code)
                           ->get();

              
              if(empty($users)){
                
                     return Redirect::back()->with('message', SiteHelpers::alert('error', 'Final approval authority not defined in configuration master.Please contact administrator'));
              }
              }else if($checkParam[0]->change_stage == 2 && $checkParam[0]->proj_code == ""){

                 $users = DB::table('tb_finalApprovCloser')
                ->select('member')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();
                if(empty($users)){
                     return Redirect::back()->with('message', SiteHelpers::alert('error', 'Final approval authority not defined in configuration master.Please contact administrator'));
                }

                      
            }else{
              // print_r($checkParam);exit();
               $users = DB::table('tb_finalApprovCloser')
                ->select('membermultiple')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                ->where('change_type',$checkParam[0]->changeType)
                 ->get();

             
                      if(empty($users)){
                     return Redirect::back()->with('message', SiteHelpers::alert('error', 'Final approval authority not defined in configuration master.Please contact administrator'));
                    }

            }

            //----start code for tracking Sheet----
            $data=DB::table('tracking_sheet_date_param')->where('id',14)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Final Closure',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>15
                        )
                    );

              $Date=date('Y-m-d');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                 
                  ->where('status', 14)

                  ->update(['actual_date' => $Date]);

                 //----end code for tracking Sheet----
       
        $destinationPath = 'uploads/before_after_status_option_attachment'; // upload path
        
        if (Input::hasFile('doc')) {
            $files = Input::file('doc');

          //  print_r($files);exit;

            foreach ($files as $file) {


                $extension = $file->getClientOriginalName();

                $filename = rand(11111,99999).'-'.$extension; // renameing image

                $info = pathinfo($filename);

                $ext = $info['extension'];
                $a = array('tif','gif','png','jpg','jpeg','pdf');
                if($ext1[0]->file_upload_type == "Specific"){
               if (!in_array(strtolower($ext), $a)) {
                    return Redirect::back()->with('message', SiteHelpers::alert('error', 'Only image and file can be attached'));
                }
              }
                $upload_success = $file->move($destinationPath, $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename));

                $this->save_before_after_status_attachments($extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename),$date,$id);
            }
        }else{
            $filename='';
            $this->save_before_after_status_attachments($extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $filename),$date,$id);

        }
        //==================mail section ========================

       

        if($checkParam[0]->change_stage == 2 && $checkParam[0]->proj_code != ""){
              $users = DB::table('tb_projectMaster')
                          ->select('finalApproval')
                          ->where('id',$checkParam[0]->proj_code)
                           ->get();

              
                      if(!empty($users)){
                        $meber = DB::table('tb_users')
                           ->select('tb_users.id', 'tb_users.email')
                           ->where('id',$users[0]->finalApproval)
                          ->get();
                      }else{
                            
                             return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for horizontal deployment'));
                      }

                    $email = (String)$meber[0]->email;
                    $message = "Pending final closure of change management from Admin.";
                    $url = 'changes/change-management-closer/';
                    $last_id_req=$this->save_noticication_status($meber[0]->id, $id, $message, $url, 19);
                    $this->change_request_status_close($id, $id1);

                    $data1 = $this->get_user_info_by_id($meber[0]->id);//Assigned to task
                    $request_id=$id;
                    $close_status=$last_id_req;
                    $contactName = $data1['name'];
                    $email_id = $data1['email'];
                    $assignedby=Session::get('fid');
                  $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


              if($this->check_netconnection())
              {
                  Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                      $message->to($email_id)->subject('You Have New Task');

                  });
              }else{

              }
              
                
        }else if($checkParam[0]->change_stage == 2 && $checkParam[0]->proj_code == ""){

                 $users = DB::table('tb_finalApprovCloser')
                ->select('member')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();

             
                  if(!empty($users)){
                    $meber = DB::table('tb_users')
                       ->select('tb_users.id', 'tb_users.email')
                       ->where('id',$users[0]->member)
                      ->get();
                    }else{
                        
                         return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for final approval'));
                    }

                       $email = (String)$meber[0]->email;
                    $message = "Pending final closure of change management from Admin.";
                    $url = 'changes/change-management-closer/';
                    $last_id_req=$this->save_noticication_status($meber[0]->id, $id, $message, $url, 19);
                    $this->change_request_status_close($id, $id1);

                    $data1 = $this->get_user_info_by_id($meber[0]->id);//Assigned to task
                    $request_id=$id;
                    $close_status=$last_id_req;
                    $contactName = $data1['name'];
                    $email_id = $data1['email'];
                    $assignedby=Session::get('fid');

                     $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                    $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


                  if($this->check_netconnection())
                  {
                      Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                          $message->to($email_id)->subject('You Have New Task');

                      });

                  }else{

                  }
            }

          else{

              $users = DB::table('tb_finalApprovCloser')
                ->select('membermultiple')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                ->where('change_type',$checkParam[0]->changeType)
                 ->get();
             
                    if(empty($users)){
                      return Redirect::back()->with('message', SiteHelpers::alert('error', 'User not selected for final approval'));
                    }else{
                     $meberId=explode(',',$users[0]->membermultiple) ;
                     
                     foreach ($meberId as $value) {
                     // print_r($value);exit();
                    $meber = DB::table('tb_users')
                       ->select('tb_users.id', 'tb_users.email')
                       ->where('id',$value)
                      ->get();
                      // print_r($meber);exit();
                       $email = (String)$meber[0]->email;
                    $message = "Pending final closure of change management from Admin.";
                    $url = 'changes/change-management-closer/';
                    $last_id_req=$this->save_noticication_status($meber[0]->id, $id, $message, $url, 19);
                    $this->change_request_status_close($id, $id1);

                    $data1 = $this->get_user_info_by_id($meber[0]->id);//Assigned to task
                    $request_id=$id;
                    $close_status=$last_id_req;
                    $contactName = $data1['name'];
                    $email_id = $data1['email'];
                    $assignedby=Session::get('fid');
                     $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                    $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


                  if($this->check_netconnection())
                  {
                      Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                          $message->to($email_id)->subject('You Have New Task');

                      });

                  }else{

                  }

                  }
              }
          }
       
        return Redirect::to('');
    }


    function save_before_after_status_attachments($file_name, $startdate ,$id){

        if (isset($file_name)) {
            $filename = $file_name;
        } else {
            $filename = '';
        }
        if($file_name != ""){
        DB::table('befor_after_status_option_attachment')->insert(
            array('request_id' => $id,
                'post_date' => $startdate,
                'attachment_file'=> $filename,
            )
        );
      }else{
         DB::table('befor_after_status_option_attachment')
         ->where('request_id',$id)
         ->update(
            array('request_id' => $id,
                'post_date' => $startdate,
            )
        );
      }
        if (isset($startdate) && !empty($startdate)) {
            $currentTime = $startdate;
            $date1 = explode('/', $currentTime);
            $currentTime = $date1[2] . '-' . $date1[0] . '-' . $date1[1] . ' 00:00:00';
        } else {
            $currentTime = '';
        }

        

    }





    /**
     * @return mixed
     */
    public function change_management_closer($id){
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
     if($checkClose[0]->close ==2 || $checkClose[0]->close ==1){
          return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
     }else{   
        if($this->check_request_permission($id)){

            return View::make('changes/change-management-closer');
        }else{
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.' ));
        }
      }



    }
    /**
     * 20-closed
     * 21-open
     * 22-cancelled
     * @param closer
     * @param request_id
     * @param $id
     */

   public function close_cm_management($id,$id1){
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==2 || $checkClose[0]->close ==1){ 
            $c='c';
            return $c;exit();
         }
        $input = (object)Input::all();
     
        if($input->radioStatus==25){

           $change_stage = DB::table('changerequests')
            ->select('changerequests.change_stage','plant_code','stakeholder','proj_code')
            ->where('changerequests.request_id', $id)
            ->get();
            $holdId=DB::table('tb_holdchangerequests')
                   ->select('r_id')
                   ->where('r_id',$id)
                   ->where('userId',Session::get('uid')) 
                   ->get();
           // print_r($holdId);exit();
           if(empty($holdId)){
               DB::table('tb_holdchangerequests')->insert(
                  array('r_id' => $id,
                  'userId' => Session::get('uid'),
                  'change_stage' =>$change_stage[0]->change_stage,
                  'flag'=>1,
                )
              );
         }else{
              DB::table('tb_holdchangerequests')
                ->where('r_id', $id)
                ->where('userId',Session::get('uid'))
                ->update(
                  array('change_stage' => $change_stage[0]->change_stage,
                        'flag' => 1,
                  )
              );

         }
         echo '0';exit;

        }else if($input->radioStatus ==26){

          DB::table('tb_final_reject')->insert(
                array(
                    'comment' => $input->rejectcoment,
                    'request_id' => $id

                )
            );
           $users = DB::table('tb_users')
                    ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                    ->select('tb_users.id', 'tb_users.email')
                    ->where('changerequests.request_id', $id)//1 for super admin id
                    ->first();

                    DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 15)
                  ->delete();

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 14)
                  ->update(['actual_date' => 0]);



                $email_send = $users->email;

                  $message = "Pending decision on Implementation Date & before-after status(final approval member rejected).";
                

                $url = 'changes/before-after-status-option/';
                $last_id_req = $this->save_noticication_status($users->id, $id, $message, $url, 18);
                $this->change_request_status_close($id, $id1);

                $data1 = $this->get_user_info_by_id($users->id);//Assigned to task

                $request_id = $id;
               // $close_status = $last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby = Session::get('fid');

                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname' => $contactName, 'description' => $message, 'assigned_task_by' => $assignedby, 'url' => $url, 'request_id' => $cmNo,'comment'=>$input->rejectcoment);


                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates-reject', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{



                }
        }else{

          $holdId=DB::table('tb_holdchangerequests')
                  ->select('r_id')
                  ->where('r_id',$id)
                  ->where('userId',Session::get('uid')) 
                  ->get();
           // print_r($holdId);exit();
           if(!empty($holdId)){
              DB::table('tb_holdchangerequests')
                ->where('r_id', $id)
                ->where('userId',Session::get('uid'))
                ->update(
                  array('flag' => 0,
                  )
              );

         }


        if($input->radioStatus==20){
            $message = "Closed";
            if(isset($input->Nocomment)){
            $comment=$input->Nocomment;
          }else{
            $comment='';
          }

        }elseif($input->radioStatus==21){
            $message = "Open";
            $comment='';

        }else{

            $message = "Cancelled";
            $comment='';
        }
         $Date=date('Y-m-d');
        DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 15)
                  ->update(['actual_date' =>  $Date]);


  // ******** Mail to all members involved in change request *************
            $CM_dtls=DB::table('changerequests')
                    ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                    ->select('change_type_name','created_date','changerequests.status','change_stage')
                    ->where('request_id',$id)
                    ->get();
        if($CM_dtls[0]->change_stage==1){
             $count=DB::table('request_progress_status')
              ->select(DB::Raw('count(request_id) as cnt'))
              ->where('request_id',$id)
              ->where('status',19)
              ->where('close',0)
              ->get();

        if($count[0]->cnt==1){

           DB::table('request_progress_status')
            ->where('request_id', $id)
            ->where('id', $id1)

            ->update(
                array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'message' => $message,
                    'next_url'=>'',
                    'status'=>$input->radioStatus,
                    'close'=>2,
                    'comment'=>$comment,
                )
            );

            DB::table('request_progress_status')
            ->where('request_id', $id)
            ->where('status', 19)
            ->update(
                array(
                    'status'=>$input->radioStatus,
                    'close'=>2
                )
            );

          $involveusers=DB::table('request_progress_status')
                    ->select('assigned_to')
                    ->where('request_id',$id)
                    ->distinct('assigned_to')
                    ->get();
          
                 
         $CMNo=$this->generate_cm_no($CM_dtls[0]->change_type_name, $CM_dtls[0]->created_date, $id, $CM_dtls[0]->status);

        foreach ($involveusers as $key => $value) {
           $usersdtls = DB::table('tb_users')
                      ->select((DB::raw('CONCAT(first_name," ",last_name) as full_name')),'email','id')
                      ->where('id',$value->assigned_to)
                      ->get();

                $assignedby=Session::get('fid');
                $message = "Change request is successfully closed";
                $email_id=$usersdtls[0]->email;

             $data_1 = array('firstname'=>$usersdtls[0]->full_name,'description'=>$message,'CMNo'=>$CMNo);
             $loginuser=Session::get('uid');
             // print_r($usersdtls[0]->id);exit();
           
            if($this->check_netconnection())
            {
                Mail::send('emails/email-ptr', $data_1, function ($message) use ($email_id) {
                    $message->to($email_id)->subject('Change request closed');
                });
                
            }else{

            }
            
          }

        }else{

           DB::table('request_progress_status')
            ->where('request_id', $id)
            ->where('id', $id1)

            ->update(
                array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'message' => $message,
                    'next_url'=>'',
                    'status'=>19,
                    'close'=>1,
                    'comment'=>$comment,
                )
            );
        }
      }else{
        DB::table('request_progress_status')
            ->where('request_id', $id)
            ->where('id', $id1)

            ->update(
                array(
                    'created_date' => date('Y-m-d H:i:s'),
                    'message' => $message,
                    'next_url'=>'',
                    'status'=>$input->radioStatus,
                    'close'=>2,
                    'comment'=>$comment,
                )
            );
      }
      echo '1';exit;
    }
  }



    public function get_data_in_modal($id,$category_id,$list_id){



        $points  = DB::table('tb_risk_assessment_points')
            ->leftJoin('activity_monitering_document_attachment', 'tb_risk_assessment_points.risk_assessment_id', '=', 'activity_monitering_document_attachment.list_id')
            ->select('tb_risk_assessment_points.*','activity_monitering_document_attachment.*')
            ->where('tb_risk_assessment_points.risk_assessment_id', $list_id)
           // ->where('category', $category_id)

            ->first();


                $res = array('risk_assessment_id' => $points->risk_assessment_id,


                    'category' => $this->get_risk_assessment_point_category($category_id),

                    'attachments' => $this->get_all_atachments_activity_monitoring1($id, $category_id, $list_id),

                );

                return $res;


    }


    public function delete_data_in_modal($id,$name){

        DB::table('attachment_activity_monitoring')->where('attachment_id', $id)->delete();

        $filename = Config::get('app.site_root'). '/uploads/risk_assessment_documents/'.$name;

        if (File::exists($filename)) {
            File::delete($filename);
        }
    }

    function get_risk_assessment_point_category($id)
    {//print_r($id);exit;
         return $points = DB::table('risk_assessment_document_upload')
            ->select('risk_assessment_document_upload.*')
            ->where('risk_assessment_document_id', $id)
            ->first();
//print_r($points);exit;




    }


    function get_all_atachments_activity_monitoring1($request_id,$document_category_id,$list_id){//print_r($list_id);exit;

        $purpose=array();
        $attachments = DB::table('attachment_activity_monitoring')
            ->select('attachment_activity_monitoring.*')
            ->where('attachment_activity_monitoring.list_id',$list_id)
            ->where('attachment_activity_monitoring.category_id',$document_category_id)
            ->where('attachment_activity_monitoring.request_id',$request_id)
            ->get();


        foreach($attachments as $attachment){
            $purpose[]=array('attachment_id'=>$attachment->attachment_id,
                //'attachment_id'=>$attachment->activity_id,
                'attachment_file'=>$attachment->attachment_file,
            );

        }


        return $purpose;


    }

    public function submit_cat_attachments($id){

        $destinationPath = 'uploads/risk_assessment_documents';
        $input = (object)Input::all();


        if (Input::hasFile('multi_doc')) {
            $files = Input::file('multi_doc');

            foreach ($files as $file) {


                $extension = $file->getClientOriginalName();

                $filename = rand(11111,99999).'-'.$extension; // renameing image

                $upload_success = $file->move($destinationPath, $filename);

                $this->save_risk_attachments($input->list_id, $input->category_id, $filename, $id);
            }
        }
        return Redirect::back()->with('success', 'You have posted successfully');
    }
    function save_risk_attachments($list_id,$category_id,$file_name,$id){

        DB::table('attachment_activity_monitoring')->insert(
            array('request_id' => $id,
                'category_id' => $category_id,
                'attachment_file' => $file_name,
                'list_id'=>$list_id,
                'created' => date('Y-m-d H:i:s'),
                'status' => 1,

            )
        );
    }

    public function assign_task_to_next_step_frm_activity_monitoring($id,$id1){
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }
        $result=$this->count_applicability($id);

        // print_r($result);exit;
        if($result==1) {

          $docVerifier = DB::table('changerequests')
                         ->select('change_stage','plant_code','stakeholder','proj_code')
                         ->where('request_id',$id)
                         ->get();
  
            if($docVerifier[0]->change_stage == 2 && $docVerifier[0]->proj_code != ""){
              $data = DB::table('tb_projectMaster')
                      ->select('documentVerify')
                      ->where('id',$docVerifier[0]->proj_code)
                      ->get();
                  
                       $verifier = $data[0]->documentVerify;

                    
            }else{
              $data = DB::table('tb_documentVerifyConfig')
                      ->select('member')
                      ->where('change_stage',$docVerifier[0]->change_stage)
                      ->where('plant_code',$docVerifier[0]->plant_code)
                      ->where('stakeholder',$docVerifier[0]->stakeholder)
                      ->get();

                      if(empty($data)){
                      return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Document verififying authority not defined in configuration master.Please contact administrator.'))
                      ->withInput();
                      }

                      $verifier = $data[0]->member;

                     
            }



            $message = "Pending admin approval on activity completion status.";

            $url = 'changes/activity-monitoring-view/';
            $this->save_noticication_status_temp($verifier, $id, $message, $url, 16);
            $this->change_request_status_close($id, $id1);

            $data = DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_progress_status.request_id', $id)
                ->where('request_progress_status.close', 0)
                ->where('request_progress_status.status', 14)
                ->get();

            $data_check = DB::table('attachment_activity_monitoring')
                ->select(DB::raw('COUNT(attachment_id) as total'))
                ->where('attachment_activity_monitoring.request_id', $id)
                ->where('attachment_activity_monitoring.user_id', Session::get('uid'))
                ->where('attachment_activity_monitoring.dep_id', $dep_id=Session::get('dep_id'))
               // ->where('attachment_activity_monitoring.task_status',1)
                ->get();

            $user_id=Session::get('uid');
            $dep_id=Session::get('dep_id');



                   //----start code for tracking Sheet----

                
                $Date=date('Y-m-d');

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('process','Risk Activity Status Document Upload by '.$dep_id)
                  ->where('status', 10)

                  ->update(['actual_date' => $Date]);

                 //----end code for tracking Sheet----

            DB::table('attachment_activity_monitoring_summerysheet')
                ->where('request_id', $id)
                ->where('user_id', $user_id)
                ->where('dep_id',$dep_id)
                ->update(
                    array('task_status' => 2,
                        'modified_date' => date('Y-m-d H:i:s'),
                    )
                );

            if($data_check[0]->total==0){//echo "inside";exit;

                DB::table('attachment_activity_monitoring_summerysheet')
                    ->where('request_id', $id)
                    ->where('user_id', $user_id)
                    ->where('dep_id',$dep_id)
                    ->update(
                        array('task_status' => 2,
                              'modified_date' => date('Y-m-d H:i:s'),
                        )
                    );

                DB::table('attachment_activity_monitoring')->insert(
                    array('request_id' => $id,

                        'user_id'=>$user_id,
                        'dep_id'=>$dep_id,

                    )
                );
            }


            if ($data[0]->total == 0) {

              //----start code for tracking Sheet----
                $data=DB::table('tracking_sheet_date_param')->where('id',11)->get();
                $Date=date('Y-m-d');
                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Document Verification Status',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>12
                        )
                    );

                 
                 //----end code for tracking Sheet----

               $data2 = DB::table('request_progress_status_temp')
                    ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                    ->groupBy('request_progress_status_temp.assigned_to')
                    ->where('request_progress_status_temp.status', 16)
                    ->where('request_progress_status_temp.request_id', $id)
                    ->orderBy('request_progress_status_temp.created_date','desc')
                    ->first();

                      $data1[0]=$data2;

                $data_check = DB::table('attachment_activity_monitoring')
                    ->select(DB::raw('COUNT(attachment_id) as total'))
                    ->where('attachment_activity_monitoring.request_id', $id)
                    ->where('attachment_activity_monitoring.user_id', Session::get('uid'))
                    ->where('attachment_activity_monitoring.dep_id', $dep_id=Session::get('dep_id'))
                    ->get();

                if($data_check[0]->total==0){


                    $user_id=Session::get('uid');
                    $dep_id=Session::get('dep_id');

                    DB::table('attachment_activity_monitoring')->insert(
                        array('request_id' => $id,

                            'user_id'=>$user_id,
                            'dep_id'=>$dep_id,

                        )
                    );
                }

                foreach ($data1 as $risk) {

                    $last_id_req=$this->save_noticication_status($risk->assigned_to, $id, $message, $url, 16);

                    $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task

                    $request_id=$id;
                    $close_status=$last_id_req;


                    $contactName = $data1['name'];
                    $email_id = $data1['email'];
                    $assignedby=Session::get('fid');

                     $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);
                    $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



                    if($this->check_netconnection())
                    {

                        Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                            $message->to($email_id)->subject('You Have New Task');

                        });

                    }else{



                    }


                   
                }

               

                return Redirect::to('');

            }
            return Redirect::to('');
        }else {//echo "in back";exit;

            return Redirect::back()
                ->with('message', SiteHelpers::alert('error','File upload is mandatory for "YES" Applicability '))
                ->withInput();

           // return Redirect::back()->with('success', 'You have posted successfully');

        }


    /*
     *
     * old code working new code for client new client changes code above
     *
     */

     /*   $message = "Pending admin approval on activity completion status.";

        $url = 'changes/activity-monitoring-view/';
        $this->save_noticication_status(1, $id, $message, $url, 16);
        $this->change_request_status_close($id, $id1);

        $users = DB::table('tb_users')
            ->select('tb_users.id', 'tb_users.email')
            ->where('id', 1)//1 for super admin id
            ->first();


        $email_send = $users->email;

        Mail::send('emails/email-template', array('data' => (String)$email_send), function ($message) use ($email_send) {

            $message->to($email_send)->subject('Welcome!');

        });


        return Redirect::to('');

        */



        /*
         * Old code below for verify or need action on activity monitoring page
         *
         */


       /*

        $data= DB::table('activity_monitering_verification_status')
            ->select('activity_monitering_verification_status.verify_status')
            ->where('activity_monitering_verification_status.request_id',$id)
            ->orderBy('activity_monitering_verification_status.verify_id', 'DESC')
           ->first();




       if($data->verify_status==2) {

            $message = "Pending admin approval on activity completion status.";

            $url = 'changes/activity-monitoring-view/';
            $this->save_noticication_status(1, $id, $message, $url, 16);
            $this->change_request_status_close($id, $id1);

            $users = DB::table('tb_users')
                ->select('tb_users.id', 'tb_users.email')
                ->where('id', 1)//1 for super admin id
                ->first();


            $email_send = $users->email;

            Mail::send('emails/email-template', array('data' => (String)$email_send), function ($message) use ($email_send) {

                $message->to($email_send)->subject('Welcome!');

            });


            return Redirect::to('');

        }else{


            $users = DB::table('tb_users')
                ->leftJoin('changerequests', 'tb_users.id', '=', 'changerequests.initiator_id')
                ->select('tb_users.id', 'tb_users.email')
                ->where('changerequests.request_id', $id)
                ->first();

            $message = "Pending Decision of Horzontal Deployment applicability from Initiator.";

            $url = 'changes/horizontal-deployment/';
            $this->save_noticication_status($users->id, $id, $message, $url, 17);

            $this->change_request_status_close($id, $id1);


            $email_send = $users->email;

            Mail::send('emails/email-template', array('data' => (String)$email_send), function ($message) use ($email_send) {

                $message->to($email_send)->subject('Welcome!');

            });


            return Redirect::to('');

        }*/

    }
    public function activity_monitoring_view($id){

        if($this->check_request_permission($id)){

            return View::make('changes/view_details');
        }else{

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.' ));
        }



    }

    public function activity_monitoring_view_next($id){
        $message = "Pending admin approval on activity completion status.";

        $url='changes/activity-monitoring-view/';
        $this->save_noticication_status($id, $id, $message,$url);

        $users = DB::table('tb_users')

            ->select('tb_users.id','tb_users.email')
            ->where('id',1)//1 for super admin id
            ->first();


        $email_send=$users->email;



        if($this->check_netconnection())
        {

            Mail::send('emails/email-template', array('data'=>(String)$users[0]->email), function($message) use ($email_send)
            {

                $message->to($email_send)->subject('You Have New Task');

            });

        }else{



        }


        return Redirect::to('');
    }

    public  function check_all_form_data_for_next_step($id,$id1){


           $users = DB::table('tb_risk_assessment_points')

               ->select(DB::raw('COUNT(status_activity_monitoring) as total'))
               ->where('tb_risk_assessment_points.status_activity_monitoring', 2)
               ->where('tb_risk_assessment_points.risk_assessment_id', $id)
               ->where('tb_risk_assessment_points.request_id', $id1)


               ->get();

        return $users[0]->total;
    }

   public function fetch_implementation_date_for_change($request_id){


         $result = DB::table('add_update_initial_sheet')
            ->select('add_update_initial_sheet.currentTime')
             ->orderBy('add_update_initial_sheet.currentTime', 'DESC')
            ->where('add_update_initial_sheet.request_id', $request_id)
            ->first();


        print_r(Carbon::createFromFormat('Y-d-m H:i:s', $result->currentTime)->format('d/m/Y'));exit;
   }

   public function get_current_date(){


        $ldate = date('Y-m-d H:i:s');


        print_r(Carbon::createFromFormat('Y-m-d H:i:s', $ldate)->format('d/m/Y'));exit;
   }

    public function fetch_ad_data($id){

       $stage=DB::table('changerequests')
                      ->select('change_stage','stakeholder','plant_code')
                      ->where('request_id',$id) 
                      ->get();
              $result=array();        
            if($stage[0]->change_stage==1){
                $ini=DB::table('tb_documentverifyconfig')
                    ->select('riskmember')
                      ->where('change_stage',$stage[0]->change_stage)
                      ->where('plant_code',$stage[0]->plant_code)
                      ->where('stakeholder',$stage[0]->stakeholder)
                      ->get();
                if(!empty($ini)){      
                  $result=$this->get_user_info_by_id($ini[0]->riskmember);
                }    
              }else{   

                $data = DB::table('tb_dept_addRemove')
                ->select('RiskAssApprove')
                ->get();
                if($data[0]->RiskAssApprove == 'Superadmin'){
                  $result=$this->get_user_info_by_id(1);
                }else{
                  $ini = DB::table('changerequests')
                  ->select('initiator_id')
                  ->where('request_id',$id)
                  ->get();
                 $result=$this->get_user_info_by_id($ini[0]->initiator_id);
              }
          }

       return $result;

    }

    public function add_pending_approval_admin($id, $id1)
    {
        $input = (object)Input::all();

        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
         }
    
        if ($input->radioStatus == 2) {
           $j=0;
           foreach ($input->comment as $value1) {

                if ($value1 != '') {

                  $data = DB::table('tb_users')
                          ->select('id')
                          ->where('active',1)
                          ->where('id',$input->cid[$j])
                          ->get();

                  $data1 = DB::table('tb_users')
                  ->select('first_name','last_name')
                  ->where('id',$input->cid[$j])
                  ->get();
                  if(empty($data)){
                    return Redirect::back()
                    ->with('message', SiteHelpers::alert('error',$data1[0]->first_name.''.$data1[0]->last_name.' is inactive you can not reject task'))
                    ->withInput();
                  }
                }

                $j++;
            }
            $i = 0;
            foreach ($input->comment as $value1) {

                if ($value1 != '') {

                  $data = DB::table('tb_users')
                          ->select('id')
                          ->where('active',1)
                          ->where('id',$input->cid[$i])
                          ->get();

                          $data1 = DB::table('tb_users')
                          ->select('first_name','last_name')
                          ->where('id',$input->cid[$i])
                          ->get();
                          if(empty($data)){
                            return Redirect::back()
                      ->with('message', SiteHelpers::alert('error',$data1[0]->first_name.''.$data1[0]->last_name.' is inactive you can not reject task'))
                      ->withInput();
                          }

                    DB::table('approval_risk_assessment_from_admin')->insert(
                        array('request_id' => $id,
                            'approve_status' => $input->radioStatus,
                            'reject_reason'=>$value1,
                            'user_id' => $input->cid[$i]

                        )
                    );



                    //------trackingSheet reject by superadmin------

                    $dept_id = DB::table('tb_users')->select('department')->where('id',$input->cid[$i])->get();


               DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 3)
                  ->where('process','RiskAssessment By '.$dept_id[0]->department)
                  ->update(['actual_date' => 0]);

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 4)
                  ->where('process','Risk Assessment Approval by '.$dept_id[0]->department.' HOD')
                  ->delete();

                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 5)
                  ->delete();

               //------------end------------ 

                    DB::table('add_updated_risk_assessment_sheet')
                        ->where('add_updated_risk_assessment_sheet.user_id',$input->cid[$i])
                        ->where('add_updated_risk_assessment_sheet.r_id',$id)
                        ->update(array(
                                'user_dep'=>0,
                                'user_dep_hod_approve'=>0,
                                'status' => 1,
                              //  'modified'=>date('Y-m-d H:i:s'),

                            )
                        );


                    $users = DB::table('approval_risk_assessment_from_admin')
                        ->select('approval_risk_assessment_from_admin.user_id','approval_risk_assessment_from_admin.reject_reason')
                        ->where('approval_risk_assessment_from_admin.request_id', $id)
                        ->where('approval_risk_assessment_from_admin.user_id', $input->cid[$i])
                        ->groupBy('approval_risk_assessment_from_admin.user_id')
                        ->get();


                    foreach ($users as $value) {

                        $user_id = (String)$value->user_id;

                        $message = "Rejected by admin. Pending clearance of Risk Assessment point activities from CFT Dept.";

                        $url = 'changes/update-risk-analysis-sheet/';

                        $last_id_req=$this->save_noticication_status_for_reject($user_id, $id, $message, $url, 99,$value1);
                        $admin = $this->get_user_info_by_id(1);
                        $data1 = $this->get_user_info_by_id($user_id);//Assigned to task
                        $comment=$value1;

                        $request_id=$id;
                        $close_status=$last_id_req;

                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby=Session::get('fid');
                        $admin_email=$admin['email'];
                           $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status,'comment'=>$comment);



                        if($this->check_netconnection())
                        {

                            Mail::send('emails/email-ProjMgrRejection', $data_1, function ($message) use ($email_id,$admin_email) {


                                $message->to($email_id);
                                $message->bcc($admin_email)
                                    ->subject('You Have New Task');

                            });

                        }else{

                        }
                        $this->change_request_status_close($id, $id1);
                    }
                }

                $i++;
            }


            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));

        } else if($input->radioStatus == 1){
            /*
            
                    Following function is for accept approval on risk assessment form

            */
             
              $dataview2= $this->view_search_result($input->request_id) ;
            //  echo '<pre>';print_r($dataview2);exit();
           
             $summeries = $dataview2['userjobs'];
            
            $pdf=PDF::loadView('scm/email-steering',compact('summeries'));
               $pdf->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
               $datetime= new DateTime();
               $result = $datetime->format('Y-m-d-H-i-s');

               $filename='ChangeRequestDetails'.$result;
                $filename2 = Config::get('app.site_root').'uploads/email/'.$filename.'.pdf';
               $pdf->save($filename2);

             
          $changeReqData = DB::table('changerequests')
         ->select('plant_code','stakeholder','change_stage','proj_code','changeType','created_date')
         ->where('request_id',$input->request_id)
         ->get();
       
          
          /*code for development without project */

         if($changeReqData[0]->change_stage == 2 && $changeReqData[0]->proj_code == ""){

          
          $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
              ->select('steeringComm_id')
              ->where('plant_id',$changeReqData[0]->plant_code)
              ->where('stakeholder',$changeReqData[0]->stakeholder)
              ->where('change_stage',$changeReqData[0]->change_stage)
              ->get();
              $data1 = [];
               if(empty($steerCommMem)){
                 return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Atleast one member should be there'))
                      ->withInput();
               }



               $steerCommMemId = explode(',', $steerCommMem[0]->steeringComm_id);

               
               $count1 = count($steerCommMemId);
              if(!empty($steerCommMem)){
                for($i=0;$i<$count1;$i++) {
               
               

                        $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$steerCommMemId[$i])
                    ->get();

                     if(empty($data)){   


                        return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }
                }
               }

               
             
             
              if($input->custComm == 1){

              
                 if(isset($input->custComAvl)){
                    $data = DB::table('tb_users')
                        ->select('id')
                        ->where('active',1)
                        ->where('id',$input->custComAvl)
                        ->get();
                       
                  
                  }else{

                     return Redirect::back()
                          ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                          ->withInput();
                  }
                     if((empty($data))){   
                        return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }

                 //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',8)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'Customer Evidance Upload',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>8
                        )
                    );
               DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 5)
                  ->update(['actual_date' => $Date]);
                   
                 
                 //----end code for tracking Sheet----

              $custComm = DB::table('tb_dynamicCustComm')
                            ->select('CC_member')
                            ->where('CC_changeStage',$changeReqData[0]->change_stage)
                            ->where('CC_plantCode',$changeReqData[0]->plant_code)
                            ->where('CC_stakeholder',$changeReqData[0]->stakeholder)
                            ->get();

                  if(empty($custComm)){
                     return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','select customer communication member'))
                      ->withInput();
                  }      

                   $cComUsr = DB::table('tb_users')
                                      ->select('id','department','sub_department')
                                      ->where('id',$custComm[0]->CC_member)
                                      ->get();    

                   $cust = DB::table('changerequests_customer')
                          ->select('customer_id')
                          ->where('request_id',$input->request_id)
                          ->get();
                       foreach ($cust as $row) {
                                                 
                          DB::table('Customer_Communication_list')->insert(
                              array('request_id' => $input->request_id,
                                  'decision' => 1,
                                  'description' => $row->customer_id,
                                  // 'user_id' => $input->user_id,
                                  // 'created_date' => date('Y-m-d H:i:s'),
                              )
                          );
                        }
              


                    DB::table('Customer_Communication_Decision')->insert(
                        array('request_id' => $input->request_id,
                            'dep_id' => $cComUsr[0]->department,
                            'sub_dep_id' => $cComUsr[0]->sub_department,
                            'user_id' => $cComUsr[0]->id,
                            'created_date' => date('Y-m-d H:i:s'),
                            )
                        );



                      $message="Pending Customer Approval from responsible person.";

                      $url = 'changes/customer-communication-decision-attachments/';
                      $this->save_noticication_status_temp($custComm[0]->CC_member, $id, $message, $url, 12);
                      $this->change_request_status_close($id, $id1);
                       $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status',12)
                        ->where('request_progress_status_temp.request_id',$input->request_id)
                        ->get();

                    foreach($data1 as $risk) {

                        $last_id_req=$this->save_noticication_status($risk->assigned_to, $risk->request_id, $message, $url, 12);

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task

                        $request_id=$risk->request_id;
                        $close_status=$last_id_req;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby=Session::get('fid');

                $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                  $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


                        if($this->check_netconnection())
                        {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        }else{

                        }
                    }
                }else{
                  $checkuser=DB::table('tb_updatesheet_dep_team')
            ->select('team_member')
            ->where('request_id',$input->request_id)
            ->get();

           foreach ($checkuser as $key) {
            $inactiveuser=DB::table('tb_users')
            ->select('first_name','last_name')
            ->where('active',0)
            ->where('id',$key->team_member)
            ->get();
            if(!empty($inactiveuser)){

                return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','CFT member'.$inactiveuser[0]->first_name.' '.$inactiveuser[0]->last_name.' is inactive.Please contact administrator.'))
                      ->withInput();
              
              
            }
           }
            
                                
                  $cust = DB::table('changerequests_customer')
                                ->select('customer_id')
                                ->where('request_id',$input->request_id)
                                ->get();
                   foreach ($cust as $row) {
                                             
                      DB::table('Customer_Communication_list')->insert(
                          array('request_id' => $input->request_id,
                              'decision' => 0,
                              'description' => $row->customer_id,
                              // 'user_id' => $input->user_id,
                              // 'created_date' => date('Y-m-d H:i:s'),
                          )
                      );
                    }
                    DB::table('customer_Communication_Decision_wno')->insert(
                      array('request_id' => $input->request_id,
                          'assign_by_id' => Session::get('uid'),
                          'decision' => 0,

                      )
                  );

                 DB::table('tb_updatesheet_dep_team')
                ->where('request_id', $input->request_id)
                ->update(['resp_emp_status' => 3]);


                DB::table('tb_updatesheet_dep_team')
                    ->where('request_id', $id)
                    ->update(['resp_emp_status' => 3]);//3 for task assign to responsibles employees

                $data  = DB::table('tb_updatesheet_dep_team')
                    ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
                    ->select('tb_users.email','tb_users.id','tb_users.department')
                    ->where('tb_updatesheet_dep_team.request_id','=',$id)
                    ->get();

                  $message = "Pending from Responsible person to monitor activity completion status.";

                  $url = 'changes/activity-monitoring/';

                  foreach ($data as $value) {

                      $email_id = (String)$value->email;
                      $user_id = (String)$value->id;
                      $department = (String)$value->department;


                       $target_date1 = DB::table('tb_risk_assessment_points')
                  ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
                  ->groupBy('tb_risk_assessment_points.risk_dep')
                  ->where('tb_risk_assessment_points.request_id', $id)
                  ->where('tb_risk_assessment_points.responsibility', $user_id)
                  ->first();

                  if($target_date1->t_date=="0000-00-00"){

                   $target_date='';


                  }else{

                    $target_date=$target_date1->t_date;
                  }

                   //----start code for tracking Sheet----
                    $Date=date('Y-m-d');
                          DB::table('tracking_sheet_info')->insert(
                              array(
                                  'request_id' => $id,
                                  'process'     =>'Risk Activity Status Document Upload by '.$department,
                                  'target_date' =>$target_date,
                                  'actual_date'  =>0,
                                  'status'      =>10
                                )
                            );
                        
                          DB::table('tracking_sheet_info')
                          ->where('request_id', $id)
                          ->where('status', 5)

                          ->update(['actual_date' => $Date]);
                 //----end code for tracking Sheet----
                $last_id_req=$this->save_noticication_status($user_id, $id, $message, $url, 14);

                $this->save_task_status($user_id,$department,$id);

                $data1 = $this->get_user_info_by_id($user_id);//Assigned to task


                $request_id=$id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);



                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{

                }

                $this->change_request_status_close($id, $id1);
            }  
          }

          $id_user = DB::table('request_progress_status')

                    ->select('request_progress_status.assigned_by')
                    ->where('request_progress_status.id', $id1)
                    ->first();

                DB::table('approval_risk_assessment_from_admin')->insert(
                    array('request_id' => $id,
                        'approve_status' => 0,
                        'reject_reason'=>'',
                        'user_id' => $id_user->assigned_by,
                        'apprve_comment' => $input->reason

                    )
                );
                $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
              ->select('steeringComm_id')
              ->where('plant_id',$changeReqData[0]->plant_code)
              ->where('stakeholder',$changeReqData[0]->stakeholder)
              ->where('change_stage',$changeReqData[0]->change_stage)
              ->get();
              $data1 = [];
               if(empty($steerCommMem)){
                 return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Atleast one member should be there'))
                      ->withInput();
               }
               $steerCommMemId = explode(',', $steerCommMem[0]->steeringComm_id);
               $count1 = count($steerCommMemId);
              if(!empty($steerCommMem)){
                for($i=0;$i<$count1;$i++) {
               
               $data1[] = DB::table('tb_users')
                      ->leftJoin('subdepartments', 'tb_users.sub_department', '=', 'subdepartments.sub_dep_id')
                      ->select('tb_users.email', 'tb_users.id','subdepartments.sub_dep_id','tb_users.first_name','tb_users.last_name')
                      ->where('tb_users.id', $steerCommMemId[$i])
                      ->get();

                }
               }

               $allMem = $data1;
                foreach ($allMem as $row) {
                 
                    $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$changeReqData[0]->changeType)
                    ->get();

                    $assignedby=Session::get('fid');

                    $toname=$row[0]->first_name.' '.$row[0]->last_name;
                    $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$changeReqData[0]->created_date,$id);

                    $demo= $cmNo;
                    $email_id = $row[0]->email;

                $data_1 = array('user' => $demo,'to'=>$toname,'assignedby' =>$assignedby);

                  if ($this->check_netconnection()) {

                   
                    Mail::send('emails/email-steering', $data_1,  function ($message) use ($email_id,$filename2) {

                        $message->to($email_id)->subject('Change Request Information');
                         $message->attach($filename2);
                    });
                  } else {

                  }
                }
            if (File::exists($filename2)) {
                    File::delete($filename2);
                }

          }else if($changeReqData[0]->change_stage == 2 && $changeReqData[0]->proj_code != ""){
             /* code for developmet with project */
              $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
              ->select('steeringComm_id')
              ->where('plant_id',$changeReqData[0]->plant_code)
              ->where('stakeholder',$changeReqData[0]->stakeholder)
              ->where('change_stage',$changeReqData[0]->change_stage)
              ->get();
              $data1 = [];
               if(empty($steerCommMem)){
                 return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Atleast one member should be there'))
                      ->withInput();
               }
               $steerCommMemId = explode(',', $steerCommMem[0]->steeringComm_id);
               $count1 = count($steerCommMemId);
              if(!empty($steerCommMem)){
                for($i=0;$i<$count1;$i++) {
               
                        $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$steerCommMemId[$i])
                    ->get();

                     if(empty($data)){   

                        return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }
                }
               }
              
              if($input->custComm == 1){
                if(isset($input->custComAvl)){

                $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$input->custComAvl)
                    ->get();
                  }else{
                    return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }

                     if((empty($data))){   


                        return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }


                 //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',8)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'Customer Evidance Upload',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>8
                        )
                    );
               DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 5)
                  ->update(['actual_date' => $Date]);
                   
                 
                 //----end code for tracking Sheet----
                  $cust = DB::table('changerequests_customer')
                          ->select('customer_id')
                          ->where('request_id',$input->request_id)
                          ->get();
             foreach ($cust as $row) {
                                       
                DB::table('Customer_Communication_list')->insert(
                    array('request_id' => $input->request_id,
                        'decision' => 1,
                        'description' => $row->customer_id,
                        // 'user_id' => $input->user_id,
                        // 'created_date' => date('Y-m-d H:i:s'),
                    )
                );
              }
                $custComm = DB::table('tb_projectMaster')
                            ->select('cust_comm_repres')
                            ->where('id',$changeReqData[0]->proj_code)
                            ->get();
                            $cComUsr = DB::table('tb_users')
                                      ->select('id','department','sub_department')
                                      ->where('id',$custComm[0]->cust_comm_repres)
                                      ->get();


                            DB::table('Customer_Communication_Decision')->insert(
                        array('request_id' => $input->request_id,
                            'dep_id' => $cComUsr[0]->department,
                            'sub_dep_id' => $cComUsr[0]->sub_department,
                            'user_id' => $cComUsr[0]->id,
                            'created_date' => date('Y-m-d H:i:s'),
                        )
                      );


                      $message="Pending Customer Approval from responsible person.";

                     $url = 'changes/customer-communication-decision-attachments/';
                      $this->save_noticication_status_temp($custComm[0]->cust_comm_repres, $id, $message, $url, 12);
                      $this->change_request_status_close($id, $id1);
                       $data1 = DB::table('request_progress_status_temp')
                        ->select('request_progress_status_temp.assigned_to', 'request_progress_status_temp.request_id', 'request_progress_status_temp.next_url', 'request_progress_status_temp.message', 'request_progress_status_temp.created_date')
                        ->groupBy('request_progress_status_temp.assigned_to')
                        ->where('request_progress_status_temp.status',12)
                        ->where('request_progress_status_temp.request_id',$input->request_id)
                        ->get();

                    foreach($data1 as $risk) {

                        $last_id_req=$this->save_noticication_status($risk->assigned_to, $risk->request_id, $message, $url, 12);

                        $data1 = $this->get_user_info_by_id($risk->assigned_to);//Assigned to task

                        $request_id=$risk->request_id;
                        $close_status=$last_id_req;


                        $contactName = $data1['name'];
                        $email_id = $data1['email'];
                        $assignedby=Session::get('fid');
                         $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                        $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


                        if($this->check_netconnection())
                        {
                            Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                                $message->to($email_id)->subject('You Have New Task');

                            });

                        }else{

                        }
                    }
                }else{

                   $checkuser=DB::table('tb_updatesheet_dep_team')
            ->select('team_member')
            ->where('request_id',$input->request_id)
            ->get();

           foreach ($checkuser as $key) {
            $inactiveuser=DB::table('tb_users')
            ->select('first_name','last_name')
            ->where('active',0)
            ->where('id',$key->team_member)
            ->get();
            if(!empty($inactiveuser)){

                return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','CFT member'.$inactiveuser[0]->first_name.' '.$inactiveuser[0]->last_name.' is inactive.Please contact administrator.'))
                      ->withInput();
              
              
            }
           }
           DB::table('customer_Communication_Decision_wno')->insert(
              array('request_id' => $id,
                  'assign_by_id' => Session::get('uid'),
                  'decision' =>0,

                )
              );

             DB::table('tb_updatesheet_dep_team')
                ->where('request_id', $input->request_id)
                ->update(['resp_emp_status' => 3]);


            $cust = DB::table('changerequests_customer')
                          ->select('customer_id')
                          ->where('request_id',$input->request_id)
                          ->get();
             foreach ($cust as $row) {
                                       
                DB::table('Customer_Communication_list')->insert(
                    array('request_id' => $input->request_id,
                        'decision' => 0,
                        'description' => $row->customer_id,
                        // 'user_id' => $input->user_id,
                        // 'created_date' => date('Y-m-d H:i:s'),
                    )
                );
              }

            $data  = DB::table('tb_updatesheet_dep_team')
                ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
                ->select('tb_users.email','tb_users.id','tb_users.department')
                ->where('tb_updatesheet_dep_team.request_id','=',$id)
                ->get();
                // print_r($data);exit();
            $message = "Pending from Responsible person to monitor activity completion status.";

            $url = 'changes/activity-monitoring/';

            foreach ($data as $value) {

                $email_id = (String)$value->email;
                $user_id = (String)$value->id;
                $department = (String)$value->department;


                 $target_date1 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->where('tb_risk_assessment_points.request_id', $id)
            ->where('tb_risk_assessment_points.responsibility', $user_id)
            ->first();

            // print_r($target_date1);

                  if($target_date1->t_date=="0000-00-00"){

                   $target_date='';


                  }else{

                    $target_date=$target_date1->t_date;
                  }

                   //----start code for tracking Sheet----

                $Date=date('Y-m-d');
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'Risk Activity Status Document Upload by '.$department,
                          'target_date' =>$target_date,
                          'actual_date'  =>0,
                          'status'      =>10
                        )
                    );
                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 5)

                  ->update(['actual_date' => $Date]);

               
                 //----end code for tracking Sheet----

                $last_id_req=$this->save_noticication_status($user_id, $id, $message, $url, 14);

                $this->save_task_status($user_id,$department,$id);

                $data1 = $this->get_user_info_by_id($user_id);//Assigned to task

                $request_id=$id;
                $close_status=$last_id_req;

                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);

                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');

                    });

                }else{

                }

                $this->change_request_status_close($id, $id1);
            }  

            }

            $id_user = DB::table('request_progress_status')

                    ->select('request_progress_status.assigned_by')
                    ->where('request_progress_status.id', $id1)
                    ->first();

                DB::table('approval_risk_assessment_from_admin')->insert(
                    array('request_id' => $id,
                        'approve_status' =>0,
                        'reject_reason'=>'',
                        'user_id' => $id_user->assigned_by,
                        'apprve_comment' => $input->reason

                    )
                );


                $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
              ->select('steeringComm_id')
              ->where('plant_id',$changeReqData[0]->plant_code)
              ->where('stakeholder',$changeReqData[0]->stakeholder)
              ->where('change_stage',$changeReqData[0]->change_stage)
              ->get();
              $data1 = [];
               if(empty($steerCommMem)){
                 return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Atleast one member should be there'))
                      ->withInput();
               }



               $steerCommMemId = explode(',', $steerCommMem[0]->steeringComm_id);

               
               $count1 = count($steerCommMemId);
              if(!empty($steerCommMem)){
                for($i=0;$i<$count1;$i++) {
               
               $data1[] = DB::table('tb_users')
                      ->leftJoin('subdepartments', 'tb_users.sub_department', '=', 'subdepartments.sub_dep_id')
                      ->select('tb_users.email', 'tb_users.id','subdepartments.sub_dep_id','tb_users.first_name','tb_users.last_name')
                      ->where('tb_users.id', $steerCommMemId[$i])
                      ->get();

                      
                }
               }

               $allMem = $data1;
                foreach ($allMem as $row) {
                 
                    $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$changeReqData[0]->changeType)
                    ->get();

                    $assignedby=Session::get('fid');

                    $toname=$row[0]->first_name.' '.$row[0]->last_name;
                    $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$changeReqData[0]->created_date,$id);

                    $demo= $cmNo;
                    $email_id = $row[0]->email;

                $data_1 = array('user' => $demo,'to'=>$toname,'assignedby' =>$assignedby);

                  if ($this->check_netconnection()) {

                   
                    Mail::send('emails/email-steering', $data_1,  function ($message) use ($email_id,$filename2) {

                        $message->to($email_id)->subject('Change Request Information');
                         $message->attach($filename2);                       
                        

                    });
                  } else {

                  }
                }
            if (File::exists($filename2)) {
                    File::delete($filename2);
                }

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
              
          }else{
            /* code for change stage Series*/
            
            if($input->cooapp==2){

              //************ coo approval 'NO' **********************
           
            $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
             ->select('steeringComm_id')
             ->where('plant_id',$changeReqData[0]->plant_code)
             ->where('stakeholder',$changeReqData[0]->stakeholder)
             ->where('change_stage',$changeReqData[0]->change_stage)
             ->where('change_type',$changeReqData[0]->changeType)
             ->get();
            $data1 = [];
               if(empty($steerCommMem)){
                 return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Atleast one member of steering committee should be there'))
                      ->withInput();
               }
             $steerCommMemId = explode(',', $steerCommMem[0]->steeringComm_id);

               
               $count1 = count($steerCommMemId);
             
            if(!empty($steerCommMem)){
                for($i=0;$i<$count1;$i++) {
             
             $data1[] = DB::table('tb_users')
                    ->leftJoin('subdepartments', 'tb_users.sub_department', '=', 'subdepartments.sub_dep_id')
                    ->select('tb_users.email', 'tb_users.id','subdepartments.sub_dep_id')
                    ->where('tb_users.id', $steerCommMemId[$i])
                    ->get();

                    $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$steerCommMemId[$i])
                    ->get();

                     if(empty($data)){   


                        return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }
              }
            }
       
              $allMem = $data1;
             
             $checkcoo=DB::table('coo_approval_decision_status')
                         ->select('request_id')
                         ->where('request_id',$id) 
                         ->get();
                if(empty($checkcoo)) {        
                    $coodecision=DB::table('coo_approval_decision_status')->insert(
                        array('request_id' => $id,
                              'user_id' => session::get('uid'),
                              'decision'=>$input->cooapp
                        )
                    );
                }else{
                  $coodecision=DB::table('coo_approval_decision_status')
                              ->where('request_id', $id)
                              ->update(
                                array('user_id' => session::get('uid'),
                                      'decision'=>$input->cooapp
                                )
                            );
                }

                
                $superAdminCnt=DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_id',$input->request_id)
                ->where('status',88)
                ->get();

                foreach ($allMem as $value) {

               //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',6)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'steering commitee approval by '.$value[0]->id,
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>6
                        )
                    );
               
                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 5)
                  ->update(['actual_date' => $Date]);

                 
                 //----end code for tracking Sheet----

                $email_send = (String)$value[0]->email;
                $sub_dep=(String)$value[0]->sub_dep_id;

                $message="Pending Steering Committee approval on Risk Assessment points based on cost.";

                $url = 'changes/approve-allrisk-assesment/';

                $last_id_req= $this->save_noticication_status_for_steering_sub_dep((String)$value[0]->id, $input->request_id, $message, $url, 88,$sub_dep);
                $this->change_request_status_close($id, $id1);

                $id_user = DB::table('request_progress_status')

                    ->select('request_progress_status.assigned_by')
                    ->where('request_progress_status.id', $id1)
                    ->first();

                DB::table('approval_risk_assessment_from_admin')->insert(
                    array('request_id' => $id,
                        'approve_status' => $input->radioStatus,
                        'reject_reason'=>'',
                        'user_id' => $id_user->assigned_by,
                        'apprve_comment' => $input->reason

                    )
                );

                $data1 = $this->get_user_info_by_id((String)$value[0]->id);//Assigned to task


                $request_id=$id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');

                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');
                    });

                }else{

                }

            }
           
          // }
           return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
         }else{

           //************ coo approval 'Yes' **********************
          
          $COOMem = DB::table('tb_cooapprovalauthority') 
             ->select('userId')
             ->where('plant_code',$changeReqData[0]->plant_code)
             ->where('stakeholder',$changeReqData[0]->stakeholder)
             ->where('change_stage',$changeReqData[0]->change_stage)
             ->where('change_type',$changeReqData[0]->changeType)
             ->get();
           // print_r($COOMem);exit();

               if(empty($COOMem)){
                 return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','COO approval authority is not defined'))
                      ->withInput();
               }
            
            if(!empty($COOMem)){
               
             $data1 = DB::table('tb_users')
                    ->select('tb_users.email', 'tb_users.id')
                    ->where('tb_users.id', $COOMem[0]->userId)
                    ->get();

                    $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$COOMem[0]->userId)
                    ->get();

                     if(empty($data)){ 

                        return Redirect::back()
                      ->with('message', SiteHelpers::alert('error','Approval authority not defined or inactive'))
                      ->withInput();
                  }
            }
            
              $checkcoo=DB::table('coo_approval_decision_status')
                         ->select('request_id')
                         ->where('request_id',$id) 
                         ->get();


                    //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',10)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $input->request_id,
                          'process'     =>'COO Approval',
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>11
                        )
                    );
               DB::table('tracking_sheet_info')
                  ->where('request_id', $input->request_id)
                  ->where('status', 5)
                  ->update(['actual_date' => $Date]);
                   
                 
                 //----end code for tracking Sheet----     
                if(empty($checkcoo)) {  
                $coodecision=DB::table('coo_approval_decision_status')->insert(
                    array('request_id' => $id,
                          'user_id' => session::get('uid'),
                          'decision'=>$input->cooapp
                    )
                );
              }else{
                $coodecision=DB::table('coo_approval_decision_status')
                            ->where('request_id',$id)
                            ->update(
                              array(
                                  'user_id' => session::get('uid'),
                                  'decision'=>$input->cooapp
                            )
                        );
              }

                $email_send = $data1[0]->email;
               
                $message="Pending COO approval on Risk Assessment points based on cost.";

                $url = 'changes/approve-allrisk-assesment_coo/';

                $last_id_req= $this->save_noticication_status_for_steering_sub_dep($data1[0]->id, $input->request_id, $message, $url, 21,0);
                $this->change_request_status_close($id, $id1);

                $data1 = $this->get_user_info_by_id($data1[0]->id);//Assigned to task
                // print_r($data1);exit();

                $request_id=$id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'request_id'=>$cmNo);


                if ($this->check_netconnection()) {

                   
                    Mail::send('emails/email-templates', $data_1,  function ($message) use ($email_id,$filename2) {

                        $message->to($email_id)->subject('You have new task');
                         $message->attach($filename2);                       
                        

                    });
                  } else {

                  }
            if (File::exists($filename2)) {
                    File::delete($filename2);
                }
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            
         }  //************ coo approval 'Yes' **********************

       }
       return Redirect::to('');

        } else{

          //************ Permanant reject and close **********************

            DB::table('permanent_reject_close')->insert(
                array(
                    'request_id' => $id,
                    'rejected_by_id' => Session::get('uid'),
                    'rejected_by_name' => Session::get('fid'),
                    'remark' => $input->reject_reason,
                    'reject_date' => date('Y-m-d H:i:s'),
                    'created_date'=> date('Y-m-d')

                )
            );

             $checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$id)
            ->get();

            if($checkParam[0]->change_stage == 1){
               $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code)
                 ->get();
               }


            $first = DB::table('add_updated_risk_assessment_sheet')
                ->select('add_updated_risk_assessment_sheet.user_id')
                ->where('add_updated_risk_assessment_sheet.r_id', $id);

                // print_r($first);exit();
            $users = DB::table('add_updated_risk_assessment_sheet')
                ->select('add_updated_risk_assessment_sheet.hod')
                ->where('add_updated_risk_assessment_sheet.r_id', $id);


            $users1 = DB::table('changerequests')
                ->select('changerequests.initiator_id')
                ->where('changerequests.request_id', $id);

            if(isset($representative_id) && !empty($representative_id)){

              $representative_id = DB::table('tb_dynamiccftteamrepresentative')
                ->select('representative_id')
                ->where('change_stage',$checkParam[0]->change_stage)
                ->where('stakeholder',$checkParam[0]->stakeholder)
                ->where('plant_code',$checkParam[0]->plant_code);

              $results = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id', $id)
                ->union($first)
                ->union($users)
                ->union($users1)
                ->union($representative_id)
                ->get();
            }else{

            $results = DB::table('changerequests') ->select('changerequests.Approval_Authority')->where('changerequests.request_id', $id)
                ->union($first)
                ->union($users)
                ->union($users1)
                ->get();
            }
              // print_r( $results);exit();

            $initiatorId=DB::table('changerequests')
                ->select('changerequests.changeType','changerequests.created_date')
                ->where('changerequests.request_id', $id)
                ->get();


            $query1=DB::table('tbl_change_type')
                ->select('tbl_change_type.change_type_name')
                ->where('tbl_change_type.change_type_id',$initiatorId[0]->changeType)
                ->get();


            $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$initiatorId[0]->created_date,$id);


            $assignById=DB::table('tb_users')
                ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                ->where('tb_users.id', Session::get('uid'))
                ->groupBy('tb_users.id')
                ->get();

            $assignByName= $assignById[0]->first_name." ".$assignById[0]->last_name;

            $this->change_request_status_reject_and_close($id, $id1, $assignByName);

          foreach($results as $row){

               $allUser=DB::table('tb_users')
                   ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                   ->where('tb_users.id', $row->Approval_Authority)
                   ->groupBy('tb_users.id')
                   ->get();

              $message = "Change Request ".$cmNo." is  Rejected and Closed by ".$assignByName.".";
                $comment=$input->reject_reason;
             $contactName = $allUser[0]->first_name." ".$allUser[0]->last_name;
             $email_id = $allUser[0]->email;




              $data_1 = array('firstname'=>$contactName,'description'=>$message,'comment'=>$comment);



              if($this->check_netconnection())
              {

                  Mail::send('emails/permanent-reject', $data_1, function ($message) use ($email_id) {


                      $message->to($email_id)
                          ->subject('Change request is Rejected and Closed');

                  });

              }else{



              }

           }
           return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }

    }

    public function reminder_email(){

        $assign=DB::table('request_progress_status')
            ->select('request_progress_status.*')
            ->where('request_progress_status.close', 0)
            ->get();

             //  print_r($points);exit;

        foreach ($assign as $point) {
            $res[] = array('request_id' =>$this->get_request_info_by_id($point->request_id),
                'assign_by'=>$this->get_user_info_by_id($point->assigned_by),
                'assign_to' => $this->get_user_info_by_id($point->assigned_to),

            );


            $assign_to_email_id = (String)$res['assign_to']['email'];



            if($this->check_netconnection())
            {

                Mail::send('emails/email-template', array('data' => $res), function ($message) use ($assign_to_email_id) {

                    $message->to($assign_to_email_id)->subject('You Have New Task');

                });

            }else{



            }

        }


    }

    public function uploadFileExtension(){
      $data = DB::table('tb_dept_addRemove')
              ->select('file_upload_type')
              ->get();
              if($data[0]->file_upload_type == 'All'){
                $ext = "";
              }else{
                $ext = ".pdf,image/*";
              }
              return $ext;
    }

    public function getDay(){
       $data = DB::table('tb_dept_addRemove')
              ->select('No_of_Days')
              ->get();
              
              return $data;
    
    }
    public function get_inititor_dept($r_id){
      $id = Session::get('uid');
     if($id ==  1){
        $initId=DB::table('changerequests')
                ->select('initiator_id')
                ->where('request_id',$r_id)
                ->get();

                $data = DB::table('tb_users')
              ->leftJoin('tb_departments','tb_departments.d_id','=','tb_users.department')
              ->leftJoin('subdepartments','subdepartments.sub_dep_id','=','tb_users.sub_department')
              ->select('tb_users.department','tb_users.sub_department','tb_departments.d_name','subdepartments.sub_dep_name','subdepartments.sub_dep_id')

              ->where('id',$initId[0]->initiator_id)
              ->get();
            
     }else{
      $data = DB::table('tb_users')
              ->leftJoin('tb_departments','tb_departments.d_id','=','tb_users.department')
              ->leftJoin('subdepartments','subdepartments.sub_dep_id','=','tb_users.sub_department')
              ->select('tb_users.department','tb_users.sub_department','tb_departments.d_name','subdepartments.sub_dep_name','subdepartments.sub_dep_id')

              ->where('id',$id)
              ->get();
            }
            
              return $data;
    }


    public function checkDeptParam(){
      $data = DB::table('tb_dept_addRemove')
              ->select('view_dept_in_CR')
              ->get();
              if(!empty($data)){
                if($data[0]->view_dept_in_CR =='Yes'){
                    return 1;
                }else{
                    return 0;
                }
              }
              
              return $data;
    }

    
    public function get_changeSubType($type_id){
        $data = DB::table('tbl_chage_sub_type')
          ->select('sub_type_id','sub_type_name')
          ->where('change_type',$type_id)
          ->where('status','active')
          ->get();
          return $data;
    }

     public function get_changeSubType1($type_id){
        $data = DB::table('tbl_chage_sub_type')
          ->select('sub_type_id')
          ->where('change_type',$type_id)
          ->where('status','active')
          ->get();
          return $data;
    }


  
    public function view_search_result($id) {
      

            $query = DB::table('changerequests')
                //  ->leftJoin('customer', 'changerequests.customer_id', '=', 'customer.CustomerId')
                ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
                ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
                ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
                ->leftJoin('add_update_initial_sheet', 'changerequests.request_id', '=', 'add_update_initial_sheet.request_id')
                ->leftJoin('request_progress_status', 'changerequests.request_id', '=', 'request_progress_status.request_id')
                ->leftJoin('tb_users as user1', 'changerequests.Approval_Authority', '=', 'user1.id')
                ->leftJoin('tb_users as user2', 'changerequests.initiator_id', '=', 'user2.id')
                ->leftJoin('horizontal_deployment', 'changerequests.request_id', '=', 'horizontal_deployment.request_id')
                 ->leftJoin('tb_stakeholder','tb_stakeholder.id','=','changerequests.stakeholder')
                 ->leftJoin('tb_projectMaster', 'tb_projectMaster.id', '=', 'changerequests.proj_code')
                 ->leftJoin('tb_businessMaster', 'tb_businessMaster.id', '=', 'changerequests.business')
                  ->leftJoin('tbl_chage_sub_type', 'changerequests.change_sub_type', '=', 'tbl_chage_sub_type.sub_type_id')
                ->select('changerequests.*', 'tb_stakeholder.*','changerequests.status as cmstatus','tb_projectMaster.*', 'changerequests.request_id as r_id','changerequests.plant_code as plant', 'tb_departments.d_name', 'subdepartments.sub_dep_name','tb_change_stage.stage_name', 'user1.first_name as authority1', 'user1.last_name as authority2', 'user2.first_name as authority_1', 'user2.last_name as authority_2', 'tbl_change_type.change_type_name', 'plant_code.plant_code', 'horizontal_deployment.*', 'add_update_initial_sheet.selected as indexlevel', 'add_update_initial_sheet.currentTime as impdate','tbl_chage_sub_type.*','tbl_chage_sub_type.sub_type_name as type_name','tb_businessMaster.busi_code as busi','changerequests.change_stage as cr_stage'
)
                ->orderBy('changerequests.request_id', 'DESC')
                ->orderBy('horizontal_deployment.created', 'DESC')
                // ->orderBy('add_update_initial_sheet.currentTime', 'DESC')
                // ->where('changerequests.status','<>',5)
                ->where('changerequests.request_id', '=', $id);
            

            //$userjobs
            $users = $query->get();
            $user = $users[0];
            

            // print_r($users);exit;

            if ($user->impdate == '') {

                $user_created_data = '---';
            } else {

                $user_created_data = Carbon::createFromFormat('Y-d-m H:i:s', $user->impdate)->format('d.m.Y');
            }

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
                'changeSubType' => $user->type_name,
                'change_stage' => $user->change_stage,
                'stakeholder'   =>$user->name,
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
                
                'get_change_request_attachment' => $this->get_change_request_attachment($user->r_id),
                'count_request_is_rejected' => $this->get_count_request_is_rejected($id),
                'index_level' => $user->indexlevel,
                'impdate' => $user_created_data,
                
                
                'response_date' => $this->get_custom_date($user->projected_close_date),
                'hodApproveComment' => $this->getComment($user->r_id),
                'change_type_name' => $user->change_type_name,
                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->r_id, $user->cmstatus),

                'teamleader' => $this->get_team_leader_name($user->r_id),
                'parts'       => $this->getParts($user->r_id),
                'team_members'=> $this->fetch_dep_team($user->r_id) ,
                'risksdatas1'=> $this->get_allRisk_assessment_approval($user->r_id),
                'totalcost' =>$this->get_total_cost($user->r_id),
                'totcostperpiece' =>$this->get_total_cost_perpiece($user->r_id),
                'projrct_mgr'=>$this->get_overallRisk_authority ($user->cr_stage,$user->plant,$user->stakeholder,$user->proj_code),

            );
           
           

            return $data;
        
    }
      public function getParts($id){
        $data=DB::table('tbl_parts_info')
                ->select('tbl_parts_info.*')
                ->where('tbl_parts_info.request_ids', $id)->get();
                return $data;
      }
    


   

    public function getComment($r_id){
        $comment = DB::table('changerequests')
        ->select('comment')
        ->where('request_id',$r_id)
        ->get();
        return $comment[0]->comment;
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

    public function checkImplementationDate(){
      $input = (object)Input::all();
     
      $data = DB::table('add_update_initial_sheet')
              ->select('currentTime')
              ->where('request_id',$input->request_id)
              ->get();
         $tdate=explode(' ', $data[0]->currentTime);
            $date1 = explode('-', $tdate[0]);
            $currentTime = $date1[0] . '-' . $date1[2] . '-' . $date1[1];

          return $currentTime;
    }

    public function saveStockandDate(){
      $input = (object)Input::all();
      $uid=Session::get('uid');
        $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$input->request_id)
              ->where('id',$input->rpsid)
              ->get();
         if($checkClose[0]->close ==1 && ($uid != 1 || $uid != 114)){
            return 3;
         }

      
       if (isset($input->currentstock)) {
                $stock_data = $input->currentstock;
            } else {
                $stock_data = '';
            }
            if (isset($input->currentdate) && !empty($input->currentdate)) {
                $currentTime = $input->currentdate;
                $date1 = explode('.', $currentTime);
                $currentTime = $date1[2] . '-' . $date1[0] . '-' . $date1[1] . ' 00:00:00';
            } else {
                $currentTime = '';
            }

            $stock=DB::table('add_update_initial_sheet')
                  ->select('*')
                  ->where('request_id',$input->request_id)
                  ->get();
              // print_r($stock);exit();
            if(empty($stock)){

            DB::table('add_update_initial_sheet')->insert(
                array('team_leader_id' => Session::get('uid'),
                    // 'unique_id' => $input->unique_id,
                    'selected' => $input->radio,
                    'currentTime' => $currentTime,
                    'stock' => $stock_data,
                    'request_id' => $input->request_id
                )
            );
            echo 1;exit;
          }else{
            DB::table('add_update_initial_sheet')->where('request_id',$input->request_id)
                ->update(
                    array('team_leader_id' => Session::get('uid'),
                    // 'unique_id' => $input->unique_id,
                    'selected' => $input->radio,
                    'currentTime' => $currentTime,
                    'stock' => $stock_data,
                    
                )
            );
                echo 2;exit;
          }
    }

    public function get_change_stage($request_id){
      $stage=DB::table('changerequests')
            ->select('change_stage')
            ->where('request_id',$request_id)
            ->get();
        return $stage[0]->change_stage;
    }

    public function approve_allrisk_assesment_coo($id, $id1)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',Request::segment(3))
              ->where('id',Request::segment(4))
              ->get();
       if($checkClose[0]->close ==1){
            return Redirect::to('dashboard')->with('message', SiteHelpers::alert('error', 'Task is already completed.'))
                   ->withInput();
       }else{   
        if ($this->check_request_permission($id)) {

            return View::make('changes/approve-allrisk-assesment_coo');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Permission Denied.'));
        }
      }


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


     function cooApprovalstatus($id, $id1)
    {
      $checkClose = DB::table('request_progress_status')
              ->select('close')
              ->where('request_id',$id)
              ->where('id',$id1)
              ->get();
         if($checkClose[0]->close ==1){
            return ;exit();
         }
        $input = (object)Input::all();

        if ($input->radioStatus == 3) {

            $init_id=DB::table('request_progress_status')
                       ->select('assigned_by')
                       ->where('id',$id1) 
                       ->get();

           $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$init_id[0]->assigned_by)
                    ->get();

                    if(empty($data)){
                      echo 0;exit;
                    }

                    DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 5)
                  ->update(['actual_date' => 0]);

                   DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 11)
                  ->where('process','COO Approval')
                  ->delete();


             $coodecision=DB::table('coo_approval_decision_status')
                        ->where('request_id',$id)
                        ->update(
                          array('authority_id' => session::get('uid'),
                              'reject_reason' =>$input->reject_reason ,
                              'status'=>$input->radioStatus
                        )
                    );
       
           // $message = 'Rejected';
            $message='COO approval rejected';
            $url = 'changes/approve-all-risk-assesment/';
           
            $last_id_req=$this->save_noticication_status_for_reject($init_id[0]->assigned_by, $id, $message, $url, 8,$input->reject_reason);

            $data1 = $this->get_user_info_by_id($init_id[0]->assigned_by);
            $initiator_id = $this->get_data_id($last_id_req);

            $initiator_name = $this->get_user_info_by_id($initiator_id['assigned_by']);

            $request_id=$id;
            $close_status=$last_id_req;


            $contactName = $data1['name'];
            $email_id = $data1['email'];
            $assignedby=Session::get('fid');
            $assignedto=$initiator_name['name'];
            $comment=$input->reject_reason;

            $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'task_assigned_to'=>$assignedto,'url'=>$url,'request_id'=>$request_id,'Close_status'=>$close_status,'comment'=>$comment);

            Mail::send('emails/email-template-reject', $data_1, function ($message) use ($email_id) {

                $message->to($email_id)
                ->subject('You Have New Task');

            });
            $this->change_request_status_close($id, $id1);



        } else{
          // *************Following code for accept**************

             
          $changeReqData = DB::table('changerequests')
         ->select('plant_code','stakeholder','change_stage','proj_code','changeType','created_date')
         ->where('request_id',$id)
         ->get();
          
            $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
             ->select('steeringComm_id')
             ->where('plant_id',$changeReqData[0]->plant_code)
             ->where('stakeholder',$changeReqData[0]->stakeholder)
             ->where('change_stage',$changeReqData[0]->change_stage)
             ->where('change_type',$changeReqData[0]->changeType)
             ->get();
            $data1 = [];
               if(empty($steerCommMem)){
               echo 1;exit;
               }
             $steerCommMemId = explode(',', $steerCommMem[0]->steeringComm_id);
               $count1 = count($steerCommMemId);
             
            if(!empty($steerCommMem)){
                for($i=0;$i<$count1;$i++) {
             
             $data1[] = DB::table('tb_users')
                    ->leftJoin('subdepartments', 'tb_users.sub_department', '=', 'subdepartments.sub_dep_id')
                    ->select('tb_users.email', 'tb_users.id','subdepartments.sub_dep_id')
                    ->where('tb_users.id', $steerCommMemId[$i])
                    ->get();

                    $data = DB::table('tb_users')
                    ->select('id')
                    ->where('active',1)
                    ->where('id',$steerCommMemId[$i])
                    ->get();

                     if(empty($data)){   

                      echo 1;exit;

                      
                  }
              }
            }
              
              $coodecision=DB::table('coo_approval_decision_status')
                        ->where('request_id',$id)
                        ->update(
                          array('authority_id' => session::get('uid'),
                              'comment' =>$input->comment ,
                              'status'=>$input->radioStatus
                        )
                    );

              $allMem = $data1;
             
                
                $superAdminCnt=DB::table('request_progress_status')
                ->select(DB::raw('COUNT(id) as total'))
                ->where('request_id',$id)
                ->where('status',88)
                ->get();

                foreach ($allMem as $value) {

               //----start code for tracking Sheet----

                $data=DB::table('tracking_sheet_date_param')->where('id',6)->get();
                $Date=date('Y-m-d');

                $targetDate=date("Y-m-d", strtotime($Date.' + '.$data[0]->no_of_days.' days'));
                
                  DB::table('tracking_sheet_info')->insert(
                      array(
                          'request_id' => $id,
                          'process'     =>'steering commitee approval by '.$value[0]->id,
                          'target_date' =>$targetDate,
                          'actual_date'  =>0,
                          'status'      =>6
                        )
                    );
               
                
                  DB::table('tracking_sheet_info')
                  ->where('request_id', $id)
                  ->where('status', 11)
                  ->update(['actual_date' => $Date]);

                 
                 //----end code for tracking Sheet----

                $email_send = (String)$value[0]->email;
                $sub_dep=(String)$value[0]->sub_dep_id;

                $message="Pending Steering Committee approval on Risk Assessment points based on cost.";

                $url = 'changes/approve-allrisk-assesment/';

                $last_id_req= $this->save_noticication_status_for_steering_sub_dep((String)$value[0]->id, $id, $message, $url, 88,$sub_dep);
                $this->change_request_status_close($id, $id1);

                $id_user = DB::table('request_progress_status')

                    ->select('request_progress_status.assigned_by')
                    ->where('request_progress_status.id', $id1)
                    ->first();

                DB::table('approval_risk_assessment_from_admin')->insert(
                    array('request_id' => $id,
                        'approve_status' => 1,
                        'reject_reason'=>'',
                        'user_id' => $id_user->assigned_by,
                        'apprve_comment' => $input->comment

                    )
                );


                $data1 = $this->get_user_info_by_id((String)$value[0]->id);//Assigned to task


                $request_id=$id;
                $close_status=$last_id_req;


                $contactName = $data1['name'];
                $email_id = $data1['email'];
                $assignedby=Session::get('fid');
                 $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $data_1 = array('firstname'=>$contactName,'description'=>$message,'assigned_task_by'=>$assignedby,'url'=>$url,'request_id'=>$cmNo,'Close_status'=>$close_status);


                if($this->check_netconnection())
                {

                    Mail::send('emails/email-templates', $data_1, function ($message) use ($email_id) {

                        $message->to($email_id)->subject('You Have New Task');
                    });

                }else{

                }

            }
        }
    }

    public function downloadView(){
   
    if(isset($_GET['r_Id'])){
      $r_id=$_GET['r_Id'];
       $request_id=explode("/",$r_id);
       $query = DB::table('changerequests')
              ->select('request_id')
              ->where('request_id',$request_id[2])
              ->get();
       if(!empty($query)){
       $dataview2= $this->view_search_result_download($request_id[2]) ;
            $team_members= $this->fetch_dep_team_WithComment($request_id[2]) ;
             $risksdatas1= $this->get_allRisk_assessment_approval($request_id[2]) ;
             $summeries = $dataview2['userjobs'];

              if($summeries['index_level']=='1'){
                $summeries['lev']='Yes';
               }else if($summeries['index_level']=='2'){
                $summeries['lev']='No';
               }else{
                $summeries['lev']='';
               }
               
               if(!empty($summeries['hd'])){
               if($summeries['hd']->status=='1'){
                $summeries['hd1']='Yes';
               }else if($summeries['hd']->status=='2'){
                $summeries['hd1']='No';
               }else{
                $summeries['hd1']='';
               }
             }
             $parts = $dataview2['parts'];


      $pdf=PDF::loadView('scm/view_details_download',compact('summeries','parts','team_members','risksdatas1'));
                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
          return $pdf->download('View.pdf');




    }
    else{
       return Redirect::back();
    }
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

 public function view_search_result_download($id) {
      
            $query = DB::table('changerequests')
                //  ->leftJoin('customer', 'changerequests.customer_id', '=', 'customer.CustomerId')
                ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                ->leftJoin('subdepartments', 'changerequests.sub_dep_id', '=', 'subdepartments.sub_dep_id')
                ->leftJoin('tb_change_stage', 'changerequests.change_stage', '=', 'tb_change_stage.change_stage_id')
                ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                ->leftJoin('plant_code', 'changerequests.plant_code', '=', 'plant_code.plant_id')
                ->leftJoin('add_update_initial_sheet', 'changerequests.request_id', '=', 'add_update_initial_sheet.request_id')
                ->leftJoin('request_progress_status', 'changerequests.request_id', '=', 'request_progress_status.request_id')
                ->leftJoin('tb_users as user1', 'changerequests.Approval_Authority', '=', 'user1.id')
                ->leftJoin('tb_users as user2', 'changerequests.initiator_id', '=', 'user2.id')
                ->leftJoin('horizontal_deployment', 'changerequests.request_id', '=', 'horizontal_deployment.request_id')
                ->leftJoin('tb_stakeholder','tb_stakeholder.id','=','changerequests.stakeholder')
                ->leftJoin('tb_projectMaster', 'tb_projectMaster.id', '=', 'changerequests.proj_code')
                ->leftJoin('tb_businessMaster', 'tb_businessMaster.id', '=', 'changerequests.business')
                ->leftJoin('tbl_chage_sub_type', 'changerequests.change_sub_type', '=', 'tbl_chage_sub_type.sub_type_id')
                ->select('changerequests.*', 'tb_stakeholder.*','changerequests.status as cmstatus','tb_projectMaster.*', 'changerequests.request_id as r_id','changerequests.plant_code as plant', 'tb_departments.d_name', 'subdepartments.sub_dep_name','tb_change_stage.stage_name', 'user1.first_name as authority1', 'user1.last_name as authority2', 'user2.first_name as authority_1', 'user2.last_name as authority_2', 'tbl_change_type.change_type_name', 'plant_code.plant_code', 'horizontal_deployment.*', 'add_update_initial_sheet.selected as indexlevel', 'add_update_initial_sheet.currentTime as impdate','tbl_chage_sub_type.*','tbl_chage_sub_type.sub_type_name as type_name','tb_businessMaster.busi_code as busi')
                ->orderBy('changerequests.request_id', 'DESC')
                ->orderBy('horizontal_deployment.created', 'DESC')
                ->where('changerequests.request_id', '=', $id);
            

            //$userjobs
            $users = $query->get();
            $user = $users[0];
            

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
                'Purpose_Modification_Details' => $user->Purpose_Modification_Details,
                'remark' => $user->remark,
                'created_date' => $this->get_custom_date($user->dt),
                'status' => $user->status,
                'd_name' => $user->sub_dep_name,
                'sub_dep_name' => $user->request_id,
                'stage_name' => $user->stage_name,
                //  'user_role' => $user->user_role,
                'before_after_attachement' => $this->get_before_after_attachment_file_download($user->r_id),
                'ptrDocument'       =>$this->get_ptrDocumet_download($user->r_id),
                'get_change_request_attachment' => $this->get_change_request_attachment($user->r_id),
                'count_request_is_rejected' => $this->get_count_request_is_rejected($id),
                'index_level' => $user->indexlevel,
                'impdate' => $user_created_data,
                'final_closer' => $this->admin_closer_status_download($user->r_id),
                'steering_committee_approval' => $this->get_steering_committee_approval_download($user->r_id),
                'steering_commitee_member' => $this->get_steering_commitee_member_download($user->r_id),
                'responsibility_to_get_customer_approval' => $this->get_responsibility_to_get_customer_approval_download($user->r_id),
                'customer_approval_attachment' => $this->get_cust_data_attachments_download($user->r_id),
                'verification_status' => $this->get_verification_status($user->r_id),
                'customer_to_be_communicated' => $this->get_customer_to_be_communicated_download($user->r_id),
                'hd' => $this->get_hd_download($user->r_id),
                'response_date' => $this->get_custom_date($user->projected_close_date),
                'hodApproveComment' => $this->getComment($user->r_id),
                'change_type_name' => $user->change_type_name,
                'horizontal_deployment_comment' => $user->comment,
                'horizontal_deployment_status' => $user->status,
                'horizontal_deployment_reason' => $this->get_hd_download($user->r_id),
                'cmNo' => $this->generate_cm_no($user->change_type_name, $user->created_date, $user->r_id, $user->cmstatus),

                'teamleader' => $this->get_team_leader_name($user->r_id),
                'totalcost' => $this->get_total_cost_download($user->r_id),
                'close_details' => $this->get_close_details_download($user->r_id),
                'prjMgrComment' =>$this->getprjMgrComment($user->r_id),
                    'projrct_mgr'=>$this->get_overallRisk_authority($user->change_stage,$user->plant,$user->stakeholder,$user->proj_code),


            );


            $parts = DB::table('tbl_parts_info')
                ->select('tbl_parts_info.*')
                ->where('tbl_parts_info.request_ids', '=', $id)->get();
            $data['parts'] = $parts;

            return $data;
        

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


    


}	

