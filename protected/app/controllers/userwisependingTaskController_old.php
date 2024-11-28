<?php
use Carbon\Carbon;

class userwisependingTaskController extends BaseController
{

    public function index()
    {

        $user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('userwisependingTask/pendingTask_search');
        }
            else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
         
        
    }       

    public function department()
    {
        
        //Returns All departments
        $departments = DB::table('tb_departments')->select('d_id','d_name')->get();
        
        return $departments;
   
 
    }

    public function get_riskquestion($d_id)
    {
        if($d_id==0){
        //Returns All departments
        $question = DB::table('tb_risk_assessment_points_admin')->select('risk_assessment_id_admin','assessment_point_department')
                  ->where('tb_risk_assessment_points_admin.status','active')
                  ->distinct('risk_assessment_id_admin')->get();
        
        return $question;
      }else{
         $question = DB::table('tb_risk_assessment_points_admin')->select('risk_assessment_id_admin','assessment_point_department')
                   ->where('tb_risk_assessment_points_admin.risk_sub_department',$d_id)
                   ->where('tb_risk_assessment_points_admin.status','active')
                   ->get();
        
        return $question;
      }
 
    }

    public function get_users($d_id)
    {
       if($d_id==0){
        $data = DB::table('tb_users')
                ->select('tb_users.id',db::raw('CONCAT(tb_users.first_name," ",tb_users.last_name) as username'))
                ->distinct('tb_users.id')
                ->get();
               
               return $data;
        }else{
          $data = DB::table('tb_users')
                ->select('tb_users.id',db::raw('CONCAT(tb_users.first_name," ",tb_users.last_name) as username'))
                ->where('tb_users.department',$d_id)
                ->get();
               
               return $data;
        }       
   
 
    }

    public function userPendingTask_search_result(){
        $data=array();
            $input = (object)Input::all();
            // print_r($input);exit();
         
            if(!strcmp((String)$input->startdate,(String)$input->enddate)){
                $std=explode('/',$input->startdate);


                $created_date=$std[2].'-'.$std[0].'-'.$std[1].' 00:00:00';
                $etd=explode('/',$input->enddate);
                $end_date=$etd[2].'-'.$etd[0].'-'.$etd[1].' 23:59:00';

            }else {
                $std = explode('/', $input->startdate);
               // print_r($std);exit;
                $created_date = $std[2] . '-' . $std[0] . '-' . $std[1] . ' 00:00:00';
                $etd = explode('/', $input->enddate);
                $end_date = $etd[2] . '-' . $etd[0] . '-' . $etd[1] . ' 23:59:00';
            }

             $query =DB::table('changerequests')
                     ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                    ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
                    ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                    ->leftJoin('request_progress_status','request_progress_status.request_id','=','changerequests.request_id')
                    ->leftJoin('tb_users as assDept','request_progress_status.assigned_to','=','assDept.id')
                    ->leftJoin('tb_risk_assessment_points','tb_risk_assessment_points.request_id','=','changerequests.request_id')
                     ->select('changerequests.request_id','changerequests.dt', 'tb_users.first_name','changerequests.created_date','tb_users.last_name','tbl_change_type.change_type_name')
                     ->orderBy('changerequests.dt','asc')
                     ->where('changerequests.status','<>',5)
                     ->where('changerequests.dt', '>=', $created_date)
                     ->where('changerequests.dt', '<=', $end_date)
                     ->where('request_progress_status.close',0);
                     // ->get();
                     if($input->department!= '? undefined:undefined ?'){
                        $query->where('assDept.department', $input->department);
                        $dept_id=$input->department;
                    }else{
                        $dept_id='';
                        }
                     if(isset($input->user)&& !empty($input->user)){
                        $query->whereIn('request_progress_status.assigned_to',[implode(',', $input->user)]);
                         $user_id=implode(',',$input->user);
                    }else{
                        $user_id='';
                        }
                     if(isset($input->question)&& !empty($input->question)){
                        $query->whereIn('tb_risk_assessment_points.risk_assessment_id_admin',[implode(',', $input->question)]);
                        $quest=implode(',',$input->question);
                    }else{
                        $quest='';
                    }
             //        $users=$query->get();
             //   echo '<pre>';
             // print_r($users);exit();       
           $users=  $query->distinct('changerequests.request_id')
                          ->get();
          
             foreach ($users as $user){

                $data[] = array(
                    'request_id' => $user->request_id,
                    'initiation_dt'=>Carbon::createFromFormat('Y-m-d', $user->dt)->format('d.m.Y'),
                    'initiator'=>$user->first_name.' '.$user->last_name,
                    'assigned_to'=>$this->get_assignedto($user->request_id,$quest),
                    'cmNoview'=> $this->generate_cm_no_search($user->change_type_name,$user->created_date,$user->request_id),
                    // 'PendingDays'=>$this->get_pendingDays($assigned_to[0]->status),
                    );
             }
            
            $formInput=array(
                'startdate'=>$created_date,
                'enddate'=>$end_date,
                'dept_id'=>$dept_id,
                'user_id'=>$user_id,
                'quest'=>$quest,
                // 'purpose'=>$purpose,
                // 'customer_id'=>$customer_id,
                // 'projectcode'=>$projectcode,
            );    
            //  echo '<pre>';
            // print_r($data);exit();
            if ($this->check_permission(1)) {
            return View::make('UserwisependingTask/taskSheet',compact('data','formInput'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

    public function get_assignedto($r_id,$risk_id){
        // print_r($r_id);exit();
        
        $now = Carbon::now(); 
       
        // print_r($status2dt);exit();
        $activity=DB::table('request_progress_status')
                 ->Join('tb_users', 'request_progress_status.assigned_to', '=', 'tb_users.id')
                 ->select('request_progress_status.message',db::raw('CONCAT(tb_users.first_name," ",tb_users.last_name) as user'),'request_progress_status.status','tb_users.department')
                 ->where('request_progress_status.request_id',$r_id)
                 ->where('request_progress_status.close',0)
                 ->get();
        // print_r($activity);exit();
        $data=array();
        foreach ($activity as $value) {
            
        if($value->status==1){
            $query =DB::table('changerequests')
               ->select('created_date','projected_close_date')
               ->where('request_id',$r_id)
               ->get();
             $status1dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status1dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==3){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',3)
               ->where('close',0)
               ->take(1)
               ->get();
             $status1dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status1dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==2){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',2)
               ->where('close',0)
               ->take(1)
               ->get();
             $status2dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status2dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==6 ||$value->status==9||$value->status==11||$value->status==99){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->whereIn('status',[6,9,11,99])
               ->where('close',0)
               ->take(1)
               ->get();
             $status6dt=Carbon::parse($query[0]->created_date);
              // print_r($query[0]->created_date);exit();
            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status6dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==7){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',7)
               ->where('close',0)
               ->take(1)
               ->get();
             $status7dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status7dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==8){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',8)
               ->where('close',0)
               ->take(1)
               ->get();
             $status8dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status8dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==88){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',88)
               ->where('close',0)
               ->take(1)
               ->get();
             $status88dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status88dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==10){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',10)
               ->where('close',0)
               ->take(1)
               ->get();
             $status10dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status10dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==12){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',12)
               ->where('close',0)
               ->take(1)
               ->get();
             $status12dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status12dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==13){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',13)
               ->where('close',0)
               ->take(1)
               ->get();
             $status13dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status13dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==14){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',14)
               ->where('close',0)
               ->take(1)
               ->get();
             $status14dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status14dt->diffInDays($now),
                'actmonitoring'=>$this->getRiskSheet($r_id,$value->department,$risk_id),
                );
        }
        if($value->status==16){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',16)
               ->where('close',0)
               ->take(1)
               ->get();
             $status16dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status16dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==17){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',17)
               ->where('close',0)
               ->take(1)
               ->get();
             $status17dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status17dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==18){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',18)
               ->where('close',0)
               ->take(1)
               ->get();
             $status18dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status18dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==19){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',19)
               ->where('close',0)
               ->take(1)
               ->get();
             $status19dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status19dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
        if($value->status==22){
            $query =DB::table('request_progress_status')
               ->select('created_date')
               ->where('request_id',$r_id)
               ->where('status',22)
               ->where('close',0)
               ->take(1)
               ->get();
             $status19dt=Carbon::parse($query[0]->created_date);

            $data[]=array(
                'activity'=>$value->message,
                'assignedto'=>$value->user,
                'status'=>$value->status,
                'pendingdays'=>$status19dt->diffInDays($now),
                'actmonitoring'=>'',
                );
        }
     }
        // print_r($data);exit();
        return $data;
    }

    public function getRiskSheet($r_id,$d_id,$risk_id){
      if(isset($risk_id)&& !empty($risk_id)){
                    
        $data=DB::table('tb_risk_assessment_points')
             ->join('tb_risk_assessment_points_admin','tb_risk_assessment_points.risk_assessment_id_admin','=','tb_risk_assessment_points_admin.risk_assessment_id_admin')
             ->select('tb_risk_assessment_points_admin.assessment_point_department','tb_risk_assessment_points.target_date')
             ->where('tb_risk_assessment_points.request_id',$r_id)
             ->where('tb_risk_assessment_points.risk_dep',$d_id)
             ->whereIn('tb_risk_assessment_points.risk_assessment_id_admin',[implode(',', (array)$risk_id)])
             // ->where('tb_risk_assessment_points_admin.status','active')
             ->get();

        return $data;
      }else{
        $data=DB::table('tb_risk_assessment_points')
             ->join('tb_risk_assessment_points_admin','tb_risk_assessment_points.risk_assessment_id_admin','=','tb_risk_assessment_points_admin.risk_assessment_id_admin')
             ->select('tb_risk_assessment_points_admin.assessment_point_department','tb_risk_assessment_points.target_date')
             ->where('tb_risk_assessment_points.request_id',$r_id)
             ->where('tb_risk_assessment_points.risk_dep',$d_id)
             // ->where('tb_risk_assessment_points_admin.status','active')
             ->get();

        return $data;
      }
    }

    public function advance_search_result_download(){
         $data=array();
        $input = (object)Input::all();
        // print_r($input);exit();
             $query =DB::table('changerequests')
                     ->leftJoin('tb_departments', 'changerequests.dep_id', '=', 'tb_departments.d_id')
                    ->leftJoin('tb_users', 'changerequests.initiator_id', '=', 'tb_users.id')
                    ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                    ->leftJoin('request_progress_status','request_progress_status.request_id','=','changerequests.request_id')
                    ->leftJoin('tb_risk_assessment_points','tb_risk_assessment_points.request_id','=','changerequests.request_id')
                    ->leftJoin('tb_risk_assessment_points_admin','tb_risk_assessment_points.risk_assessment_id_admin','=','tb_risk_assessment_points_admin.risk_assessment_id_admin')
                     ->select('changerequests.request_id','changerequests.dt', 'tb_users.first_name','changerequests.created_date','tb_users.last_name','tbl_change_type.change_type_name')
                     ->orderBy('changerequests.dt','asc')
                     ->where('changerequests.status','<>',5)
                     ->where('changerequests.dt', '>=', $input->startdate)
                     ->where('changerequests.dt', '<=', $input->enddate)
                     ->where('request_progress_status.close',0);
                     // ->get();
                     if(isset($input->dept_id)&& !empty($input->dept_id)){
                        $query->where('changerequests.dep_id', $input->dept_id);
                        $dept_id=$input->dept_id;
                    }else{
                        $dept_id='';
                        }
                     if(isset($input->user_id)&& !empty($input->user_id)){
                        $query->whereIn('changerequests.initiator_id',[implode(',', (array)$input->user_id)]);
                         $user_id=implode(',',(array)$input->user_id);
                    }else{
                        $user_id='';
                        }
                      if(isset($input->quest)&& !empty($input->quest)){
                        $query->whereIn('tb_risk_assessment_points_admin.risk_assessment_id_admin',[implode(',', (array)$input->quest)]);
                        $quest=implode(',', (array)$input->quest);
                    }else{
                        $quest='';
                    }
             //        $users=$query->get();
             //   echo '<pre>';
             // print_r($users);exit();       
           $users=  $query->distinct('changerequests.request_id')
                          ->get();
          
             foreach ($users as $user){

                $data[] = array(
                    'request_id' => $user->request_id,
                    'initiation_dt'=>$user->dt,
                    'initiator'=>$user->first_name.' '.$user->last_name,
                    'assigned_to'=>$this->get_assignedto($user->request_id,$quest),
                    'cmNoview'=> $this->generate_cm_no_search($user->change_type_name,$user->created_date,$user->request_id),
                    // 'PendingDays'=>$this->get_pendingDays($assigned_to[0]->status),
                    );
             }

             $stadt= Carbon::createFromFormat('Y-m-d H:i:s', $input->startdate)->format('d.m.Y');
             $enddt= Carbon::createFromFormat('Y-m-d H:i:s', $input->enddate)->format('d.m.Y');
      //  $filename=$input->startdate.'-'.$input->enddate;
             $filename='UserwisependingTask-'.$stadt.'-'.$enddt;

             if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('UserwisependingTask/taskSheetPDF', compact('data'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('UserwisependingTask/taskSheetExcel',compact('data'));

               // print_r($output);exit;
                $headers = array(
                    'Pragma' => 'public',
                    'Expires' => 'public',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Cache-Control' => 'private',
                    'Content-Type' => 'application/vnd.ms-excel',
                    'Content-Disposition' => 'attachment; filename='.$filename.'.xls',
                    'Content-Transfer-Encoding' => ' binary'
                );
                return Response::make($output, 200, $headers);

            }
    }
   
}
