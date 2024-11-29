<?php
class ProjectRevisionMaterialController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'ProjectRevisionMaterial';
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
			'pageModule'=> 'ProjectRevisionMaterial',
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
		$this->layout->nest('content','ProjectRevisionMaterial.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('apqp_project_revision_materialchange'); 
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

		$this->layout->nest('content','ProjectRevisionMaterial.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('apqp_project_revision_materialchange'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','ProjectRevisionMaterial.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		$trackUri = $this->data['trackUri'];
		$rules = $this->validateForm();
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('apqp_project_revision_materialchange');
			
			
			$new_info=DB::table('apqp_project_revision_materialchange')
			      ->select('*')
			      ->where('old_project_id',$data['old_project_id'])
			      ->get();

			      if(empty($new_info)){
			      		Session::flash('messagetext', 'Material not changed');	
				Session::flash('msgstatus','error');
				return Redirect::to('ProjectRevisionMaterial/add/'.$id);
			      }else{
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

			      DB::table('apqp_project_revision_materialchange')
			      ->where('old_project_id',$data['old_project_id'])
					->update(
							array(
									
									'new_project_id'          => $last_id,
									'remark'     			  => $data['remark'],
									'CreatedDate'             => date('Y-m-d H:i:s')
								)
							);

					$newMat= DB::table('apqp_project_revision_materialchange')
			      ->where('old_project_id',$data['old_project_id'])
			      ->get();
			      	$revNo=DB::table('apqp_new_project_info')
			      ->select('*')
			      ->where('id',$last_id)
			      ->get();
			      foreach($newMat as $mat){
			      	 DB::table('apqp_project_material')
			      	->insert(
						array(
							'material_id' =>$mat->new_material,
							'release_project'=>0,
							'project_revision'=>$revNo[0]->project_revision,
							'project_id'=>$revNo[0]->project_no
							)
						);
			      }

					
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
			       foreach($newMat as $mat){
			       	DB::table('apqp_draft_project_plan')
			       	->where('project_id',$last_id)
			       	->where('material_id',$mat->old_material)
			       	->update(
			       			array(
			       					'material_id' =>$mat->new_material
			       				)
			       		);
			       }

			      



			// Redirect after save	
			$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'ProjectRevisionMaterial/add/'.$id.'?md='.$md.$trackUri :  'ProjectRevisionMaterial?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
		}
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('ProjectRevisionMaterial/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
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

	

	public function getMaterialProj(){
		

		$data =DB::select(DB::raw('select id,project_no,project_revision from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1) '));
		return $data;
	}
	public function checkRevision(){
		$input=Input::all();
		$data=DB::table('apqp_new_project_info')
				->select('project_revision')
				->where('id',$input['pid'])
				->get();
				return 'Revision '.$data[0]->project_revision;
	}
	public function getProjMaterial($pid){
			$newMat = DB::table('apqp_project_revision_materialchange')
				->select('old_project_id')
				->where('new_project_id',$pid)
				->get();

				if(empty($newMat)){
				
				$pno = DB::table('apqp_new_project_info')
					->select('project_no','project_revision')
					->where('id',$pid)
					->get();
					$revNo = DB::table('apqp_project_material')
					->select(DB::raw('max(project_revision) as rev'))
					->where('project_id',$pno[0]->project_no)
					->get();
				
				if(!empty($pno)){
					$data = DB::table('apqp_project_material')
					->leftJoin('apqp_material_master','apqp_project_material.material_id','=','apqp_material_master.id')
					->select('apqp_material_master.id','apqp_material_master.material_description','apqp_material_master.commodity')
					->where('apqp_project_material.project_id',$pno[0]->project_no)
				   ->where('apqp_project_material.project_revision',$revNo[0]->rev)
					->get();
				return $data;
				}
			}else{
				$mat = DB::table('apqp_project_revision_materialchange')
				->leftJoin('apqp_material_master','apqp_project_revision_materialchange.new_material','=','apqp_material_master.id')
					->select('apqp_material_master.id','apqp_material_master.material_description','apqp_material_master.commodity')
					->where('apqp_project_revision_materialchange.new_project_id',$pid)
					->get();
					return $mat;
			}
		
	}
	public function getNewMaterial($commodity){
		$data=DB::table('apqp_material_master')
				->select('apqp_material_master.id','apqp_material_master.material_description')
				->where('commodity',$commodity)
				->whereNotIn('id',function($query){
					$query->select ('material_id')->from ('apqp_project_material');
				})
				->get();
				if(!empty($data)){
					return $data;
				}
				
	}
	public function saveNewMaterial(){
		$input =Input::all();
		$newMat = DB::table('apqp_project_revision_materialchange')
				->select('old_project_id')
				->where('old_project_id',$input['project_no'])
				->get();
				if(empty($newMat)){
					$newMatid = DB::table('apqp_project_revision_materialchange')
							->select('new_project_id','new_material')
							->where('new_project_id',$input['project_no'])
							->get();

					$pno = DB::table('apqp_new_project_info')
						->select('project_no','project_revision')
						->where('id',$input['project_no'])
						->get();
					if(!empty($newMatid)){
						foreach($newMatid as $d){
								DB::table('apqp_project_revision_materialchange')
								->insert(
									array(
											'old_project_id' =>$input['project_no'],
											 'old_material'   => $d->new_material,
											 'new_material'        => $d->new_material
										)
									);
								}
								DB::table('apqp_project_revision_materialchange')
								->where('old_project_id',$input['project_no'])
								->where('old_material',$input['old_mat_id'])
								->update(
										array(
												'new_material'   => $input['new_mat']
											)
									);
					}else{
						if(!empty($pno)){
							$data = DB::table('apqp_project_material')
							
							->select('apqp_project_material.material_id')
							->where('apqp_project_material.project_id',$pno[0]->project_no)
							->get();
							foreach($data as $d){
								DB::table('apqp_project_revision_materialchange')
								->insert(
									array(
											'old_project_id' =>$input['project_no'],
											 'old_material'   => $d->material_id,
											 'new_material'        => $d->material_id
										)
									);
								}
								DB::table('apqp_project_revision_materialchange')
								->where('old_project_id',$input['project_no'])
								->where('old_material',$input['old_mat_id'])
								->update(
										array(
												'new_material'   => $input['new_mat']
											)
									);
							}
						
					
					}
				}else{
					// foreach($newMat  as $n){
					// 		DB::table('apqp_project_revision_materialchange')
					// 		->insert(
					// 				array(
					// 						'old_project_id' =>$input['project_no'],
					// 						'old_material'   => $n->old_material,
					// 						'new_material'        => $n->old_material
					// 					)
					// 			);
					// 		}
					try{
							DB::table('apqp_project_revision_materialchange')
							->where('old_project_id',$input['project_no'])
							->where('new_material',$input['old_mat_id'])
							->update(
									array(
											'new_material'   => $input['new_mat']
										)
								);
						}catch (Illuminate\Database\QueryException $e){

						    $errorCode = $e->errorInfo[1];
						    if($errorCode == 1062){
						    	echo '0';exit();
						    }
							}
				}
				$data = DB::table('apqp_project_revision_materialchange')
					->leftJoin('apqp_material_master','apqp_project_revision_materialchange.new_material','=','apqp_material_master.id')
					->select('apqp_material_master.id','apqp_material_master.material_description','apqp_material_master.commodity')
					->where('apqp_project_revision_materialchange.old_project_id',$input['project_no'])
					->get();
				return $data;
	}
		
}