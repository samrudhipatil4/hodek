<?php
class cooapprovalauthorityController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'cooapprovalauthority';
	static $per_page	= '10';

	
	public function __construct() {
		
		parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
	
		$this->model = new cooapprovalauthority();

		
		$this->info = $this->model->makeInfo($this->module);
	
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'cooapprovalauthority',
			'trackUri' 	=> $this->trackUriSegmented()	
		);
				
			//echo "<pre>";print_r($this->data);exit;			
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
		
		$this->layout->nest('content','cooapprovalauthority.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable(' tb_cooapprovalauthority'); 
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

		$this->data['member']	= $this->model->coogetUser();	
		$this->data['id'] = $id;
		
		$this->layout->nest('content','cooapprovalauthority.form',$this->data)->with('menus', $this->menus );	
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
			$this->data['row'] = $this->model->getColumnTable(' tb_cooapprovalauthority'); 
		}
		$this->data['masterdetail']  = $this->masterDetailParam(); 
		$this->data['id'] = $id;
		$this->data['access']		= $this->access;
		$this->layout->nest('content','cooapprovalauthority.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		
		$trackUri = $this->data['trackUri'];

		$rules = $this->validateForm();

		$validator = Validator::make(Input::all(), $rules);	
		
		if ($validator->passes()) {

			$data = $this->validatePost('tb_cooapprovalauthority');
			
			$allTblData=$this->getCustCommData();
			$flag = 0;
			foreach ($allTblData as $row) {
				if(Input::get('id') ==''){
				if($row['plant_code']  == $data['plant_code'] && $row['change_stage']  == $data['change_stage'] && $row['stakeholder']  == $data['stakeholder'] && $row['change_type']  == $data['change_type'] && $row['userId']  == $data['userId'] ){
					$flag = 1;
				}
			  }else{
			  	if($row['plant_code']  == $data['plant_code'] && $row['change_stage']  == $data['change_stage'] && $row['stakeholder']  == $data['stakeholder'] && $row['change_type']  == $data['change_type'] && $row['id']  != $data['id'] ){
					$flag = 1;
				}
			  }
			}
			if($flag == 1){
				Session::flash('messagetext', 'Duplicate member');	
				Session::flash('msgstatus','error');
				return Redirect::to('cooapprovalauthority');

			}
		
			$ID = $this->model->insertRow($data , $data['id']);
			
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
			$redirect = (!is_null(Input::get('apply')) ? 'cooapprovalauthority/add/'.$id.'?md='.$md.$trackUri :  'cooapprovalauthority?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('cooapprovalauthority/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
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

		return Redirect::to('cooapprovalauthority');
	}

	public function getCustCommData(){
		$data= DB::table('tb_cooapprovalauthority')->get();
		$allData =[];
		if(!empty($data)){
			foreach ($data as $row) {
				$allData[]  = array(
			'change_stage' => $row->change_stage,
			'stakeholder' => $row->stakeholder,
			'plant_code'  => $row->plant_code,
			'change_type' => $row->change_type,
			'userId'      => $row->userId,
			'id'          =>$row->id,
			 );
			}
		}
		return $allData;


	}	

	
}