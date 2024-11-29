<?php
use Carbon\Carbon;

class pendingTaskController extends BaseController
{


   public function index()
    {    //$allUser =$this->getAllUserDept();
        $userId=DB::table('tb_users')
           ->select('id')
           ->where('group_id','!=',11)
           ->get();
           foreach ($userId as $row) {
           
            $data[]  = array(
               
                'allUser' =>$this->getAllUserDept($row->id),
                'reintiate' => $this->getPendingTask($row->id,3),
                'hod_approval' => $this->getPendingTask($row->id,1),
                'ini_info_sheet' => $this->getPendingTask($row->id,2),
                'riskEntry'  => $this->getRiskEntrytask($row->id),
                'risk_entry_hod' => $this->getPendingTask($row->id,7),
                'risk_admin_app' => $this->getPendingTask($row->id,8),
                'steer_comm' => $this->getPendingTask($row->id,88),
                'QA_head' => $this->getPendingTask($row->id,10),
                'customer_evi_upload' => $this->getPendingTask($row->id,12),
                'admin_cust_app' => $this->getPendingTask($row->id,13),
                'docUpload' => $this->getPendingTask($row->id,14),
                'ptrUpload' => $this->getPendingTask($row->id,22),
                'app_doc_upload' => $this->getPendingTask($row->id,16),
                'hor_dep' => $this->getPendingTask($row->id,17),
                'before_after' => $this->getPendingTask($row->id,18),
                'final_app' => $this->getPendingTask($row->id,19),
                

                );
        } 

      
       
        if ($this->check_permission(1)) {
            return View::make('pendingTask/taskSheet',compact('data'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
  }

    public function getAllUserDept($user_id){
        $data = DB::table('tb_users')
                ->Join('tb_departments','tb_departments.d_id','=','tb_users.department')
                ->select('tb_users.id','tb_users.first_name','tb_users.last_name','tb_departments.d_name')
                ->where('tb_users.id',$user_id)
              
                ->get();
               
               return $data;
    }

    public function getPendingTask($user_id,$status){
        $data = DB::table('request_progress_status')
                //->join('tb_users','tb_users.id','=','request_progress_status.assigned_to')
                ->select(DB::raw('count(status) as total'))
                ->where('assigned_to',$user_id)
                ->where('close',0)
                ->where('status',$status)
                ->get();
                if($data[0]->total == 0){
                    $total ="";
                }else{
                    $total = $data[0]->total;
                }

                $data1 = array(
                    'total' => $total,
                    );
                return $data1;
                
    }
    public function getRiskEntrytask($user_id){
         $data = DB::table('request_progress_status')
               // ->join('tb_users','tb_users.id','=','request_progress_status.assigned_to')
                ->select(DB::raw('count(status) as total'))
                ->where('request_progress_status.assigned_to',$user_id)
                ->where('request_progress_status.close',0)
                ->whereIn('request_progress_status.status',array(6,9,11,99))
                ->get();

                if($data[0]->total == 0){
                    $total ="";
                }else{
                    $total = $data[0]->total;
                }
                $data1 = array(
                    'total' => $total
                    );
                return $data1;
    }

     public function advance_search_result_download() {
        $data=array();
       // $removeddata1=array();
        $input = (object)Input::all();
     

       $userId=DB::table('tb_users')
           ->select('id')
           ->where('group_id','!=',11)
           ->get();


           foreach ($userId as $row) {
           
            $data[]  = array(
               
                'allUser' =>$this->getAllUserDept($row->id),
                'reintiate' => $this->getPendingTask($row->id,3),
                'hod_approval' => $this->getPendingTask($row->id,1),
                'ini_info_sheet' => $this->getPendingTask($row->id,2),
                'riskEntry'  => $this->getRiskEntrytask($row->id),
                'risk_entry_hod' => $this->getPendingTask($row->id,7),
                'risk_admin_app' => $this->getPendingTask($row->id,8),
                'steer_comm' => $this->getPendingTask($row->id,88),
                'QA_head' => $this->getPendingTask($row->id,10),
                'customer_evi_upload' => $this->getPendingTask($row->id,12),
                'admin_cust_app' => $this->getPendingTask($row->id,13),
                'docUpload' => $this->getPendingTask($row->id,14),
                'ptrUpload' => $this->getPendingTask($row->id,22),
                'app_doc_upload' => $this->getPendingTask($row->id,16),
                'hor_dep' => $this->getPendingTask($row->id,17),
                'before_after' => $this->getPendingTask($row->id,18),
                'final_app' => $this->getPendingTask($row->id,19),
                

                );
        } 
        $date = date('Y-m-d');
        
        
        $filename='pendingTask Sheet-'.$date;
       
            if($input->filetype=='pdf') {

              //  $pdf = App::make('dompdf');
                

                $pdf=PDF::loadView('pendingTask/check', compact('data'));
                $pdf->setPaper('a3')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser

                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){

                $output =  View::make('pendingTask/csv_download',compact('data'));
        
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


    

}
