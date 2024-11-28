<?php
class ProjectRevisionDateController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'ProjectRevisionDate';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new ProjectRevisionDate();

		$this->info = $this->model->makeInfo( $this->module);

		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'ProjectRevisionDate',
			'trackUri' 	=> $this->trackUriSegmented()	
		);
			
				
	} 

	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext',Lang::get('core.note_restric'))->with('msgstatus','error');
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'id'); 
		$order = (!is_null(Input::get('order')) ? Input::get('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
		// End Filter Search for query 
		
		// Take param master detail if any
		$master  = $this->buildMasterDetail(); 
		// append to current $filter
		$filter .=  $master['masterFilter'];
	
		
		$page = Input::get('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null(Input::get('rows')) ? filter_var(Input::get('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );		
		//echo '<pre>';print_r($results);exit();
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);		
		
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['details']		= $master['masterView'];
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		//echo '<pre>';print_r($this->data);exit();
		$this->layout->nest('content','ProjectRevisionDate.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}		
	

	function getAdd( $id = null)
	{
	
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',Lang::get('core.note_restric'))->with('msgstatus','error');
		}	
		
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
			
		$id = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;
		
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('apqp_project_revision_datechange'); 
		}
		/* Master detail lock key and value */
		if(!is_null(Input::get('md')) && Input::get('md') !='')
		{
			$filters = explode(" ", Input::get('md') );
			$this->data['row'][$filters[3]] = SiteHelpers::encryptID($filters[4],true); 	
		}
		/* End Master detail lock key and value */
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['filtermd'] = str_replace(" ","+",Input::get('md')); 		
		$this->data['id'] = $id;

		$this->layout->nest('content','ProjectRevisionDate.form',$this->data)->with('menus', $this->menus );	
	}
	
	function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
					
		$ids = (is_numeric($id) ? $id : SiteHelpers::encryptID($id,true)  );
		$row = $this->model->getRow($ids);
		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('apqp_hold_project'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','ProjectRevisionDate.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		$trackUri = $this->data['trackUri'];
		$rules = $this->validateForm();
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('apqp_new_project_info');
			
			//print_r($data);exit();
			$new_info=DB::table('apqp_new_project_info')
			      ->select('*')
			      ->where('id',$data['old_project_id'])
			      ->get();


			      foreach ($new_info as $value) {
			      	$projInfo = DB::table('apqp_new_project_info')
					->insert(
							array(
									'project_no'              => $value->project_no,
									'project_name'            => $value->project_name,
									'mfg_location'            => $value->mfg_location,
									'project_start_date' 	  => $value->project_start_date,
									'flag'                    => $value->flag,
									'hold_project'            => 0,
									'hold_proj_text'   		  => '',
									'document_no'     		  => $value->document_no,
									'top_mgt_approval'        => $value->top_mgt_approval,
									'sop_date'                => $value->sop_date,
									'cust_sop_date'           => $value->cust_sop_date,
									'project_revision'		  => $value->project_revision+1,
									'template'				  => $value->template
								)
						);
			      }
			      $last_id = DB::getPdo()->lastInsertId();

			      DB::table('apqp_project_revision_datechange')
			->insert(
					array(
							'old_project_id'          => $data['old_project_id'],
							'new_project_id'          => $last_id,
							'phase'                   => $data['phase'],
							'activity'            	  => $data['activity'],
							'activity_start_date' 	  =>date('Y-m-d', strtotime(str_replace('/','-',$data['activity_start_date']))),
							'activity_end_date'       => date('Y-m-d', strtotime(str_replace('/','-',$data['activity_end_date']))),
							'activity_new_start_date' => date('Y-m-d', strtotime(str_replace('/','-',$data['activity_new_start_date']))),
							'activity_new_end_date'   => date('Y-m-d', strtotime(str_replace('/','-',$data['activity_new_end_date']))),
							'remark'     			  => $data['remark'],
							'CreatedDate'             => date('Y-m-d H:i:s')
						)
				);
			      $draft=DB::table('apqp_draft_project_plan')
			      ->select('*')
			      ->where('project_id', $data['old_project_id'])
			      ->get();
			      foreach ($draft as $value) {
			      	$projInfo = DB::table('apqp_draft_project_plan')
					->insert(
							array(
									'project_id'           => $last_id,
									'project_no'           => $value->project_no,
									'gate_id'              => $value->gate_id,
									'project_start_date'   => $value->project_start_date,
									'activity'             => $value->activity,
									'lead_time'         => $value->lead_time,
									'prev_reference_act'   => $value->prev_reference_act,
									'department'   		   =>$value->department,
									'responsibility'       => $value->responsibility,
									'material_id'          => $value->material_id,
									'activity_start_date'  => $value->activity_start_date,
									'activity_end_date'    => $value->activity_end_date,
									'release_project'      => 0,
									'old_draft_id'		   => $value->id

								)
						);
			      }

			      if($data['activity'] != ""){
			      	DB::table('apqp_draft_project_plan')
			      	->where('project_id',$last_id)
			      	->where('activity',$data['activity'])
			      	->update(
		      			array(
		      					'activity_start_date' =>date('Y-m-d', strtotime(str_replace('/','-',$data['activity_new_start_date']))),
		      					'activity_end_date' =>date('Y-m-d', strtotime(str_replace('/','-',$data['activity_new_end_date']))),
		      				)
			      		);
			$NewEndDate=date('Y-m-d', strtotime(str_replace('/','-',$data['activity_new_end_date'])));
			$myDateTime = DateTime::createFromFormat('Y-m-d', $NewEndDate);
			$newDateString = $myDateTime->format('m/d/Y');

			      	$data =$this->checkprevDefine($data['activity'], $newDateString,$last_id);
			      }



			// Redirect after save	
			$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'ProjectRevisionDate/add/'.$id.'?md='.$md.$trackUri :  'ProjectRevisionDate?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('ProjectRevisionDate/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
	}

	public function checkprevDefine($act_id,$start_date,$pid){
		
		$prevDefine = DB::table('apqp_gate_activity_master')
					->select('apqp_gate_activity_master.*')
					->where('previous_reference_activity',$act_id)
					->get();
					
					if(!empty($prevDefine)){
						foreach ($prevDefine as $key) {
							$enddate=$this->calendDate($key->lead_time,$start_date);
				
							DB::table('apqp_draft_project_plan')
							->where('activity',$key->id)
							->where('project_id',$pid)
							->update(
									 array(
									 	'activity_start_date' =>date('Y-m-d', strtotime($start_date))  , 
									 	'activity_end_date' =>date('Y-m-d', strtotime($enddate))  , 
									 	)
								);
							
							$this->checkprevDefine($key->id,$enddate,$pid);
						}
					}
	}
	public function calendDate($lead_time,$sdate){
		
		$holidayDates =DB::table('apqp_holiday_master')
				->select('apqp_holiday_master.*')
				->get();
		$totcnt=$lead_time;
	 	$start_date=$sdate;
	 	
	 	$i = 0;
		while ($i < $totcnt) {
			
	 		$end=date('m/d/Y', strtotime($start_date. '+1 days'));
	 		$start_date=$end;
		 	$finDate = $end;
		 	 foreach($holidayDates as $day) {
		 		 if($day->holiday_date == $finDate){
		 		 	
		 		 	$totcnt++;
 		 	 		break;
		    	}
		 	}
	    $i++;
		 }
		 	$fin_date = $finDate;
		 	return $fin_date;
	}
	
	public function postDestroy()
	{
		
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
	
		if(count(Input::get('id')) >=1)
		{
			try{
			$this->model->destroy(Input::get('id'));
			}catch (Illuminate\Database\QueryException $e){
			    $errorCode = $e->errorInfo[1];
			    if($errorCode == 1451){

			    	
			
			       Session::flash('messagetext', 'Duplicate project code');	
				Session::flash('msgstatus','error');
				return Redirect::to('materialMaster');

			    }
			}

			//$this->model->destroy(Input::get('id'));
			$this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successfull");
			// redirect
			Session::flash('messagetext', Lang::get('core.note_success_delete'));	
			Session::flash('msgstatus','success');		
		} else {
			Session::flash('messagetext', 'No Item Deleted');	
			Session::flash('msgstatus','error');		
		}

		return Redirect::to('materialMaster?md='.Input::get('md'));
	}

	public function getPhase(){
		$input=Input::all();

		$data = DB::table('apqp_draft_project_plan')
				->leftJoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
				->select('Gate_Description','apqp_gate_management_master.id')
				->where('apqp_draft_project_plan.project_id',$input['pid'])
				->groupby('apqp_draft_project_plan.gate_id')
				->get();

		$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->Gate_Description.'</option>';
			}

		exit;
	}	
	public function getActivity(){
		$input=Input::all();

		// $data = DB::table('apqp_draft_project_plan')
		// 		->leftJoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
		// 		->select('apqp_gate_activity_master.activity','apqp_gate_activity_master.id')
		// 		->where('apqp_draft_project_plan.project_id',$input['pid'])
		// 		->where('apqp_draft_project_plan.gate_id',$input['phase'])
		// 		->groupby('apqp_draft_project_plan.activity')
		// 		->get();

		$data = DB::table('apqp_user_task_details')
          ->join('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_user_task_details.activity_id')
          ->select('apqp_gate_activity_master.id','apqp_gate_activity_master.activity')
          ->where('project_id',$input['pid'])
          ->where('apqp_gate_activity_master.gate_id',$input['phase'])
          ->groupby('apqp_user_task_details.activity_id')
          ->get();

		$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->activity.'</option>';
			}

		exit;
	}	

	public function getOldDate()	{
		$input = Input::all();
		$data = DB::table('apqp_draft_project_plan')
				->select('apqp_draft_project_plan.activity_start_date','apqp_draft_project_plan.activity_end_date')
				->where('apqp_draft_project_plan.project_id',$input['pid'])
				->where('apqp_draft_project_plan.gate_id',$input['phase'])
				->where('apqp_draft_project_plan.activity',$input['activity'])
				->get();

				return $data;
	}

	public function calNewEndDate(){
		$input = Input::all();
		$start_date=$input['start_date'];
		$lead_time = DB::table('apqp_gate_activity_master')
					->select('lead_time')
					->where('id',$input['activity'])
					->get();

					$k = 0;
					$totcnt=$lead_time[0]->lead_time;
	 		 		while ($k < $totcnt) {
	 		 		$end=date('m/d/Y', strtotime($start_date. '+1 days'));
	 		 		$start_date = $end;
			 		 	$finDate = $end;
					$k++;
				}
				return $finDate;
	}

	public function getRevisionPrj(){
		// $data= DB::table('apqp_new_project_info AS a')
		// 		->select('a.*')
		// 		->where('project_revision','=','DB::raw("(select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no")')
		// 		->whereIn('id',function($query){
		// 			$query->select ('project_id')->from ('apqp_draft_project_plan')->where ('release_project', 1);
		// 		})
		// 		->whereNotIn('id',function($query){
		// 			$query->select ('project_id')->from ('apqp_drop_project');
		// 		})
		// 		->get();

		$data =DB::select(DB::raw('select * from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1) '));
		//print_r($data);exit();
			$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->project_no.' Revision '.$key->project_revision.'</option>';
			}

		exit;
	}
	public function checkRevision(){
		$input=Input::all();
		$data=DB::table('apqp_new_project_info')
				->select('project_revision')
				->where('id',$input['pid'])
				->get();
				return 'Revision '.$data[0]->project_revision;
	}
		
}