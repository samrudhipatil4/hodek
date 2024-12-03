<?php
class newProjectController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'newProject';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new newProject();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'newProject',
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
		$this->layout->nest('content','newProject.index',$this->data)
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
			$this->data['row'] =  $this->model->getColumnTable('apqp_new_project_info'); 
		} else {
			$this->data['row'] = $this->model->getColumnTable('apqp_new_project_info'); 
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
		unset($_SESSION['SessionProjectNo']);
		unset($_SESSION['searchPro']);
		$this->layout->nest('content','newProject.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('tbl_change_type'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','commodityMaster.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		$trackUri = $this->data['trackUri'];
		$rules = $this->validateForm();
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('apqp_commodity_master');
			try{
			$ID = $this->model->insertRow($data , Input::get('id'));
			}catch (Illuminate\Database\QueryException $e){
			    $errorCode = $e->errorInfo[1];
			    if($errorCode == 1062){
			    	$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'CommodityMaster/add/'.$id.'?md='.$md.$trackUri :  'CommodityMaster/add/'.$id.'?md='.$md.$trackUri);
			      
			       Session::flash('messagetext', 'Duplicate commodity description');	
				Session::flash('msgstatus','error');
				return Redirect::to($redirect);

			    }
			}
			// Input logs
			if( Input::get('id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
				$id = SiteHelpers::encryptID($ID);
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'CommodityMaster/add/'.$id.'?md='.$md.$trackUri :  'CommodityMaster?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('CommodityMaster/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
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

	public function getUser(){
		$input=Input::all();
		$users = DB::table('tb_users')
				->select('tb_users.*')
				->where('department',$input['d_id'])
				->get();
				
				$select="--Please Select--";

			echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->first_name.' '.$key->last_name.'</option>';
			}

		exit;
	}	
	public function SaveProject(){
		//error_reporting(E_ALL);
		$input=Input::all();
		$projNo='';
		if($input['sop_date'] == ""){
			$sop_date=null;
		}else{
			$sop_date=date('Y-m-d', strtotime($input['sop_date']));
		}

		if($input['cust_sop_date'] == ""){
			$cust_sop_date=null;
		}else{
			$cust_sop_date=date('Y-m-d', strtotime($input['cust_sop_date']));
		}
		if($input['cust_proto_date'] == ""){
			$cust_proto_date=null;
		}else{
			$cust_proto_date=date('Y-m-d', strtotime($input['cust_proto_date']));
		}
		if($input['cust_ppap_date'] == ""){
			$cust_ppap_date=null;
		}else{
			$cust_ppap_date=date('Y-m-d', strtotime($input['cust_ppap_date']));
		}
		$projNo=( isset($_SESSION['SessionProjectNo']))? $_SESSION['SessionProjectNo'] : '';
		// dd($projNo);
		if($input['customer']==""){
			$cust="";
		}else{
			$cust=$input['customer'];
		}
		if($input['enquiry_id']==""){
			$enquiry="";
		}else{
			$enquiry=$input['enquiry_id'];
		}
		
			if($projNo == ''){		
				try{
					// DB::enableQueryLog();
						$data = DB::table('apqp_new_project_info')
					->insert(
						array(
								'project_no'  		=>  $input['projectNo'],
								'project_name' 		=>  $input['proj_name'],
								'mfg_location'		=>  $input['location'],
								'project_start_date'=>  $input['date'],
								'document_no'		=>  $input['doc_no'],
								'top_mgt_approval'  =>  $input['top_app'],
								'part_no'  			=>  $input['part_no'],
								'cust_part_no'  	=>  $input['cust_part_no'],
								'cust_proto_qty'  	=>  $input['cust_proto_qty'],
								'cust_ppap_qty'  	=>  $input['cust_ppap_qty'],
								'engine_details'  	=>  $input['engine_details'],
								'engine_appl_details'=> $input['engine_appl_details'],
								'annual_vol_data'   =>  $input['annual_vol_data'],
								'cust_ppap_date'	=>  $cust_ppap_date,
								'cust_proto_date'	=>  $cust_proto_date,
								'sop_date'			=>  $sop_date,
								'cust_sop_date'		=>  $cust_sop_date,
								'customer'			=>  $cust,
								'enquiry_id'		=>  $enquiry						)
													);
					 //dd(DB::getQueryLog());
					$_SESSION['SessionProjectNo'] = $input['projectNo'];
				 }catch (Illuminate\Database\QueryException $e){

				    echo $errorCode = $e->errorInfo[1];
				    if($errorCode == 1062){
				    	echo 'Duplicate project';exit();
				    }
				}
			}elseif ($projNo != '' || strcasecmp($projNo, $input['projectNo'])==0) {
				$data = DB::table('apqp_new_project_info')
					->where('project_no',$input['projectNo'])
					->update(
						array(
								'project_no'  		=>  $input['projectNo'],
								'project_name' 		=>  $input['proj_name'],
								'mfg_location'		=>  $input['location'],
								'project_start_date'=>  $input['date'],
								'document_no'		=>  $input['doc_no'],
								'top_mgt_approval'  =>  $input['top_app'],
								'part_no'  			=>  $input['part_no'],
								'cust_part_no' 		=>  $input['cust_part_no'],
								'cust_proto_qty'  	=>  $input['cust_proto_qty'],
								'cust_ppap_qty'  	=>  $input['cust_ppap_qty'],
								'engine_details' 	=>  $input['engine_details'],
								'engine_appl_details'  =>  $input['engine_appl_details'],
								'annual_vol_data'  =>  $input['annual_vol_data'],
								'cust_ppap_date'	=>  $cust_ppap_date,
								'cust_proto_date'			=>  $cust_proto_date,
								'sop_date'			=>  $sop_date,
								'cust_sop_date'		=>  $cust_sop_date,
								'customer'			=>  $cust,
								'enquiry_id'		=>  $enquiry						
							)
					);
					echo '1';exit();
			}else{
				echo '1';exit();
			}
			exit();	
			
	}
	public function checkCommonAct(){
			$input = Input::all();

		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}
				
					$commact = DB::table('apqp_gate_activity_master')
					->select('apqp_gate_activity_master.*')
					//->where('gate_id',$value['val'])
					->where('activity_type','C')
					->where('active',1)
					->where('template',$input['template'])
					->get(); 

					if(empty($commact)){
						echo "noactivity";;
					}
			exit();
	}

	public function SaveGate(){

		$input = Input::all();

		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}

		$data = DB::table('apqp_project_gate')
				->select('apqp_project_gate.*')
				->where('project_id',$projNo)
				->get();
				
			
				if(empty($data)){
				foreach ($input as $key) {
					foreach ($key as $value) {
						
					$data = DB::table('apqp_project_gate')
							->insert(
								array(
										'project_id'  	=>  $projNo,
										'gate_id' 		=>  $value['val'],
										
									)
							);
						}
				}
			}else{
				$data = DB::table('apqp_project_gate')
						->where('project_id',$projNo)
							->update(
								array(
										'project_id'  	=>  $projNo,
									)
							);
			}
			
		exit();
	}
	public function getTemplate(){

			if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}
	$data = DB::table('apqp_new_project_info')
	->leftjoin('apqp_templatemaster','apqp_templatemaster.template_id','=','apqp_new_project_info.template')
	->select('apqp_templatemaster.*')
	->where('apqp_new_project_info.project_no',$projNo)
	->get();
			
				echo '<table align="center" border="1"  width="70%" id="allTemplate">
					<tr>
					<td width="10%" align="center" >Sr.No.</td>
					<td width="40%" align="center">Template</td>
					</tr>';

					 $i=1; if(!empty($data)){ foreach($data as $key){
					echo '<tr >
						<td>'. $i.'</td>
						<td>'. $key->template_desc.'</td>
						
					<input style="display:none" type="hidden" id="temp_id" value="'.$key->template_id.'" /></tr>';
					 $i++; } }
				echo '</table>';exit;
	}
	public function getGetInfo(){
		$input =Input::all();
			if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}
				$data = DB::table('apqp_gate_management_master')
				->join('apqp_gate_activity_master','apqp_gate_activity_master.gate_id','=','apqp_gate_management_master.id')
				->select('apqp_gate_management_master.*')
				->where('apqp_gate_management_master.Is_Active',1)
				->where('apqp_gate_activity_master.template',$input['template'])
				->groupBy('gate_id')
				->orderby('id')
				->get();
			
				echo '<table align="center" border="1"  width="70%" id="allGate">
					<tr>
					<td width="10%" align="center" >Sr.No.</td>
					<td width="40%" align="center">Gate </td>
					</tr>';

					 $i=1; if(!empty($data)){ foreach($data as $key){
					echo '<tr >
						<td>'. $i.'</td>
						<td>'. $key->Gate_Description.'</td>
						<input type="hidden" name="gateid" id="'. $i.'" value="'. $key->id.'">
					</tr>';
					 $i++; } }
				echo '</table>';exit;
	}
	public function getMaterial(){

			if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}
				$data = DB::table('apqp_project_material')
				->leftjoin('apqp_material_master','apqp_material_master.id','=','apqp_project_material.material_id')
				->select('apqp_project_material.*','apqp_material_master.*')
				->where('apqp_project_material.project_id',$projNo)
				->get();
			
				echo '<table align="center" border="1"  width="70%" id="allMaterial">
					<tr>
					<td width="10%" align="center" >Sr.No.</td>
					<td width="40%" align="center">Material</td>
					</tr>';

					 $i=1; if(!empty($data)){ foreach($data as $key){
					echo '<tr >
						<td>'. $i.'</td>
						<td>'. $key->material_description.'</td>
						
					</tr>';
					 $i++; } }
				echo '</table>';exit;
	}
	public function checkCommodityAct(){
		$input = Input::all();


		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}
		$comm=DB::table('apqp_material_master')
		->select('apqp_material_master.*')
		->where('apqp_material_master.id','=',$input['material'])
		->get();

		// $gate = DB::table('apqp_project_gate')
		// 		->select('apqp_project_gate.*')
		// 		->where('project_id','=',$projNo)
		// 		->get();
		// foreach ($gate as $key) {
			$commact = DB::table('apqp_gate_activity_master')
					->select('apqp_gate_activity_master.*')
					//->where('gate_id',$key->gate_id)
					->where('activity_type','M')
					->where('commodity',$comm[0]->commodity)
					->where('apqp_gate_activity_master.template',$input['template'])
					->get(); 
					
		//}
		if(empty($commact)){
						echo 'noact';exit();
					}
		exit();
	}
	public function SaveTemplate(){
		$input = Input::all();
		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				// 'if';exit();
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
			//echo $projNo;exit();
		}else{
			//echo 'elese';exit();
			$projNo='';
		}

		
		
	
			$data = DB::table('apqp_new_project_info')
					->where('project_no',$projNo)
					->update(
						 array(  
						
						'template'	=> $input['template']
						)
					);
			
			
		
				exit;
	}
	public function Savematerial(){
		$input = Input::all();
		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}
	
		$data = DB::table('apqp_project_material')
				->select('apqp_project_material.*')
				->where('project_id',$projNo)
				->get();
		
		try{
			$data = DB::table('apqp_project_material')
					->insert(
						 array(  
						'project_id' => $projNo,
						'material_id'	=> $input['material']
						)
					);
			}catch (Illuminate\Database\QueryException $e){

				    $errorCode = $e->errorInfo[1];
				    if($errorCode == 1062){
				    	echo 'Material Already added';exit();
				    }
			}
		
				exit;
	}
	public function deptNUser(){
		$input = Input::all();
		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$projNo=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$projNo=$_SESSION['searchPro'];
		}else{
			
			$projNo='';
		}
		$check = DB::table('apqp_project_dept_User')
						->select('apqp_project_dept_User.id','apqp_project_dept_User.dept_id')
						->where('apqp_project_dept_User.project_id',$projNo)
						->get();

						$data = DB::table('apqp_gate_activity_master')
								->select('apqp_gate_activity_master.*')
								->where('template',$input['template'])
								->groupBy('apqp_gate_activity_master.responsible_department')
								->get();
						if(empty($check)){

								foreach ($data as $key) {
									$data =DB::table('apqp_project_dept_User')
											->insert(
											 		array('project_id' => $projNo,
											 				'dept_id'  => $key->responsible_department,
											 		 )
												);
								}
						}else{
						foreach($data as $aV){
							$aTmp1[] = $aV->responsible_department;
						}

						foreach($check as $aV){
							$aTmp2[] = $aV->dept_id;
						}

						$result=array_diff($aTmp1,$aTmp2);
						foreach ($result  as $newDept) {
							$data =DB::table('apqp_project_dept_User')
											->insert(
											 		array('project_id' => $projNo,
											 				'dept_id'  => $newDept,
											 		 )
												);
						}
					}
						$data = DB::table('apqp_project_dept_User')
							->leftjoin('tb_departments','apqp_project_dept_User.dept_id','=','tb_departments.d_id')
							
							->select('apqp_project_dept_User.user_id','tb_departments.*')
							->where('project_id',$projNo)
							->where('d_id','!=',2)
							->where('d_id','!=',11)
							->get(); 
							
							echo '<table border="1" width="100%" id="deptUser">
								<tr>
								<td width="10%" align="center" >Sr.No.</td>
								<td width="40%" align="center">Department</td>
								<td width="40%" align="center">User</td>
								<td width="10%" align="center">Action</td>
								</tr>';

								 $i=1; foreach($data as $key){
								 	
								echo '<tr>
									<td>'.  $i.'</td>
									<td>'.$key->d_name.'</td><td>';
									//echo '<td>';
									$allUserId = explode(',', $key->user_id);
									$i1=0;
									foreach ($allUserId as $val ) {
										$data= DB::table('tb_users')
												->select('tb_users.first_name','tb_users.last_name')
												->where('id',$val)
												->get();
												if(!empty($data)){
													if($i1==0){
														echo $data[0]->first_name.' '.$data[0]->last_name;
													}else{
												echo ','.$data[0]->first_name.' '.$data[0]->last_name;
											}
										}
										$i1++;
												
									}
									echo'</td>
									<td align="center"><a   href="#" id=""  onclick="getUser('. $key->d_id.')" data-position="bottom" data-delay="50" data-tooltip="Edit"><i class="fa fa-pencil"></i> </td>';
									echo '<input type="hidden" id="d'.$key->d_id.'" value="'.$key->d_name.'">';
									echo '<input type="hidden" id="'.'id'.$i.'" value="'.$key->user_id.'">';
								echo '</tr>';
								 $i++;
								}
							echo '</table>';
						
						
					exit();
	}	
	public function addUser(){
		$input=Input::all();
	
		if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$proj_id=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$proj_id=$_SESSION['searchPro'];
		}else{
			
			$proj_id='';
		}
		//$seluser= implode(",",$input['user']);
		$user_id = $input['user'];  // The user ID (from input)
        
        // Fetch the current group_id for the user
		
		$currentGroupId = DB::table('tb_users')
		->where('id', $user_id)
		// ->value('group_id');
		->pluck('group_id');
		// ->first();  // Use first() to get the value from the result

		// Check if we successfully fetched the group_id
        if ($currentGroupId !== null) {
            // Convert the current group_id string into an array
            $groupIds = explode(',', $currentGroupId);
            
            // Check if 101 is already in the group_id array
            if (!in_array('101', $groupIds)) {
                // Append 101 to the array if it's not already present
                $groupIds[] = '101';
                
                // Convert the array back to a comma-separated string
                $newGroupId = implode(',', $groupIds);
                
                // Update the group_id in the database
                DB::table('tb_users')
                    ->where('id', $user_id)
                    ->update(['group_id' => $newGroupId]);
            }
        } 
		
		
	
		$data =DB::table('apqp_project_dept_User')
					->where('dept_id',$input['d_id'])
					->where('project_id',$proj_id)
					->update(
					 		array(
					 				'user_id'  => $input['user'],
					 		 )
						);
					exit();
	}

	public function addAllUser(){
		$input=Input::all();
	if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$proj_id=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$proj_id=$_SESSION['searchPro'];
		}else{
			
			$proj_id='';
		}
		$seluser= implode(",",$input['user']);
		
	
		$data =DB::table('apqp_gate_clearence_app_team')
					->where('gate_id',$input['gate_id'])
					->update(
					 		array(
					 				'user_id'  => $seluser,
					 		 )
						);
					exit();
	}

	public function getAllUser(){
		$input=Input::all();
		$users = DB::table('tb_users')
				->select('tb_users.*')
				->get();
				
				$select="--Please Select--";
	

			echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->first_name.' '.$key->last_name.'</option>';
			}

		exit;
	}
	public function clearance(){
		$input = Input::all();
			if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$proj_id=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$proj_id=$_SESSION['searchPro'];
		}else{
			
			$proj_id='';
		}

			$data = DB::table('apqp_gate_clearence_app_team')
				->select('apqp_gate_clearence_app_team.*')
				->where('apqp_gate_clearence_app_team.project_id',$proj_id)
				->get(); 
				if(empty($data)){
					
					$data1 = DB::table('apqp_gate_management_master')
				->join('apqp_gate_activity_master','apqp_gate_activity_master.gate_id','=','apqp_gate_management_master.id')
				->select('apqp_gate_management_master.*')
				->where('apqp_gate_management_master.Is_Active',1)
				->where('apqp_gate_activity_master.template',$input['template'])
				->groupBy('gate_id')
				->orderby('id')
				->get(); 
								foreach ($data1 as $key) {
									$data =DB::table('apqp_gate_clearence_app_team')
											->insert(
											 		array('project_id' => $proj_id,
											 				'gate_id'  => $key->id,
											 		 )
												);
								}
				}
					$data2 = DB::table('apqp_gate_clearence_app_team')
							->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_gate_clearence_app_team.gate_id')
							
							->select('apqp_gate_clearence_app_team.user_id','apqp_gate_management_master.*')
							->where('project_id',$proj_id)
							->get(); 

				echo '<table border="1" width="100%" id="clearanceTeam">
					<tr>
					<td width="10%" align="center">Sr.No.</td>
					<td width="40%" align="center">Gate</td>
					<td width="40%" align="center">Approving Authority</td>
					<td width="40%" align="center">Action</td>';
					

					 $i=1; foreach($data2 as $key){ 
					echo '<tr>
						<td>'.$i.'</td>
						<td>'. $key->Gate_Description.'</td><td>';
						$allUserId = explode(',', $key->user_id);
						$i1=0;
									foreach ($allUserId as $val ) {
										$data= DB::table('tb_users')
												->select('tb_users.first_name','tb_users.last_name')
												->where('id',$val)
												->get();
												
												if(!empty($data)){
													if($i1==0){
														echo $data[0]->first_name.' '.$data[0]->last_name;
													}else{
												echo ','.$data[0]->first_name.' '.$data[0]->last_name;
											}
										}

										$i1++;
									}
						echo'</td><td align="center"><a   href="#" id=""  onclick="getAllUser('.$key->id.');return false;" data-position="bottom" data-delay="50" data-tooltip="Edit"><i class="fa fa-pencil"></i> </td>
						<input type="hidden" id="gate_id'.$i.'" value="'.$key->user_id.'">
					</tr>';
					 $i++;} 
				echo '</table>';
			
			exit();

	}
	public function searchProject(){
		$input=Input::all();
		

		$data= DB::table('apqp_new_project_info')
				->select('apqp_new_project_info.*')
				->where('project_no','=',$input['projectno'])
				->get();

				if(!empty($data)){
					$_SESSION['searchPro'] = $input['projectno'];
					echo json_encode($data);
				}else{
					echo 'No';
				}
				exit();
	}

	public function changeFlag(){
			if(isset($_SESSION['SessionProjectNo']) && !empty($_SESSION['SessionProjectNo']))
		{
				
			$proj_id=$_SESSION['SessionProjectNo'];
		}else if(isset($_SESSION['searchPro']) && !empty($_SESSION['searchPro'])){
			
			$proj_id=$_SESSION['searchPro'];
		}else{
			
			$proj_id='';
		}
		$data =DB::table('apqp_new_project_info')
					->where('project_no',$proj_id)
					->update(
					 		array(
					 				'flag'  => 1,
					 		 )
						);
					exit();
	}
	public function getIncomPrj(){
		$data= DB::table('apqp_new_project_info')
				->select('apqp_new_project_info.*')
				->where('flag',0)
				->whereNotIn('id',function($query){
					$query->select ('project_id')->from ('apqp_draft_project_plan');
				})
				->get();
			$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->project_no. '"';
				echo ' >'.$key->project_no.'</option>';
			}

		exit;
	}

	public function getComponent(){
		$data = DB::table('apqp_material_master')
				->select('apqp_material_master.id','apqp_material_master.material_description')
				->whereNotIn('id',function($query){
					$query->select ('material_id')->from ('apqp_project_material')->where ('material_id', '!=',2);
				})
				->get();
			$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->material_description.'</option>';
			}

		exit;
	}
	public function getEnquiry(){

		$data = DB::select(DB::raw('select enquiryId,enquiry_no from customer_enquiry_form'));
		
		        $select = "--Please Select--";
		        echo '<option value="">';
		        echo $select.'</option>';
		        foreach($data as $d){
		        	echo '<option value="'.$d->enquiryId.'"';
		        	echo '>'.$d->enquiry_no.'</option>';
		        }
		        exit();
	}

		public function getCust(){
		$data = DB::table('customer') 
		        ->select('CustomerId','FirstName')
		        ->where('status','active')
		        ->get();
		        $select = "--Please Select--";
		        echo '<option value="">';
		        echo $select.'</option>';
		        foreach($data as $d){
		        	echo '<option value="'.$d->CustomerId.'">';
		        	echo $d->FirstName.'</option>';
		        }
		        exit();
	}

	// public function getCust(){
	// 	$data = DB::table('apqp_material_master')
	// 			->select('apqp_material_master.id','apqp_material_master.material_description')
	// 			->whereNotIn('id',function($query){
	// 				$query->select ('material_id')->from ('apqp_project_material')->where ('material_id', '!=',2);
	// 			})
	// 			->get();
	// 		$select="--Please Select--";
	// 	echo '<option value=""';
	// 		echo ' >'.$select.'</option>';
	// 		foreach ($data as $key ) {

	// 			echo '<option value="'. $key->id. '"';
	// 			echo ' >'.$key->material_description.'</option>';
	// 		}

	// 	exit;
	// }
		
}