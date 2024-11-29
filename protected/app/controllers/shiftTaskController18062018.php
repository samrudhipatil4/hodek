<?php
use Carbon\Carbon;

class shiftTaskController extends ChangerequestController
{


    
    public function shiftTask(){
        if ($this->check_permission(1)) {
            return View::make('modifychangerequest/shifttask');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

   

    public function getUserName(){
        $input=Input::all();
       $data=DB::table('changerequests')
             ->select('changerequests.*')
             ->where('request_id',$input['r_id'])
             ->get();
             if($input['m_code']==1){

               $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',1)
              ->get();

              if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }

             }elseif($input['m_code']==2){

               $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',2)
              ->get();

              if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }

             }elseif($input['m_code']==5){

               $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',8)
              ->get();

              if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }

             }elseif($input['m_code']==7){

                $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',12)
              ->get();

                if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }
             }elseif($input['m_code']==8){

                $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',13)
              ->get();

                if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }
             }elseif($input['m_code']==10){
                $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',16)
              ->get();

                 if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }

             }elseif($input['m_code']==11){
                  $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',22)
              ->get();

                if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }

             }elseif($input['m_code']==12){

                $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',17)
              ->get();

                 if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }
             }elseif($input['m_code']==13){

                $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',18)
              ->get();

                 if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }
             }elseif($input['m_code']==14){

                $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',19)
              ->get();

                 if(!empty($data)){
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$data[0]->assigned_to)
                    ->get();
                    return $user;
                }
             }

    }

    public function getUserNameDept(){
       $input=Input::all();
    
       $data=DB::table('changerequests')
             ->select('changerequests.*')
             ->where('request_id',$input['r_id'])
             ->get();
             if($input['m_code']==3){

              $user =DB::table('add_updated_risk_assessment_sheet')
                    ->join('tb_users','tb_users.id','=','add_updated_risk_assessment_sheet.user_id')
                    ->select('first_name','last_name','tb_users.id')
                    //->where('id',$key->assigned_to)
                    ->where('r_id',$input['r_id'])
                    ->where('user_department',$input['d_id'])
                    ->get();
                    return $user;

              //  $data=DB::table('request_progress_status')
              //  ->select('assigned_to')
              // ->where('request_id',$input['r_id'])
              // ->where('status',6)
              // ->get();
              
             
              //  if(!empty($data)){
              // foreach ( $data as $key) {
               
             
              //   $user =DB::table('tb_users')
              //       ->select('first_name','last_name','id')
              //       ->where('id',$key->assigned_to)
              //       ->where('department',$input['d_id'])
              //       ->get();
                    
              //       if(!empty($user)){
              //         return $user;
              //          break;
              //       }
              //   }
              // }
              

             }elseif($input['m_code']==4){

              //  $data=DB::table('request_progress_status')
              //  ->select('assigned_to')
              // ->where('request_id',$input['r_id'])
              // ->where('status',7)
              // ->get();
              
             
              //  if(!empty($data)){
              // foreach ( $data as $key) {
               
             
                $user =DB::table('add_updated_risk_assessment_sheet')
                    ->join('tb_users','tb_users.id','=','add_updated_risk_assessment_sheet.hod')
                    ->select('first_name','last_name','tb_users.id')
                    //->where('id',$key->assigned_to)
                    ->where('r_id',$input['r_id'])
                    ->where('user_department',$input['d_id'])
                    ->get();
                    return $user;
                    
                //     if(!empty($user)){
                //        return $user;
                //        break;
                //     }
                // }
              //}
             
              }elseif($input['m_code']==6){

               $data=DB::table('request_progress_status')
               ->select('assigned_to')
              ->where('request_id',$input['r_id'])
              ->where('status',11)
              ->get();
              
             
               if(!empty($data)){
              foreach ( $data as $key) {
               
             
                $user =DB::table('tb_users')
                    ->select('first_name','last_name','id')
                    ->where('id',$key->assigned_to)
                    ->where('department',$input['d_id'])
                    ->get();
                    
                    if(!empty($user)){
                      return $user;
                       break;
                    }
                }
              }
              
              }elseif($input['m_code']==9){

              //  $data=DB::table('request_progress_status')
              //  ->select('assigned_to')
              // ->where('request_id',$input['r_id'])
              // ->where('status',14)
              // ->get();
             
              //  if(!empty($data)){
              // foreach ( $data as $key) {
               
             
              //   $user =DB::table('tb_users')
              //       ->select('first_name','last_name','id')
              //       ->where('id',$key->assigned_to)
              //       ->where('department',$input['d_id'])
              //       ->get();
                    
              //       if(!empty($user)){
              //         return $user;
              //          break;
              //       }
              //   }
              // }
                  $user =DB::table('add_updated_risk_assessment_sheet')
                    ->join('tb_users','tb_users.id','=','add_updated_risk_assessment_sheet.user_id')
                    ->select('first_name','last_name','tb_users.id')
                    //->where('id',$key->assigned_to)
                    ->where('r_id',$input['r_id'])
                    ->where('user_department',$input['d_id'])
                    ->get();
                    return $user;
              
              }

             

    }
    public function getAllUser1($did){

        $user =DB::table('tb_users')
                    ->select('first_name','last_name','id','username')
                    ->where('active',1);
                    if($did != 'undefined'){
                     $user->where('department',$did);
                    }
                    $user->get();
                    return $user->get();
    }

    public function getAllUser(){
        $user =DB::table('tb_users')
                    ->select('first_name','last_name','id','username')
                    ->where('active',1)
                    ->get();
                    return $user;
    }

    public function shiftUser(){
        $input=Input::all();
       
       if($input['m_code']==1){
           $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',1)
              ->get();
              if(!empty($data)){
                DB::table('changerequests')
                  ->where('request_id',$input['r_id'])
                  ->update(
                      array('Approval_Authority' => $input['user'],
                    )
                  );
                  
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',1)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
       }elseif($input['m_code']==2){
             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',2)
              ->get();
              if(!empty($data)){
                 
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',2)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==3){
              $user=DB::table('tb_users')
                  ->select('department')
                  ->where('id',$input['user'])
                  ->get();

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',6)
              ->get();
              if(!empty($data)){
                 DB::table('tb_updatesheet_dep_team')
                  ->where('request_id',$input['r_id'])
                  ->where('department',$input['d_id'])
                  ->update(
                      array('team_member' => $input['user'],
                    )
                  );

                  DB::table('add_updated_risk_assessment_sheet')
                  ->where('r_id',$input['r_id'])
                  ->where('user_department',$input['d_id'])
                  ->update(
                      array('user_id' => $input['user'],
                    )
                  );

                   DB::table('approval_risk_assessment')
                  ->where('request_id',$input['r_id'])
                  ->where('user_id',$input['existUser'])
                  ->update(
                      array('user_id' => $input['user'],
                    )
                  );

                  DB::table('attachment_activity_monitoring_summerysheet')
                  ->where('request_id',$input['r_id'])
                  ->where('dep_id',$input['d_id'])
                  ->update(
                      array('user_id' => $input['user'],
                        'dep_id'      =>  $user[0]->department
                    )
                  );

                    DB::table('tb_risk_assessment_points')
                  ->where('request_id',$input['r_id'])
                  ->where('risk_dep',$input['d_id'])
                  ->update(
                      array('responsibility' => $input['user'],
                        'risk_dep'      =>  $user[0]->department
                    )
                  );


                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',6)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                   DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',9)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                   DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',11)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',99)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==4){

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',7)
              ->get();
              $user =DB::table('tb_users')
                    ->select('department','sub_department','id')
                    ->where('id',$input['user'])
                    ->get();

              if(!empty($data)){
                  DB::table('add_updated_risk_assessment_sheet')
                  ->where('r_id',$input['r_id'])
                  ->where('user_department',$input['d_id'])
                  ->update(
                      array('hod' => $input['user'],
                    )
                  );

                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                    ->where('assigned_to',$input['existUser'])
                  ->where('status',7)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                  
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==5){
             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',8)
              ->get();
              if(!empty($data)){
                  DB::table('request_progress_status_temp')
                  ->where('request_id',$input['r_id'])
                  ->where('status',8)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',8)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==6){
             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',88)
              ->get();
              if(!empty($data)){
                 
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',88)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==7){

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',12)
              ->get();
              $user =DB::table('tb_users')
                    ->select('department','sub_department','id')
                    ->where('id',$input['user'])
                    ->get();

              if(!empty($data)){
                  
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',12)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                  DB::table('Customer_Communication_Decision')
                  ->where('request_id',$input['r_id'])
                  ->update(
                      array('dep_id' => $user[0]->department,
                        'sub_dep_id' => $user[0]->sub_department,
                         'user_id' => $user[0]->id,

                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==8){

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',13)
              ->get();
              $user =DB::table('tb_users')
                    ->select('department','sub_department','id')
                    ->where('id',$input['user'])
                    ->get();

              if(!empty($data)){
                  
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',13)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==9){
         $user=DB::table('tb_users')
                  ->select('department')
                  ->where('id',$input['user'])
                  ->get();

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',14)
              ->get();
              $user =DB::table('tb_users')
                    ->select('department','sub_department','id')
                    ->where('id',$input['user'])
                    ->get();

              if(!empty($data)){
                  
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',14)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );

                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',6)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );

                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',9)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );

                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('assigned_to',$input['existUser'])
                  ->where('status',99)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );

                DB::table('tb_updatesheet_dep_team')
                  ->where('request_id',$input['r_id'])
                  ->where('department',$input['d_id'])
                  ->update(
                      array('team_member' => $input['user'],
                    )
                  );

                   DB::table('approval_risk_assessment')
                  ->where('request_id',$input['r_id'])
                  ->where('user_id',$input['existUser'])
                  ->update(
                      array('user_id' => $input['user'],
                    )
                  );

                  DB::table('add_updated_risk_assessment_sheet')
                  ->where('r_id',$input['r_id'])
                  ->where('user_department',$input['d_id'])
                  ->update(
                      array('user_id' => $input['user'],
                    )
                  );

                  DB::table('attachment_activity_monitoring_summerysheet')
                  ->where('request_id',$input['r_id'])
                  ->where('dep_id',$input['d_id'])
                  ->update(
                      array('user_id' => $input['user'],
                        'dep_id'      =>  $user[0]->department
                    )
                  );

                  DB::table('attachment_activity_monitoring')
                  ->where('request_id',$input['r_id'])
                  ->where('dep_id',$input['d_id'])
                  ->update(
                      array('user_id' => $input['user']
                       
                    )
                  );

                    DB::table('tb_risk_assessment_points')
                  ->where('request_id',$input['r_id'])
                  ->where('risk_dep',$input['d_id'])
                  ->update(
                      array('responsibility' => $input['user'],
                        'risk_dep'      =>  $user[0]->department
                    )
                  );
                 
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==10){

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',16)
              ->get();
             

              if(!empty($data)){
                  DB::table('request_progress_status_temp')
                  ->where('request_id',$input['r_id'])
                  ->where('status',16)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',16)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==11){

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',22)
              ->get();
             

              if(!empty($data)){
                  
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',22)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==12){

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',17)
              ->get();
             

              if(!empty($data)){
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',17)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==13){

             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',18)
              ->get();
              if(!empty($data)){
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',18)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }elseif($input['m_code']==14){
             $data=DB::table('request_progress_status')
              ->where('request_id',$input['r_id'])
              ->where('status',19)
              ->where('close',0)
              ->get();
              if(!empty($data)){
                  DB::table('request_progress_status')
                  ->where('request_id',$input['r_id'])
                  ->where('status',19)
                  ->update(
                      array('assigned_to' => $input['user'],
                    )
                  );
                 return 0;
              }else{
                return 1;exit();
              }
        }
    }


}
