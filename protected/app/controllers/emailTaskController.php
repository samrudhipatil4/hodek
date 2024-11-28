<?php
use Carbon\Carbon;
class emailTaskController extends BaseController
{

    public function taskMail()
    {
        
        $mailCond="OverdueAndAll";
        if($mailCond == "Overdue"){
            $this->overDueMail();
        }elseif($mailCond == "All"){
            $this->allMail();
        }elseif($mailCond == "OverdueAndAll"){
            $this->APQPPendingMail();
            $this->overDueMail();
            $this->allMail();
        }else{

        }


    }
     //start of -->this function will send mail of all APQP pending task
    public function APQPPendingMail(){
        $users = DB::table('apqp_all_task')
            ->select('apqp_all_task.assigned_to')
            ->where('apqp_all_task.close', 0)
             ->where('status',1)
            ->groupBy('apqp_all_task.assigned_to')
            ->get();

        foreach ($users as $row) {

            $email_1 = DB::table('tb_users')
                ->select('tb_users.email','tb_users.first_name','tb_users.last_name')
                ->where('tb_users.id', $row->assigned_to)
                ->get();
                
           $email_id = $email_1[0]->email;
             $name = $email_1[0]->first_name.' '.$email_1[0]->last_name;

            $task = DB::table('apqp_all_task')
                ->leftjoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_all_task.activity')
                ->leftjoin('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_all_task.gate')
                ->leftjoin('apqp_new_project_info','apqp_new_project_info.id','=','apqp_all_task.project_id')
                ->select('apqp_all_task.activity_start_date','apqp_all_task.activity_end_date','apqp_all_task.status','apqp_all_task.activity', 'apqp_gate_management_master.Gate_Description','apqp_gate_activity_master.activity as act','apqp_new_project_info.project_no','apqp_new_project_info.project_name','apqp_new_project_info.project_revision')
                ->where('apqp_all_task.close', 0)
                ->where('apqp_all_task.assigned_to', $row->assigned_to)
                ->where('status',1)
                ->get();
        
                $data_1=array();
                if(!empty($task)){
            foreach($task as $t){
                if($t->status == 2){
                    $activity = $t->activity;
                }else{
                     $activity = $t->act;
                }
                $data_1[] = array('gate_id'=>$t->Gate_Description,'activity'=>$activity,'startdate'=>date('d-m-Y', strtotime($t->activity_start_date)),'end_date'=>date('d-m-Y', strtotime($t->activity_end_date)),'proj_id' =>$t->project_no,'revision'=>$t->project_revision, 'proj_name'=>$t->project_name
                    );
                             
             }  
             }            


            $data_2 = array('name'=>$name,'data1'=>$data_1);
           
                 
                Mail::send('apqpEmails/pendingtask', $data_2, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('APQP: You have a pending task
                ');

                });
            
             $data_1 =[];
  
        }

        


    }
    //end of -->this function will send mail of all APQP pending task



    //start of -->this function will send mail of all pending task
    public function allMail(){
        $users = DB::table('request_progress_status')
            ->select('request_progress_status.assigned_to',DB::raw('COUNT(request_progress_status.request_id) as total_request'))
            ->where('request_progress_status.close', 0)
            ->groupBy('request_progress_status.assigned_to')
            ->get();
        foreach ($users as $row) {

            $email_1 = DB::table('tb_users')
                ->select('tb_users.email')
                ->where('tb_users.id', $row->assigned_to)
                ->get();

           $email_id = $email_1[0]->email;
			

            $actualMail = DB::table('request_progress_status')
                ->select('request_progress_status.assigned_to', 'request_progress_status.request_id', 'request_progress_status.message','request_progress_status.assigned_by')
                ->where('request_progress_status.close', 0)
                ->where('request_progress_status.assigned_to', $row->assigned_to)
                ->get();
            $demo = "";
            $cmNo="";

            foreach ($actualMail as $mail) {

                   $query =DB::table('changerequests')
                    ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                    ->where('changerequests.request_id','=',$mail->request_id)
                    ->get();

                $query1=DB::table('tbl_change_type')
                    ->select('tbl_change_type.change_type_name')
                    ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                    ->get();

                $query2=DB::table('tb_users')
                    ->select('tb_users.first_name','tb_users.last_name')
                    ->where('tb_users.id',$mail->assigned_by)
                    ->get();

                $query3=DB::table('tb_users')
                    ->select('tb_users.first_name','tb_users.last_name')
                    ->where('tb_users.id',$mail->assigned_to)
                    ->get();

                $toname=$query3[0]->first_name.' '.$query3[0]->last_name;
                $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                $demo = $demo . ' ' . $cmNo . ' --> ' . $mail->message .'     Assign By --> '.$query2[0]->first_name.' '.$query2[0]->last_name."@";

                $cmNo="";
            }

            $data_1 = array('user' => $demo,'to'=>$toname);

            //if ($this->check_netconnection()) {

                Mail::send('emails/email-task', $data_1, function ($message) use ($email_id) {

                    $message->to($email_id)->subject('Change Management: You have a pending task
');

                });
            // } else {


            // }
        }


    }
    //end of -->this function will send mail of all pending task

    //start of -->this function will send mail of overdue pending task
//     public function overDueMail(){

//         $users = DB::table('attachment_activity_monitoring_summerysheet')->distinct()->select('user_id')->get();

//         $current_date=date('Y-m-d');

//         foreach ($users as $row){

//             $assign_new = DB::table('attachment_activity_monitoring_summerysheet')
//                 ->select('attachment_activity_monitoring_summerysheet.task_status','attachment_activity_monitoring_summerysheet.admin_status','attachment_activity_monitoring_summerysheet.created_date', 'attachment_activity_monitoring_summerysheet.user_id','attachment_activity_monitoring_summerysheet.dep_id','attachment_activity_monitoring_summerysheet.request_id')
//                 ->where('attachment_activity_monitoring_summerysheet.user_id',$row->user_id)
//                 ->get();

//             $demo="";
//             foreach($assign_new as $row1) {
               
//                 $target_date1 = $this->get_target_date($row1->user_id, $row1->request_id);

//                 $current_dt = $current_date;
//                 $date1 = strtotime($current_dt);

//                 if ($target_date1 !== 0) {

//                     $date2 = strtotime((String)$target_date1->t_date);

//                 } else {

//                     $current_date = date('Y-m-d');
//                     $date2 = strtotime($current_dt);

//                 }



//                 //print_r($assign_new[0]->request_id);exit;
//                 if ($date1 > $date2 && $row1->admin_status != 2 && $row1->task_status <= 1) {

//                     $query =DB::table('changerequests')
//                         ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
//                         ->where('changerequests.request_id','=',$row1->request_id)
//                         ->get();

//                     $users = DB::table('changerequests')->distinct()->select('request_id')->get();


//                     $query1=DB::table('tbl_change_type')
//                         ->select('tbl_change_type.change_type_name')
//                         ->where('tbl_change_type.change_type_id',$query[0]->changeType)
//                         ->get();



//                     $userEmail = DB::table('tb_users')
//                         ->select('tb_users.first_name', 'tb_users.last_name', 'tb_users.email')
//                         ->where('tb_users.id', $row1->user_id)
//                         ->get();
//                     $to=$userEmail[0]->first_name.' '.$userEmail[0]->last_name;
//                    $email_id=$userEmail[0]->email;
// 			        // $email_id="manoj.gurav@in.mahle.com";

//                     $cmNo="";
//                     $message="Pending from Responsible person to monitor activity completion status.";

//                     $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

//                     $demo = $demo . ' ' . $cmNo . ' --> ' . $message .'     Assign By --> Change Management admin'."@";

//                     $cmNo="";
//                 }


//             }
//             if($demo !=""){
//                 $data_1 = array('user' => $demo,'to'=>$to);

//                 if ($this->check_netconnection()) {

//                     Mail::send('emails/email-task', $data_1, function ($message) use ($email_id) {

//                         $message->to($email_id)->subject('Change Management: You have an overdue task
// ');

//                     });
//                 } else {


//                 }
//             }

//         }

//     }

     public function overDueMail(){

        $users = DB::table('attachment_activity_monitoring_summerysheet')->distinct()->select('user_id')->get();

        $current_date=date('Y-m-d');

        foreach ($users as $row){

            $assign_new = DB::table('request_progress_status')
                ->join('tb_users','tb_users.id','=','request_progress_status.assigned_to')
                ->select('request_progress_status.request_id','request_progress_status.assigned_to','tb_users.department')
                ->where('request_progress_status.assigned_to','=',$row->user_id)
                ->where('status',14)
                ->where('close',0)
                ->get();
                 

            $demo="";
            foreach($assign_new as $row1) {
                //print_r($row1->user_id);
                $target_date1 = $this->get_target_date1($row1->department, $row1->request_id);

                $current_dt = $current_date;// Carbon::createFromFormat('Y-m-d H:i:s', $user->created_date)->format('Y-m-d');

                $date1 = strtotime($current_dt);

                if ($target_date1 !== 0) {

                    $date2 = strtotime((String)$target_date1->t_date);

                } else {

                    $current_date = date('Y-m-d');
                    $date2 = strtotime($current_dt);

                }
              if ($date1 > $date2 ) {

                    $query =DB::table('changerequests')
                        ->select('changerequests.changeType','changerequests.created_date','changerequests.request_id')
                        ->where('changerequests.request_id','=',$row1->request_id)
                        ->get();

                    $users = DB::table('changerequests')->distinct()->select('request_id')->get();


                    $query1=DB::table('tbl_change_type')
                        ->select('tbl_change_type.change_type_name')
                        ->where('tbl_change_type.change_type_id',$query[0]->changeType)
                        ->get();

                    $userEmail = DB::table('tb_users')
                        ->select('tb_users.first_name', 'tb_users.last_name', 'tb_users.email')
                        ->where('tb_users.id', $row1->assigned_to)
                        ->get();
                    $to=$userEmail[0]->first_name.' '.$userEmail[0]->last_name;
                   $email_id=$userEmail[0]->email;
                 

                    $cmNo="";
                    $message="Pending from Responsible person to monitor activity completion status.";

                    $cmNo=$this->generate_cm_no_search($query1[0]->change_type_name,$query[0]->created_date,$query[0]->request_id);

                    $demo = $demo . ' ' . $cmNo . ' --> ' . $message .'     Assign By --> Change Management admin'."@";

                    $cmNo="";

                }
            }
            if($demo !=""){
                $data_1 = array('user' => $demo,'to'=>$to);

                if ($this->check_netconnection()) {

                    Mail::send('emails/email-task', $data_1, function ($message) use ($email_id) {

                $message->to($email_id)->subject('Change Management: You have an overdue task');

                    });
                } else {

                }
            }
        }

    }



    //end of -->this function will send mail of overdue pending task
}


