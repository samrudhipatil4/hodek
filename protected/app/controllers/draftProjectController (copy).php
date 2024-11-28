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
		$data= DB::table('apqp_new_project_info')
				->select('apqp_new_project_info.*')
				->where('flag',1)
				->get();
			$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->project_no.'</option>';
			}

		exit;
	}
	public function getProjectInfo(){
		$input = Input::all();
		$data= DB::table('apqp_new_project_info')
				->leftjoin('plant_code','plant_code.plant_id','=','apqp_new_project_info.mfg_location')
				->select('apqp_new_project_info.project_name','plant_code.plant_code')
				->where('flag',1)
				->where('id',$input['proj_no'])
				->get();
				echo json_encode($data);exit();
	}
	public function saveProject(){
		$input = Input::all();
		$data=DB::table('apqp_new_project_info')
		->leftjoin('apqp_project_gate','apqp_project_gate.project_id','=','apqp_new_project_info.project_no')
		->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_project_gate.gate_id')
		->select('apqp_project_gate.*','apqp_gate_management_master.Gate_Description','apqp_new_project_info.project_no')
		->where('apqp_new_project_info.id',$input['proj_no'])
		->orderBy('apqp_gate_management_master.id')
		->get();
		
		

		echo '<table align="center" border="1" width="100%">
							<tr>
								<td width="10%">No</td>
								<td width="20%">Gate</td>
								<td width="20%">Activity</td>
								<td width="20%">Responsibility</td>
								<td width="15%">Activity Start Date</td>
								<td width="15%">Activity End Date</td>
							</tr>';

							 		$i1=1;
							foreach ($data as $key) {
								
 								if(!empty($key)){
 								$i2=1;
								$commact = $this->getActivity($key->gate_id,'C');
								$_SESSION['sesProjtNo'] = $key->project_no;
								echo '<tr><td  colspan="6" style="font-weight:bold;">Gate '.$key->gate_id.'</td></tr>';
							 	foreach ($commact as $value) {

							 		
							 		$getUser=$this->getUser($value->responsible_department,$_SESSION['sesProjtNo']);

							 		

							 		echo '<tr><td width="10%">'.$i1.'.'.$i2.'</td>
								<td width="20%">'.  $value->Gate_Description.'</td>
								<td width="20%">'; 
								echo $value->activity;
								echo '</td>
								<td width="20%">';
								if(!empty($getUser)){
								 foreach($getUser as $key3){
								 	 echo $key3[0]->first_name.' '.$key3[0]->last_name;
									}
								}
								echo'</td>
								<td width="15%"></td>
								<td width="15%"></td></tr>';
								$i2++;
							 	}

							 	$mat = DB::table('apqp_project_material')
								->select('apqp_project_material.*')
								->where('apqp_project_material.project_id','=',$_SESSION['sesProjtNo'])
								->get();

								foreach ($mat as $key5) {
									
									$comm[] = DB::table('apqp_material_master')
								->select('apqp_material_master.material_description','apqp_material_master.commodity')
								->where('apqp_material_master.id','=',$key5->material_id)
								->distinct('apqp_material_master.id')
								->get();

								}

								foreach ($comm as $key1) {
								
									

								echo '<tr><td colspan="2"></td><td colspan=4 style="font-weight:bold;"><div>'.$key1[0]->material_description.'</div></td></tr>';
								
								$commact = $this->getAct($key->gate_id,$key1[0]->commodity);
								
							 	foreach ($commact as $value) {

							 		$getUser=$this->getUser($value->responsible_department,$_SESSION['sesProjtNo']);

							 		echo '<tr><td width="10%">'.$i1.'.'.$i2.'</td>
								<td width="20%">'.  $value->Gate_Description.'</td>
								<td width="20%">'; 
								echo $value->activity;
								echo '</td>
								<td width="20%">';
								if(!empty($getUser)){
								 foreach($getUser as $key8){
								 	 echo $key8[0]->first_name.' '.$key8[0]->last_name;
									}
								}
								echo'</td>
								<td width="15%"></td>
								<td width="15%"></td></tr>';
								$i2++;
							 	}
							 
							}
							unset($comm);
							
							 	$i1++;
							 }

							 }
							 	
					
						echo '</table>';exit();
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
						->select('tb_users.first_name','tb_users.last_name')
						->where('tb_users.id',$value)
						->get();
					}
				}
			}
			
				return $data1;
				
	}
	public function getActivity($gate,$type){
		$data = DB::table('apqp_gate_activity_master')
				->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_gate_activity_master.gate_id')
				->select('apqp_gate_activity_master.*','apqp_gate_management_master.Gate_Description',DB::raw('"" as start_date'),DB::raw('"" as end_date'))
				->where('gate_id',$gate)
				->where('activity_type','=',$type)
				->get();
				
				return $data;
				

				
	}
	public function getAct($gate,$comm){
		$data = DB::table('apqp_gate_activity_master')
				->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_gate_activity_master.gate_id')
				->select('apqp_gate_activity_master.*','apqp_gate_management_master.Gate_Description')
				->where('apqp_gate_activity_master.gate_id',$gate)
				->where('apqp_gate_activity_master.commodity',$comm)
				->where('apqp_gate_activity_master.activity_type','=','M')
				->get();
				return $data;
	}
	public function getStartDate($date,$id){
		$data = DB::table('apqp_gate_activity_master')
				->select('apqp_gate_activity_master.*')
				->where('apqp_gate_activity_master.id',$id)
				->get();
				//echo'<pre>';print_r($data);
				
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
				$data =DB::table('apqp_project_dept_User')
				->select('apqp_project_dept_User.*')
				->get();
				foreach ($data as $key) {
					if ($key->user_id==''){
						echo 'user';
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
				$Cond1='commAct';
				$Cond2='commdityAct';
				$Cond3='userDept';
				$Cond4= 'clrs';
		if($Cond1 == 'commAct'){
			
			foreach ($data as $key){
				$data = DB::table('apqp_gate_activity_master')
						->select('apqp_gate_activity_master.*')
						->where('gate_id',$key->gate_id)
						->where('activity_type','C')
						->get();
						if(empty($data)){
							echo 'noact';break;
						}
			}
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

					foreach ($data as $key3) {
						
					$comm = DB::table('apqp_gate_activity_master')
					->select('apqp_gate_activity_master.*')
					->where('gate_id','=',$key3->gate_id)
					->where('activity_type','M')
					->where('commodity',$value1[0]->commodity)
					->get();
					if(empty($comm)){
						echo 'commodity';break;
					}
					}
				}
			
		}

		if($Cond3=='userDept'){
		$check = DB::table('apqp_project_dept_User')
						->select('apqp_project_dept_User.id','apqp_project_dept_User.dept_id')
						->where('apqp_project_dept_User.project_id',$input['proj_id'])
						->get();

		$act = DB::table('apqp_gate_activity_master')
			 ->select('apqp_gate_activity_master.responsible_department')
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
						->where('project_id',$input['proj_id'])
						->get();
						if(empty($data1)){
							echo'noclr';break;
						}
			}
		}
		exit();
		                                      

	}
		
}