<?php
/*
Route::get('/', function()
{
	return View::make('user/login');
});*/
if (defined('CNF_MULTILANG') && CNF_MULTILANG == 1) {
   $lang = (Session::get('lang') != "" ? Session::get('lang') : CNF_LANG);
    App::setLocale($lang);
}



include('pageroutes.php');

Route::get('/', 'UserController@index');
Route::get('emailTask', 'UserController@email');
Route::controller('user', 'UserController'); 
Route::controller('send', 'PasswordsendController'); 
Route::controller('home', 'HomeController');
Route::controller('blog', 'BlogController');
Route::controller('dashboard', 'DashboardController');
Route::controller('dashboard_admin', 'DashboardAdminController');


Route::group(array('prefix' => 'changerequest'), function()
{
	Route::resource('changes', 'ChangerequestController');
	Route::resource('advance-search', 'AdvancesearchController');
	Route::resource('reports', 'ReportsController');
      //  Route::resource('views', 'ViewController');
     //   Route::resource('scm', 'ScmController');
	
});


Route::group(array('before' => 'auth'), function() 
{
	/* CORE APPLICATION DONT DELETE IT */
	//Route::controller('pages', 'PagesController');
	
		/* CORE APPLICATION DONT DELETE IT */
	Route::controller('pages', 'PagesFrontController');
	Route::controller('users', 'UsersController');
	Route::controller('groups', 'GroupsController');
	Route::controller('menu', 'MenuController');

	Route::controller('logs', 'LogsController');
	Route::controller('blogadmin', 'BlogadminController');
	Route::controller('blogcategories', 'BlogcategoriesController');
	Route::controller('blogcomment', 'BlogcommentController');
	
	/* END CORE APPLICATION  */
	/* Dynamic Routers */
	
	include('moduleroutes.php');
});	


Route::group(array('before' => 'authSU'), function() 
{
		Route::controller('module', 'ModuleController');
		Route::controller('config', 'ConfigController');
});
