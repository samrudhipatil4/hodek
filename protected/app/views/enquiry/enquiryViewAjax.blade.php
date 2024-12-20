<h5 class="border-none" ><strong>View Enquiry:- </strong></h5> 
                             <table class="striped">
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
                                        if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
                                        } 

                                    }?>
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
                                         if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
                                         } }?>
                                  </td>
                                  <td width="12.5%"><strong>Labeling</strong></td>
                                  <td>{{$enquiry_details[0]->labeling}}</td>
                                  <td width="12.5%"><strong>Labeling File</strong></td>
                                  <td>
                                        <?php foreach($file_details as $key => $value){
                                        if($value->type == 'Labeling'){
                                        "Labeling".$key; print_r($value->file_name);
                                         if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
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
                                         if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
                                         } }?>
                                  </td>
                                  <td width="12.5%"><strong>Any Other</strong></td>
                                  <td>{{$enquiry_details[0]->any_other}}</td>
                                  <td width="12.5%"><strong>Any Other File</strong></td>
                                  <td>
                                        <?php foreach($file_details as $key => $value){
                                         if($value->type == 'Any Other'){
                                         "Any Other".$key; print_r($value->file_name);
                                          if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
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
                                           if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
                                          } } ?>
                                  </td>
                                  <td width="12.5%"><strong>Customer Specific Requirement</strong></td>
                                  <td>{{$enquiry_details[0]->specific_req}}</td>
                                  <td width="12.5%"><strong>Specific Requirement File</strong></td>
                                  <td>
                                          <?php foreach($file_details as $key => $value){
                                           if($value->type == 'Specific Requirement'){
                                           "Specific Requirement".$key; print_r($value->file_name);
                                            if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
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
                                             if(!empty($value->file_name)){?><a href="<?php echo Request::root().'/download?path=enqDocument&filename='.$value->file_name;?>" data-position="bottom" data-delay="50" data-tooltip="Download"><i class="glyphicon glyphicon-download-alt"></i><?php echo '<br>';?></a><?php } ;
                                       }}?>
                                  </td> 
                              </tr>
                            </table>