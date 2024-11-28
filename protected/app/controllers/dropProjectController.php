<?php
class dropProjectController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'DropProject';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new DropProject();

		$this->info = $this->model->makeInfo( $this->module);

		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'HoldProject',
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
		$this->layout->nest('content','DropProject.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('apqp_drop_project'); 
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

		$this->layout->nest('content','DropProject.form',$this->data)->with('menus', $this->menus );	
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
		$this->layout->nest('content','DropProject.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		$trackUri = $this->data['trackUri'];
		$rules = $this->validateForm();
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('DropProject');
			//echo '<pre>';print_r($data);exit();
			try{
				if( Input::get('id') =='')
				 {
				 	$check  = DB::table('apqp_drop_project')
				 	         ->select('id')
				 	         ->where('project_id',$data['project_id'])
				 	         ->get();
				 	if(empty($check)){
				 		$ID = DB::table('apqp_drop_project')
						  ->insert(
						  		array(
					              'project_id' => $data['project_id'],
					              'remark' => $data['remark'],
					              'drop_proj_user_id' => session::get('uid'),
					              'CreateDate'=>date('Y-m-d H:i:s'),
					              'ip_address'=>$_SERVER['REMOTE_ADDR'],
                        		  'user_id' =>session::get('uid')
          						)
						  	);
						  DB::table('apqp_all_task')
						  ->where('project_id',$data['project_id'])
						  ->update(
						  		array(
					              'close' =>1,
					            )
						  	);


						  $user = DB::select(DB::raw("SELECT distinct(replace(responsibility,',','')) as res FROM apqp_draft_project_plan where project_id=".$data['project_id']));
				
				foreach($user as $u){
				
					$mailData = DB::table('tb_users')
								->select('tb_users.email','tb_users.first_name','tb_users.last_name')
								->whereIN('tb_users.id',[$u->res.',',$u->res])
								  	->get();


					$project =DB::table('apqp_new_project_info')
								->select('apqp_new_project_info.project_no','apqp_new_project_info.project_name')
								->where('apqp_new_project_info.id',$data['project_id'])
								 ->get();
								 //	print_r($project);exit();

								 
								 	$projInfo = ' Is Dropped';
								 
										$email = $mailData[0]->email;
								$data_1 = 
								array(
								'proj_id' => $project[0]->project_no,
							    'name' => $mailData[0]->first_name.' '.$mailData[0]->last_name,
								'projInfo' =>$projInfo,
								'remark'=>  $data['remark']
								);

									
							
	                  
			                    Mail::send('apqpEmails/DropInfoEmail', $data_1, function ($message) use ($email) {
			                        $message->to($email)->subject('Information Mail');
			                    });
			                
			                 
			                 
				}
							Session::flash('messagetext', 'Project dropped successfully.');	
							Session::flash('msgstatus','success');
							return Redirect::to('DropProject?md='.Input::get('md'));
						}else{
							 Session::flash('messagetext', 'Project already dropped.');	
							Session::flash('msgstatus','error');
							return Redirect::to('DropProject?md='.Input::get('md'));
						}
					}
					

			}catch (Illuminate\Database\QueryException $e){
			    $errorCode = $e->errorInfo[1];
			    if($errorCode == 1062){
			    	$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'DropProject/add/'.$id.'?md='.$md.$trackUri :  'DropProject/add/'.$id.'?md='.$md.$trackUri);
			      
			       Session::flash('messagetext', 'Duplicate Project');	
				Session::flash('msgstatus','error');
				return Redirect::to($redirect);

			    }
			}
			
			
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('HoldProject/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
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

	public function getReleasedPrj(){
		// $data= DB::table('apqp_new_project_info')
		// 		->select('apqp_new_project_info.*')
		// 		->whereIn('id',function($query){
		// 			$query->select ('project_id')->from ('apqp_draft_project_plan')->where ('release_project', 1);
		// 		})
		// 		->whereNotIn('id',function($query){
		// 			$query->select ('project_id')->from ('apqp_drop_project');
		// 		})
		// 		->get();

		$data =DB::select(DB::raw('select * from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1) '));
			$select="--Please Select--";
		echo '<option value=""';
			echo ' >'.$select.'</option>';
			foreach ($data as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->project_no.' Revision '.$key->project_revision.'</option>';
			}

		exit;
	}
			
		
}