<?php
unset($_SESSION['btntype']);
class lessonlearnedreportController extends BaseController  {

	//protected $layout = "layouts.main";
	
	
	public function index(){
        if(Auth::check()):
         return View::make('apqpLessonLearnedReport/lesson_learnedReport');
      else:
         return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
        endif;
  }
  public function getLesson(){
    
    $data=array();
      $input = (object)Input::all();
     
  $checkProj = DB::table('apqp_project_lesson')
                ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_project_lesson.project_id')
                 ->join('plant_code','plant_code.plant_id','=','apqp_new_project_info.mfg_location')
                ->select('project_no','project_name','project_start_date','plant_code','project_id')
                ->groupby('project_id')
                ->orderby('project_id');
                if($input->proj_no != '')
             $checkProj->where('apqp_project_lesson.project_id',$input->proj_no);
                

                $lesson=  $checkProj->get();
              
          foreach ($lesson as $row) {
              $data[]  = array(
                'Project_no' => $row->project_no,
                'project_name'=> $row->project_name,
                'mfg_location' => $row->plant_code,
                'lesson' => $this->getProjectLesson($row->project_id),
                'proj_start_date' => $row->project_start_date,
               'checkDrop' => $this->getCheckDrop($row->project_id),
         'checkHold' =>$this->getCheckHold($row->project_id)


                );
        }
    
      //echo "<pre>";print_r($data);exit();

       $formInput=array(
              'proj_no' =>$input->proj_no,
                );


        if ($this->check_permission(1)) {
            return View::make('apqpLessonLearnedReport/summery_sheet',compact('data','formInput'));
        } else {

            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
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
   
	
 public function getProjectLesson($project_id) {
  $checkProj = DB::table('apqp_project_lesson')
                    ->select('lesson')
                    ->where('project_id',$project_id)
                    ->get();
    if(!empty($checkProj)){
      return $checkProj;
    }
 }

 public function downloadReport(){
  $input = (object)Input::all();
    // print_r($input);exit();
  $checkProj = DB::table('apqp_project_lesson')
                ->join('apqp_new_project_info','apqp_new_project_info.id','=','apqp_project_lesson.project_id')
                 ->join('plant_code','plant_code.plant_id','=','apqp_new_project_info.mfg_location')
                ->select('project_no','project_name','project_start_date','plant_code','project_id')
                ->groupby('project_id');

                if($input->proj_no != '')
             $checkProj->where('apqp_project_lesson.project_id',$input->proj_no);
                

                $lesson=  $checkProj->get();
              
          foreach ($lesson as $row) {
              $data[]  = array(
                'Project_no' => $row->project_no,
                'project_name'=> $row->project_name,
                'mfg_location' => $row->plant_code,
                'lesson' => $this->getProjectLesson($row->project_id),
                'proj_start_date' => $row->project_start_date,
                'checkDrop' => $this->getCheckDrop($row->project_id),
         'checkHold' =>$this->getCheckHold($row->project_id)


                );
        }

        $date = date('Y-m-d');

        $filename='lessonlearnedReport-'.$date;
        if($input->filetype=='pdf') {

                // $pdf = App::make('dompdf');

                $pdf=PDF::loadView('apqpLessonLearnedReport/check', compact('data'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){
                // echo"<pre>";print_r($data);exit;
                $output =  View::make('apqpLessonLearnedReport/csv_download',compact('data'));

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




        return Redirect::to('lesson_learned_report')->with(compact('data'));

 }

			
	
}	