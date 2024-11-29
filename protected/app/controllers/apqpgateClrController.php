<?php
unset($_SESSION['btntype']);
class apqpgateClrController extends BaseController  {

	//protected $layout = "layouts.main";
	
	public function gateclearance(){

        if(Auth::check()):
                 return View::make('apqpTask/gateClearenceAuth');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    public function clrTask($aid,$tid){
        
         DB::table('apqp_all_task')
                        ->where('id',$tid)
                        ->update(
                            array(
                                'close' =>1,
                                )
                            );
return Redirect::to('apqp_dashboard');
    }
	

			
	
}	