<?php
use Carbon\Carbon;
session_start();
class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	//public $menus ='';

	public function __construct() {

		$this->menus = SiteHelpers::menus();
		$this->sidebar = SiteHelpers::menus('sidebar');
		
		
		$driver = Config::get('database.default');
		$database = Config::get('database.connections');
		$this->db = $database[$driver]['database'];


	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	function prepare()
	{

		$info = $this->model->makeInfo( $this->module);
		$data = array(
			'tableGrid' => $this->info['grid']
		);
		return $data;

	}

	function infoTable()
	{
		$info = $this->model->makeInfo( $this->module);
		return $info['module_config']['grid'];
	}

	function getDownload()
	{

		if($this->access['is_excel'] ==0)
			return Redirect::to('')
				->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));

		$info = $this->model->makeInfo( $this->module);
		// Take param master detail if any
		$filter = (!is_null(Input::get('search')) ? $this->buildSearch() : '');
		$master  = $this->buildMasterDetail();
		$filter .=  $master['masterFilter'];
		$masterParam  = $this->masterDetailParam();
		$params = array(
			'params'	=> $filter
		);

		$results 	= $this->model->getRows( $params );
		$fields		= $info['config']['grid'];
		$rows		= $results['rows'];

		$content = $this->data['pageTitle'];
		$content .= '<table border="1">';
		$content .= '<tr>';
		foreach($fields as $f )
		{
			if($f['download'] =='1') $content .= '<th style="background:#f9f9f9;">'. $f['label'] . '</th>';
		}
		$content .= '</tr>';

		foreach ($rows as $row)
		{
			$content .= '<tr>';
			foreach($fields as $f )
			{
				if($f['download'] =='1'):
					$conn = (isset($f['conn']) ? $f['conn'] : array() );
					$content .= '<td>'. SiteHelpers::gridDisplay($row->$f['field'],$f['field'],$conn) . '</td>';
				endif;
			}
			$content .= '</tr>';
		}
		$content .= '</table>';

		@header('Content-Type: application/ms-excel');
		@header('Content-Length: '.strlen($content));
		@header('Content-disposition: inline; filename="'.$title.' '.date("d/m/Y").'.xls"');

		echo $content;
		exit;


		//return View::make('excel',$this->data);
	}
	function getDownload1()
	{

		$query =DB::table('tb_dynamicSteeringCommitee')
            
            ->leftJoin('tb_stakeholder', 'tb_dynamicSteeringCommitee.stakeholder', '=', 'tb_stakeholder.id')
            
            ->leftJoin('tb_change_stage', 'tb_dynamicSteeringCommitee.change_stage', '=', 'tb_change_stage.change_stage_id')
            
             ->leftJoin('plant_code', 'tb_dynamicSteeringCommitee.plant_id', '=', 'plant_code.plant_id')
             
            ->leftJoin('tb_users', 'tb_dynamicSteeringCommitee.steeringComm_id', '=', 'tb_users.id')
            
            ->select('tb_dynamicSteeringCommitee.*', 'tb_stakeholder.name', 'tb_dynamicSteeringCommitee.id as t_id', 'tb_change_stage.stage_name', 'tb_users.*','plant_code.plant_code')
            ->get();
           
            
            
         
        //   return $userjobs;

        foreach ($query as $user){
            $data[] = array(
                'id'		=>$user->t_id,
               'plant_code' =>$user->plant_code,
                'stage_name' => $user->stage_name,
                'stakeholder'	=>$user->name,
                'cust_comm_user' =>$this->getCustCommMem($user->cust_comm_decision),
                'steer_member' =>$this->steer_member($user->steeringComm_id)
               


            );
        }
      
        $filename=date('Y-m-d');
        
                $output =  View::make('SteeringCommiteeMember/csv_download',compact('data'));

              
                $headers = array(
                    'Pragma' => 'public',
                    'Expires' => 'public',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Cache-Control' => 'private',
                    'Content-Type' => 'application/vnd.ms-excel',
                    'Content-Disposition' => 'attachment; filename='.$filename.'.xls',
                    'Content-Transfer-Encoding' => ' binary'
                );
                return Response::make($output, 200, $headers);
            
             return Redirect::to('SteeringCommiteeMember')->with(compact('data'));

          

	}
	 function getDownload2()
	{
		
		$query =DB::table('tb_dynamicDepartment')
            
            ->leftJoin('tb_stakeholder', 'tb_dynamicDepartment.stakeholder', '=', 'tb_stakeholder.id')
            
            ->leftJoin('tb_change_stage', 'tb_dynamicDepartment.change_stage', '=', 'tb_change_stage.change_stage_id')
            
             ->leftJoin('plant_code', 'tb_dynamicDepartment.plantCode', '=', 'plant_code.plant_id')
             
            ->leftJoin('tb_departments', 'tb_dynamicDepartment.department', '=', 'tb_departments.d_id')
            
            ->select('tb_dynamicDepartment.*', 'tb_stakeholder.name', 'tb_dynamicDepartment.id as t_id', 'tb_change_stage.stage_name', 'tb_departments.*','plant_code.plant_code')
            ->get();
           
            
            
         
        //   return $userjobs;

        foreach ($query as $user){
            $data[] = array(
                'id'		=>$user->t_id,
               'plant_code' =>$user->plant_code,
                'stage_name' => $user->stage_name,
                'stakeholder'	=>$user->name,
                'departments' =>$this->getDwnDept($user->department),
                
               


            );
        }
    	
        $filename=date('Y-m-d');
             
                $output =  View::make('DepartmentList/csv_download',compact('data'));

                $headers = array(
                    'Pragma' => 'public',
                    'Expires' => 'public',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Cache-Control' => 'private',
                    'Content-Type' => 'application/vnd.ms-excel',
                    'Content-Disposition' => 'attachment; filename='.$filename.'.xls',
                    'Content-Transfer-Encoding' => ' binary'
                );
                return Response::make($output, 200, $headers);

            
             return Redirect::to('DepartmentList')->with(compact('data'));

	}
	function getDownload3()
	{
	
		$query =DB::table('tb_projectMaster')
		->leftJoin('tb_change_stage', 'tb_projectMaster.change_stage', '=', 'tb_change_stage.change_stage_id')
            ->select('tb_projectMaster.*', 'tb_change_stage.stage_name')
            ->get();
           
            
           
         
        //   return $userjobs;

        foreach ($query as $user){
            $data[] = array(
                'id'		=>$user->id,
                'Prj_code'  =>$user->project_code,
                'stage_name' => $user->stage_name,
                'proj_manager' => $this->getName($user->project_manager),
                'cust_comm_repres' => $this->getName($user->cust_comm_repres),
                'docVerifier' => $this->getName($user->documentVerify),
                'finalApproval' => $this->getName($user->finalApproval),
                'prjDept'		=> $this->getPrjDept($user->project_code)
           );
             
        }
      
    	
        $filename=date('Y-m-d');
             
                $output =  View::make('projectMaster/csv_download',compact('data'));

                $headers = array(
                    'Pragma' => 'public',
                    'Expires' => 'public',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Cache-Control' => 'private',
                    'Content-Type' => 'application/vnd.ms-excel',
                    'Content-Disposition' => 'attachment; filename='.$filename.'.xls',
                    'Content-Transfer-Encoding' => ' binary'
                );
                return Response::make($output, 200, $headers);

            
             return Redirect::to('DepartmentList')->with(compact('data'));

	}
	function getPrjDept($code){
		$data=DB::table('CFTTeamForProject')
			  ->leftjoin('tb_departments','CFTTeamForProject.dept_id','=','tb_departments.d_id')
			  ->leftjoin('tb_users','CFTTeamForProject.user_id','=','tb_users.id')
			  ->select('d_name','first_name','last_name')
			  ->where('project_code',$code)
			  ->where('flag',1)
			  ->get();
			  return $data;
	}
	function getName($id){
		$data=DB::table('tb_users')
			  ->select('first_name','last_name')
			  ->where('id',$id)
			  ->get();
			  return $data;
	}

	 function getDwnDept($dept){

		$exc = explode(',', $dept);

		for ($i=0;$i<count($exc);$i++) {
			
		
		$data[] = DB::table('tb_departments')
				->select('d_id','d_name')
				->where('d_id',$exc[$i])
				->get();
			}	
			return $data;

	}

	function steer_member($id){
		$exc = explode(',', $id);

		for ($i=0;$i<count($exc);$i++) {
			
		
		$data[] = DB::table('tb_users')
				->select('id','first_name','last_name')
				->where('id',$exc[$i])
				->get();
			}
			
				return $data;
	}
	 function getCustCommMem($id){
		$data = DB::table('tb_users')
				->select('id','first_name','last_name')
				->where('id',$id)
				->get();
				return $data;
	}
	

	function postSearch()
	{
		$keyword = $this->module;
		if(!is_null(Input::get('keyword')))
		{
			$keyword = $this->module.'?search='.str_replace(' ','_',Input::get('keyword'));
		}
		return Redirect::to($keyword);

	}

	function postMultisearch()
	{
		//echo '<pre>';print_r($_POST);echo '</pre>';exit;
		$post = $_POST;
		$items ='';
		foreach($post as $item=>$val):
			if($_POST[$item] !='' and $item !='_token' and $item !='md' && $item !='id'):
				$items .= $item.':'.trim($val).'|';
			endif;

		endforeach;
		return Redirect::to($this->module.'?search='.substr($items,0,strlen($items)-1).'&md='.Input::get('md'));
	}

	function postFilter()
	{
		$module = $this->module;
		$sort 	= (!is_null(Input::get('sort')) ? Input::get('sort') : '');
		$order 	= (!is_null(Input::get('order')) ? Input::get('order') : '');
		$rows 	= (!is_null(Input::get('rows')) ? Input::get('rows') : '');
		$md 	= (!is_null(Input::get('md')) ? Input::get('md') : '');

		$filter = '?';
		if($sort!='') $filter .= '&sort='.$sort;
		if($order!='') $filter .= '&order='.$order;
		if($rows!='') $filter .= '&rows='.$rows;
		if($md !='') $filter .= '&md='.$md;



		return Redirect::to($module . $filter);

	}

	function injectPaginate()
	{
		$sort 	= (!is_null(Input::get('sort')) ? Input::get('sort') : '');
		$order 	= (!is_null(Input::get('order')) ? Input::get('order') : '');
		$rows 	= (!is_null(Input::get('rows')) ? Input::get('rows') : '');
		$search 	= (!is_null(Input::get('search')) ? Input::get('search') : '');
		$masterDetail 	= (!is_null(Input::get('md')) ? Input::get('md') : '');
		$appends = array();
		if($sort!='') 	$appends['sort'] = $sort;
		if($order!='') 	$appends['order'] = $order;
		if($rows!='') 	$appends['rows'] = $rows;
		if($search!='') $appends['search'] = $search;
		if($masterDetail!='') $appends['md'] = $masterDetail;
		return $appends;

	}

	function trackUriSegmented()
	{
		$pages 	= (!is_null(Input::get('page')) ? Input::get('page') : '');
		$sort 	= (!is_null(Input::get('sort')) ? Input::get('sort') : '');
		$order 	= (!is_null(Input::get('order')) ? Input::get('order') : '');
		$rows 	= (!is_null(Input::get('rows')) ? Input::get('rows') : '');
		$search 	= (!is_null(Input::get('search')) ? Input::get('search') : '');
		$masterDetail 	= (!is_null(Input::get('md')) ? Input::get('md') : '');
		$appends = array();
		if($pages!='') 	$appends['page'] = $pages;
		if($sort!='') 	$appends['sort'] = $sort;
		if($order!='') 	$appends['order'] = $order;
		if($rows!='') 	$appends['rows'] = $rows;
		if($search!='') $appends['search'] = $search;
		if($masterDetail!='') $appends['md'] = $masterDetail;
		$url = "";
		foreach($appends as $key=>$val)
		{
			$url .= "&$key=$val";
		}
		return $url;

	}

	function infoFieldSearch()
	{
		$info =$this->model->makeInfo( $this->module);
		$forms = $info['config']['forms'];
		$data = array();
		foreach($forms as $f)
		{
			if($f['search'] ==1)
            	if($f['alias'] !='' )  {
				$data[] =  array('id'=> $f['alias'].".".$f['field']);
			}
		}
		return $data;
	}
	function buildSearch()
	{
		$keywords = ''; $fields = '';	$param ='';
		$allowsearch = $this->info['config']['forms'];
		foreach($allowsearch as $as) $arr[$as['field']] = $as ;
		if(Input::get('search') !='')
		{
			$type = explode("|",Input::get('search'));
			if(count($type) >= 1)
			{
				foreach($type as $t)
				{
					$keys = explode(":",$t);

					if(in_array($keys[0],array_keys($arr))):
						if($arr[$keys[0]]['type'] == 'select' || $arr[$keys[0]]['type'] == 'radio' )
						{
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." = '".$keys[1]."' ";
						} else {
							$param .= " AND ".$arr[$keys[0]]['alias'].".".$keys[0]." REGEXP '".$keys[1]."' ";
						}
					endif;
				}
			}
		}
		return $param;

	}


	function buildMasterDetail( $template = null)
	{
		// check if url contain $_GET['md'] , that mean master detail
		if(!is_null(Input::get('md')) and Input::get('md') != '' )
		{

			$values 				= array();
			$data 					= explode(" ", Input::get('md') );
			// Split all param get
			$master 				= ucwords($data[0]) ; $master_key = $data[1]; $module = $data[2]; $key = $data[3];  $val = $data[4];
			$val 					=  SiteHelpers::encryptID($val,true) ;
			$values['row'] 			= $master::getRow( $val );
			$loadInfo 				= $master::makeInfo( $master);
			$values['grid']         = $loadInfo ['config']['grid'];
			$filter 				= 	" AND  ".$this->info['table'].".".$key."='".$val."' ";
			if($template != null)
			{
				$view 					= View::make($template, $values);
			} else {
				$view 					= View::make('layouts/masterview', $values);
			}
			$result = array(
				'masterFilter' => $filter,
				'masterView'	=> $view
			);
			return $result;

		} else {
			$result = array(
				'masterFilter' => '',
				'masterView'	=> ''
			);
			return $result;
		}


	}

	public function masterDetailParam()
	{
		if(!is_null(Input::get('md')))
		{
			$data 	= explode(" ", Input::get('md') );
			$data = array(
				'filtermodule' 		=> (isset($data[2]) ? $data[2] : ''),
				'filterkey'			=> (isset($data[3]) ? $data[3] : ''),
				'filtervalue' 		=> (isset($data[4]) ? $data[4] : ''),
				'filtermd' 			=> str_replace(" ","+",Input::get('md')),

			);
		} else {
			$data = array(
				'filtermodule' 	=> '',
				'filterkey' 	=> '',
				'filtervalue' 	=> '',
				'filtermd' 		=> '',
			);
		}
		return $data;

	}

	function getComboselect()
	{

		if(Request::ajax() == true && Auth::check() == true)
		{
			$param = explode(':',Input::get('filter'));
			$limit = (!is_null(Input::get('limit')) ? Input::get('limit') : null);
			$rows = $this->model->getComboselect($param,$limit);
			$items = array();

			$fields = explode("|",$param[2]);

			foreach($rows as $row)
			{
				$value = "";
				foreach($fields as $item=>$val)
				{
					if($val != "") $value .= $row->$val." ";
				}
				$items[] = array($row->$param['1'] , $value);

			}

			return json_encode($items);
		} else {
			return json_encode(array('OMG'=>" Ops .. Cant access the page !"));
		}
	}

	

	function getCombotable()
	{
		if(Request::ajax() == true && Auth::check() == true)
		{
			$rows = $this->model->getTableList($this->db);
			$items = array();
			foreach($rows as $row) $items[] = array($row , $row);
			return json_encode($items);
		} else {
			return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
		}
	}

	function getCombotablefield()
	{
		if(Input::get('table') =='') return json_encode(array());
		if(Request::ajax() == true && Auth::check() == true)
		{


			$items = array();
			$table = Input::get('table');
			if($table !='')
			{
				$rows = $this->model->getTableField(Input::get('table'));
				foreach($rows as $row)
					$items[] = array($row , $row);
			}
			return json_encode($items);
		} else {
			return json_encode(array('OMG'=>"  Ops .. Cant access the page !"));
		}
	}

	function validateListError( $rules )
	{
		$errMsg = Lang::get('core.note_error') ;
		$errMsg .= '<hr /> <ul>';
		foreach($rules as $key=>$val)
		{
			$errMsg .= '<li>'.$key.' : '.$val[0].'</li>';
		}
		$errMsg .= '</li>';
		return $errMsg;
	}
	function validateForm()
	{
		$forms = $this->info['config']['forms'];

		$rules = array();
		foreach($forms as $form)
		{
			
			if($form['required']== '' || $form['required'] !='0')
			{
				$rules[$form['field']] = 'required';
			} elseif ($form['required'] == 'alpa'){
				$rules[$form['field']] = 'required|alpa';
			} elseif ($form['required'] == 'alpa_num'){
				$rules[$form['field']] = 'required|alpa_num';
			} elseif ($form['required'] == 'alpa_dash'){
				$rules[$form['field']]='required|alpa_dash';
			} elseif ($form['required'] == 'email'){
				$rules[$form['field']] ='required|email';
			} elseif ($form['required'] == 'numeric'){
				$rules[$form['field']] = 'required|numeric';
			} elseif ($form['required'] == 'date'){
				$rules[$form['field']]='required|date';
			} else if($form['required'] == 'url'){
				$rules[$form['field']] = 'required|active_url';
			} else {

			}
		}
		
		return $rules ;
	}

	function validatePost(  $table )
	{
		

		$str = $this->info['config']['forms'];

		$data = array();
		foreach($str as $f){
			$field = $f['field'];
				
		
			if($f['view'] ==1)
			{

				if($f['type'] =='textarea_editor' || $f['type'] =='textarea')
				{
					$content = (isset($_POST[$field]) ? $_POST[$field] : '');
					/* Use this filter for html sanity
					$data[$field] =  Purifier::clean($content);
					*/
					 $data[$field] = $content;
				} else {

					SiteHelpers::globalXssClean();
					if(!is_null(Input::get($field)))
					{
						$data[$field] = Input::get($field);
					}
					// if post is file or image
					if($f['type'] =='file')
					{
						if(!is_null(Input::file($field)))
						{
							$file = Input::file($field);
							$destinationPath = './'.str_replace('.','',$f['option']['path_to_upload']);
							$filename = $file->getClientOriginalName();
							$extension =$file->getClientOriginalExtension(); //if you need extension of the file
							$rand = rand(1000,100000000);
							$newfilename = strtotime(date('Y-m-d H:i:s')).'-'.$rand.'.'.$extension;
							$uploadSuccess = Input::file($field)->move($destinationPath, $newfilename);
							 if($f['option']['resize_width'] != '0' && $f['option']['resize_width'] !='')
							 {
							 	if( $f['option']['resize_height'] ==0 )
								{
									$f['option']['resize_height']	= $f['option']['resize_width'];
								}
							 	$orgFile = $destinationPath.'/'.$newfilename;
								 SiteHelpers::cropImage($f['option']['resize_width'] , $f['option']['resize_height'] , $orgFile ,  $extension,	 $orgFile)	;
							 }

							if( $uploadSuccess ) {
							   $data[$field] = $newfilename;
							}
						} else {
							unset($data[$field]);
						}
					}
					// if post is checkbox
					if($f['type'] =='checkbox')
					{
						if(!is_null(Input::get($field)))
						{
							$data[$field] = implode(",",Input::get($field));
						}
					}
					// if post is date
					if($f['type'] =='date')
					{
						$data[$field] = date("Y-m-d",strtotime(Input::get($field)));
					}

					// if post is seelct multiple
					if($f['type'] =='select')
					{ 

						if( isset($f['option']['is_multiple']) &&  $f['option']['is_multiple'] ==1 )
						{
							
							$data[$field] = implode(",",Input::get($field));
						}
					}

				}

			}
		}
		
		 $global	= (isset($this->access['is_global']) ? $this->access['is_global'] : 0 );

		if($global == 0 )
			$data['entry_by'] = Session::get('uid');

		return $data;
	}

	public function getAllData(){
		$data= DB::table('tb_dynamicSteeringCommitee')->get();
		$allData =[];
		if(!empty($data)){
			foreach ($data as $row) {
				$allData[]  = array(
			'plant_id' 			=> $row->plant_id,
			'stakeholder'		=> $row->stakeholder,
			'steeringComm'		=> $row->steeringComm_id,
			'change_stage'		=> $row->change_stage,
			'cust_comm'		=> $row->cust_comm_decision,
			'change_type' => $row->change_type,
			'id'          =>$row->id,
			 );
			}
		}
		return $allData;


	}

	function validAccess( $methode )
	{

		if($this->model->validAccess( $methode ,$this->info['id']) == false)
		{
			return Redirect::to('home')
			->with('message', SiteHelpers::alert('error',' Your are not allowed to access the page '));

		}

	}

	function inputLogs( $note = NULL)
	{
		$data = array(
			'module'	=> Request::segment(1),
			'task'		=> Request::segment(2),
			'user_id'	=> Session::get('uid'),
			'ipaddress'	=> Request::getClientIp(),
			'note'		=> $note
		);
		 DB::table( 'tb_logs')->insert($data);		;

	}

	function btnAction( $row , $id)
	{

		$id = SiteHelpers::encryptID($id);
		if($this->access['is_detail'] ==1):
			$val = '<a href="'.URL::to('logs/show/'.$id).'"  class="tips btn btn-xs btn-default"  title="'.Lang::get('core.btn_view').'"
			onclick="SximoModal(this.href,\'Add New\')"
			> <i class="icon-paragraph-justify"></i> </a>';
		endif;

		if($this->access['is_edit'] ==1):
			$val ='<a  href="'.URL::to('logs/add/'.$id).'"  class="tips btn btn-xs btn-success"  title="'.Lang::get('core.btn_edit').'"
			onclick="SximoModal(this.href,\''.Lang::get('core.btn_edit').'\')" ><i class="icon-pencil4"></i></a>';
		endif;
		return $val;
	}



	public function getRemovecurrentfiles()
	{
		$id 	= Input::get('id');
		$field 	= Input::get('field');
		$file 	= Input::get('file');
		if(file_exists('./'.$file) && $file !='')
		{
			if(unlink('.'.$file))
			{
				DB::table($this->info['table'])->where($this->info['key'],$id)->update(array($field=>''));
			}
			return Response::json(array('status'=>'success'));
		} else {
			return Response::json(array('status'=>'error'));
		}
	}


	function get_purpose_name($pid){

		$name = DB::table('changerequest_purpose')
				->select('changerequest_purpose.*')
				->where('id',$pid)
				->get();


		return $name[0]->changerequest_purpose;

	}

	/**
	 * @param $id
	 * @return array|string
	 */
	function get_assigned_task_purpose($id)
	{

		$purpose='';
		 $users = DB::table('changerequests_purposechange')
				->select('changerequests_purposechange.*')
				->where('request_id', $id)
				->get();

		$purpose=[];
		foreach($users as $user){
			$purpose[]=array(
					'id'=>$user->id,
					'purpose_name'=>$this->get_purpose_name($user->purpose_id),
			);

		}
		// print_r($purpose);exit();
		return $purpose;


	}

	public function get_total_cost_download($id){

            $users = DB::table('tb_risk_assessment_points')
                ->select(DB::raw('SUM(tb_risk_assessment_points.cost) as total'))
                ->where('tb_risk_assessment_points.request_id', $id)
                //->where('tb_updatesheet_dep_team.team_member', $member)
                ->get();

            return $users[0]->total;
        }

         public function get_close_details_download($request_id){
        $data = DB::table('request_progress_status')

            ->select('request_progress_status.id','request_progress_status.next_url')
            ->where('request_progress_status.request_id', $request_id)
            ->where('request_progress_status.assigned_to', Session::get('uid'))
            ->where('request_progress_status.close', '=', 0)
            ->first();

        return $data;

    }

	public  function get_before_after_attachment_file_download($id){

       $data=array();
       $users = DB::table('befor_after_status_option_attachment')
           ->select('befor_after_status_option_attachment.attachment_file')
           ->where('befor_after_status_option_attachment.request_id', $id)
           ->get();

       foreach($users as $user){
           $data[]=array(
               'attachment_file'=>$user->attachment_file,
           );

       }

       return $data;


   }
   public  function get_ptrDocumet_download($id){

       $data=array();
       $users = DB::table('tb_PTRDocument')
           ->select('tb_PTRDocument.file_name')
           ->where('tb_PTRDocument.request_id', $id)
           ->get();

       foreach($users as $user){
           $data[]=array(
               'attachment_file'=>$user->file_name,
           );
       }
       return $data;
   }
    public function admin_closer_status_download($id){

        $users = DB::table('request_progress_status')

            ->select('request_progress_status.status')
            ->where('request_progress_status.request_id', $id)
            ->orderBy('request_progress_status.id', 'DESC')
            ->first();

        return $users;
    }

    public function get_steering_committee_approval_download($id){

        $users = DB::table('approval_for_risk_assessment_for_cost_involved')

            ->select('approval_for_risk_assessment_for_cost_involved.approval_status','approval_for_risk_assessment_for_cost_involved.sub_department_id')
            ->where('approval_for_risk_assessment_for_cost_involved.request_id', $id)
            ->groupBy('approval_for_risk_assessment_for_cost_involved.sub_department_id')
            ->get();


        return $users;

    }

    public function get_steering_commitee_member_download($r_id){

        $data = $member = DB::table('changerequests')
       ->select('plant_code','change_stage','stakeholder','changeType')
       ->where('request_id',$r_id)
       ->get();
       
       if($data[0]->change_stage ==1){
             $member = DB::table('tb_dynamicSteeringCommitee')
           ->select('tb_dynamicSteeringCommitee.steeringComm_id')
           ->where('plant_id',$data[0]->plant_code)
           ->where('change_stage',$data[0]->change_stage)
           ->where('stakeholder',$data[0]->stakeholder)
           ->where('change_type',$data[0]->changeType)
           ->get();
       }else{
           $member = DB::table('tb_dynamicSteeringCommitee')
           ->select('tb_dynamicSteeringCommitee.steeringComm_id')
           ->where('plant_id',$data[0]->plant_code)
           ->where('change_stage',$data[0]->change_stage)
           ->where('stakeholder',$data[0]->stakeholder)
           ->get();
        }
      
       
       $mem = explode(',', $member[0]->steeringComm_id);
       $cnt = count($mem);
   
        $allmember=[];
       if(!empty($mem)){
     for($i=0;$i<$cnt;$i++) {
           
            $allmember[]  = array(
                    'name' => $this->getSteerCommName_download($mem[$i]),
                    'sub_department_id' =>$this->getSubDept_download($mem[$i],$r_id),
                    'approval_status' => $this->getAppStatus_download($mem[$i],$r_id)
             );
       }
       // print_r($allmember);exit();
   }
   return $allmember;
}

 public function getSubDept_download($userId,$id){
        $users = DB::table('approval_for_risk_assessment_for_cost_involved')
            ->select('sub_department_id')
            ->where('request_id', $id)
            ->where('user_id', $userId)
            ->get();
            $mem = [];

            foreach ($users as $row) {
            $mem[] = array(
                'sub_department_id' => $row->sub_department_id, 
                );
         }

            return $mem;

    }

    public function getAppStatus_download($userId,$id){
        $users = DB::table('approval_for_risk_assessment_for_cost_involved')
            ->select('approval_status')
            ->where('request_id', $id)
            ->where('user_id', $userId)
            ->get();

            $mem = [];
            foreach ($users as $row) {
            $mem[] = array(
                'approval_status' => $row->approval_status, 
                );
        }
            return $mem;

    }

	 public function get_responsibility_to_get_customer_approval_download($id){

        $responsible_person = DB::table('Customer_Communication_Decision')
            ->leftJoin('tb_users', 'Customer_Communication_Decision.user_id', '=', 'tb_users.id')
            ->select('tb_users.first_name','tb_users.last_name')
            ->where('Customer_Communication_Decision.request_id', $id)
            ->orderBy('Customer_Communication_Decision.id','desc')
            ->first();

        return $responsible_person;

    }
    public function getSteerCommName_download($id){
        $steerCommitee = DB::table('tb_users')
         ->select('first_name','last_name')
         ->where('tb_users.id',$id)
         ->get();
         $mem= [];
         foreach ($steerCommitee as $row) {
            $mem[] = array(
                'name' => $row->first_name." ".$row->last_name, 
                );
         }
         return $mem;


    }

    public function get_cust_data_attachments_download($request_id)
    {

        $user_type=Session::get('gid');

        $query = DB::table('changerequests_customer')
            ->select('changerequests_customer.*')
            ->where('request_id', $request_id);
        if(isset($user_type)  && !empty($user_type) &&($user_type!=1)){
            $query->where('flag', 0);
        }
        $users=	$query->get();
        $purpose=array();
        foreach($users as $user){
            $purpose[]=array(

                'customer_approval_attachment_status'=>$this->get_customer_approval_list_download($user->customer_id,$request_id),

            );

        }
        // print_r($purpose);exit();
        return $purpose;

    }

    function get_customer_approval_list_download($customer_id,$request_id){
        $lists = DB::table('Customer_Communication_list')
            ->leftJoin('customer', 'Customer_Communication_list.description', '=', 'customer.CustomerId')
            ->select('Customer_Communication_list.*', 'customer.FirstName', 'customer.LastName', 'customer.CustomerId')
            ->where('request_id', $request_id)
            ->where('decision','!=',0)
            ->where('Customer_Communication_list.description',$customer_id)
            ->get();

        $data=array();
        foreach ($lists as $list) {

            $data= array(
                'FirstName' => $list->FirstName,
                'LastName' => $list->LastName,
                'attachments' => $this->get_all_atachments_download($list->id,$request_id),



            );
        }

        return $data;


    }
    function get_all_atachments_download($list_id,$request_id)
    {

        $attachments = DB::table('Customer_Communication_list_attachments')
            ->select('Customer_Communication_list_attachments.*')
            ->where('list_id', $list_id)
            ->where('request_id',$request_id)
            ->get();

        $purpose = [];

        foreach ($attachments as $attachment) {
            $purpose[] = array(
               // 'attachment_id' => $attachment->id,
                'doc_name' => $attachment->doc_name,
                'comment'   =>$attachment->comment
            );

        }


        return $purpose;


    }

    function get_customer_communication_list_download($customer_id,$request_id){
        $customer_communicated = DB::table('Customer_Communication_list')
            ->leftJoin('customer', 'Customer_Communication_list.description', '=', 'customer.CustomerId')
            ->select('customer.FirstName','customer.LastName','customer.CustomerId')
            ->where('Customer_Communication_list.request_id', $request_id)
            ->where('Customer_Communication_list.decision','!=',0)//done changes in this for new change request uncommented this line
            ->where('Customer_Communication_list.description',$customer_id)

            ->get();

        $purpose = [];

        foreach ($customer_communicated as $value) {
            $purpose = array('first_name' => $value->FirstName,
                'last_name' => $value->LastName,

            );

        }

        return $purpose;

    }

    public function get_customer_to_be_communicated_download($request_id){

            $user_type=Session::get('gid');

            $query = DB::table('changerequests_customer')
                ->select('changerequests_customer.*')
                ->where('request_id', $request_id);
            if(isset($user_type)  && !empty($user_type) &&($user_type!=1)){
                $query->where('flag', 0);
            }
            $users=	$query->get();
            $purpose=array();

           // print_r($users);exit;
            foreach($users as $user){


                $purpose[]=array(

                    'customer_name'=>$this->get_customer_communication_list_download($user->customer_id,$request_id),

                );

            }

            return $purpose;

        }

         public function get_hd_download($request_id){
        	echo 'hieee';
            $hd = DB::table('horizontal_deployment')

                ->select('horizontal_deployment.status','horizontal_deployment.comment','horizontal_deployment.reason')
                ->where('horizontal_deployment.request_id', $request_id)
                ->orderBy('horizontal_deployment.horizontal_deployment_id','asc')

                ->first();
           // print_r($hd);exit();

            return $hd;
        }


	public function get_dept_HOD($id){
        $users = DB::table('tb_users')
            ->select('tb_users.*')
            ->where('id', $id)
            ->get();
        $hod =$users[0]->first_name." ".$users[0]->last_name;

        return $hod;
    }
	function get_request_customers_edit($id)
	{
		 $users = DB::table('changerequests_customer')
				->select('changerequests_customer.customer_id')
				->where('request_id', $id)
				->get();


		$temp_data='';
		$count=0;
		foreach($users as $user){
			$temp_data.=$user->customer_id;
			if($count<count($users)-1){
				$temp_data.=',';
			}
			$count++;
		}
		$result=explode(",", $temp_data);
		// print_r($result);exit();
		return $result;

	}

	function get_request_customers_edit_single($id){


		$users = DB::table('changerequests_customer')
				->select('changerequests_customer.customer_id')
				->where('request_id', $id)
				->get();


		$temp_data='';
		$count=0;
		foreach($users as $user){
			$temp_data.=$user->customer_id;
			//if($count<count($users)-1){
			//	$temp_data.=',';
			//}
			//$count++;
		}

		return $temp_data;
	}



	function get_assigned_task_purpose_id($id)
	{

		$purpose='';
		$users = DB::table('changerequests_purposechange')
				->select('changerequests_purposechange.*')
				->where('request_id', $id)
				->get();
		$purpose=[];
		$temp_data='';
		$count=0;
		foreach($users as $user){
			$temp_data.=$user->purpose_id;
			if($count<count($users)-1){
				$temp_data.=',';
			}
			$count++;
		}

		$result=explode(",", $temp_data);
		return $result;

		//return $temp_data;








		/*$purpose='';
		$users = DB::table('changerequests_purposechange')
				->select('changerequests_purposechange.*')
				->where('request_id', $id)
				->get();
		$purpose=[];
		foreach($users as $user){
			$purpose[]=array(
					'id'=>$user->purpose_id,

			);

		}
		return $purpose;*/


	}

	function get_customer_name($pid){

		$name = DB::table('customer')
				->select('customer.FirstName','customer.LastName')
				->where('CustomerId',$pid)
				->get();
		if($name) {
			return $name[0]->FirstName . ' ' . $name[0]->LastName;
		}else{
			return '';
		}

	}

	public function get_proposed_date($id){
		$Proposed_date=DB::table('add_update_initial_sheet')
                  ->select('add_update_initial_sheet.currentTime')
                  ->where('request_id',$id)
                  ->get();

         if(!empty($Proposed_date)){

         	return Carbon::createFromFormat('Y-d-m H:i:s', $Proposed_date[0]->currentTime)->format('d.m.Y');
         }  else{      
         return '';
     	}
    }

    public function get_actual_date($id){
    	$actual_date=DB::table('befor_after_status_option_attachment')
    				->select('post_date')
    				->where('request_id',$id)
    				->get();
    	if(!empty($actual_date)){

         	return Carbon::createFromFormat('d/m/Y', $actual_date[0]->post_date)->format('d.m.Y');
         }  else{      
         return '';
     	}
    }

   public function get_final_approval($id){
    	$data_ = DB::table('request_progress_status')
				->select('request_progress_status.status','request_progress_status.close')
				->where('request_progress_status.request_id',$id)
				->orderBy('request_progress_status.request_id','desc')
				->first();
		$data=array();
		if(!empty($data_)){
			if($data_->status==19 && $data_->close==0){//echo 'in green';exit;

				$status=1;
				$class='yellow';
				$text='Y';

			}else if(($data_->status==20 || $data_->status==21 || $data_->status==22) && $data_->close==2){//echo 'in yellow';exit;

				$status=1;
				$class='green';
				$text='G';

			}else{//echo 'in blank';exit;

				$status=1;
				$class='-';
				$text='-';
			}

			
			$data = array(

					'dep_'=>$status,
					'class_'=>$class,
					'text_'=>$text,


			);
		}

		return $data;
    }

    public function get_document_verification_status($id){
    	$data = DB::table('request_progress_status')
				->select('request_progress_status.status','request_progress_status.close')
				->where('request_progress_status.request_id', $id)
				->where('request_progress_status.status', 16)
				->orderBy('request_progress_status.id','desc')
				->get();

				$data1 = DB::table('request_progress_status')
				->select('request_progress_status.status','request_progress_status.close')
				->where('request_progress_status.request_id', $id)
				->where('request_progress_status.status', 14)
				->where('close',0)
				->get();



		if(empty($data)){
			$status=1;
			$class='-';
			$text='-';
		}

		else if($data[0]->close==1 && empty($data1)){

			$status=1;
			$class='green';
			$text='G';

		}else if($data[0]->close==1 && !empty($data1)){

			$status=1;
			$class='-';
			$text='-';
		}else{

			$status=1;
			$class='yellow';
			$text='Y';
		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,

		);
		return $data;
    }




	function get_request_customers($id)
	{
		$user_type=Session::get('gid');
		$purpose='';
		$query = DB::table('changerequests_customer')
				->select('changerequests_customer.*')
				->where('request_id', $id);
				if(isset($user_type)  && !empty($user_type) &&($user_type!=1)){
					$query->where('flag', 0);
				}
		$users=	$query->get();



		foreach($users as $user){
			$purpose[]=array(
					'id'=>$user->id,
					'customer_name'=>$this->get_customer_name($user->customer_id),
					'status'=>$this->get_status($id),
					'status2'=>$this->get_status2($id),
					'status_steering'=>$this->get_status_steering($id),
					'customer_approval'=>$this->get_status_for_customer_approval_decision($id),
				    'customer_approval_status'=>$this->get_customer_approval_status($id),
					'change_implementation_data'=>$this->get_implementation_date($id),
					'before_after_comparison'=>$this->get_before_after_comparison($id),

					'admin_status'=>$user->admin_status,
					'flag'=>$user->flag,
					'Proposed_date'=>$this->get_proposed_date($id),
					'actual_date'=>$this->get_actual_date($id),
					'Final_approval'=>$this->get_final_approval($id),
					'documentverifystatus'=>$this->get_document_verification_status($id),
					'PTR_docapp'=>$this->getPTRdoc($id)

			);

		}

		// print_r($purpose);exit();
		return $purpose;


	}

	function getPTRdoc($id){
		$checkParam = DB::table('changerequests')
            ->select('change_stage','plant_code','stakeholder','proj_code')
            ->where('request_id',$id)
            ->get();
    if($checkParam[0]->change_stage == 2){
    	$status=1;
		$class='-';
		$text='-';
    }else{
        	$data = DB::table('request_progress_status')
			->select('request_progress_status.status','request_progress_status.close')
			->where('request_progress_status.request_id', $id)
			->where('request_progress_status.status', 22)
			->orderBy('id','asc')
			->first();



				if(empty($data)){
					$status=1;
					$class='-';
					$text='-';
				}

				else if($data->close==1){

					$status=1;
					$class='green';
					$text='G';

				}else if($data->close==0){
					$status=1;
					$class='yellow';
					$text='Y';

				}else{

					$status=1;
					$class='-';
					$text='-';
				}

            }
            $data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,

		);
		return $data;
	}
    function get_change_request_customers($id)
    {
        $user_type=Session::get('gid');
        $purpose='';
        $query = DB::table('changerequests_customer')
            ->select('changerequests_customer.*')
            ->where('request_id', $id);

        $users=	$query->get();



        foreach($users as $user){
            $purpose[]=array(

                'customer_name'=>$this->get_customer_name($user->customer_id),

            );

        }


        return $purpose;


    }
    function get_parts($id)
    {
        $parts = DB::table('tbl_parts_info')
            ->select('tbl_parts_info.*')
            ->where('tbl_parts_info.request_ids', '=', $id)->get();





        return $parts;


    }

	function update_risk_status_sheet($request_id,$type_id){


			DB::table('Summary_Sheet_Status_Risk_Analysis')->insert(
					array(
							'request_id' => $request_id,
							//'created_date' => date('Y-m-d H:i:s'),
							'type_id'=>$type_id,
							'status'=>1,


					)
			);

	}

	/*function get_status($request_id){

		$assign=DB::table('Summary_Sheet_Status_Risk_Analysis')
				->select('Summary_Sheet_Status_Risk_Analysis.*')
				->where('request_id', $request_id)
				->get();
		$data[] = array();
		foreach ($assign as $user){
			/*$created_date=$user->created_date;
			$target_date=$user->created_date;

			if($created_date<=$target_date){
				$status=1;
			'class'='green'
			}elseif($created_date>$target_date){
				$status=3;
			'class'='green'
			}*/

		/*	$data = array(
					'dep_'.$user->type_id=>1,
					'class_'.$user->type_id=>'green',
					'text_'.$user->type_id=>'G',
			);
		}
		return $data;
	}*/

	function get_status_steering($request_id){

		$changeReqData = DB::table('changerequests')
         ->select('plant_code','stakeholder','change_stage')
         ->where('request_id',$request_id)
         ->get();


         if(!empty($changeReqData)){
		 $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
         ->select('steeringComm_id')
         ->where('plant_id',$changeReqData[0]->plant_code)
         ->where('stakeholder',$changeReqData[0]->stakeholder)
         ->where('change_stage',$changeReqData[0]->change_stage)
         ->get();
    		 }
    		 $cnt1=0;
    		 if(!empty($steerCommMem)){

    		 $cnt = explode(',', $steerCommMem[0]->steeringComm_id);
    		 $cnt1  =count($cnt);
    		}
    		
		$users = DB::table('approval_risk_assessment_from_admin')
				->select(DB::raw('COUNT(id) as total'))

				->where('approval_risk_assessment_from_admin.request_id', $request_id)
				->where('approval_risk_assessment_from_admin.approve_status', 1)
				->get();




		$data = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 88)
				->where('request_progress_status.close', 0)
				->get();

		$data2 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 11)
				->where('request_progress_status.close', 0)
				->get();

		$data3 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 7)
				->where('request_progress_status.close', 0)
				->get();


		$data4 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 8)
				->where('request_progress_status.close', 0)
				->get();

		$data5 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 88)
				->where('request_progress_status.close', 0)
				->get();

	//	print_r($data4[0]->total);exit;


		if($users[0]->total>=$cnt1 && $data2[0]->total==0 && $data3[0]->total==0 && $data4[0]->total==0 && $data5[0]->total==0){//echo 'in green';exit;

			$status=1;
			$class='green';
			$text='G';

		}else if($data[0]->total<=$cnt1 && $data2[0]->total==0 && $data3[0]->total==0 && $data4[0]->total==0 && $data[0]->total!=0){//echo 'in yellow';exit;



			$status=1;
			$class='yellow';
			$text='Y';

		}else{//echo 'in blank';exit;

			$status=1;
			$class='-';
			$text='-';
		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;

	}

	/*
	 *
	 * Summery Sheet data for customer approval decision
	 *
	 */
	function get_status_for_customer_approval_decision($request_id){

		
$changeReqData = DB::table('changerequests')
         ->select('plant_code','stakeholder','change_stage')
         ->where('request_id',$request_id)
         ->get();

     if($changeReqData[0]->change_stage == 1){
         	if(!empty($changeReqData)){
		 $steerCommMem = DB::table('tb_dynamicSteeringCommitee') 
         ->select('steeringComm_id')
         ->where('plant_id',$changeReqData[0]->plant_code)
         ->where('stakeholder',$changeReqData[0]->stakeholder)
         ->where('change_stage',$changeReqData[0]->change_stage)
         ->get();

         $steercommcnt = DB::table('approval_for_risk_assessment_for_cost_involved')
         ->select(DB::raw('COUNT(id) as total'))
         ->where('request_id',$request_id)
         ->get();
    		 }
    		 $cnt1=0;
    		 if(!empty($steerCommMem)){

    		 $cnt = explode(',', $steerCommMem[0]->steeringComm_id);
    		 $cnt1  =count($cnt);
    		}
    		$data = DB::table('request_progress_status')
				->select('request_progress_status.status','request_progress_status.close')
				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 12)
				->get();

		
		if(empty($data)){
			$status=1;
			$class='-';
			$text='-';
		}

		else if($data[0]->close==1 && $cnt1==$steercommcnt[0]->total ){

			$status=1;
			$class='green';
			$text='G';

		}else if($data[0]->close==0 && $cnt1==$steercommcnt[0]->total ){

			$status=1;
			$class='yellow';
			$text='G';

		}else{
			$status=1;
			$class='-';
			$text='-';
		}


		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;


      }else{
		$data = DB::table('request_progress_status')
				->select('request_progress_status.status','request_progress_status.close')
				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 12)
				->get();

		if(empty($data)){
			$status=1;
			$class='-';
			$text='-';
		}

		else if($data[0]->close==1){

			$status=1;
			$class='green';
			$text='G';

		}else{

			$status=1;
			$class='yellow';
			$text='Y';
		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;
	}

	}



	function get_implementation_date($request_id){

		$users=DB::table('befor_after_status_option_attachment')
				->select(DB::raw('COUNT(id) as total'))
				->where('befor_after_status_option_attachment.request_id', $request_id)

				->get();

		$data_count = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 18)
				->get();


		if($users[0]->total>=1){

			$status=1;
			$class='green';
			$text='G';

		}else if($data_count[0]->total==1){

		$status=1;
		$class='yellow';
		$text='Y';

		}else{

			$status=1;
			$class='-';
			$text='-';

		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;


	}


	function get_before_after_comparison($request_id){
		$users=DB::table('befor_after_status_option_attachment')
				->select(DB::raw('COUNT(id) as total'))
				->where('befor_after_status_option_attachment.request_id', $request_id)
				->where('befor_after_status_option_attachment.attachment_file','!=','')

				->get();

		$data_count = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))
				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 18)
				->get();

				$data_count1 = DB::table('request_progress_status')
				->select('close')
				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 18)
				->orderBy('id','desc')
				->limit(1)
				->get();





		if($users[0]->total>=1 && $data_count1[0]->close == 1) {

			
			$status = 1;
			$class = 'green';
			$text = 'G';
			

		}else if($data_count[0]->total>0){

			$status=1;
			$class='yellow';
			$text='Y';

		}else{

			$status=1;
			$class='-';
			$text='-';

		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;

	}

	/*
	 *
	 * Old one bye one yellow code below for last two step
	 *
	 *
	 */
	/*function get_before_after_comparison($request_id){

		$users=DB::table('befor_after_status_option_attachment')
				->select(DB::raw('COUNT(id) as total'))
				->where('befor_after_status_option_attachment.request_id', $request_id)
				->where('befor_after_status_option_attachment.attachment_file','!=','')

				->get();

		$data_count = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 19)
				->where('request_progress_status.close', 0)
				->get();
		$data_count1 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 20)
				->where('request_progress_status.close', 2)
				->get();



		if($data_count1[0]->total==1) {

			$status = 1;
			$class = 'green';
			$text = 'G';

		}else if($data_count[0]->total>0){

			$status=1;
			$class='yellow';
			$text='Y';

		}else{

			$status=1;
			$class='-';
			$text='-';

		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;


	}*/

	function get_customer_approval_status($request_id){

		$users=DB::table('customer_verification')
				->select(DB::raw('COUNT(verification_id) as total'))
				->where('customer_verification.request_id', $request_id)
				->where('customer_verification.status', 1)

				->get();


		$data = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 12)
				->get();

		$data_rej = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 15)
				->where('request_progress_status.close', 0)
				->get();

		$data_ = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 12)
				->where('request_progress_status.close', 0)
				->get();

		$data_1 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 13)
				->where('request_progress_status.close', 0)
				->get();

		if($users[0]->total>=1 && $data_[0]->total!=1){//echo "in g";exit;

			$status=1;
			$class='green';
			$text='G';

		}else if($data[0]->total>0 && $data_rej[0]->total==1 && $data_[0]->total!=1){//echo "in y1";exit;

			$status=1;
			$class='yellow';
			$text='Y';

		}else if($data_[0]->total==1){//echo "in y2";exit;

			$status=1;
			$class='yellow';
			$text='Y';


		}else if($data_1[0]->total==1){//echo "in y3";exit;

			$status=1;
			$class='yellow';
			$text='Y';


		}

		else{

			$status=1;
			$class='-';
			$text='-';

		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;

		/*$users=DB::table('Customer_Communication_list_attachments')
				->select(DB::raw('COUNT(id) as total'))
				->where('Customer_Communication_list_attachments.request_id', $request_id)
				->where('Customer_Communication_list_attachments.doc_name','!=','')

				->get();


		$data = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 12)
				->get();

		$data_rej = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 15)
				->where('request_progress_status.close', 0)
				->get();

		$data_ = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 12)
				->where('request_progress_status.close', 0)
				->get();

		$data_1 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))

				->where('request_progress_status.request_id', $request_id)
				->where('request_progress_status.status', 13)
				->where('request_progress_status.close', 0)
				->get();

		if($users[0]->total>=1 && $data_[0]->total!=1){//echo "in g";exit;

			$status=1;
			$class='green';
			$text='G';

		}else if($data[0]->total>0 && $data_rej[0]->total==1 && $data_[0]->total!=1){//echo "in y";exit;

			$status=1;
			$class='yellow';
			$text='Y';

		}else if($data_[0]->total==1){

			$status=1;
			$class='yellow';
			$text='Y';


		}else if($data_1[0]->total==1){

			$status=1;
			$class='yellow';
			$text='Y';


			}

		else{

			$status=1;
			$class='-';
			$text='-';

		}

		$data = array(

				'dep_'=>$status,
				'class_'=>$class,
				'text_'=>$text,


		);
		return $data;*/

	}
/*
 * Bakup
 *
 */
	/*
	function get_status($request_id){

		$assign=DB::table('Summary_Sheet_Status_Risk_Analysis')

				->select('Summary_Sheet_Status_Risk_Analysis.*')
				->where('request_id', $request_id)
				->orderBy('Summary_Sheet_Status_Risk_Analysis.type_id','desc')
				->groupBy('Summary_Sheet_Status_Risk_Analysis.type_id')
				->get();

		$users = DB::table('approval_for_risk_assessment_for_cost_involved')
				->select(DB::raw('COUNT(id) as total'))
				//->select('approval_for_risk_assessment_for_cost_involved.approval_status','approval_for_risk_assessment_for_cost_involved.sub_department_id')
				->where('approval_for_risk_assessment_for_cost_involved.request_id', $request_id)
				->get();


		$target_date1=DB::table('tb_risk_assessment_points')
				->select('tb_risk_assessment_points.target_date')

				->where('request_id', $request_id)
				->where('tb_risk_assessment_points.target_date', '!=','')
				->first();

		$data = array();
		foreach ($assign as $user){
			$created_date=Carbon::createFromFormat('Y-m-d H:i:s', $user->created_date)->format('Y-m-d');



			if($target_date1!=''){

				$targetdate=Carbon::createFromFormat('d/m/Y', $target_date1->target_date)->format('Y-m-d');

				$target_date=$targetdate;

			}else{

				$target_date='';
			}


			$date1=strtotime($created_date);
			$date2=strtotime($target_date);



			if($date1<=$date2 ){//echo "less then or equal to target date";exit;
				$status=1;
				$class='green';
				$text='G';
			}elseif($date1>$date2){//echo "created date in high target date";exit;
				$status=1;
				$class='red';
				$text='R';
			}
			elseif($date2==''){//echo "created date in high target date";exit;
				$status=1;
				$class='yellow';
				$text='Y';
			}

			$data[] = array(

					'dep_'.$user->type_id=>$status,
					'class_'.$user->type_id=>$class,
					'text_'.$user->type_id=>$text,


			);

		}

		return $data;



		/*$data = array();
		foreach ($assign as $user){
			$created_date=Carbon::createFromFormat('Y-m-d H:i:s', $user->created_date)->format('d/m/Y');

			if($target_date1!=''){

				$target_date=$target_date1->target_date;

			}else{

				$target_date=$target_date1->target_date='';
			}


			if($created_date<=$target_date ){//echo "less then or equal to target date";exit;
				$status=1;
			    $class='green';
				$text='G';
			}elseif($created_date>$target_date){//echo "created date in high target date";exit;
				$status=1;
				$class='red';
				$text='R';
			}
			elseif($target_date==''){//echo "created date in high target date";exit;
				$status=1;
				$class='yellow';
				$text='Y';
			}

			$data[] = array(

					'dep_'.$user->type_id=>$status,
					'class_'.$user->type_id=>$class,
					'text_'.$user->type_id=>$text,


					);

			//
		}


		return $data;
	}*/

	function get_status($request_id){

		$data  = DB::table('tb_updatesheet_dep_team')
				->leftJoin('tb_departments','tb_departments.d_id','=','tb_updatesheet_dep_team.department')
				->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
				->select('tb_departments.d_name','tb_updatesheet_dep_team.update_sheet_dep_id','tb_updatesheet_dep_team.*','tb_users.first_name', 'tb_users.last_name')

				->where('tb_updatesheet_dep_team.request_id','=',$request_id)
				->where('tb_updatesheet_dep_team.initial_sheet_status',2)

				->get();

		$accept_data = DB::table('add_updated_risk_assessment_sheet')
				->select(DB::raw('COUNT(id) as total'))
				->where('add_updated_risk_assessment_sheet.r_id', $request_id)

				->get();

		$compdata = DB::table('add_updated_risk_assessment_sheet')
				->select(DB::raw('COUNT(id) as total'))
				->where('add_updated_risk_assessment_sheet.r_id', $request_id)
				->where('add_updated_risk_assessment_sheet.status', 2)
				->get();

		$compdata1 = DB::table('add_updated_risk_assessment_sheet')
				->select(DB::raw('COUNT(id) as total'))
				->where('add_updated_risk_assessment_sheet.r_id', $request_id)
				->where('add_updated_risk_assessment_sheet.status', 3)
				->get();

		//echo '<pre>';

		//print_r($compdata);exit;


		$res=array();

		

			/* start Sanjay */

			 //    $sa1 = DB::table('add_updated_risk_assessment_sheet')
				// 	->select('add_updated_risk_assessment_sheet.user_department')
				// 	->where('add_updated_risk_assessment_sheet.r_id', '=', $request_id)
				// 	->get();

				// 	foreach ($sa1 as $row) {
				// 		$sa2[] = $row->user_department;
				// 	}
				
					
				// $first = DB::table('tb_departments')
				// ->select(DB::raw("'0' as field1"),DB::raw("'0' as field2"),
				// 	'tb_departments.d_id as user_department' )
				// ->whereNotIn('tb_departments.d_id', $sa2)
				// ->where('tb_departments.d_id', '!=', 11);
				
				// 	//->where('add_updated_risk_assessment_sheet.r_id', '=', $request_id)
				
		

				// $compdata_ = DB::table('add_updated_risk_assessment_sheet')
				// 	->select('add_updated_risk_assessment_sheet.user_dep_hod_approve','add_updated_risk_assessment_sheet.user_dep','add_updated_risk_assessment_sheet.user_department')
				// 	->where('add_updated_risk_assessment_sheet.r_id', '=', $request_id)
				// 	->union($first)
				// 	->get();	


				

				//echo "<pre>"; print_r($compdata_) ;

            /* start End */

			$compdata_ = DB::table('add_updated_risk_assessment_sheet')
					->select('add_updated_risk_assessment_sheet.user_dep_hod_approve','add_updated_risk_assessment_sheet.user_dep','add_updated_risk_assessment_sheet.user_department')
					->where('add_updated_risk_assessment_sheet.r_id', '=', $request_id)
					->orderBy('add_updated_risk_assessment_sheet.user_department','asc')
					->get();
			

			$result=array();
			foreach ($compdata_ as $value) {//print_r((String)$value->user_dep);exit;

				$status = 1;
				$class = 'green';
				$text = 'G';

				$result[] = array(
						'dep_' . $status => $status,
						'class_' . $status => $class,
						'text_' . $status => $text,
						'department' => (String)$value->user_dep_hod_approve,
						'user_dep' => (String)$value->user_dep,
						'hod_approved' => (String)$value->user_dep_hod_approve,
						'all_reqDept' => $value->user_department

				);

			}

		//echo '<pre>';

		//	print_r($result);exit;

			return $result;
			//echo '<pre>';

		//	print_r($result);exit;





	//	}

	}

	function get_status2($request_id)
	{

		$admin_accept_data = DB::table('activity_completion_sheet_verify')
				->select(DB::raw('COUNT(activity_completion_sheet_verify_id) as total'))
				->where('activity_completion_sheet_verify.request_id', $request_id)
				->where('activity_completion_sheet_verify.status', 1)
				->get();

		//print_r($admin_accept_data);exit;


		$aa = DB::table('activity_completion_sheet_verify')
				->select('activity_completion_sheet_verify.status')
				->where('activity_completion_sheet_verify.request_id', $request_id)
				->where('activity_completion_sheet_verify.status',1)
				->first();

		$result_d = DB::table('attachment_activity_monitoring_summerysheet')
				->select('attachment_activity_monitoring_summerysheet.dep_id', 'attachment_activity_monitoring_summerysheet.user_id')
				->where('request_id', $request_id)
			//	->where('resp_emp_status', 3)
				->orderBy('attachment_activity_monitoring_summerysheet.dep_id', 'desc')
				//->groupBy('tb_updatesheet_dep_team.user_id')
				->get();

		$r_1 = DB::table('request_progress_status')
				->select(DB::raw('COUNT(id) as total'))
				->where('request_progress_status.request_id', $request_id)
				->where('status', 16)
				//->where('close', 0)
				->get();


		$r_1_2 = DB::table('attachment_activity_monitoring_summerysheet')
				->select(DB::raw('COUNT(id) as total'))
				->where('attachment_activity_monitoring_summerysheet.request_id', $request_id)
				->get();

		$r_1_3 = DB::table('attachment_activity_monitoring_summerysheet')
				->select(DB::raw('COUNT(id) as total'))
				->where('attachment_activity_monitoring_summerysheet.request_id', $request_id)
				->where('attachment_activity_monitoring_summerysheet.task_status', 2)
				->get();

		//echo '<pre>';
		//print_r($r_1_3);exit;



	/*	if($r_1_2[0]->total>=1 && $r_1_3[0]->total == 0 ){//echo "in first";exit;

			$result_1 = array();

			foreach ($result_d as $user) {

				$status = 1;
				$class = 'yellow';
				$text = 'Y';

				$result_1[] = array(
						'dep_' => $status,
						'class_' => $class,
						'text_' => $text,
						'department' => (String)$user->dep_id,
				);


			}
			return $result_1;

		}*/


		/*else if($admin_accept_data[0]->total == 1){echo "in second";exit;

			$result1 = array();

			foreach ($assign as $user) {

				$status = 1;
				$class = 'green';
				$text = 'G';

				$result1[] = array(
						'dep_' => $status,
						'class_' => $class,
						'text_' => $text,
						'department' => (String)$user->dep_id,
				);


			}
			return $result1;

		}*///else{//echo "in third";exit;

			$assign = DB::table('attachment_activity_monitoring')
					->select('attachment_activity_monitoring.created', 'attachment_activity_monitoring.user_id','attachment_activity_monitoring.dep_id')
					->where('request_id', $request_id)
					->orderBy('attachment_activity_monitoring.user_id', 'desc')
					->groupBy('attachment_activity_monitoring.user_id')
					->get();
						
			$assign_new = DB::table('attachment_activity_monitoring_summerysheet')
			->select('attachment_activity_monitoring_summerysheet.task_status','attachment_activity_monitoring_summerysheet.admin_status','attachment_activity_monitoring_summerysheet.created_date', 'attachment_activity_monitoring_summerysheet.user_id','attachment_activity_monitoring_summerysheet.dep_id')
			->where('request_id', $request_id)
			->groupBy('attachment_activity_monitoring_summerysheet.dep_id')
			->orderBy('attachment_activity_monitoring_summerysheet.dep_id', 'asc')
			->get();



			$result = array();

			$current_date=date('Y-m-d');

			foreach ($assign_new as $user) {


				$target_date1 = $this->get_target_date($user->user_id, $request_id);
		

				$current_dt =$current_date;// Carbon::createFromFormat('Y-m-d H:i:s', $user->created_date)->format('Y-m-d');

				$date1 = strtotime($current_dt);
				//print_r($target_date1);exit();
				if(!empty($target_date1)) {
					if($target_date1 != ""){
					$date2 = strtotime((String)$target_date1->t_date);
				}

				}else{

					$current_date=date('Y-m-d');
					$date2 = strtotime($current_date);
				}
			//echo $date2;exit();
				$result[] = array(
						'dep_1' => 1,
						//'class_' => $class,
						//'text_' => $text,
						//'department' => (String)$target_date1->risk_dep,
						'date1'=>$date1,
						'date2'=>$date2,
						'task_status' => (String)$user->task_status,
						'user_department' => (String)$user->dep_id,
						'admin_status'=>(String)$user->admin_status,
				);

			}

			//echo "<pre>";
			//print_r($result);exit;

			return $result;
		


		//}

	}

	function get_target_date($user_id,$request_id){
      $target_date1 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->where('tb_risk_assessment_points.request_id', $request_id)
            ->where('tb_risk_assessment_points.responsibility', $user_id)
           // ->orderBy('tb_risk_assessment_points.risk_dep', 'desc')
            ->first();
            if(!empty($target_date1)){
			if($target_date1->t_date=="0000-00-00"){
				return 0;
			}else{
				$target_date=$target_date1;
				return $target_date;
			}
		}

	}

	function get_target_date1($dept,$request_id){
      $target_date1 = DB::table('tb_risk_assessment_points')
            ->select(DB::raw('risk_assessment_id, max(target_date) as t_date,responsibility,risk_dep'))
            ->groupBy('tb_risk_assessment_points.risk_dep')
            ->where('tb_risk_assessment_points.request_id', $request_id)
            ->where('tb_risk_assessment_points.risk_dep', $dept)
           // ->orderBy('tb_risk_assessment_points.risk_dep', 'desc')
            ->first();
            if(!empty($target_date1)){
			if($target_date1->t_date=="0000-00-00"){
				return 0;
			}else{
				$target_date=$target_date1;
				return $target_date;
			}
		}

	}



	/**
	 * save notification for dashboard and task purposes
	 *
	 * @param $assigned_to
	 * @param $request_id
	 * @param $message
	 */

	function save_noticication_status($assigned_to,$request_id,$message,$url,$status){

		// print_r($request_id);exit();
		DB::table('request_progress_status')->insert(
				array('assigned_by' => Session::get('uid'),
						'assigned_to' => $assigned_to,
						'request_id' => $request_id,
						'created_date' => date('Y-m-d H:i:s'),
						'message' => $message,
						'next_url'=>$url,
						'status'=>$status,
						//'progress'=>$progress

				)
		);

		return $lastest_id = DB::getPdo()->lastInsertId();

	}


	function save_noticication_status_for_steering_sub_dep($assigned_to,$request_id,$message,$url,$status,$sub_dep){


		DB::table('request_progress_status')->insert(
				array('assigned_by' => Session::get('uid'),
						'assigned_to' => $assigned_to,
						'request_id' => $request_id,
						'created_date' => date('Y-m-d H:i:s'),
						'message' => $message,
						'next_url'=>$url,
						'status'=>$status,
					    'assigned_to_sub_dep_id'=>$sub_dep

				)
		);

		return $lastest_id = DB::getPdo()->lastInsertId();

	}

	function save_noticication_status_for_reject($assigned_to,$request_id,$message,$url,$status,$comment){


		DB::table('request_progress_status')->insert(
				array('assigned_by' => Session::get('uid'),
						'assigned_to' => $assigned_to,
						'request_id' => $request_id,
						'created_date' => date('Y-m-d H:i:s'),
						'message' => $message,
						'next_url'=>$url,
						'status'=>$status,
						'comment'=>$comment

				)
		);

		return $lastest_id = DB::getPdo()->lastInsertId();

	}

	/*
	 * Below code is for merge different customer with temp table
	 */

	function save_noticication_status_temp($assigned_to,$request_id,$message,$url,$status){

		// print_r($request_id);exit();
		DB::table('request_progress_status_temp')->insert(
				array('assigned_by' => Session::get('uid'),
						'assigned_to' => $assigned_to,
						'request_id' => $request_id,
						'created_date' => date('Y-m-d H:i:s'),
						'message' => $message,
						'next_url'=>$url,
						'status'=>$status,
					//'progress'=>$progress

				)
		);

	}

	function send_mail_to_remaining_member($user_id,$request_id){

		$result=DB::table('request_progress_status')
				->select('assigned_to')
				->where('request_id', $request_id)
				->where('assigned_to', '!=',$user_id)
				->where('status',88)
				->distinct('assigned_to')
				->get();

		//echo '<pre>';
		//print_r($result);exit;
		//$data1 = $this->get_user_info_by_id($user_id);
		$res=array();
		foreach ($result as $data) {
			$res[] = array(
				//'sub_dep_id' => $data->sub_dep_id,
				//'sub_dep_name' => $data->sub_dep_name,
					'user_id' => $data->assigned_to,


			);


		}

		return $res;

		//print_r($res[0]['user_id']);


	}


	function save_noticication_status_multiple($assigned_to,$request_id,$message,$url,$status){

		$assign=DB::table('request_progress_status')
			->select('assigned_by')
			->where('request_id', $request_id)
			->first();

		$assigned_by=$assign->assigned_by.','.Session::get('uid');

		DB::table('request_progress_status')
				->where('request_id', $request_id)

				->update(
						array('assigned_by' => $assigned_by,
								'assigned_to' => $assigned_to,
							//'request_id' => $request_id,
								'created_date' => date('Y-m-d H:i:s'),
								'message' => $message,
								'next_url'=>$url,
								'status'=>$status,

						)
				);



	}

	function create_noticication_status($assigned_to,$request_id,$message,$url,$status){

		DB::table('request_progress_status')->insert(
				array('assigned_by' => Session::get('uid'),
						'assigned_to' => $assigned_to,
						'request_id' => $request_id,
						'created_date' => date('Y-m-d H:i:s'),
						'message' => $message,
						'next_url'=>$url,
						'status'=>$status,

				)
		);

	return $lastest_id = DB::getPdo()->lastInsertId();
	}



	function save_request_status($request_id,$status){

		DB::table('changerequests')
				->where('request_id', $request_id)
				->update(['status' => $status]);
	}


	function change_request_status_close($request_id,$id){
		// print_r($request_id);exit();
		DB::table('request_progress_status')
				->where('request_id', $request_id)
				->where('id', $id)
				->update([
					'close' => 1,
					'IP_Address'=>$_SERVER['REMOTE_ADDR'],
					'User_id' =>session::get('uid')
					]);
	}

    function change_request_status_reject_and_close($request_id,$id,$userid){




        $message="Change request is Rejected and Closed By ".$userid;
        DB::table('request_progress_status')
            ->where('request_id', $request_id)
            ->where('id', $id)
            ->update(
            array('close' => 2,
                'message' => $message,
                'IP_Address'=>$_SERVER['REMOTE_ADDR'],
				'User_id' =>session::get('uid')
            )
        );
    }

	function check_session_set(){

		$user_type = Session::get('uid');

		if ($user_type != ""):
			return 1;
		else:
			return 0;
		endif;
	}

		function check_request_permission($id){


			if($this->check_session_set()) {

				$users = DB::table('request_progress_status')
						->select(DB::raw('COUNT(id) as total'))
						->where('request_progress_status.request_id', $id)
						//->where('request_progress_status.assigned_to', Session::get('uid'))
						->whereRaw("find_in_set(".Session::get('uid').",request_progress_status.assigned_to)")
						->get();

				if ($users[0]->total) {
					return 1;
				} else {
					return 0;
				}
			}else{
				return 0;
			}
		}
function check_menu_permission($id){
	$user_type = Session::get('uid');
	if ($user_type != ""){
		$users = DB::table('tb_users')
				->select('tb_users.permission')
				->where('tb_users.id', Session::get('uid'))
				->first();

		//return $users->permission;

		if (in_array($id, explode(',',$users->permission)))
		{
			return 1;
		}
		else
		{
			return 0;
		}

	}


}

	function check_scm_permission(){
		$user_type = Session::get('gid');
		if ($user_type != ""){
			$users = DB::table('tb_users')
					->select('tb_users.id')
					->whereRaw("find_in_set(".Session::get('gid').",tb_users.group_id)")
					->first();

			//return $users->permission;
			//echo $users;exit;

			if ($users)
			{
				return 1;
			}
			else
			{
				return 0;
			}

		}


	}

	function check_permission($page_type){
		$user_type = Session::get('gid');

		//print_r(Session::get('gid'));exit;
		if ($user_type != ""){

			if(Session::get('uid')==1){
				return 1;
			}else{
				
			$users = DB::table('tb_role')
					->select('tb_role.permission_id')
					->whereIn('tb_role.role_id', explode(',',$user_type))
					->get();


			$txt='';
			foreach($users as $user){
				$txt.= $user->permission_id.',';
			}
			
		$permission=rtrim($txt,",");
		//	print_r(explode(',',$permission));
		//	exit;
			if (in_array($page_type, explode(',',$permission)))
			{
				//echo '1';
				return 1;
			}
			else
			{
				//echo '0';
				return 0;
			}
			//exit;
			}

		}


	}




function get_user_email_by_id($id){

	 $user = DB::table('tb_users')
			->select('tb_users.email')
			->where('id', $id)
			->first();
	return $user->email;
}
	function get_data_id($id){
		$result = DB::table('request_progress_status')
				->select('request_progress_status.assigned_by')
				->where('id',$id)

				->get();

		if($result) {

			$purpose = array(
					'assigned_by' => $result[0]->assigned_by,

			);
			return $purpose;
		}


		//return $result;

	}

	function get_user_info_by_id_for_report($id){

		$user = DB::table('tb_users')
				->leftJoin('tb_departments','tb_departments.d_id','=','tb_users.department')
				->leftJoin('subdepartments','subdepartments.sub_dep_id','=','tb_users.sub_department')

				->select('tb_users.*','tb_departments.d_name','subdepartments.sub_dep_name')
				->where('id', $id)
				 ->get();

		if($user) {

			$purpose = array(
					'id' => $user[0]->id,
					'name' => $user[0]->first_name . ' ' . $user[0]->last_name,
					'email' => $user[0]->email,
					'group_id' => $user[0]->group_id,
					'd_name' => $user[0]->d_name,
					'sub_dep_name' => $user[0]->sub_dep_name,
					'mobile_no' => $user[0]->mobile_no,
					'department_id' => $user[0]->department,

            );             
                  
               return $purpose;
		}
		

	}

	function get_user_info_by_id($id){

		$user = DB::table('tb_users')
				->leftJoin('tb_departments','tb_departments.d_id','=','tb_users.department')
				->leftJoin('subdepartments','subdepartments.sub_dep_id','=','tb_users.sub_department')

				->select('tb_users.*','tb_departments.d_name','subdepartments.sub_dep_name')
				->where('id', $id)
				 ->where('tb_users.active',1)
				->get();

		if($user) {

			$purpose = array(
					'id' => $user[0]->id,
					'name' => $user[0]->first_name . ' ' . $user[0]->last_name,
					'email' => $user[0]->email,
					'group_id' => $user[0]->group_id,
					'd_name' => $user[0]->d_name,
					'sub_dep_name' => $user[0]->sub_dep_name,
					'mobile_no' => $user[0]->mobile_no,
					'department_id' => $user[0]->department,

			);
			return $purpose;
		}
		

	}

	function get_request_info_by_id($id){

		return $user = DB::table('tb_users')
				->select('request_id.*')
				->where('request_id', $id)
				->get();
	}

	function get_last_status($id){
		$latestJournal = DB::table('request_progress_status')
				->where('request_id',$id)
				->orderBy('request_progress_status.id', 'desc')
				->get();

				return $latestJournal;


	}
	public function get_sterring_committee_for_update_risk_ana()
	{

		$datas = DB::table('subdepartments')
				// ->leftJoin('tb_users','subdepartments.sub_dep_id','tb_users.sub_department')
				->select('subdepartments.sub_dep_id', 'subdepartments.sub_dep_name')
				->where('department_id', 11)
				->get();


		foreach ($datas as $data) {
			$res[] = array(
					//'sub_dep_id' => $data->sub_dep_id,
					//'sub_dep_name' => $data->sub_dep_name,
					'members' => $this->get_steering_committee_($data->sub_dep_id),


			);
		}




		return $res;
	}

	function get_initiator_id_by_request_id($id){

		$latestJournal = DB::table('changerequests')
				->select('changerequests.initiator_id')
				->where('request_id',$id)
				//->order_by('request_progress_status.id', 'desc')
				->first();

		return $latestJournal->initiator_id;
	}

	function get_hod_by_user_department_subdept($dep_id,$sub_dep){

		$data = DB::table('tb_users')
				->select('tb_users.id', 'tb_users.first_name', 'tb_users.last_name')
				->where('tb_users.department', '=', $dep_id)
				->where('tb_users.sub_department','=',$sub_dep)
				->whereRaw("find_in_set(4,tb_users.group_id)")
				->get();


		if($data) {

			$main = array(
					'id' => $data[0]->id,
					'name' => $data[0]->first_name . ' ' . $data[0]->last_name,

			);

		//	print_r($main);exit;
			return $main;
		}

	}
	
	function get_hod_by_user_department($dep_id){

		$data = DB::table('tb_users')
				->select('tb_users.id', 'tb_users.first_name', 'tb_users.last_name')
				->where('tb_users.department', '=', $dep_id)

				->whereRaw("find_in_set(4,tb_users.group_id)")
				->get();


		if($data) {

			$main = array(
					'id' => $data[0]->id,
					'name' => $data[0]->first_name . ' ' . $data[0]->last_name,

			);

		//	print_r($main);exit;
			return $main;
		}

	}

	/**
	 * @param $dep
	 * @param $member
	 * @param $request
	 * @return mixed
	 */

	function check_team_member_initial_sheet($dep,$member,$request){

		$users = DB::table('tb_updatesheet_dep_team')
				->select(DB::raw('COUNT(update_sheet_dep_id) as total'))
				->where('tb_updatesheet_dep_team.request_id', $request)
				->where('tb_updatesheet_dep_team.department', $dep)
				//->where('tb_updatesheet_dep_team.team_member', $member)
				->get();

		return $users[0]->total;
	}

	/**
	 * @param $dep
	 * @param $user_id
	 * @param $request
	 * @return mixed
	 */

	function check_data_as_ds($dep,$user_id,$request){

		$users = DB::table('approve_for_risk_assessment')
				->select(DB::raw('COUNT(approve_for_risk_assessment.approve_id) as total'))
				->where('approve_for_risk_assessment.sub_dep_id', $dep)
				->where('approve_for_risk_assessment.user_id', $user_id)
				->where('approve_for_risk_assessment.request_id', $request)
				->get();

		return $users[0]->total;

	}

	function generate_cm_no($change_type_name,$created_date,$request_id,$status=NULL)
	{
		
		// if ($status== 1 || $status== 5) {
		// 	return 'NA';
		// } else {


			$name = substr($change_type_name, 0, 1) . 'CM';
			$date = explode(' ', $created_date);
			$date1 = explode('-', $date[0]);
			return $name . '/' . $date1[0] . '/' . $request_id;
		//}
	}

		function generate_cm_no_search($change_type_name,$created_date,$request_id){
			$name=substr($change_type_name, 0, 1).'CM';
			$date=explode(' ',$created_date);
			$date1=explode('-',$date[0]);

				return $name.'/'.$date1[0].'/'.$request_id;

			}

	/**
	 * @param $date
	 * @return string
	 */

	function get_custom_date($date){

		if($date!='') {
			$date = explode(' ', $date);
			$date1 = explode('-', $date[0]);

			return $date1[2] . '.' . $date1[1] . '.' . $date1[0];
		}else{

			return ;
		}


	}

	function get_custom_date1($date){

		if($date!='') {
			$date = explode(' ', $date);
			$date1 = explode('-', $date[0]);

			return $date1[1] . '.' . $date1[2] . '.' . $date1[0];
		}else{

			return ;
		}


	}


	/**
	 * @param $id
	 * @return array
	 */
	 function get_risk_by_request_id($id,$subdep){
		$res=array();
		$points  = DB::table('tb_risk_assessment_points')
				->leftJoin('subdepartments', 'tb_risk_assessment_points.risk_sub_dep', '=', 'subdepartments.sub_dep_id')
				->select('tb_risk_assessment_points.*')
				->orderBy('tb_risk_assessment_points.created', 'ASC')
				->where('request_id', $id)
				->where('risk_sub_dep', $subdep)

				->get();

		foreach($points as $point){
			$res[]=array(
					'assessment_point'=>$point->assessment_point,
					'applicability'=>$point->applicability,
					'reason'=>$point->reason,
					'responsibility'=>$point->responsibility,
					'target_date'=>$point->target_date,
					'cost'=>$point->cost,

			);
		}
		return $res;
	}

	function get_hod_according_to_user(){

		$users  = DB::table('tb_users')
				//->leftJoin('tb_role', 'tb_role.role_id', '=', 'tb_users.user_role')
				->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
				//->whereIn('tb_users.group_id', $group_id)
				->where('tb_users.sub_department',Session::get('sub_dep_id'))
				//->whereRaw("find_in_set(".$group_id.",tb_users.group_id)")


				->get();

		foreach($users as $point){
			$res[]=array(
					'name'=>$point->first_name.' '.$point->last_name,
					'email'=>$point->email,
					'user_id'=>$point->id,
			);
		}
		return $res;
	}


	function get_user_by_role($group_id){
		$users  = DB::table('tb_users')
				//->leftJoin('tb_role', 'tb_role.role_id', '=', 'tb_users.user_role')
				->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','tb_users.group_id')
				//->whereIn('tb_users.group_id', $group_id)
				->whereRaw("find_in_set(".$group_id.",tb_users.group_id)")
				 ->where('tb_users.active',1)

				->get();

		foreach($users as $point){
			$res[]=array(
					'name'=>$point->first_name.' '.$point->last_name,
					'email'=>$point->email,
					'user_id'=>$point->id,
			);
		}
		return $res;
	}


		function team_member_by_request($request_id,$id){
			//$res=array();
			$users  = DB::table('tb_users')
					->leftJoin('tb_updatesheet_dep_team', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
					->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email')
					->where('tb_updatesheet_dep_team.request_id', $request_id)
					->where('tb_updatesheet_dep_team.department', $id)

					->first();

			//print_r($users);exit;

			//foreach($users as $point){
			if($users) {
				$res = array(
						'name' => $users->first_name . ' ' . $users->last_name,
					//'email'=>$point->email,
					//'user_id'=>$point->id,
				);
				//}
				return $res;
			}else{return '';}
		}

	 function get_team_leader_name($request_id){



		$users  = DB::table('tb_users')
					->leftJoin('add_update_initial_sheet', 'add_update_initial_sheet.team_leader_id', '=', 'tb_users.id')
					->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_users.email','add_update_initial_sheet.stock','add_update_initial_sheet.comment')
					->where('add_update_initial_sheet.request_id', $request_id)
					//->where('tb_updatesheet_dep_team.department', $id)

					->first();



		 if($users) {

			 $res = array(
					 'name' => $users->first_name . ' ' . $users->last_name,
					 'stock' => $users->stock,
					 'comment'=>$users->comment

			 );

			 return $res;
		 }
		 else{
			 $res = array(
					 'name' =>  '',
					 'stock' => '',
					 'comment'=> ''

			 );

			 return $res;
		 }

	}

	function get_report_name($id){
		 $reports = DB::table('report_types')
				->select('report_name')
				->where('id','=',$id)
				->get();

		return $reports[0]->report_name;


	}


		function get_report_type_1($created_date,$end_date,$input,$param,$id){

		$type=$input->report_type;

		$query = DB::table('changerequests')
				//->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);

		if($type==1)
			$query->where('request_progress_status.status', 1);
		if($type==2)
		$query->where('request_progress_status.status',2);
		if($type==3)
			$query->where('request_progress_status.status', 2);
		if($type==4)
			$query->where('request_progress_status.status', [2]);
		if($type==5)
			$query->where('request_progress_status.status', [2]);
		if($type==6)
			$query->where('request_progress_status.status', [2]);
		if($type==7)
			$query->where('request_progress_status.status', [2]);
		if($type==8)
			$query->where('request_progress_status.status', [2]);
		if($type==9)
			$query->where('request_progress_status.status', [2]);
		if($type==10)
			$query->where('request_progress_status.status', [2]);
				if($input->change_stage_id != '? undefined:undefined ?')
						 $query->where('changerequests.change_stage', $input->change_stage_id);
				if($input->changeType != '? undefined:undefined ?')
					$query->where('changerequests.changeType', $input->changeType);
				if($input->customer_id != '? undefined:undefined ?')
					$query->where('changerequests_customer.customer_id', $input->customer_id);

				 $query->where('changerequests.dep_id', $id);
		         $query->where('changerequests.dt', '>=', $created_date);
				 $query ->where('changerequests.dt', '<=', $end_date);
		       //  $query ->where('request_progress_status.status','=', 1);
		         $query ->where('request_progress_status.close','=', 0);
		         $query->where('changerequests.dt','<=',Carbon::parse($param)->toDateTimeString());

				$users=$query->get();

		return $users[0]->total;
	}


	function get_report_type_2($created_date,$end_date,$input,$param,$id){






		$type=$input->report_type;



		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);

		if($type==1)
			$query->where('request_progress_status.status', 1);
		if($type==2)
			$query->where('request_progress_status.status',2);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
		    $query->where('changerequests_customer.flag','!=',1);

		// $query->where('tb_users.department', $id);
		$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);
		//$query ->where('request_progress_status.status','=', 1);
		$query ->where('request_progress_status.close','=', 0);

		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());

		$users=$query->get();

		//	print_r($users);exit;

		return $users[0]->total;

	}
	function get_report_type_3($created_date,$end_date,$input,$param,$id){

		$type=$input->report_type;

		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('add_updated_risk_assessment_sheet', 'add_updated_risk_assessment_sheet.r_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc') 
				->limit(1);


		if($type==3)
			$query->whereIn('request_progress_status.status',[6,9,11,99]);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
			$query->where('changerequests_customer.flag','!=',1);
			$query->where('add_updated_risk_assessment_sheet.user_department', $id);
			$query->where('changerequests.dt', '>=', $created_date);
			$query ->where('changerequests.dt', '<=', $end_date);
			$query ->where('request_progress_status.close','=', 0);

			$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());

		$users=$query->get();

		return $users[0]->total;

	}
	function get_report_type_4($created_date,$end_date,$input,$param,$id){

		$type=$input->report_type;

		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('add_updated_risk_assessment_sheet', 'add_updated_risk_assessment_sheet.r_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc') 
				
				->limit(1);


		if($type==4)
			$query->where('request_progress_status.status','=',7);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
			$query->where('changerequests_customer.flag','!=',1);
			$query->where('add_updated_risk_assessment_sheet.user_department', $id);
			$query->where('changerequests.dt', '>=', $created_date);
			$query ->where('changerequests.dt', '<=', $end_date);

			$query ->where('request_progress_status.close','=', 0);

			$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());

		$users=$query->get();
		// print_r($users);exit();
		return $users[0]->total;


	}
	function get_report_type_5($created_date,$end_date,$input,$param,$id){

		$type=$input->report_type;

		$query = DB::table('changerequests')
				// ->leftJoin('subdepartments', 'subdepartments.sub_dep_id', '=', 'changerequests.sub_dep_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);


		if($type==5)
			$query->where('request_progress_status.status',88);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
		    $query->where('changerequests_customer.flag','!=',1);


		    $query->where('request_progress_status.assigned_to_sub_dep_id', $id);
			$query->where('changerequests.dt', '>=', $created_date);
			$query ->where('changerequests.dt', '<=', $end_date);
		    $query ->where('request_progress_status.close','=', 0);

			$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();

		return $users[0]->total;

	}
	function get_report_type_6($created_date,$end_date,$input,$param,$id){
		$type=$input->report_type;

		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);


		if($type==6)
			$query->where('request_progress_status.status',10);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
		$query->where('changerequests_customer.flag','!=',1);
		$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);
		$query ->where('request_progress_status.close','=', 0);

		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();



		return $users[0]->total;
	}
	function get_report_type_7($created_date,$end_date,$input,$param,$id){
		$type=$input->report_type;

		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);

		if($type==7)
			$query->whereIn('request_progress_status.status',[12,15]);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
		$query->where('changerequests_customer.flag','!=',1);
		$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);
		$query ->where('request_progress_status.close','=', 0);

		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();



		return $users[0]->total;
	}
	function get_report_type_8($created_date,$end_date,$input,$param,$id){

		$type=$input->report_type;

		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('attachment_activity_monitoring_summerysheet', 'attachment_activity_monitoring_summerysheet.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);

		if($type==8)
			$query->where('request_progress_status.status',14);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
		$query->where('changerequests_customer.flag','!=',1);
		$query->where('attachment_activity_monitoring_summerysheet.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);


		$query ->where('request_progress_status.close','=', 0);

		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());

		$users=$query->get();

		return $users[0]->total;
	}
	function get_report_type_9($created_date,$end_date,$input,$param,$id){
		$type=$input->report_type;

		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);

		if($type==9)
			$query->where('request_progress_status.status',17);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
		$query->where('changerequests_customer.flag','!=',1);
		$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);

		$query ->where('request_progress_status.close','=', 0);
		//die;
		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();



		return $users[0]->total;
	}
	function get_report_type_10($created_date,$end_date,$input,$param,$id){

		$type=$input->report_type;


		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);



		if($type==10)
			$query->where('request_progress_status.status',18);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
		$query->where('changerequests_customer.flag','!=',1);
		$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);
		//$query ->where('request_progress_status.status','=', 1);
		$query ->where('request_progress_status.close','=', 0);
		//die;
		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();

		return $users[0]->total;


	}
	function get_report_type_11($created_date,$end_date,$input,$param,$id){
		$type=$input->report_type;


		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);



		if($type==11)
			$query->where('request_progress_status.status',18);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
			$query->where('changerequests_customer.flag','!=',1);
		$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);
		//$query ->where('request_progress_status.status','=', 1);
		$query ->where('request_progress_status.close','=', 0);
		//die;
		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();

		return $users[0]->total;
	}

	function get_report_type_12($created_date,$end_date,$input,$param,$id){
		$type=$input->report_type;

		
		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);



		if($type==12)
			$query->where('request_progress_status.status',22);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
			$query->where('changerequests_customer.flag','!=',1);
		$query->where('changerequests.dep_id', $id);
		//$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);
		//$query ->where('request_progress_status.status','=', 1);
		$query ->where('request_progress_status.close','=', 0);
		//die;
		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();

		return $users[0]->total;
	}
	function get_report_type_13($created_date,$end_date,$input,$param,$id){
		$type=$input->report_type;

		
		$query = DB::table('changerequests')
				// ->leftJoin('tb_users', 'tb_users.id', '=', 'changerequests.initiator_id')
				->leftJoin('changerequests_customer', 'changerequests_customer.request_id', '=', 'changerequests.request_id')
				->leftJoin('request_progress_status', 'request_progress_status.request_id', '=', 'changerequests.request_id')
				->select(DB::raw('COUNT(distinct changerequests.request_id)as total'))
				->orderBy('request_progress_status.id','desc')
				->limit(1);



		if($type==13)
			$query->where('request_progress_status.status',19);
		if($input->change_stage_id != '? undefined:undefined ?')
			$query->where('changerequests.change_stage', $input->change_stage_id);
		if($input->changeType != '? undefined:undefined ?')
			$query->where('changerequests.changeType', $input->changeType);
		if($input->customer_id != '? undefined:undefined ?')
			$query->where('changerequests_customer.customer_id', $input->customer_id);
			$query->where('changerequests_customer.flag','!=',1);
		$query->where('changerequests.dep_id', $id);
		//$query->where('changerequests.dep_id', $id);
		$query->where('changerequests.dt', '>=', $created_date);
		$query ->where('changerequests.dt', '<=', $end_date);
		//$query ->where('request_progress_status.status','=', 1);
		$query ->where('request_progress_status.close','=', 0);
		//die;
		$query->where('request_progress_status.created_date','<=',Carbon::parse($param)->toDateTimeString());


		$users=$query->get();

		return $users[0]->total;
	}

	function get_report_type_data($created_date,$end_date,$input,$param,$id){

		//print_r($input);exit;

			if($input->report_type==1){

                return $this->get_report_type_1($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==2){
                return $this->get_report_type_2($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==3){
                return $this->get_report_type_3($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==4){
                return $this->get_report_type_4($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==5){
                return $this->get_report_type_5($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==6){
                return $this->get_report_type_6($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==7){
                return $this->get_report_type_7($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==8){
                return $this->get_report_type_8($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==9){
                return $this->get_report_type_9($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==10){
                return $this->get_report_type_10($created_date,$end_date,$input,$param,$id);

            }else if($input->report_type==11){
				return $this->get_report_type_11($created_date,$end_date,$input,$param,$id);

			}else if($input->report_type==12){
				return $this->get_report_type_12($created_date,$end_date,$input,$param,$id);

			}else if($input->report_type==13){
				return $this->get_report_type_13($created_date,$end_date,$input,$param,$id);

			}



        }

	/**
	 * @param $input
	 * @return mixed
	 */
	function get_chart_report($input)
	{
		if(!strcmp((String)$input->startdate,(String)$input->enddate)){
			$std=explode('/',$input->startdate);
			$created_date=$std[2].'-'.$std[0].'-'.$std[1].' 00:00:00';
			$etd=explode('/',$input->enddate);
			$end_date=$etd[2].'-'.$etd[0].'-'.$etd[1].' 23:59:00';

		}else {
			$std = explode('/', $input->startdate);
			$created_date = $std[2] . '-' . $std[0] . '-' . $std[1] . ' 00:00:00';
			$etd = explode('/', $input->enddate);
			$end_date = $etd[2] . '-' . $etd[0] . '-' . $etd[1] . ' 23:59:00';
		}

		if($input->report_type==5){

			$users = DB::table('subdepartments')
					//->leftJoin()
					->select('subdepartments.sub_dep_name','subdepartments.sub_dep_id')
					->where('subdepartments.department_id','=',11)
					->get();

			foreach ($users as $value) {

				$data['name'][] =
						$value->sub_dep_name;


			}

			foreach ($users as $value) {//echo "first";
				//Enddate minus two weeks
				$data['val1'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-2 week',$value->sub_dep_id);


			}
			foreach ($users as $value) {//echo "second";

				$data['val2'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-1 months',$value->sub_dep_id);


			}
			foreach ($users as $value) {//echo "third";

				$data['val3'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-2 months',$value->sub_dep_id);


			}
			foreach ($users as $value) {//echo "fourth";

				$data['val4'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-3 months',$value->sub_dep_id);


			}

			$data['header']=$this->get_report_name($input->report_type);

			return $data;

		}else{
			$users = DB::table('tb_departments')
					->select('tb_departments.*')
					->where('tb_departments.d_id','!=',11)
					->where('tb_departments.d_id','!=',2)
					->get();

			foreach ($users as $value) {

				$data['name'][] =
						$value->d_name;


			}

			//print()

			foreach ($users as $value) {//echo "first";
				//Enddate minus two weeks
				$data['val1'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-2 week',$value->d_id);


			}
			foreach ($users as $value) {//echo "second";

				$data['val2'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-1 months',$value->d_id);


			}
			foreach ($users as $value) {//echo "third";

				$data['val3'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-2 months',$value->d_id);


			}
			foreach ($users as $value) {//echo "fourth";

				$data['val4'][] =
						$this->get_report_type_data($created_date,$end_date,$input,'-3 months',$value->d_id);


			}

			$data['header']=$this->get_report_name($input->report_type);

			return $data;

		}








	/*	if(isset($input->startdate)&& !empty($input->startdate)){
			$startdate=$input->startdate;
			$date1=explode('/',$startdate);
			$date = Carbon::create($date1[2], $date1[0], $date1[1]);

		}

			if($input->report_type==4){
				 $users = DB::table('tbl_change_type')
						->select('change_type_name','change_type_id as id')
						->get();

				foreach ($users as $value) {

					$data['name'][] =
							$value->change_type_name;


				}

			}else{
				$users = DB::table('changerequest_purpose')
						->select('changerequest_purpose.*')
						->get();

				foreach ($users as $value) {

					$data['name'][] =
							$value->changerequest_purpose;


				}

			}



			foreach ($users as $value) {

				$data['val1'][] =
						$this->get_report_type_data($date,$input,'-1 week',$value->id);


			}
		foreach ($users as $value) {

			$data['val2'][] =
					$this->get_report_type_data($date,$input,'-1 months',$value->id);


		}
		foreach ($users as $value) {

			$data['val3'][] =
					$this->get_report_type_data($date,$input,'-2 months',$value->id);


		}
		foreach ($users as $value) {

			$data['val4'][] =
					$this->get_report_type_data($date,$input,'-3 months',$value->id);


		}

		$data['header']=$this->get_report_name($input->report_type);

		return $data;*/

	}
	 function fetch_risk_assessment_from_admin($id,$riskAssId,$dept_id){
		$data  = DB::table('tb_risk_assessment_points_admin')
				->select('tb_risk_assessment_points_admin.*')
				->where('tb_risk_assessment_points_admin.risk_sub_department','=',$dept_id)
                ->where('tb_risk_assessment_points_admin.status','=','active')
				->orderBy('tb_risk_assessment_points_admin.created', 'ASC')
				->get();

		 	foreach($data as $risk){

				DB::table('tb_risk_assessment_points')->insert(
						array('responsibility' => $riskAssId,
								'risk_dep' => $dept_id,
								'request_id' => $id,
								'risk_assessment_id_admin' => $risk->risk_assessment_id_admin,
								'status'=>1

						)
				);
			}

	}

	function fetch_risk_assessment($id,$riskAssId,$dept_id){
        $data  = DB::table('tb_risk_assessment_points')
				->leftJoin('tb_risk_assessment_points_admin','tb_risk_assessment_points_admin.risk_assessment_id_admin','=','tb_risk_assessment_points.risk_assessment_id_admin')
				->select('tb_risk_assessment_points_admin.assessment_point_department','tb_risk_assessment_points.*')
				->where('tb_risk_assessment_points.risk_dep','=',$dept_id)
				->where('tb_risk_assessment_points.responsibility','=',$riskAssId)
				->where('tb_risk_assessment_points.request_id','=',$id)
				->orderBy('tb_risk_assessment_points_admin.created', 'ASC')
				->get();


		//print_r($data['target_date']);exit;
		if($data!='') {



			$purpose=array();
			foreach ($data as $user) {
				if($user->target_date=="0000-00-00"){

					$target_date='';
				}else{

					$target_date=$user->target_date;
				}
				if($user->cost=="0"){
					$cost='';
				}else{


					$cost=$user->cost;
				}
				if($user->piececost=="0"){
					$piececost='';
				}else{


					$piececost=$user->piececost;
				}



				$purpose[] = array(
						'assessment_point_department' => $user->assessment_point_department,
						'risk_assessment_id' => $user->risk_assessment_id,
						'request_id' => $user->request_id,
						'risk_dep' => $user->risk_dep,
						'risk_assessment_id_admin' => $user->risk_assessment_id_admin,
						'applicability' => $user->applicability,
						'reason' => $user->reason,
						'responsibility' => $user->responsibility,
						'target_date' => $target_date,
						'cost' => $cost,
						'piececost'=>$piececost,
						'status' => $user->status,
						'de_risking' => $user->de_risking,
						'status_activity_monitoring' => $user->status_activity_monitoring,
						'status_verification' => $user->status_verification,

				);

			}


			return $purpose;
		}

      // return $data;


	}

	public function getDeptAsPerProject($proj_code,$r_id){
		
	
			
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

				
                  
                   
						foreach ($dept as $row) {
						
							DB::table('tb_updatesheet_dep_team')->insert(
								array(
									'request_id' => $r_id,
									'department' => $row->d_id,
									'team_member'	=>$row->user_id,
									'fetch_status'=> 2,
									'created'=>date('Y-m-d H:i:s')

								)
							);
							DB::table('add_updated_risk_assessment_sheet')->insert(
								array(
										'r_id' => $r_id,
										'user_id' => $row->user_id,
										'user_department' => $row->d_id,
										'status'=>1,
										'created'=>date('Y-m-d H:i:s'),
										'created_date'=>date('Y-m-d H:i:s') 

								)
							);
						}
					

					 
						return $dept;
				

	}

	function fetch_all_department($id,$dept){
		// $data  = DB::table('tb_departments')
		// 		->select('tb_departments.*')
		// 		->where('tb_departments.d_id','!=',11)
		// 		->orderBy('tb_departments.d_id', 'ASC')
		// 		->get();

		$data = explode(',', $dept[0]->department);


		foreach($data as $risk){

			DB::table('tb_updatesheet_dep_team')->insert(
					array(
							'request_id' => $id,
							'department' => $risk,
							'fetch_status'=>1,
							'created'=>date('Y-m-d H:i:s')

					)
			);
		}

	}

	function fetch_all_department_1($id,$dept){

		// $data  = DB::table('tb_departments')
		// 		->select('tb_departments.*')
		// 		->where('tb_departments.d_id','!=',11)
		// 		->orderBy('tb_departments.d_id', 'ASC')
		// 		->get();

		$data = explode(',', $dept[0]->department);

		foreach($data as $risk){

			DB::table('add_updated_risk_assessment_sheet')->insert(
					array(
							'r_id' => $id,
							'user_department' => $risk,
							//'fetch_status'=>1

					)
			);
		}


	}

	function fetch_department($id){

		$data  = DB::table('tb_updatesheet_dep_team')
				->leftJoin('tb_departments','tb_departments.d_id','=','tb_updatesheet_dep_team.department')
				->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
				->select('tb_departments.d_name','tb_updatesheet_dep_team.update_sheet_dep_id','tb_updatesheet_dep_team.*','tb_users.first_name', 'tb_users.last_name','tb_users.department as d_id')

				->where('tb_updatesheet_dep_team.request_id','=',$id)

				->get();

		return $data;


	}
	function remove_customer_from_list($request_id,$id)
	{

		DB::table('changerequests_customer')
				->where('request_id', $request_id)
				->where('id', $id)
				->update(
				array('admin_status' => 1,
			)
		);

	}

	function show_customer_from_list($request_id,$id)
	{

		DB::table('changerequests_customer')
				->where('request_id', $request_id)
				->where('id', $id)
				->update(
						array('admin_status' => 0,
						)
				);

	}

	/*
	 *
	 * trial
	 *
	 *
	 */

	function show_customer_from_list_trial($request_id,$id)
	{

		//print_r($id);exit;



		DB::table('changerequests_customer')
				->where('request_id', $request_id)
				->where('id', $id)
				->update(
						array('flag' => 1,
						)
				);

	}

	function get_assigned_by_user_id($id){

		$data  = DB::table('request_progress_status')
				     ->select('request_progress_status.assigned_by')
					 ->where('request_progress_status.id', $id)
				     ->first();

		return $data->assigned_by;

	}

	function get_assigned_to_user_id($id){
		$data  = DB::table('request_progress_status')
				->select('request_progress_status.assigned_to')
				->where('request_progress_status.id', $id)
				->first();

		return $data->assigned_to;

	}

	function get_hdata_status($id){

		$datas  = DB::table('changerequests_customer')
				->select('changerequests_customer.flag','changerequests_customer.customer_id')
				->where('changerequests_customer.request_id',$id)
				->get();



		foreach($datas as $data){
						$result[]= array(

							'flag' => $data->flag,
							'customer_id'=>$data->customer_id,


			);
		}

		return $result;

	}

	function count_hide_data($id){

		$data1 = DB::table('changerequests_customer')
				->select(DB::raw('COUNT(id) as total'))
				->where('changerequests_customer.request_id', $id)
				->get();


		$data2 = DB::table('changerequests_customer')
				->select(DB::raw('COUNT(id) as total'))
				->where('changerequests_customer.request_id', $id)
				->where('changerequests_customer.flag', 1)
				->get();


		if ($data1[0]->total == $data2[0]->total) {
			return 1;
		} else {
			return 0;
		}



	}
	//----start code for ubuntu -----
	// function check_netconnection(){

	// 	$response = null;
	// 	system("ping -c 1 google.com", $response);
	// 	if($response == 0)
	// 	{
	// 		return 1;

	// 	}else{

	// 		return 0;
	// 	}
	// }
	//------------------------
//----start code for windows -----
 /*function check_netconnection(){

		$pingresult = null;
 		$ip = Config::get('mail.host');
            $pingresult = system("ping -n 1 $ip | FIND \"Reply\"");
            $alive = "Reply from";
 	    $deadoralive = strpos($pingresult,$alive);
	if ($deadoralive === FALSE)	
	    {return 0;}
	else
            {return 1;	}
 		// return 0;
 	}
*/
	function check_netconnection(){

		return 1;
		
	}

	//------------------------
	
	function save_task_status($user_id,$dep,$request_id){


		 DB::table('attachment_activity_monitoring_summerysheet')->insert(
				 array('request_id' => $request_id,
						 'user_id' => $user_id,
						 'dep_id'=>$dep,
						 'task_status'=>1,//1 status is for in i.e task came to particular user
					     'created_date' => date('Y-m-d H:i:s'),

				 )
		 );


	}
	/*
	 *
	 * Function for admin reject activity completion sheet
	 *
	 */
	function admin_reject_activity_completion_sheet($user_id,$request_id){


		DB::table('attachment_activity_monitoring_summerysheet')
				->where('request_id', $request_id)
				->where('user_id', $user_id)

				->update(
						array('task_status' => 1,
								//'created_date' => '',
								'admin_status'=>2
						)
				);

	}

	public function get_coo_approval_status($id){
		$coostatus=array();
		$coostatus=DB::table('coo_approval_decision_status')
				  ->where('request_id',$id) 
				  ->get();	  
		return $coostatus;	  	
	}

	public function fetch_dep_team_WithComment($id)
    {
        $data = DB::table('tb_updatesheet_dep_team')
            ->leftJoin('tb_departments', 'tb_updatesheet_dep_team.department', '=', 'tb_departments.d_id')
            ->leftJoin('tb_users', 'tb_updatesheet_dep_team.team_member', '=', 'tb_users.id')
           
            ->select('tb_users.first_name', 'tb_users.last_name','tb_users.id', 'tb_departments.*', 'tb_updatesheet_dep_team.update_sheet_dep_id','tb_updatesheet_dep_team.fetch_status')
            ->where('tb_updatesheet_dep_team.request_id', '=', $id)
            ->groupBy('tb_updatesheet_dep_team.department')
            ->get();
         
            foreach ($data as $key) {
            	// return $key;
            	$data1[]=array(
            	'first_name'=>$key->first_name,
            	'last_name'=>$key->last_name,
            	'id'		=>$key->id,
            	'd_name'	=>$key->d_name,
            	'reject_reason'=>$this->getAdminComment($key->id,$id)
            	);
            }

        return $data1;

    }
    public function getAdminComment($uid,$id){

    $data = DB::table('approval_risk_assessment_from_admin')
            ->select('approval_risk_assessment_from_admin.reject_reason')
            ->where('approval_risk_assessment_from_admin.request_id', '=', $id)
             ->where('approval_risk_assessment_from_admin.user_id', '=', $uid)
            ->get();
            if(!empty($data)){
            return $data[0]->reject_reason;
        }
           

        }
     public function getAllChangeRequ(){
      

       $cmNo="";

        
             $requestId=DB::table('changerequests')
           ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id','request_id')
           ->select('tbl_change_type.change_type_name','changerequests.*')
           ->get();
           
      foreach($requestId as $row) {

            $data[] = array(
                'request_id' => $this->generate_cm_no_search($row->change_type_name, $row->created_date, $row->request_id),
                'r_id'      =>$row->request_id,
            );
        }
        return $data;

    }

    public static function getCompanyName()
    {
      $data = DB::table('tb_dept_addremove')
      ->select('company_name')
      ->get();
      if(!empty($data)){
      	return $data[0]->company_name;
      }
    }
    



}
