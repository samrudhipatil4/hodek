<?php
unset($_SESSION['btntype']);
class apqptaskController extends BaseController  {


    public function assignToHods(){
        $input = Input::all();

        \Log::info([
            "you get called" => $input,        
        ]);
        

exit();
    }
    public function SadminAPQPTask(){
        $data =DB::select(DB::raw('select a.*,p.plant_code from apqp_new_project_info as a
         LEFT JOIN 
                    plant_code AS p 
                    ON p.plant_id = a.mfg_location
                    WHERE 
        project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) and a.flag=1 AND release_flag = 1 and (a.id IN(select project_id from apqp_draft_project_plan where release_project= 0 ) or a.id  NOT IN(select project_id from apqp_draft_project_plan )) '));
        \Log::info([
            "data completed" => $data,
        ]);
        return $data;

    // exit();
    }

	//protected $layout = "layouts.main";   
	// public function get_hod_pending_task(){
    //     $userId = Session::get('uid');
        
	// 		$data =DB::select(DB::raw('select * from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) and a.flag=1 AND release_flag = 1 and (a.id IN(select project_id from apqp_draft_project_plan where release_project= 0 ) or a.id  NOT IN(select project_id from apqp_draft_project_plan )) '));

    //         return $data;
        
    // }
	//protected $layout = "layouts.main";   
	public function get_hod_pending_task(){
        $userId = Session::get('uid');
        \Log::info([
            "final userId" => $userId,
        ]);
		
		if($userId!=1){
			
			// Step 1: Fetch group_id from tb_user for the given user_id
			$userGroup = DB::table('tb_users')
			->where('id', $userId)
			->pluck('group_id');

	 		// // Step 1: Retrieve project_id for the given user_id
			// $data = DB::select(DB::raw('SELECT * FROM apqp_project_dept_user WHERE user_id = :user_id'), [
			// 	'user_id' => $userId,
			// ]);
			
			// Step 2: Check if group_id contains '101'
            if ($userGroup && in_array('101', explode(',', $userGroup))) {
            // Step 3: Fetch data from apqp_project_dept_user
                    $data = DB::select(DB::raw('SELECT * FROM apqp_project_dept_user WHERE user_id = :user_id AND HOD_Tasks_Flag = 0'), [
                        'user_id' => $userId,
                    ]);
                    // Extract project_id values into an array
                    $projectIds = array_map(function ($item) {
                        return $item->project_id;
                    }, $data);
                    
                    // Convert to a comma-separated string with proper quoting for SQL
                    $projectIdsString = "'" . implode("','", $projectIds) . "'";

                    // Ensure $projectIds is always an array
                    $projectIdsArray = is_array($projectIds) ? $projectIds : [$projectIds];

                    \Log::info([
                        "projectIdsArray" => $projectIdsArray,
                    
                    ]);

                    $sql = "
                    SELECT a.*, p.plant_code 
                    FROM apqp_new_project_info AS a 
                    LEFT JOIN 
                    plant_code AS p 
                    ON p.plant_id = a.mfg_location
                    WHERE 
                        project_revision = (
                            SELECT MAX(project_revision) 
                            FROM apqp_new_project_info AS b 
                            WHERE a.project_no = b.project_no
                        )
                        AND a.id NOT IN (
                            SELECT project_id 
                            FROM apqp_drop_project
                        )
                        AND a.flag = 1 
                        AND a.release_flag = 0
                        AND a.release_final_flag = 1
                        AND (
                            a.id IN (
                                SELECT project_id 
                                FROM apqp_draft_project_plan 
                                WHERE release_project = 0
                            ) 
                            OR a.id NOT IN (
                                SELECT project_id 
                                FROM apqp_draft_project_plan
                            )
                        )
                        AND a.project_no IN ($projectIdsString)
                    ";

                // Fetch all data using the query
                    $pending_proj_data = DB::select(DB::raw($sql));
            }

            \Log::info([
                // "sql" => $sql,
                "final pending_proj_data" => $pending_proj_data,
              ]);

            
            $pending_data = [];

            foreach ($pending_proj_data as $key) {
                $pending_data[] = array(
                    'pending_project_id'         => $key->id,
                    'pending_project_no'         => $key->project_no,
                    'pending_project_name'       => $key->project_name,
                    'pending_project_manulocation' => $key->plant_code,
                    'pending_project_startdate'  => $key->project_start_date,
                );
            }
            
            return $pending_data;
		}else{
            // super admin
            $pending_proj_data = DB::select(DB::raw("
                    SELECT a.*, p.plant_code 
                    FROM apqp_new_project_info AS a 
                    LEFT JOIN 
                    plant_code AS p 
                    ON p.plant_id = a.mfg_location
                    WHERE 
                        project_revision = (
                            SELECT MAX(project_revision) 
                            FROM apqp_new_project_info AS b 
                            WHERE a.project_no = b.project_no
                        )
                        AND a.id NOT IN (
                            SELECT project_id 
                            FROM apqp_drop_project
                        )
                        AND a.flag = 1 
                        AND a.release_flag = 0
                        AND a.release_final_flag = 1
                        AND (
                            a.id IN (
                                SELECT project_id 
                                FROM apqp_draft_project_plan 
                                WHERE release_project = 0
                            ) 
                            OR a.id NOT IN (
                                SELECT project_id 
                                FROM apqp_draft_project_plan
                            )
                        )
                "));
        
                // Log the final data
                \Log::info([
                    "final from super admin pending_proj_data" => $pending_proj_data,
                ]);
        
                // Prepare the pending data for response
                $pending_data = [];
                foreach ($pending_proj_data as $key) {
                    $pending_data[] = array(
                        'pending_project_id' => $key->id,
                        'pending_project_no' => $key->project_no,
                        'pending_project_name' => $key->project_name,
                        'pending_project_manulocation' => $key->plant_code, 
                        'pending_project_startdate' => $key->project_start_date,
                        'btn_flag' => $key->admin_complete_task,
                    );
                }
                return $pending_data;
        }
        
    }


	public function get_apqp_task()
	{
		 $query = DB::table('apqp_all_task')
                  ->leftjoin('apqp_draft_project_plan','apqp_draft_project_plan.id','=','apqp_all_task.activity_id_as_per_drft')
		 		  ->leftJoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_all_task.activity')
		 		  ->leftJoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_all_task.project_id')
		 		  ->select('apqp_all_task.*','apqp_all_task.id as tid','apqp_all_task.activity as actid','apqp_gate_activity_master.activity as act','apqp_new_project_info.*','apqp_all_task.activity_id_as_per_drft as did','apqp_draft_project_plan.material_id')
		 		  ->where('close',0)
		 		  ->where('assigned_to',Session::get('uid'))
		 		  ->get();
		 		  // dd($query);
		 		  $data=[];
                  
		 		 foreach ($query as $key) {
                $aaid=explode('@', $key->actid);
		 		 	if (preg_match('/[A-Z]+[a-z]+/', $key->actid))
						{
						    $act=$key->activity;
						   
						}else if($aaid[0]== 'a'){
                            $act=$this->getActName($key->actid,$key->gate,$key->project_id);
                        }else{

							$act=$key->act;
							
						}
		 		 	$data[]= array(
		 		 			'id'		=> $key->tid,
                            'did'        => $key->did,
		 		 			'pid'		=> $key->project_id,
		 		 			'aid'		=> $key->actid,
                            'gate_id'   =>  $key->gate,
		 		 			'proj_id' => $key->project_no.' Revision '.$key->project_revision,
		 		 			'proj_name' => $key->project_name,
		 		 			'activity'=>$act,
		 		 			'start_date'=>$key->activity_start_date,
		 		 			'end_date'=>$key->activity_end_date,
		 		 			'next_url' => $key->next_url,
                            'mat_id' =>$key->material_id,
                            'hold_project'=>$key->hold_project,
                            'flag' =>$key->flag

		 		 		);
		 		}                 
		 		

		 		 return $data;
	}

    public function getMaterial($mid){
        if($mid != 0){
            $data=DB::table('apqp_material_master')
                ->select('material_description')
                ->where('id',$mid)
                ->get();
                return $data;
        }
        
    }
    public function getActName($aid,$gid,$pid){
        $data=DB::table('apqp_activity_as_per_project')
                ->select('pactivity')
                ->where('pa_proj_id',$pid)
                ->where('p_act_id',$aid)
                ->where('pa_gate_id',$gid)
                ->get();
                if(!empty($data)){
                    return $data[0]->pactivity;
                }
    }
	public function apqp_findmemberdep($id)
	{
		$member = DB::table('tb_users')
				->select('tb_users.first_name','tb_users.last_name')
				->where('id', '=', $id)->get();
		return $member;

	}
	public function task(){
				if(Auth::check()):
				 return View::make('apqpTask/userTask');
			else:
				 return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
			  endif;
	}

	public function saveTaskDet($aid,$pid,$actid){
		 $input = (object)Input::all();
		//dd($input);
		if(isset($input->actual_start_date)){
        		$date=$input->actual_start_date;
    	}else{
    		$date='';
    	}
    	if(isset($input->cost)){
        		$cost=$input->cost;
    	}else{
    		$cost='';
    	}
    	
    	if(isset($input->risk)){
        		$risk=$input->risk;
    	}else{
    		$risk='';
    	}
    	if(isset($input->action)){
        		$action=$input->action;
    	}else{
    		$action='';
    	}
    	$data=DB::table('apqp_user_task_details')
    				->select('apqp_user_task_details.id')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                    ->where('act_id',$actid)
                    ->get();
    	if(empty($data)){
    	 DB::table('apqp_user_task_details')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                     ->insert(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'act_id'	=>$actid,
                    		'actual_start_date'  =>date('Y-m-d', strtotime($date)),
                    		
                    		'risk'     =>$risk,
                    		'action'     =>$action,
                    		'cost'     =>$cost,
                    		'created_date' =>date('Y-m-d'),
                    		'actual_end_date' =>date('Y-m-d'),
                    		)
                    	);
    	}else{
    		DB::table('apqp_user_task_details')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                     ->update(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'actual_start_date'  =>date('Y-m-d', strtotime($date)),
                    		'delay_reason'  =>$reason,
                    		'comment'  =>$input->comment,
                    		'created_date' =>date('Y-m-d'),
                    		'actual_end_date' =>date('Y-m-d'),
                    		'risk'     =>$input->risk,
                    		'action'     =>$input->action,
                    		'cost'     =>$input->cost,
                    		)
                    	);
    	}
               
	}
	public function submitTask($aid,$pid,$tid,$mid){
		$input=Input::all();
		// dd($input);
        $checkClose=DB::table('apqp_all_task')
                    ->where('project_id',$pid)
                    ->where('activity',$aid)
                    ->where('id',$tid)
                    ->where('close',1)
                    ->get();
            if(!empty($checkClose)){
              return Redirect::to('apqp_dashboard');
            }        

		if(isset($input['submitDocument'])){
			
        }else{
            if(isset($input['startdate_status'])){
             $date1 = explode('/', $input['startdate_status']);
                 $cnt=count($date1);
                 if($cnt==3){
                     $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                 }else{
                    $d_t=$input['startdate_status'];
                 }
            }

            
        	DB::table('apqp_user_task_details')
                    ->where('act_id',$tid)
                    ->where('project_id',$pid)
                     ->update(
                    	array(
                    		'actual_start_date'  => $d_t,
                            'actual_end_date' =>date('Y-m-d'),
                            'remark'=>$input['txtremark']
                    		)
                    	);
        	
                      DB::table('apqp_all_task')
                    	->where('id',$tid)
                     	->update(
	                    	array(
	                    		'close' =>1,
	                    		)
	                    	);
                 $aaid=explode('@', $aid);
                         if($aaid[0]!='a'){
         
                     	  $depAct1=DB::table('apqp_draft_project_plan')
                     	->select('apqp_draft_project_plan.*')
                    	->where('prev_reference_act',$aid)
                    	->where('project_id',$pid);
                        if($mid != 0){
                            $depAct1->where('material_id',$mid);
                            }
                        $depAct = $depAct1->get();
                        

            if(!empty($depAct)){
         foreach ($depAct as $key) {
     		$mailData[] = DB::table('apqp_draft_project_plan')
					->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
					->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
					->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_draft_project_plan.material_id')
					->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_draft_project_plan.project_id')
					->leftjoin('tb_users','tb_users.id','=','apqp_draft_project_plan.responsibility')
					->select('tb_users.email','tb_users.first_name','tb_users.last_name','apqp_draft_project_plan.*','apqp_gate_activity_master.activity as act','apqp_gate_management_master.Gate_Description','apqp_new_project_info.*','apqp_material_master.material_description')
					->where('apqp_draft_project_plan.id',$key->id)
					->get();

                    
                               // print_r($oldActId);exit();


						$data1 = DB::table('apqp_all_task')
					->insert(
						array(
								'project_id'  		=> $key->project_id,
								'assigned_to' 		=>  $key->responsibility,
								'department'		=>  $key->department,
								'activity'=>  $key->activity,
								'gate'	=> $key->gate_id,
								'activity_start_date'  		=> $key->activity_start_date,
								'activity_end_date'		=> $key->activity_end_date,
								'next_url' 		=>  'apqp/task',
								'prev_refer_act' =>$key->prev_reference_act,
                                'activity_id_as_per_drft' => $key->id,
                                'status' =>1,
								'close'		=>  0,
                                'CreatedDate' =>date('Y-m-d H:i:s'),
								
							)
					);
                     $last_id = DB::getPdo()->lastInsertId();
                     if($key->old_draft_id != ""){
                     $oldActId= DB::table('apqp_all_task')
                                ->select('id')
                                ->where('activity_id_as_per_drft',$key->old_draft_id)
                                ->where('activity',$key->activity)
                                ->get();

                              //  print_r($oldActId[0]->id);exit();

                                if(!empty($oldActId)){
                                DB::table('apqp_user_task_details')
                                ->where('project_id',$key->project_id)
                                ->where('activity_id',$key->activity)
                                ->where('act_id',$oldActId[0]->id)
                                ->update(
                                    array(
                                            'act_id' => $last_id,
                                        )
                                );

                                 DB::table('apqp_user_task_document')
                                 ->where('project_id',$key->project_id)
                                ->where('activity_id',$key->activity)
                                ->where('act_id',$oldActId[0]->id)
                                ->update(
                                    array(
                                            'act_id' => $last_id,
                                            
                                            
                                        )
                                );
                             }
                            }
					
				}
			 //echo "<pre>";print_r($mailData);exit();
				foreach ($mailData as $value) {
					if(!empty($value)){
					if($value[0]->material_description ==''){
						$mat='';
					}else{
						$mat=$value[0]->material_description;
					}
					$data_1 = array('proj_id'=>$value[0]->project_no,'revision'=>$value[0]->project_revision,'proj_name'=>$value[0]->project_name,'gate_id'=>$value[0]->Gate_Description,'activity'=>$value[0]->act,'startdate'=>date('d-m-Y', strtotime($value[0]->activity_start_date)),'end_date'=>date('d-m-Y', strtotime($value[0]->activity_end_date)),'material'=>$mat,'first_name'=>$value[0]->first_name,'last_name'=>$value[0]->last_name);
					$email = $value[0]->email;
	                if($this->check_netconnection())
	                {
	                    Mail::send('apqpEmails/taskEmail', $data_1, function ($message) use ($email) {

	                        $message->to($email)->subject('You Have New Task');

	                    });
	                }else{

	                }
	            }
				}
                     	
			}
        }
			 $gate=DB::table('apqp_all_task')
                        ->join('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_all_task.gate')
                     	->select('gate','Gate_Description')
                    	->where('apqp_all_task.id',$tid)
                     	->get();

                     	$checkgateAct=DB::table('apqp_all_task')
                     	->select(DB::raw('COUNT(id) as total'))
                    	->where('gate',$gate[0]->gate)
                    	->where('close',1)
                        ->where('project_id',$pid)
                     	->get();
                        $checkgateActInDraft=DB::table('apqp_draft_project_plan')
                        ->select(DB::raw('COUNT(id) as total'))
                        ->where('gate_id',$gate[0]->gate)
                        ->where('project_id',$pid)
                        ->get();
                     	if($checkgateAct[0]->total == $checkgateActInDraft[0]->total){
                     		$pno=DB::table('apqp_draft_project_plan')
                     	 ->select('apqp_draft_project_plan.project_no')
                    	->where('project_id',$pid)
                     	->get();

                     	$gateclr=DB::table('apqp_gate_clearence_app_team')
                     	 ->select('apqp_gate_clearence_app_team.*')
                    	->where('project_id',$pno[0]->project_no)
                    	->where('gate_id',$gate[0]->gate)
                     	->get();
                        $gateclrmem = explode(',', $gateclr[0]->user_id);

                         $count1 = count($gateclrmem);
             
                        if(!empty($gateclrmem)){
                            for($i=0;$i<$count1;$i++) {
                        
                     		$data1 = DB::table('apqp_all_task')
                        
					->insert(
						array(
								'project_id'  		=> $pid,
								'assigned_to' 		=>  $gateclrmem[$i],
								
								'gate' =>$gate[0]->gate,
								'activity'=>'All gate activities are completed',
								'activity_start_date'=>'-',
								'activity_end_date'=>'-',
								'next_url' 		=>  'apqp/gateclearance',
								
								'status' =>2,
								'close'		=>  0,
								'CreatedDate' =>date('Y-m-d H:i:s'),
							)
					);



                   $getuserDet=$this->getUserDet($gateclrmem[$i]);
                   $data_1 = array('proj_id'=>$pno[0]->project_no,'gate_id'=>$gate[0]->Gate_Description,'first_name'=>$getuserDet[0]->first_name,'last_name'=>$getuserDet[0]->last_name,'msg'=>'All activities are completed');
                   $email=$getuserDet[0]->email;

                   
                        if($this->check_netconnection())
                        {
                            Mail::send('apqpEmails/gateclrEmail', $data_1, function ($message) use ($email) {

                                $message->to($email)->subject('You Have New Task');

                            });
                        }else{

                        }
                    }
                     }
                 }
        	}
        	return Redirect::to('apqp_dashboard');
	}

    public function getUserDet($id){
        $data=DB::table('tb_users')
                ->select('first_name','last_name','email')
                ->where('id',$id)
                ->get();
                return $data;
    }
	public function getProjectStartDate(){
          $input=Input::all();

		$date= DB::table('apqp_new_project_info')
                    ->select('project_start_date')
                    ->where('id', $input['pid'])
                    ->get();
                    return $date;
	}
	public function getTask($aid,$pid,$actid){
		//$allData=[];
		$doc= DB::table('apqp_user_task_details')
                ->select('apqp_user_task_details.*')
                ->where('activity_id',$aid)
                ->where('project_id',$pid)
                ->where('act_id',$actid)
                ->get();
                // print_r($doc);
                if(!empty($doc)){
                foreach($doc as $d){
                    if($d->actual_start_date != '0000-00-00'){
                        $start_date = $d->actual_start_date;
                    }else{
                         $start_date = '';
                    }
                    $allData[]=
                        array(
                    'act_id' => $d->act_id,
                    'action' => $d->action,
                    'activity_id'=> $d->activity_id,
                    'actual_end_date' =>$d->actual_end_date,
                    'actual_start_date' => $start_date,
                    'cost' => $d->cost,
                    'hour' => $d->hour,
                    'gate_id'=>$d->gate_id,
                    'id' =>$d->id,
                    'parameter'=>$d->parameter,
                    'project_id'=>$d->project_id,
                    'remark' =>$d->remark,
                    'risk'  =>$d->risk,
                    'issue'      =>$d->issue,
                    'doc'   =>$this->getDoc($d->project_id,$d->activity_id,$d->act_id,$d->parameter),
                    'Issuedoc'   =>$this->getIssueDoc($d->project_id,$d->activity_id,$d->act_id,$d->parameter)
                    );

                }

                	return $allData;
                }else{
                	return $allData;
                }
    }
     public function getDoc($pid,$activity_id,$act_id,$param){

      $data2[]=DB::table('apqp_user_task_document')
           
            ->select("apqp_user_task_document.id",'apqp_user_task_document.upload_doc')
            ->where('act_id',$act_id)
            ->where('project_id',$pid)
            ->where('activity_id',$activity_id)
            ->where('parameter',$param)
            ->get();

            if(!empty($data2)){
              return $data2;
            }
    }
    public function getIssueDoc($pid,$activity_id,$act_id,$param){

      $data2[]=DB::table('apqp_activity_issue_document')
           
            ->select("apqp_activity_issue_document.id",'apqp_activity_issue_document.issue_document')
            ->where('act_id',$act_id)
            ->where('project_id',$pid)
            ->where('activity_id',$activity_id)
            ->where('parameter',$param)
            ->get();

            if(!empty($data2)){
              return $data2;
            }
    }
    public function getActivityName($aid,$pid){
         $aaid=explode('@', $aid);
         if($aaid[0]=='a'){
         
             $data=DB::table('apqp_activity_as_per_project')
                ->join('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_activity_as_per_project.pa_gate_id')
                ->select('apqp_activity_as_per_project.pactivity as activity','apqp_gate_management_master.Gate_Description','apqp_gate_management_master.flag')
                ->where('apqp_activity_as_per_project.p_act_id',$aid)
                ->where('apqp_activity_as_per_project.pa_proj_id',$pid)
                ->get();
                if(!empty($data)){
                    return $data;
                }
         }else{
             $data=DB::table('apqp_gate_activity_master')
                ->join('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_gate_activity_master.gate_id')
                ->select('apqp_gate_activity_master.activity','apqp_gate_management_master.Gate_Description','apqp_gate_activity_master.flag')
                ->where('apqp_gate_activity_master.id',$aid)
               
                ->get();
                if(!empty($data)){
                	
                    return $data;
                }
         }
       
       
    }

    public function getTask1(){
        $input=Input::all();
        $doc= DB::table('apqp_user_task_details')
                    ->select('apqp_user_task_details.actual_start_date')
                    ->where('activity_id',$input['aid'])
                      ->where('project_id',$input['pid'])
                      ->where('act_id',$input['tid'])
                    ->first();
                    if(!empty($doc)){
                        return $doc;
                    }else{
                        return $doc;
                    }
      }

      public function checkParamkSave(){
        $input=Input::all();
        $doc= DB::table('apqp_user_task_details')
                    ->select('apqp_user_task_details.risk')
                    ->where('activity_id',$input['aid'])
                      ->where('project_id',$input['pid'])
                      ->where('act_id',$input['act_id'])
                    ->first();
                    if(!empty($doc)){
                        return 'save';
                    }else{
                        return 'no';
                    }
      }
                    
	public function deleteIssueFile($id,$filename){
      

		 DB::table('apqp_activity_issue_document')->where('id', $id)->delete();

            $filename = Config::get('app.site_root') . '/uploads/apqp_issue_document/' . $filename;
           

            if (File::exists($filename)) {
                File::delete($filename);
            }
            
	}
  public function deleteFile($id,$filename){
      

     DB::table('apqp_user_task_document')->where('id', $id)->delete();

            $filename = Config::get('app.site_root') . '/uploads/apqp_activity_document/' . $filename;
           

            if (File::exists($filename)) {
                File::delete($filename);
            }
            
  }
    public function deleteParam($param,$aid,$pid,$act_id){
      

         DB::table('apqp_user_task_details')
         ->where('project_id', $pid)
         ->where('activity_id', $aid)
         ->where('act_id', $act_id)
         ->where('parameter', $param)
         ->delete();

         $file = DB::table('apqp_user_task_document')
         ->where('project_id', $pid)
         ->where('activity_id', $aid)
         ->where('act_id', $act_id)
         ->where('parameter', $param)
         ->get();

         $issuefile = DB::table('apqp_activity_issue_document')
         ->select('issue_document')
         ->where('project_id', $pid)
         ->where('activity_id', $aid)
         ->where('act_id', $act_id)
         ->where('parameter', $param)
         ->get();
             foreach($file as $f){
                 $filename = Config::get('app.site_root') . '/uploads/apqp_activity_document/' . $f->upload_doc;
               
                if (File::exists($filename)) {
                    File::delete($filename);
                }
             }

             foreach($issuefile as $f){
                 $filename = Config::get('app.site_root') . '/uploads/apqp_issue_document/' . $f->issue_document;
               
                if (File::exists($filename)) {
                    File::delete($filename);
                }
             }

             $file = DB::table('apqp_activity_issue_document')
         ->where('project_id', $pid)
         ->where('activity_id', $aid)
         ->where('act_id', $act_id)
         ->where('parameter', $param)
         ->delete();

         DB::table('apqp_user_task_document')
         ->where('project_id', $pid)
         ->where('activity_id', $aid)
         ->where('act_id', $act_id)
         ->where('parameter', $param)
         ->delete();

         return '1';exit();    
    }
	public function fileUpload($uploadNo){
		$input=Input::all();
		//print_r($input);exit();
             
		$aid=$input['aid'];
		$pid=$input['pid'];
		$tid=$input['tid'];

          $data1=DB::table('apqp_all_task')
                    ->select('apqp_all_task.gate')
                    ->where('id',$tid)
                    ->get();
		    	
    	$doc = 'doc'.$uploadNo;
        $issuedoc = 'issueDoc'.$uploadNo;

	 		if (Input::hasFile($doc)) {
			 foreach($input[$doc] as $file) {
			 	
			 	 $destinationPath = 'uploads/apqp_activity_document';
                    $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '',$file->getClientOriginalName());
                   
                    $filename = rand(11111, 99999) . '-' . $extension; 
                    
                    $upload_success = $file->move($destinationPath, $filename);

                    
                     DB::table('apqp_user_task_document')
                    ->insert(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'act_id' =>$tid,
                            'gate_id'   => $data1[0]->gate,
                    		'upload_doc'  =>$filename,
                    		'parameter' => $uploadNo,
                    		)
                    	);
                }
                }
           
                if (Input::hasFile($issuedoc)) {
       foreach($input[$issuedoc] as $file) {
        
         $destinationPath = 'uploads/apqp_issue_document';
                    $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '',$file->getClientOriginalName());
                   
                    $filename = rand(11111, 99999) . '-' . $extension; 
                    
                    $upload_success = $file->move($destinationPath, $filename);

                    
                     DB::table('apqp_activity_issue_document')
                    ->insert(
                      array(
                        'project_id' =>$pid,
                        'activity_id' =>$aid,
                        'act_id' =>$tid,
                            'gate_id'   => $data1[0]->gate,
                        'issue_document'  =>$filename,
                        'parameter' => $uploadNo,
                        )
                      );
                }
                }       
            exit();
	}
	public function userDetails(){
		$input=Input::all();
		
            
		 $aid=$input['aid'];
         // $aaid=explode('@', $input['aid']);
         // if($aaid=='a'){
         //    $aid=$aaid[1];
         // }else{
         //    $aid=$input['aid'];
         // }
		$pid=$input['pid'];
		$tid=$input['tid'];
		if(isset($input['asdate'])){
        		
                 $date1 = explode('/', $input['asdate']);
                 $cnt=count($date1);
                 if($cnt==3){
                     $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
                 }else{
                    $d_t=$input['asdate'];
                 }
              
    	}else{
    		$date='';
    	}
    	if(isset($input['cost'])){
        		$cost=$input['cost'];
    	}else{
    		$cost='';
    	}
    	
    	if(isset($input['risk'])){
        		$risk=$input['risk'];
    	}else{
    		$risk='';
    	}
    	if(isset($input['action'])){
        		$action=$input['action'];
    	}else{
    		$action='';
    	}
      if(isset($input['issue'])){
            $issue=$input['issue'];
      }else{
        $issue='';
      }
      if(isset($input['hour'])){
            $hour=$input['hour'];
      }else{
        $hour='';
      }
    	$data=DB::table('apqp_user_task_details')
    				->select('apqp_user_task_details.id')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                    ->where('act_id',$tid)
                    ->where('parameter',$input['Upload'])
                    ->get();

                    $data1=DB::table('apqp_all_task')
                    ->select('apqp_all_task.gate')
                    ->where('id',$tid)
                    ->get();
                

    	if(empty($data)){
    	 DB::table('apqp_user_task_details')
                     ->insert(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'act_id'	=>$tid,
                    		'actual_start_date'  =>$d_t,
                    		'gate_id'  => $data1[0]->gate,
                    		'risk'     =>$risk,
                    		'parameter'=> $input['Upload'],
                    		'action'  =>$action,
                    		'cost'    =>$cost,
                        	'hour'    =>$hour,
                        	'issue'  	    => $issue,
                    		'created_date' =>date('Y-m-d'),
                    		)
                    	);
    	}else{
    		DB::table('apqp_user_task_details')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                    ->where('act_id',$tid)
                    ->where('parameter',$input['Upload'])
                     ->update(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'actual_start_date'  =>$d_t,
                    		'created_date' =>date('Y-m-d'),
                    		'risk'     =>$risk,
                    		'action'     =>$action,
                    		'cost'     =>$cost,
                            'hour'    =>$hour,
                            'issue'   => $issue,
                    		)
                    	);
    	}
            exit();
	}

    public function getHodStatusAPQPTask() {

      
            $userId = Session::get('uid');
            \Log::info([
                "final userId" => $userId,
            ]);
        
            if ($userId == 1) {
                // Query specifically for userId == 1
                
        
            }
            
            return $pending_data;
            // Return an empty array if userId is not 1
            // return [];
        }
    }

                
       
//         $data = DB::select(DB::raw("
//             SELECT a.*, p.plant_code 
//             FROM apqp_new_project_info AS a 
//             LEFT JOIN plant_code AS p ON p.plant_id = a.mfg_location
//             WHERE 
//                 project_revision = (
//                     SELECT MAX(project_revision) 
//                     FROM apqp_new_project_info AS b 
//                     WHERE a.project_no = b.project_no
//                 )
//                 AND a.id NOT IN (
//                     SELECT project_id 
//                     FROM apqp_drop_project
//                 )
//                 AND a.flag = 1 
//                 AND a.release_flag = 1
//                 AND (
//                     a.id IN (
//                         SELECT project_id 
//                         FROM apqp_draft_project_plan 
//                         WHERE release_project = 0
//                     ) 
//                     OR a.id NOT IN (
//                         SELECT project_id 
//                         FROM apqp_draft_project_plan
//                     )
//                 )
//         "));
       

//         $pending_data = [];
        
//         foreach ($data as $key) {
//             $pending_data[] = array(
//                 'pending_project_id' => $key->id,
//                 'pending_project_no' => $key->project_no,
//                 'pending_project_name' => $key->project_name,
//                 'pending_project_manulocation' => $key->plant_code,
//                 'pending_project_startdate' => $key->project_start_date,
//             );
//         }

//         return $pending_data;
//     }
// }	

