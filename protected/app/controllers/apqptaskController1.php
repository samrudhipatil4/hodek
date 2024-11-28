<?php
unset($_SESSION['btntype']);
class apqptaskController extends BaseController  {

	//protected $layout = "layouts.main";
	
	
	public function get_apqp_task()
	{
		 $query = DB::table('apqp_all_task')
		 		  ->leftJoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_all_task.activity')
		 		  ->leftJoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_all_task.project_id')
		 		  ->select('apqp_all_task.*','apqp_all_task.id as tid','apqp_all_task.activity as actid','apqp_gate_activity_master.activity as act','apqp_new_project_info.*')
		 		  ->where('close',0)
		 		  ->where('assigned_to',Session::get('uid'))
		 		  ->get();
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
		 		 			'pid'		=> $key->project_id,
		 		 			'aid'		=> $key->actid,
                            'gate_id'   =>  $key->gate,
		 		 			'proj_id' => $key->project_no,
		 		 			'proj_name' => $key->project_name,
		 		 			'activity'=>$act,
		 		 			'start_date'=>$key->activity_start_date,
		 		 			'end_date'=>$key->activity_end_date,
		 		 			'next_url' => $key->next_url
		 		 		);
		 		 }
		 		

		 		 return $data;

		
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
	public function submitTask($aid,$pid,$tid){
		$input=Input::all();
		


		if(isset($input['submitDocument'])){
			 if (Input::hasFile('doc')) {
			 	$imageNameArray=[];
			 foreach($input['doc'] as $file) {
			 	
			 	 $destinationPath = 'uploads/apqp_activity_document';
                    $extension = $file->getClientOriginalName();
                   
                    $filename = rand(11111, 99999) . '-' . $extension; 
                    
                    $upload_success = $file->move($destinationPath, $filename);
                     DB::table('apqp_user_task_document')
                    ->insert(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'act_id' =>$tid,
                    		'upload_doc'  =>$filename
                    		)
                    	);
                    
                }
                
            }
               return Redirect::back();
        }else{

        	DB::table('apqp_user_task_details')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                     ->update(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,

                    		'actual_start_date'  => date('Y-m-d', strtotime($input['startdate_status'])),
                    		
                    		'created_date' =>date('Y-m-d'),
                    		'actual_end_date' =>date('Y-m-d'),
                    		'risk'     =>$input['risk'],
                    		'action'     =>$input['action'],
                    		'cost'     =>$input['cost'],
                    		)
                    	);
        	
                      DB::table('apqp_all_task')
                    	->where('id',$tid)
                     	->update(
	                    	array(
	                    		'close' =>1,
	                    		)
	                    	);

                     
                     	  $depAct=DB::table('apqp_draft_project_plan')
                     	 ->select('apqp_draft_project_plan.*')
                    	->where('prev_reference_act',$aid)
                    	->where('project_id',$pid)
                     	->get();
            if(!empty($depAct)){
         foreach ($depAct as $key) {
     		$mailData[] = DB::table('apqp_draft_project_plan')
					->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
					->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
					->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_draft_project_plan.material_id')
					->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_draft_project_plan.project_id')
					->leftjoin('tb_users','tb_users.id','=','apqp_draft_project_plan.responsibility')
					->select('tb_users.email','tb_users.first_name','tb_users.last_name','apqp_draft_project_plan.*','apqp_gate_activity_master.activity as act','apqp_gate_management_master.Gate_Description','apqp_new_project_info.*','apqp_material_master.material_description')
					->where('apqp_draft_project_plan.activity',$key->id)
					->get();



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
								'close'		=>  0,
								
							)
					);
					
				}
			
				foreach ($mailData as $value) {
					if(!empty($value)){
					if($value[0]->material_description ==''){
						$mat='';
					}else{
						$mat=$value[0]->material_description;
					}
					$data_1 = array('proj_id'=>$value[0]->project_id,'proj_name'=>$value[0]->project_name,'gate_id'=>$value[0]->Gate_Description,'activity'=>$value[0]->act,'startdate'=>$value[0]->activity_start_date,'end_date'=>$value[0]->activity_end_date,'material'=>$mat,'first_name'=>$value[0]->first_name,'last_name'=>$value[0]->last_name);
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
			 $gate=DB::table('apqp_all_task')
                     	->select('gate')
                    	->where('id',$tid)
                     	->get();

                     	$checkgateAct=DB::table('apqp_all_task')
                     	->select('gate')
                    	->where('gate',$gate[0]->gate)
                    	->where('close',0)
                     	->get();
                     	if(empty($checkgateAct)){
                     		$pno=DB::table('apqp_draft_project_plan')
                     	 ->select('apqp_draft_project_plan.project_no')
                    	->where('project_id',$pid)
                     	->get();

                     	$gateclr=DB::table('apqp_gate_clearence_app_team')
                     	 ->select('apqp_gate_clearence_app_team.*')
                    	->where('project_id',$pno[0]->project_no)
                    	->where('gate_id',$gate[0]->gate)
                     	->get();


                     		$data1 = DB::table('apqp_all_task')
					->insert(
						array(
								'project_id'  		=> $pid,
								'assigned_to' 		=>  $gateclr[0]->user_id,
								
								'gate' =>$gate[0]->gate,
								'activity'=>'All gate activities are completed',
								'activity_start_date'=>'-',
								'activity_end_date'=>'-',
								'next_url' 		=>  'apqp/gateclearance',
								
								'status' =>2,
								'close'		=>  0,
								
							)
					);



                   $getuserDet=$this->getUserDet($gateclr[0]->user_id);
                   $data_1 = array('proj_id'=>$pno[0]->project_no,'gate_id'=>$gate[0]->gate,'first_name'=>$getuserDet[0]->first_name,'last_name'=>$getuserDet[0]->last_name,'msg'=>'All activities are completed');
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
        	return Redirect::to('apqp_dashboard');
		
		
	}

    public function getUserDet($id){
        $data=DB::table('tb_users')
                ->select('first_name','last_name','email')
                ->where('id',$id)
                ->get();
                return $data;
    }
	public function getFile($aid,$pid,$actid){
		$doc= DB::table('apqp_user_task_document')
                    ->select('apqp_user_task_document.*')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                    ->where('act_id',$actid)
                    ->get();
                    return $doc;
	}
	public function getTask($aid,$pid,$actid){
		$doc=[];
		$doc= DB::table('apqp_user_task_details')
                    ->select('apqp_user_task_details.*')
                    ->where('activity_id',$aid)
                      ->where('project_id',$pid)
                      ->where('act_id',$actid)
                    ->get();
                    if(!empty($doc)){
                    	return $doc;
                    }else{
                    	return $doc;
                    }
                }

    public function getTask1(){
        $input=Input::all();
        $doc= DB::table('apqp_user_task_details')
                    ->select('apqp_user_task_details.actual_start_date')
                    ->where('activity_id',$input['aid'])
                      ->where('project_id',$input['pid'])
                      ->where('act_id',$input['tid'])
                    ->get();
                    if(!empty($doc)){
                        return $doc;
                    }else{
                        return $doc;
                    }
                }
                    
	public function deleteUploadAttach($id,$filename){

		 DB::table('apqp_user_task_document')->where('id', $id)->delete();

            $filename = Config::get('app.site_root') . '/uploads/apqp_activity_document/' . $filename;
           

            if (File::exists($filename)) {
                File::delete($filename);
            }
            
	}
	public function fileUpload(){
		$input=Input::all();
		
             
		$aid=$input['aid'];
		$pid=$input['pid'];
		$tid=$input['tid'];
		
    	$data=DB::table('apqp_user_task_details')
    				->select('apqp_user_task_details.id')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                    ->where('act_id',$tid)
                    ->where('parameter',$input['Upload'])
                    ->get();

    	
    	
    	$doc = 'doc'.$input['Upload'];

		 

			 	if(empty($data)){
			 		if (Input::hasFile($doc)) {
			 foreach($input[$doc] as $file) {
			 	
			 	 $destinationPath = 'uploads/apqp_activity_document';
                    $extension = $file->getClientOriginalName();
                   
                    $filename = rand(11111, 99999) . '-' . $extension; 
                    
                    $upload_success = $file->move($destinationPath, $filename);

                    
                     DB::table('apqp_user_task_document')
                    ->insert(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'act_id' =>$tid,
                    		'upload_doc'  =>$filename,
                    		'parameter' => $input['Upload'],
                    		)
                    	);
                }
                }
                }else{
                	$fU=DB::table('apqp_user_task_document')->where('parameter', $input['Upload'])->get();

                	 DB::table('apqp_user_task_document')->where('parameter', $input['Upload'])->delete();

                	  
                	  foreach ($fU as $key) {
                	  	 $filename = Config::get('app.site_root') . '/uploads/apqp_activity_document/' .$key->upload_doc;
                	  	  if (File::exists($filename)) {
				                File::delete($filename);
				            }
                	  }

           
                	if (Input::hasFile($doc)) {

                     foreach($input[$doc] as $file) {
			 	
			 	 $destinationPath = 'uploads/apqp_activity_document';
                    $extension = $file->getClientOriginalName();
                   
                    $filename = rand(11111, 99999) . '-' . $extension; 
                    
                    $upload_success = $file->move($destinationPath, $filename);

                    
                     DB::table('apqp_user_task_document')
                    ->insert(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'act_id' =>$tid,
                    		'upload_doc'  =>$filename,
                    		'parameter' => $input['Upload'],
                    		)
                    	);
                }
                }
            }
                
                
            
            exit();
	}
	public function userDetails(){
		$input=Input::all();
		
            
		$aid=$input['aid'];
		$pid=$input['pid'];
		$tid=$input['tid'];
		if(isset($input['asdate'])){
        		
                 $date1 = explode('/', $input['asdate']);
                $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
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
    	$data=DB::table('apqp_user_task_details')
    				->select('apqp_user_task_details.id')
                    ->where('activity_id',$aid)
                    ->where('project_id',$pid)
                    ->where('act_id',$tid)
                    ->where('parameter',$input['Upload'])
                    ->get();
                

    	if(empty($data)){
    	 DB::table('apqp_user_task_details')
                     ->insert(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'act_id'	=>$tid,
                    		'actual_start_date'  =>$d_t,
                    		
                    		'risk'     =>$risk,
                    		'parameter' => $input['Upload'],
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
                    ->where('act_id',$tid)
                    ->where('parameter',$input['Upload'])
                     ->update(
                    	array(
                    		'project_id' =>$pid,
                    		'activity_id' =>$aid,
                    		'actual_start_date'  =>$d_t,
                    		'created_date' =>date('Y-m-d'),
                    		'actual_end_date' =>date('Y-m-d'),
                    		'risk'     =>$risk,
                    		'action'     =>$action,
                    		'cost'     =>$cost,
                    		)
                    	);
    	}
    	
    	
                
                
            
            exit();
	}

	

			
	
}	