<?php

class PasswordsendController extends BaseController  {

	//protected $layout = "layouts.main";
	
	
	public function index()
	{
		//echo "hiii";
		//$this->layout->nest('content','dashboard.index');	
		return View::make('send/index');
	}		
	
}	