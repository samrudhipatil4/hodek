<?php
class SteeringCommiteeController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'SteeringCommiteeMember';
	static $per_page	= '10';

	
	public function __construct() {
		
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
	
		$this->model = new SteeringCommiteeMember();

		
		$this->info = $this->model->makeInfo($this->module);
		//echo "<pre>";print_r($this->info);exit;
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'SteeringCommiteeMember',
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
		
		$this->data['CountOfRow']	=count($this->data['rowData']);
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
		//echo "<pre>";print_r($this->data['tableGrid']);exit;
		$this->layout->nest('content','SteeringCommiteeMember.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('tb_dynamicSteeringCommitee'); 
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
		$this->data['steerComm']	= $this->model->getSteeringComm();

		$this->data['id'] = $id;
		
		$this->layout->nest('content','SteeringCommiteeMember.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable('tracking_sheet_date_param'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','SteeringCommiteeMember.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		
		$trackUri = $this->data['trackUri'];
		$rules = $this->validateForm();
		$input=Input::all();
		$validator = Validator::make(Input::all(), $rules);	
		// print_r($input['change_stage']);exit();
		if($input['change_stage']==1 && $input['change_type']==''){
			if(Input::get('id') ==''){
				Session::flash('messagetext', 'Please select change type');	
				Session::flash('msgstatus','error');
				return Redirect::to('SteeringCommiteeMember/add?md=');
			}else{
				Session::flash('messagetext', 'Please select change type');	
				Session::flash('msgstatus','error');
				$md = str_replace(" ","+",Input::get('md'));
				return Redirect::to('SteeringCommiteeMember/add/'.$id.'?md='.$md);
			}
		}

		if ($validator->passes()) {

			$data = $this->validatePost('tb_dynamicSteeringCommitee');
			
			$data['steeringComm_id']=implode(',', Input::get('steeringComm_id'));
			$allmem = Input::get('steeringComm_id');
			$cnt1 = count($allmem);
			$chk=0;
			for($j=0;$j<$cnt1;$j++){
				if($allmem[$j] == $data['cust_comm_decision']){
					$chk = 1;
					break;
				}
			}
			if($chk == 0){
				Session::flash('messagetext', 'steering committtee member and customer communication shold be same');	
				Session::flash('msgstatus','error');
				return Redirect::to('SteeringCommiteeMember/add?md=');

			}
			$allTblData=$this->getAllData();
			
			
			$flag = 0;
			foreach ($allTblData as $row) {
				if(Input::get('id') ==''){
				if($data['change_stage']==1){
					if($row['plant_id']  == $data['plant_id'] && $row['change_stage'] == $data['change_stage'] && $row['stakeholder'] == $data['stakeholder']&& $row['change_type'] == $data['change_type'] ){
					$flag = 1;
				}
				}else{
				if($row['plant_id']  == $data['plant_id'] && $row['change_stage'] == $data['change_stage'] && $row['stakeholder'] == $data['stakeholder'] ){
					$flag = 1;
				}
			  }
			 }else{
			 		if($data['change_stage']==1){
					if($row['plant_id']  == $data['plant_id'] && $row['change_stage'] == $data['change_stage'] && $row['stakeholder'] == $data['stakeholder'] && $row['change_type'] == $data['change_type'] && $row['id'] != $data['id'] ){
					$flag = 1;
				}
				}else{
				if($row['plant_id']  == $data['plant_id'] && $row['change_stage'] == $data['change_stage'] && $row['stakeholder'] == $data['stakeholder'] && $row['id'] != $data['id'] ){
					$flag = 1;
				}
			  }
			 }
			}
			if($flag == 1){
				Session::flash('messagetext', 'Duplicate member');	
				Session::flash('msgstatus','error');
				return Redirect::to('SteeringCommiteeMember');

			}
			$ID = $this->model->insertRow($data , Input::get('id'));
			
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
			$redirect = (!is_null(Input::get('apply')) ? 'SteeringCommiteeMember/add/'.$id.'?md='.$md.$trackUri :  'SteeringCommiteeMember?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('SteeringCommiteeMember/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
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

		return Redirect::to('SteeringCommiteeMember');
	}	


	public function get_SteeringComm($id){
		
		$users = DB::table('tb_users')
				->select('id','first_name','last_name')
				->where('department','=',11)
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