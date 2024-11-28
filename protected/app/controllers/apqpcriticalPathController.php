<?php

class apqpcriticalPathController extends BaseController  {

	//protected $layout = "layouts.main";
	
	public function critical_path(){

        if(Auth::check()):
              return View::make('apqpCriticalPath/ganttChart');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    
    public function getCriticalPathReport(){
      $input=Input::all();
      
      $prjAvl = DB::table('apqp_draft_project_plan')
          ->leftJoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
          ->select('apqp_draft_project_plan.*','apqp_gate_activity_master.lead_time')
          ->where('project_id',$input['proj_no'])
          ->where('release_project',1)
          ->where('prev_reference_act','=','')
          ->orderBy('activity')
          ->get();

          $project_id=$input['proj_no'];
          foreach ($prjAvl as $value) {
            $withoutPrevAct[] = array(
           'aid' => $value->activity,
           'duration' => $value->lead_time,
           'prev_act'    => $value->prev_reference_act,
           'mat_id'  => $this->getMatName($value->lead_time),
          
          );
          }

           $prjAvl1 = DB::table('apqp_draft_project_plan')
          ->leftJoin('apqp_gate_activity_master','apqp_gate_activity_master.id','=','apqp_draft_project_plan.activity')
          ->select('apqp_draft_project_plan.*','apqp_gate_activity_master.lead_time')
          ->where('project_id',$input['proj_no'])
          ->where('release_project',1)
          ->where('prev_reference_act','!=','')
          ->orderBy('prev_reference_act')
          ->get();

          $project_id=$input['proj_no'];
          foreach ($prjAvl1 as $value) {
            $withPrevAct[] = array(
           'aid' => $value->activity,
           'duration' => $value->lead_time,
           'prev_act'    => $value->prev_reference_act,
           'mat_id'  => $this->getMatName($value->lead_time),
          
          );
          }

          if(!empty($prjAvl) && !empty($prjAvl1)){

            return View::make('apqpCriticalPath/activitytbl',compact('withPrevAct','withoutPrevAct','project_id'));
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
          ->orderBy('gate_id')
           ->orderBy('material_id')
          ->get();
          $project_id=$input->proj_id;
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
          );
          }
        $date = date('Y-m-d');
        
        
$filename='project_documentation-'.$date;
       
            if($input->filetype=='pdf') {

               // $pdf = App::make('dompdf');
               
 $filename1 = Config::get('app.site_root').'uploads/'.$filename;
 
                $pdf=PDF::loadView('ProjectDocReport/check', compact('alldata','project_id'));
                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
              // $pdf->save(storage_path($filename1));
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){

                $output =  View::make('ProjectDocReport/csv_download',compact('alldata','project_id'));
        
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




        return Redirect::to('trackingSheet')->with(compact('data'));


    }
			
	
}	