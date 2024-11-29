<?php

class apqpBudgetVsActualCostController extends BaseController  {

	//protected $layout = "layouts.main";
	
	public function budgetvsactual_report(){

        if(Auth::check()):
              return View::make('apqpBudgetVsCostReport/ganttChart');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    
    public function getCostReport(){
      $input=Input::all();
      
      $prjAvl = DB::table('apqp_draft_project_plan')
          ->select('apqp_draft_project_plan.*')
          ->where('project_id',$input['proj_no'])
          ->where('release_project',1)
          ->orderBy('id','asc')
         // ->orderBy('material_id')
          ->get();
          $totbudgetCost = 0;
           $totactualCost = 0;
           $totmanpowercost =0;
          $project_id=$input['proj_no'];
          foreach ($prjAvl as $value) {
            $totbudgetCost = $totbudgetCost+$value->cost;
            $alldata[] = array(
           'd_id' => $value->id,
           'project_id' => $value->project_id,
           'gate_id'    => $value->gate_id,
           'gate_name'  => $this->getGateName($value->gate_id),
           'activity_name'  => $this->getactivity($value->activity),
          'prev_reference_act'    => $value->prev_reference_act,
          'responsibility'    => $value->responsibility,
          'getUserName'       => $this->getuserName($value->responsibility),
          'budgetCost'        => $value->cost,
          'mat_name'          =>$this->getMatName($value->material_id),
          'material_id'  =>  $value->material_id,
          'actualCost'     =>  $this->getActualCost($value->id),
          'manpowerCost'   => $this->getManpowerCost($value->id)
     
          );
            $manpowerCost   = $this->getManpowerCost($value->id);
             $totmanpowercost = $totmanpowercost+$manpowerCost[0]['hour'];
            $actualcost = $this->getActualCost($value->id);
             $totactualCost = $totactualCost+$actualcost[0]['cost'];

          }

         $prjDetails =[];
          $prjDetails =   array(
              'checkDrop' => $this->getCheckDrop($project_id),
              'projectDts'=>$this->getProjectById($project_id),
              'checkHold' =>$this->getCheckHold($project_id)
            );


         
           //echo '<pre>';print_r($prjDetails);exit();
          if(!empty($prjAvl)){

            return View::make('apqpBudgetVsCostReport/CostReport',compact('alldata','project_id','prjDetails','totbudgetCost','totactualCost','totmanpowercost'));
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
    public function getActualCost($id){
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
          $tot = 0;
          foreach ($data3 as $key) {
           
           $tot = $tot+ $key->cost;
          
        }
          $data1[] = array(
           
            'cost'      => $tot,
           
         
           );
          if(!empty($data1)){
          return $data1;
        }

        }
    }

    public function getManpowerCost($id){
      $data=DB::table('apqp_all_task')
            ->select("apqp_all_task.id",'apqp_all_task.assigned_to')
            ->where('activity_id_as_per_drft',$id)
            ->get();
         

        if(!empty($data)){
          $usercost =  $data3=DB::table('tb_users')
            ->select('tb_users.cost_per_hour')
            ->where('id',$data[0]->assigned_to)
            ->get();
            $data3=DB::table('apqp_user_task_details')
            ->select('apqp_user_task_details.*')
            ->where('act_id',$data[0]->id)
            ->get();
          }
       
        if(!empty($data) && !empty($data3)){
          $tot = 0;
          foreach ($data3 as $key) {
           
           $tot = $tot+ $key->hour;
          
        }
          $data1[] = array(
           
            'hour'      => $tot*$usercost[0]->cost_per_hour,
           
         
           );
          if(!empty($data1)){
          return $data1;
        }

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
       // print_r($input);exit();
       //$input=Input::all();
      
      $prjAvl = DB::table('apqp_draft_project_plan')
          ->select('apqp_draft_project_plan.*')
          ->where('project_id',$input->proj_id)
          ->where('release_project',1)
          ->orderBy('id','asc')
         // ->orderBy('material_id')
          ->get();
          $totbudgetCost = 0;
           $totactualCost = 0;
           $totmanpowercost =0;
          $project_id=$input->proj_id;
          foreach ($prjAvl as $value) {
            $totbudgetCost = $totbudgetCost+$value->cost;
            $alldata[] = array(
           'd_id' => $value->id,
           'project_id' => $value->project_id,
           'gate_id'    => $value->gate_id,
           'gate_name'  => $this->getGateName($value->gate_id),
           'activity_name'  => $this->getactivity($value->activity),
          'prev_reference_act'    => $value->prev_reference_act,
          'responsibility'    => $value->responsibility,
          'getUserName'       => $this->getuserName($value->responsibility),
          'budgetCost'        => $value->cost,
          'mat_name'          =>$this->getMatName($value->material_id),
          'material_id'  =>  $value->material_id,
          'actualCost'     =>  $this->getActualCost($value->id),
          'manpowerCost'   => $this->getManpowerCost($value->id)
     
          );
            $manpowerCost   = $this->getManpowerCost($value->id);
             $totmanpowercost = $totmanpowercost+$manpowerCost[0]['hour'];
            $actualcost = $this->getActualCost($value->id);
             $totactualCost = $totactualCost+$actualcost[0]['cost'];

          }

         $prjDetails =[];
          $prjDetails =   array(
              'checkDrop' => $this->getCheckDrop($project_id),
              'projectDts'=>$this->getProjectById($project_id),
              'checkHold' =>$this->getCheckHold($project_id)
            );
         $date = date('Y-m-d');
$filename='projectCostReport-'.$date;
       
            if($input->filetype=='pdf') {

               // $pdf = App::make('dompdf');
               
 $filename1 = Config::get('app.site_root').'uploads/'.$filename;
 
                $pdf=PDF::loadView('apqpBudgetVsCostReport/check', compact('alldata','project_id','prjDetails','totbudgetCost','totactualCost','totmanpowercost'));
                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
              // $pdf->save(storage_path($filename1));
                return $pdf->download($filename.'.pdf'); //forcely download
            }elseif($input->filetype=='excel'){

                $output =  View::make('apqpBudgetVsCostReport/csv_download',compact('alldata','project_id','prjDetails','totbudgetCost','totactualCost','totmanpowercost'));
        
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