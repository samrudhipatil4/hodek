<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
<?php require app_path().'/views/apqp_header1.php'; ?>
<style>
table, th, td {
    
     padding: 5px 3px 5px 8px;
}
/*body {font-family: "Lato", sans-serif;}*/

/* Style the tab */
div.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */

div.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
div.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
div.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 100px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>
</head>
<body onload="openCity1(event, 'project_info','prjInfo')">
    <div style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0.3; z-index: 99999; display:none" id="fade"></div>
 
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
    </div>
 
 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-content"> 	

		
<div class="col-md-12">
						<div class="tab">
  <button style="font-weight: bold;"  id="prjInfo">Enquiry Details</button>
<button style="font-weight: bold;" id="btn_template">Voice Of Customer</button>
  <button style="font-weight: bold;"  id="gateInfo">Team Experience</button>
  <button style="font-weight: bold;" id="materl">Customer Business Plan</button>
  <button style="font-weight: bold;" id="deptteam" >Product/Process Benchmark</button>
  <button style="font-weight: bold;"  id="gateclrece">Risk Management Analysis</button>
</div>

<div id="project_info" class="tabcontent">
<form name="project_info" class='form-horizontal' files = true id="project_info_frm"  parsley-validate='' novalidate=' ' enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <label for="Change Type Name" class=" control-label col-md-2 text-left" > Enquiry Number<span class="asterix"> * </span></label>
            <div class="col-md-4">
             {{ Form::text('enquiry_no','',array('class'=>'form-control', 'placeholder'=>'', 'id'=>'enquiry_no',  'required'=>'true','data-parsley-group'=>'first'  )) }} 
            </div>
        
            <label for="Change Type Name" class=" control-label col-md-2 text-left" >Enquiry Date</label>
            <div class="col-md-4">
             {{ Form::text('enquiry_date', '', array('id' => 'enquiry_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
            </div>
        </div>
    </div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 <select name='customer' id="customer" rows='5'  code='{$id}' class='select2 '  required  ></select> 
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer Revision Number</label>
		<div class="col-md-4">
		 {{ Form::text('cust_rev', '', array('id' => 'cust_rev','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
 <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer Part Number</label>
		<div class="col-md-4">
		 {{ Form::text('cust_part_no', '', array('id' => 'cust_part_no','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer Contact Person</label>
		<div class="col-md-4">
		{{ Form::text('cust_cont_person', '', array('id' => 'cust_cont_person','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>	
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer contact Number</label>
		<div class="col-md-4">
		 {{ Form::text('cust_person_no', '', array('id' => 'cust_person_no','class' => 'form-control','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	
		<label for="email" class=" control-label col-md-2 text-left" >Customer Person Email</label>
		<div class="col-md-4">
		 {{ Form::text('cust_person_email', '', array('id' => 'cust_person_email','class' => 'form-control','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>	
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Engine Details</label>
		<div class="col-md-4">
		 {{ Form::text('engine_details','',array('class'=>'form-control', 'placeholder'=>'','id'=>'engine_details','data-parsley'=>'second'  )) }} 
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Engine Application Details</label>
		<div class="col-md-4">
		 {{ Form::text('engine_appl_details', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'engine_appl_details','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Similar Product Mfg.</label>
		<div class="col-md-4">
		 {{ Form::text('similar_product_mfg','',array('class'=>'form-control', 'placeholder'=>'','id'=>'similar_product_mfg','data-parsley'=>'second'  )) }} 
		</div>
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Internal Customer Name</label>
		<div class="col-md-4">
		 {{ Form::text('internal_cust', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'internal_cust','data-parsley'=>'second'  )) }} 
	</div>
</div>
<br><br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Estimated Cost Of Damper</label>
		<div class="col-md-4">
		 {{ Form::text('estimated_cost','',array('class'=>'form-control', 'placeholder'=>'','id'=>'estimated_cost','data-parsley'=>'second'  )) }} 
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Proposal Deadline</label>
		<div class="col-md-4">
		 {{ Form::text('deadline', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'deadline','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
		
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Annual Volume YR1</label>
		<div class="col-md-4">
		 {{ Form::text('annual_volY1','',array('class'=>'form-control', 'placeholder'=>'','id'=>'annual_volY1','data-parsley'=>'second'  )) }} 
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Annual Volume YR2</label>
		<div class="col-md-4">
		 {{ Form::text('annual_volY2', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'annual_volY2','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Annual Volume YR3</label>
		<div class="col-md-4">
		 {{ Form::text('annual_volY3','',array('class'=>'form-control', 'placeholder'=>'','id'=>'annual_volY3','data-parsley'=>'second'  )) }} 
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Annual Volume YR4</label>
		<div class="col-md-4">
		 {{ Form::text('annual_volY4', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'annual_volY4','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Annual Volume YR5</label>
		<div class="col-md-4">
		 {{ Form::text('annual_volY5','',array('class'=>'form-control', 'placeholder'=>'','id'=>'annual_volY5','data-parsley'=>'second'  )) }} 
         <input type="file" name="annual_volume[]" id="annual_volume" multiple>
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > First Off Tool Sample</label>
		<div class="col-md-4">
		 {{ Form::text('proto_sample', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'proto_sample','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Prototype Date</label>
		<div class="col-md-4">
            {{ Form::text('proto_date', '', array('id' => 'proto_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > PILOT Batch</label>
		<div class="col-md-4">
		 {{ Form::text('pilot_batch', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'pilot_batch','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
   <br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > PILOT Date</label>
		<div class="col-md-4">
            {{ Form::text('pilot_date', '', array('id' => 'pilot_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Initial Sample/PPAP/PTR Batch</label>
		<div class="col-md-4">
		 {{ Form::text('ppap_batch', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'ppap_batch','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
   <br>
   <div class="row">
	<div class="col-md-12">
        <label for="Change Type Name" class=" control-label col-md-2 text-left" > Sample/PPAP/PTR Date</label>
		<div class="col-md-4">
            {{ Form::text('ppap_date', '', array('id' => 'ppap_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>

		<label for="Change Type Name" class=" control-label col-md-2 text-left" > SOP Date</label>
		<div class="col-md-4">
			{{ Form::text('sop_date', '', array('id' => 'sop_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
   <br>
   <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Packaging</label>
		<div class="col-md-4">
		 {{ Form::text('packaging', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'packaging','data-parsley'=>'second'  )) }}
         <input type="file" name="pack[]" id="pack"> 
		</div>
        <label for="Change Type Name" class=" control-label col-md-2 text-left" > Labeling</label>
		<div class="col-md-4">
		 {{ Form::text('labeling','',array('class'=>'form-control', 'placeholder'=>'','id'=>'labeling','data-parsley'=>'second'  )) }} 
         <input type="file" name="label[]" id="label">
		</div>
	</div>
</div>
   <br>
   <div class="row">
	<div class="col-md-12">
		
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Painting</label>
		<div class="col-md-4">
		 {{ Form::text('painting', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'painting','data-parsley'=>'second'  )) }} 
         <input type="file" name="paint[]" id="paint">
		</div>
        <label for="Change Type Name" class=" control-label col-md-2 text-left" > Any Other</label>
		<div class="col-md-4">
		 {{ Form::text('any_other','',array('class'=>'form-control', 'placeholder'=>'','id'=>'any_other','data-parsley'=>'second'  )) }}
         <input type="file" name="any[]" id="any"> 
		</div>
	</div>
</div>
   <br>
   <div class="row">
	<div class="col-md-12">
		
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Engine Data Sheet</label>
		<div class="col-md-4">
		 {{ Form::text('engine_data', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'engine_data','data-parsley'=>'second'  )) }} 
         <input type="file" name="engine[]" id="engine">
		</div>
        <label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer Specific Requirement</label>
		<div class="col-md-4">
		 {{ Form::text('specific_req','',array('class'=>'form-control', 'placeholder'=>'','id'=>'specific_req','data-parsley'=>'second'  )) }} 
         <input type="file" name="specific[]" id="specific">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > SOP Quantity</label>
		<div class="col-md-4">
		 {{ Form::text('sop_quantity', '',array('class'=>'form-control', 'placeholder'=>'','id'=>'sop_quantity','data-parsley'=>'second'  )) }} 
         
		</div>
        
	</div>
</div>
   <br>
   
<div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">				  
   <button  class="tablinks btn btn-primary btn-sm" id="save_project">Save</button>
    <button id="gate_infor" class="tablinks btn btn-primary btn-sm" onClick ="openCity(event, 'template_info','btn_template','prjInfo')">Next</button>
    </div>
    </div>
</form>
</div>
</div>
<div id="template_info" class="tabcontent">
    <form name="template_info" class='form-horizontal' files = true id="template_info"  parsley-validate='' novalidate=' '>

<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer Interview<span class="asterix"> * </span></label>
		<div class="col-md-4">
            {{ Form::text('cust_interview', '', array('id' => 'cust_interview','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
        </div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Name of the Interviewee</label>
		<div class="col-md-4">
		 {{ Form::text('name_interview', '', array('id' => 'name_interview','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
 <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Name of the Interviewer </label>
		<div class="col-md-4">
            {{ Form::text('name_interviewer', '', array('id' => 'name_interviewer','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
        </div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Inputs/Data Collected</label>
		<div class="col-md-4">
		 {{ Form::text('input_data', '', array('id' => 'input_data','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
 <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Competitors Name </label>
		<div class="col-md-4">
            {{ Form::text('competitors', '', array('id' => 'competitors','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
        </div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Product Name</label>
		<div class="col-md-4">
		 {{ Form::text('product_name', '', array('id' => 'product_name','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
 <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Product & Quality  Information </label>
		<div class="col-md-4">
            {{ Form::text('product_quality', '', array('id' => 'product_quality','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
        </div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > TGR Reports</label>
		<div class="col-md-4">
		 {{ Form::text('tgr_report', '', array('id' => 'tgr_report','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
 <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >TGW Product/Name</label>
		<div class="col-md-4">
            {{ Form::text('tgw_product_name', '', array('id' => 'tgw_product_name','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
        </div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Discrepancy  Observed</label>
		<div class="col-md-4">
		 {{ Form::text('discrepancy', '', array('id' => 'discrepancy','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
 <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Probable Causes  for Discrepancy</label>
		<div class="col-md-4">
            {{ Form::text('cause_discrepancy', '', array('id' => 'cause_discrepancy','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
        </div>
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer plant returns & Rejection</label>
		<div class="col-md-4">
		 {{ Form::text('return_reject', '', array('id' => 'return_reject','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
 <div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Field  return Product Analysis</label>
		<div class="col-md-4">
            {{ Form::text('field_return', '', array('id' => 'field_return','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
        </div>
	</div>
</div>
<br><br>
   <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">		
  <button class="tablinks btn btn-primary btn-sm" onClick="openCity1(event,'project_info','prjInfo','btn_template')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" id="save_template" >Save</button>
  <button id="dept_info" class="tablinks btn btn-primary btn-sm" onClick="saveTemplate(event, 'gate_info','gateInfo','btn_template')">Next</button>
  </div>
  </div>
</form>
</div>


<div id="gate_info" class="tabcontent">
    <form name="gate_info" class='form-horizontal' files = true id="gate_info"  parsley-validate='' novalidate=' '>
        <div class="row">
            <div class="col-md-12">
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer Letters/suggestion<span class="asterix"> * </span></label>
                <div class="col-md-4">
                    {{ Form::text('cust_suggestions', '', array('id' => 'cust_suggestions','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Field service reports</label>
                <div class="col-md-4">
                 {{ Form::text('service_report', '', array('id' => 'service_report','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            </div>
        </div>
         <br>
         <div class="row">
            <div class="col-md-12">
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Transportation & Primiunm Freight</label>
                <div class="col-md-4">
                    {{ Form::text('transportation', '', array('id' => 'transportation','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Goverment requirements & regulations</label>
                <div class="col-md-4">
                 {{ Form::text('requirement_regulation', '', array('id' => 'requirement_regulation','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            </div>
        </div>    
        <br>
        <div class="row">
           <div class="col-md-12">
               <label for="Change Type Name" class=" control-label col-md-2 text-left" >Problems & issues Report from Internal customer</label>
               <div class="col-md-4">
                   {{ Form::text('internal_custo', '', array('id' => 'internal_custo','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
               </div>
               <label for="Change Type Name" class=" control-label col-md-2 text-left" >TGR / TGW:</label>
		        <div class="col-md-4">
                   {{ Form::text('tgr_tgw', '', array('id' => 'tgr_tgw','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
           </div>
       </div>							
	<br>
  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">				  
   <button class="tablinks btn btn-primary btn-sm" onClick="openCity1(event,'template_info','btn_template','gateInfo')">Back</button>
 <button class="tablinks btn btn-primary btn-sm" id="saveTeamExp">Save</button>
<button  class="tablinks btn btn-primary btn-sm" onClick="saveTeamExpFun(event, 'material_info','materl','gateInfo')">Next</button>
    </div>
    </div>
</form>
</div>



<div id="material_info" class="tabcontent">
    <form name="material_info" class='form-horizontal' files = true id="material_info"  parsley-validate='' novalidate=' '>
        <div class="row">
            <div class="col-md-12">
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Time constriants<span class="asterix"> * </span></label>
                <div class="col-md-4">
                    {{ Form::text('time_constriants', '', array('id' => 'time_constriants','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Cost constraint</label>
                <div class="col-md-4">
                 {{ Form::text('cost_constraint', '', array('id' => 'cost_constraint','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            </div>
        </div>
         <br>
         <div class="row">
            <div class="col-md-12">
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Investment</label>
                <div class="col-md-4">
                    {{ Form::text('investment', '', array('id' => 'investment','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >key competitors</label>
                <div class="col-md-4">
                 {{ Form::text('key_competitor', '', array('id' => 'key_competitor','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            </div>
        </div> 
<br><br>
   <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">		
  <button class="tablinks btn btn-primary btn-sm" onClick="openCity1(event, 'gate_info','gateInfo','materl')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" id="saveBusinessPlan">Save</button>
  <button id="dept_info" class="tablinks btn btn-primary btn-sm" onClick="saveBusinessPlanFun(event, 'dept_team','deptteam','materl')">Next</button>
  </div>
  </div>
    </form>
</div>
    </div>
<div id="dept_team" class="tabcontent">
    <form name="dept_team" class='form-horizontal' files = true id="dept_team"  parsley-validate='' novalidate=' '>
        <div class="row">
            <div class="col-md-12">
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Performance<span class="asterix"> * </span></label>
                <div class="col-md-4">
                    {{ Form::text('performance', '', array('id' => 'performance','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >Cost</label>
                <div class="col-md-4">
                 {{ Form::text('cost', '', array('id' => 'cost','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            </div>
        </div>
         <br>
         <div class="row">
            <div class="col-md-12">
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >New Technology</label>
                <div class="col-md-4">
                    {{ Form::text('n_techno', '', array('id' => 'n_techno','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            
                <label for="Change Type Name" class=" control-label col-md-2 text-left" >New resources</label>
                <div class="col-md-4">
                 {{ Form::text('new_resources', '', array('id' => 'new_resources','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                </div>
            </div>
        </div>
        

 <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">
  <button class="tablinks btn btn-primary btn-sm" onClick="openCity1(event, 'material_info','materl','deptteam')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" id="saveBenchmark">Save</button>
  <button class="tablinks btn btn-primary btn-sm" onClick="saveBenchmarkFun(event, 'gate_clearance','gateclrece','deptteam')">Next</button>
  </div>
  </div>
    </form>
</div>


<div id="gate_clearance" class="tabcontent">
    <form name="gate_clearance" class='form-horizontal' files = true id="gate_clearance_frm"  parsley-validate='' novalidate=' '>
    <div class="row">
        <div class="col-md-12">
            <label for="Change Type Name" class=" control-label col-md-2 text-left" >Risk Management Analysis<span class="asterix"> * </span></label>
            <div class="col-md-4">
                {{ Form::text('risk_mgmt', '', array('id' => 'risk_mgmt','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
                <input type="file" name="risk[]" id="risk">
            </div>
        </div>
    </div>
    <br> <br>
   <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">
  <button class="tablinks btn btn-primary btn-sm" onClick="openCity(event, 'dept_team','deptteam','gateclrece')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" id="finalsave" >Save</button>
</div>
</div>
</div>
			</div>
			<div style="clear:both"></div>	
	</div>
</div>		 
</div>	
</div>	

  

<script type="text/javascript">
    var base_url='<?php echo Request::root(); ?>/';
     $.ajax({
         url:base_url+'getCust',
         type:'post',
         data:{},
         success:function(data){
             $("#customer").html(data);
         }
     });
 
   
    $("#save_project").click(function(evt){
            var enquiry_no =$("#enquiry_no").val();
            var enquiry_date =$("#enquiry_date").val();
            var customer =$("#customer").val();
            var cust_rev =$("#cust_rev").val();
            var cust_part_no =$("#cust_part_no").val();
            var cust_cont_person =$("#cust_cont_person").val();
            var cust_person_no =$("#cust_person_no").val();
            var cust_person_email =$("#cust_person_email").val();
            var engine_details =$("#engine_details").val();
            var engine_appl_details = $("#engine_appl_details").val();
            var similar_product_mfg =$("#similar_product_mfg").val();
            var internal_cust =$("#internal_cust").val();
            var estimated_cost =$("#estimated_cost").val();
            var deadline =$("#deadline").val();
            var annual_volY1 =$("#annual_volY1").val();
            var annual_volY2 =$("#annual_volY2").val();
            var annual_volY3 =$("#annual_volY3").val();
            var annual_volY4 =$("#annual_volY4").val();
            var annual_volY5 =$("#annual_volY5").val();
            var proto_sample =$("#proto_sample").val();
            var proto_date =$("#proto_date").val();
            var pilot_batch =$("#pilot_batch").val();
            var pilot_date =$("#pilot_date").val();
            var ppap_batch = $("#ppap_batch").val();
            var ppap_date = $("#ppap_date").val();
            var sop_date =$("#sop_date").val();
            var packaging =$("#packaging").val();
            var labeling =$("#labeling").val();
            var painting =$("#painting").val();
            var any_other =$("#any_other").val();
            var engine_data =$("#engine_data").val();
            var specific_req =$("#specific_req").val();
            var annual_volume =$("#annual_volume").val();
            var pack =$("#pack").val();
            var label =$("#label").val();
            var paint =$("#paint").val();
            var any =$("#any").val();
            var engine =$("#engine").val();
            var specific =$("#specific").val();
            var sop_quantity =$("#sop_quantity").val();
               if(enquiry_no == ''){
            alert('Enter enquiry number');
            }else
            if(customer == ''){
            alert('Select customer');
            }else{
           
            evt.preventDefault();
             
            $.ajax({
                    url:base_url+'saveEnquiry',
                    type: 'POST',
                    data:new FormData($("#project_info_frm")[0]),
                    contentType: false,
	                cache: false,
	                processData:false,
                    beforeSend: function(){
                     $("#fade").show();
                    },
                    success: function (data) {
                         $("#fade").hide();
                     if(data.trim() == 'Duplicate enquiry'){
                             alert('Duplicate enquiry');
                     }
                    }
                
                 });
         }
     });
 
     $("#save_template").click(function(evt){
        var cust_interview =$("#cust_interview").val();
        var name_interview =$("#name_interview").val();
        var name_interviewer =$("#name_interviewer").val();
        var input_data =$("#input_data").val();
        var competitors =$("#competitors").val();
        var product_name =$("#product_name").val();
        var product_quality =$("#product_quality").val();
        var tgr_report =$("#tgr_report").val();
        var tgw_product_name =$("#tgw_product_name").val();
        var discrepancy = $("#discrepancy").val();
        var cause_discrepancy =$("#cause_discrepancy").val();
        var return_reject =$("#return_reject").val();
        var field_return =$("#field_return").val();
        if(cust_interview == ''){
            alert('Enter customer interview');
        }else{
                
        evt.preventDefault();
             
             $.ajax({
                    url:base_url+'SaveVoice',
                     type: 'POST',
                     data:{
                        cust_interview:cust_interview, 
                        name_interview:name_interview,
                        name_interviewer:name_interviewer,
                        input_data:input_data,
                        competitors:competitors,
                        product_name:product_name,
                        product_quality:product_quality,
                        tgr_report:tgr_report,
                        tgw_product_name:tgw_product_name,
                        discrepancy:discrepancy,
                        cause_discrepancy:cause_discrepancy,
                        return_reject:return_reject,
                        field_return:field_return
                        },
                     beforeSend: function(){
                     $("#fade").show();
                 },
                     success: function (data) {
                         $("#fade").hide();
                     if(data.trim() == 'Duplicate enquiry'){
                             alert('Duplicate enquiry');
                         }
                         } 
                 });
         }
     });
 
     $("#saveTeamExp").click(function(evt){
        var cust_suggestions =$("#cust_suggestions").val();
        var service_report =$("#service_report").val();
        var transportation =$("#transportation").val();
        var requirement_regulation =$("#requirement_regulation").val();
        var internal_custo =$("#internal_custo").val();
        var tgr_tgw =$("#tgr_tgw").val();
        if(cust_suggestions == ''){
         alert('Enter customer suggestion');
        }else{
           
        evt.preventDefault();
             
             $.ajax({
                    url:base_url+'TeamExperience',
                     type: 'POST',
                     data:{
                        cust_suggestions:cust_suggestions, 
                        service_report:service_report,
                        transportation:transportation,
                        requirement_regulation:requirement_regulation,
                        internal_custo:internal_custo,
                        tgr_tgw:tgr_tgw
                       
                        },
                     beforeSend: function(){
                     $("#fade").show();
                 },
                     success: function (data) {
                         $("#fade").hide();
                     if(data.trim() == 'Duplicate enquiry'){
                             alert('Duplicate enquiry');
                         }
                         }
                
                 });
         }
     });
 
 
     $("#saveBusinessPlan").click(function(evt){
        // alert('in saveBusinessPlan');
        var time_constriants =$("#time_constriants").val();
        var cost_constraint  =$("#cost_constraint ").val();
        var investment   =$("#investment ").val();
        var key_competitor =$("#key_competitor").val();
             if(time_constriants == ''){
                 alert('Enter time constraint');
            }else{

           
             evt.preventDefault();
             
             $.ajax({
                    url:base_url+'CustBussiness',
                     type: 'POST',
                     data:{
                        time_constriants:time_constriants, 
                       cost_constraint:cost_constraint,
                       investment:investment,
                       key_competitor:key_competitor
                        },
                     beforeSend: function(){
                     $("#fade").show();
                 },
                     success: function (data) {
                         //alert('in saveBusinessPlan success');
                         $("#fade").hide();
                     if(data.trim() == 'Duplicate enquiry'){
                             alert('Duplicate enquiry');
                         }
                         }
                
                 });
         }
     });
     $("#saveBenchmark").click(function(evt){
      //   alert('In saveBenchmark');
            var performance =$("#performance").val();
            var cost  =$("#cost").val();
            var n_techno   =$("#n_techno").val();
            var new_resources =$("#new_resources").val();
                if(performance == ''){
                 alert('Enter performance');
                }else{
                evt.preventDefault();
                $.ajax({
                    url:base_url+'ProductBenchmark',
                    type: 'POST',
                    data:{
                        performance:performance, 
                        cost:cost,
                        n_techno:n_techno,
                        new_resources:new_resources
                        },
                     beforeSend: function(){
                     $("#fade").show();
                                            },
                     success: function (data) {
                        // alert('in saveBenchmark success')
                         $("#fade").hide();
                     if(data.trim() == 'Duplicate enquiry'){
                             alert('Duplicate enquiry');
                         }
                         }
                
                 });
         }
     });
 

     </script>
     <script>
 function openCity(evt, cityName,divIdA,divIdU) {
     
    var enquiry_no =$("#enquiry_no").val();
    var enquiry_date =$("#enquiry_date").val();
    var customer =$("#customer").val();
    var cust_rev =$("#cust_rev").val();
    var cust_part_no =$("#cust_part_no").val();
    var cust_cont_person =$("#cust_cont_person").val();
    var cust_person_no =$("#cust_person_no").val();
    var cust_person_email =$("#cust_person_email").val();
    var engine_details =$("#engine_details").val();
    var engine_appl_details = $("#engine_appl_details").val();
    var similar_product_mfg =$("#similar_product_mfg").val();
    var internal_cust =$("#internal_cust").val();
    var estimated_cost =$("#estimated_cost").val();
    var deadline =$("#deadline").val();
    var annual_volY1 =$("#annual_volY1").val();
    var annual_volY2 =$("#annual_volY2").val();
    var annual_volY3 =$("#annual_volY3").val();
    var annual_volY4 =$("#annual_volY4").val();
    var annual_volY5 =$("#annual_volY5").val();
    var proto_sample =$("#proto_sample").val();
    var proto_date =$("#proto_date").val();
    var pilot_batch =$("#pilot_batch").val();
    var pilot_date =$("#pilot_date").val();
    var ppap_batch = $("#ppap_batch").val();
    var ppap_date = $("#ppap_date").val();
    var sop_date =$("#sop_date").val();
    var packaging =$("#packaging").val();
    var labeling =$("#labeling").val();
    var painting =$("#painting").val();
    var any_other =$("#any_other").val();
    var engine_data =$("#engine_data").val();
    var specific_req =$("#specific_req").val();
    var annual_volume =$("#annual_volume").val();
    var pack =$("#pack").val();
    var label =$("#label").val();
    var paint =$("#paint").val();
    var any =$("#any").val();
    var engine =$("#engine").val();
    var specific =$("#specific").val();
    var sop_quantity = $("#sop_quantity").val();
    if(enquiry_no == ""){
        
    }else{
        evt.preventDefault();
        $.ajax({
                url:base_url+'saveEnquiry',
                type: 'POST',
                data: new FormData($("#project_info_frm")[0]),
                contentType: false,
                cache: false,
                processData:false,
                
                success: function (data) {
                        $("#SessionProjectNo").val(data);
                        if(data.trim() == 'Duplicate enquiry'){
                            alert('Duplicate enquiry');
                        }else{
                            
                            $.ajax({
                                url:base_url+'SaveVoice',
                                type: 'POST',
                                data:{},
                                
                                success: function (data) {
                                    $("#template_info").html(data);
                                        
                                }
                        
                            });

                        var i, tabcontent, tablinks;

                        tabcontent = document.getElementsByClassName("tabcontent");

                        for (i = 0; i < tabcontent.length; i++) {
                            tabcontent[i].style.display = "none";
                        }
                        tablinks = document.getElementsByClassName("tablinks");
                        for (i = 0; i < tablinks.length; i++) {
                            
                            tablinks[i].className = tablinks[i].className.replace("active", "");
                        }
                        document.getElementById(cityName).style.display = "block";
                        var gateId= document.getElementById(gateInfo);
                        document.getElementById(divIdA).className = "active";
                        $('#'+divIdU).removeClass('active');
                        evt.currentTarget.className += "active";
                        }
                } 
        });
    }
 }
 
 function saveTemplate(evt, cityName,divIdA,divIdU) {
     
    var cust_interview =$("#cust_interview").val();
    var name_interview =$("#name_interview").val();
    var name_interviewer =$("#name_interviewer").val();
    var input_data =$("#input_data").val();
    var competitors =$("#competitors").val();
    var product_name =$("#product_name").val();
    var product_quality =$("#product_quality").val();
    var tgr_report =$("#tgr_report").val();
    var tgw_product_name =$("#tgw_product_name").val();
    var discrepancy = $("#discrepancy").val();
    var cause_discrepancy =$("#cause_discrepancy").val();
    var return_reject =$("#return_reject").val();
    var field_return =$("#field_return").val();

    if(cust_interview == ""){
         alert('Please add customer interview');
    }else{
         $.ajax({
                    url:base_url+'SaveVoice',
                     type: 'POST',
                     data:{
                        cust_interview:cust_interview, 
                        name_interview:name_interview,
                        name_interviewer:name_interviewer,
                        input_data:input_data,
                        competitors:competitors,
                        product_name:product_name,
                        product_quality:product_quality,
                        tgr_report:tgr_report,
                        tgw_product_name:tgw_product_name,
                        discrepancy:discrepancy,
                        cause_discrepancy:cause_discrepancy,
                        return_reject:return_reject,
                        field_return:field_return
                     },
                     success: function (data) {
                         if(data.trim()== 'noactivity'){
                             alert(' activity is not defined for selected template.Please add activity');
                         }else{
         $.ajax({
                    url:base_url+'TeamExperience',
                     type: 'POST',
                     data:{},
                     
                     success: function (data) {
                         $("#gate_info").html(data);   
                         }
                 });
             }
           }
         });
     evt.preventDefault();
     var i, tabcontent, tablinks;
 
     tabcontent = document.getElementsByClassName("tabcontent");
     
     for (i = 0; i < tabcontent.length; i++) {
         tabcontent[i].style.display = "none";
     }
     tablinks = document.getElementsByClassName("tablinks");
    
     
     for (i = 0; i < tablinks.length; i++) {
         tablinks[i].className = tablinks[i].className.replace(" active", "");
     }
     document.getElementById(cityName).style.display = "block";
  document.getElementById(divIdA).className = "active";
    $('#'+divIdU).removeClass('active');
    }
 
 }
 
 function saveTeamExpFun(evt, cityName,divIdA,divIdU) {
    evt.preventDefault(); //avoid reloading page
    var cust_suggestions =$("#cust_suggestions").val();
    var service_report =$("#service_report").val();
    var transportation =$("#transportation").val();
    var requirement_regulation =$("#requirement_regulation").val();
    var internal_custo =$("#internal_custo").val();
    var tgr_tgw =$("#tgr_tgw").val();
    if(cust_suggestions == ""){
          alert('Please add customer suggestion');
      }else{
          $.ajax({
                     url:base_url+'TeamExperience',
                      type: 'POST',
                      data:{
                        cust_suggestions:cust_suggestions, 
                        service_report:service_report,
                        transportation:transportation,
                        requirement_regulation:requirement_regulation,
                        internal_custo:internal_custo,
                        tgr_tgw:tgr_tgw
                      },
                      success: function (data) {
                          if(data.trim()== 'noactivity'){
                              alert(' activity is not defined for selected template.Please add activity');
                          }else{
                            $.ajax({
                                    url:base_url+'CustBusiness',
                                    type: 'POST',
                                    data:{},
                                    
                                    success: function (data) {
                                        $("#material_info").html(data);   
                                    }
                                });
                            }
                        }
          });
      evt.preventDefault();
      var i, tabcontent, tablinks;
  
      tabcontent = document.getElementsByClassName("tabcontent");
      
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
     
      
      for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
   document.getElementById(divIdA).className = "active";
     $('#'+divIdU).removeClass('active');
     }
  
  }
  function saveBusinessPlanFun(evt, cityName,divIdA,divIdU) {
    var time_constriants =$("#time_constriants").val();
    var cost_constraint  =$("#cost_constraint ").val();
    var investment   =$("#investment ").val();
    var key_competitor =$("#key_competitor").val();
             if(time_constriants == ''){
                 alert('Enter time constraint');
            }else{
                
                $.ajax({
                      url:base_url+'CustBussiness',
                       type: 'POST',
                       data:{
                            time_constriants:time_constriants, 
                            cost_constraint:cost_constraint,
                            investment:investment,
                            key_competitor:key_competitor
                       },
                       success: function (data) {
                           if(data.trim()== 'noactivity'){
                               alert(' activity is not defined for selected template.Please add activity');
                           }else{
                $.ajax({
                      url:base_url+'ProductBenchmark',
                       type: 'POST',
                       data:{},
                       
                       success: function (data) {
                           $("#dept_team").html(data);   
                           }
                   });
               }
             }
           });
       evt.preventDefault();
       var i, tabcontent, tablinks;
   
       tabcontent = document.getElementsByClassName("tabcontent");
       
       for (i = 0; i < tabcontent.length; i++) {
           tabcontent[i].style.display = "none";
       }
       tablinks = document.getElementsByClassName("tablinks");
      
       
       for (i = 0; i < tablinks.length; i++) {
           tablinks[i].className = tablinks[i].className.replace(" active", "");
       }
       document.getElementById(cityName).style.display = "block";
    document.getElementById(divIdA).className = "active";
      $('#'+divIdU).removeClass('active');
      }
   
   }
   
   function saveBenchmarkFun(evt, cityName,divIdA,divIdU) {
        var performance =$("#performance").val();
        var cost  =$("#cost").val();
        var n_techno   =$("#n_techno").val();
        var new_resources =$("#new_resources").val();
            if(performance == ''){
                 alert('Enter performance');
            }else{
            $.ajax({
                       url:base_url+'ProductBenchmark',
                        type: 'POST',
                        data:{
                            performance:performance, 
                            cost:cost,
                            n_techno:n_techno,
                            new_resources:new_resources 
                        },
                        success: function (data) {
                            //alert('in saveBenchmarkFun success');
                            if(data.trim()== 'noactivity'){
                                alert(' activity is not defined for selected template.Please add activity');
                            }else{
            $.ajax({
                       url:base_url+'RiskManagement',
                        type: 'POST',
                        data:{},
                        
                        success: function (data) {
                            $("#gate_clearance").html(data);   
                            }
                    });
                }
              }
            });
        evt.preventDefault();
        var i, tabcontent, tablinks;
    
        tabcontent = document.getElementsByClassName("tabcontent");
        
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
       
        
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
     document.getElementById(divIdA).className = "active";
       $('#'+divIdU).removeClass('active');
       }
    
    }
  
    
  
 function openCity1(evt, cityName,divIdA,divIdU) {
     
     
     var i, tabcontent, tablinks;
 
     tabcontent = document.getElementsByClassName("tabcontent");
     
     for (i = 0; i < tabcontent.length; i++) {
         tabcontent[i].style.display = "none";
     }
     tablinks = document.getElementsByClassName("tablinks");
    
     
     for (i = 0; i < tablinks.length; i++) {
         tablinks[i].className = tablinks[i].className.replace(" active", "");
     }
     document.getElementById(cityName).style.display = "block";
     document.getElementById(divIdA).className = "active";
       $('#'+divIdU).removeClass('active');
 }

 $("#finalsave").click(function(e){
   // e.preventDefault(); //avoid loading page
    var risk_mgmt =$("#risk_mgmt").val();
    var risk =$("#risk").val();
    if(risk_mgmt == ''){
        alert('Enter risk_mgmt');
    }else{
        $.ajax({
                url:base_url+'RiskManagement',
                type: 'POST',
                data: new FormData($("#gate_clearance_frm")[0]),
                contentType: false,
                cache: false,
                processData:false,
                success: function (data) {
                   window.location.href = base_url+"enquiry";	
                }
        });	 
     }
 });
 
 
 </script>	
 <script>
 $(function() {
       
 $( "#enquiry_date").datepicker({format: 'mm/dd/yyyy'});
 $( "#proto_date").datepicker({format: 'mm/dd/yyyy'});
 $( "#pilot_date").datepicker({format: 'mm/dd/yyyy'});
 $( "#ppap_date").datepicker({format: 'mm/dd/yyyy'});
 $( "#sop_date").datepicker({format: 'mm/dd/yyyy'});
 $('#enquiry_no').keyup(function()
     {
         var yourInput = $(this).val();
         re = /[`~!@#$%^&*()|+\=?;:'",.<>\{\}\[\]\\\/]/gi;
         var isSplChar = re.test(yourInput);
         if(isSplChar)
         {
             var no_spl_char = yourInput.replace(/[`~!@#$%^&*()|+\=?;:'",.<>\{\}\[\]\\\/]/gi, '');
             $(this).val(no_spl_char);
         }
     });
 
 });
 </script>
 
 
 
     </body>
     </html>	 