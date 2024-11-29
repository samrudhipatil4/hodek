<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="<?php echo Request::root(); ?>/protected/public/css/custom-pdf.css" rel="stylesheet"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,700,600italic,700italic,800">
<style type="text/css">
   .report-wrapper table tbody > tr > td{
        padding: 5px !important;
        color: #58585 !important;
        font-size: 13px;
  }
</style>
</head>
<body>
<table class="striped" id="downloadfile">
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
                                  <td width="12.5%"><strong>Prototype Sample</strong></td>
                                  <td>{{$enquiry_details[0]->proto_sample}}</td>
                                  <td width="12.5%"><strong>Prototype Date</strong></td>
                                  <td>{{$enquiry_details[0]->proto_date}}</td>
                                  <td width="12.5%"><strong>PILOT Batch</strong></td>
                                  <td>{{$enquiry_details[0]->pilot_batch}}</td>
                                  <td width="12.5%"><strong>PILOT Date</strong></td>
                                  <td>{{$enquiry_details[0]->pilot_date}}</td>
                              </tr>
                              <tr>
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
                                  <td width="12.5%"><strong>Labeling</strong></td>
                                  <td>{{$enquiry_details[0]->labeling}}</td>
                                  <td width="12.5%"><strong>Painting</strong></td>
                                  <td>{{$enquiry_details[0]->painting}}</td>
                                  <td width="12.5%"><strong>Any Other</strong></td>
                                  <td>{{$enquiry_details[0]->any_other}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Engine Data Sheet</strong></td>
                                  <td>{{$enquiry_details[0]->engine_data}}</td>
                                  <td width="12.5%"><strong>Customer Specific Requirement</strong></td>
                                  <td>{{$enquiry_details[0]->specific_req}}</td>
                                  <td width="12.5%"><strong>Customer Interview</strong></td>
                                  <td>{{$enquiry_details[0]->cust_interview}}</td>
                                  <td width="12.5%"><strong>Name of the Interviewee</strong></td>
                                  <td>{{$enquiry_details[0]->name_interview}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Name of the Interviewer</strong></td>
                                  <td>{{$enquiry_details[0]->name_interviewer}}</td>
                                  <td width="12.5%"><strong>Inputs/Data Collected</strong></td>
                                  <td>{{$enquiry_details[0]->input_data}}</td>
                                  <td width="12.5%"><strong>Competitors Name</strong></td>
                                  <td>{{$enquiry_details[0]->competitors}}</td>
                                  <td width="12.5%"><strong>Product Name</strong></td>
                                  <td>{{$enquiry_details[0]->product_name}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Product & Quality Information</strong></td>
                                  <td>{{$enquiry_details[0]->product_quality}}</td>
                                  <td width="12.5%"><strong>TGR Reports</strong></td>
                                  <td>{{$enquiry_details[0]->tgr_report}}</td>
                                  <td width="12.5%"><strong>TGW Product/Name</strong></td>
                                  <td>{{$enquiry_details[0]->tgw_product_name}}</td>
                                  <td width="12.5%"><strong>Discrepancy Observed</strong></td>
                                  <td>{{$enquiry_details[0]->discrepancy}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Probable Causes for Discrepancy</strong></td>
                                  <td>{{$enquiry_details[0]->cause_discrepancy}}</td>
                                  <td width="12.5%"><strong>Customer plant returns & Rejection</strong></td>
                                  <td>{{$enquiry_details[0]->return_reject}}</td>
                                  <td width="12.5%"><strong>Field return Product Analysis</strong></td>
                                  <td>{{$enquiry_details[0]->field_return}}</td>
                                  <td width="12.5%"><strong>Customer Letters/suggestion</strong></td>
                                  <td>{{$enquiry_details[0]->cust_suggestions}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>Field service reports</strong></td>
                                  <td>{{$enquiry_details[0]->service_report}}</td>
                                  <td width="12.5%"><strong>Transportation & Primiunm Freight</strong></td>
                                  <td>{{$enquiry_details[0]->transportation}}</td>
                                  <td width="12.5%"><strong>Goverment requirements & regulations:</strong></td>
                                  <td>{{$enquiry_details[0]->requirement_regulation}}</td>
                                  <td width="12.5%"><strong>Problems & issues Report from Internal customer</strong></td>
                                  <td>{{$enquiry_details[0]->internal_custo}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>TGR/TGW</strong></td>
                                  <td>{{$enquiry_details[0]->tgr_tgw}}</td>
                                  <td width="12.5%"><strong>Time constriants</strong></td>
                                  <td>{{$enquiry_details[0]->time_constriants}}</td>
                                  <td width="12.5%"><strong>Cost constraint</strong></td>
                                  <td>{{$enquiry_details[0]->cost_constraint}}</td>
                                  <td width="12.5%"><strong>Investment</strong></td>
                                  <td>{{$enquiry_details[0]->investment}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>key competitors</strong></td>
                                  <td>{{$enquiry_details[0]->key_competitor}}</td>
                                  <td width="12.5%"><strong>Performance</strong></td>
                                  <td>{{$enquiry_details[0]->performance}}</td>
                                  <td width="12.5%"><strong>Cost</strong></td>
                                  <td>{{$enquiry_details[0]->cost}}</td>
                                  <td width="12.5%"><strong>New Technology</strong></td>
                                  <td>{{$enquiry_details[0]->n_techno}}</td>
                              </tr>
                              <tr>
                                  <td width="12.5%"><strong>New resources</strong></td>
                                  <td>{{$enquiry_details[0]->new_resources}}</td>
                                  <td width="12.5%"><strong>Risk Management</strong></td>
                                  <td>{{$enquiry_details[0]->risk_mgmt}}</td>
                                  
                              </tr>
<!-- file -->
                </tbody></table>
                              
</body>

</html>

                         

                      

  
