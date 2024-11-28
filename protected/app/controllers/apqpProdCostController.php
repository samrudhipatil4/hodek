<?php

class apqpProdCostController extends BaseController  {

	//protected $layout = "layouts.main";
	
	public function index(){

        if(Auth::check()):
              return View::make('apqpTask/ProdCostCard');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }
    public function viewRFQ(){

        if(Auth::check()):
              return View::make('apqpTask/RFQ_view');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    
  public function saveRFQCost(){
    $input =Input::all();
//     DB::beginTransaction();
// try {
    if(!empty($input['costdetails'])){
      $allcostdet = $input['costdetails'];

    DB::table('apqp_productcostdetails')
    ->insert(
        array(
            'project' => $allcostdet[0]['project'],
            'RFQ_Id'  =>$allcostdet[0]['rfq'],
            'batch_size'=>$allcostdet[0]['batch'],
            'material_total'=>$allcostdet[0]['mattot'],
            'production_total'=>$allcostdet[0]['prodtot'],
            'other_total' =>$allcostdet[0]['othertot'],
            'allCostTotal' =>$allcostdet[0]['totalcost'],
            'CreatedBy'  =>Session::get('uid'),
            'CreatedDate' => date('Y-m-d H:i:s')
          )
      );
      $lastid = DB::getPdo()->lastInsertId();
    }

     if(!empty($input['materialcost'])){
      $matdet = $input['materialcost'];
      foreach ($matdet as $key) {
        DB::table('apqp_materialcostdetails')
        ->insert(
            array(
                'cost_id' => $lastid,
                'materials'  =>$key['material'],
                'quantity'=>$key['quantity'],
                'rate'=>$key['rate'],
                'total_cost'=>$key['total']
              )
          );
      }
    }
     if(!empty($input['productioncost'])){
      $proddet = $input['productioncost'];
      foreach ($proddet as $key) {
        DB::table('apqp_productioncostdetails')
        ->insert(
            array(
                'Cost_id' => $lastid,
                'Process'  =>$key['Process'],
                'cost'=>$key['cost']
                
              )
          );
      }
    }
    if(!empty($input['othercost'])){
      $proddet = $input['othercost'];
      foreach ($proddet as $key) {
        DB::table('apqp_othercostdetails')
        ->insert(
            array(
                'cost_id' => $lastid,
                'cost_type'  =>$key['costtype'],
                'cost'=>$key['othercost']
                
              )
          );
      }
    }
 //    DB::commit();
 //   }catch (\Exception $e) {
 //     DB::rollback();
 //    $message = $e->getMessage();
 // }
    return;
  }

  public function SearchRFQ($id){
    $data = DB::table('apqp_rfq_details')
            
             ->leftJoin('customer','customer.CustomerId','=','apqp_rfq_details.customer_id')
            ->select('apqp_rfq_details.*','customer.FirstName')
            ->where('apqp_rfq_details.id',$id)
            ->get();
            $RFQId =$id;
            $details = [];
            foreach($data as $row){
              $details = array(
                  'RFQ_Id' => $row->rfq_id,
                  'RfqTitle'=> $row->rfq_title,
                  'customer'=> $row->FirstName,
                  'summary_desc'=>$row->proj_summary_desc,
                  'product_goals'=> $row->prod_goals,
                  'custContactPerson' => $row->proj_lead_title,
                  'phone' =>$row->phone,
                  'email'=>$row->email,
                  'instruction_for_respone'=>$row->instruction_for_respone,
                  'rfq_issue_date'=>date('d-m-Y',strtotime($row->rfq_issue_date)),
                  'proposal_deadline' =>date('d-m-Y',strtotime($row->proposal_deadline)),
                  'prod_details'=> $row->prod_details,
                  'technical_req'=> $row->technical_req,
                  'quantity' => $row->prod_quantity,
                  'delivery_req'=>$row->delivery_req,
                  'support_req' =>$row->support_req,
                  'quality_assurance_req'=>$row->quality_assurance_req,
                  'legal_req' =>$row->legal_req,
                  'terms_condition'=>$row->terms_condition,
                  'price_per_unit' => $row->price_per_unit,
                  'rfq_close' =>$row->rfq_close,
                  'rfq_close_reason'=>$row->rfq_close_reason,
                  'file'=>$this->getRFQFile($row->id)
                );

            }
            return $details;
  }
	public function getRFQFile($RFQId){
    $data = DB::table('apqp_rfq_file')
    ->select('file_name')
    ->where('rfq_id',$RFQId)
    ->get();

    return $data;

  }
  public function downloadRFQView(){
    $input = Input::all();

    if(isset($input['RFQId'])){
      $date = date('Y-m-d');

        $filename='RFQView-'.$date;
      $data = DB::table('apqp_rfq_details')
             ->leftJoin('customer','customer.CustomerId','=','apqp_rfq_details.customer_id')
            ->select('apqp_rfq_details.*','customer.FirstName')
            ->where('apqp_rfq_details.id',$input['RFQId'])
            ->get();
            $details = [];
            foreach($data as $row){
              $details[] = array(
                  'RFQ_Id' => $row->rfq_id,
                  'RfqTitle'=> $row->rfq_title,
                  'customer'=> $row->FirstName,
                  'summary_desc'=>$row->proj_summary_desc,
                  'product_goals'=> $row->prod_goals,
                  'custContactPerson' => $row->proj_lead_title,
                  'phone' =>$row->phone,
                  'email'=>$row->email,
                  'instruction_for_respone'=>$row->instruction_for_respone,
                  'rfq_issue_date'=>date('d-m-Y',strtotime($row->rfq_issue_date)),
                  'proposal_deadline' =>date('d-m-Y',strtotime($row->proposal_deadline)),
                  'prod_details'=> $row->prod_details,
                  'technical_req'=> $row->technical_req,
                  'quantity' => $row->prod_quantity,
                  'delivery_req'=>$row->delivery_req,
                  'support_req' =>$row->support_req,
                  'quality_assurance_req'=>$row->quality_assurance_req,
                  'legal_req' =>$row->legal_req,
                  'terms_condition'=>$row->terms_condition,
                  'price_per_unit' => $row->price_per_unit,
                  'rfq_close' =>$row->rfq_close,
                  'rfq_close_reason'=>$row->rfq_close_reason,
                  'file'=>$this->getRFQFile($row->id)
                );

            }
            //print_r($details);exit();
         $pdf=PDF::loadView('apqpTask/RFQViewDownload', compact('details'));

                $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);
               // return $pdf->stream(); // view file in browser
               
                return $pdf->download($filename.'.pdf'); //forcely download
    }
  }

}	