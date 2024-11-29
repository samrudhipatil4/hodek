<?php



class CommonActGanttChart extends BaseModel {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_banner';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	function getProjectById($project_id){
		return DB::table('apqp_new_project_info')
            ->join('plant_code', 'plant_code.plant_id', '=', 'apqp_new_project_info.mfg_location')
            ->select('apqp_new_project_info.*', 'plant_code.plant_code', 'plant_code.description')
            ->where('apqp_new_project_info.id', $project_id)
            ->first();
			
	}
	public function getCheckHold($pid){
		  $checkHold = DB::table('apqp_new_project_info')
                  ->select('hold_project')
                  ->where('id', $pid)
                  ->get();
                  
                    if($checkHold[0]->hold_project == 1){
                      $hold= 'Is On Hold.';
                    }else{
                       $hold='';
                    }
                 
                  return $hold;
               
	}
	function projectEndDate($project_id){
		$data=  DB::table('apqp_draft_project_plan')
		 	->select(DB::raw('max(apqp_draft_project_plan.activity_end_date) as project_end_date'))
            ->where('project_id', $project_id)
            ->get();
            if(!empty($data)){
            	return $data[0]->project_end_date;
            }
           
	}
	public function getCheckDrop($pid){
		$data = DB::table('apqp_drop_project')
				->leftJoin('tb_users','tb_users.id','=','apqp_drop_project.drop_proj_user_id')
				->select('tb_users.first_name','tb_users.last_name','apqp_drop_project.remark')
				->where('project_id',$pid)
				->get();
				if(!empty($data)){
					return $data[0];
				}
	}

	public function getActivityDate($pid){
		$data= array(
			'T0SampleSub' => $this->getAllActDate($pid,18),
			'T1SampleSub' => $this->getAllActDate($pid,25),
			'pilotRun' 	  => $this->getAllActDate($pid,56),
			'T0SampleApp' => $this->getAllActDate($pid,21),
			'T1SampleApp' => $this->getAllActDate($pid,26), 

			);
		return $data;
	}

	public function getAllActDate($pid,$aid){
		$data = DB::table('apqp_user_task_details')
				->select('actual_end_date')
				->where('project_id',$pid)
				->where('activity_id',$aid)
				->get();
				if(!empty($data)){
					return $data[0]->actual_end_date;
				}

	}
	public function getLogo(){
		$data = DB::table('tb_logo')
				->select('logo_image')
				->get();
				if(!empty($data)){
					return $data[0]->logo_image;
				}
	}
	public function gettopApp($uid){
		$data = DB::table('tb_users')
				->select('first_name','last_name')
				->where('id',$uid)
				->get();
				if(!empty($data)){
					return $data[0]->first_name.' '.$data[0]->last_name;
				}
	}
	public function getCust($cid){
		$data = DB::table('customer') 
		        ->select('CustomerId','FirstName')
		        ->where('status','active')
		        ->where('CustomerId',$cid)
		        ->get();
				if(!empty($data)){
					return $data[0]->FirstName;
				}
	}
	

	function getProjectEndDate($project_id){
		return DB::table('apqp_draft_project_plan')
		 	->select('*')
            ->where('project_id', $project_id)
            ->orderBy('activity_end_date', 'DESC')
            ->first();
	}

	function getAllActivity($project_id){

		return DB::table('apqp_gate_management_master')
            ->join('apqp_draft_project_plan', 'apqp_gate_management_master.id', '=', 'apqp_draft_project_plan.gate_id')
            ->join('apqp_gate_activity_master', 'apqp_gate_activity_master.id', '=', 'apqp_draft_project_plan.activity')
            ->join('tb_departments', 'tb_departments.d_id', '=', 'apqp_draft_project_plan.department')
            ->select('apqp_draft_project_plan.*', 'apqp_gate_management_master.Gate_Description','apqp_gate_activity_master.activity as activityName','tb_departments.d_name as department_name')
            ->where('apqp_draft_project_plan.project_id', $project_id)
            ->orderBy('apqp_draft_project_plan.id','asc')
            ->where('apqp_gate_activity_master.activity_type','=','C')
            ->where('apqp_draft_project_plan.material_id',0)
            //->orderBy('apqp_gate_activity_master.sequence_no','apqp_gate_activity_master.gate_id','asc')
            ->get();

		//return $users = DB::table('apqp_draft_project_plan')->get();
	}

	public function getAtualActivityDetails($project_id,$activity_id,$draft_id){
		//echo $project_id.'|'.$activity_id;
		return DB::table('apqp_user_task_details')
           ->leftJoin('apqp_all_task','apqp_all_task.id','=','apqp_user_task_details.act_id')
            ->select('*')
            ->where('apqp_user_task_details.project_id', $project_id)
            ->where('apqp_user_task_details.activity_id', $activity_id)
            ->where('apqp_all_task.activity_id_as_per_drft',$draft_id)
            ->first();
            
	}

	function getProjectActualEndDate($project_id){
			return DB::table('apqp_user_task_details')
		 	->select('*')
            ->where('project_id', $project_id)
            ->orderBy('actual_end_date', 'DESC')
            ->first();
	}

	// // public function getAllActivity($project_id){
	// // 	return DB::table('apqp_gate_management_master')
 // //            ->join('apqp_draft_project_plan', 'apqp_gate_management_master.id', '=', 'apqp_draft_project_plan.gate_id')
 // //            ->join('apqp_gate_activity_master', 'apqp_gate_activity_master.id', '=', 'apqp_draft_project_plan.activity')
 // //            ->join('tb_departments', 'tb_departments.d_id', '=', 'apqp_draft_project_plan.department')
 // //            ->select('apqp_draft_project_plan.*', 'apqp_gate_management_master.Gate_Description','apqp_gate_activity_master.activity as activityName','apqp_gate_activity_master.previous_reference_activity as refActivity','tb_departments.d_name as department_name')
 // //            ->where('apqp_draft_project_plan.project_id', $project_id)
 // //            ->orderBy('apqp_draft_project_plan.id','asc')
 // //            ->get();
	// }

public function getAllRemark($activity_id){
		$remark =  DB::table('apqp_new_project_info as np')
				->Leftjoin('apqp_user_task_details as utd','utd.project_id', '=', 'np.id')
				->Leftjoin('apqp_gate_activity_master as gam','gam.id', '=', 'utd.activity_id')
				->select('np.id', 'utd.remark', 'utd.activity_id', 'gam.activity')
				->where('np.id',$activity_id)
				->get();
				return $remark;
	}

public function getUploadDoc($activity_id){
	return DB::table('apqp_new_project_info as np')
				->Leftjoin('apqp_user_task_document as utd','utd.project_id', '=', 'np.id')
				->Leftjoin('apqp_gate_activity_master as gam','gam.id', '=', 'utd.activity_id')
				->select('gam.id','utd.upload_doc', 'utd.activity_id', 'gam.activity')
				->where('np.id',$activity_id)
				->get();
				//dd($new);
    }

    public function respUser($project_id){
		// DB::enableQueryLog();
			$data= DB::table('apqp_draft_project_plan as dp')
				->Leftjoin('apqp_gate_activity_master as gm','dp.activity','=','gm.id')
				->Leftjoin('tb_users as u','dp.responsibility','=','u.id')
				->select('u.username','u.id','dp.responsibility','gm.activity AS activity_name ')
				->where('dp.project_id',$project_id)
				->get();
		// dd(DB::getQueryLog());
			return $data;
	}
	
public function getRefActivity(){
		$data = DB::select('SELECT a.id as activityID,a.previous_reference_activity as preActivityID,a.activity,(SELECT b.activity FROM apqp_gate_activity_master as b WHERE a.previous_reference_activity = b.id) AS refActivity FROM apqp_gate_activity_master as a
		');
		//dd($data);
		return $data;
	}
	public function getEnquiry($cid){
		$data = DB::table('customer_enquiry_form as cef')
					->Leftjoin('customer as c','cef.customer','=','c.CustomerId')
					->select('cef.*','c.FirstName')
					->where('customer',$cid)
					->get();
					// dd($data);
		return $data;
	}
	

}
