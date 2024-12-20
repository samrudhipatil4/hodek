<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/jquery.min.js"></script>
 <script type="text/javascript" src="<?php echo Request::root(); ?>/protected/public/js/bootstrap-dropdown.js"></script>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
.green-background{
background-color:#00bfff; 
}
.blue-background{
  background-color:#009933;
}
.red-background{
  background-color:#ff0000;
}
.left-table-container{
overflow-y:auto;  
}
.right-table-container{
overflow-y:auto;  
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding:0;
    vertical-align: top;
    border-top:none;
}
.table>thead>tr>th {
    vertical-align:top;
    border-bottom:none;
  height:90px;
}
.table>tbody>tr{
height:71px;  
}
.only-top-bdr{
border-top:1px solid #000;  
}
.bdr-left{
border-left:1px solid #000; 
}
.sub-table>tbody>tr{
border-bottom:1px solid #000;
height:45px;
border-right:1px solid #000;
width: 58px;
    display: block;
text-align:center;  
}
.bdr-top{
border-top:1px solid #000;  
}
.table>thead>tr{
  border-top:1px solid #000;
}
.table>thead>tr>th{
  border-right:1px solid #000;
}
/*left-table*/
.left-table-container>.table>tbody>tr{
border-bottom:1px solid #000;
height: 90px;
}
.left-table-container>.table>tbody>tr>td{
  border-left:1px solid #000;
}
.left-table-bdr-top{
border-top:1px solid #000;
vertical-align:middle;  
}
.left-sub-table{
width:100%; 
}
.left-sub-table>tbody>tr{
  height:45px;
  display:block;
}
.bdr-only-top{
  border-top:1px solid #000;
}
.right-table>tbody>tr{
border-top:1px solid #000;
border-right:1px solid #000;  
}
.right-table>tbody>tr:last-child{
border-bottom:1px solid #000; 
}
.left-table-boder-right{
  border-right: 1px solid #000;
}

.container-fluid{
  width:100%;
}
.left-side-div{
  width:60%;
}
.right-side-div{
  width:40%;
}

</style>
</head>
<body>
<div class="container-fluid">

<div class="col-md-5 col-sm-6 xol-xs-6 left-side-div" style="padding-right:0;">
      <div class="left-table-container">
            <table class="table bdr-left-table left-table-boder-right"> 
                    <tbody>
                              <tr>
                                  <td width="12.5%"><strong>Enquiry Id</strong></td>
                                  <td>{{$enquiry_details[0]->enquiryId}}</td>
                                  <td width="12.5%"><strong>Enquiry No</strong></td>
                                  <td>{{$enquiry_details[0]->enquiry_no}}</td>                       
                                  <td width="12.5%"><strong>Enquiry Date</strong></td>
                                  <td>{{$enquiry_details[0]->enquiry_date}}</td>
                                  <td width="12.5%"><strong>Customer</strong></td>
                                  <td>{{$enquiry_details[0]->customer}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Customer Revision Number</strong></td>
                                  <td>{{$enquiry_details[0]->cust_rev}}</td>
                                  <td width="12.5%"><strong>Customer Part Number</strong></td>
                                  <td>{{$enquiry_details[0]->cust_part_no}}</td>    
                                  <td width="12.5%"><strong>Customer Contact Person</strong></td>
                                  <td>{{$enquiry_details[0]->cust_cont_person}}</td>
                                  <td width="12.5%"><strong>Customer contact Number</strong></td>
                                  <td>{{$enquiry_details[0]->cust_person_no}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Customer Person Email</strong></td>
                                  <td>{{$enquiry_details[0]->cust_person_email}}</td>
                                  <td width="12.5%"><strong>Engine Details</strong></td>
                                  <td>{{$enquiry_details[0]->engine_details}}</td>
                                  <td width="12.5%"><strong>Engine Application Details</strong></td>
                                  <td>{{$enquiry_details[0]->engine_appl_details}}</td>
                                  <td width="12.5%"><strong>Similar Product Mfg</strong></td>
                                  <td>{{$enquiry_details[0]->similar_product_mfg}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Internal Customer Name</strong></td>
                                  <td>{{$enquiry_details[0]->internal_cust}}</td>
                                  <td width="12.5%"><strong>Estimated Cost Of Damper</strong></td>
                                  <td>{{$enquiry_details[0]->estimated_cost}}</td>
                                  <td width="12.5%"><strong>Proposal Deadline</strong></td>
                                  <td >{{$enquiry_details[0]->deadline}}</td>
                                  <td width="12.5%"><strong>Annual Volume YR1</strong></td>
                                  <td>{{$enquiry_details[0]->annual_volY1}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Annual Volume YR2</strong></td>
                                  <td>{{$enquiry_details[0]->annual_volY2}}</td>
                                  <td width="12.5%"><strong>Annual Volume YR3</strong></td>
                                  <td>{{$enquiry_details[0]->annual_volY3}}</td>
                                  <td width="12.5%"><strong>Annual Volume YR4</strong></td>
                                  <td>{{$enquiry_details[0]->annual_volY4}}</td>
                                  <td width="12.5%"><strong>Annual Volume YR5</strong></td>
                                  <td>{{$enquiry_details[0]->annual_volY5}}</td>
                              </tr>
                              <tr>
                                   <td width="12.5%"><strong>Annual Volume File</strong></td>
                                   <td>
                                    <?php foreach($file_details as $key => $value){                   
                                        if($value->type == 'Annual Volume'){
                                        "Annual Volume".$key; print_r($value->file_name);
                                        } }?>
                                    </td>
                                  <td width="12.5%"><strong>Prototype Sample</strong></td>
                                  <td>{{$enquiry_details[0]->proto_sample}}</td>
                                  <td width="12.5%"><strong>Prototype Date</strong></td>
                                  <td>{{$enquiry_details[0]->proto_date}}</td>
                                  <td width="12.5%"><strong>PILOT Batch</strong></td>
                                  <td>{{$enquiry_details[0]->pilot_batch}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>PILOT Date</strong></td>
                                  <td>{{$enquiry_details[0]->pilot_date}}</td>
                                  <td width="12.5%"><strong>PPAP Batch</strong></td>
                                  <td>{{$enquiry_details[0]->ppap_batch}}</td>
                                  <td width="12.5%"><strong>PPAP Date</strong></td>
                                  <td>{{$enquiry_details[0]->ppap_date}}</td>
                                  <td width="12.5%"><strong>SOP Date</strong></td>
                                  <td>{{$enquiry_details[0]->sop_date}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Packaging</strong></td>
                                  <td>{{$enquiry_details[0]->packaging}}</td>
                                  <td width="12.5%"><strong>Packaging File</strong></td> 
                                  <td>
                                       <?php foreach($file_details as $key => $value){        
                                       if($value->type == 'Packaging'){
                                        "Packaging".$key; print_r($value->file_name);
                                         } }?>
                                  </td>
                                  <td width="12.5%"><strong>Labeling</strong></td>
                                  <td>{{$enquiry_details[0]->labeling}}</td>
                                  <td width="12.5%"><strong>Labeling File</strong></td>
                                  <td>
                                        <?php foreach($file_details as $key => $value){
                                        if($value->type == 'Labeling'){
                                        "Labeling".$key; print_r($value->file_name);
                                        }}?>
                                   </td>
                                </tr>
                                <tr>
                                  <td width="12.5%"><strong>Painting</strong></td>
                                  <td>{{$enquiry_details[0]->painting}}</td>
                                  <td width="12.5%"><strong>Painting File</strong></td>
                                  <td>
                                        <?php foreach($file_details as $key => $value){
                                        if($value->type == 'Painting'){
                                        "Painting".$key; print_r($value->file_name);
                                         } }?>
                                  </td>
                                  <td width="12.5%"><strong>Any Other</strong></td>
                                  <td>{{$enquiry_details[0]->any_other}}</td>
                                  <td width="12.5%"><strong>Any Other File</strong></td>
                                  <td>
                                        <?php foreach($file_details as $key => $value){
                                         if($value->type == 'Any Other'){
                                         "Any Other".$key; print_r($value->file_name);
                                          } }?>
                                   </td>
                              </tr>
                              <tr>
                                   <td width="12.5%"><strong>Engine Data Sheet</strong></td>
                                   <td>{{$enquiry_details[0]->engine_data}}</td>
                                   <td width="12.5%"><strong>Engine Data sheet File</strong></td>
                                   <td>
                                          <?php foreach($file_details as $key => $value){
                                          if($value->type == 'Engine Data Sheet'){
                                          "Engine Data Sheet".$key; print_r($value->file_name);
                                          } } ?>
                                  </td>
                                  <td width="12.5%"><strong>Customer Specific Requirement</strong></td>
                                  <td>{{$enquiry_details[0]->specific_req}}</td>
                                  <td width="12.5%"><strong>Specific Requirement File</strong></td>
                                  <td>
                                          <?php foreach($file_details as $key => $value){
                                           if($value->type == 'Specific Requirement'){
                                           "Specific Requirement".$key; print_r($value->file_name);
                                         }}?>
                                  </td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Customer Interview</strong></td>
                                  <td>{{$enquiry_details[0]->cust_interview}}</td>
                                  <td width="12.5%"><strong>Name of the Interviewee</strong></td>
                                  <td>{{$enquiry_details[0]->name_interview}}</td>
                                  <td width="12.5%"><strong>Name of the Interviewer</strong></td>
                                  <td>{{$enquiry_details[0]->name_interviewer}}</td>
                                  <td width="12.5%"><strong>Inputs/Data Collected</strong></td>
                                  <td>{{$enquiry_details[0]->input_data}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Competitors Name</strong></td>
                                  <td>{{$enquiry_details[0]->competitors}}</td>
                                  <td width="12.5%"><strong>Product Name</strong></td>
                                  <td>{{$enquiry_details[0]->product_name}}</td>
                              
                                  <td width="12.5%"><strong>Product & Quality Information</strong></td>
                                  <td>{{$enquiry_details[0]->product_quality}}</td>
                                  <td width="12.5%"><strong>TGR Reports</strong></td>
                                  <td>{{$enquiry_details[0]->tgr_report}}</td>
                               </tr>
                               <tr>
                                  <td width="12.5%"><strong>TGW Product/Name</strong></td>
                                  <td>{{$enquiry_details[0]->tgw_product_name}}</td>
                                  <td width="12.5%"><strong>Discrepancy Observed</strong></td>
                                  <td>{{$enquiry_details[0]->discrepancy}}</td>
                              
                                  <td width="12.5%"><strong>Probable Causes for Discrepancy</strong></td>
                                  <td>{{$enquiry_details[0]->cause_discrepancy}}</td>
                                  <td width="12.5%"><strong>Customer plant returns & Rejection</strong></td>
                                  <td>{{$enquiry_details[0]->return_reject}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Field return Product Analysis</strong></td>
                                  <td>{{$enquiry_details[0]->field_return}}</td>
                                  <td width="12.5%"><strong>Customer Letters/suggestion</strong></td>
                                  <td>{{$enquiry_details[0]->cust_suggestions}}</td>
                              
                                  <td width="12.5%"><strong>Field service reports</strong></td>
                                  <td>{{$enquiry_details[0]->service_report}}</td>
                                  <td width="12.5%"><strong>Transportation & Primiunm Freight</strong></td>
                                  <td>{{$enquiry_details[0]->transportation}}</td>
                                </tr>
                                <tr>
                                  <td width="12.5%"><strong>Goverment requirements & regulations:</strong></td>
                                  <td>{{$enquiry_details[0]->requirement_regulation}}</td>
                                  <td width="12.5%"><strong>Problems & issues Report from Internal customer</strong></td>
                                  <td>{{$enquiry_details[0]->internal_custo}}</td>
                              
                                  <td width="12.5%"><strong>TGR/TGW</strong></td>
                                  <td>{{$enquiry_details[0]->tgr_tgw}}</td>
                                  <td width="12.5%"><strong>Time constriants</strong></td>
                                  <td>{{$enquiry_details[0]->time_constriants}}</td>
                              </tr>
                              <tr>
                              
                                  <td width="12.5%"><strong>Cost constraint</strong></td>
                                  <td>{{$enquiry_details[0]->cost_constraint}}</td>
                                  <td width="12.5%"><strong>Investment</strong></td>
                                  <td>{{$enquiry_details[0]->investment}}</td>
                             
                                  <td width="12.5%"><strong>key competitors</strong></td>
                                  <td>{{$enquiry_details[0]->key_competitor}}</td>
                                  <td width="12.5%"><strong>Performance</strong></td>
                                  <td>{{$enquiry_details[0]->performance}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Cost</strong></td>
                                  <td>{{$enquiry_details[0]->cost}}</td>
                                  <td width="12.5%"><strong>New Technology</strong></td>
                                  <td>{{$enquiry_details[0]->n_techno}}</td>
                             
                                  <td width="12.5%"><strong>New resources</strong></td>
                                  <td>{{$enquiry_details[0]->new_resources}}</td>
                                  <td width="12.5%"><strong>Risk Management</strong></td>
                                  <td>{{$enquiry_details[0]->risk_mgmt}}</td>
                               </tr>
                              <tr>
                                  <td width="12.5%"><strong>Risk Management file</strong></td>            
                                  <td>
                                    <?php foreach($file_details as $key => $value){                   
                                          if($value->type == 'Risk Management'){
                                            "Risk Management".$key; print_r($value->file_name);
                                       }}?>
                                  </td> 
                              </tr>
                            </table>
            </table>
        </div>
    </div>
    
</body>

</html>
