<?php

class apqpUploadActivityDocController extends BaseController  {

	//protected $layout = "layouts.main";
	
	public function uploadActivitydoc(){

        if(Auth::check()):
              return View::make('apqpUploadActivityDoc/UploadActivityDoc');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

public function getCompletedAct($proj_id,$gate){
  $data = DB::table('apqp_user_task_details')
          ->join('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_user_task_details.activity_id')
          ->select('apqp_gate_activity_master.id','apqp_gate_activity_master.activity')
          ->where('project_id',$proj_id)
          ->where('apqp_user_task_details.gate_id',$gate)
          ->groupby('apqp_user_task_details.activity_id')
          ->get();
          if(!empty($data)){

            return $data;
          }
}

public function getGateInfo($proj_id){
  $data = DB::table('apqp_draft_project_plan')
          ->join('apqp_gate_management_master','apqp_gate_management_master.id','=','apqp_draft_project_plan.gate_id')
          ->select('apqp_gate_management_master.id','apqp_gate_management_master.Gate_Description')
          ->where('project_id',$proj_id)
          ->groupby('apqp_draft_project_plan.gate_id')
          ->get();
          if(!empty($data)){
            return $data;
          }
}

public function getParam($activty,$proj_id){
  $data = DB::table('apqp_user_task_details')
          ->select('parameter','risk')
          ->where('project_id',$proj_id)
           ->where('activity_id',$activty)
          ->get();
          if(!empty($data)){
            return $data;
          }
}
    
    public function getProjDocReport(){
      $input=Input::all();
      
      $prjAvl = DB::table('apqp_draft_project_plan')
          ->select('apqp_draft_project_plan.*')
          ->where('project_id',$input['proj_no'])
          ->where('release_project',1)
          ->orderBy('id','asc')
         // ->orderBy('material_id')
          ->get();
          $project_id=$input['proj_no'];
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


         
           //echo '<pre>';print_r($prjDetails);exit();
          if(!empty($prjAvl)){

            return View::make('ProjectDocReport/projectDocReport',compact('alldata','project_id','prjDetails'));
          }
    }

    public function uploadFile($proj,$activity,$param){
      

         if (!empty($_FILES)) {


            $imageNameArray = array();

            $destinationPath = 'uploads/apqp_activity_document'; // upload path
        
    $act_id = DB::table('apqp_user_task_details')
      ->select('act_id','gate_id')
      ->where('project_id',$proj)
      ->where('activity_id',$activity)
      ->where('parameter',$param)
      ->get();

            if (Input::hasFile('uploadFile')) {

               
                $names = Input::file('uploadFile');
                
                foreach($names as $file) {

                    

                   $extension = preg_replace("/[^A-Za-z0-9\_\.]/", '', $file->getClientOriginalName());

                    $filename = rand(11111, 99999) . '-' . $extension; 

                 
          
                    
                    $upload_success = $file->move($destinationPath, $filename);

                    DB::table('apqp_user_task_document')
                    ->insert(
                      array(
                        'project_id' =>$proj,
                        'activity_id' =>$activity,
                        'act_id' =>$act_id[0]->act_id,
                            'gate_id'   => $act_id[0]->gate_id,
                        'upload_doc'  =>$filename,
                        'updated_doc_remark' =>$_POST['remark'],
                        'updated_date' => date("Y-m-d H:i:s"),
                        'parameter' => $param,
                        )
                      );
                }

                echo json_encode($file); exit();



            }
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
}	