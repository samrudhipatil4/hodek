<?php
use Carbon\Carbon;

class PendingCRFormTargetDateController extends BaseController
{

    public function index()
    {

        $user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('PendingCRFromTargetDate/changeRequest_search');
        }
            else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
         
        
    }       


    public function PendingCRFormTargetDate_search_result(){
        $data=array();

            $input = (object)Input::all();
            
            if($input->pending==1){
                $pending='1 week';
            }else if($input->pending==2){
                $pending='2 week';
            }else{
                $pending='1 month';
            }
            if($input->stage=='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?'){
            $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where  target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                $stage_id='';
                $plant='';
                $changeType='';
            }else  if($input->stage !='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?'&& $input->changeType=='? undefined:undefined ?'){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where change_stage='.$input->stage.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant='';
                 $changeType='';
            }else  if($input->stage =='? undefined:undefined ?' && $input->plant !='? undefined:undefined ?'&& $input->changeType=='? undefined:undefined ?'){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id='';
                 $plant=$input->plant;
                 $changeType='';
            }else  if($input->stage =='? undefined:undefined ?' && $input->plant =='? undefined:undefined ?'&& $input->changeType!='? undefined:undefined ?'){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where changeType='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id='';
                 $plant='';
                 $changeType=$input->changeType;

            }else if($input->stage !='? undefined:undefined ?' && $input->plant !='? undefined:undefined ?'&& $input->changeType=='? undefined:undefined ?'){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and change_stage ='.$input->stage.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant=$input->plant;
                 $changeType='';
            }else if($input->stage =='? undefined:undefined ?' && $input->plant !='? undefined:undefined ?'&& $input->changeType!='? undefined:undefined ?'){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and changeType ='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id='';
                 $plant=$input->plant;
                 $changeType=$input->changeType;
            }else if($input->stage !='? undefined:undefined ?' && $input->plant =='? undefined:undefined ?'&& $input->changeType!='? undefined:undefined ?'){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where change_stage='.$input->stage.' and changeType ='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant='';
                 $changeType=$input->changeType;
            }else{
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and change_stage ='.$input->stage.' and changeType ='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant=$input->plant;
                  $changeType=$input->changeType;
            }
            $formInput=array(
                'stage_id'=>$stage_id,
                'pending'=>$pending,
                'plant'  =>$plant,
                'changeType'=>$changeType
            );
            
            if ($this->check_permission(1)) {
            return View::make('PendingCRFromTargetDate/taskSheet',compact('data','formInput'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

    
    public function PendingCRFormTargetDate_download(){
         $data=array();
        $input = (object)Input::all();
        
        
         // if($input->pending==1){
         //        $pending='1 week';
         //    }else if($input->pending==2){
         //        $pending='2 week';
         //    }else{
         //        $pending='1 month';
         //    }
        $pending=$input->pending;
            // print_r($pending);exit();
          if($input->stage=='' && $input->plant=='' && $input->changeType==''){
            $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where  target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                $stage_id='';
                $plant='';
                $changeType='';
            }else  if($input->stage !='' && $input->plant==''&& $input->changeType==''){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where change_stage='.$input->stage.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant='';
                 $changeType='';
            }else  if($input->stage =='' && $input->plant !=''&& $input->changeType==''){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id='';
                 $plant=$input->plant;
                 $changeType='';
            }else  if($input->stage =='' && $input->plant ==''&& $input->changeType!=''){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where changeType='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id='';
                 $plant='';
                 $changeType=$input->changeType;

            }else if($input->stage !='' && $input->plant !=''&& $input->changeType==''){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and change_stage ='.$input->stage.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant=$input->plant;
                 $changeType='';
            }else if($input->stage =='' && $input->plant !=''&& $input->changeType!=''){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and changeType ='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id='';
                 $plant=$input->plant;
                 $changeType=$input->changeType;
            }else if($input->stage !='' && $input->plant ==''&& $input->changeType!=''){
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where change_stage='.$input->stage.' and changeType ='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant='';
                 $changeType=$input->changeType;
            }else{
                $data=DB::select(DB::raw('select d_name,count(request_id)as cnt FROM report_get_target_date where plant='.$input->plant.' and change_stage ='.$input->stage.' and changeType ='.$input->changeType.' and target_date < NOW() - INTERVAL '.$pending.' group by d_id'));
                 $stage_id=$input->stage;
                 $plant=$input->plant;
                  $changeType=$input->changeType;
            }
            $formInput=array(
                'stage_id'=>$stage_id,
                'pending'=>$pending,
                'plant'=>$plant
            );
             $stadt=date("Y-m-d");
             $filename='PendingFromTarget-'.$stadt;

             if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('PendingCRFromTargetDate/taskSheetPDF', compact('data','formInput'));

                $pdf->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('PendingCRFromTargetDate/taskSheetExcel',compact('data','formInput'));

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
