<?php

class ScmController extends BaseController  {

			
	public function index()
	{

		if ($this->check_permission(22)) {
$res=array();
			$points = DB::table('suppliers_change_request')
					//->select('suppliers_change_request.*')
					->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name'))
					->groupBy('year')
					//->groupBy('month')
					->orderBy('year', 'desc')
					//->orderBy('month', 'desc')
					->get();



			foreach ($points as $point) {
				$res[] = array(
						'year' => $point->year,
					//'supplier_month' => $point->month,
						'supplierdata'=>$this->get_data_by_supplier($point->year),
				);

				/*foreach ($points as $point) {
					$res[] = array(
							'supplier_id' => $point->year,
							//'supplier_month' => $point->month,
							'supplierdata'=>$this->get_data_by_year($point->year),
					);
					*/

			}
			//	echo '<pre>';
			//	print_r($res);exit;




			/*foreach ($points as $point) {
                $res[] = array(
                        'supplier_id' => $point->supplier_id,
                        'man' => $point->man,
                        'machine' => $point->machine,
                        'material' => $point->material,
                        'method' => $point->method,
                        'created_at' => $point->created_at,

                );
            }
            */


			return View::make('scm/scm', compact('res'));
		//} else {

	//		return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
		}

	}

	public function schedular(){

		return View::make('scm/schedule');


	}

	function get_data_by_supplier($year)

	{
		$date= $year.'-1-1 00:00:00';
		$date1= $year.'-12-31 11:59:00';

		//return $year;exit;
		$res=array();
		$points =  DB::table('suppliers_change_request')
				->leftJoin('tb_supplier', 'suppliers_change_request.supplier_id', '=', 'tb_supplier.supplier_id')
				->select(DB::raw('YEAR(suppliers_change_request.created_at) year, MONTH(suppliers_change_request.created_at) month, MONTHNAME(suppliers_change_request.created_at) month_name,suppliers_change_request.created_at,suppliers_change_request.supplier_id,tb_supplier.company_name'))
				//->groupBy('year')
				->groupBy('suppliers_change_request.supplier_id')
				//->orderBy('year', 'desc')
				->orderBy('month', 'desc')
				->where('suppliers_change_request.created_at','>', $date )
				->where('suppliers_change_request.created_at','<', $date1 )
				->get();

		foreach ($points as $point) {
			$res[] = array(
					'company_name'=>$point->company_name,
					'supplier_id' => $point->supplier_id,
					'supplierdata1' => $this->get_data_by_year($year,$point->supplier_id),


			);


		}
		return $res;
	}








	function get_data_by_year($year,$supplier_id)

	{
		$points = array();
		for ($i = 1; $i <= 12; $i++) {
			$date = $year . '-' . $i . '-1 00:00:00';
			$date1 = $year . '-' . $i . '-31 11:59:00';

			//return $year;exit;

			 $points[] = DB::table('suppliers_change_request')
					->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name,suppliers_change_request.*'))
					//->groupBy('year')
					//->groupBy('month')
					//->orderBy('year', 'desc')
					->orderBy('month', 'desc')
					->where('created_at', '>', $date)
					->where('created_at', '<', $date1)
					->where('supplier_id', '=', $supplier_id)
					->first();
				}
		return $points;
			exit;

			foreach ($points as $point) {
				$res[] = array(
						'supplier_month' => $point->month,
						'supplierdata2' => $this->get_data_by_month($year, $point->month, $supplier_id),


				);


			}
			return $res;

	}

	function get_data_by_month($year,$month,$supplier_id)
	{

		for ($i = 1; $i <= 12; $i++) {

			$date = $year . '-' . $month . '-1 00:00:00';
			$date1 = $year . '-' . $month . '-31 11:59:00';

			return $points = DB::table('suppliers_change_request')
					->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, suppliers_change_request.*'))
					->where('created_at', '>', $date)
					->where('created_at', '<', $date1)
					->where('supplier_id', '=', $supplier_id)
					//->orderBy('month', 'desc')
					->first();


		}
	}


        
        public function view_attachments($id){
            
            $user_type = Session::get('gid');
		if($user_type!="") {


			$attachments = DB::table('suppliers_change_request_attachments')
					->leftJoin('suppliers_change_request', 'suppliers_change_request_attachments.list_id', '=', 'suppliers_change_request.id')
					->select('suppliers_change_request_attachments.*')
					->where('suppliers_change_request_attachments.list_id', $id)
					->orderBy('suppliers_change_request_attachments.created_at', 'desc')
					->get();

			return View::make('scm/attachments',compact('attachments'));
		}
			else {
				return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
			}
             }
             
             
             public function summary_sheet(){
                 
                 $user_type = Session::get('gid');
		  if($user_type!=""):
				return View::make('scm/summary_sheet');
			else:
				 return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
			  endif;
             }


			public function supplier(){

				if(in_array(8,explode(',',Session::get('gid')))){
					return View::make('scm/supplier');
				} else {

					return Redirect::to('')->with('message', SiteHelpers::alert('error', 'Please Login to Access this Page'));
				}


			}

	public function get_supplier_list(){

		//Returns All departments
		$suppliers = DB::table('tb_supplier')
				->select('tb_supplier.*')
				->get();

		return $suppliers;
	}

	/**
	 * @param $id
	 * @return mixed
	 */

	public function save_supplier($id){


		$input = (object)Input::all();

		$date=$input->startdate;
		$date1=explode('/',$date);
		//$date1=explode('-',$date[0]);

		//return $date1[2].'.'.$date1[1].'.'.$date1[0];

		$users = DB::table('suppliers_change_request')
				->select(DB::raw('COUNT(supplier_id) as total'))
				->where('suppliers_change_request.supplier_id', $id)
				->whereYear('suppliers_change_request.created_at', '=', $date1[2])
				->whereMonth('suppliers_change_request.created_at', '=', $date1[0])
				->get();


		if($users[0]->total>0){

			Session::flash('message', "Changes Already Done on Selected Month.");
			return Redirect::back();

		}else {
			$time=$date1[2].'-'.$date1[0].'-'.$date1[1].' '.'00:00:00';

			DB::table('suppliers_change_request')->insert(
					array('supplier_id' => $id,
							'man' => $input->man,
							'machine' => $input->machine,
							'material' => $input->material,
							'method' => $input->method,
							'remark' => $input->remark,
							'created_at' => $time,

					)
			);

			$last_id = DB::getPdo()->lastInsertId();

			$destinationPath = 'uploads/scm';
			//$i=0;

			if (Input::hasFile('man_file')) {
				$files = Input::file('man_file');
				//echo '<pre>';
				//print_r($files);
				foreach ($files as $file) {


					$filename = $file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $filename);
					// flash message to show success.
					//Session::flash('success', 'Upload successfully');
					//return Redirect::to('upload');

					$this->save_attachments($id, 1, $filename, $last_id);
				}
			}

			if (Input::hasFile('machine_file')) {
				$files = Input::file('machine_file');
				foreach ($files as $file) {

					$filename = $file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $filename);
					// flash message to show success.
					//Session::flash('success', 'Upload successfully');
					//return Redirect::to('upload');

					$this->save_attachments($id, 2, $filename, $last_id);
				}
			}
			if (Input::hasFile('material_file')) {
				$files = Input::file('material_file');
				foreach ($files as $file) {

					$filename = $file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $filename);
					// flash message to show success.
					//Session::flash('success', 'Upload successfully');
					//return Redirect::to('upload');

					$this->save_attachments($id, 3, $filename, $last_id);
				}
			}
			if (Input::hasFile('method_file')) {
				$files = Input::file('method_file');
				foreach ($files as $file) {

					$filename = $file->getClientOriginalName();
					$upload_success = $file->move($destinationPath, $filename);
					// flash message to show success.
					//Session::flash('success', 'Upload successfully');
					//return Redirect::to('upload');

					$this->save_attachments($id, 4, $filename, $last_id);
				}
			}
			Session::flash('message', "You have posted successfully");
			return Redirect::back();

		}
	}

	function save_attachments($id,$type,$file_name,$last_id){

		DB::table('suppliers_change_request_attachments')->insert(
				array('supplier_id' => $id,
						'type' => $type,
						'file_name' => $file_name,
					    'list_id'=>$last_id,
						'created_at' => date('Y-m-d H:i:s'),

				)
		);
	}

	public function save_supplier_bkp($id){


		$destinationPath = 'uploads'; // upload path


		//Input::get('last_name');

		$input = (object)Input::all();

		DB::table('suppliers_change_request')->insert(
				array('supplier_id' => $id,
						'man' => $input->man,
						'machine' => $input->machine,
						'material' => $input->material,
						'method' => $input->method,
						'remark' => $input->remark,
						'created_at' => date('Y-m-d H:i:s'),

				)
		);



		if (Input::hasFile('man_file')) {
			$files = Input::file('man_file');
			foreach ($files as $file) {
				$destinationPath = 'uploads/users';
				//	$filename = $file->getClientOriginalName();


				$name = $file->getClientOriginalName();

				$extension = $file->getClientOriginalExtension();
				$filename = rand(11111, 99999) . "-" . $name; // renaming image
				$file->move($destinationPath, $filename);



				$file->move($destinationPath, $filename);

				$this->save_attachments($id,1,$filename);
			}
		}
		if (Input::hasFile('machine_file')) {
			$files = Input::file('machine_file');
			foreach ($files as $file) {
				$destinationPath = 'uploads/users';
				$name = $file->getClientOriginalName();

				$extension = $file->getClientOriginalExtension();
				$filename = rand(11111, 99999) . "-" . $name; // renaming image
				$file->move($destinationPath, $filename);

				$this->save_attachments($id,2,$filename);
			}
		}
		if (Input::hasFile('material_file')) {
			$files = Input::file('material_file');
			foreach ($files as $file) {
				$destinationPath = 'uploads/users';
				$name = $file->getClientOriginalName();

				$extension = $file->getClientOriginalExtension();
				$filename = rand(11111, 99999) . "-" . $name; // renaming image
				$file->move($destinationPath, $filename);

				$this->save_attachments($id,3,$filename);
			}
		}
		if (Input::hasFile('method_file')) {
			$files = Input::file('method_file');
			foreach ($files as $file) {
				$destinationPath = 'uploads/users';
				$name = $file->getClientOriginalName();

				$extension = $file->getClientOriginalExtension();
				$filename = rand(11111, 99999) . "-" . $name; // renaming image
				$file->move($destinationPath, $filename);

				$this->save_attachments($id,4,$filename);
			}
		}

		Session::flash('message', "You have done changes successfully");
		return Redirect::back();



	}

	public function send_schedule_email()
	{

		$points = DB::table('tb_supplier')
				->leftJoin('suppliers_change_request', 'suppliers_change_request.supplier_id', '=', 'tb_supplier.supplier_id')
				->select('tb_supplier.*')->distinct('suppliers_change_request.supplier_id')
				->get();


		//echo '<pre>';
		//print_r($points);exit;



		foreach ($points as $point) {
			$res = array(
					'year' => $point->email_id,
				    'company_name' => $point->company_name,
					//'supplierdata' => $this->get_data_by_supplier($point->year),
			);
		//	echo 'san';

			$email_id=(String)$point->email_id;
			Mail::send('emails.email-template', $res, function($message) use ($email_id) {
				$message->to($email_id, 'Jon Doe')->subject('Request Rejected.');
			});

		}

		//return $res;
	}

	public function save_cron_job(){
		//echo app_path();

		//$str=file_get_contents(base_path('resources/views/layouts/controller.txt'));
		//$str = str_replace("{{class}}", ucwords($class), $str);
		$str='*   *   *   *   *'.app_path().'/send_schedule_email';

		file_put_contents(app_path()."/test.txt",$str);

		//echo shell_exec('sh'. app_path().'/test.sh');

		echo 'success';
	}
}	