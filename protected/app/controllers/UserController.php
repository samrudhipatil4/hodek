<?php

class UserController extends BaseController {

    
   protected $layout = "layouts.main";

    public function __construct() {
        $this->beforeFilter('csrf', array('on'=>'post'));

    } 
    public function index()
    {  
         $logo = DB::table('tb_logo')->select('company_logo_id','logo_image')->get();
         $data =DB::table('login_management')->select('phone_number','email_id')->get();

         $logos['logo_image']=$logo[0]->logo_image;

         $logos['phone_number']=$data[0]->phone_number;
         $logos['email_id']=$data[0]->email_id;
       
        if(Auth::check()):
                  return Redirect::to('redirection');
            else:
               
                return View::make('user/login',$logos);
              
              endif;
    }

public function email() {
      return View::make('user/emailTask'); 
    }

    public function getRegister() {
        
        if(CNF_REGIST =='false') :    
            if(Auth::check()):
                 return Redirect::to('dashboard')->with('message',SiteHelpers::alert('success','Youre already login'));
            else:
                 return Redirect::to('user/login');
              endif;
              
            else :
                $this->layout = View::make('layouts.login');
                $this->layout->content = View::make('user.register');             
         endif ; 
           
    

    }



    public function postSignin() {
        
        $rules = array(
            'email'=>'required',
            'password'=>'required',
        );   


      //  if(CNF_RECAPTCHA =='true') $rules['recaptcha_response_field'] = 'required|recaptcha';
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {

            if (Auth::attempt(array(
                    'email'     => Input::get('email'),
                    'password'  => Input::get('password')
                )) ||
                Auth::attempt(array(
                    'username'     => Input::get('email'),
                    'password'  => Input::get('password')
                ))) {
                if(Auth::check())
                {
                    $row = User::find(Auth::user()->id);

                    if($row->active =='0')
                    {
                        // inactive
                        Auth::logout();
                        return Redirect::to('')->with('message', SiteHelpers::alert('error','Your Account is not active'));

                    } else if($row->active=='2')
                    {
                        // BLocked users
                        Auth::logout();
                        return Redirect::to('')->with('message', SiteHelpers::alert('error','Your Account is BLocked'));
                    } else {
                        DB::table('tb_users')->where('id', '=',$row->id )->update(array('last_login' => date("Y-m-d H:i:s")));
                        Session::put('uid', $row->id);
                        Session::put('gid', $row->group_id);
                        Session::put('permission', $row->permission);
                        Session::put('ll', $row->last_login);
                        Session::put('fid', $row->first_name.' '. $row->last_name);
                        Session::put('dep_id', $row->department);
                        Session::put('sub_dep_id', $row->sub_department);


                        $user_type = Session::get('gid');

                        // return Redirect::to('dashboard')->with('message',SiteHelpers::alert('success','Login Success'));
                        //Auth::logout();


                        if($user_type == 9){
                            return Redirect::to('dashboard_admin');
                        }
                        else if($user_type !=9){
                            // print_r("in user 2 type");exit;
                            return Redirect::to('redirection')->with('message',SiteHelpers::alert('success','Login Success'));
                        }else {
                            return Redirect::to('')->with('message',SiteHelpers::alert('success','Login Success'));
                        }


                    }

                }

            } else {
                return Redirect::to('')
                    ->with('message', SiteHelpers::alert('error','Your username/password combination was incorrect'))
                    ->withInput();
            }
        } else {

            return Redirect::to('')
                ->with('message', SiteHelpers::alert('error','The following  errors occurred'))
                ->withErrors($validator)->withInput();
        }







    }
public function getDashboard() {
        $data = array('menus'=> SiteHelpers::menus());
        $this->layout->nest('content','users.dashboard')->with('menus', SiteHelpers::menus());
    }

   
    
    public function getProfile() {
        
        if(!Auth::check()) return Redirect::to('user/login');
        
        
        $user_id = Auth::user()->id;
        $info = User::find($user_id);
        $this->data = array(
            'pageTitle' => 'My Profile',
            'pageNote'  => 'View Detail My Info',
            'info'      => $info,
        );
        $this->layout = View::make('layouts.main');
        $this->layout->nest('content','user.profile',$this->data)->with('menus', SiteHelpers::menus());
    }
    

    
    public function postSavepassword()
    {
        $rules = array(
            'password'=>'required|alpha_num|between:6,12',
            'password_confirmation'=>'required|alpha_num|between:6,12'
            );      
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            $user = User::find(Session::get('uid'));
            $user->password = Hash::make(Input::get('password'));
            $user->save();

            return Redirect::to('user/profile')->with('message',SiteHelpers::alert('success','Password has been saved!'));
        } else {
            return Redirect::to('user/profile')->with('message', SiteHelpers::alert('error','The following errors occurred')
            )->withErrors($validator)->withInput();
        }   
    
    }  

    public function postSaveprofile()
    {
        if(!Auth::check()) return Redirect::to('user/login');
        $rules = array(
            'first_name'=>'required|alpha_num|min:2',
            'last_name'=>'required|alpha_num|min:2',
            );  
            
         
                
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes()) {
            
            
            if(!is_null(Input::file('avatar')))
            {
                $file = Input::file('avatar'); 
                $destinationPath = './uploads/users/';
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension(); //if you need extension of the file
                 $newfilename = Session::get('uid').'.'.$extension;
                $uploadSuccess = Input::file('avatar')->move($destinationPath, $newfilename);                
                if( $uploadSuccess ) {
                    $data['avatar'] = $newfilename; 
                } 
                
            }       
            
            $user = User::find(Session::get('uid'));
            $user->first_name   = Input::get('first_name');
            $user->last_name    = Input::get('last_name');
            $user->email        = Input::get('email');
            if(isset( $data['avatar']))  $user->avatar  = $newfilename;             
            $user->save();

            return Redirect::to('user/profile')->with('message',SiteHelpers::alert('success','Profile has been saved!'));
        } else {
            return Redirect::to('user/profile')->with('message', SiteHelpers::alert('error','The following errors occurred')
            )->withErrors($validator)->withInput();
        }   
    
    }
        
    public function getReminder()
    {
    
        $this->layout->content = View::make('user.remind');
    }   

    public function postRequest()
    {

        $rules = array(
            'credit_email'=>'required|email'
        );  
        
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) { 
    
            $user =  User::where('email','=',Input::get('credit_email'));
            if($user->count() >=1)
            {
                $user = $user->get();
                $user = $user[0];
                $data = array('token'=>Input::get('_token'));  
                  //  print_r($data);exit;
                //===============================  Custom Code  ========================================//


                Mail::send('emails/auth/reminder', array('token'=>Input::get('_token')), function($message){
                 $message->to(Input::get('credit_email'))->subject('Reset your password');
             });
                 $affectedRows = User::where('email', '=',$user->email)
                                ->update(array('reminder' => Input::get('_token')));
                                
                return Redirect::to('')->with('message', SiteHelpers::alert('success','Email containing password reset instructions is successfully sent to your email address'));    

              //  $message = "Thanks for registering! . Please check your inbox and follow activation link";

             /*   $user = $user->get();
                $user = $user[0];
                $data = array('token'=>Input::get('_token'));   
                $to = Input::get('credit_email');
                $subject = " REQUEST PASSWORD RESET ";          
                $message = View::make('emails/auth/reminder', $data);
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


              //  $headers .= 'From: '.CNF_APPNAME.' <'.CNF_EMAIL.'>' . "\r\n";
                    mail($to, $subject, $message, $headers);                
            
                
                $affectedRows = User::where('email', '=',$user->email)
                                ->update(array('reminder' => Input::get('_token')));
                                
                return Redirect::to('');    
              */
            } else {
                return Redirect::to('send')->with('message', SiteHelpers::alert('error','Sorry, we could not find an active account with that email address'));
            }

        }  else {
            return Redirect::to('')->with('message', SiteHelpers::alert('error','The following errors occurred')
            )->withErrors($validator)->withInput();
        }    
    }   
    
   public function getReset( $token = '')
    {
        $user = User::where('reminder','=',$token);
        if($user->count() >=1)
        {
            $data = array('verCode'=>$token);
            $this->layout = View::make('layouts.login');
            $this->layout->nest('content','user.remind',$data); 
        } else {
            return Redirect::to('')->with('message', SiteHelpers::alert('error','Sorry, we could not find an active account with that email address'));
        }
    /*   // echo "string";exit;
        $user = User::where('reminder','=',$token);
        //echo $token;exit;
        if($user->count() >=1)
        {
            //$data = $token;
           $data = array('verCode'=>$token);
          // echo "string";
          //  return View::make('user/remind');
          //  return Redirect::to('reset_password');  
            $this->layout = View::make('layouts/login');
            $this->layout->nest('content','user/remind',$data); 
        } else {
           // return Redirect::to('user/login');
        }*/
        
    }   
    
    public function postDoreset( $token = '')
    {
        $rules = array(
            'password'=>'required|between:6,12|confirmed',
           // 'password_confirmation'=>'required|between:6,12'
            );      
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->passes()) {
            
            $user =  User::where('reminder','=',$token);
            if($user->count() >=1)
            {
                $data = $user->get();
                $user = User::find($data[0]->id);
                $user->reminder = '';
                $user->password = Hash::make(Input::get('password'));
                $user->save();          
            }

           // return Redirect::to('');
            return Redirect::to('')->with('message',SiteHelpers::alert('success','Your password has been reset successfully.'));
        } else {
            return Redirect::to('user/reset/'.$token)->with('message', SiteHelpers::alert('error','The following errors occurred')
            )->withErrors($validator)->withInput();
        }   
    
    }   

    public function getLogout() {
        Session::forget('phase');

        if(Auth::check()):
        Auth::logout();
        Session::flush();
        return Redirect::to('');
            else:
               
         return Redirect::to('')->with('message',SiteHelpers::alert('error','You are already logout'));
              endif;

    //   return Redirect::to('');
    }

     public function getBack() {

         return Redirect::to('');
    }

    function autoSignin($user)
    {

        if(is_null($user)){
          return Redirect::to('user/login')
                ->with('message', SiteHelpers::alert('error','You have not registered yet '))
                ->withInput();
        } else{

            Auth::login($user);
            if(Auth::check())
            {
                $row = User::find(Auth::user()->id); 

                if($row->active =='0')
                {
                    // inactive 
                    Auth::logout();
                    return Redirect::to('user/login')->with('message', SiteHelpers::alert('error','Your Account is not active'));

                } else if($row->active=='2')
                {
                    // BLocked users
                    Auth::logout();
                    return Redirect::to('user/login')->with('message', SiteHelpers::alert('error','Your Account is BLocked'));
                } else {
                    Session::put('uid', $row->id);
                    Session::put('permission', $row->permission);
                    Session::put('gid', $row->group_id);
                    Session::put('eid', $row->group_email);
                    Session::put('fid', $row->first_name.' '. $row->last_name); 
                    if(CNF_FRONT =='false') :
                        return Redirect::to('config/dashboard');                        
                    else :
                        return Redirect::to('');
                    endif;                  
                    
                                        
                }
                
                
            }
        }

    }
    public function logo()
    {

        //Returns All plantcodes
        $logo = DB::table('tb_logo')->select('company_logo_id','logo_image')->get();
        
        return $logo;
   
 
    }

    public function login_pgdt()
    {


        $result = DB::table('login_management')->select('phone_number','email_id')->get();

        return $result;


    }
    //  public function dashboardlogo()
    // {
        
    //     $logo = DB::table('tb_dashboardlogo')->select('logo_id','logo_image')->get();
        
    //     return $logo;
   
 
    // }


    
    
}
