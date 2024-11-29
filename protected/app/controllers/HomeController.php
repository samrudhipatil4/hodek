<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	
	
	public function index()
	{

		if(Auth::check()):
				 return Redirect::to('dashboard')->with('message',SiteHelpers::alert('success','Youre already login'));
			else:
				 return Redirect::to('user/login');
			  endif;

			  
		if(CNF_FRONT =='false' && Request::segment(1) =='' ) :
			return Redirect::to('dashboard');
		endif; 
		
		if(is_null(Input::get('p')))
		{
			$page = Request::segment(1); 	
		} else {
			$page = Input::get('p'); 	
		}
		if($page !='') :
			$content = Pages::where('alias','=',$page)->where('status','=','enable');
			if($content->count() >=1)
			{
				$content = $content->get();
				$row = $content[0];
				$this->data['pageTitle'] = $row->title;
				$this->data['pageNote'] = $row->note;		
				$this->data['breadcrumb'] = 'active';					
				
				if($row->access !='')
				{
					$access = json_decode($row->access,true)	;	
				} else {
					$access = array();
				}	

				// If guest not allowed 
				if($row->allow_guest !=1)
				{	
					$group_id = Session::get('gid');				
					$isValid =  (isset($access[$group_id]) && $access[$group_id] == 1 ? 1 : 0 );	
					if($isValid ==0)
					{
						return Redirect::to('')
							->with('message', SiteHelpers::alert('error',Lang::get('core.note_restric')));				
					}
				}				
				if($row->template =='backend')
				{
					 $this->layout = View::make("layouts.main");
				}
				
				$filename = public_path() ."protected/app/views/pages/template/".$row->filename.".blade.php";
				if(file_exists($filename))
				{
					$page = 'pages.template.'.$row->filename;
				} else {
					return Redirect::to('')
						->with('message', SiteHelpers::alert('error',Lang::get('core.note_noexists')));					
				}
				
			} else {
				return Redirect::to('')
					->with('message', SiteHelpers::alert('error',Lang::get('core.note_noexists')));	
			}
			
			
		else :
			$this->data['pageTitle'] = 'Home';
			$this->data['pageNote'] = 'Welcome To Our Site';
			$this->data['breadcrumb'] = 'inactive';			
			$page = 'pages.template.home';
		endif;	
		
		$page = SiteHelpers::renderHtml($page);
		

		$this->layout->nest('content',$page,$this->data)->with('menus', $this->menus )->with('page',$this->data);
			
	}
	
	
	
}