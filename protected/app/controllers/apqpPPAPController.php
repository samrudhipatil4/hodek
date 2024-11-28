<?php

class apqpPPAPController extends BaseController  {

	//protected $layout = "layouts.main";
	
	  public function index(){

        if(Auth::check()):
              return View::make('apqpPPAP/DFMEA');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

     public function PFMEA(){

        if(Auth::check()):
              return View::make('apqpPPAP/PFMEA');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }



    public function viewRFQ(){

        if(Auth::check()):
              return View::make('apqpTask/RFQ_view');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    public function reportDFEMA(){
      if(Auth::check()):
              return View::make('apqpPPAP/DFMEASearchReport');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

     public function reportPFEMA(){
      if(Auth::check()):
              return View::make('apqpPPAP/PFMEASearchReport');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    public function getResUser(){
      $data=DB::table('tb_users')
            ->select('id','first_name','last_name')
            ->get();
            

            $select="--Please Select--";
  

      echo '<option value=" "';
      echo ' >'.$select.'</option>';
      foreach ($data as $key ) {

        echo '<option value="'. $key->id. '"';
        echo ' >'.$key->first_name.' '.$key->last_name.'</option>';
      }

    exit;
    }
    public function getDFMEANo(){
      $data=DB::table('apqp_dfmea_main')
            ->select('dfmea_id','dfmea_no')
            ->orderBy('dfmea_id')
            ->get();
            return $data;
    }

    public function getPFMEANo(){
      $data=DB::table('apqp_pfmea_main')
            ->select('pfmea_id','pfmea_no')
            ->orderBy('pfmea_id')
            ->get();
            return $data;
    }

    
  public function saveDFMEADet(){
    $input =Input::all();
  
//     DB::beginTransaction();
// try {
    try{
    if(!empty($input['DFMEAmain'])){
      
      $data = $input['DFMEAmain'];
       $date1 = explode('/',  $data[0]['DFMEADate']);
                $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
    DB::table('apqp_dfmea_main')
    ->insert(
        array(
            'project_id' => $data[0]['project'],
            'part_no_name'  =>$data[0]['txtpart'],
            'dfmea_no'=>$data[0]['DFMEANum'],
            'dfmea_date'=>$d_t,
            'CreatedBy'  =>Session::get('uid'),
            'CreatedDate' => date('Y-m-d H:i:s')
          )
      );
      $lastid = DB::getPdo()->lastInsertId();
    }

     if(!empty($input['DFMEAdet'])){
      $details = $input['DFMEAdet'];

      foreach ($details as $key) {
          $date2 = explode('/',  $key['targetdate']);
                $d_t1 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
        DB::table('apqp_dfmea_details')
        ->insert(
            array(
                'dfmea_id' => $lastid,
                'item'  =>$key['item'],
                'requirements'=>$key['requirements'],
                'failure_mode'=>$key['failuremode'],
                'effects_of_failure'=>$key['failureeffect'],
                'severity'=>$key['severity'],
                'classification'=>$key['classification'],
                'potential_causes'=>$key['potcauses'],
                'control_prevention'=>$key['ctrlprevention'],
                'occurance'=>$key['occurance'],
                'control_detection'=>$key['ctrldetection'],
                'detectionrank'=>$key['detectionrank'],
                'risk_pririty_no'=>$key['riskpriortyno'],
                'recommended_action'=>$key['recommaction'],
                'responsibility'=>$key['resp'],
                'target_date'=>$d_t1,
                'action_result'=>$key['actionresult']


              )
          );
      }
    }
  }catch (Illuminate\Database\QueryException $e){
          $errorCode = $e->errorInfo[1];
          if($errorCode == 1062){
            return $errorCode;
          }

    }
     
    
 //    DB::commit();
 //   }catch (\Exception $e) {
 //     DB::rollback();
 //    $message = $e->getMessage();
 // }
    return $d_t.'  '.$d_t1;
  }

   public function savePFMEADet(){
    $input =Input::all();
  
//     DB::beginTransaction();
// try {
    try{
    if(!empty($input['PFMEAmain'])){
      $data = $input['PFMEAmain'];
       $date1 = explode('/',  $data[0]['PFMEADate']);
                $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
    DB::table('apqp_pfmea_main')
    ->insert(
        array(
            'project_id' => $data[0]['project'],
            'part_no_name'  =>$data[0]['txtpart'],
            'pfmea_no'=>$data[0]['PFMEANum'],
            'pfmea_date'=>$d_t,
            'CreatedBy'  =>Session::get('uid'),
            'CreatedDate' => date('Y-m-d H:i:s')
          )
      );
      $lastid = DB::getPdo()->lastInsertId();
    }

     if(!empty($input['PFMEAdet'])){
      $details = $input['PFMEAdet'];

      foreach ($details as $key) {
          $date2 = explode('/',  $key['targetdate']);
                $d_t1 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
        DB::table('apqp_pfmea_details')
        ->insert(
            array(
                'pfmea_id' => $lastid,
                'process_step'  =>$key['processes'],
                'requirements'=>$key['requirements'],
                'failure_mode'=>$key['failuremode'],
                'effects_of_failure'=>$key['failureeffect'],
                'severity'=>$key['severity'],
                'classification'=>$key['classification'],
                'potential_causes'=>$key['potcauses'],
                'control_prevention'=>$key['ctrlprevention'],
                'occurance'=>$key['occurance'],
                'control_detection'=>$key['ctrldetection'],
                'detectionrank'=>$key['detectionrank'],
                'risk_pririty_no'=>$key['riskpriortyno'],
                'recommended_action'=>$key['recommaction'],
                'responsibility'=>$key['resp'],
                'target_date'=>$d_t1,
                'action_result'=>$key['actionresult']


              )
          );
      }
    }
  }catch (Illuminate\Database\QueryException $e){
          $errorCode = $e->errorInfo[1];
          if($errorCode == 1062){
            return $errorCode;
          }

    }
     
    
 //    DB::commit();
 //   }catch (\Exception $e) {
 //     DB::rollback();
 //    $message = $e->getMessage();
 // }
    return $d_t.'  '.$d_t1;
  }
  public function view_DFMEA_report(){
    $input = Input::all();
  $dfmea_no = $input['dfmea_no'];
  
      $data = DB::table('apqp_dfmea_main')
              ->join('apqp_dfmea_details','apqp_dfmea_details.dfmea_id','=','apqp_dfmea_main.dfmea_id')
             
              ->join('tb_users','tb_users.id','=','apqp_dfmea_details.responsibility')
              ->select('apqp_dfmea_details.*','tb_users.first_name','tb_users.last_name')
              ->where('apqp_dfmea_main.dfmea_id',$input['dfmea_no'])
              ->get();

            $dfmea = DB::table('apqp_dfmea_main')
             ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_dfmea_main.project_id')
              ->select('apqp_dfmea_main.*','apqp_new_project_info.project_no')
              ->where('apqp_dfmea_main.dfmea_id',$input['dfmea_no'])
              ->get();

               if ($this->check_permission(1)) {
            return View::make('apqpPPAP/DFMEAReport',compact('data','dfmea_no','dfmea'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
  }
  public function downloadDFMEAReport(){
    $input = Input::all();
  $dfmea_no = $input['dfmea_no'];
  
      $data = DB::table('apqp_dfmea_main')
              ->join('apqp_dfmea_details','apqp_dfmea_details.dfmea_id','=','apqp_dfmea_main.dfmea_id')
             
              ->join('tb_users','tb_users.id','=','apqp_dfmea_details.responsibility')
              ->select('apqp_dfmea_details.*','tb_users.first_name','tb_users.last_name')
              ->where('apqp_dfmea_main.dfmea_id',$input['dfmea_no'])
              ->get();

            $dfmea = DB::table('apqp_dfmea_main')
             ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_dfmea_main.project_id')
              ->select('apqp_dfmea_main.*','apqp_new_project_info.project_no')
              ->where('apqp_dfmea_main.dfmea_id',$input['dfmea_no'])
              ->get();

               $date = date('Y-m-d');

        $filename='DFMEAReport-'.$date;
        if($input['filetype']=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('apqpPPAP/downloadDFMEAReport', compact('data','dfmea','dfmea_no'));

                $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input['filetype']=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('apqpPPAP/downloadDFMEAReport', compact('data','dfmea','dfmea_no'));

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

   public function view_PFMEA_report(){
    $input = Input::all();
  $pfmea_no = $input['pfmea_no'];
  
      $data = DB::table('apqp_pfmea_main')
              ->join('apqp_pfmea_details','apqp_pfmea_details.pfmea_id','=','apqp_pfmea_main.pfmea_id')
              ->join('tb_users','tb_users.id','=','apqp_pfmea_details.responsibility')
              ->select('apqp_pfmea_details.*','tb_users.first_name','tb_users.last_name')
              ->where('apqp_pfmea_main.pfmea_id',$input['pfmea_no'])
              ->get();

            $pfmea = DB::table('apqp_pfmea_main')
             ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_pfmea_main.project_id')
              ->select('apqp_pfmea_main.*','apqp_new_project_info.project_no')
              ->where('apqp_pfmea_main.pfmea_id',$input['pfmea_no'])
              ->get();

        if ($this->check_permission(1)) {
            return View::make('apqpPPAP/PFMEAReport',compact('data','pfmea_no','pfmea'));
        } else {
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
  }

  public function downloadPFMEAReport(){
    $input = Input::all();
  $pfmea_no = $input['pfmea_no'];
  
      $data = DB::table('apqp_pfmea_main')
              ->join('apqp_pfmea_details','apqp_pfmea_details.pfmea_id','=','apqp_pfmea_main.pfmea_id')
             
              ->join('tb_users','tb_users.id','=','apqp_pfmea_details.responsibility')
              ->select('apqp_pfmea_details.*','tb_users.first_name','tb_users.last_name')
              ->where('apqp_pfmea_main.pfmea_id',$input['pfmea_no'])
              ->get();

            $pfmea = DB::table('apqp_pfmea_main')
             ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_pfmea_main.project_id')
              ->select('apqp_pfmea_main.*','apqp_new_project_info.project_no')
              ->where('apqp_pfmea_main.pfmea_id',$input['pfmea_no'])
              ->get();

               $date = date('Y-m-d');

        $filename='PFMEAReport-'.$date;
        if($input['filetype']=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('apqpPPAP/downloadPFMEAReport', compact('data','pfmea','pfmea_no'));

                $pdf->setPaper('a0')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input['filetype']=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('apqpPPAP/downloadPFMEAReport', compact('data','pfmea','pfmea_no'));

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