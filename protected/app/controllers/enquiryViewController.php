<?php
use Maatwebsite\Excel\Facades\Excel;

class enquiryViewController extends BaseController  
{
    public function viewEnquiry()
    {
        if(Auth::check()):
              return View::make('enquiry/enquiryView');
        else:
             return Redirect::to('')->with('message', SiteHelpers::alert('error','Please Login to Access this Page'));
          endif;
    }

    public function getEnq()
    {
      $data = DB::select(DB::raw('select enquiryId,enquiry_no from customer_enquiry_form'));
       $select = "--Please Select--";
            echo '<option value="">';
            echo $select.'</option>';
            foreach($data as $d){
              echo '<option value="'.$d->enquiryId.'"';
              echo '>'.$d->enquiry_no.'</option>';
            }
    exit();
    }

  public function SearchEnquiry()
  {
    $input =Input::all();
    $en = new Enquiry();
    $enquiry = $input['enquiry'];
    $enquiry_data= $en->getEnquiryData($enquiry);
    $file_data= $en->getEnquiryFileData($enquiry);
    return View::make('enquiry.enquiryViewAjax', array('enquiry_details' => $enquiry_data,'file_details' => $file_data));    
  }

  public function enquiryPDFDownload(){
    $input =Input::all();
    $en = new Enquiry();
    $enquiry = $input['enquiry'];
    $enquiry_data = $en->getEnquiryData($enquiry);
    $file_data = $en->getEnquiryFileData($enquiry);
    $date = date('Y-m-d');
    $filename ='enquiryPDF-'.$date;
    $pdf=PDF::loadView('enquiry.enquiryViewDownload', array('enquiry_details' => $enquiry_data,'file_details' => $file_data))->save('uploads/'.$filename.'.pdf',true);
    $pdf->setPaper('a2')->setOrientation('landscape')->setWarnings(false);

    echo 'uploads/'.$filename.'.pdf';
    }

    public function enquiryExcelDownload($enquiry){

    $input =Input::all();
    $en = new Enquiry();
      // dd($en);

    // $enquiry = $input['enquiry'];
    $enquiry_data= $en->getEnquiryData($enquiry);
    $file_data= $en->getEnquiryFileData($enquiry);
    $date = date('Y-m-d');
    $filename='enqquiryExcel-'.$date;
    
    $output = View::make('enquiry.prt_excel',array('enquiry_details' => $enquiry_data,'file_details' => $file_data));



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

    }

}