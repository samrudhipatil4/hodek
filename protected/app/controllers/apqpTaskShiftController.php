<?php

class apqpTaskShiftController extends BaseController  {

  //protected $layout = "layouts.main";
  
  public function apqptaskShift(){

        if(Auth::check()):
              return View::make('apqpTaskShift/TaskShift');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }



public function getActivity($project_id,$gate){
  $data = DB::table('apqp_draft_project_plan')
  ->join('apqp_all_task','apqp_all_task.activity','=','apqp_draft_project_plan.activity')
  ->join('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
  ->select('apqp_gate_activity_master.id','apqp_gate_activity_master.activity')
  ->where('apqp_draft_project_plan.project_id',$project_id)
  ->where('apqp_draft_project_plan.gate_id',$gate)
  ->where('apqp_all_task.close',0)
  ->groupby('apqp_all_task.activity')
  ->get();
  if(!empty($data)){
    return $data;
  }

}

public function getapqpuser($activty,$proj_id,$gate){
$data = DB::table('apqp_draft_project_plan')
        ->select('tb_users.first_name','tb_users.last_name','tb_users.id')
        ->join('tb_users','tb_users.id','=','apqp_draft_project_plan.responsibility')
        ->where('project_id',$proj_id)
         ->where('activity',$activty)
         ->where('gate_id',$gate)
        ->get();
          if(!empty($data)){
            return $data;
          }
}

public function getAllUser(){
  $data = DB::table('tb_users')
          ->select('id','first_name','last_name')
          ->where('active',1)
          ->get();
          return $data;
}

public function shiftApqpUser(){
  $input = Input::all();
  
  DB::table('apqp_draft_project_plan')
  ->where('apqp_draft_project_plan.project_id',$input['proj_no'])
  ->where('apqp_draft_project_plan.gate_id',$input['gate'])
  ->where('apqp_draft_project_plan.activity',$input['activity'])
 // ->where('apqp_draft_project_plan.responsibility','=',$input['exist_userId'])
  ->update(
      [
        'responsibility'=> $input['new_user']
        ]
    );
  DB::table('apqp_all_task')
  ->where('apqp_all_task.project_id',$input['proj_no'])
  ->where('apqp_all_task.gate',$input['gate'])
  ->where('apqp_all_task.activity',$input['activity'])
  ->where('apqp_all_task.assigned_to',$input['exist_userId'])
  ->update(
      [
        'assigned_to'=>$input['new_user']
        ]
    );
}
  
  
} 