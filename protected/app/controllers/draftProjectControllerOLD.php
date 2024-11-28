<?php
class draftProjectController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'draftProjectPlan';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new draftProject();
		$this->info = $this->model->makeInfo( $this->module);

		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'draftProjectPlan',
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
		$this->layout->nest('content','draftProject.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('apqp_draft_project_plan'); 
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
		
		$this->layout->nest('content','draftProject.form',$this->data)->with('menus', $this->menus );	
	}
	function postCreate( $id = null)
	{
		
		$input = Input::all();
		
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
			$this->data['row'] = $this->model->getColumnTable('apqp_draft_project_plan'); 
		}
		
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['filtermd'] = str_replace(" ","+",Input::get('md')); 		
		$this->data['id'] = $id;
		$this->data['project_id']=$input['proj_no'];
		$this->data['proj_name']=$input['proj_name1'];
		$this->data['proj_start_date']=$input['date'];
		
		$this->layout->nest('content','draftProject.create',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('apqp_draft_project_plan'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','commodityMaster.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		
		$input = Input::all();
		$data=DB::table('apqp_new_project_info')
		->leftjoin('apqp_project_gate','apqp_project_gate.project_id','=','apqp_new_project_info.project_no')
		->select('apqp_project_gate.*')
		->where('apqp_new_project_info.id',$input['proj_no'])
		->get();
		
		foreach ($data as $key) {

		$data1[] = array(
				'activity' => $this->getActivity($key->gate_id),
			);
		}


		$this->layout->nest('content','draftProject.form',$data1)->with('menus', $this->menus );
	
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
				return Redirect::to('newProject');

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

		return Redirect::to('CommodityMaster?md='.Input::get('md'));
	}

		
	
	
	
	public function getPrj(){
		$data =DB::select(DB::raw('select * from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) and a.flag=1 and (a.id IN(select project_id from apqp_draft_project_plan where release_project= 0 ) or a.id  NOT IN(select project_id from apqp_draft_project_plan )) '));

		// $data= DB::table('apqp_new_project_info')
		// 		->select('apqp_new_project_info.*')
		// 		->where('flag',1)
		// 		->get();
			$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->project_no.' Revision '.$key->project_revision.'</option>';
			}

		exit;
	}
	public function getProjectInfo(){
		$input = Input::all();
		
		$data= DB::table('apqp_new_project_info')
				->leftjoin('plant_code','plant_code.plant_id','=','apqp_new_project_info.mfg_location')
				->select('apqp_new_project_info.project_no','apqp_new_project_info.project_name','plant_code.plant_code','apqp_new_project_info.project_start_date')
				->where('flag',1)
				->where('id',$input['proj_no'])
				->get();
				echo json_encode($data);exit();
	}
	public function saveProject(){

		$input = Input::all();
		
		
		$prjAvl = DB::table('apqp_draft_project_plan')
				  ->select('apqp_draft_project_plan.*')
				  ->where('project_id',$input['proj_no'])
				  ->get();

				
		if(!empty($prjAvl)){
			echo '<table align="center" border="1" width="100%" id="project_plan">
							<tr>
								<td>SR.NO.</td>
								<td width="5%">Gate No</td>
								<td width="20%">Gate</td>
								<td width="20%">Activity</td>
								<td width="5%">Lead Time</td>
								<td width="5%">Budget Cost</td>
								<td width="20%">Responsibility</td>
								<td width="15%">Activity Start Date</td>
								<td width="15%">Activity End Date</td>
								<td id="action" style="display:none">Action</td>
							</tr>';
							$i1=1;
							 	$j=1;
							 	
							 	$pregate ='';
							 	$premat='';
							 	$pgate = '';
								foreach ($prjAvl as $value) {
									$ngate = $value->gate_id;
									if($ngate != $pgate){
										$i2 = 1;
								echo '<tr><td  colspan="6" style="font-weight:bold;">Gate '.$value->gate_id.'</td></tr>';	
								}
								$pgate = $ngate;

							 	if($value->material_id == 0){
							 		
							 		echo '<tr><td>'.$j.'</td><td width="10%">'.$value->gate_id.'.'.$i2.'</td>
							 	
								<td width="20%">'. $this->getGateName($value->gate_id).'</td>
								<td width="20%">'; 
								
								if (strpos($value->activity, 'a') !== false) {
									echo $this->getActName($value->activity);
								}else{
								echo $this->getActivityName($value->activity);
							}

							

								echo '</td><td width="5%">'.$value->lead_time.'
									<input type="text" onkeydown="return numeric(event);" name="editlead" id="editlead'.$j.'" style="display:none;width:100px">
								</td>
								<td width="5%">'; if($value->cost != 0){ echo $value->cost;} echo '<input type="text" onkeydown="return numeric(event);" name="costperact" id="costperact'.$j.'" style="display:none;width:100px"></td>';

								echo '<td width="20%" id="noUpdate'.$j.'" >';
								$user_id = explode(',', $value->responsibility);
								
								foreach ($user_id as $key) {
								
								echo $this->getuserName($key);
								 }
								 echo '</td><td width="20%" id="Update'.$j.'" style="display:none">';
								 echo "<select width='150px'   name='dept_user'  id='dept_user".$j."' rows='5'  
							  required  >";
							$getallDept = $this->DeptUser($value->responsibility);

							foreach ($getallDept as $key1) {
								echo '<option value="'.$key1->id.'"  ';foreach ($user_id as $key) { if($key1->id==$key){
									echo 'selected';
								} }
									echo' >'.$key1->first_name.' '.$key1->last_name.'</option>';
								
							
							}
							echo "</select>";
								echo'</td>';
								echo'<td width="15%" id="calNo'.$j.'">';
								
									
									echo date('d-m-Y',strtotime($value->activity_start_date));
									
								
								echo '</td>';
								echo '<td width="15%" id="calYes'.$j.'" style="display:none">';
									echo '<script>
									$("#startdate'.$j.'").datepicker();  

									</script>';
									echo date('d-m-Y',strtotime($value->activity_start_date));
									echo '<input type="text" id="startdate'.$j.'" placeholder="date" style="width:100px">';
								
								echo '</td>';
								echo'<td width="15%" id="calendNo'.$j.'">';
								
									echo date('d-m-Y',strtotime($value->activity_end_date));
								
								echo '</td>';
								
								echo '<td id="updateBut'.$j.'" style="display:none"><button  name="submit" id="updateProject"  > Update</button></td><input type="hidden" id="activeId'.$j.'" style="display:none" value="'.$value->activity.'"><input type="hidden" id="prjId'.$j.'" style="display:none" value="'.$value->id.'"></tr>';
								$i2++;
								$j++;
								
							 	}else{
							 		$newgate = $value->gate_id;
							 		$newmat = $value->material_id;
							 		if($newgate != $pregate || $newmat != $premat){
							 		echo '<tr><td colspan="2"></td><td colspan=4 style="font-weight:bold;"><div>'.$this->getMatName($value->material_id).'</div></td></tr>';
							 	} $pregate=$newgate;
							 		$premat=$newmat;

							 			echo '<tr><td>'.$j.'</td><td width="5%">'.$value->gate_id.'.'.$i2.'</td>
							 	
								<td width="20%">'. $this->getGateName($value->gate_id).'</td>
								<td width="20%">'; 
								if (strpos($value->activity, 'a') !== false) {
									echo $this->getActName($value->activity);
								}else{
								echo $this->getActivityName($value->activity);
							}


								echo '</td><td width="5%">'.$value->lead_time.'
								<input type="text" onkeydown="return numeric(event);" name="editlead" id="editlead'.$j.'" style="display:none;width:100px">
								</td>
								<td width="5%">'; if($value->cost != 0){ echo $value->cost;} echo '<input type="text" onkeydown="return numeric(event);" name="costperact" id="costperact'.$j.'" style="display:none;width:100px"></td>
								';

								echo '<td width="20%" id="noUpdate'.$j.'" >';
								$user_id = explode(',', $value->responsibility);
								
								foreach ($user_id as $key) {
								
								echo $this->getuserName($key);
								 }
								 echo '</td><td width="20%" id="Update'.$j.'" style="display:none">';
								  echo "<select width='150px'   name='dept_user'  id='dept_user".$j."' rows='5'  
							  required  >";
							$getallDept = $this->DeptUser($value->responsibility);

							foreach ($getallDept as $key1) {
								echo '<option value="'.$key1->id.'"  ';foreach ($user_id as $key) { if($key1->id==$key){
									echo 'selected';
								} }
									echo' >'.$key1->first_name.' '.$key1->last_name.'</option>';
								
							
							}
							echo "</select>";	 
								echo'</td>';
								echo'<td width="15%" id="calNo'.$j.'">';
								
									echo date('d-m-Y',strtotime($value->activity_start_date));
								
								echo '</td>';
								echo '<td width="15%" id="calYes'.$j.'" style="display:none">';
									echo '<script>
									$("#startdate'.$j.'").datepicker();  

									</script>';
									echo date('d-m-Y',strtotime($value->activity_start_date));
									echo '<input type="text" id="startdate'.$j.'" placeholder="date" style="width:100px">';
								
								echo '</td>';
								echo'<td width="15%" id="calendNo'.$j.'">';
								
									echo date('d-m-Y',strtotime($value->activity_end_date));
								
								echo '</td>';
								
								
								echo '<td id="updateBut'.$j.'" style="display:none"><button  name="submit" id="updateProject"  > Update</button></td>
									<input type="hidden" id="activeId'.$j.'" style="display:none" value="'.$value->activity.'"><input type="hidden" id="prjId'.$j.'" style="display:none" value="'.$value->id.'"></tr>';
								$i2++;
								$j++;
							 	}
							 }
		}else{
		$data=DB::table('apqp_new_project_info')
		->leftjoin('apqp_project_gate','apqp_project_gate.project_id','=','apqp_new_project_info.project_no')
		->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_project_gate.gate_id')
		->select('apqp_project_gate.*','apqp_gate_management_master.Gate_Description','apqp_new_project_info.project_no','apqp_new_project_info.template')
		->where('apqp_new_project_info.id',$input['proj_no'])
		->orderBy('apqp_gate_management_master.id')
		->get();

		foreach ($data as $allGate) {
			$_SESSION['sesProjtNo'] = $allGate->project_no;
			$getAllAct[]=$this->getAllAct($allGate->gate_id,$allGate->template);
		}

		
		$allact=[];
		$r=0;
		foreach ($getAllAct as $value) {
				foreach ($value as $key) {
				$allact[$r] = $key;
					$r++;
				}
			}
			
			$final = [];
			$j=0;
			
			while(!empty($allact)) {
			foreach ($allact as $key=>$value) {
					
				if($value->previous_reference_activity==''){
					
 		 		$holidayDates =DB::table('apqp_holiday_master')
				->select('apqp_holiday_master.*')
				->get();

				
	 		 		$k = 0;
	 		 		$totcnt=$value->lead_time;
	 		 		
	 		 		$start_date=$input['date'];
	 		 		while ($k < $totcnt) {
		 		 		$value->start_date=$input['date'];

			 		 	$end=date('m/d/Y', strtotime($start_date. '+1 days'));
			 		 	$start_date = $end;
			 		 	$finDate = $end;
			 		 	
			 		 	foreach($holidayDates as $day) {
			 		 		 if($day->holiday_date == $finDate){
			 		 		 	$totcnt++;
				 		 	 	break;
						    }
			 		 	}
					     $k++;
					}
		 		 
		 		 	$value->end_date=$finDate;
			 		 	$final[$j]=$value;
			 		 	$j++;
 		 		
 		 		unset($allact[$key]);
 		 		
	 		 	}
	 		 	else{

	 		 		foreach ($final as $key1) {
	 		 	 if($value->previous_reference_activity==$key1->id){

	 		 $holidayDates =DB::table('apqp_holiday_master')
				->select('apqp_holiday_master.*')
				->get();
	 		 		$i = 0;
	 		 		$totcnt=$value->lead_time;
	 		 		$start_date1=$key1->end_date;
	 		 		while ($i < $totcnt) {
		 		 		$value->start_date=$key1->end_date;
			 		 	$end=date('m/d/Y', strtotime($start_date1. '+1 days'));
			 		 	$start_date1=$end;
			 		 	$finDate = $end;
			 		 	 foreach($holidayDates as $day) {
			 		 		 if($day->holiday_date == $finDate){
			 		 		 	$totcnt++;
				 		 	 	break;
						    }
			 		 	}
					    $i++;
		 		 	}
		 		 	$value->end_date=$finDate;
			 		 	$final[$j]=$value;
			 		 	$j++;
		 		 	unset($allact[$key]);
		 		 	break;
		 		 }
	 		 	}
 
	 		 }

	 	 }
	 	
 		}
 		//echo'<pre>';print_r($final);exit();
 		// echo '<pre>';print_r($final);
	 	//echo '<pre>';print_r($allact);exit();
		echo '<table align="center" border="1" width="100%" id="project_plan">
							<tr>
								<td>SR.NO.</td>
								<td width="5%">Gate No</td>
								<td width="20%">Gate</td>
								<td width="20%">Activity</td>
								<td width="5%">Lead Time</td>
								<td width="5%">Budget Cost </td>
								<td width="20%">Responsibility</td>
								<td width="15%">Activity Start Date</td>
								<td width="15%">Activity End Date</td>
								<td id="action" style="display:none">Action</td>
							</tr>';

							 		$i1=1;
							 	$j=1;

							foreach ($data as $key) {
								
 								if(!empty($key)){
 								$i2=1;
								$commact = $this->getActivity($key->gate_id,'C',$key->template);
								
								echo '<tr><td  colspan="6" style="font-weight:bold;">Gate '.$key->gate_id.'</td></tr>';

									$mat='C';
							 	foreach ($commact as $value) {

							 		$getUser=$this->getUser($value->responsible_department,$_SESSION['sesProjtNo']);
							 		echo '<tr><td>'.$j.'</td><td width="10%">'.$i1.'.'.$i2.'</td>
								<td width="20%">'.  $value->Gate_Description.'</td>';
								echo '<td width="20%">'; 
								echo $value->activity;
								echo '</td>
								<td width="5%">'.$value->lead_time.'</td>
								<td width="5%"></td>
								<td width="20%">';
								if(!empty($getUser)){
								 foreach($getUser as $key3){
								 	 echo $key3[0]->first_name.' '.$key3[0]->last_name;
									}
								}
								echo'</td>';
								echo'<td width="15%">';
								foreach ($final as $fin){
								if($fin->id==$value->id){
									
									echo date('d-m-Y',strtotime($fin->start_date));
								
								echo '</td>
								<td width="15%">'.date('d-m-Y',strtotime($fin->end_date)).'</td>';
									}
								}
								echo '<td style="display:none">'.$value->previous_reference_activity.'</td><td style="display:none">'.$value->id.'</td><td style="display:none">'.$value->responsible_department.'</td><td style="display:none">'.$key->gate_id.'</td><td style="display:none">'.$mat.'</td><td style="display:none">';
								if(!empty($getUser)){
								 foreach($getUser as $key9){
								 	 echo $key9[0]->id.',';
								 	}
								}
								echo '</td><td id="updateBut'.$j.'" style="display:none"><button  name="submit" id="updateProject"  > Update</button></td></tr>';
								$i2++;
								$j++;
							 	}

							 	$mat = DB::table('apqp_project_material')
								->select('apqp_project_material.*')
								->where('apqp_project_material.project_id','=',$_SESSION['sesProjtNo'])
								->get();

								foreach ($mat as $key5) {
									
									$comm[] = DB::table('apqp_material_master')
								->select('apqp_material_master.material_description','apqp_material_master.commodity','apqp_material_master.id as mat_id')
								->where('apqp_material_master.id','=',$key5->material_id)
								->distinct('apqp_material_master.id')
								->get();
								}
									if(!empty($comm)){
								foreach ($comm as $key1) {
								
								
								$commact = $this->getAct($key->gate_id,$key1[0]->commodity,$key1[0]->mat_id,$key->template);
								if(!empty($commact)){ echo '<tr><td colspan="2"></td><td colspan=4 style="font-weight:bold;"><div>'.$key1[0]->material_description.'</div></td></tr>';
								}
							 	foreach ($commact as $value) {

		$getUser=$this->getUser($value->responsible_department,$_SESSION['sesProjtNo']);

							 		echo '<tr><td>'.$j.'</td><td width="5%">'.$i1.'.'.$i2.'</td>
								<td width="20%">'.  $value->Gate_Description.'</td>';

								echo '<td width="20%">'; 
								echo $value->activity;
								echo '</td><td width="5%">'.$value->lead_time.'</td>
								<td width="5%"></td>
								<td width="20%">';

								if(!empty($getUser)){
									$l=0;
								 foreach($getUser as $key8){
								 	if($l==0){
								 	 echo $key8[0]->first_name.' '.$key8[0]->last_name;
								 	}else{
								 		echo ','.$key8[0]->first_name.' '.$key8[0]->last_name;
								 	}
								 	$l++;
									}
								}
								echo'</td>';
								echo '<td width="15%">';

								foreach ($final as $fin){
								if($fin->id==$value->id && $fin->material == $value->material){
									echo date('d-m-Y',strtotime($fin->start_date));
								
								echo '</td>
								<td width="15%">'.date('d-m-Y',strtotime($fin->end_date)).'</td>';
									}
								}
								echo '<td style="display:none">'.$value->previous_reference_activity.'</td><td style="display:none">'.$value->id.'</td><td style="display:none">'.$value->responsible_department.'</td>
								<td style="display:none">'.$key->gate_id.'</td><td style="display:none">'.$key1[0]->mat_id.'</td><td style="display:none">';
								if(!empty($getUser)){
								 foreach($getUser as $key9){
								 	 echo $key9[0]->id.',';
								 	}
								}
								echo '</td><td id="updateBut'.$j.'" style="display:none"><button  name="submit" id="updateProject"  > Update</button></td></tr>';
								$i2++;
								$j++;
							 	}
							 
							}
						  }
							unset($comm);
							
							 	$i1++;
							 }
							 	
							 }
							 	
					
						echo '</table>';

		}
		
						exit();

	}
	public function getActName($act){
		
		$data = DB::table('apqp_activity_as_per_project')
				->select('pactivity')
				->where('p_act_id',$act)
				->get();
				
				return $data[0]->pactivity;
	}
	public function getMatName($mat_id){
		$data = DB::table('apqp_material_master')
				->select('material_description')
				->where('id',$mat_id)
				->get();
				return $data[0]->material_description;
	}
	public function getGateName($gate_id){
		$data = DB::table('apqp_gate_management_master')
				->select('apqp_gate_management_master.Gate_Description')
				->where('id',$gate_id)
				->get();
				return $data[0]->Gate_Description;
	}
	public function getActivityName($act){
		$data = DB::table('apqp_gate_activity_master')
				->select('apqp_gate_activity_master.activity')
				->where('apqp_gate_activity_master.active',1)
				->where('id',$act)
				->get();
				return $data[0]->activity;
	}
	public function DeptUser($id){
	
	
		$data = DB::table('tb_users')
				->select('tb_users.department')
				->where('id',$id)
				->get();

				$data1 = DB::table('tb_users')
				->select('tb_users.*')
				->where('department',$data[0]->department)
				->get();
				return $data1;

	}

	public function getUserName($id){
		if($id != ''){
		$data = DB::table('tb_users')
				->select('tb_users.first_name','tb_users.last_name','tb_users.id')
				->where('id',$id)
				->get();
				return $data[0]->first_name.' '.$data[0]->last_name;
			}
	}
	
	public function getUser($dept,$projNo){
		
		$data = DB::table('apqp_project_dept_User')
				->select('apqp_project_dept_User.user_id')
				->where('apqp_project_dept_User.dept_id',$dept)
				->where('apqp_project_dept_User.project_id',$projNo)
				->get();
				$data1=[];
				if(!empty($data)){
				foreach ($data as $key) {
					$id= explode(',', $key->user_id);
					foreach ($id as $value) {
					$data1[]= DB::table('tb_users')
						->select('tb_users.id','tb_users.first_name','tb_users.last_name')
						->where('tb_users.id',$value)
						->get();
					}
				}
			}
			
				return $data1;
				
	}
	public function getActivity($gate,$type,$temp){
		$data = DB::table('apqp_gate_activity_master')
				->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_gate_activity_master.gate_id')
				->select('apqp_gate_activity_master.*','apqp_gate_management_master.Gate_Description')
				->where('gate_id',$gate)
				->where('activity_type','=',$type)
				->where('apqp_gate_activity_master.active',1)
				->where('apqp_gate_activity_master.template',$temp)
				->orderBy('sequence_no','asc')
				->get();
				
				return $data;
				
	}
	public function getAct($gate,$comm,$mat,$temp){
		$data = DB::table('apqp_gate_activity_master')
				->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_gate_activity_master.gate_id')
				->leftjoin('apqp_material_master','apqp_material_master.commodity','=','apqp_gate_activity_master.commodity')
				->select('apqp_gate_activity_master.*','apqp_gate_management_master.Gate_Description','apqp_material_master.id as material')
				->where('apqp_gate_activity_master.gate_id',$gate)
				->where('apqp_gate_activity_master.commodity',$comm)
				->where('apqp_gate_activity_master.activity_type','=','M')
				->where('apqp_material_master.id',$mat)
				->where('apqp_gate_activity_master.active',1)
				->where('apqp_gate_activity_master.template',$temp)
				->orderBy('apqp_gate_activity_master.sequence_no','asc')
				->get();
				return $data;
	}
	public function getAllAct($gate,$temp){
		
		$mat = DB::table('apqp_project_material')
			->select('apqp_project_material.*')
			->where('apqp_project_material.project_id','=',$_SESSION['sesProjtNo'])
			->get();
			$commodity = [];
		if(!empty($mat)){
			foreach ($mat as $key5) {
				
				$comm[] = DB::table('apqp_material_master')
			->select('apqp_material_master.material_description','apqp_material_master.commodity','apqp_material_master.id as mat_id')
			->where('apqp_material_master.id','=',$key5->material_id)
			->distinct('apqp_material_master.id')
			->get();

			}
			
			foreach ($comm as $key1) {

				$data[] = DB::table('apqp_gate_activity_master')
						->leftjoin('apqp_material_master','apqp_material_master.commodity','=','apqp_gate_activity_master.commodity')
						->select('apqp_gate_activity_master.*',DB::raw('"" as start_date'),DB::raw('"" as end_date'),'apqp_material_master.id as material')
						->where('apqp_gate_activity_master.gate_id',$gate)
						->where('apqp_gate_activity_master.commodity',$key1[0]->commodity)
						->where('apqp_gate_activity_master.activity_type','=','M')
						->where('apqp_material_master.id',$key1[0]->mat_id)
						->where('apqp_gate_activity_master.template',$temp)
						->where('apqp_gate_activity_master.active',1)
						->get();
			}

			$r=0;
			$commodity = [];
			foreach($data as $val){
				foreach($val as $key){
					$commodity[$r] = $key;
					$r++;
				}
				
			}
		}
			//echo 'temp'.$temp;
			//echo '<pre>';print_r($comm);exit();

			$Common = DB::table('apqp_gate_activity_master')
				->select('apqp_gate_activity_master.*',DB::raw('"" as start_date'),DB::raw('"" as end_date'),'apqp_gate_activity_master.commodity as material')
				->where('apqp_gate_activity_master.gate_id',$gate)
				->where('apqp_gate_activity_master.activity_type','=','C')
				->where('apqp_gate_activity_master.active',1)
				->where('apqp_gate_activity_master.template',$temp)
				->orderBy('apqp_gate_activity_master.activity_type')
				//->union($commodity)
				->get();
				
				return array_merge($commodity,$Common);
				 //$Common;
				
	}
	public function checkDate(){
		$input = Input::all();

		$data =DB::table('apqp_holiday_master')
				->select('apqp_holiday_master.*')
				->get();
				foreach ($data as $key) {
					if ( strtotime($input['date']) == strtotime($key->holiday_date)){
						echo 'same';
						break;
					}
				}
				
				exit();
	}

	public function checkAllCondForGenDraft(){
		$input = Input::all();


		$data= DB::table('apqp_project_gate')
				->select('apqp_project_gate.*')
				->where('project_id',$input['proj_id'])
				->get();
		$temp = DB::table('apqp_new_project_info')			
				->select('template')
				->where('id',$input['proj_no'])
				->get();
				$Cond1='commAct';
				$Cond2='commdityAct';
				$Cond3='userDept';
				$Cond4= 'clrs';
		if($Cond1 == 'commAct'){
			
			//foreach ($data as $key){
				$allact = DB::table('apqp_gate_activity_master')
						->select('apqp_gate_activity_master.*')
						//->where('gate_id',$key->gate_id)
						->where('activity_type','C')
						->where('active',1)
						->where('template',$temp[0]->template)
						->get();
						if(empty($allact)){
							echo 'noact';break;
						}
			//}
		}if($Cond2=='commdityAct'){
			
				$data1 = DB::table('apqp_project_material')
						->select('apqp_project_material.*')
						->where('project_id','=',$input['proj_id'])
						->get();
					
						$mat=[];
				foreach ($data1 as  $value) {

					$mat[] = DB::table('apqp_material_master')
					->select('apqp_material_master.*')
					->where('apqp_material_master.id','=',$value->material_id)
					->get();
				}

				foreach ($mat as  $value1) {

					
						
					$comm = DB::table('apqp_gate_activity_master')
					->select('apqp_gate_activity_master.*')
					->where('template','=',$temp[0]->template)
					->where('activity_type','M')
					->where('commodity',$value1[0]->commodity)
					->where('active',1)
					->get();
					if(empty($comm)){
						echo 'commodity';break;
					
					}
				}
			
		}

		if($Cond3=='userDept'){
		$check = DB::table('apqp_project_dept_User')
						->select('apqp_project_dept_User.id','apqp_project_dept_User.dept_id')
						->where('apqp_project_dept_User.project_id','=',$input['proj_id'])
						->get();

		$act = DB::table('apqp_gate_activity_master')
			 ->select('apqp_gate_activity_master.responsible_department')
			 ->where('template',$temp[0]->template)
			 ->get();
			 

		foreach($act as $aV){
				$aTmp1[] = $aV->responsible_department;
			}

		foreach($check as $aV){
			$aTmp2[] = $aV->dept_id;
		}

		$result=array_diff($aTmp1,$aTmp2);

		if(!empty($result)){
			echo 'noUser';exit();
		}
	}

		if($Cond4=='clrs'){
			foreach ($data as $key) {
				$data1 = DB::table('apqp_gate_clearence_app_team')
						->select('user_id')
						->where('gate_id',$key->gate_id)
						->where('project_id','=',$input['proj_id'])
						->get();
						if(empty($data1)){
							echo'noclr';break;
						}
			}
		}
		exit();
		                                      

	}
	public function checkProjRel(){
		$input = Input::all();

		$data1 = DB::table('apqp_draft_project_plan')
				->select('apqp_draft_project_plan.project_id')
				->where('apqp_draft_project_plan.project_id',$input['allData'][0]['proj_id'])
				->get();
			
		if(!empty($data1)){
			echo 'exist';exit();
		}
		exit();
	}
	public function getProjUser($id){
		$data = DB::table('tb_users')
				->select('tb_users.first_name','tb_users.last_name')
				->where('tb_users.id',$id)
				->get();
				if(!empty($data)){
					return $data[0]->first_name.' '.$data[0]->last_name;
				}
	}
	public function getProjActivity($id){
		$data = DB::table('apqp_gate_activity_master')
				->select('apqp_gate_activity_master.activity')
				->where('apqp_gate_activity_master.id',$id)
				->get();
				if(!empty($data)){
					return $data[0]->activity;
				}
	}

	public function checkinvolvmentofuser(){
		$input = Input::all();
$alluser =[];
$allinvolveuser=[];
		$checkrel=DB::table('apqp_draft_project_plan')
				->select('release_project')
				//->where('release_project',1)
				->where('project_id',$input['projId'])
				->get();
			if(empty($checkrel)){
					foreach ($input['allData'] as $key) {
			$alluser[] =str_replace(',', '', $key['res']);
		}	
		
			}else{
				$user = DB::select(DB::raw("SELECT distinct(replace(responsibility,',','')) as res FROM apqp_draft_project_plan where project_id=".$input['projId']));
				foreach ($user as $key) {
			$alluser[] =str_replace(',', '', $key->res);
		}	
			}
		//echo '<pre>';print_r($alluser);exit();
			 $data =DB::select(DB::raw('select id from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  
and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1) order by id '));

	foreach ($data as $key) {
		$resuser = implode( "," , array_unique($alluser));
		
		$checkuserInvolment[] = DB::select(DB::raw('select distinct(replace(responsibility,",","")) as res,project_id,project_no,activity from apqp_draft_project_plan where activity not in (select activity from apqp_all_task where close=1 and project_id='.$key->id.') and  project_id='.$key->id.' and responsibility in('.$resuser.') order by project_id,responsibility'  ));
			}
			//print_r(array_filter($checkuserInvolment));exit();
			foreach (array_filter($checkuserInvolment) as $value1) {
			
				foreach ($value1 as $key) {
					$allinvolveuser[] = array(
						'project_id' =>$key->project_no,
						'user'     => $this->getProjUser($key->res),
						'activity' => $this->getProjActivity($key->activity)
						);
					}
			}
			return $allinvolveuser;
	}
	public function genDraftProj(){
		$input = Input::all();
		

		$checkRev = DB::table('apqp_new_project_info')
					->select('project_revision')
					->where('id',$input['projId'])
					->get();

	if($checkRev[0]->project_revision != 0 && isset($input['genproject'])){


		$getActivity = DB::table('apqp_project_revision_datechange')
					->select('apqp_project_revision_datechange.*')
					->where('new_project_id',$input['projId'])
					->get();


		if(!empty($getActivity)){

		$alltask= DB::table('apqp_all_task')
				  ->select('*')
				  ->where('project_id',$getActivity[0]->old_project_id)
				  ->get();
		foreach($alltask as $task){
			DB::table('apqp_all_task')
			->insert(
				array(
						'assigned_to'            => $task->assigned_to,
						'department'             =>$task->department,
						'project_id'             =>$input['projId'],
						'activity'               =>$task->activity,
						'activity_id_as_per_drft'=>$task->activity_id_as_per_drft,
						'gate'                   =>$task->gate,
						'prev_refer_act'         =>$task->prev_refer_act,
						'activity_start_date'    =>$task->activity_start_date,
						'activity_end_date'      =>$task->activity_end_date,
						'next_url'               =>$task->next_url,
						'status'                 =>$task->status,
						'close'                  =>$task->close,
						'CreatedDate'            =>date('Y-m-d H:i:s'),
					)
			);
		}

		DB::table('apqp_all_task')			
		->where('project_id',$getActivity[0]->old_project_id)
		->update(array(
				'close' => 1
			));

		DB::table('apqp_all_task')			
		->where('project_id',$getActivity[0]->new_project_id)
		->where('activity',$getActivity[0]->activity)
		->update(array(
				'close' => 0
			));
		DB::table('apqp_all_task')			
		->where('project_id',$getActivity[0]->new_project_id)
		->where('status',2)
		->where('gate',$getActivity[0]->phase)
		->update(array(
				'close' => 1
			));
		

		
		DB::table('apqp_draft_project_plan')			
		->where('project_id',$getActivity[0]->new_project_id)
		
		->update(array(
				'release_project' => 1
			));


		$alltaskDetails= DB::table('apqp_user_task_details')
				  ->select('*')
				  ->where('project_id',$getActivity[0]->old_project_id)
				  ->get();


		foreach($alltaskDetails as $det){
			DB::table('apqp_user_task_details')
			->insert(
				array(
						'project_id'            =>$input['projId'],
						'activity_id'           =>$det->activity_id,
						'act_id'             	=>$det->act_id,
						'parameter'             =>$det->parameter,
						'gate_id'          		=>$det->gate_id,
						'actual_start_date'     =>$det->actual_start_date,
						'cost'         			=>$det->cost,
						'risk'    				=>$det->risk,
						'action'      			=>$det->action,
						'created_date'          =>$det->created_date,
						'actual_end_date'       =>$det->actual_end_date,
						'remark'                =>$det->remark,
						
					)
			);
		}

		$alltaskDoc= DB::table('apqp_user_task_document')
				  ->select('*')
				  ->where('project_id',$getActivity[0]->old_project_id)
				  ->get();
		foreach($alltaskDoc as $doc){
		
			$imageNameArray = array();
			$extension =  $doc->upload_doc;

                    $filename = 'Rev'.$checkRev[0]->project_revision. '-' . $extension; 

                 
				    $file ='uploads/apqp_activity_document/'.$doc->upload_doc;
				$newfile = 'uploads/apqp_activity_document/'.$filename;
				 if (File::exists($file)) {
					if (!copy($file, $newfile)) {
				   echo "failed to copy";  
				}
				}
				
                

			DB::table('apqp_user_task_document')
			->insert(
				array(
						'project_id'            =>$input['projId'],
						'activity_id'           =>$doc->activity_id,
						'act_id'             	=>$doc->act_id,
						'gate_id'          		=>$doc->gate_id,
						'upload_doc'            =>$filename,
						'updated_doc_remark'	=>$doc->updated_doc_remark,
						'updated_date'			=>$doc->updated_date,
						'parameter'         	=>$doc->parameter
					)
			);
		}
		DB::table('apqp_user_task_details')			
		->where('project_id',$getActivity[0]->new_project_id)
		->where('activity_id',$getActivity[0]->activity)
		->update(array(
				'actual_start_date'     =>'0000-00-00',
				'actual_end_date'       =>'0000-00-00',
			));
		$allact= $this->checkDependant($getActivity[0]->activity,$input['projId']);

		$alltaskUpdate= DB::table('apqp_all_task')
				  ->select('*')
				  ->where('project_id',$input['projId'])
				  ->get();

		foreach($alltaskUpdate as $task){
			$old_draft_id=DB::table('apqp_all_task')
					->select('id')
					->where('project_id',$getActivity[0]->old_project_id)
					->where('activity',$task->activity)
					->where('activity_id_as_per_drft',$task->activity_id_as_per_drft)
					->get();

				
			DB::table('apqp_user_task_details')
			->where('project_id',$input['projId'])
			->where('activity_id',$task->activity)
			->where('act_id',$old_draft_id[0]->id)
			->update(
				array(
						'act_id' => $task->id,
						
						
					)
			);
			DB::table('apqp_user_task_document')
			->where('project_id',$input['projId'])
			->where('activity_id',$task->activity)
			->where('act_id',$old_draft_id[0]->id)
			->update(
				array(
						'act_id' => $task->id,
						
					)
			);
		}
		

		$draftPlan = DB::table('apqp_draft_project_plan')
					->where('project_id',$input['projId'])
					->get();
		
		foreach($draftPlan as $plan ){
			
			DB::table('apqp_all_task')
			->where('project_id',$input['projId'])
			->where('activity',$plan->activity)
			->where('activity_id_as_per_drft',$plan->old_draft_id)
			->update(
				array(
						'activity_id_as_per_drft' => $plan->id,
						'activity_start_date'     => $plan->activity_start_date,
						'activity_end_date'       => $plan->activity_end_date,
						'assigned_to'			  => $plan->responsibility
					)
			);
		}


		$user = DB::select(DB::raw("SELECT distinct(replace(responsibility,',','')) as res FROM apqp_draft_project_plan where project_id=".$input['projId']));
				$pid= $input['projId'];
				//echo '<pre>';print_r($user);exit();
				foreach($user as $u){
					$user= $u->res;
					$mailData = [];
					$mailData[] = DB::table('apqp_draft_project_plan')
									->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
									->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
									->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_draft_project_plan.material_id')
									->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_draft_project_plan.project_id')
									->leftjoin('tb_users','tb_users.id','=','apqp_draft_project_plan.responsibility')
									
									->select('tb_users.email','tb_users.first_name','tb_users.last_name','apqp_draft_project_plan.*','apqp_gate_activity_master.activity as act','apqp_gate_management_master.Gate_Description','apqp_new_project_info.*','apqp_material_master.material_description')
								  ->where('apqp_draft_project_plan.project_id',$input['projId'])
								  ->whereIN('apqp_draft_project_plan.responsibility',[$u->res.',',$u->res])
								 ->whereNotIn('apqp_draft_project_plan.activity',function($query) use($pid,$user){
										$query->select ('activity')->from ('apqp_all_task')->where('close',1)->where('project_id',$pid)->where('assigned_to',$user);
									})
								  
								  	->get();

								  	

									$data_1 = [];
									if(!empty($mailData)){
									foreach($mailData as $activity){
										foreach($activity as $act){
										
										$data_1[] = array('gate_id'=>$act->Gate_Description,'activity'=>$act->act,'startdate'=>date('d-m-Y', strtotime($act->activity_start_date)),'end_date'=>date('d-m-Y', strtotime($act->activity_end_date)),'material'=>$act->material_description);
								$email = $act->email;
								$proj_id =$act->project_no;
								$proj_name=$act->project_name;
								$name = $act->first_name.' '.$act->last_name;
								$remark = $getActivity[0]->remark;
								$revision = $act->project_revision;
									}
								}
							}
							if(!empty($data_1)){
								$data_2 = array('proj_id' =>$proj_id,'proj_name'=>$proj_name,'name'=>$name,'data1'=>$data_1,'remark'=>$remark,'revision'=>$revision);
								
			                    Mail::send('apqpEmails/ProjRevInfoEmail', $data_2, function ($message) use ($email) {
			                        $message->to($email)->subject('Project Revision Information Mail');
			                    });
			                }
			                 
							}
				}else{
					$matRevision = DB::table('apqp_project_revision_materialchange')
									->select('apqp_project_revision_materialchange.new_project_id','apqp_project_revision_materialchange.old_project_id','apqp_project_revision_materialchange.remark')
									->where('apqp_project_revision_materialchange.new_project_id',$input['projId'])
									->first();

					$matRevisionAct = DB::table('apqp_material_revision_activity')
									->select('apqp_material_revision_activity.activity')
									->where('apqp_material_revision_activity.project_id',$input['projId'])
									->orderBy('apqp_material_revision_activity.activity','asc')
									->get();

				if(!empty($matRevision)){
					$alltask= DB::table('apqp_all_task')
				  ->select('*')
				  ->where('project_id',$matRevision->old_project_id)
				  ->get();

		foreach($alltask as $task){
			DB::table('apqp_all_task')
			->insert(
				array(
						'assigned_to'            => $task->assigned_to,
						'department'             =>$task->department,
						'project_id'             =>$input['projId'],
						'activity'               =>$task->activity,
						'activity_id_as_per_drft'=>$task->activity_id_as_per_drft,
						'gate'                   =>$task->gate,
						'prev_refer_act'         =>$task->prev_refer_act,
						'activity_start_date'    =>$task->activity_start_date,
						'activity_end_date'      =>$task->activity_end_date,
						'next_url'               =>$task->next_url,
						'status'                 =>$task->status,
						'close'                  =>$task->close,
						'CreatedDate'            =>date('Y-m-d H:i:s'),
					)
			);
		}

		DB::table('apqp_all_task')			
		->where('project_id',$matRevision->old_project_id)
		->update(array(
				'close' => 1
			));

		foreach($matRevisionAct as $act){
		DB::table('apqp_all_task')			
		->where('project_id',$matRevision->new_project_id)
		->where('activity',$act->activity)
		->update(array(
				'close' => 0
			));
	}
		DB::table('apqp_all_task')			
		->where('project_id',$matRevision->new_project_id)
		->where('status',2)
		
		->update(array(
				'close' => 1
			));
		

		
		DB::table('apqp_draft_project_plan')			
		->where('project_id',$matRevision->new_project_id)
		
		->update(array(
				'release_project' => 1
			));


		$alltaskDetails= DB::table('apqp_user_task_details')
				  ->select('*')
				  ->where('project_id',$matRevision->old_project_id)
				  ->get();


		foreach($alltaskDetails as $det){
			DB::table('apqp_user_task_details')
			->insert(
				array(
						'project_id'            =>$input['projId'],
						'activity_id'           =>$det->activity_id,
						'act_id'             	=>$det->act_id,
						'parameter'             =>$det->parameter,
						'gate_id'          		=>$det->gate_id,
						'actual_start_date'     =>$det->actual_start_date,
						'cost'         			=>$det->cost,
						'risk'    				=>$det->risk,
						'action'      			=>$det->action,
						'created_date'          =>$det->created_date,
						'actual_end_date'       =>$det->actual_end_date,
						'remark'                =>$det->remark,
						
					)
			);
		}

		$alltaskDoc= DB::table('apqp_user_task_document')
				  ->select('*')
				  ->where('project_id',$matRevision->old_project_id)
				  ->get();
		foreach($alltaskDoc as $doc){
		
			$imageNameArray = array();
			$extension =  $doc->upload_doc;

                    $filename = 'Rev'.$checkRev[0]->project_revision. '-' . $extension; 

                 
				    $file ='uploads/apqp_activity_document/'.$doc->upload_doc;
				$newfile = 'uploads/apqp_activity_document/'.$filename;
				 if (File::exists($file)) {
					if (!copy($file, $newfile)) {
				   echo "failed to copy";  
				}
				}
				
                

			DB::table('apqp_user_task_document')
			->insert(
				array(
						'project_id'            =>$input['projId'],
						'activity_id'           =>$doc->activity_id,
						'act_id'             	=>$doc->act_id,
						'gate_id'          		=>$doc->gate_id,
						'upload_doc'            =>$filename,
						'parameter'         	=>$doc->parameter
					)
			);
		}
		foreach($matRevisionAct as $a){
		DB::table('apqp_user_task_details')			
		->where('project_id',$matRevision->new_project_id)
		->where('activity_id',$matRevisionAct[0]->activity)
		->update(array(
				'actual_start_date'     =>'0000-00-00',
				'actual_end_date'       =>'0000-00-00',
			));
		$allact= $this->materialcheckDependant($a->activity,$input['projId']);
	}

		$alltaskUpdate= DB::table('apqp_all_task')
				  ->select('*')
				  ->where('project_id',$input['projId'])
				  ->get();

		foreach($alltaskUpdate as $task){
			$old_draft_id=DB::table('apqp_all_task')
					->select('id')
					->where('project_id',$matRevision->old_project_id)
					->where('activity',$task->activity)
					->where('activity_id_as_per_drft',$task->activity_id_as_per_drft)
					->get();

				
			DB::table('apqp_user_task_details')
			->where('project_id',$input['projId'])
			->where('activity_id',$task->activity)
			->where('act_id',$old_draft_id[0]->id)
			->update(
				array(
						'act_id' => $task->id,
					)
			);
			DB::table('apqp_user_task_document')
			->where('project_id',$input['projId'])
			->where('activity_id',$task->activity)
			->where('act_id',$old_draft_id[0]->id)
			->update(
				array(
						'act_id' => $task->id,
						
					)
			);
		}
		

		$draftPlan = DB::table('apqp_draft_project_plan')
					->where('project_id',$input['projId'])
					->get();
		
		foreach($draftPlan as $plan ){
			
			DB::table('apqp_all_task')
			->where('project_id',$input['projId'])
			->where('activity',$plan->activity)
			->where('activity_id_as_per_drft',$plan->old_draft_id)
			->update(
				array(
						'activity_id_as_per_drft' => $plan->id,
						'activity_start_date'     => $plan->activity_start_date,
						'activity_end_date'       => $plan->activity_end_date,
						'assigned_to'			  => $plan->responsibility
					)
			);
		}


		$user = DB::select(DB::raw("SELECT distinct(replace(responsibility,',','')) as res FROM apqp_draft_project_plan where project_id=".$input['projId']));
				$pid= $input['projId'];
				//echo '<pre>';print_r($user);exit();
				foreach($user as $u){
					$user= $u->res;
					$mailData = [];
					$mailData[] = DB::table('apqp_draft_project_plan')
									->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
									->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
									->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_draft_project_plan.material_id')
									->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_draft_project_plan.project_id')
									->leftjoin('tb_users','tb_users.id','=','apqp_draft_project_plan.responsibility')
									
									->select('tb_users.email','tb_users.first_name','tb_users.last_name','apqp_draft_project_plan.*','apqp_gate_activity_master.activity as act','apqp_gate_management_master.Gate_Description','apqp_new_project_info.*','apqp_material_master.material_description')
								  ->where('apqp_draft_project_plan.project_id',$input['projId'])
								  ->whereIN('apqp_draft_project_plan.responsibility',[$u->res.',',$u->res])
								 ->whereNotIn('apqp_draft_project_plan.activity',function($query) use($pid,$user){
										$query->select ('activity')->from ('apqp_all_task')->where('close',1)->where('project_id',$pid)->where('assigned_to',$user);
									})
								  
								  	->get();

								  	

									$data_1 = [];
									if(!empty($mailData)){
									foreach($mailData as $activity){
										foreach($activity as $act){
										
										$data_1[] = array('gate_id'=>$act->Gate_Description,'activity'=>$act->act,'startdate'=>date('d-m-Y', strtotime($act->activity_start_date)),'end_date'=>date('d-m-Y', strtotime($act->activity_end_date)),'material'=>$act->material_description);
								$email = $act->email;
								$proj_id =$act->project_no;
								$proj_name=$act->project_name;
								$name = $act->first_name.' '.$act->last_name;
								$remark = $matRevision->remark;
								$revision = $act->project_revision;
									}
								}
							}
							if(!empty($data_1)){
								$data_2 = array('proj_id' =>$proj_id,'proj_name'=>$proj_name,'name'=>$name,'data1'=>$data_1,'remark'=>$remark,'revision'=>$revision);
								
			                    Mail::send('apqpEmails/ProjRevInfoEmail', $data_2, function ($message) use ($email) {
			                        $message->to($email)->subject('Project Revision Information Mail');
			                    });
			                }
			                 
							}
						}

				}			
	}else{

		$data1 = DB::table('apqp_draft_project_plan')
				->select('apqp_draft_project_plan.*')
				->where('apqp_draft_project_plan.project_id',$input['projId'])
				->get();

		$checkrel=DB::table('apqp_draft_project_plan')
				->select('release_project')
				->where('release_project',1)
				->where('project_id',$input['projId'])
				->get();

			if(isset($input['genproject'])){
				if(empty($data1)){
				foreach ($input['allData'] as $key) {
			
			$data = DB::table('apqp_draft_project_plan')
					->insert(
						array(
								'project_id'  		=> $key['proj_id'],
								'project_no' 		=>  $key['proj_no'],
								'gate_id'		=>  $key['gate'],
								'project_start_date'=>   date('Y-m-d', strtotime($key['proj_start_date'])),
								'lead_time'         => $key['lead_time'],
								'activity'  		=> $key['act'],
								'cost'  		=>$key['cost'],
								'department'		=> $key['dept'],
								'responsibility' 		=>  $key['res'],
								'material_id'		=>  $key['mat_id'],
								'activity_start_date'=>  date('Y-m-d', strtotime($key['act_start_date'])),
								'activity_end_date'=>  date('Y-m-d', strtotime($key['act_end_date'])),
								'prev_reference_act'=>$key['prev_ref_act'],
								'release_project'	=> 1
							)
					);
				}

				$draftdata = DB::table('apqp_draft_project_plan')
				->select('apqp_draft_project_plan.*')
				->where('apqp_draft_project_plan.project_id',$input['projId'])
				->get();


			
			foreach ($draftdata as $key) {

					DB::table('apqp_project_material')
					->where('project_id',$key->project_no)
					->where('material_id',$key->material_id)
					->update(['release_project'=>1]);
			
					if($key->prev_reference_act == ''){

						$data1 = DB::table('apqp_all_task')
					->insert(
						array(
								'project_id'  		=> $key->project_id,
								'assigned_to' 		=>  $key->responsibility,
								'department'		=>  $key->department,
								'activity'=>  $key->activity,
								'gate' =>$key->gate_id,
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
					}
				}
			}else{
				
				
				foreach ($data1 as $key) {

					$mailData[] = DB::table('apqp_draft_project_plan')
									->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
									->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
									->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_draft_project_plan.material_id')
									->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_draft_project_plan.project_id')
									->leftjoin('tb_users','tb_users.id','=','apqp_draft_project_plan.responsibility')
									->select('tb_users.email','tb_users.first_name','tb_users.last_name','apqp_draft_project_plan.*','apqp_gate_activity_master.activity as act','apqp_gate_management_master.Gate_Description','apqp_new_project_info.*','apqp_material_master.material_description')
									->where('apqp_draft_project_plan.id',$key->id)
									->get();


					DB::table('apqp_project_material')
					->where('project_id',$key->project_no)
					->where('material_id',$key->material_id)
					->update(['release_project'=>1]);
					
					if($key->prev_reference_act == '' && empty($checkrel)){
						
						$data1 = DB::table('apqp_all_task')
					->insert(
						array(
								'project_id'  		=> $key->project_id,
								'assigned_to' 		=>  $key->responsibility,
								'department'		=>  $key->department,
								'activity'=>  $key->activity,
								'gate' =>$key->gate_id,
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

			DB::table('apqp_draft_project_plan')
              ->where('project_id',$input['projId'])
              ->update(
                  array('release_project' => 1,
                   
                )
              );
					}
				}
			}
				if(empty($checkrel)){
						$user = DB::select(DB::raw("SELECT distinct(replace(responsibility,',','')) as res FROM apqp_draft_project_plan where project_id=".$input['projId']));
				
				foreach($user as $u){
					$mailData = [];
					$mailData[] = DB::table('apqp_draft_project_plan')
									->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
									->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
									->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_draft_project_plan.material_id')
									->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_draft_project_plan.project_id')
									->leftjoin('tb_users','tb_users.id','=','apqp_draft_project_plan.responsibility')
									->select('tb_users.email','tb_users.first_name','tb_users.last_name','apqp_draft_project_plan.*','apqp_gate_activity_master.activity as act','apqp_gate_management_master.Gate_Description','apqp_new_project_info.*','apqp_material_master.material_description')
								  ->where('apqp_draft_project_plan.project_id',$input['projId'])
								  ->whereIN('apqp_draft_project_plan.responsibility',[$u->res.',',$u->res])
								  	->get();

									$data_1 = [];
									foreach($mailData as $activity){
										foreach($activity as $act){
										
										$data_1[] = array('gate_id'=>$act->Gate_Description,'activity'=>$act->act,'startdate'=>date('d-m-Y', strtotime($act->activity_start_date)),'end_date'=>date('d-m-Y', strtotime($act->activity_end_date)),'material'=>$act->material_description);
								$email = $act->email;
								$proj_id =$act->project_no;
								$proj_name=$act->project_name;
								$revision = $act->project_revision;
								$name = $act->first_name.' '.$act->last_name;
									}
								}

								$data_2 = array('proj_id' =>$proj_id,'proj_name'=>$proj_name,'revision'=>$revision,'name'=>$name,'data1'=>$data_1);
								
			                    Mail::send('apqpEmails/InfoEmail', $data_2, function ($message) use ($email) {
			                        $message->to($email)->subject('Information Mail');
			                    });
			               
			                
							}
						}
			}else{

			
				if(!empty($data1)){
					echo 'exist';exit();
				}else{
					foreach ($input['allData'] as $key) {
					$data = DB::table('apqp_draft_project_plan')
					->insert(
						array(
								'project_id'  		=> $key['proj_id'],
								'project_no' 		=>  $key['proj_no'],
								'gate_id'		=>  $key['gate'],
								'project_start_date'=>   date('Y-m-d', strtotime($key['proj_start_date'])),
								'lead_time'         => $key['lead_time'],
								'activity'  		=> $key['act'],
								'department'		=> $key['dept'],
								'responsibility' 		=>  $key['res'],
								'material_id'		=>  $key['mat_id'],
								'activity_start_date'=>  date('Y-m-d', strtotime($key['act_start_date'])),
								'activity_end_date'=>  date('Y-m-d', strtotime($key['act_end_date'])),
								'prev_reference_act'=>$key['prev_ref_act'],
								'release_project'	=>0,

							)
					);
					}
				}
			}
	}

	
		exit();
	}
	public function checkDependant($act_id,$pid){
		
		$prevDefine = DB::table('apqp_draft_project_plan')
					->select('apqp_draft_project_plan.*')
					->where('project_id',$pid)
					->where('prev_reference_act',$act_id)
					->get();
					
					 if(!empty($prevDefine)){
						foreach ($prevDefine as $key) {

							DB::table('apqp_user_task_details')			
							->where('project_id',$pid)
							->where('activity_id',$key->activity)
							->update(array(
									'actual_start_date'     =>'0000-00-00',
									'actual_end_date'       =>'0000-00-00',
								));

							DB::table('apqp_all_task')
							->where('project_id',$pid)
							->where('activity',$key->activity)
							->delete();
							
							$this->checkDependant($key->activity,$pid);
							
						}
						
					}
					
					
	}

	public function materialcheckDependant($act_id,$pid){
		
		$prevDefine = DB::table('apqp_gate_activity_master')
					->select('apqp_gate_activity_master.*')
					->where('previous_reference_activity',$act_id)
					->get();
					
					 if(!empty($prevDefine)){
						foreach ($prevDefine as $key) {

							DB::table('apqp_user_task_details')			
							->where('project_id',$pid)
							->where('activity_id',$key->id)
							->update(array(
									'actual_start_date'     =>'0000-00-00',
									'actual_end_date'       =>'0000-00-00',
								));

							DB::table('apqp_all_task')
							->where('project_id',$pid)
							->where('activity',$key->id)
							->delete();
							
							$this->materialcheckDependant($key->id,$pid);
							
						}
						
					}
					
					
	}

	public function updateProjectDet(){
		$input = Input::all();
		
				
		
		$data = DB::table('apqp_draft_project_plan')
				->select('apqp_draft_project_plan.*')
				->where('activity',$input['aid'])
				->where('id',$input['pid'])
				->get();
				
				DB::table('apqp_draft_project_plan')
				->where('id',$input['pid'])
				->update(
						 array(
						 	'responsibility'	=>$input['user'],
						 	)
					);
				DB::table('apqp_draft_project_plan')
				->where('id',$input['pid'])
				->update(
						 array(
						 	'cost'	=>$input['cost'],
						 	)
					);
				if($input['sdate'] != ''){

				$matRev= DB::table('apqp_project_revision_materialchange')
				->select('id')
				->where('new_project_id',$input['proj_id'])
				->get();
					if(!empty($matRev)){
						$matRevAct= DB::table('apqp_material_revision_activity')
							    ->select('id')
							    ->where('project_id',$input['proj_id'])
							    ->where('activity',$input['aid'])
							    ->get();
					    if(empty($matRevAct)){
					    	DB::table('apqp_material_revision_activity')
								->insert(
									array(
											'project_id' => $input['proj_id'],
											'activity'   => $input['aid']
									    )
									 );
					    }
						
					}


				if($input['lead_time'] != ''){
					$lead_time = $input['lead_time'];
				}else{
					$lead_time =$data[0]->lead_time;
				}	

				$enddate=$this->calendDate($lead_time,$input['sdate']);
				
				DB::table('apqp_draft_project_plan')
				->where('project_id',$input['proj_id'])
			   ->where('activity',$input['aid'])
				->update(
						 array(
						 	'lead_time'	=>$lead_time,
						 	'responsibility'	=>$input['user'],
						 	'activity_start_date' =>date('Y-m-d', strtotime($input['sdate'])) , 
						 	'activity_end_date' =>date('Y-m-d', strtotime($enddate))  , 
						 	)
					);

				$this->checkprevDefine($input['aid'],$enddate,$input['proj_id']);
			}

			if($input['sdate'] == '' && $input['lead_time'] != ''){

				$NewStartDate=date('Y-m-d', strtotime(str_replace('/','-',$input['plan_start_date'])));
			$myDateTime = DateTime::createFromFormat('Y-m-d', $NewStartDate);
			$newDateString = $myDateTime->format('m/d/Y');

				$enddate=$this->calendDate($input['lead_time'],$newDateString);
				
				DB::table('apqp_draft_project_plan')
				->where('project_id',$input['proj_id'])
			    ->where('activity',$input['aid'])
				->update(
						 array(
						 	'lead_time'	=>$input['lead_time'],
						 	'activity_start_date' =>date('Y-m-d', strtotime($input['plan_start_date'])) , 
						 	'activity_end_date' =>date('Y-m-d', strtotime($enddate))  , 
						 	)
					);

				$this->checkprevDefine($input['aid'],$enddate,$input['proj_id']);
			}

				exit();
	
	}
	public function checkprevDefine($act_id,$start_date,$projId){
		$prevDefine = DB::table('apqp_gate_activity_master')
					->select('apqp_gate_activity_master.*')
					->where('previous_reference_activity',$act_id)
					->get();
					
					if(!empty($prevDefine)){
						foreach ($prevDefine as $key) {
							$leadT= DB::table('apqp_draft_project_plan')
							->select('lead_time')
							->where('activity',$key->id)
							->where('project_id',$projId)
							->get();
							if(!empty($leadT)){
							$enddate=$this->calendDate($leadT[0]->lead_time,$start_date);
				
							DB::table('apqp_draft_project_plan')
							->where('activity',$key->id)
							->where('project_id',$projId)
							->update(
									 array(
									 	'activity_start_date' =>date('Y-m-d', strtotime($start_date))  , 
									 	'activity_end_date' =>date('Y-m-d', strtotime($enddate))  , 
									 	)
								);
							$this->checkprevDefine($key->id,$enddate,$projId);
						}
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
	public function checkprjSave(){
		$input = Input::all();
		$prjAvl = DB::table('apqp_draft_project_plan')
				  ->select('apqp_draft_project_plan.*')
				  ->where('project_id',$input['proj_no'])
				  ->take(1)
				  ->orderBy('id')
				  ->get();
				if(empty($prjAvl)){
					echo 'no';
				}else{
					echo $prjAvl[0]->project_start_date;
				}
				exit();
	}
	public function get_dropdown(){
		$input = Input::all();
		$tableName=$input['dept'];
		$users = DB::table($tableName)->select('d_id','d_name')->where('d_id','!=',2)->get();
		$select="Please Select Function";
			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {


				echo '<option value="'. $key->d_id. '"';
				echo ' >'.$key->d_name.'</option>';
			}
		exit();
	}
	public function get_dropdown1(){
		$input = Input::all();
		$tableName=$input['dept'];
		$field1=$input['field1'];
		$field2=$input['field2'];
		$users = DB::table($tableName)->select(
			$field1,$field2)->get();
		$select="Please Select Function";
			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {


				echo '<option value="'. $key->$field1. '"';
				echo ' >'.$key->$field2.'</option>';
			}
		exit();
	}
	public function get_commodity(){
		$input = Input::all();
		
		$data = DB::table('apqp_project_material')
				->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_project_material.material_id')
				->select('apqp_material_master.*')
				->where('project_id',$input['id'])
				->get();

		$select="Please Select Function";
			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($data as $key3 ) {
				echo '<option value="'. $key3->id. '"';
				echo ' >'.$key3->material_description.'</option>';
			}
		exit();
	}
	 function postSaveact( $id =0)
	{  
		$input = Input::all();
		
		$data1 = DB::table('apqp_activity_as_per_project')
		->select('apqp_activity_as_per_project.pa_id')
		->get();
		$data = DB::table('apqp_draft_project_plan')
				->select('project_start_date')
				->where('project_id',$input['project_id'])
				->take(1)
				->get();
		
		if(empty($data1)){
			$act='a@0';
		}else{
			 $actid = DB::table('apqp_activity_as_per_project')->orderBy('pa_id', 'desc')->first();
			 $act = 'a@'.$actid->pa_id;
		}
		
		DB::table('apqp_activity_as_per_project')
		->insert(
			array(
              'pa_proj_id' => $input['project_id'],
              'p_act_id' => $act,
              'pa_gate_id' => $input['gate_id'],
             'pactivity' => $input['activity'],
             'pa_lead_time' => $input['lead_time'],
              'pa_previous_reference_activity' => $input['gate_id1'],
              'pa_responsible_department' => $input['responsible_department'],
             'pa_user' => $input['user'],
             'pa_material' => $input['commodity'],
             'pa_activity_type' => $input['activity_type'],
             'pa_start_date' =>$input['date'],
             'pa_end_date' =>$input['date1']
          
          )
			);

		DB::table('apqp_draft_project_plan')
		->insert(
			array(
              'project_id' => $input['project_id'],
              'project_no' => $input['proj_name1'],
              'gate_id' => $input['gate_id'],
             'project_start_date' =>  $data[0]->project_start_date,
             'activity' => $act,
              'responsibility' => $input['user'],
              'material_id' => $input['commodity'],
             'activity_start_date' =>date('Y-m-d', strtotime($input['date'])), 
             'activity_end_date' =>date('Y-m-d', strtotime($input['date1'])),
            
          
          )
			);
		//$redirect = (!is_null(Input::get('apply')) ? 'projectMaster/add/'.$id.'?md='.$md.$trackUri :  'draftProjectPlan?md='.$md.$trackUri );
		return Redirect::to('draftProjectPlan/add/')->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
		
	
	}
	public function get_user(){
		$input = Input::all();
		$tableName=$input['dept'];
		$users = DB::table('tb_users')->select('tb_users.*')->where('department',$input['dept'])->get();
		$select="Please Select Function";
			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {


				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->first_name.' '.$key->last_name.'</option>';
			}
		exit();
	}
	public function calEndDate1(){
		$input =Input::all();
		$data=DB::table('apqp_draft_project_plan')
				->select('apqp_draft_project_plan.activity_end_date')
				->where('id',$input['a_id'])
				->get();

				$calendd=$this->calEndDate($input['lead_time'],$data[0]->activity_end_date);
				$edate=date('d-m-Y',strtotime($calendd));
				$date = $data[0]->activity_end_date.'@'.$edate;
				return $date;
				
				exit();
	}
	public function getActivity1(){
		$input = Input::all();
		
		if(isset($input['commodity'])){
			$mat=$input['commodity'];
		}else{
			$mat=0;
		}
echo $input['proj_id'];
		$users = DB::table('apqp_draft_project_plan')
				->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
				->select('apqp_gate_activity_master.*','apqp_draft_project_plan.id')
				->where('apqp_draft_project_plan.gate_id',$input['gate'])
				->where('apqp_draft_project_plan.material_id',$mat)
				->where('apqp_draft_project_plan.project_id',$input['proj_id'])
				->get();
				
				
				$select="--Please Select--";
	

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->activity.'</option>';
			}


		exit;
	}	
	public function calDate(){
		$input = Input::all();
		 $date =$this->calEndDate($input['lead_time'],$input['date']);
		 return $date;exit();
	}

	
		
}