<?php
use Carbon\Carbon;

class CRPerCustomerPerPurposeController extends BaseController
{

    public function index()
    {

        $user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('OpenCRPerCustomerPerPurpose/changeRequest_search');
        }
            else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
         
        
    }   




    public function totalNoOfCRPerCustPerPurpose_search_result(){
        $data=array();
            $input = (object)Input::all();

            if($input->startdate!='' && $input->startdate!=''){
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
        }else{
            $created_date='';
            $end_date='';
        }

           if($input->stage=='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?' && ($input->startdate=='' && $input->enddate=='')){
                $purpose=DB::select(DB::raw('select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose'));
                $custdata=DB::select(DB::raw('select distinct(customer_id),CustName from total_cr_customerpurpose'));
             $stage_id='';
             $changeType='';
             $startdate='';
             $enddate='';
             $plant='';
            }else if($input->stage!='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && $input->plant =='? undefined:undefined ?' && ($input->startdate=='' && $input->enddate=='') ){
               
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where change_stage=".$input->stage));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where change_stage=".$input->stage));

            $stage_id=$input->stage;
            $changeType='';
            $startdate='';
            $enddate='';
            $plant='';
           }else if($input->stage=='? undefined:undefined ?' && $input->changeType !='? undefined:undefined ?' && $input->plant =='? undefined:undefined ?' && ($input->startdate=='' && $input->enddate=='') ){
               
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where changeType=".$input->changeType));

            $stage_id='';
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant='';
           }else if($input->stage=='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && $input->plant !='? undefined:undefined ?' && ($input->startdate=='' && $input->enddate=='') ){
               
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where plant=".$input->plant));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where plant=".$input->plant));

            $stage_id='';
            $changeType='';
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else if($input->stage=='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?' && ($input->startdate!='' && $input->enddate!='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."'"));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."'"));

            $stage_id='';
             $changeType='';
            $startdate=$created_date;
            $enddate=$end_date;
            $plant='';
           }else if($input->stage!='? undefined:undefined ?' && $input->plant!='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && ($input->startdate=='' && $input->enddate=='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where change_stage=".$input->stage." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where  change_stage=".$input->stage." and plant=".$input->plant));

            $stage_id=$input->stage;
            $changeType='';
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else if($input->stage=='? undefined:undefined ?' && $input->plant!='? undefined:undefined ?' && $input->changeType !='? undefined:undefined ?' && ($input->startdate=='' && $input->enddate=='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where  changeType=".$input->changeType." and plant=".$input->plant));

            $stage_id='';
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else if($input->stage=='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && $input->plant!='? undefined:undefined ?' && ($input->startdate !='' && $input->enddate !='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and plant=".$input->plant));

          
            $stage_id='';
             $changeType='';
            $startdate=$created_date;
            $enddate=$end_date;
            $plant=$input->plant;
           }else if($input->stage !='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?' && $input->changeType !='? undefined:undefined ?' && ($input->startdate=='' && $input->enddate=='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType." and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where  changeType=".$input->changeType." and change_stage=".$input->stage));

            $stage_id=$input->stage;
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant='';
           }else if($input->stage!='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && ($input->startdate !='' && $input->enddate !='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and change_stage=".$input->stage));

          
            $stage_id=$input->stage;
            $changeType='';
            $startdate=$created_date;
            $enddate=$end_date;
            $plant='';
           }else if($input->stage=='? undefined:undefined ?' && $input->plant=='? undefined:undefined ?' && $input->changeType!='? undefined:undefined ?' && ($input->startdate !='' && $input->enddate !='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and changeType=".$input->changeType));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and changeType=".$input->changeType));

          
            $stage_id='';
            $changeType=$input->changeType;
            $startdate=$created_date;
            $enddate=$end_date;
            $plant='';
           }else if($input->stage !='? undefined:undefined ?' && $input->plant =='? undefined:undefined ?' && $input->changeType!='? undefined:undefined ?' && ($input->startdate !='' && $input->enddate !='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and changeType=".$input->changeType." and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and changeType=".$input->changeType." and change_stage=".$input->stage));

          
            $stage_id=$input->stage;
            $changeType=$input->changeType;
            $startdate=$created_date;
            $enddate=$end_date;
            $plant='';
           }else if($input->stage !='? undefined:undefined ?' && $input->plant !='? undefined:undefined ?' && $input->changeType=='? undefined:undefined ?' && ($input->startdate !='' && $input->enddate !='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and change_stage=".$input->stage." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and change_stage=".$input->stage." and plant=".$input->plant));

          
            $stage_id=$input->stage;
            $changeType='';
            $startdate=$created_date;
            $enddate=$end_date;
            $plant=$input->plant;
           }else if($input->stage =='? undefined:undefined ?' && $input->plant !='? undefined:undefined ?' && $input->changeType!='? undefined:undefined ?' && ($input->startdate !='' && $input->enddate !='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and changeType=".$input->changeType." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and changeType=".$input->changeType." and plant=".$input->plant));

          
            $stage_id='';
            $changeType=$input->changeType;
            $startdate=$created_date;
            $enddate=$end_date;
            $plant=$input->plant;
           }else if($input->stage !='? undefined:undefined ?' && $input->plant !='? undefined:undefined ?' && $input->changeType!='? undefined:undefined ?' && ($input->startdate =='' && $input->enddate =='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType." and plant=".$input->plant." and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where changeType=".$input->changeType." and plant=".$input->plant." and change_stage=".$input->stage));
          
            $stage_id=$input->stage;
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else{
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and  change_stage=".$input->stage." and plant=".$input->plant." and changeType=".$input->changeType));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$created_date."' and dt<='".$end_date."' and change_stage=".$input->stage." and plant=".$input->plant." and changeType=".$input->changeType));

            $stage_id=$input->stage;
            $startdate=$created_date;
            $enddate=$end_date;
             $changeType=$input->changeType;
            $plant=$input->plant;
           }

             $formInput=array(
                'stage_id'=>$stage_id,
                'startdate'=>$created_date,
                'enddate'=>$end_date,
                'plant' =>$plant,
                'changeType'=>$changeType
            );     
             
            if ($this->check_permission(1)) {
            return View::make('OpenCRPerCustomerPerPurpose/taskSheet',compact('purpose','custdata','formInput'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

    
    public function totalNoOfCRPerCustPerPurpose_download(){
        $data=array();
        $input = (object)Input::all();

       
             if($input->stage=='' && $input->changeType=='' && $input->plant=='' && ($input->created_date=='' && $input->end_date=='')){
                $purpose=DB::select(DB::raw('select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose'));
                $custdata=DB::select(DB::raw('select distinct(customer_id),CustName from total_cr_customerpurpose'));
             $stage_id='';
             $changeType='';
             $startdate='';
             $enddate='';
             $plant='';
            }else if($input->stage!='' && $input->changeType=='' && $input->plant =='' && ($input->created_date=='' && $input->end_date=='') ){
               
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where change_stage=".$input->stage));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where change_stage=".$input->stage));

            $stage_id=$input->stage;
            $changeType='';
            $startdate='';
            $enddate='';
            $plant='';
           }else if($input->stage=='' && $input->changeType !='' && $input->plant =='' && ($input->created_date=='' && $input->end_date=='') ){
               
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where changeType=".$input->changeType));

            $stage_id='';
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant='';
           }else if($input->stage=='' && $input->changeType=='' && $input->plant !='' &&($input->created_date=='' && $input->end_date=='') ){
               
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where plant=".$input->plant));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where plant=".$input->plant));

            $stage_id='';
            $changeType='';
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else if($input->stage=='' && $input->changeType=='' && $input->plant=='' && ($input->created_date !='' && $input->end_date!='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."'"));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."'"));

            $stage_id='';
             $changeType='';
            $startdate=$input->created_date;
            $enddate=$input->end_date;
            $plant='';
           }else if($input->stage!='' && $input->plant!='' && $input->changeType=='' && ($input->created_date=='' && $input->end_date=='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where change_stage=".$input->stage." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where  change_stage=".$input->stage." and plant=".$input->plant));

            $stage_id=$input->stage;
            $changeType='';
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else if($input->stage=='' && $input->plant!='' && $input->changeType !='' && ($input->created_date=='' && $input->end_date=='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where  changeType=".$input->changeType." and plant=".$input->plant));

            $stage_id='';
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else if($input->stage=='' && $input->changeType=='' && $input->plant!='' && ($input->created_date!='' && $input->end_date!='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and plant=".$input->plant));

          
            $stage_id='';
             $changeType='';
            $startdate=$input->created_date;
            $enddate=$input->end_date;
            $plant=$input->plant;
           }else if($input->stage !='' && $input->plant=='' && $input->changeType !='' && ($input->created_date=='' && $input->end_date=='')){
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType." and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where  changeType=".$input->changeType." and change_stage=".$input->stage));

            $stage_id=$input->stage;
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant='';
           }else if($input->stage!='' && $input->plant=='' && $input->changeType=='' && ($input->created_date!='' && $input->end_date!='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and change_stage=".$input->stage));

          
            $stage_id=$input->stage;
            $changeType='';
            $startdate=$input->created_date;
            $enddate=$input->end_date;
            $plant='';
           }else if($input->stage=='' && $input->plant=='' && $input->changeType!='' && ($input->created_date!='' && $input->end_date!='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and changeType=".$input->changeType));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and changeType=".$input->changeType));

          
            $stage_id='';
            $changeType=$input->changeType;
            $startdate=$input->created_date;
            $enddate=$input->end_date;
            $plant='';
           }else if($input->stage !='' && $input->plant =='' && $input->changeType!='' && ($input->created_date!='' && $input->end_date!='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and changeType=".$input->changeType." and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and changeType=".$input->changeType." and change_stage=".$input->stage));

          
            $stage_id=$input->stage;
            $changeType=$input->changeType;
            $startdate=$input->created_date;
            $enddate=$input->end_date;
            $plant='';
           }else if($input->stage !='' && $input->plant !='' && $input->changeType=='' && ($input->created_date!='' && $input->end_date!='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and change_stage=".$input->stage." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and change_stage=".$input->stage." and plant=".$input->plant));

          
            $stage_id=$input->stage;
            $changeType='';
            $startdate=$input->created_date;
            $enddate=$input->end_date;
            $plant=$input->plant;
           }else if($input->stage =='' && $input->plant !='' && $input->changeType!='' && ($input->created_date!='' && $input->end_date!='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and changeType=".$input->changeType." and plant=".$input->plant));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and changeType=".$input->changeType." and plant=".$input->plant));

          
            $stage_id='';
            $changeType=$input->changeType;
            $startdate=$input->created_date;
            $enddate=$input->end_date;
            $plant=$input->plant;
           }else if($input->stage !='' && $input->plant !='?' && $input->changeType!='' && ($input->created_date=='' && $input->end_date=='')){
             $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where changeType=".$input->changeType." and plant=".$input->plant." and change_stage=".$input->stage));


            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where changeType=".$input->changeType." and plant=".$input->plant." and change_stage=".$input->stage));
          
            $stage_id=$input->stage;
            $changeType=$input->changeType;
            $startdate='';
            $enddate='';
            $plant=$input->plant;
           }else{
            $purpose=DB::select(DB::raw("select distinct(purpose_id),changerequest_purpose from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and  change_stage=".$input->stage." and plant=".$input->plant." and changeType=".$input->changeType));

            $custdata=DB::select(DB::raw("select distinct(customer_id),CustName from total_cr_customerpurpose where dt>='".$input->created_date."' and dt<='".$input->end_date."' and change_stage=".$input->stage." and plant=".$input->plant." and changeType=".$input->changeType));

            $stage_id=$input->stage;
            $startdate=$input->created_date;
            $enddate=$input->end_date;
             $changeType=$input->changeType;
            $plant=$input->plant;
           }

             $formInput=array(
                'stage_id'=>$stage_id,
                'startdate'=>$startdate,
                'enddate'=>$enddate,
                'plant'  =>$plant,
            );     
            $stadt=date("Y-m-d");
             $filename='TotalCRPerCustomerPurpose-'.$stadt;

             if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('OpenCRPerCustomerPerPurpose/taskSheetPDF', compact('purpose','custdata','formInput'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('OpenCRPerCustomerPerPurpose/taskSheetExcel',compact('purpose','custdata','formInput'));

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
