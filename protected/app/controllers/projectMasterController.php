<?php
use Carbon\Carbon;
//session_start();
class projectMasterController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'projectMaster';
	static $per_page	= '10';

	
	public function __construct() {
		
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
	
		$this->model = new projectMaster();

		
		$this->info = $this->model->makeInfo($this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'projectMaster',
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
		
		$this->layout->nest('content','projectMaster.index',$this->data)
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

			$this->data['row'] = $this->model->getColumnTable('tb_projectMaster'); 

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
		$this->data['member']	= $this->model->getUser();
		$this->data['stage']	= $this->getStage();

		if($this->data['row']['project_code'] == ""){	
		$this->data['department']	= $this->getDepartment();
		}else{
			$project_code = $this->data['row']['project_code'];
			$this->data['department'] = $this->getEditDept($project_code);
		}
		$this->data['depart'] = $this->getDepartmentByAjax();
		
		$this->data['id'] = $id;
		$_SESSION['valid'] = 'Yes';
		$this->layout->nest('content','projectMaster.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('tb_projectMaster'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','projectMaster.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		
		unset($_SESSION['data']);
		unset($_SESSION['project_description']);
		unset($_SESSION['stage']);
		unset($_SESSION['proj_mgr']);
		unset($_SESSION['comm']);
		unset($_SESSION['docver']);
		unset($_SESSION['final']);
		unset($_SESSION['cust_app']);
		$trackUri = $this->data['trackUri'];
		
		
		$rules = $this->validateForm();

		$validator = Validator::make(Input::all(), $rules);	

		//if ($validator->passes()) {

			$data = $this->validatePost('tb_projectMaster');
		
			$checkDeptSave = $this->checkDeptSave($data['project_code']);

			
			$allProjCode = $this->getProjCode();

			$flag = 0;

			foreach ($allProjCode as $row) {
				if($row->project_code ==  $data['project_code'] ){
					$flag = 1;
				}
			}

			
			if(isset($data['change_stage'])){
			if($checkDeptSave == 1  && $data['change_stage']==2 && $data['id'] == ""){
				$_SESSION['data'] = $data['project_code'];
    		$_SESSION['description'] = $data['project_description'];
    		$_SESSION['proj_mgr'] = $data['project_manager'];
    		$_SESSION['stage'] = $data['change_stage'];
    		$_SESSION['comm'] = $data['cust_comm_repres'];
    			$_SESSION['cust_app'] = $data['cust_comm_approval'];
    		$_SESSION['docver'] = $data['documentVerify'];
    		$_SESSION['final'] = $data['finalApproval'];
				Session::flash('messagetext', 'Please select department or user');	
				Session::flash('msgstatus','error');
				return Redirect::to('projectMaster/add?md=');
			}
		}

			if($flag == 1 && $data['id'] == ""){
				Session::flash('messagetext', 'Duplicate project code');	
				Session::flash('msgstatus','error');
				return Redirect::to('projectMaster');

			}

			if($data['id'] != ""){
				$dept = Input::all();
				$oldCode = $dept['proj_department'];
				$editCode  = $data['project_code'];
				if($oldCode != $editCode){
					DB::table('CFTTeamForProject')
								->where('project_code',$oldCode)
								->update(
										array(
												'project_code' => $editCode
											)
									);
				}
			}
			try{
			$ID = $this->model->insertRow($data , $data['id']);
			}catch (Illuminate\Database\QueryException $e){
			    $errorCode = $e->errorInfo[1];
			    if($errorCode == 1062){

			    	$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'projectMaster/add/'.$id.'?md='.$md.$trackUri :  'projectMaster/add/'.$id.'?md='.$md.$trackUri);
			       Session::flash('messagetext', 'Duplicate project code');	
				Session::flash('msgstatus','error');
				return Redirect::to($redirect);

			    }
			}
			// Input logs
			if( Input::get('process') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
				$id = SiteHelpers::encryptID($ID);
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'projectMaster/add/'.$id.'?md='.$md.$trackUri :  'projectMaster?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
			
		// } else {
		// 	$md = str_replace(" ","+",Input::get('md'));
		// 	return Redirect::to('projectMaster/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
		// 	->withErrors($validator)->withInput();
		// }	
	
	}
	
	
	public function postDestroy()
	{
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
		// delete multipe rows 
		if(count(Input::get('id')) >=1)
		{
			$this->model->destroy(Input::get('id'));
			$this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successfull");
			// redirect
			Session::flash('messagetext', Lang::get('core.note_success_delete'));	
			Session::flash('msgstatus','success');		
		} else {
			Session::flash('messagetext', 'No Item Deleted');	
			Session::flash('msgstatus','error');		
		}

		return Redirect::to('projectMaster');
	}
	
	public function getDepartment(){
		
		if(isset($_SESSION['data'])){
		$proj_code = $_SESSION['data'];
		}else{
			$proj_code = "";
		}
		
		//echo "dept".$proj_code;exit();
		
		$data = DB::table('CFTTeamForProject')
		->select('project_code')
		->where('project_code',$proj_code)
		->get();
		
		
		

		if(!empty($data)){
				$dept = DB::table('tb_departments')
				
				->leftjoin('CFTTeamForProject','CFTTeamForProject.dept_id','=',DB::raw('tb_departments.d_id AND CFTTeamForProject.project_code ='.'"'.$proj_code.'"' ))
				->leftjoin('tb_users','tb_users.id','=',DB::raw('CFTTeamForProject.user_id AND tb_users.group_id like \'%3%\''))
				->select('d_name','d_id','first_name','last_name','user_id','project_code','flag')
				->where('tb_departments.d_id','!=',11)
				->where('tb_departments.d_id','!=',2)
				->whereNull('CFTTeamForProject.flag')
				->orwhere('CFTTeamForProject.flag',1)
				//->where('CFTTeamForProject.project_code',$data[0]->project_code)
				->groupBy('tb_departments.d_id')
				
				->get();

			
				
		}else{
				$dept = DB::table('tb_departments')
				
				->leftjoin('CFTTeamForProject','CFTTeamForProject.dept_id','=',DB::raw('tb_departments.d_id AND CFTTeamForProject.project_code = "" '))
				->leftjoin('tb_users','tb_users.id','=',DB::raw('CFTTeamForProject.user_id AND tb_users.group_id like \'%3%\''))
				->select('d_name','d_id','first_name','last_name','user_id','project_code')
				->where('d_id','!=',11)
				->where('d_id','!=',2)
				//->whereNull('CFTTeamForProject.flag')
				//->orwhere('CFTTeamForProject.flag',1)

				->groupBy('tb_departments.d_id')

				->get();

		}



		return $dept;
				
	}

	public function getEditDept($proj_code){
		
				//echo 'edit'.$proj_code;exit();
				$dept = DB::table('tb_departments')
				
				->leftjoin('CFTTeamForProject','CFTTeamForProject.dept_id','=','tb_departments.d_id')
				->leftjoin('tb_users','tb_users.id','=',DB::raw('CFTTeamForProject.user_id AND tb_users.group_id like \'%3%\''))
				->select('d_name','d_id','first_name','last_name','user_id')
				->where('d_id','!=',11)
				->where('d_id','!=',2)
				->whereNull('CFTTeamForProject.flag')
				->orwhere('CFTTeamForProject.flag',1)

				->groupBy('tb_departments.d_id')
				->where('project_code',$proj_code)

				->get();
		return $dept;
				
	}
	public function get_User(){
		$input = (object)Input::all();

		 $user = DB::table('tb_users')->select('id','first_name','last_name')
		 ->where('department',$input->dept_id)
		 ->where('tb_users.id','!=', 1)
		 ->where('tb_users.group_id','LIKE','%3%')
		 ->get();
		 	echo '<option value="'." ".'">--Please Select--</option>';
		foreach ($user as $key ) {
				$selected = ($input->user_id == $key->id) ? 'selected' : '';
				echo '<option '.$selected.' value="'. $key->id. '"';
				echo ' >'.$key->first_name.' '.$key->last_name.'</option>';
			}
			exit;
	}	

	public function save_User(){
		$input = (object)Input::all();
		$proj_code = $input->proj_code;
			$user = $input->user;
			$dept = $input->dept_id;

			// if($input->edit == ""){
			// 	$projCodeAvl = DB::table('CFTTeamForProject')
			// 			->select('user_id')
			// 			->where('project_code',$proj_code)
			// 			->where('dept_id',$dept)
			// 			->where('user_id',$user)
			// 			->get();
			// 			if(!empty($projCodeAvl)){
			// 				echo '1';die();
			// 			}

			// }
			$getData = DB::table('CFTTeamForProject')
						->select('user_id')
						->where('project_code',$proj_code)
						->where('dept_id',$dept)
						->get();

						if(!empty($getData)){
							
							DB::table('CFTTeamForProject')
							->where('project_code',$proj_code)
							->where('dept_id',$dept)
							->update(
								array(
										'user_id'		=> $user
									)
							);
						}else{

						DB::table('CFTTeamForProject')->insert(
							array(
									'project_code'	=> $proj_code,
									'dept_id'		=> $dept,
									'user_id'		=> $user
								)
							);
						}

						$getUser = DB::table('tb_users')
						->select('first_name','last_name')
						->where('id',$user)
						->get();
						echo json_encode($getUser);die();
		}

		public function deleteDepartment(){
			$input = (object)Input::all();

			$data = DB::table('tb_projectMaster')
			->select('project_code')
			->where('project_code',$input->proj_code)
			->get();

			if($input->edit == ""){
			foreach ($data as $row) {
					if($row->project_code === $input->proj_code){
						echo 0;exit;
					}
				}	
			}	
			$_SESSION['data'] = $_POST['proj_code'];
    		$_SESSION['description'] = $_POST['desc'];
    		$_SESSION['proj_mgr'] = $_POST['mgr'];
    		$_SESSION['stage'] = $_POST['stage'];
    		$_SESSION['comm'] = $_POST['comm'];
    		$_SESSION['docver'] = $_POST['docver'];
    		$_SESSION['final'] = $_POST['docver'];

			$checkDept = DB::table('CFTTeamForProject')
						->select('dept_id')
						->where('dept_id',$input->dept_id)
						->where('project_code',$input->proj_code)
						->get();


						if(!empty($checkDept)){

							DB::table('CFTTeamForProject')
								->where('dept_id',$input->dept_id)
								->where('project_code',$input->proj_code)
								->update(
										array(
												'flag' => 0
											)
									);
						}else{
							DB::table('CFTTeamForProject')
								->insert(
										array(
												'project_code' => $input->proj_code,
												'dept_id'	=> $input->dept_id
											)
									);
								DB::table('CFTTeamForProject')
								->where('dept_id',$input->dept_id)
								->where('project_code',$input->proj_code)
								->update(
										array(
												'flag' => 0
											)
									);

						}
			echo 1;exit;
		}

		public function checkProject(){
			$input = (object)Input::all();
			$data = DB::table('CFTTeamForProject')
			->select('project_code')
			->where('project_code',$input->proj_code)
			->get();
			if(!empty($data)){
				return '1';exit;
			}else{
				$proj="0";
				return false;exit;
			}

		
		}

		public function getProjCode(){
			$data = DB::table('tb_projectMaster')
			->select('project_code')
			->get();
			return $data;
		}

		public function checkDeptSave($proj_code){
			$data = DB::table('CFTTeamForProject')
					->select('dept_id')
					->where('project_code',$proj_code)
					->get();

					if(empty($data)){
						return true;
					}else{
						$data = DB::table('CFTTeamForProject')
						->select(DB::raw('COUNT(dept_id) as total'))
						->where('project_code',$proj_code)
						->where('flag','0')
						->get();

						
							
							$data1 = DB::table('tb_departments')
						->select(DB::raw('COUNT(d_id) as total'))
						->where('d_id','!=',11)
						->where('d_id','!=',2)
						->get();
						
						$cnt =$data1[0]->total-$data[0]->total;
						

						
							$data2 = DB::table('CFTTeamForProject')
							->select(DB::raw('COUNT(user_id) as total'))
							->where('project_code',$proj_code)
							->where('flag',1)
							->get();
							
						
							
					
						if($data2[0]->total != $cnt){
								return true;
							}
					}

		}

		public function getStage(){
			$member = DB::table('tb_change_stage')
				->select('change_stage_id','stage_name')
				
				->get();

				foreach ($member as $row) {
					$data[] =  array(
						'change_stage_id' => $row->change_stage_id,
						'stage_name'	=> $row->stage_name
					 );
				}

				return $data;
		}

		public function getDepartmentByAjax(){
		
		$users = DB::table('tb_departments')
				->select('d_id','d_name')
				->where('d_id','!=',11)
				->where('d_id','!=',2)
				->get();
	
			return $users;
			
	}
	public function add_deptart(){
		$input =Input::all();

		$_SESSION['data'] = $_POST['proj_code'];
    		$_SESSION['description'] = $_POST['desc'];
    		$_SESSION['proj_mgr'] = $_POST['mgr'];
    		$_SESSION['stage'] = $_POST['stage'];
    		$_SESSION['comm'] = $_POST['comm'];
    		$_SESSION['docver'] = $_POST['docver'];
    		$_SESSION['final'] = $_POST['docver'];
		
		$data = DB::table('CFTTeamForProject')
				->where('project_code',$input['proj_code'])
				->where('dept_id',$input['dept'])
				->where('flag',1)
				->get();
			$data1 = DB::table('CFTTeamForProject')
				->where('project_code',$input['proj_code'])
				->where('dept_id',$input['dept'])
				->get();


				
				if(!empty($data)){
					return "0";exit;
				}else if(empty($data1)){
					return "0";exit;
				}else{
				 DB::table('CFTTeamForProject')
				->where('project_code',$input['proj_code'])
				->where('dept_id',$input['dept'])
				->update(['flag'=>1]);
				return 1;
				}

	}
	function setStageSess(){
		$input =Input::all();

		if($input['edit']=='series'){
			$_SESSION['valid'] = 'No';
		}else{
			$_SESSION['valid'] = 'Yes';
		}
		exit;
	}
	public function changeReqUpload1(){
     $input = Input::all();
      $names = Input::file('logo_image');

    
    	$destinationPath = 'uploads/projectMaster';
    	$extension = $names->getClientOriginalName();
    	$filename = rand(11111, 99999) . '-' .$extension; 
    	$upload_success = $names->move($destinationPath, $filename);
    	$fileWithPath = 'uploads/projectMaster/'.$filename;
    	

   
    try {
    	   
    $inputFileType = PHPExcel_IOFactory::identify($fileWithPath);
    
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($fileWithPath);
	} catch(Exception $e) {
	    die('Error loading file "'.pathinfo($fileWithPath,PATHINFO_BASENAME).'": '.$e->getMessage());
	}  
    
    $sheet = $objPHPExcel->getSheet(0); 
  		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		
		
		
		for($i=1;$i<=$highestRow;$i++){
			$rowData[] = $sheet->rangeToArray('A' . $i . ':' . $highestColumn . $i,
		                                    NULL,
		                                    TRUE,
		                                    FALSE);

		}
		 $filename1 =  Config::get('app.site_root'). '/uploads/projectMaster/' . $filename;
	

                
                    File::delete($filename1);
                   
		
		$flag=0;
		for($i=0;$i<$highestRow;$i++){
			
			
			for($j=$i+1;$j<$highestRow;$j++){
				
				if(strnatcasecmp($rowData[$i][0][0],$rowData[$j][0][0])==0){
					$flag=1;break;
				}
			}
		}

		
		for($i=0;$i<$highestRow;$i++){
			if($rowData[$i][0][1] == ""){
				echo "Project Description is blank in input file";exit;
			}
		}
		for($i=0;$i<$highestRow;$i++){
			if($rowData[$i][0][2] == ""){
				echo "Change stage is blank in input file";exit;
			}
		}
		for($i=0;$i<$highestRow;$i++){
			$checkPrjDb= $this->checkPrjInDB($rowData[$i][0][0]);
			if(!empty($checkPrjDb)){
				$flag=1;break;
			}
		}
		
		if($flag==1){
			echo "Duplicate project code in input file";exit;
		}

			for($i=0;$i<$highestRow;$i++){
			$tc = count($rowData[$i][0]);
				for($j=3;$j<7;$j++){
					
					$dd= $this->checkUserExist($rowData[$i][0][$j]);
					if($dd==0){
						echo "User does not exist or blank in input file";exit;
					}
				}
			}

			for($i=0;$i<$highestRow;$i++){
			$tc = count($rowData[$i][0]);
				if($rowData[$i][0][7] == ""){
					echo "Department blank in input file";exit;
				}
				
			} 
			for($i=0;$i<$highestRow;$i++){
			$tc = count($rowData[$i][0]);
				if($rowData[$i][0][7] == ""){
					echo "Department blank in input file";exit;
				}
				for($j=7;$j<$tc;$j+=2){
					if($rowData[$i][0][$j]!=""){
						if($rowData[$i][0][$j+1]==""){
						echo "Department user is blank in input file";exit;
					}else{
						$dd= $this->checkUserExist($rowData[$i][0][$j+1]);
					if($dd==0){
						echo "User does not exist or blank in input file";exit;
					}
					}
					}
				}
			}
			

		//---------------------
		//for  dept check 
		

		
		
		$chk=0;
		for($i=0;$i<$highestRow;$i++){
			$tc = count($rowData[$i][0]);
			
			for($m=7;$m<$tc;$m+=2){
				for($n=$m+2;$n<$tc;$n+=2){
					if($rowData[$i][0][$m] != "" && $rowData[$i][0][$n])
					if(strnatcasecmp($rowData[$i][0][$m],$rowData[$i][0][$n])==0){
							
							$chk=1;break;
					}
				}
			}
		
		}
		
		if($chk==1){
			
			echo "Duplicate department in input file";exit;
		}

		for($i=0;$i<$highestRow;$i++){
			$tc=count($rowData[$i][0]);
			for($m1=7;$m1<$tc;$m1+=2){

				$checkRole=$this->checkRole($rowData[$i][0][$m1+1]);
				if($checkRole == 1){
						echo "Check user role";exit;
					}
				$checkUserDept = $this->checkUserDept($rowData[$i][0][$m1],$rowData[$i][0][$m1+1]);
				
					if($checkUserDept == 1){
						echo "User  department invalid in input file";exit;
					}
				
			}
		}
		for($i=0;$i<$highestRow;$i++){
			DB::table('tb_projectMaster')->insert(
          array(
              'project_code' => $rowData[$i][0][0],
              'project_description' => $rowData[$i][0][1],
              'change_stage'=>$this->getStage1($rowData[$i][0][2]),
              'project_manager'=>$this->getUser($rowData[$i][0][3]),
              'cust_comm_repres' => $this->getUser($rowData[$i][0][4]),
              'documentVerify' => $this->getUser($rowData[$i][0][5]),
              'finalApproval'=>$this->getUser($rowData[$i][0][6]),

          )
      );
 
			
		}
		for($i=0;$i<$highestRow;$i++){
			$tc=count($rowData[$i][0]);
			for($m1=7;$m1<$tc;$m1+=2){
				if($rowData[$i][0][$m1] != ""){

					
					DB::table('CFTTeamForProject')->insert(
			          array(
			              'project_code' => $rowData[$i][0][0],
			              'dept_id' =>$this->getDeptByName($rowData[$i][0][$m1]),
			              'user_id'=>$this->getUser($rowData[$i][0][$m1+1]),
			              'flag'	=>1,

			         	 )
			      		);
				}else{
					break;
				}
	 		
 			}
			
		}

		for($i=0;$i<$highestRow;$i++){
						$dept1=DB::table('tb_departments')
							->select('d_id')
							->where('d_id','!=',2)
							->where('d_id','!=',11)
							->get();
					 foreach ($dept1 as $key) {
					 	$checkDept=$this->checkDeptInCft($key->d_id,$rowData[$i][0][0]);
					 	if($checkDept == 1){
						 	DB::table('CFTTeamForProject')->insert(
					          array(
					              'project_code' => $rowData[$i][0][0],
					              'dept_id' =>$key->d_id,
					              'flag'	=>0,

					         	 )
					      		);
				 		}
					}

						
			
		}
		

               
		
		echo  "save";exit;

		

		

    }

     public function checkDeptInCft($did,$p_code){
     	
    	$data= DB::table('CFTTeamForProject')
    			->select('dept_id')
    			->where('dept_id',$did)
    			->where('project_code',$p_code)
    			->get();
    			
    			if(!empty($data)){
    				return 0;
    			}else{
    				return 1;
    			}
     }
    			
    	
    public function checkUserExist($name){
    	if($name == ''){
    		return 0;
    	}else{
    	$data = DB::table('tb_users')
    			->select('id')
    			->where('username',$name)
    			->get();
    			if(empty($data)){
    				return 0;
    			}else{
    				return 1;
    			}
    		}
    			
    			
    }
    public function getUser($name){
    	if($name != ""){
    		$data = DB::table('tb_users')
    			->select('id')
    			->where('username',$name)
    			->get();
    			
    			return $data[0]->id;
    
    }
	}
    public function getStage1($name){
    	if($name != ""){
    		$data = DB::table('tb_change_stage')
    			->select('change_stage_id')
    			->where('stage_name',$name)
    			->get();
    			return $data[0]->change_stage_id;
    		}
    }
    public function checkRole($user){
    	$data = DB::table('tb_users')
    			->select('department')
    			->where('username',$user)
    			->where('tb_users.group_id','LIKE','%3%')  
    			->where('active',1)  
    			->get();
    			if(!empty($data)){
    				return 0;
    			}else{
    				return 1;
    			}
    			
    }
    public function checkUserDept($dept,$user){
    	
    	$deptId= $this->getDeptByName($dept);
    	$data = DB::table('tb_users')
    			->select('department')
    			->where('username',$user)
    			->get();
    			
    			if(!empty($data)){
    			if($data[0]->department == $deptId){
    				return 0;
    			}else{
    				return 1;
    			}
    		}
    	
    }
    public function getDeptByName($dept){
    	if($dept != ""){
    	$data= DB::table('tb_departments')
    			->select('d_id')
    			->where('d_name',$dept)
    			->get();
    			return $data[0]->d_id;
    			}
    }

    public function checkPrjInDB($prj_code){

    	$data = DB::table('tb_projectMaster')
    			->select('id')
    			->where('project_code',$prj_code)
    			->get();
    			
    			return $data;
    }

    public function checkProjectTask(){
    	$input =Input::all();
    
    	$data=DB::table('changerequests')
    		  ->select('request_id')
    		  ->where('proj_code',$input['edit'])
    		  ->get();
    	foreach ($data as $key) {
    		$results=DB::table('request_progress_status')
    		         ->where('request_id',$key->request_id)
    		         ->where('close',0)
    		         ->get();
    	}
    	if(!empty($results)){
    		return 1;
    	}else{
    		return 0;
    	}

    }



		

		
}