<?php
use Carbon\Carbon;

class CRCloseController extends BaseController
{


   public function Close_CR()
    {  
      $user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('modifychangerequest/CloseCR');
        }
      else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
     
    }

    public function permanentCloseCR($id){
      $input=Input::all();
     
     $comment=$input['reject_reason'];
      DB::table('permanent_reject_close')->insert(
                array(
                    'request_id' => $id,
                    'rejected_by_id' => Session::get('uid'),
                   'rejected_by_name' => Session::get('fid'),
                    'remark' => $comment,
                   'reject_date' => date('Y-m-d H:i:s'),
                    'created_date'=> date('Y-m-d')

                )
            );

       DB::table('add_updated_risk_assessment_sheet')
                  ->where('r_id',$input['r_id'])
                  ->update(
                      array('status' => 3,
                    )
                  );

                  DB::table('attachment_activity_monitoring_summerysheet')
                  ->where('request_id',$input['r_id'])
                  ->update(
                      array('task_status' => 2,
                       
                    )
                  );


       
        $message = "Change Request  is  Rejected and Closed by ".Session::get('fid').".";
        $data=DB::table('request_progress_status')
        ->select('id')
        ->where('request_id', $id)
        ->where('close',0)
        ->get();
        if($data[0]->id==1)
        {
        DB::table('request_progress_status')
        ->where('request_id', $id)
        ->where('close',0)
            ->update(
                  array(
                    'close' => 2,
                    'message'=>$message,
                    'IP_Address'=>$_SERVER['REMOTE_ADDR'],
                    'User_id' =>session::get('uid')
                )
            );
          }else{
            $last= DB::table('request_progress_status')
            ->select('id') 
            ->where('request_id', $id)
            ->where('close',0)
            ->orderBy('id','desc') 
            ->first();
           
            if(!empty($last)){
              DB::table('request_progress_status')
              ->where('request_id', $id)
              ->where('close',0)
              ->where('id',$last->id)
              ->update(
                    array(
                      'close' => 2,
                      'message'=>$message,
                      'IP_Address'=>$_SERVER['REMOTE_ADDR'],
                      'User_id' =>session::get('uid')
                  )
              );
            }
            DB::table('request_progress_status')
        ->where('request_id', $id)
        ->where('close',0)
            ->update(
                  array(
                    'close' => 1,
                    'IP_Address'=>$_SERVER['REMOTE_ADDR'],
                    'User_id' =>session::get('uid')
                    
                )
            );
          }

          
              $users = DB::table('request_progress_status')
            ->select('request_progress_status.assigned_to')
            ->where('request_progress_status.request_id', $id)
            ->where('request_progress_status.assigned_to' ,'!=',1 )
            ->groupBy('request_progress_status.assigned_to');
           
            $users1 = DB::table('request_progress_status')
            ->select('request_progress_status.assigned_by')
            ->where('request_progress_status.request_id', $id)
            ->where('request_progress_status.assigned_by' ,'!=',1 )
            ->groupBy('request_progress_status.assigned_by')
            ->union($users)
                ->get();
 
                
           foreach ($users1 as $mail) {

                   $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();

                $query2=DB::table('tb_users')
                    ->select('tb_users.first_name','tb_users.last_name','tb_users.email')
                    ->where('tb_users.id',$mail->assigned_by)
                    ->get();

                   $email= $query2[0]->email;

                     $admin = $this->get_user_info_by_id(1);
            $admincontactName = $admin['name'];

               $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$id);

               

           $message = "Change Request ".$cmNo." is  Rejected and Closed by ".$admincontactName.".";

                     $data_2 = array('firstname'=>$query2[0]->first_name,'description'=>$message,'comment'=>$comment);


                    if($this->check_netconnection())
                      {

                          Mail::send('emails/permanent-reject', $data_2, function ($message) use ($email) {
                              $message->to($email)
                                  ->subject('Change request is Rejected and Closed');
                          });

                      }else{

                      }
              }

              

    }



    


}
