<?php

class apqpProjectReviewController extends BaseController  {

	//protected $layout = "layouts.main";

  
	
	public function projectReview(){

        if(Auth::check()):
              return View::make('apqpProjectReview/ProjectReview');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    public function projectReview_Report(){
      if(Auth::check()):
              return View::make('apqpProjectReview/ganttChart');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

public function getGate($proj_id){
$temp = DB::table('apqp_new_project_info')
        ->select('template')
        ->where('id',$proj_id)
        ->get();

 $data = DB::table('apqp_gate_management_master')
        ->join('apqp_gate_activity_master','apqp_gate_activity_master.gate_id','=','apqp_gate_management_master.id')
        ->select('apqp_gate_management_master.*')
        ->where('apqp_gate_management_master.Is_Active',1)
        ->where('apqp_gate_activity_master.template',$temp[0]->template)
        ->groupBy('gate_id')
        ->orderby('id')
        ->get();

        return $data;
}

public function getTeamMember(){
    $data = DB::table('tb_users')
              ->select('id','first_name','last_name')
              ->where('active',1)
              ->get();
              return $data;
}


    public function addReview(){


      if($_POST['startdate_status']==''){
          $d_t='--';
      }else{
        $date1 = explode('/', $_POST['startdate_status']);
        $d_t = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
      }
      if($_POST['gate'] == ""){
        $gate = null;
      }else{
        $gate = $_POST['gate'];
      }
      DB::table('apqp_project_review')
      ->insert(
        array(
            'project_id' => $_POST['proj_no'],
            'gate_id' => $gate,
            'comment' => $_POST['comment'],
            'review_date' => $d_t ,
            'Created_Date' => date('Y-m-d H:i:s')
          )
        );
        $last_id = DB::getPdo()->lastInsertId();
        // $teammember =explode(",", $_POST['member']);

           foreach ($_POST['member'] as $value) {
          DB::table('apqp_project_review_teammember')->insert(
              array(
                  'review_id' =>$last_id ,
                  'team_member' => $value
                    )
                );

              }
      

         if (!empty($_FILES)) {
            $imageNameArray = array();
            $destinationPath = 'uploads/review_document'; // upload path
            if (Input::hasFile('uploadFile')) {
                $names = Input::file('uploadFile');
                foreach($names as $file) {
          $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $file->getClientOriginalName());      $filename = rand(11111, 99999) . '-' . $extension; 
    $upload_success = $file->move($destinationPath, $filename);

        DB::table('apqp_project_review_file')
        ->insert(
          array(
            'review_id' =>$last_id,
            'file_name'  =>$filename
            )
          );
     }
       echo json_encode($file); exit();
            }
        }
    }

    

   

  public function getProject(){
    $data =DB::select(DB::raw('select * from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1)  order by id '));
  
$project =[];
  if(!empty($data)){
            foreach ($data as $key) {
              $project[]=array(
              'id'=> $key->id,
              'project_no'=>$key->project_no.' Revision'.$key->project_revision
              );
            }
			}
      return $project;
	}

  public function getReviewReport(){
    $input = Input::all();
 if($input['proj_no'] == ""){
  $data = DB::table('apqp_project_review'
      )->join('apqp_new_project_info as anpi','anpi.id','=','apqp_project_review.project_id')
        ->select('apqp_project_review.review_id','project_id','anpi.project_no')
        ->groupBy('apqp_project_review.project_id')
        ->get();
  }else{
    $data = DB::table('apqp_project_review'
      )->join('apqp_new_project_info as anpi','anpi.id','=','apqp_project_review.project_id')
       ->select('apqp_project_review.review_id','project_id','anpi.project_no')
        ->where('project_id',$input['proj_no'])
        ->distinct('project_id')
        ->get();
  }

   // $prjDetails =[];
   //        $prjDetails =   array(
   //            'checkDrop' => $this->getCheckDrop($input['proj_no']),
   //            'projectDts'=>$this->getProjectById($input['proj_no']),
   //            'checkHold' =>$this->getCheckHold($input['proj_no'])
   //          );
          $project_id=$input['proj_no'];
          $alldata = [];
    foreach($data as $val){
      $alldata[] = array(
        'id' =>$val->project_id,
        'project_no' => $val->project_no,
        'allreview'       => $this->getAllReview($val->project_id),
        'reviewMember'   => $this->getReviewMember($val->project_id),
         'reviewfile'   => $this->getReviewFile($val->project_id),
         'checkDrop' => $this->getCheckDrop($val->project_id),
         'checkHold' =>$this->getCheckHold($val->project_id)
        );
    }
   // echo '<pre>';print_r($input);exit();
    
            return View::make('apqpProjectReview/reviewReport',compact('alldata','project_id'));
          

  }

  public function getAllReview($proj_id){

    $data = array(
        'gate' => $this->getGateInfo($proj_id),
        'reviewDatecomment' =>$this->reviewDatecomment($proj_id),
      

      );
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
                  $hold=[];
         if(!empty($checkHold)){
          if($checkHold[0]->hold_project == 1){
            $hold= 'Is On Hold.';
          }else{
             $hold='';
          }
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

  public function download() {
          $input = (object)Input::all();
 if($input->proj_no == ""){
  $data = DB::table('apqp_project_review'
      )->join('apqp_new_project_info as anpi','anpi.id','=','apqp_project_review.project_id')
        ->select('apqp_project_review.review_id','project_id','anpi.project_no')
        ->groupBy('apqp_project_review.project_id')
        ->get();
  }else{
    $data = DB::table('apqp_project_review'
      )->join('apqp_new_project_info as anpi','anpi.id','=','apqp_project_review.project_id')
       ->select('apqp_project_review.review_id','project_id','anpi.project_no')
        ->where('project_id',$input->proj_no)
        ->distinct('project_id')
        ->get();
  }

   $prjDetails =[];
          $prjDetails =   array(
              'checkDrop' => $this->getCheckDrop($input->proj_no),
              'projectDts'=>$this->getProjectById($input->proj_no),
              'checkHold' =>$this->getCheckHold($input->proj_no)
            );
          $project_id=$input->proj_no;
    foreach($data as $val){
     //echo'<pre>'; print_r($val);
      $alldata[] = array(
        'project_no' => $val->project_no,
        'allreview'       => $this->getAllReview($val->project_id),
        'reviewMember'   => $this->getReviewMember($val->project_id),
         'reviewfile'   => $this->getReviewFile($val->project_id),
          'checkDrop' => $this->getCheckDrop($val->project_id),
         'checkHold' =>$this->getCheckHold($val->project_id)
        );
    }
 //echo '<pre>';print_r($alldata);exit();
    
        $date = date('Y-m-d');

         $prjDetails =[];
          $prjDetails =   array(
              'checkDrop' => $this->getCheckDrop($project_id),
              'projectDts'=>$this->getProjectById($project_id),
               'checkHold' =>$this->getCheckHold($project_id)
            );
        
        
$filename='review_report-'.$date;
       
            if($input->filetype=='pdf') {

               // $pdf = App::make('dompdf');
               
 $filename1 = Config::get('app.site_root').'uploads/'.$filename;
 
                $pdf=PDF::loadView('apqpProjectReview/csv_download', compact('alldata','project_id','prjDetails'));
                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
              // $pdf->save(storage_path($filename1));
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){

                $output =  View::make('apqpProjectReview/csv_download',compact('alldata','project_id','prjDetails'));
        
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