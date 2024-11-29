<?php
use Carbon\Carbon;

class trackingSheetController extends BaseController
{

  public function index(){
   return View::make('trackingSheet/advance_search');
  }
   public function getTeckingSheet()
    {     
        $input = (object)Input::all();


            $_SESSION['btntype'] = "track";
            $data=array();
            $allDepartment =$this->getDepartment();

            $steeringCommCnt = $this->cntSteeringComm();

            $requestId1=DB::table('changerequests')
           ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
           ->select('changerequests.changeType','tbl_change_type.change_type_name','changerequests.created_date','changerequests.request_id','changerequests.dt','changerequests.modified_date')
           ->orderBy('changerequests.request_id','desc')
           ->where('changerequests.status', '!=',5)
            ->where('changerequests.status', '!=',1)
           ->distinct();

            if($input->r_id != '')
             $requestId1->where('changerequests.request_id',$input->r_id);
           if(isset($input->changeType)&& !empty($input->changeType)) {
               
                $requestId1->whereIn('changerequests.changeType', [implode(',', $input->changeType)]);
                $changeType=implode(',',$input->changeType);
            }else{
                $changeType='';
            }
            if(isset($input->change_stage_id)&& !empty($input->change_stage_id)) {
                $requestId1->whereIn('changerequests.change_stage', [implode(',', $input->change_stage_id)]);
                $change_stage_id=implode(',',$input->change_stage_id);
            }
            else{
                $change_stage_id='';
            }
            
             if(isset($input->changerequest_plantcode)&& !empty($input->changerequest_plantcode)){
                 $requestId1->whereIn('changerequests.plant_code',[implode(',',$input->changerequest_plantcode)]);
                 $plantcode= implode(',',$input->changerequest_plantcode);
             }else{
                 $plantcode='';
             }
           $requestId =$requestId1->get();
           foreach ($requestId as $row) {

            if(Session::get('uid') == 1){
                  $result = 0;
                }else{
                  $result=$this->count_hide_data($row->request_id);
                }
             if($result!=1) {
             

             $data[]  = array(
                'initiatin_date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $row->modified_date)->format('d.m.Y'),
                'cmNo'=> $this->generate_cm_no_search($row->change_type_name,$row->created_date,$row->request_id),
                'count_request_is_rejected' => $this->get_count_request_is_rejected($row->request_id),
                'hod_approval' => $this->getAllDate($row->request_id,1),
                'initialInformation' => $this->getAllDate($row->request_id,2),
                'riskEntry' => $this->getAllDate($row->request_id,3),
                'riskEntryHodApp' => $this->getAllDate($row->request_id,4),
                'adminRiskapp' => $this->getAllDate($row->request_id,5),
                'steerComApp' => $this->getSteeringDate($row->request_id,6),
                'qaHead' => $this->getAllDate($row->request_id,7),
                'custEvdienceUpload' => $this->getAllDate($row->request_id,8),
                'adminActivityApp' => $this->getAllDate($row->request_id,9),
                'documentUpload' => $this->getAllDate($row->request_id,10),
                'dept'  => $this->getDept($row->request_id),
                'cooapp' => $this->getAllDate($row->request_id,11),
                 'checkreq' =>$this->checkeCooApproval($row->request_id),
                 'docVerStatus' => $this->getAllDate($row->request_id,12),
                 'PTRupload' => $this->getAllDate($row->request_id,16),
                 'horDep' => $this->getAllDate($row->request_id,13),
                 'beforeAfterStatus' => $this->getAllDate($row->request_id,14),
                 'finalclose' => $this->getAllDate($row->request_id,15),


                );
        }
    }
      // echo "<pre>";print_r($data);exit();

       $formInput=array(
              'r_id' =>$input->r_id,
              'changeType'=>$changeType,
              'change_stage_id'=>$change_stage_id,
              'plantcode'=>$plantcode
                );


        if ($this->check_permission(1)) {
            return View::make('trackingSheet/sheet',compact('allDepartment','data','steeringCommCnt','formInput'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }


    }

    public function checkeCooApproval($rid){
          $data=  DB::table('changerequests')
                  ->select('change_stage')
                  ->where('request_id',$rid)
                  ->get();
                  if(!empty($data)){
                  return  $data[0]->change_stage;
              }
         }


    public function advance_search_result_download() {
        $data=array();
       // $removeddata1=array();
        $input = (object)Input::all();


        $input = (object)Input::all();
    $allDepartment =$this->getDepartment();

            $steeringCommCnt = $this->cntSteeringComm();

            $requestId1=DB::table('changerequests')
           ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
           ->select('changerequests.changeType','tbl_change_type.change_type_name','changerequests.created_date','changerequests.request_id','changerequests.dt','changerequests.modified_date')
           ->orderBy('changerequests.request_id','desc')
           ->where('changerequests.status', '!=',5)
            ->where('changerequests.status', '!=',1)
           ->distinct();

            if($input->r_id != '')
             $requestId1->where('changerequests.request_id',$input->r_id);
            if(isset($input->changeType)&& !empty($input->changeType)) {
               
                $requestId1->whereIn('changerequests.changeType', [implode(',', (array)$input->changeType)]);
                $changeType=implode(',',(array)$input->changeType);
            }else{
                $changeType='';
            }
            if(isset($input->change_stage_id)&& !empty($input->change_stage_id)) {
                $requestId1->whereIn('changerequests.change_stage', [implode(',', (array)$input->change_stage_id)]);
                $change_stage_id=implode(',',(array)$input->change_stage_id);
            }
            else{
                $change_stage_id='';
            }
            
             if(isset($input->plantcode)&& !empty($input->plantcode)){
                 $requestId1->whereIn('changerequests.plant_code',[implode(',',(array)$input->plantcode)]);
                 $plantcode= implode(',',(array)$input->plantcode);
             }else{
                 $plantcode='';
             }

           $requestId =$requestId1->get();
           foreach ($requestId as $row) {

             $query1=DB::table('tbl_change_type')
                        ->select('tbl_change_type.change_type_name')
                        ->where('tbl_change_type.change_type_id',$row->changeType)
                        ->get();
                        

             $data[]  = array(
                'initiatin_date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $row->modified_date)->format('d.m.Y'),
                'cmNo'=> $this->generate_cm_no_search($query1[0]->change_type_name,$row->created_date,$row->request_id),
                'count_request_is_rejected' => $this->get_count_request_is_rejected($row->request_id),
                'hod_approval' => $this->getAllDate($row->request_id,1),
                'initialInformation' => $this->getAllDate($row->request_id,2),
                'riskEntry' => $this->getAllDate($row->request_id,3),
                'riskEntryHodApp' => $this->getAllDate($row->request_id,4),
                'adminRiskapp' => $this->getAllDate($row->request_id,5),
                'steerComApp' => $this->getSteeringDate($row->request_id,6),
                'qaHead' => $this->getAllDate($row->request_id,7),
                'custEvdienceUpload' => $this->getAllDate($row->request_id,8),
                'adminActivityApp' => $this->getAllDate($row->request_id,9),
                'documentUpload' => $this->getAllDate($row->request_id,10),
                'cooapp' => $this->getAllDate($row->request_id,11),
                 'checkreq' =>$this->checkeCooApproval($row->request_id),
                  'docVerStatus' => $this->getAllDate($row->request_id,12),
                 'horDep' => $this->getAllDate($row->request_id,13),
                 'beforeAfterStatus' => $this->getAllDate($row->request_id,14),
                 'finalclose' => $this->getAllDate($row->request_id,15),
                 'PTRupload' => $this->getAllDate($row->request_id,16),

                );
        }
        $date = date('Y-m-d');
        
        
$filename='trackingSheet Sheet-'.$date;
       
            if($input->filetype=='pdf') {

               // $pdf = App::make('dompdf');
               
 $filename1 = Config::get('app.site_root').'uploads/'.$filename;
 
                $pdf=PDF::loadView('trackingSheet/check', compact('data','allDepartment','steeringCommCnt'));
                $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
              // $pdf->save(storage_path($filename1));
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){

                $output =  View::make('trackingSheet/csv_download',compact('data','allDepartment','steeringCommCnt'));
        
                $headers = array(
                    'Pragma' => 'public',
                    'Expires' => 'public',
                    'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                    'Cache-Control' => 'private',
                    'Content-Type' => 'application/vnd.ms-excel; name="excel"',
                    'Content-Disposition' => 'attachment; filename='.$filename.'.xls',
                    'Content-Transfer-Encoding' => 'binary'
                );

                
                return Response::make($output, 200, $headers);

            }elseif($input->filetype=='csv'){



            }else if($input->filetype=='remove' && !empty($input->removeddata)){
                    $removeddata=$input->removeddata;
             //   echo '<pre>';

              //  print_r($removeddata);exit;
                foreach($removeddata as $remove){
                    $x=explode('/',$remove);
                    $request=$x[0];
                    $cust=$x[1];
                  //  echo $request.'   '.$cust.'<br/>';

                    $this->remove_customer_from_list($request,$cust);


                }

            }else if($input->filetype=='show' && !empty($input->showdata)){
                $showdata=$input->showdata;
              //  echo '<pre>';
              //  print_r($showdata);exit;
                foreach($showdata as $show){
                    $x=explode('/',$show);
                    $request=$x[0];
                    $cust=$x[1];
                    //  echo $request.'   '.$cust.'<br/>';

                    $this->show_customer_from_list($request,$cust);


                }
            }else if($input->filetype=='hide_data' && !empty($input->removeddata1)) {
                $showdata = $input->removeddata1;

                    DB::table('changerequests_customer')
                        //->where('request_id', $request_id)
                        //->where('id', $id)
                        ->update(
                            array('flag' => 0,
                            )
                        );


                    foreach ($showdata as $show) {
                        $x = explode('/', $show);
                        $request = $x[0];
                        $cust = $x[1];

                        $this->show_customer_from_list_trial($request, $cust);


                    }

            }




        return Redirect::to('trackingSheet')->with(compact('data'));


    }
      public function getDepartment()
    {

      
        $departments = DB::table('tb_departments')->select('d_id', 'd_name')->where('d_id','!=',11)
                ->where('d_id','!=',2)
                ->get();

        return $departments;


    }

    public function getAllDate($r_id,$status){
        $data = DB::table('tracking_sheet_info')
                ->where('request_id',$r_id)
                ->where('status',$status)
                ->get();

   
   
    $data1=[];
    foreach ($data as $row) {

        if($row->actual_date == 0){
             $actual_date = ""; 
        }else{
               $actual_date = date("d-m-y", strtotime($row->actual_date));
        }
        if($row->target_date == 0){
           $target_date = ""; 
            
        }else{
          $target_date = date("d-m-y", strtotime($row->target_date));
               
        }
        $data1[] = array(
            'actual_date' =>$actual_date, 
            'target_date' =>$target_date, 
            'process'     =>$row->process,
            'status'      =>$row->status
            );
    }
    return $data1;
    }

    public function cntSteeringComm(){
        $cnt = DB::table('tb_users')
        ->select('id','department','first_name','last_name')
        ->where('department',11)
        ->get();
        return $cnt;
    }

    public function get_count_request_is_rejected($id){
        $users = DB::table('permanent_reject_close')
            ->select(DB::raw('COUNT(permanent_reject_close.id) as total'))

            ->where('permanent_reject_close.request_id', $id)
            //->where('request_progress_status.assigned_to', Session::get('uid'))
            ->get();
        if($users[0]->total >=1){
            $Name = DB::table('permanent_reject_close')
                ->select('permanent_reject_close.rejected_by_name')
                ->where('permanent_reject_close.request_id', $id)
                //->where('request_progress_status.assigned_to', Session::get('uid'))
                ->get();
            return "Request is Rejected and Closed by ".$Name[0]->rejected_by_name;
        }else{
            return "";
        }
    }

    public function getDept($req_id){
        $users = DB::table('add_updated_risk_assessment_sheet')
            ->select(DB::raw('add_updated_risk_assessment_sheet.user_department'))

            ->where('add_updated_risk_assessment_sheet.r_id', $req_id)
            ->get();
            $allDept =[];
            foreach ($users as $row) {
              $allDept[] =  array( 'dept_id' => $row->user_department

                );
            }

            return $allDept;
    }


public function getSteeringDate($r_id,$status){
        $data = DB::table('tracking_sheet_info')
              ->select(DB::Raw('max(actual_date) as actual_date,target_date,process,status'))
              ->where('request_id',$r_id)
              ->where('status',$status)
              ->get();
     // print_r($data);exit();
    $data1=[];
    foreach ($data as $row) {

        if($row->actual_date == 0){
             $actual_date = ""; 
        }else{
               $actual_date = date("d-m-y", strtotime($row->actual_date));
        }
        if($row->target_date == 0){
           $target_date = ""; 
            
        }else{
          $target_date = date("d-m-y", strtotime($row->target_date));
               
        }
        
        $data1[] = array(
            'actual_date' =>$actual_date, 
            'target_date' =>$target_date, 
            'process'     =>$row->process,
            'status'      =>$row->status

            );
    }

    // print_r($data1);exit();
    return $data1;
    }

    


}
