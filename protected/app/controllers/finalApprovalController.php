<?php
class finalApprovalController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'FinalApproveCloser';
	static $per_page	= '10';

	
	public function __construct() {
	
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
	
		$this->model = new FinalApproveCloser();

		
		$this->info = $this->model->makeInfo($this->module);
		
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'FinalApproveCloser',
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
		
		//$this->data['CountOfRow']	=count($this->data['rowData']);
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
		
		$this->layout->nest('content','FinalApproveCloser.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('tb_finalApprovCloser'); 
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
		$this->data['id'] = $id;
		
		$this->layout->nest('content','FinalApproveCloser.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('tb_finalApprovCloser'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','FinalApproveCloser.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		
		$trackUri = $this->data['trackUri'];

		$rules = $this->validateForm();
		// print_r(Input::all());exit();
		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes()) {

			$data = $this->validatePost('tb_finalApprovCloser');
			if(!empty(Input::get('membermultiple'))){
			$data['membermultiple']=implode(',', Input::get('membermultiple'));
			}

			$allTblData=$this->getData();
			$flag = 0;
			foreach ($allTblData as $row) {
				if(Input::get('id') ==''){
				if($data['change_stage']==1){
				if($row['plant_code']  == $data['plant_code']  && $row['stakeholder']  == $data['stakeholder']  && $row['change_stage'] == $data['change_stage'] && $row['change_type'] == $data['change_type'] ){
					$flag = 1;
				}
			  }else{
			  	if($row['plant_code']  == $data['plant_code']  && $row['stakeholder']  == $data['stakeholder']  && $row['change_stage'] == $data['change_stage']){
					$flag = 1;
				}
			  }
			 }else{
			 	
			 	if($data['change_stage']==1){
			 		
				if($row['plant_code']  == $data['plant_code']  && $row['stakeholder']  == $data['stakeholder'] && $row['change_type'] == $data['change_type'] && $row['change_stage'] == $data['change_stage'] && $row['id'] != $data['id']){
					$flag = 1;

				}
			  }else{
			  	if($row['plant_code']  == $data['plant_code']  && $row['stakeholder']  == $data['stakeholder'] && $row['change_stage'] == $data['change_stage'] && $row['id'] != $data['id']){
			  		
					$flag = 1;
				}
			  }
			 }
			}
			// print_r($data);exit();
			if($flag == 1){
				Session::flash('messagetext', 'Member is already define.');	
				Session::flash('msgstatus','error');
				return Redirect::to('FinalApproveCloser');

			}
			
			// try{
			// $ID = $this->model->insertRow($data ,  Input::get('id'));
			// }catch (Illuminate\Database\QueryException $e){
			//     $errorCode = $e->errorInfo[1];
			//     if($errorCode == 1062){

			//     	$md = str_replace(" ","+",Input::get('md'));
			// $redirect = (!is_null(Input::get('apply')) ? 'FinalApproveCloser/add/'.$id.'?md='.$md.$trackUri :  'FinalApproveCloser/add/'.$id.'?md='.$md.$trackUri);
			//        Session::flash('messagetext', 'Duplicate record');	
			// 	Session::flash('msgstatus','error');
			// 	return Redirect::to($redirect);

			//     }
			// }
			
			// Input logs
			$ID = $this->model->insertRow($data ,  Input::get('id'));
			if( Input::get('id') =='')
			{
				$this->inputLogs("New Entry row with ID : $ID  , Has Been Save Successfull");
				$id = SiteHelpers::encryptID($ID);
			} else {
				$this->inputLogs(" ID : $ID  , Has Been Changed Successfull");
			}
			// Redirect after save	
			$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'FinalApproveCloser/add/'.$id.'?md='.$md.$trackUri :  'FinalApproveCloser?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('FinalApproveCloser/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
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

		return Redirect::to('FinalApproveCloser');
	}	

	public function getData(){
		$data= DB::table('tb_finalApprovCloser')->get();
		$allData =[];
		if(!empty($data)){
			foreach ($data as $row) {
				$allData[]  = array(
			'plant_code' => $row->plant_code,
			'stakeholder'	=> $row->stakeholder,
			'member'	=> $row->member,
			'change_stage'	=> $row->change_stage,
			'change_type'  =>$row->change_type,
			'membermultiple'=>$row->membermultiple,
			'id'           =>$row->id,
			 );
			}
		}
		return $allData;


	}

		public function get_SteeringComm($id){
			// echo 'get';exit();
		
		$users = DB::table('tb_users')
				->select('id','first_name','last_name')
				->where('active','=',1)
				->get();

		if($id=='s'){
			foreach ($users as $key ) {
				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->first_name.' '.$key->last_name.'</option>';
			}
		}else{
			$s_id=$id;
			foreach ($users as $key ) {
				echo '<option value="' . $key->id . '"';
				if (in_array($key->id, explode(",", $s_id))) {
					echo 'selected="selected"';
				}
				echo ' >' . $key->first_name .' '.$key->last_name.'</option>';
			}

		}
		exit;
	}
	
}