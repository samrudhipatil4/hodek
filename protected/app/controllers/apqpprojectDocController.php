<?php

class apqpprojectDocController extends BaseController  {

	//protected $layout = "layouts.main";
	
	public function project_dct_report(){

        if(Auth::check()):
              return View::make('ProjectDocReport/ganttChart');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    
  public function getProjDocReport(){
      $input=Input::all();
      
      $prjAvl = DB::table('apqp_draft_project_plan')
          ->select('apqp_draft_project_plan.*')
          ->where('project_id',$input['proj_no'])
          ->where('release_project',1)
          ->orderBy('id','asc')
          ->get();
      $data = DB::table('apqp_user_task_details')
          ->select('apqp_user_task_details.*')
          ->where('project_id',$input['proj_no'])
          ->get();
        //   echo"<pre>";
        // print_r($data);
        //   exit;
          $project_id=$input['proj_no'];
          foreach ($prjAvl as $value) {
            $alldata[] = array(
           'd_id' => $value->id,
           'project_id' => $value->project_id,
           'gate_id'    => $value->gate_id,
           'activity'   => $value->activity,
           'gate_name'  => $this->getGateName($value->gate_id),
          'activity_name'  => $this->getactivity($value->activity),
          'prev_reference_act'    => $value->prev_reference_act,
          'responsibility'    => $value->responsibility,
          'getUserName'       => $this->getuserName($value->responsibility),
          'activity_start_date' => $value->activity_start_date,
          'activity_end_date' => $value->activity_end_date,
          'mat_name'          =>$this->getMatName($value->material_id),
          'material_id'  =>  $value->material_id,
          'document'     =>  $this->getdocument($value->id),
          'remark'      =>  $this->getRemark($value->id,$project_id)

          );
          }
          foreach ($data as $d1) {
             $alldata1[] = array(
            'activity_id' =>$d1->activity_id,
            'gate_id' =>$d1->gate_id,
            'actual_start_date' => $d1->actual_start_date
          );
          }
        // echo "<pre>";
        //   print_r($alldata);exit;  
         $prjDetails =[];
          $prjDetails =   array(
              'checkDrop' => $this->getCheckDrop($project_id),
              'projectDts'=>$this->getProjectById($project_id),
              'checkHold' =>$this->getCheckHold($project_id)
            );


           $projReviewdata = DB::table('apqp_project_review'
      )->join('apqp_new_project_info as anpi','anpi.id','=','apqp_project_review.project_id')
       ->select('apqp_project_review.review_id','project_id','anpi.project_no')
        ->where('project_id',$input['proj_no'])
        ->distinct('project_id')
        ->get();
        $reviewData=[];
        if(!empty($projReviewdata)){
      foreach($projReviewdata as $val){
      $reviewData[] = array(
        'project_no' => $val->project_no,
        'allreview'       => $this->getAllReview($val->project_id),
        'reviewMember'   => $this->getReviewMember($val->project_id),
         'reviewfile'   => $this->getReviewFile($val->project_id)
        );
      }
    }


    $lessonProj = DB::table('apqp_project_lesson')
                ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_project_lesson.project_id')
                 ->join('plant_code','plant_code.plant_id','=','apqp_new_project_info.mfg_location')
                ->select('project_no','project_name','project_start_date','plant_code','project_id')
                ->groupby('project_id')
                ->orderby('project_id');
                if($input['proj_no'] != '')
             $lessonProj->where('apqp_project_lesson.project_id',$input['proj_no']);
                

                $lesson=  $lessonProj->get();
              $lessondata = [];
          foreach ($lesson as $row) {
              $lessondata[]  = array(
                'Project_no' => $row->project_no,
                'project_name'=> $row->project_name,
                'mfg_location' => $row->plant_code,
                'lesson' => $this->getProjectLesson($row->project_id),
                'proj_start_date' => $row->project_start_date,
                );
        }


        
          if(!empty($prjAvl)){

            return View::make('ProjectDocReport/projectDocReport',compact('alldata','project_id','prjDetails','reviewData','lessondata','alldata1'));
          }
    }

    public function getDocReportById(){
      $input=Input::all();
      
      $prjAvl = DB::table('apqp_draft_project_plan')
          ->select('apqp_draft_project_plan.*')
          ->where('project_id',$input['prjId'])
          ->where('release_project',1)
          ->orderBy('id','asc')
          ->get();
          $project_id=$input['prjId'];
          foreach ($prjAvl as $value) {
            $alldata[] = array(
           'd_id' => $value->id,
           'project_id' => $value->project_id,
           'gate_id'    => $value->gate_id,
           'gate_name'  => $this->getGateName($value->gate_id),
           'activity_name'  => $this->getactivity($value->activity),
          'prev_reference_act'    => $value->prev_reference_act,
          'responsibility'    => $value->responsibility,
          'getUserName'       => $this->getuserName($value->responsibility),
          'activity_start_date' => $value->activity_start_date,
          'activity_end_date' => $value->activity_end_date,
          'mat_name'          =>$this->getMatName($value->material_id),
          'material_id'  =>  $value->material_id,
          'document'     =>  $this->getdocument($value->id),
          'remark'      =>  $this->getRemark($value->id,$project_id)

          );
          }

         $prjDetails =[];
          $prjDetails =   array(
              'checkDrop' => $this->getCheckDrop($project_id),
              'projectDts'=>$this->getProjectById($project_id),
              'checkHold' =>$this->getCheckHold($project_id)
            );


           $projReviewdata = DB::table('apqp_project_review'
      )->join('apqp_new_project_info as anpi','anpi.id','=','apqp_project_review.project_id')
       ->select('apqp_project_review.review_id','project_id','anpi.project_no')
        ->where('project_id',$input['prjId'])
        ->distinct('project_id')
        ->get();
        $reviewData=[];
        if(!empty($projReviewdata)){
      foreach($projReviewdata as $val){
      $reviewData[] = array(
        'project_no' => $val->project_no,
        'allreview'       => $this->getAllReview($val->project_id),
        'reviewMember'   => $this->getReviewMember($val->project_id),
         'reviewfile'   => $this->getReviewFile($val->project_id)
        );
      }
    }


    $lessonProj = DB::table('apqp_project_lesson')
                ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_project_lesson.project_id')
                 ->join('plant_code','plant_code.plant_id','=','apqp_new_project_info.mfg_location')
                ->select('project_no','project_name','project_start_date','plant_code','project_id')
                ->groupby('project_id')
                ->orderby('project_id');
                if($input['prjId'] != '')
             $lessonProj->where('apqp_project_lesson.project_id',$input['prjId']);
                

                $lesson=  $lessonProj->get();
              $lessondata = [];
          foreach ($lesson as $row) {
              $lessondata[]  = array(
                'Project_no' => $row->project_no,
                'project_name'=> $row->project_name,
                'mfg_location' => $row->plant_code,
                'lesson' => $this->getProjectLesson($row->project_id),
                'proj_start_date' => $row->project_start_date,
                );
        }


        
          if(!empty($prjAvl)){

            return View::make('ProjectDocReport/projectDocReport',compact('alldata','project_id','prjDetails','reviewData','lessondata'));
          }
    }

    public function getProjectLesson($project_id) {
      $checkProj = DB::table('apqp_project_lesson')
                    ->select('lesson')
                    ->where('project_id',$project_id)
                    ->get();
    if(!empty($checkProj)){
      return $checkProj;
    }
 }

     public function getAllReview($proj_id){

    $data = array(
        'gate' => $this->getGateInfo($proj_id),
        'reviewDatecomment' =>$this->reviewDatecomment($proj_id),
      

      );
    return $data;
    
  }
  public function getGateInfo($proj_id){
    $data = DB::table('apqp_project_review'
      )->join('apqp_gate_management_master as agmm','agmm.id','=','apqp_project_review.gate_id')
        ->select('agmm.Gate_Description')
        ->where('project_id',$proj_id)
        ->whereNotNull('apqp_project_review.gate_id')
        ->where('agmm.Is_Active',1)
        ->get();
    return $data;

  }

public function getReviewMember($proj_id){

     $data = DB::table('apqp_project_review'
      ) ->select('apqp_project_review.review_id')
        ->where('project_id',$proj_id)
        ->get();

        $team=[];
        foreach($data as $key){
  $team[]=  $data = DB::table('apqp_project_review_teammember'
      )   ->join('tb_users','tb_users.id','=','apqp_project_review_teammember.team_member')
          ->select('tb_users.first_name','tb_users.last_name')
        ->where('review_id',$key->review_id)
        ->get();
        }

    return $team;
    
  }
public function getReviewFile($proj_id){

     $data = DB::table('apqp_project_review'
      ) ->select('apqp_project_review.review_id')
        ->where('project_id',$proj_id)
        ->get();

        $team=[];
        foreach($data as $key){
    $team[]=  $data = DB::table('apqp_project_review_file'
      )   ->select('apqp_project_review_file.file_name')
        ->where('review_id',$key->review_id)
        ->get();
        }

    return $team;
    
}
  public function reviewDatecomment($proj_id){
    $data = DB::table('apqp_project_review'
      ) ->select('apqp_project_review.comment','apqp_project_review.review_date')
        ->where('project_id',$proj_id)
        ->get();
    return $data;

  }

    public function getRemark($id,$pid){
      
      $data=DB::table('apqp_all_task')
            ->select("apqp_all_task.id")
            ->where('activity_id_as_per_drft',$id)
            ->where('project_id',$pid)
            ->get();
         
        if(!empty($data)){
            $remarkval=DB::table('apqp_user_task_details')
            ->select('apqp_user_task_details.remark')
            ->where('act_id',$data[0]->id)
            ->first();
          }
           
          if(!empty($remarkval)){
            return $remarkval->remark;
          }
    }

    public function getCheckDrop($pid){
    $data = DB::table('apqp_drop_project')
        ->leftJoin('tb_users','tb_users.id','=','apqp_drop_project.drop_proj_user_id')
        ->select('tb_users.first_name','tb_users.last_name','apqp_drop_project.remark')
        ->where('project_id',$pid)
        ->get();
        if(!empty($data)){
          return $data;
        }
    }
    public function getCheckHold($pid){
      $checkHold = DB::table('apqp_new_project_info')
                  ->select('hold_project')
                  ->where('id', $pid)
                  ->get();
                    if($checkHold[0]->hold_project == 1){
                      $hold= 'Is On Hold.';
                    }else{
                       $hold='';
                    }
                 
                  return $hold;
               
  }

    function getProjectById($project_id){
    return DB::table('apqp_new_project_info')
            ->join('plant_code', 'plant_code.plant_id', '=', 'apqp_new_project_info.mfg_location')
            ->select('apqp_new_project_info.*', 'plant_code.plant_code', 'plant_code.description')
            ->where('apqp_new_project_info.id', $project_id)
            ->first();
      
  }
    public function getdocument($id){
      $data=DB::table('apqp_all_task')
            ->select("apqp_all_task.id")
            ->where('activity_id_as_per_drft',$id)
            ->get();
         

        if(!empty($data)){
            $data3=DB::table('apqp_user_task_details')
            ->select('apqp_user_task_details.*')
            ->where('act_id',$data[0]->id)
            ->get();
          }
       
        if(!empty($data) && !empty($data3)){
          foreach ($data3 as $key) {
           
          $data1[] = array(
            'id' => $id,
            'parameter' => $key->risk,
            'action'    => $key->action,
            'cost'      => $key->cost,
            'issue'     => $key->issue,
            'doc'    => $this->getDoc($data[0]->id,$key->parameter),
            'issuedoc'    => $this->getIssueDoc($data[0]->id,$key->parameter),
         
           );
        }
 
          if(!empty($data1)){
          return $data1;
        }

        }
    }

    public function getDoc($id,$param){

      $data2[]=DB::table('apqp_user_task_document')
           
            ->select("apqp_user_task_document.act_id",'apqp_user_task_document.upload_doc','apqp_user_task_document.updated_doc_remark','apqp_user_task_document.updated_date')
            ->where('act_id',$id)
            ->where('parameter',$param)
            ->get();


            if(!empty($data2)){
              return $data2;
            }

    }

    public function getIssueDoc($id,$param){

      $data2[]=DB::table('apqp_activity_issue_document')
            ->select("apqp_activity_issue_document.act_id",'apqp_activity_issue_document.issue_document')
            ->where('act_id',$id)
            ->where('parameter',$param)
            ->get();

            if(!empty($data2)){
              return $data2;
            }
    }

  public function getactivity($act){
    if (strpos($act, 'a') !== false) {
    $data = DB::table('apqp_activity_as_per_project')
        ->select('pactivity')
        ->where('p_act_id',$act)
        ->get();
        if(!empty($data)){
           return $data[0]->pactivity;
        }
       
      }else{
        $data = DB::table('apqp_gate_activity_master')
        ->select('apqp_gate_activity_master.activity')
        ->where('id',$act)
        ->get();
        if(!empty($data)){
        return $data[0]->activity;
      }
      }
  }

  public function getGateName($gate_id){
    $data = DB::table('apqp_gate_management_master')
        ->select('apqp_gate_management_master.Gate_Description')
        ->where('id',$gate_id)
        ->get();
        return $data[0]->Gate_Description;
  }

  public function getUserName($id){
    if($id != ''){
    $data = DB::table('tb_users')
        ->select('tb_users.first_name','tb_users.last_name','tb_users.id')
        ->where('id',$id)
        ->get();
        return $data[0]->first_name.' '.$data[0]->last_name;
      }
  }

  public function getMatName($mat_id){
    $data = DB::table('apqp_material_master')
        ->select('material_description')
        ->where('id',$mat_id)
        ->get();
        if(!empty($data)){
        return $data[0]->material_description;
      }
  }

  public function download() {
        $data=array();
      
        $input = (object)Input::all();
        $prjAvl = DB::table('apqp_draft_project_plan')
          ->select('apqp_draft_project_plan.*')
          ->where('project_id',$input->proj_id)
          ->where('release_project',1)
           ->orderBy('id','asc')
          ->get();
        $data = DB::table('apqp_user_task_details')
          ->select('apqp_user_task_details.*')
          ->where('project_id',$input->proj_id)
          ->get();
          // echo "<pre>";
          // print_r($data);exit;
          $project_id=$input->proj_id;
          foreach ($prjAvl as $value) {
            $alldata[] = array(
           'd_id' => $value->id,
           'project_id' => $value->project_id,
           'gate_id'    => $value->gate_id,
           'activity'   => $value->activity,
           'gate_name'  => $this->getGateName($value->gate_id),
           'activity_name'  => $this->getactivity($value->activity),
          'prev_reference_act'    => $value->prev_reference_act,
          'responsibility'    => $value->responsibility,
          'getUserName'       => $this->getuserName($value->responsibility),
          'activity_start_date' => $value->activity_start_date,
          'activity_end_date' => $value->activity_end_date,
          'mat_name'          =>$this->getMatName($value->material_id),
          'material_id'  =>  $value->material_id,
          'document'     =>  $this->getdocument($value->id),
          'remark'      =>  $this->getRemark($value->id,$project_id)
          );
          }

          foreach ($data as $d1) {
             $alldata1[] = array(
            'activity_id' =>$d1->activity_id,
            'gate_id' =>$d1->gate_id,
            'actual_start_date' => $d1->actual_start_date
          );
          //  echo "<pre>";
          // print_r($alldata);exit;  
          }
        $date = date('Y-m-d');

         $prjDetails =[];
          $prjDetails =   array(
              'checkDrop' => $this->getCheckDrop($project_id),
              'projectDts'=>$this->getProjectById($project_id),
               'checkHold' =>$this->getCheckHold($project_id)
            );


          $projReviewdata = DB::table('apqp_project_review'
      )->join('apqp_new_project_info as anpi','anpi.id','=','apqp_project_review.project_id')
       ->select('apqp_project_review.review_id','project_id','anpi.project_no')
        ->where('project_id',$project_id)
        ->distinct('project_id')
        ->get();
        $reviewData=[];
        if(!empty($projReviewdata)){
      foreach($projReviewdata as $val){
      $reviewData[] = array(
        'project_no' => $val->project_no,
        'allreview'       => $this->getAllReview($val->project_id),
        'reviewMember'   => $this->getReviewMember($val->project_id),
         'reviewfile'   => $this->getReviewFile($val->project_id)
        );
      }
    }


    $lessonProj = DB::table('apqp_project_lesson')
                ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_project_lesson.project_id')
                 ->join('plant_code','plant_code.plant_id','=','apqp_new_project_info.mfg_location')
                ->select('project_no','project_name','project_start_date','plant_code','project_id')
                ->groupby('project_id')
                ->orderby('project_id');
                if($project_id != '')
             $lessonProj->where('apqp_project_lesson.project_id',$project_id);
                

                $lesson=  $lessonProj->get();
              $lessondata = [];
          foreach ($lesson as $row) {
              $lessondata[]  = array(
                'Project_no' => $row->project_no,
                'project_name'=> $row->project_name,
                'mfg_location' => $row->plant_code,
                'lesson' => $this->getProjectLesson($row->project_id),
                'proj_start_date' => $row->project_start_date,
                );
        }

        
        
        $filename='project_documentation-'.$date;
       
        if($input->filetype=='pdf') {

               // $pdf = App::make('dompdf');
               
          $filename1 = Config::get('app.site_root').'uploads/'.$filename;
 
          $pdf=PDF::loadView('ProjectDocReport/check', compact('alldata','project_id','prjDetails','reviewData','lessondata','alldata1'));
          $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
              // $pdf->save(storage_path($filename1));
          return $pdf->download($filename.'.pdf'); //forcely download
        }elseif($input->filetype=='excel'){

          $output =  View::make('ProjectDocReport/csv_download',compact('alldata','project_id','prjDetails','reviewData','lessondata','alldata1'));
        
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




        return Redirect::to('project_dct_report')->with(compact('data'));


    }
			
	
}	