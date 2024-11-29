<?php
class PagesFrontController extends BaseController 
{

	protected $layout = "layouts.main";
	//protected $data = array();	
	//public $module = 'pages';
	//static $per_page	= '10';
	
	public function __construct() 
	{
		//parent::__construct();
		$this->beforeFilter('csrf', array('on'=>'post'));
	} 

	public function index()
	{
		$user_type = Session::get('gid');
		if($user_type!=""):
				return View::make('pages/aboutus');
			else:
				 return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
			  endif;
    }

	public function userdata()
	{
		$users = DB::table('tb_users')->select('first_name','email','last_name')->get();
		return $users;
   	}	
}