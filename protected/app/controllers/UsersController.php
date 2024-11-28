<?php
class UsersController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'users';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Users();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'	=> 'users'
		);
			
				
	} 
	
	public function getIndex()
	{
		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));
				
		// Filter sort and order for query 
		$sort = (!is_null(Input::get('sort')) ? Input::get('sort') : 'id'); 
		$order = (!is_null(Input::get('order')) ? Input::get('order') : 'asc');
		// End Filter sort and order for query 
		// Filter Search for query 
		$filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
		// End Filter Search for query 
		$filter .= " AND id !='1' AND tb_groups.level >= ".Session::get('gid')."";
		
		$page = Input::get('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null(Input::get('rows')) ? filter_var(Input::get('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter
		);
		// Get Query 
		$results = $this->model->getRows( $params );
		
		
		
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = Paginator::make($results['rows'], $results['total'],$params['limit']);		
		
		
		$this->data['rowData']		= $results['rows'];
		$this->data['pagination']	= $pagination;
		$this->data['pager'] 		= $this->injectPaginate();	
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= SiteHelpers::viewColSpan($this->info['config']['grid']);	
		$this->data['access']		= $this->access;
		
		$this->layout->nest('content','users.index',$this->data)
						->with('menus', SiteHelpers::menus());
	}	
	
	function getAdd( $id = null)
	{

		if($this->access['is_view'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));
			
		$id = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;
		$row = $this->model->find($id);
//print_r($row);exit;
		if($row)
		{

			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
		}
		$res = DB::table('tb_groups')->where('group_id',Session::get('gid'))->get();
		
		$res = $res[0];

		$this->data['level'] = $res->level;		
		$this->data['id'] = $id;
		//$this->data['group']=$res->group_id;



		$this->layout->nest('content','users.form',$this->data)->with('menus', $this->menus );	
	}
	
	function getShow( $id = null)
	{
	
		if($this->access['is_detail'] ==0) 
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));
					
		$ids = ($id == null ? '' : SiteHelpers::encryptID($id,true)) ;
		$row = $this->model->getRow($ids);

		if($row)
		{
			$this->data['row'] =  $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_users'); 
		}
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','users.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{//print_r("expression");exit;
		$data = $this->validatePost('tb_users');
		//echo '<pre>';print_r($data);exit();
		$users = DB::table('tb_users')->select('email','username','department')->where('id', '=', $data['id'])->first();
			if(!empty($users->department)){
				
			if($users->department != $data['department']){
				
			$data1 = DB::table('request_progress_status')
					->select(DB::raw('count(status) as total'))
					->where('assigned_to',$data['id'])
					->where('close',0)
					->get();
					if($data1[0]->total > 0){
						Session::flash('messagetext', 'User have pending task.You can not change department');	
				Session::flash('msgstatus','error');
				return Redirect::to('users/add/'.$id);
			}

					}
		}
		$rules = array(
			'active'		=> 'required',
			'first_name'	=> 'required',
			//'email'	=> 'required|email|unique:tb_users',

		);

		if($data['active'] == 0){
			$data = DB::table('request_progress_status')
					->select(DB::raw('count(status) as total'))
					->where('assigned_to',$data['id'])
					->where('close',0)
					->get();
					if($data[0]->total > 0){
						Session::flash('messagetext', 'User have pending task.You can not change status');	
				Session::flash('msgstatus','error');
				return Redirect::to('users/add/'.$id);


					}
		}

		if(isset($data[0]->total ))
		{
			$activeu=0;
		}else{
			$activeu=1;
		}
		if($activeu==1){
		$f=0;
		
		$checkDupHod = DB::table('tb_users')
					->select('group_id')
					->where('department',$data['department'])
					->where('active',1);
					if(isset($data['sub_department'])){
						$checkDupHod->where('sub_department',$data['sub_department']);
					}
					if($data['id'] != ""){
						$checkDupHod->where('id','!=',$data['id']);
					}
					$checkDupHod1=$checkDupHod->get();
		
		
		
		
		if(!empty($checkDupHod1)){
			foreach ($checkDupHod1 as $key) {
				
				$group = explode(',',$key->group_id);
				
				if(in_array(4, $group)==1){
					$f=1;
					break;
				}

				
			}
		}
		
	
		$inrow=in_array(4, Input::get('group_id'));
		if($inrow != ""){
		if($f==$inrow){
					if($id != ""){
					Session::flash('messagetext', 'HOD not repetted for same department');		
				Session::flash('msgstatus','error');
				return Redirect::to('users/add/'.$id);
				}else{
					
					Session::flash('messagetext', 'HOD not repetted for same department');		
				Session::flash('msgstatus','error');
				return Redirect::to('users/add/');
				}
				}
			}
		}

		$u_id = Input::get('id');
		$gid = Input::get('group_id');
		
		if($u_id != ""){
		$userRole = DB::table('tb_users')
					->select('group_id')
					->where('id',$u_id)
					->get();
		
		$role = explode(',',$userRole[0]->group_id);
		//print_r($role);
		//print_r($data['group_id']);exit();
		$res = array_diff($role, $gid);
		}
		$msg = "";
		if(!empty($res)){

			foreach ($res as $row) {
				if($row == 2){
					$data = $this->cntpendingTask($data['id'],3,2);
					
					if($data[0]->total != 0){
						$msg = "User have update intial info. sheet Pending task";
					}
				}
				if($row == 3){
					$data = $this->cntRiskTask($data['id']);
					if($data[0]->total != 0){
						$msg = "User have risk entry pending task";
					}

				}
				if($row == 4){
					$data = $this->cntpendingTask($data['id'],7,1);
					
					if($data[0]->total != 0){
						$msg = "User have Dept. HOD approval Pending task";
					}
				}
				if($row == 11){
					$data = $this->cntcustpendingTask($data['id'],12);
					if($data[0]->total != 0){
						$msg = "Pending Customer Approval from responsible person.";
					}
				}
			}
		}
		if($msg != ""){
				Session::flash('messagetext', $msg);	
				Session::flash('msgstatus','error');
				return Redirect::to('users/add/'.$id);
			}


		if(isset($users->email) && !empty($users->email)){//echo "first";exit;

			if(Input::get('email') == $users->email){


			}else{

				$rules['email'] 				= 'required|email|unique:tb_users';


			}
			
		}

		if(isset($users->username) && !empty($users->username)){//echo "first";exit;

			if(Input::get('username') == $users->username){


			}else{


				$rules['username'] 				= 'required|unique:tb_users';


			}
			//$rules['email'] 				= 'required|email|unique:tb_users';
				//Input::get('email') == $users->email;
		}



			if(Input::get('id') =='')
		{
			$rules['password'] 				= 'required|between:6,12|confirmed';
			$rules['password_confirmation'] = 'required|between:6,12';
			$rules['email'] 				= 'required|email|unique:tb_users';
			$rules['username'] 				= 'required|min:2|unique:tb_users';
			
		} else {
			if(Input::get('password') !='')
			{
				$rules['password'] 				='required|between:6,12|confirmed';
				$rules['password_confirmation'] ='required|between:6,12';	
				//$rules['email'] 				= 'required|email|unique:tb_users';
			   // $rules['username'] 				= 'required|min:2|unique:tb_users';		
			}
		}
		//print_r(Input::all());exit;
		$validator = Validator::make(Input::all(), $rules);	


		if ($validator->passes()) {
			$data = $this->validatePost('tb_users');
			if(Input::get('id') =='')
			{
				$data['password'] = Hash::make(Input::get('password'));
			} else {
				if(Input::get('password') !='')
				{
					$data['password'] = Hash::make(Input::get('password'));
				}
			}


				$data['group_id']=implode(',', Input::get('group_id'));//For multiple group_id


			//print_r($data);exit;
				try{
				$this->model->insertRow($data , Input::get('id'));
				}catch (Illuminate\Database\QueryException $e){
			    $errorCode = $e->errorInfo[1];
			    if($errorCode == 1062){

			    	$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'users/add/'.$id.'?md='.$md.$trackUri :  'users/add/'.$id.'?md='.$md.$trackUri);
			       Session::flash('messagetext', 'Duplicate user name');	
				Session::flash('msgstatus','error');
				return Redirect::to($redirect);

			    }
			}
			return Redirect::to('users')->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
		} else {
			return Redirect::to('users/add/'.$id)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
	}
	
	public function postDestroy()
	{
		// delete multipe rows 
		if(count(Input::get('id')) >=1)
		{		
			$data = $this->model->destroy(Input::get('id'));
			Session::flash('messagetext', 'Successfully deleted row!');
			Session::flash('msgstatus','success');	
		} else {
			Session::flash('messagetext', 'No Item Deleted');	
			Session::flash('msgstatus','error');			
		}	
		// redirect
		
		return Redirect::to('users');
	}	

		public function sub_department_ajax($id=null)
	{
		//echo"string";
		$id=Input::get('dep_id');
		//echo $id;exit;
		$select="Please Select Sub-Function";




		 $users = DB::table('subdepartments')->select('sub_dep_id','department_id','sub_dep_name')->where('department_id', '=', $id)->get();

		 echo '<select name="sub_department" rows="5" >';

		echo '<option value=" "';
		echo ' >'.$select.'</option>';
		 foreach ($users as $key ) {
		 	# code...


		 	echo '<option value="'. $key->sub_dep_id. '"';
		 	//echo 'selected="selected"';
			echo	'>' .$key->sub_dep_name.'</option>';




		 }

		 echo '</select>';

		 exit;
		
	}


	public function group_ajax($id){
		
		$users = DB::table('tb_role')->select('role_name','role_id')->where('role_id','!=',5)->where('role_id','!=',6)->get();

		if($id=='s'){


			foreach ($users as $key ) {

				echo '<option value="'. $key->role_id. '"';
				echo ' >'.$key->role_name.'</option>';
			}


		}else{
		$selectedusers = DB::table('tb_users')->select('group_id')->where('id', '=', $id)->first();
		$s_id=$selectedusers->group_id;

		foreach ($users as $key ) {

			echo '<option value="' . $key->role_id . '"';

			if (in_array($key->role_id, explode(",", $s_id))) {
				echo 'selected="selected"';
			}
			echo ' >' . $key->role_name . '</option>';

		}

		}


		exit;

	}

	public function department_ajax($id){//print_r($id);
		$users = DB::table('tb_departments')->select('d_id','d_name')->where('d_id','!=',11)->get();
		$select="Please Select Function";
		if($id=='s'){

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {


				echo '<option value="'. $key->d_id. '"';
				echo ' >'.$key->d_name.'</option>';
			}


		}else{
			$selectedusers = DB::table('tb_users')->select('department')->where('id', '=', $id)->first();
			$s_id=$selectedusers->department;

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="' . $key->d_id . '"';

				if (in_array($key->d_id, explode(",", $s_id))) {
					echo 'selected="selected"';
				}
				echo ' >' . $key->d_name . '</option>';

			}

		}


		exit;

	}

	public function subdepartment_ajax($id,$user_id){//echo "hi";exit;

		$users = DB::table('subdepartments')->select('sub_dep_id','department_id','sub_dep_name')->where('department_id', '=', $id)->get();
		$select="Please Select Sub-Function";
		if($id=='s'){//echo "in s";exit;

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="'. $key->sub_dep_id. '"';
				echo ' >'.$key->sub_dep_name.'</option>';
			}


		}else{



			$selectedusers = DB::table('tb_users')->select('sub_department')->where('id', '=', $user_id)->first();
			$s_id=$selectedusers->sub_department;

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="' . $key->sub_dep_id . '"';

				if (in_array($key->sub_dep_id, explode(",", $s_id))) {
					echo 'selected="selected"';
				}
				echo ' >' . $key->sub_dep_name . '</option>';

			}

		}


		exit;

	}

	public function cntRiskTask($u_id){
			$data = DB::table('request_progress_status')
					->select(DB::raw('count(status) as total'))
					->where('close',0)
					->whereIn('status',array(6,9,11,99))
					->where('assigned_to',$u_id)
					->get();

					return $data;
		}

		public function cntpendingTask($u_id,$status,$status1){
			$data = DB::table('request_progress_status')
					->select(DB::raw('count(status) as total'))
					->where('close',0)
					->whereIn('status',array($status,$status1))
					->where('assigned_to',$u_id)
					->get();

					return $data;
		}
		public function cntcustpendingTask($u_id,$status){
			$data = DB::table('request_progress_status')
					->select(DB::raw('count(status) as total'))
					->where('close',0)
					->where('status',$status)
					->where('assigned_to',$u_id)
					->get();

					return $data;
		}

		
}