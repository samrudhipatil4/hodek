<?php
class QaController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'qa';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new Qa();
		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'qa',
			//'trackUri' 	=> $this->trackUriSegmented()	
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
		
		$this->layout->nest('content','qa.index',$this->data)
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



		$this->layout->nest('content','qa.form',$this->data)->with('menus', $this->menus );	
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
		$this->layout->nest('content','qa.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{//print_r("expression");exit;
		$data = $this->validatePost('tb_users');
		$users = DB::table('tb_users')->select('email','username')->where('id', '=', $data['id'])->first();


			//print_r($users->email);exit;
		$rules = array(
			'active'		=> 'required',
			'first_name'	=> 'required',
			//'email'	=> 'required|email|unique:tb_users',

		);

		if(isset($users->email) && !empty($users->email)){//echo "first";exit;

			if(Input::get('email') == $users->email){


			}else{

				$rules['email'] 				= 'required|email|unique:tb_users';


			}
			//$rules['email'] 				= 'required|email|unique:tb_users';
				//Input::get('email') == $users->email;
		}/*else {echo "second";exit;
			$rules['email'] 				= 'required|email|unique:tb_users';

		}*/
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


			//	$data['group_id']=implode(',', Input::get('group_id'));//For multiple group_id


			//print_r($data);exit;

			$this->model->insertRow($data , Input::get('id'));

			return Redirect::to('qa')->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
		} else {
			return Redirect::to('qa/add/'.$id)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
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
		
		return Redirect::to('qa');
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
		$users = DB::table('tb_role')->select('role_name','role_id')->where('role_id','=',6)->get();

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
		$users = DB::table('tb_departments')->select('d_id','d_name')->where('d_id','=',4)->get();
		//$select="Please Select Function";
		if($id=='s'){

			foreach ($users as $key ) {


				echo '<option value="'. $key->d_id. '"';
				echo ' >'.$key->d_name.'</option>';
			}


		}else{
			$selectedusers = DB::table('tb_users')->select('department')->where('id', '=', $id)->first();
			$s_id=$selectedusers->department;

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
		
		if($id=='s'){
			foreach ($users as $key ) {

				echo '<option value="'. $key->sub_dep_id. '"';
				echo ' >'.$key->sub_dep_name.'</option>';
			}


		}else{



			$selectedusers = DB::table('tb_users')->select('sub_department')->where('id', '=', $user_id)->first();
			$s_id=$selectedusers->sub_department;


			$result=DB::table('subdepartments')->select('sub_dep_name')->where('sub_dep_id', '=', $s_id)->first();
			
			$s_id1=$result->sub_dep_name;
			
		     echo $s_id1;
		

		}


		exit;

	}

		
}
