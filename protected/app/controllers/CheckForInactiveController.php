<?php
use Carbon\Carbon;

class CheckForInactiveController extends BaseController
{

  public function checkUserStatus(){
   return View::make('ChechForInactive/search');
  }

  public function checkForUserActive(){
    $input=Input::all();
 
    $arr = array(
                'user'  => $input['user']
             );

    if($input['user'] != ""){
      $data[]  = array(
          'username'      =>$this->getUserName($input['user']),
          'userTask'      =>$this->checkUserTask($input['user']),
          'projectManager' =>$this->checkInProject($input['user'],'project_manager'),
          'custCommrep' =>$this->checkInProject($input['user'],'cust_comm_repres'),
          'custCommApp' =>$this->checkInProject($input['user'],'cust_comm_approval'),
          'docVer' =>$this->checkInProject($input['user'],'documentVerify'),
           'finalApproval' =>$this->checkInProject($input['user'],'finalApproval'),
          'projectMasterCFT' =>$this->checkInProjectCFT($input['user']),
          'docverifyconfig'  => $this->checkAsDocVerifier($input['user'],'member','tb_documentverifyconfig'),
          'riskAppForSeries' => $this->checkAsDocVerifier($input['user'],'riskmember','tb_documentverifyconfig'),
          'CFTRepresentative' =>$this->checkAsDocVerifier($input['user'],'representative_id','tb_dynamiccftteamrepresentative'),
          'custComm'          =>$this->checkAsDocVerifier($input['user'],'CC_member','tb_dynamiccustcomm'),
          'custCommapp'       =>$this->checkAsDocVerifier($input['user'],'CC_ApprovalMember','tb_dynamiccustcomm'),
          'horizdeploy'       =>$this->checkAsDocVerifier($input['user'],'member','tb_dynamichorizdeploy'),
          'steeringcomm'       =>$this->checkAsDocVerifier($input['user'],'steeringComm_id','tb_dynamicsteeringcommitee'),
          'custCommDecision'       =>$this->checkAsDocVerifier($input['user'],'cust_comm_decision','tb_dynamicsteeringcommitee'),
          'CFTForSeries'     => $this->getCFTUserForSeries($input['user']),
        );
    }else{
      $user =DB::table('tb_users')
             ->select('id')
             ->groupBy('id')
             ->get();
             foreach ($user as $key) {
               $data[]  = array(
          'username'      =>$this->getUserName($key->id),
          'userTask'      =>$this->checkUserTask($key->id),
          'projectManager' =>$this->checkInProject($key->id,'project_manager'),
          'custCommrep' =>$this->checkInProject($key->id,'cust_comm_repres'),
          'custCommApp' =>$this->checkInProject($key->id,'cust_comm_approval'),
          'docVer' =>$this->checkInProject($key->id,'documentVerify'),
           'finalApproval' =>$this->checkInProject($key->id,'finalApproval'),
          'projectMasterCFT' =>$this->checkInProjectCFT($key->id),
          'docverifyconfig'  => $this->checkAsDocVerifier($key->id,'member','tb_documentverifyconfig'),
          'riskAppForSeries' => $this->checkAsDocVerifier($key->id,'riskmember','tb_documentverifyconfig'),
          'CFTRepresentative' =>$this->checkAsDocVerifier($key->id,'representative_id','tb_dynamiccftteamrepresentative'),
          'custComm'          =>$this->checkAsDocVerifier($key->id,'CC_member','tb_dynamiccustcomm'),
          'custCommapp'       =>$this->checkAsDocVerifier($key->id,'CC_ApprovalMember','tb_dynamiccustcomm'),
          'horizdeploy'       =>$this->checkAsDocVerifier($key->id,'member','tb_dynamichorizdeploy'),
          'steeringcomm'       =>$this->checkAsDocVerifier($key->id,'steeringComm_id','tb_dynamicsteeringcommitee'),
          'custCommDecision'       =>$this->checkAsDocVerifier($key->id,'cust_comm_decision','tb_dynamicsteeringcommitee'),
          'CFTForSeries'     => $this->getCFTUserForSeries($key->id),
        );
             }
    }
    
       if ($this->check_permission(1)) {
            return View::make('ChechForInactive/taskSheet',compact('data','arr'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    

  }
  public function checkForUserActiveDownload(){
     $input=Input::all();
   
    if($input['user'] != ""){
      $data[]  = array(
          'username'      =>$this->getUserName($input['user']),
          'userTask'      =>$this->checkUserTask($input['user']),
          'projectManager' =>$this->checkInProject($input['user'],'project_manager'),
          'custCommrep' =>$this->checkInProject($input['user'],'cust_comm_repres'),
          'custCommApp' =>$this->checkInProject($input['user'],'cust_comm_approval'),
          'docVer' =>$this->checkInProject($input['user'],'documentVerify'),
           'finalApproval' =>$this->checkInProject($input['user'],'finalApproval'),
          'projectMasterCFT' =>$this->checkInProjectCFT($input['user']),
          'docverifyconfig'  => $this->checkAsDocVerifier($input['user'],'member','tb_documentverifyconfig'),
          'riskAppForSeries' => $this->checkAsDocVerifier($input['user'],'riskmember','tb_documentverifyconfig'),
          'CFTRepresentative' =>$this->checkAsDocVerifier($input['user'],'representative_id','tb_dynamiccftteamrepresentative'),
          'custComm'          =>$this->checkAsDocVerifier($input['user'],'CC_member','tb_dynamiccustcomm'),
          'custCommapp'       =>$this->checkAsDocVerifier($input['user'],'CC_ApprovalMember','tb_dynamiccustcomm'),
          'horizdeploy'       =>$this->checkAsDocVerifier($input['user'],'member','tb_dynamichorizdeploy'),
          'steeringcomm'       =>$this->checkAsDocVerifier($input['user'],'steeringComm_id','tb_dynamicsteeringcommitee'),
          'custCommDecision'       =>$this->checkAsDocVerifier($input['user'],'cust_comm_decision','tb_dynamicsteeringcommitee'),
           'CFTForSeries'     => $this->getCFTUserForSeries($input['user']),
        );
    }else{
      $user =DB::table('tb_users')
             ->select('id')
             ->groupBy('id')
             ->get();
             foreach ($user as $key) {
               $data[]  = array(
          'username'      =>$this->getUserName($key->id),
          'userTask'      =>$this->checkUserTask($key->id),
          'projectManager' =>$this->checkInProject($key->id,'project_manager'),
          'custCommrep' =>$this->checkInProject($key->id,'cust_comm_repres'),
          'custCommApp' =>$this->checkInProject($key->id,'cust_comm_approval'),
          'docVer' =>$this->checkInProject($key->id,'documentVerify'),
           'finalApproval' =>$this->checkInProject($key->id,'finalApproval'),
          'projectMasterCFT' =>$this->checkInProjectCFT($key->id),
          'docverifyconfig'  => $this->checkAsDocVerifier($key->id,'member','tb_documentverifyconfig'),
          'riskAppForSeries' => $this->checkAsDocVerifier($key->id,'riskmember','tb_documentverifyconfig'),
          'CFTRepresentative' =>$this->checkAsDocVerifier($key->id,'representative_id','tb_dynamiccftteamrepresentative'),
          'custComm'          =>$this->checkAsDocVerifier($key->id,'CC_member','tb_dynamiccustcomm'),
          'custCommapp'       =>$this->checkAsDocVerifier($key->id,'CC_ApprovalMember','tb_dynamiccustcomm'),
          'horizdeploy'       =>$this->checkAsDocVerifier($key->id,'member','tb_dynamichorizdeploy'),
          'steeringcomm'       =>$this->checkAsDocVerifier($key->id,'steeringComm_id','tb_dynamicsteeringcommitee'),
          'custCommDecision'       =>$this->checkAsDocVerifier($key->id,'cust_comm_decision','tb_dynamicsteeringcommitee'),
          'CFTForSeries'     => $this->getCFTUserForSeries($key->id),
        );
      }
    }
        $date = date('Y-m-d');
        $filename='UserStatus-'.$date;
    if($input['filetype']=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('ChechForInactive/check', compact('data'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
        }elseif($input['filetype']=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('ChechForInactive/csv_download',compact('data'));

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

  public function getCFTUserForSeries($uid){

      $data=DB::table('tb_updatesheet_dep_team')
            ->select('request_id')
            ->where('team_member',$uid)
            ->orderBy('request_id','asc')
            ->get();
           
            $allData=[];
      if(!empty($data)){
      foreach ($data as $key) {
          $check[]=DB::table('request_progress_status')
                  ->select('status','request_id')
                  ->where('request_id',$key->request_id)
                  ->orderBy('id','desc')
                  ->first();
          } 
         
        }
        //echo '<pre>';print_r($check);

      if(!empty($check)){
        foreach ($check as $key) {
            if($key->status != 17 && $key->status != 18 && $key->status != 20 && $key->status != 19){     

                  $rid = $this->checkOpenClose($key->request_id);
                  if($rid != 0){
                   $req[]= array(
                    'request_id'=>$rid,
                    );
                  }
                  }
            }
              
         }   

        
         if(!empty($req)){
        foreach ($req as $key) {
       
            $changereq=DB::table('changerequests')
                        ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                        ->select('created_date','change_type_name','request_id')
                        ->where('request_id',$key['request_id'])
                        
                        ->get();
                    
                        $allData[]= array(
                          'cmNoSearch' => $this->generate_cm_no_search($changereq[0]->change_type_name, $changereq[0]->created_date, $changereq[0]->request_id), 
                          );
          }   
         
        }

          return $allData;   


  } 

  public function checkOpenClose($rid)
  {
      $data=DB::table('request_progress_status')
                  ->select('request_id')
                  ->where('request_id',$rid)
                  ->where('close',0)
                  ->get();
          
          if(empty($data)){
            return 0;
          }else{
              return $data[0]->request_id;
          }

  }

  public function checkAsDocVerifier($uid,$param,$tbl){
     $data1=DB::table($tbl)
        ->select($param)
        ->where($param,$uid)
        ->get();
          return $data1;
  }
  
   
  public function getUserName($uid){
    $data=DB::table('tb_users')
          ->select('first_name','last_name','username')
          ->where('id',$uid)
          ->get();
          return $data;
  }
  public function checkUserTask($uid){
    $data=DB::table('request_progress_status')
          ->select('message','request_id')
          ->where('assigned_to',$uid)
          ->where('close',0)
          ->get();

          $allData=[];
          foreach ($data as $key) {
            $changereq=DB::table('changerequests')
                        ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
                        ->select('created_date','change_type_name','request_id')
                        ->where('request_id',$key->request_id)
                        ->get();
                        $allData[]= array(
                          'cmNoSearch' => $this->generate_cm_no_search($changereq[0]->change_type_name, $changereq[0]->created_date, $changereq[0]->request_id), 
                          'message' => $key->message

                          );

          }

          return $allData;
  }

  public function checkInProjectCFT($uid){
    
    $data1=DB::table('cftteamforproject')
        ->Join('tb_projectmaster','cftteamforproject.project_code','=','tb_projectmaster.project_code')
        ->select('cftteamforproject.project_code')
        ->where('cftteamforproject.user_id',$uid)
        ->where('cftteamforproject.flag',1)
        ->get();
        
          return $data1;
        
     }

    public function checkInProject($uid,$project_manager){
    $data=DB::table('tb_projectmaster')
          ->select('project_code')
          ->where($project_manager,$uid)
          ->get();
        return $data;
        
   
  }
    


}
