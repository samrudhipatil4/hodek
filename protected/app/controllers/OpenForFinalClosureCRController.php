<?php
use Carbon\Carbon;

class OpenForFinalClosureCRController extends BaseController
{

    public function index()
    {

        $user_type = Session::get('gid');
        if($this->check_permission(2)) {

            return View::make('OpenCRPerCtypeStakeholder/changeRequest_search');
        }
            else {
                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }
         
        
    }       


    public function openCRPerCtypeStakeholder_search_result(){
        $data=array();
            $input = (object)Input::all();
            
           if($input->stage=='? undefined:undefined ?' && $input->plant == '? undefined:undefined ?' && $input->changeType == '? undefined:undefined ?'){
            
            $cType=DB::select(DB::raw('select distinct(change_type_id),change_type_name from report_open_change_request_1 join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_1.changeType'));

            $stakeholder=DB::select(DB::raw('select distinct(id),name from report_open_change_request_1 join tb_stakeholder on tb_stakeholder.id=report_open_change_request_1.stakeholder'));
             $stage_id='';
             $plant='';
             $changeType='';
            }else if($input->stage!='? undefined:undefined ?' && $input->plant == '? undefined:undefined ?'  && $input->changeType == '? undefined:undefined ?'){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_stage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_stage.changeType where change_stage='".$input->stage."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_stage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_stage.stakeholder where change_stage='".$input->stage."'"));
            $stage_id=$input->stage;
            $plant='';
            $changeType='';
           }else if($input->stage=='? undefined:undefined ?' && $input->plant != '? undefined:undefined ?'  && $input->changeType == '? undefined:undefined ?'){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plant join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plant.changeType where plant='".$input->plant."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plant join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plant.stakeholder where plant='".$input->plant."'"));
            $stage_id='';
            $plant=$input->plant;
            $changeType='';
           }else if($input->stage=='? undefined:undefined ?' && $input->plant == '? undefined:undefined ?'  && $input->changeType != '? undefined:undefined ?'){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plant join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plant.changeType where changeType='".$input->changeType."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plant join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plant.stakeholder where changeType='".$input->changeType."'"));
            $stage_id='';
            $plant='';
            $changeType=$input->changeType;
           }else if($input->stage !='? undefined:undefined ?' && $input->plant != '? undefined:undefined ?'  && $input->changeType == '? undefined:undefined ?'){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plantandstage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plantandstage.changeType where plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plantandstage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plantandstage.stakeholder where plant='".$input->plant."' and change_stage='".$input->stage."'"));
            $stage_id=$input->stage;
             $plant=$input->plant;
             $changeType='';
           }else if($input->stage !='? undefined:undefined ?' && $input->plant == '? undefined:undefined ?'  && $input->changeType != '? undefined:undefined ?'){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_stage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_stage.changeType where changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_stage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_stage.stakeholder where changeType='".$input->changeType."' and change_stage='".$input->stage."'"));
            $stage_id=$input->stage;
             $plant='';
              $changeType=$input->changeType;
           }else if($input->stage =='? undefined:undefined ?' && $input->plant != '? undefined:undefined ?'  && $input->changeType != '? undefined:undefined ?'){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plant join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plant.changeType where changeType='".$input->changeType."' and plant='".$input->plant."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plant join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plant.stakeholder where changeType='".$input->changeType."' and plant='".$input->plant."'"));
            $stage_id='';
             $plant=$input->plant;
              $changeType=$input->changeType;
           }else {
              
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plantandstage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plantandstage.changeType where plant='".$input->plant."' and change_stage='".$input->stage."' and changeType='".$input->changeType."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plantandstage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plantandstage.stakeholder where plant='".$input->plant."' and change_stage='".$input->stage."' and changeType='".$input->changeType."'"));
            $stage_id=$input->stage;
             $plant=$input->plant;
             $changeType=$input->changeType;
           }
             $formInput=array(
                'stage_id'=>$stage_id,
                'plant'   =>$plant,
                'changeType'=>$changeType,
            );  

          

            if ($this->check_permission(1)) {
            return View::make('OpenCRPerCtypeStakeholder/taskSheet',compact('cType','stakeholder','formInput'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }
    }

   
    public function advance_search_result_download(){
         $data=array();
        $input = (object)Input::all();
        // print_r($input->stage_id);exit();
            if($input->stage=='' && $input->plant == '' && $input->changeType == ''){
            
            $cType=DB::select(DB::raw('select distinct(change_type_id),change_type_name from report_open_change_request_1 join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_1.changeType'));

            $stakeholder=DB::select(DB::raw('select distinct(id),name from report_open_change_request_1 join tb_stakeholder on tb_stakeholder.id=report_open_change_request_1.stakeholder'));
             $stage_id='';
             $plant='';
             $changeType='';
            }else if($input->stage!='' && $input->plant == ''  && $input->changeType == ''){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_stage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_stage.changeType where change_stage='".$input->stage."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_stage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_stage.stakeholder where change_stage='".$input->stage."'"));
            $stage_id=$input->stage;
            $plant='';
            $changeType='';
           }else if($input->stage=='' && $input->plant != ''  && $input->changeType == ''){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plant join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plant.changeType where plant='".$input->plant."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plant join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plant.stakeholder where plant='".$input->plant."'"));
            $stage_id='';
            $plant=$input->plant;
            $changeType='';
           }else if($input->stage=='' && $input->plant == ''  && $input->changeType != ''){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plant join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plant.changeType where changeType='".$input->changeType."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plant join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plant.stakeholder where changeType='".$input->changeType."'"));
            $stage_id='';
            $plant='';
            $changeType=$input->changeType;
           }else if($input->stage !='' && $input->plant != ''  && $input->changeType == ''){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plantandstage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plantandstage.changeType where plant='".$input->plant."' and change_stage='".$input->stage."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plantandstage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plantandstage.stakeholder where plant='".$input->plant."' and change_stage='".$input->stage."'"));
            $stage_id=$input->stage;
             $plant=$input->plant;
             $changeType='';
           }else if($input->stage !='' && $input->plant == ''  && $input->changeType != ''){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_stage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_stage.changeType where changeType='".$input->changeType."' and change_stage='".$input->stage."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_stage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_stage.stakeholder where changeType='".$input->changeType."' and change_stage='".$input->stage."'"));
            $stage_id=$input->stage;
             $plant='';
              $changeType=$input->changeType;
           }else if($input->stage =='' && $input->plant != ''  && $input->changeType != ''){
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plant join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plant.changeType where changeType='".$input->changeType."' and plant='".$input->plant."'"));

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plant join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plant.stakeholder where changeType='".$input->changeType."' and plant='".$input->plant."'"));
            $stage_id='';
             $plant=$input->plant;
              $changeType=$input->changeType;
           }else {
               
            $cType=DB::select(DB::raw("select distinct(change_type_id),change_type_name from report_open_change_request_plantandstage join tbl_change_type on tbl_change_type.change_type_id=report_open_change_request_plantandstage.changeType where plant='".$input->plant."' and change_stage='".$input->stage))."' and changeType='".$input->changeType."'";

            $stakeholder=DB::select(DB::raw("select distinct(id),name from report_open_change_request_plantandstage join tb_stakeholder on tb_stakeholder.id=report_open_change_request_plantandstage.stakeholder where plant='".$input->plant."' and change_stage='".$input->stage."'"."' and changeType='".$input->changeType."'"));
            $stage_id=$input->stage;
             $plant=$input->plant;
             $changeType=$input->changeType;
           }

           $formInput=array(
                'stage_id'=>$stage_id,
            );
            $stadt=date("Y-m-d");
             $filename='OpenCRPerChangetype-'.$stadt;

             if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('OpenCRPerCtypeStakeholder/taskSheetPDF', compact('cType','stakeholder','formInput'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('OpenCRPerCtypeStakeholder/taskSheetExcel',compact('cType','stakeholder','formInput'));

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
