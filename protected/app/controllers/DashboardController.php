<?php
unset($_SESSION['btntype']);
class DashboardController extends BaseController  {

	//protected $layout = "layouts.main";
	
	
	
public function index()
	{
		  $time = microtime();
		  $time = explode(' ', $time);               
		  $time = $time[1]+$time[0];
		  $start = $time;

		  Session::put('phase', 'CM');
		if(Auth::check()):
				 return View::make('dashboard/index');
			 //return View::make('user/redirect');
				
			else:
				 return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
			  endif;
		
	}

	public function redirect(){
		
	
		 if(Auth::check()):
				 return View::make('user/redirect');
				
			else:
				 return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
			  endif;
		
	}

	public function findmember()
	{
				$a = Session::get('gid');
		                       
				$member = DB::table('tb_users')
				->leftJoin('tb_departments', 'tb_users.department', '=', 'tb_departments.d_id')
				->select('tb_departments.d_name')
              
                ->where('group_id', '=', $a)->get();      
                return $member;
			
	}

	public function findmemberdep_by_id($id)
	{
		//$a = Session::get('gid');

		$member = DB::table('tb_users')
				//->leftJoin('tb_departments', 'tb_users.department', '=', 'tb_departments.d_id')
				->select('tb_users.first_name','tb_users.last_name')

				->where('id', '=', $id)->get();
		return $member;

	}

			
	
}	