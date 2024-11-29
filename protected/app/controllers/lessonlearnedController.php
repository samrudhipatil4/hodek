<?php
unset($_SESSION['btntype']);
class lessonlearnedController extends BaseController  {

	//protected $layout = "layouts.main";
	
	
	public function index(){
        if(Auth::check()):
         return View::make('apqpTask/lesson_learned');
      else:
         return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
        endif;
  }
  public function saveLesson(){
    if (Request::isJson()) {
      $input = (object)Input::all();
      $checkProj = DB::table('apqp_project_lesson')
                    ->select('project_id')
                    ->where('project_id',$input->proj_no)
                    ->get();
              if(empty($checkProj))      {
      foreach ($input->lesson as $value) {
                  DB::table('apqp_project_lesson')->insert(
                      array(
                        'project_id' =>$input->proj_no,
                        'lesson'  => $value['lesson'],
                        'CreatedDate' => date('Y-m-d H:i:s'),

                      )
                  );

              }
            }else{
              DB::table('apqp_project_lesson')
                    ->where('project_id',$input->proj_no)
                    ->delete();
              foreach ($input->lesson as $value) {
                   DB::table('apqp_project_lesson')->insert(
                      array(
                        'project_id' =>$input->proj_no,
                        'lesson'  => $value['lesson'],
                        'UpdatedDate' => date('Y-m-d H:i:s'),

                      )
                  );

              }
            }
      }
    }
	
 public function getLessonByProj($project_id) {
  $checkProj = DB::table('apqp_project_lesson')
                    ->select('lesson')
                    ->where('project_id',$project_id)
                    ->get();
    if(!empty($checkProj)){
      return $checkProj;
    }
 }

	public function getProject(){
    $data =DB::select(DB::raw('select * from apqp_new_project_info as a where   project_revision = (select max(project_revision) from apqp_new_project_info as b  where a.project_no=b.project_no )  and a.id NOT IN(select project_id from apqp_drop_project) 

and a.id IN(select project_id from apqp_draft_project_plan where release_project= 1) order by id '));
  
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