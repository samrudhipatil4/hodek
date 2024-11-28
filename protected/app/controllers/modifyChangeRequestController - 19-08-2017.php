<?php
use Carbon\Carbon;

class modifyChangeRequestController extends ChangerequestController
{


    public function index()
    {


        if ($this->check_permission(1)) {
            return View::make('modifychangerequest/modify_change_request');
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }


    }

    public function changerequestModify()
    {

        //Returns All plantcodes
        $plantcode = DB::table('change_modify_parameter')->select('m_code', 'details')->get();

        return $plantcode;


    }

    public function getChangeRequest()
    {
        $request=DB::select('SELECT *
        FROM changerequests
       WHERE request_id NOT IN (SELECT request_id FROM permanent_reject_close)');

        $cmNo="";

        foreach($request as $row) {

             $requestId=DB::table('changerequests')
           ->leftJoin('tbl_change_type', 'changerequests.changeType', '=', 'tbl_change_type.change_type_id')
           ->select('tbl_change_type.change_type_name')
          
           ->where('request_id', 
            $row->request_id)
           ->get();
           

            $data[] = array(
                'request_id' => $this->generate_cm_no_search($requestId[0]->change_type_name, $row->created_date, $row->request_id),
                'r_id'      =>$row->request_id,
            );
        }
        return $data;


    }


    public function changeRequestModifyDetails()
    {

        $input = (object)Input::all();

//print_r($input);exit;   
        $file = Input::get('Upload');
        $app =  Input::get('applicability');
        $uploadBy =  Input::get('activity_upload');
        $deletefile = Input::get('delete_attachment');



        $modify_id = Input::get('m_code');
        $dept_id = Input::get('d_id');
        $r_id=Input::get('r_id');

        Session::put('modify_id', $modify_id);
        Session::put('r_id', $r_id);
        Session::put('dept_id', $dept_id);

        if ($modify_id == 1 && $r_id!= "") {
            $data = array(
                'request_id'  => $r_id,
                'page'        => 'modify',

            );

            if ($this->check_permission(1)) {
                return View::make('changes/change_request_edit')->with($data);
            } else {

                return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
            }

        }else if($modify_id == 2 && $r_id != ""){

            $total  = DB::table('changerequests')
                //->select(DB::raw('count(risk_assessment_id) as total'))
                ->select('changerequests.*')

                ->where('changerequests.request_id','=',$r_id)
                // ->where('tb_risk_assessment_points.status','=',1)
                ->get();

            $data=array(
                'page'      => 'modifyByAdmin',
                'request_id' =>$r_id,
                'initiator' =>$total[0]->initiator_id
            );
            return View::make('changes/updateinitia_information_sheet')->with($data);

        }else if($modify_id == 3 && $dept_id != "" && $r_id!= ""){

            $total  = DB::table('tb_risk_assessment_points')
                //->select(DB::raw('count(risk_assessment_id) as total'))
                ->select('tb_risk_assessment_points.*')
                ->where('tb_risk_assessment_points.risk_dep','=',$dept_id)
                ->where('tb_risk_assessment_points.request_id','=',$r_id)
                // ->where('tb_risk_assessment_points.status','=',1)
                ->get();


                $data1 = array(
                    'request_id'  => $r_id,
                    'page'        => 'modify',
                    'dept_id'     =>   $dept_id,
                    'risk_assessor_id'  => $total[0]->responsibility

                );

                return View::make('changes/update-risk-analysis-sheet')->with($data1);




        }else if($modify_id == 4 && $r_id!= ""){
            $total  = DB::table('Customer_Communication_Decision')
                //->select(DB::raw('count(risk_assessment_id) as total'))
                ->select('Customer_Communication_Decision.*')
                ->where('Customer_Communication_Decision.request_id','=',$r_id)
                // ->where('tb_risk_assessment_points.status','=',1)
                ->get();

            $data1 = array(
                'request_id'  => $r_id,
                'page'        => 'modify',
                'custCommPer'   => $total[0]->user_id
            );



            return View::make('changes/customer-communication-decision_attachments')->with($data1);

        }else if($modify_id == 5 && $r_id != ""){
            $total  = DB::table('tb_risk_assessment_points')
                //->select(DB::raw('count(risk_assessment_id) as total'))
                ->select('tb_risk_assessment_points.*')
                ->where('tb_risk_assessment_points.risk_dep','=',$dept_id)
                ->where('tb_risk_assessment_points.request_id','=',$r_id)
                // ->where('tb_risk_assessment_points.status','=',1)
                ->get();
 
            $data1 = array(
                'request_id'  => $r_id,
                'page'        => 'modify',
                'dept_id'       =>$dept_id,
                'userId'        =>$total[0]->responsibility

            );
            
            return View::make('changes/activity-monitoring')->with($data1);

        }else if($modify_id == 6 && $r_id != ""){
            $total  = DB::table('changerequests')
                //->select(DB::raw('count(risk_assessment_id) as total'))
                ->select('changerequests.*')

                ->where('changerequests.request_id','=',$r_id)
                // ->where('tb_risk_assessment_points.status','=',1)
                ->get();

            $data=array(
              'request_id' =>$r_id,
                'initiator' =>$total[0]->initiator_id
            );
            return View::make('modifychangerequest/before-after-status-option')->with($data);

        }else if((!empty($file) OR !empty($deletefile))  && $uploadBy==""){


           $rId=Input::get('requestId');
            $custCommPer=Input::get('custCommPer');
            Session::put('r_id', $rId);
            Session::put('modify_id', 4);
           // Session::put('dept_id', $dept_id);

            $res=$this->uploaddoc($rId);
            if($res != "") {
                $data1 = array(
                    'request_id'  => $rId,
                    'page'        => 'modify',
                    'custCommPer'              =>$custCommPer
                );

                return View::make('changes/customer-communication-decision_attachments')->with($data1);
            }
        }else if((!empty($file) OR !empty($deletefile)) &&  $uploadBy=="activity_upload"){

            $rId=Input::get('request_Id');
            $dept_id=Input::get('dept_id');
            $userId=Input::get('user_id');

            Session::put('r_id', $rId);
            Session::put('modify_id', 5);
            Session::put('dept_id', $dept_id);


            $proId="";

            $res=$this->uploaddoc_activity_monitoring_file($rId,$proId);
            if($res != ""){
                $data1 = array(
                    'request_id'  => $rId,
                    'page'        => 'modify',
                    'dept_id'       =>$dept_id,
                    'userId'        =>$userId

                );
                return View::make('changes/activity-monitoring')->with($data1);
            }
        }else{
            return Redirect::to('modifyChangeRequest');
        }

    }
        public function changeRequestedit(){
            $modify_id =Session::get('modify_id');
            $r_id=Session::get('r_id');
            $dept_id=Session::get('dept_id');




            if ($modify_id == 1 && $r_id!= "") {
                $data = array(
                    'request_id'  => $r_id,
                    'page'        => 'modify',

                );

                if ($this->check_permission(1)) {
                    return View::make('changes/change_request_edit')->with($data);
                } else {

                    return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
                }

            }else if($modify_id == 2 && $r_id != ""){
                $total  = DB::table('changerequests')
                    //->select(DB::raw('count(risk_assessment_id) as total'))
                    ->select('changerequests.*')

                    ->where('changerequests.request_id','=',$r_id)
                    // ->where('tb_risk_assessment_points.status','=',1)
                    ->get();

                $data=array(
                    'page'      => 'modifyByAdmin',
                    'request_id' =>$r_id,
                    'initiator' =>$total[0]->initiator_id
                );
                return View::make('changes/updateinitia_information_sheet')->with($data);

            }else if($modify_id == 3 && $dept_id != "" && $r_id!= ""){

                $total  = DB::table('tb_risk_assessment_points')
                    //->select(DB::raw('count(risk_assessment_id) as total'))
                    ->select('tb_risk_assessment_points.*')
                    ->where('tb_risk_assessment_points.risk_dep','=',$dept_id)
                    ->where('tb_risk_assessment_points.request_id','=',$r_id)
                    // ->where('tb_risk_assessment_points.status','=',1)
                    ->get();


                $data1 = array(
                    'request_id'  => $r_id,
                    'page'        => 'modify',
                    'dept_id'     =>   $dept_id,
                    'risk_assessor_id'  => $total[0]->responsibility

                );

                return View::make('changes/update-risk-analysis-sheet')->with($data1);




            }else if($modify_id == 4 && $r_id!= ""){
                $total  = DB::table('Customer_Communication_Decision')
                    //->select(DB::raw('count(risk_assessment_id) as total'))
                    ->select('Customer_Communication_Decision.*')
                    ->where('Customer_Communication_Decision.request_id','=',$r_id)
                    // ->where('tb_risk_assessment_points.status','=',1)
                    ->get();

                $data1 = array(
                    'request_id'  => $r_id,
                    'page'        => 'modify',
                    'custCommPer'   => $total[0]->user_id
                );

                return View::make('changes/customer-communication-decision_attachments')->with($data1);

            }else if($modify_id == 5 && $r_id != ""){
                $total  = DB::table('tb_risk_assessment_points')
                    //->select(DB::raw('count(risk_assessment_id) as total'))
                    ->select('tb_risk_assessment_points.*')
                    ->where('tb_risk_assessment_points.risk_dep','=',$dept_id)
                    ->where('tb_risk_assessment_points.request_id','=',$r_id)
                    // ->where('tb_risk_assessment_points.status','=',1)
                    ->get();

                $data1 = array(
                    'request_id'  => $r_id,
                    'page'        => 'modify',
                    'dept_id'       =>$dept_id,
                    'userId'        =>$total[0]->responsibility

                );
                return View::make('changes/activity-monitoring')->with($data1);

            }else if($modify_id == 6 && $r_id != ""){

                $total  = DB::table('changerequests')
                    //->select(DB::raw('count(risk_assessment_id) as total'))
                    ->select('changerequests.*')

                    ->where('changerequests.request_id','=',$r_id)
                    // ->where('tb_risk_assessment_points.status','=',1)
                    ->get();

                $data=array(
                    'request_id' =>$r_id,
                    'initiator' =>$total[0]->initiator_id
                );
                return View::make('modifychangerequest/before-after-status-option')->with($data);

            }else{
                return Redirect::to('modifyChangeRequest');
            }
        }


    public function beforeAfterView($id)
    {

            $data=array(
                'request_id' =>$id
            );
            return View::make('modifychangerequest/before-after-status-option')->with($data);



    }

    public function checkUserDefined()
        {
                $input = (object)Input::all();
              $total = DB::table('tb_updatesheet_dep_team')
                    ->select(DB::raw('count(update_sheet_dep_id) as total'))
                    //->select('tb_risk_assessment_points.*')
                    ->where('tb_updatesheet_dep_team.request_id', '=',  $input->request_id)
                    //->where('tb_risk_assessment_points.status', '=', 1)
                    ->get();

                if ($total[0]->total >= 1) {
                    return 1;

                }else{
                    return 0;
                }
        }


        public function riskAssessFill()
        {
                $input = (object)Input::all();
              $total = DB::table('tb_risk_assessment_points')
                    ->select(DB::raw('count(risk_assessment_id) as total'))
                   ->where('tb_risk_assessment_points.risk_dep', '=', $input->dept_id)
                    ->where('tb_risk_assessment_points.request_id', '=',  $input->request_id)
                    ->get();

                if ($total[0]->total >= 1) {
                    return 1;

                }else{
                    return 0;
                }
        }

    public function getCustCommDecision()
    {
        $input = (object)Input::all();

        $total = DB::table('Customer_Communication_Decision')
            ->select(DB::raw('count(id) as total'))
            ->where('Customer_Communication_Decision.request_id', '=',  $input->request_id)
            ->get();

        if ($total[0]->total >= 1) {
            return 1;

        }else{
            return 0;
        }
    }

    public function getCustverification()
    {
        $input = (object)Input::all();

        $total = DB::table('Customer_Communication_list')
            ->select(DB::raw('count(id) as total'))
            ->where('Customer_Communication_list.request_id', '=',  $input->request_id)
            ->get();

       

        if ($total[0]->total >= 1) {
            return 1;

        }else{
            return 0;
        }
    }

    public function deptAvilable(){
       $input = (object)Input::all();
        $total = DB::table('add_updated_risk_assessment_sheet')
            ->select(DB::raw('count(id) as total'))
            ->where('add_updated_risk_assessment_sheet.r_id', '=',  $input->request_id)
            ->where('add_updated_risk_assessment_sheet.user_department', '=',  $input->dept_id)
            ->get();
            echo $total[0]->total;
    }

    public function getBeforeAfterStatus()
    {
        $input = (object)Input::all();

        $total = DB::table('befor_after_status_option_attachment')
            ->select(DB::raw('count(id) as total'))
            ->where('befor_after_status_option_attachment.request_id', '=',  $input->request_id)
            ->get();

        if ($total[0]->total >= 1) {
            return 1;

        }else{
            return 0;
        }
    }

    
public function fetch_changed_file($id)
{
    $input = (object)Input::all();
    $total = DB::table('befor_after_status_option_attachment')
        ->select('befor_after_status_option_attachment.*')
        ->where('befor_after_status_option_attachment.request_id', '=', $id)
        ->get();
    foreach($total as $row) {
        $data[] = array(
            'post_date' => $row->post_date,
            'file_id'   =>$row->id,
            'r_id'   =>$row->request_id,
            'attach_file' => $row->attachment_file,
            'total'=>$this->total_file($id)
        );
    }
    return $data;
}
public function total_file($id){
    $total = DB::table('befor_after_status_option_attachment')
        ->select(DB::raw('count(id) as total'))
        ->where('befor_after_status_option_attachment.request_id', '=', $id)
        ->get();
    return $total[0]->total;
}

    public function fetch_changed_date($id)
    {

        $input = (object)Input::all();

        $total = DB::table('befor_after_status_option_attachment')
            ->select('befor_after_status_option_attachment.*')
            ->where('befor_after_status_option_attachment.request_id', '=', $id)
            ->orderBy('befor_after_status_option_attachment.id', 'DECS')
            ->get();


            $data = array(
                'post_date' => $total[0]->post_date,
                'attach_file' => $total[0]->attachment_file
            );


        return $data;
    }
    public function deleteRecord($id,$r_id,$file)
    {

        $input = (object)Input::all();

        if (!empty($id)) {
         DB::table('befor_after_status_option_attachment')->where('id', $id)->delete();
            $filename = Config::get('app.site_root'). '/uploads/before_after_status_option_attachment/'.$file;

            if (File::exists($filename)) {
                File::delete($filename);
            }



        }
        $data=array(
            'request_id' =>$id
        );
        return View::make('modifychangerequest/before-after-status-option')->with($data);exit;
    }
    public function before_after_status_option_by_admin($id){


        $input = (object)Input::all();

       DB::table('befor_after_status_option_attachment')
       ->where('request_id',$id)
       ->update(['post_date' => $input->startdate]);
      
        $destinationPath = 'uploads/before_after_status_option_attachment'; // upload path


        $file=(Input::hasFile('doc'));

        if(!empty($file)) {
            if (Input::hasFile('doc')) {
                $files = Input::file('doc');

                //  print_r($files);exit;

                foreach ($files as $file) {


                    $extension = $file->getClientOriginalName();

                    $filename = rand(11111, 99999) . '-' . $extension; // renameing image


                    $upload_success = $file->move($destinationPath, $filename);

                    $this->save_before_after_status_attachments($filename, $input->startdate, $id);
                }
            }
        }
        $input="";
        $data=array(
            'request_id' =>$id
        );
        //return View::make('modifychangerequest/before-after-status-option')->with($data);
        return Redirect::to('modifyChangeRequest');

    }


}
