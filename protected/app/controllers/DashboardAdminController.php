<?php

class DashboardAdminController extends BaseController  {

	protected $layout = "layouts.main";
	
	public function __construct() {
		parent::__construct();
	}
	
	public function getIndex()
	{
		$user_type = Session::get('gid');
		if($user_type=="1" || $user_type=="11"):
				$this->layout->nest('content','dashboard_admin.index');	
			else:
				 return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
			  endif;

		//$this->layout->nest('content','dashboard_admin.index');	
	}		
	
}	