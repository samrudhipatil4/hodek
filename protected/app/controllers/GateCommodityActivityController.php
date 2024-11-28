<?php
class GateCommodityActivityController extends BaseController {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'GateCommodityActivity';
	static $per_page	= '10';
	
	public function __construct() {
		parent::__construct();

		$this->beforeFilter('csrf', array('on'=>'post'));
		$this->model = new GateCommodityActivity();

		$this->info = $this->model->makeInfo( $this->module);
		$this->access = $this->model->validAccess($this->info['id']);
	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'GateCommodityActivity',
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
		//echo "<pre>";print_r($this->data);exit();
		$this->layout->nest('content','GateCommodityActivity.index',$this->data)
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
			$this->data['row'] = $this->model->getColumnTable('apqp_gate_activity_master'); 
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

		$this->layout->nest('content','GateCommodityActivity.form',$this->data)->with('menus', $this->menus );	
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
		$this->layout->nest('content','changetype.view',$this->data)->with('menus', $this->menus );	
	}	
	
	function postSave( $id =0)
	{
		
		$trackUri = $this->data['trackUri'];
		$rules = $this->validateForm();
		$validator = Validator::make(Input::all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost('apqp_gate_activity_master');

			try{
		if(Input::get('id') !='' && Input::get('id') == Input::get('previous_reference_activity')){
			$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'GateCommodityActivity/add/'.$id.'?md='.$md.$trackUri :  'GateCommodityActivity/add/'.$id.'?md='.$md.$trackUri);
			  Session::flash('messagetext', 'You can not select self-depaendant activity');	
			Session::flash('msgstatus','error');
			return Redirect::to($redirect);	
		}
				
if( Input::get('id') !='' &&  Input::get('active') == 0)
{
	$checkdependancy=$this->checkdependancy(Input::get('id'));
				
	if($checkdependancy == 1){
		$md = str_replace(" ","+",Input::get('md'));
		$redirect = (!is_null(Input::get('apply')) ? 'GateCommodityActivity/add/'.$id.'?md='.$md.$trackUri :  'GateCommodityActivity/add/'.$id.'?md='.$md.$trackUri);
		  Session::flash('messagetext', 'You can not inactive activity.It is depaendant activity');	
		Session::flash('msgstatus','error');
		return Redirect::to($redirect);	
	}
}

			$ID = $this->model->insertRow($data , Input::get('id'));

			
			
			}catch (Illuminate\Database\QueryException $e){
			    $errorCode = $e->errorInfo[1];
			    if($errorCode == 1062){
			    	$md = str_replace(" ","+",Input::get('md'));
			$redirect = (!is_null(Input::get('apply')) ? 'GateCommodityActivity/add/'.$id.'?md='.$md.$trackUri :  'GateCommodityActivity/add/'.$id.'?md='.$md.$trackUri);
			      
			       Session::flash('messagetext', 'Duplicate activity');	
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
			$redirect = (!is_null(Input::get('apply')) ? 'GateCommodityActivity/add/'.$id.'?md='.$md.$trackUri :  'GateCommodityActivity?md='.$md.$trackUri );
			return Redirect::to($redirect)->with('messagetext',Lang::get('core.note_success'))->with('msgstatus','success');
			
		} else {
			$md = str_replace(" ","+",Input::get('md'));
			return Redirect::to('GateCommodityActivity/add/'.$id.'?md='.$md)->with('messagetext',Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
		}	
	
	}
	public function checkdependancy($aid){
		$data = DB::table('apqp_gate_activity_master')
				->select('activity')
				->where('previous_reference_activity',$aid)
				->where('active',1)
				->get();
				if(empty($data)){
					return 0;
				}else{
					return 1;
				}
	}
	
	public function postDestroy()
	{
		
		
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')
				->with('messagetext', Lang::get('core.note_restric'))->with('msgstatus','error');
	
		if(count(Input::get('id')) >=1)
		{
			$id=Input::get('id');
			
			//echo $id[0];exit();
			$checkPrevRef = DB::table('apqp_gate_activity_master')
							->select('id')
							->where('previous_reference_activity',$id[0])
							->get();
			$checkInProject=DB::table('apqp_draft_project_plan')
							->select('release_project')
							->where('activity',$id[0])
							->get();			
				if(!empty($checkPrevRef) || (!empty($checkInProject))){
					Session::flash('messagetext', 'You can not delete activity.');	
			Session::flash('msgstatus','error');
				}else{
					$this->model->destroy(Input::get('id'));
				$this->inputLogs("ID : ".implode(",",Input::get('id'))."  , Has Been Removed Successfull");
				Session::flash('messagetext', Lang::get('core.note_success_delete'));
				Session::flash('msgstatus','success');		
				}		
			
		} else {

			Session::flash('messagetext', 'No Item Deleted');	
			Session::flash('msgstatus','error');		
		}

		return Redirect::to('GateCommodityActivity?md='.Input::get('md'));
	}

	public function getActivity(){
		$input = Input::all();
		
		if(isset($input['commodity'])){
			$comm=$input['commodity'];
		}else{
			$comm=NULL;
		}

		$users = DB::table('apqp_gate_activity_master')
				->select('id','activity')
				->where('gate_id',$input['gate'])
				->where('activity_type',$input['activity_type'])
				->where('active',1)
				->where('commodity',$comm)
				->where('template',$input['template'])
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

	public function getCommodity(){

		$users = DB::table('apqp_commodity_master')->select('id','commodity_description')->get();
		$select="--Please Select--";
	

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->commodity_description.'</option>';
			}

		exit;
	
	}

	

	public function getAllGate(){

$users = DB::table('apqp_gate_management_master')
		->select('id','Gate_Description')
		->where('apqp_gate_management_master.Is_Active',1)
	    ->orderby('id')
        ->get();
		$select="--Please Select--";
	

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			foreach ($users as $key ) {

				echo '<option value="'. $key->id. '"';
				echo ' >'.$key->Gate_Description.'</option>';
			}

		exit;
	}

	public function getUserDefinedActivity(){
		$select="--Please Select--";
	

			echo '<option value=" "';
			echo ' >'.$select.'</option>';
			
				

				echo '<option value="C">Common
				</option>';
				echo '<option value="M">Commodity
				</option>';
				

		exit;
	}		
		
}