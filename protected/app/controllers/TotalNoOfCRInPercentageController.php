<?php
use Carbon\Carbon;

class TotalNoOfCRInPercentageController extends BaseController
{

    public function index()
    {

        $user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('totalNoOfCROpenCloseInPercentage/changeRequest_search');
        }
            else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
         
        
    }       


    public function totalCRInPercentage_search_result(){
        $data=array();
            $input = (object)Input::all();
            
           if($input->stage=='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?'){
            
            $total=DB::select(DB::raw('
                select count(report_open_change_request.status_count) AS nos from report_open_change_request'));

            $opencr=DB::select(DB::raw('select count(report_open_change_request.status_count) AS nos from report_open_change_request where (report_open_change_request.status_count > 0)'));

            $close=DB::select(DB::raw('select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where (report_closed_changed_request.status_count > 0) '));

            $permanent_close=DB::select(DB::raw('select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where (report_permanent_reject_cnt.status_count > 0) '));
             $stage_id='';

           
             $hold=DB::table('tb_holdchangerequests')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         // ->distinct('r_id')
                         ->get();  
             $open=($opencr[0]->nos)-($hold[0]->cnt);
             
            $stage_id='';
            $plant='';
            $changeType='';
            }else  if($input->stage!='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?'){
               
             $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('change_stage',$input->stage)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $stage_id=$input->stage;
            $plant='';
            $changeType='';
        
           }else  if($input->stage=='? undefined:undefined ?' && $input->plant!='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?'){
               
             $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where plant='".$input->plant."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and plant='".$input->plant."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and plant='".$input->plant."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and plant='".$input->plant."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.plant_code',$input->plant)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id='';
             $changeType='';
           }else if($input->stage=='? undefined:undefined ?' && $input->changeType !='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?'){
               
             $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.changeType',$input->changeType)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant='';
            $stage_id='';
            $changeType=$input->changeType;
        
           }else if($input->stage !='? undefined:undefined ?' && $input->changeType =='? undefined:undefined ?' && $input->plant!='? undefined:undefined ?'){ 
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and plant='".$input->plant."' and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and plant='".$input->plant."' and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('tb_holdchangerequests.change_stage',$input->stage)
                         ->where('changerequests.plant_code',$input->plant)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id=$input->stage;
            $changeType='';

           }else if($input->stage !='? undefined:undefined ?' && $input->changeType !='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?'){ 
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."' and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('tb_holdchangerequests.change_stage',$input->stage)
                         ->where('changerequests.changeType',$input->changeType)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant='';
            $stage_id=$input->stage;
            $changeType=$input->changeType;
           }
           else if($input->stage =='? undefined:undefined ?' && $input->changeType !='? undefined:undefined ?' && $input->plant!='? undefined:undefined ?'){ 
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."' and plant='".$input->plant."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."' and plant='".$input->plant."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.plant_code',$input->plant)
                         ->where('changerequests.changeType',$input->changeType)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id='';
            $changeType=$input->changeType;
           }else {
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.plant_code',$input->plant)
                         ->where('changerequests.changeType',$input->changeType)
                         ->where('changerequests.change_stage',$input->stage)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id=$input->stage;
            $changeType=$input->changeType;
           }
          

             $formInput=array(
                'stage_id'=>$stage_id,
                'plant'   =>$plant,
                'changeType'=>$changeType,
            );
            if ($this->check_permission(1)) {
            return View::make('totalNoOfCROpenCloseInPercentage/taskSheet',compact('total','open','close','hold','formInput','permanent_close'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

    
    
    public function totalCRInPercentage_search_result_download(){
         $data=array();
            $input = (object)Input::all();
            
           if($input->stage==0 && $input->plant==0 && $input->changeType==0){
            
            $total=DB::select(DB::raw('
                select count(report_open_change_request.status_count) AS nos from report_open_change_request'));

            $opencr=DB::select(DB::raw('select count(report_open_change_request.status_count) AS nos from report_open_change_request where (report_open_change_request.status_count > 0)'));

            $close=DB::select(DB::raw('select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where (report_closed_changed_request.status_count > 0) '));

            $permanent_close=DB::select(DB::raw('select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where (report_permanent_reject_cnt.status_count > 0) '));
             $stage_id='';

             
             $hold=DB::table('tb_holdchangerequests')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         // ->distinct('r_id')
                         ->get();  
             $open=($opencr[0]->nos)-($hold[0]->cnt);
             
            $stage_id='';
            $plant='';
            $changeType='';
            }else  if($input->stage!=0 && $input->changeType==0 && $input->plant==0){
               
             $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('change_stage',$input->stage)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $stage_id=$input->stage;
            $plant='';
            $changeType='';
        
           }else  if($input->stage==0 && $input->plant!=0 && $input->changeType==0){
               
             $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where plant='".$input->plant."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and plant='".$input->plant."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and plant='".$input->plant."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and plant='".$input->plant."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.plant_code',$input->plant)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id='';
             $changeType='';
           }else if($input->stage==0 && $input->changeType !=0 && $input->plant==0){
               
             $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.changeType',$input->changeType)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant='';
            $stage_id='';
            $changeType=$input->changeType;
        
           }else if($input->stage !=0 && $input->changeType ==0 && $input->plant!=0){ 
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and plant='".$input->plant."' and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and plant='".$input->plant."' and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('tb_holdchangerequests.change_stage',$input->stage)
                         ->where('changerequests.plant_code',$input->plant)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id=$input->stage;
            $changeType='';
           }else if($input->stage !=0 && $input->changeType !=0 && $input->plant==0){ 
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."' and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('tb_holdchangerequests.change_stage',$input->stage)
                         ->where('changerequests.changeType',$input->changeType)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant='';
            $stage_id=$input->stage;
            $changeType=$input->changeType;
           }else if($input->stage ==0 && $input->changeType !=0 && $input->plant!=0){ 
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."' and plant='".$input->plant."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."' and plant='".$input->plant."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.plant_code',$input->plant)
                         ->where('changerequests.changeType',$input->changeType)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id='';
            $changeType=$input->changeType;
           }else {
                $total=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $opencr=DB::select(DB::raw("select count(report_open_change_request.status_count) AS nos from report_open_change_request where report_open_change_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $close=DB::select(DB::raw("select count(report_closed_changed_request.status_count) AS nos from report_closed_changed_request where report_closed_changed_request.status_count > 0 and changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));

             $permanent_close=DB::select(DB::raw("select count(report_permanent_reject_cnt.status_count) AS nos from report_permanent_reject_cnt where report_permanent_reject_cnt.status_count >  0 and changeType='".$input->changeType."' and plant='".$input->plant."' and change_stage='".$input->stage."'"));


             $hold=DB::table('tb_holdchangerequests')
                        ->leftJoin('changerequests','changerequests.request_id','=','tb_holdchangerequests.r_id')
                         ->select(db::raw('count(distinct(r_id)) as cnt'))
                         ->where('flag',1)
                         ->where('changerequests.plant_code',$input->plant)
                         ->where('changerequests.changeType',$input->changeType)
                         ->where('changerequests.change_stage',$input->stage)
                         ->get();  
            $open=($opencr[0]->nos)-($hold[0]->cnt);
            $plant=$input->plant;
            $stage_id=$input->stage;
            $changeType=$input->changeType;
           }

           // print_r($open);
           // echo '<pre>';print_r($close);
           // echo '<pre>';print_r($hold);exit();

           $stadt=date("Y-m-d");
             $filename='TotalCRInPercentage-'.$stadt;

             if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('totalNoOfCROpenCloseInPercentage/taskSheetPDF', compact('total','open','close','hold','formInput','permanent_close'));

                $pdf->setPaper('a4')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('totalNoOfCROpenCloseInPercentage/taskSheetExcel',compact('permanent_close','total','open','close','hold','formInput'));

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
