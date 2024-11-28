<?php
unset($_SESSION['btntype']);
class APQPdashboardController extends BaseController  {

	//protected $layout = "layouts.main";
	
	
	public function index()
	{
		  $time = microtime();
		  $time = explode(' ', $time);               
		  $time = $time[1]+$time[0];
		  $start = $time;
		   Session::put('phase', 'APQP');
		
		if(Auth::check()):
				 return View::make('APQP_dashboard/index');
			 //return View::make('user/redirect');
				
			else:
				 return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
			  endif;
		
	}

	
	


			
	
}	