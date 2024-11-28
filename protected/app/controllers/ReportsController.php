<?php

use Carbon\Carbon;
class ReportsController extends BaseController  {

			
	public function index()
    {

        $user_type = Session::get('gid');
        if($user_type!="") {

            return View::make('reports/reports');
        }
        else {
            return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
        }

		
	}	

	public function department()
	{
		
		//Returns All departments
		$departments = DB::table('tb_departments')->select('d_id','d_name')->get();
		
		return $departments;
   
 
	}

    public function get_report_type(){
        //Returns All departments
        return $reports = DB::table('report_types')->select('id','report_name')->get();



    }


    public function generate_report(){

       
        $input = (object)Input::all();
          $_SESSION['rportInput'] = $input;
        if(isset($input->customer_id1)&& !empty($input->customer_id1)){
            $customer_id=$input->customer_id1;

        }
        if(isset($input->d_id)&& !empty($input->d_id)){
            $department_id=$input->d_id;

        }
        if(isset($input->startdate)&& !empty($input->startdate)){
            $startdate=$input->startdate;
            $date1=explode('/',$startdate);
            $date = Carbon::create($date1[2], $date1[0], $date1[1]);

        }


       // $date =$date1[2].'/'.$date1[0].'/'.$date1[1];
        //echo $date;exit;
      //  $date= Carbon::parse($date)->toDateTimeString();
       // $data['header']=$this->get_report_name($input->report_type);

        return $data= $this->get_chart_report($input);



        /*
         *
         *
         * echo Carbon::parse('2015/03/30')->toDateTimeString(); //2015-03-30 00:00:00
echo Carbon::parse('2015-03-30')->toDateTimeString(); //2015-03-30 00:00:00
echo Carbon::parse('2015-03-30 00:10:25')->toDateTimeString(); //2015-03-30 00:10:25

echo Carbon::parse('today')->toDateTimeString(); //2015-07-26 00:00:00
echo Carbon::parse('yesterday')->toDateTimeString(); //2015-07-25 00:00:00
echo Carbon::parse('tomorrow')->toDateTimeString(); //2015-07-27 00:00:00
echo Carbon::parse('2 days ago')->toDateTimeString(); //2015-07-24 20:49:53
echo Carbon::parse('+3 days')->toDateTimeString(); //2015-07-29 20:49:53
echo Carbon::parse('+2 weeks')->toDateTimeString(); //2015-08-09 20:49:53
echo Carbon::parse('+4 months')->toDateTimeString(); //2015-11-26 20:49:53
echo Carbon::parse('-1 year')->toDateTimeString(); //2014-07-26 20:49:53
echo Carbon::parse('next wednesday')->toDateTimeString(); //2015-07-29 00:00:00
echo Carbon::parse('last friday')->toDateTimeString(); //2015-07-24 00:00:00

         *
         * */


    }
        
        
    public function postQuickSearch() {

    $fields = array(
        'vehicle_manufacturer','vehicle_model',
        'year_reg_from','year_reg_to',
        'price_from','price_to'
    );

    foreach($fields as $field)
        $$field = Input::get($field);

        $query = Seller::where('vehicle_manufacturer', 'LIKE', '%'. $vehicle_manufacturer .'%')
            ->orWhere('vehicle_model', 'LIKE', '%'. $this->getModel($vehicle_model) .'%');      

    if(!empty($year_reg_from) && !empty($year_reg_to)) {
        $query->whereBetween('year_reg', array($year_reg_from, $year_reg_to));
    }

    if(!empty($price_from) && !empty($price_to)) {
        $query->whereBetween('price', array($price_from, $price_to));
    }

    if(empty($price_from) && empty($price_to) && empty($year_reg_from) && empty($year_reg_to)) {
        //Nothing yet
    }

     $result = $query->get();

    if($result->count()) {

        $data = array(
            'results'       => $result
        );

        return View::make('auto.vehicle.search')->with($data);
    }

    return Redirect::route('home')->with('global', 'No results.');
}

public function excelGeneration(){
     $input= $_SESSION['rportInput'];
        if(isset($input->customer_id1)&& !empty($input->customer_id1)){
            $customer_id=$input->customer_id1;

        }
        if(isset($input->d_id)&& !empty($input->d_id)){
            $department_id=$input->d_id;

        }
        if(isset($input->startdate)&& !empty($input->startdate)){
            $startdate=$input->startdate;
            $date1=explode('/',$startdate);
            $date = Carbon::create($date1[2], $date1[0], $date1[1]);

        }


         $date = date('Y-m-d');
        $filename='graphicalreport-'.$date;

         $data= $this->get_chart_report($input);


         
           $output =  View::make('reports/csv_download',compact('data'));

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
                return Response::make($output, 200, $headers);exit();
}



	
}	