<?php

class apqpRFQController extends BaseController  {

	//protected $layout = "layouts.main";
	
	public function index(){

        if(Auth::check()):
              return View::make('apqpTask/enquiryRFQ');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    
  public function saveRFQ(){
    $input = (object)Input::all();
    // print_r($_FILES['uploadFile']['name'][0]);exit();
  
    if($input->customer ==""){
      $compnyname= "";
    }else{
      $compnyname= $input->customer;
    }
    if($input->txtProdGoal ==""){
      $prodgoal= "";
    }else{
      $prodgoal= $input->txtProdGoal;
    }
    if($input->txtPhone ==""){
      $phone= "";
    }else{
      $phone= $input->txtPhone;
    }
    if($input->txtEmail ==""){
      $email= "";
    }else{
      $email= $input->txtEmail;
    }
    if($input->txtInstrForResp ==""){
      $InstrForResp= "";
    }else{
      $InstrForResp= $input->txtInstrForResp;
    }
    if($input->txtProdDtls ==""){
      $proddtls= "";
    }else{
      $proddtls= $input->txtProdDtls;
    }
    if($input->txtTechReq ==""){
      $technicalreq= "";
    }else{
      $technicalreq= $input->txtTechReq;
    }
    if($input->proj_summary ==""){
      $projsummary= "";
    }else{
      $projsummary= $input->proj_summary;
    }
    if($input->txtDeliverReq ==""){
      $deliveryreq= "";
    }else{
      $deliveryreq= $input->txtDeliverReq;
    }

  if($input->txtSupportReq ==""){
      $supportreq= "";
    }else{
      $supportreq= $input->txtSupportReq;
    }
  if($input->txtqualityreq ==""){
      $qualityreq= "";
    }else{
      $qualityreq= $input->txtqualityreq;
    }
    if($input->txtlegalreq ==""){
      $legalreq= "";
    }else{
      $legalreq= $input->txtlegalreq;
    }
    if($input->txtTermsCond ==""){
      $termscond= "";
    }else{
      $termscond= $input->txtTermsCond;
    }
    if($input->txtPriceUnit ==""){
      $priceperunit= "";
    }else{
      $priceperunit= $input->txtPriceUnit;
    }
    if($input->txtRFQIssue==''){
                $issuedate='--';
    }else{
        $date1 = explode('/', $input->txtRFQIssue);
        $issuedate = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
    }
    if($input->txtPropasaldeadline==''){
                $proposaldate='--';
    }else{
        $date1 = explode('/', $input->txtPropasaldeadline);
        $proposaldate = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
    }

try{
     DB::table('apqp_rfq_details')
        ->insert(
            array(
                'customer_id' => $compnyname,
                'rfq_title'  => $input->txtrfqtitle,
                'rfq_id'=>$input->txtrfqid,
                'proj_summary_desc'=>$input->txtProjSummary,
                'prod_goals'=>$prodgoal,
                'proj_lead_title'=>$input->txtprojlead,
                'phone'=>$phone,
                'email'=>$email,
                'instruction_for_respone'=>$InstrForResp,
                'rfq_issue_date'=>$issuedate,
                'proposal_deadline'=>$proposaldate,
                'prod_details'=>$proddtls,
                'technical_req'=>$technicalreq,
                'prod_quantity'=>$input->txtProdQty,
                'delivery_req'=>$deliveryreq,
                'support_req'=>$supportreq,
                'quality_assurance_req'=>$qualityreq,
                'legal_req'=>$legalreq,
                'terms_condition'=>$termscond,
                'price_per_unit' =>$priceperunit,
                'createdBy'  => Session::get('uid'),
                'CreatedDate' => Date('Y-m-d H:i:s' )
              )
          );
      }catch(Illuminate\Database\QueryException $e){
        $errorCode = $e->errorInfo[1];
         if($errorCode == 1062){
          return Redirect::to('rfq_details')->with('message', SiteHelpers::alert('error', 'Enter unique RFQ title and id'));
         }
      }
        
         $last_id = DB::getPdo()->lastInsertId();
      

  
     $destinationPath = 'uploads/rfq_file';

    if($_FILES['uploadFile']['name'][0] != ""){
         
            foreach($input->uploadFile as $file){
               $extension = $file->getClientOriginalName();
             $filename = rand(11111, 99999) . '-' . $extension; 
            
                    
                    $upload_success = $file->move($destinationPath, $filename);
             DB::table('apqp_rfq_file')->insert(
                        array(
                            'rfq_id' => $last_id,
                            'file_name'   =>$filename,
                        )
                    );
            }
          }
          return Redirect::to('apqp_dashboard')->with('message', SiteHelpers::alert('success', 'RFQ saved successfully'));;
        
  }

  public function closeRFQ(){
     if(Auth::check()):
              return View::make('apqpTask/closeRFQ');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
  }

  public function getRFQ(){
      $data = DB::select(DB::raw('select id,rfq_id,rfq_title from apqp_rfq_details where rfq_close=0 and id not in (select rfq_id from apqp_new_project_info)'));
      return $data;
  }
	public function saveRFQClose(){
      $input = (object)Input::all();
     
      DB::table('apqp_rfq_details')
      ->where('id',$input->RFQId)
      ->update(
          array(
              'rfq_close' => 1,
              'rfq_close_reason'=>$input->reason
            )
        );
  }		

  public function getCustomer(){
    $data = DB::table('customer') 
            ->select('CustomerId','FirstName')
            ->where('status','active')
            ->get();
            return $data;
  }

  public function getRFQId(){
    $data = DB::select(DB::raw('SELECT id FROM apqp_rfq_details ORDER BY id DESC LIMIT 1'));
            if(!empty($data)){
              $id= $data[0]->id+1;
            }else{
              $id= 1;
            }
            
            return $id;
  }

  public function viewFile(){

        $filename=$_REQUEST['filename'];
        $path=$_REQUEST['path'];
        $root=Config::get('app.app_name');
        $file = $root.'/uploads/'.$path.'/'.$filename;

        return View::make('apqpTask/docview',compact('filename','file'));
      }
     
  
	
}	