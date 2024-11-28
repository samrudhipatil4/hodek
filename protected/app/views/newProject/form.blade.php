<html>
<head>
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
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('newProject?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
        <li class="active">{{ Lang::get('core.addedit') }} </li>
      </ul>
	  	  
    </div>
 
 	<div class="page-content-wrapper">

		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
<div class="sbox animated fadeInRight">
	<div class="sbox-title"> <h4> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> <small>{{ $pageNote }}</small></h4></div>
	<div class="sbox-content"> 	

		
<div class="col-md-12">
						<div class="tab">
  <button style="font-weight: bold;"  id="prjInfo">Project Information</button>
<button style="font-weight: bold;" id="btn_template">Template</button>
  <button style="font-weight: bold;"  id="gateInfo">Gate Information</button>
  <button style="font-weight: bold;" id="materl">Material</button>
  <button style="font-weight: bold;" id="deptteam" >Department and Team</button>
  <button style="font-weight: bold;"  id="gateclrece">Gate clearance</button>
</div>

<div id="project_info" class="tabcontent">
	<div class="form-group  " style="margin-top: -60px;
margin-bottom: 70px;"> 
									
									<div class="col-md-4">
									<select name='search_prj' id="search_prj" rows='5'  code='{$id}' 
							class='select2 '  required  ></select>
									  
									 </div> 
									 <div class="col-md-2" >
									 	<button id="searchProject">Search</button>
									 </div>
								  </div>	
<form name="project_info" class='form-horizontal' files = true id="project_info"  parsley-validate='' novalidate=' '>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Project Number<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('project_no', $row['project_no'],array('class'=>'form-control', 'placeholder'=>'', 'id'=>'project_no',  'required'=>'true','data-parsley-group'=>'first'  )) }} 
		</div>
	
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Project Name<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('project_name', $row['project_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'project_name','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > manufacturing location<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 <select name='mfg_location' id="mfg_location" rows='5'  code='{$id}' 
							class='select2 '  required  ></select> 
		</div>
	
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Project Start Date<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('project_start_date', '', array('id' => 'datepicker','class' => 'form-control','required'=>'true','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>
 <br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Document Number for Plan<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('document_no', '', array('id' => 'doc_no','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Project Leader and Top Management Approval<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 <select name='top_mgt_approval' id="top_mgt_approval" rows='5'  code='{$id}' 
							class='select2 '  required  ></select> 
		
		</div>
	</div>
</div>	
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > SOP Date</label>
		<div class="col-md-4">
		 {{ Form::text('sop_date', '', array('id' => 'sop_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer SOP Date</label>
		<div class="col-md-4">
		 {{ Form::text('cust_sop_date', '', array('id' => 'cust_sop_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>
	</div>
</div>	
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer</label>
		<div class="col-md-4">
		 <select name='customer' id="customer" rows='5'  code='{$id}' 
							class='select2 '  required  ></select> 
		</div>
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Enquiry ID </label>
		<div class="col-md-4">
		 <select name='enquiry_id' id="enquiry_id" rows='5'  code='{$id}' 
							class='select2 '    ></select> 
		</div>
	
	</div>
</div>							
<br>
	<div class="row">
			<div class="col-md-12">
				<label for="Change Type Name" class=" control-label col-md-2 text-left" > Part Number<span class="asterix"> * </span></label>
				<div class="col-md-4">
				 {{ Form::text('part_no', '', array('id' => 'part_no','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
				</div>

				<label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer Part Number<span class="asterix"> * </span></label>
				<div class="col-md-4">
				 {{ Form::text('cust_part_no', '', array('id' => 'cust_part_no','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
				</div>			 
			</div>
	</div>
<br>

<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer Prototype Quantity<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('cust_proto_qty', '', array('id' => 'cust_proto_qty','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>

		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer Prototype Date</label>
		<div class="col-md-4">
		 {{ Form::text('cust_proto_date', '', array('id' => 'cust_proto_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>			 
	</div>
</div>
<br>
		
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Customer PPAP Quantity<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('cust_ppap_qty', '', array('id' => 'cust_ppap_qty','class' => 'form-control','required'=>'true','data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>

		<label for="Change Type Name" class=" control-label col-md-2 text-left" >Customer PPAP Date</label>
		<div class="col-md-4">
		 {{ Form::text('cust_ppap_date', '', array('id' => 'cust_ppap_date','class' => 'form-control','onkeydown'=>"return false;",'data-parsley-group'=>'first' ,'autocomplete'=>'off'))}}
		</div>			 
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Engine Details<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('engine_details','',array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'engine_details','data-parsley'=>'second'  )) }} 
		</div>
	
	
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Engine Application Details<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('engine_appl_details', '',array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'engine_appl_details','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-md-12">
		<label for="Change Type Name" class=" control-label col-md-2 text-left" > Annual Volume Data<span class="asterix"> * </span></label>
		<div class="col-md-4">
		 {{ Form::text('annual_vol_data','',array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'annual_vol_data','data-parsley'=>'second'  )) }} 
		</div>
	</div>
</div>
<br>
<div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">				  
   <button  class="tablinks btn btn-primary btn-sm" id="save_project">Save</button>
    <button id="gate_infor" class="tablinks btn btn-primary btn-sm" onclick ="openCity(event, 'template_info','btn_template','prjInfo')">Next</button>
    </div>
    </div>
</form>
</div>


<div id="template_info" class="tabcontent">

<div class="form-group" id="projectTemplate">

</div>
 <div class="form-group  " >
	<label for="material" class=" control-label col-md-4 text-left" style="padding-left: 215px"> Template <span class="asterix"> * </span></label>
	<div class="col-md-6">
	   <select name='template' id="template" rows='5'  code='{$template_id}' 
class='select2 '  required  ></select>
	 </div> 
	 <div class="col-md-2">
	 	
	 </div>
  </div>
   <br> <br>
    <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">		
 
  <button class="tablinks btn btn-primary btn-sm" id="save_template">Add</button>
  
  </div>
  </div>

<br><br>
   <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">		
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity1(event,'project_info','prjInfo','btn_template')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" >Save</button>
  <button id="dept_info" class="tablinks btn btn-primary btn-sm" onclick="saveTemplate(event, 'gate_info','gateInfo','btn_template')">Next</button>
  </div>
  </div>
</div>


<div id="gate_info" class="tabcontent">
 
 	<div class="form-group  " id="gate">
			<!--<?php 
			
			$data = DB::table('apqp_gate_management_master')
				->select('apqp_gate_management_master.*')
				->where('apqp_gate_management_master.Is_Active',1)
				->orderby('id')
				->get();
				?>	--> 
				<!-- <table align="center" border="1"  width="70%" id="allGate">
					<tr>
					<td width="10%" align="center" >Sr.No.</td>
					<td width="40%" align="center">Gate</td>
					</tr>

					<?php $i=1; foreach($data as $key){ ?>
					<tr >
						<td><?php echo $i;?></td>
						<td><?php echo $key->Gate_Description;?></td>
						<input type="hidden" name="gateid" id="<?php echo $i;?>" value="<?php echo $key->id;?>">
					</tr>
					<?php $i++;}?>
				</table> -->					
								  </div>
								
								  <br><br>
		

  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">				  
   <button class="tablinks btn btn-primary btn-sm" onclick="openCity1(event,'template_info','btn_template','gateInfo')">Back</button>
 <button class="tablinks btn btn-primary btn-sm" id="saveGate">Save</button>
<button  class="tablinks btn btn-primary btn-sm" onclick="saveGate(event, 'material_info','materl','gateInfo')">Next</button>
    </div>
    </div>

</div>

<div id="material_info" class="tabcontent">
<div class="form-group" id="projectMaterial">

</div>
 <div class="form-group  " >
	<label for="material" class=" control-label col-md-4 text-left" style="padding-left: 215px"> Material <span class="asterix"> * </span></label>
	<div class="col-md-6">
	   <select name='material' id="material" rows='5'  code='{$id}' 
class='select2 '  required  ></select>
	 </div> 
	 <div class="col-md-2">
	 	
	 </div>
  </div>
   <br> <br>
    <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">		
 
  <button class="tablinks btn btn-primary btn-sm" id="save_material">Add</button>
  
  </div>
  </div>

<br><br>
   <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">		
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity1(event, 'gate_info','gateInfo','materl')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" >Save</button>
  <button id="dept_info" class="tablinks btn btn-primary btn-sm" onclick="saveMaterial(event, 'dept_team','deptteam','materl')">Next</button>
  </div>
  </div>
</div>
<div id="dept_team" class="tabcontent">
<div class="form-group" id="deptNUser">

</div>
<br><br>
								   <div class="form-group  " >
									
									<div class="col-md-3">
									   <input style="width: 98%;display: none" type="text" name=""  id="dept_name"  disabled>
									 </div> 
									 <div class="col-md-3" id="DnU" style="display: none">
									 	<select name='dept_user'  rows='5'  id="dept_user" rows='5'  code='{$id}' 
							class='select2 '  required  ></select>
							<input type="hidden" name="" id="dept_id">
									 </div>
									  <div class="col-md-2" id="subDnU" style="display: none">
									 	 <input style="width: 50%" type="submit" name="" value="ADD" id="add_deptNuser">
									 </div>


									
								  </div>
								  <br><br>
								   

 <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity1(event, 'material_info','materl','deptteam')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" >Save</button>
  <button class="tablinks btn btn-primary btn-sm" onclick="saveDeptNTeam(event, 'gate_clearance','gateclrece','deptteam')">Next</button>
  </div>
  </div>
</div>
<div id="gate_clearance" class="tabcontent">
  <div class="form-group" id="gate_clearence_auth">
  	
  </div>
  <br> <br>
								   <div class="form-group" id="gateclr" style="display:block">
									
									 <div class="col-md-3">
									 	<select name='all_user[]' multiple id="all_user" rows='5'  code='{$id}' 
							class='select2 '  required  ></select>
									 </div>
									  <div class="col-md-2" id>
									 	 <input style="width: 50%" type="submit" name="submitUser"  value="ADD" id="submitUser"></select>
									 	 <input type="hidden" name="hidden_gate" id="hidden_gate">
									 </div>


									
								  </div>
								   <br> <br>


   <div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-8">
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'dept_team','deptteam','gateclrece')">Back</button>
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

   $("#searchProject").click(function(){
   	var no=$("#search_prj").val();
   	if(no==''){
   		alert("plase enter project no");
   	}else{
   		$.ajax({
                   url:base_url+'searchProject',
                    type: 'POST',
                    data:{projectno:no},
                    beforeSend: function(){
                    $("#fade").show();
                },
                    success: function (data) {
                    	if(data.trim()=='No'){
                    		alert('project not avilable');
                    	}else{
                    		 $("#fade").hide();
                    		 var myArray = jQuery.parseJSON(data);
					       jQuery(myArray).each(function( index, element ) {     
					       	$("#project_no").val(element.project_no);
					       $("#project_name").val(element.project_name);
					        $("#customer").val(element.customer).change();
					        $("#mfg_location").val(element.mfg_location).change();
					        $("#datepicker").val(element.project_start_date);
					        $("#doc_no").val(element.document_no);
					        $("#top_mgt_approval").val(element.top_mgt_approval).change();
							$("#part_no").val(element.part_no);
							$("#cust_part_no").val(element.cust_part_no);
							$("#cust_proto_qty").val(element.cust_proto_qty);
							$("#cust_proto_date").val(element.cust_proto_date);
							$("#cust_ppap_qty").val(element.cust_ppap_qty);
							$("#cust_ppap_date").val(element.cust_ppap_date);
							$("#engine_details").val(element.engine_details);
							$("#engine_appl_details").val(element.engine_appl_details);
							$("#annual_vol_data").val(element.annual_vol_data);

					        if(element.sop_date != '0000-00-00'){
					        	  $("#sop_date").val(element.sop_date);
					        }
					         if(element.cust_sop_date != '0000-00-00'){
					        	  $("#cust_sop_date").val(element.cust_sop_date);
					        }
					      
					       
					       });
						}
				    }
                    
                    
               
		        });
   	}
   });
	$(document).ready(function() { 
		 $("#mfg_location").jCombo("{{ URL::to('newProject/comboselect?filter=plant_code:plant_id:plant_code') }}",
		{  selected_value : '{{ $row["mfg_location"] }}' }); 
		 $("#top_mgt_approval").jCombo("{{ URL::to('newProject/comboselect?filter=tb_users:id:first_name|last_name') }}",
		 {  selected_value : '{{ $row["top_mgt_approval"] }}' }); 
		  $("#depat").jCombo("{{ URL::to('newProject/comboselect?filter=apqp_material_master:id:material_description') }}",
		{  selected_value : '{{ $row["mfg_location"] }}' }); 

		  $("#template").jCombo("{{ URL::to('newProject/comboselect?filter=apqp_templatemaster:template_id:template_desc') }}",
		{  selected_value : '{{ $row["template"] }}' });
		 

	});
	$.ajax({
		url:base_url+'getCust',
		type:'post',
		data:{},
		success:function(data){
			$("#customer").html(data);
		}
	});

		$.ajax({
		url:base_url+'getEnquiry',
		type:'post',
		data:{},
		success:function(data){
			$("#enquiry_id").html(data);
		}
	});
	$.ajax({
                   url:base_url+'getIncomPrj',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#fade").hide();
                    		$("#search_prj").html(data);
                    	}
                });
	$.ajax({
                   url:base_url+'getComponent',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	
                    		$("#material").html(data);
                    	}
               
		        });

	$("#save_project").click(function(evt){
	var project_no =$("#project_no").val();
	var project_name =$("#project_name").val();
	var location =$("#mfg_location").val();
	var date =$("#datepicker").val();
	var top_app =$("#top_mgt_approval").val();
	var doc_no =$("#doc_no").val();
	var sop_date =$("#sop_date").val();
	var cust_sop_date =$("#cust_sop_date").val();
	var customer =$("#customer").val();
	var enquiry_id = $("#enquiry_id").val();
	var part_no =$("#part_no").val();
	var cust_part_no =$("#cust_part_no").val();
	var cust_proto_qty =$("#cust_proto_qty").val();
	var cust_proto_date =$("#cust_proto_date").val();
	var cust_ppap_qty =$("#cust_ppap_qty").val();
	var cust_ppap_date =$("#cust_ppap_date").val();
	var engine_details =$("#engine_details").val();
	var engine_appl_details =$("#engine_appl_details").val();
	var annual_vol_data =$("#annual_vol_data").val();

	 if(project_no == ''){
	 	alert('Enter project number');
	 }else
	 if(project_name == ''){
	 	alert('Enter project name');
	 }else
	 if(location == ''){
	 	alert('Select manufacturing location ');
	 }else
	 if(date == ''){
	 	alert('Select  Project Start Date');
	 }else
	 if(doc_no == ''){
	 	alert('Enter  Document Number for Plan');
	 }else
	 if(top_app == ''){
	 	alert('Select  Top Management Approval');
	 }else
	 if(customer == ''){
	 	alert('Select Select customer');
	 }else{
          
	evt.preventDefault();
			
			$.ajax({
                   url:base_url+'SaveProject',
                    type: 'POST',
                    data:{projectNo:project_no,proj_name:project_name,location:location,date:date,doc_no:doc_no,top_app:top_app,sop_date:sop_date,cust_sop_date:cust_sop_date,customer:customer,enquiry_id:enquiry_id,part_no:part_no,cust_part_no:cust_part_no,cust_proto_qty:cust_proto_qty,cust_proto_date:cust_proto_date,cust_ppap_qty:cust_ppap_qty,cust_ppap_date:cust_ppap_date,engine_details:engine_details,engine_appl_details:engine_appl_details,annual_vol_data:annual_vol_data},
                    beforeSend: function(){
                    $("#fade").show();
                },
                    success: function (data) {
                    	$("#fade").hide();
                    if(data.trim() == 'Duplicate project'){
                    		alert('Duplicate project');
                    	}
                    	}
               
		        });
		}
	});


$("#add_dept").click(function(){

	var dept = $("#dept_name").val();
	
	
	if(dept == ""){
	
		alert("Department is not selected");
	
	}else{	
		
		var temp = $("#temp_id").val();
		 $.ajax({
                   url:base_url+'addDept',
                    type: 'POST',
                    data:{d_id:d_id,user:user},
                    
                    success: function (data) {
                    		 $.ajax({
			                   url:base_url+'deptNUser',
			                    type: 'POST',
			                    data:{template:temp},
			                    
			                    success: function (data) {
			                    	$('.select2-search-choice').remove(); 

			                    	$("#deptNUser").html(data);
			                    	
			                   
			                    }
		               
				        });
                    }
               
		        });
		}

	
});

$("#add_deptNuser").click(function(){

	var dept = $("#dept_name").val();
	var user = $("#dept_user").val();
	var d_id =$("#dept_id").val(); 
	var temp =$("#temp_id").val();
	if(dept == ""){
	
		alert("Department is not selected");
	}else if(user == '' || user== null)	{
		
		alert("User is not selected");
	}else{	
		
		
		 $.ajax({
                   url:base_url+'addUser',
                    type: 'POST',
                    data:{d_id:d_id,user:user},
                    
                    success: function (data) {
                    		 $.ajax({
			                   url:base_url+'deptNUser',
			                    type: 'POST',
			                    data:{template:temp},
			                    
			                    success: function (data) {
			                    	$('.select2-search-choice').remove(); 

			                    	$("#deptNUser").html(data);
			                    	$("#DnU").hide(); 
				                  	$("#dept_name").hide(); 
				                  	$("#subDnU").hide();
				                  	$("#dept_user").html(); 
			                   		
			                    }
		               
				        });
                    }
               
		        });
		}

	
});

$("#submitUser").click(function(){

	var gate_id = $("#hidden_gate").val();
	var user = $("#all_user").val();
	
	
	if(user == '' || user== null)	{
		alert('Please select user');
		
	}else{	
		var temp = $("#temp_id").val();
		
		 $.ajax({
                   url:base_url+'addAllUser',
                    type: 'POST',
                    data:{gate_id:gate_id,user:user},
                    
                    success: function (data) {
                    		 $.ajax({
			                   url:base_url+'clearance',
			                    type: 'POST',
			                    data:{template:temp},
			                    
			                    success: function (data) {
			                    	document.getElementById('gateclr').style.display = "none";
			                    	$("#gate_clearence_auth").html(data);
			                    	$('.select2-search-choice').remove(); 

			                    	
			                    	
			                   
			                    }
		               
				        });
                    }
               
		        });
		}

	
});



function getUser(d_id){
	
	var name =$("#d"+d_id).val(); 

	
	$("#dept_name").val(name); 
		$.ajax({
                   url:base_url+'getUser',
                    type: 'POST',
                    data:{d_id:d_id},
                    
                    success: function (data) {
                    	$('#dept_user').select2('val','');
                    	$("#DnU").show(); 
                  	$("#dept_name").show(); 
                  	$("#subDnU").show(); 
                  		$("#select2-chosen-4").val();
                    	$("#dept_user").html(data); 
                    	$("#dept_id").val(d_id); 
                  	$("#dept_name").val(name); 
                  
                    }
               
		        });
}
	</script>
	<script>
function openCity(evt, cityName,divIdA,divIdU) {
	
	var project_no =$("#project_no").val();
	var project_name =$("#project_name").val();
	var location =$("#mfg_location").val();
	var date =$("#datepicker").val();
	var top_app =$("#top_mgt_approval").val();
	var doc_no =$("#doc_no").val();
	var sop_date =$("#sop_date").val();
	var cust_sop_date =$("#cust_sop_date").val();
	var customer =$("#customer").val();
	var enquiry_id = $("#enquiry_id").val();
	var part_no =$("#part_no").val();
	var cust_part_no =$("#cust_part_no").val();
	var cust_proto_qty =$("#cust_proto_qty").val();
	var cust_proto_date =$("#cust_proto_date").val();
	var cust_ppap_qty =$("#cust_ppap_qty").val();
	var cust_ppap_date =$("#cust_ppap_date").val();
	var engine_details =$("#engine_details").val();
	var engine_appl_details =$("#engine_appl_details").val();
	var annual_vol_data =$("#annual_vol_data").val();

	if(project_no == "" || project_name == '' || location=='' || date=='' || top_app=='' || doc_no==''){
		
	}else{
			 evt.preventDefault();
			$.ajax({
                   url:base_url+'SaveProject',
                    type: 'POST',
                    data:{projectNo:project_no,proj_name:project_name,location:location,date:date,doc_no:doc_no,top_app:top_app,sop_date:sop_date,cust_sop_date:cust_sop_date,customer:customer,enquiry_id:enquiry_id,part_no:part_no,cust_part_no:cust_part_no,cust_proto_qty:cust_proto_qty,cust_proto_date:cust_proto_date,cust_ppap_qty:cust_ppap_qty,cust_ppap_date:cust_ppap_date,engine_details:engine_details,engine_appl_details:engine_appl_details,annual_vol_data:annual_vol_data},
                    
                    success: function (data) {
                    	$("#SessionProjectNo").val(data);
                    	if(data.trim() == 'Duplicate project'){
                    		alert('Duplicate project');
                    	}else{
                    		
                    		$.ajax({
                   url:base_url+'getTemplate',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#projectTemplate").html(data);
                    		
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
							   // evt.currentTarget.className += "active";
						}

       				}
               
				});
   			 }

}
function saveGate(evt, cityName,divIdA,divIdU) {
	
	
	var rowCount = $('#allGate tr').length;
	var i;
	var projGate = [];
	for(i=1;i<rowCount;i++){
		var id=i;
		var gate =$("#"+id).val();
		 projGate.push({ val: gate }); 
		
	}
		
		if(projGate.length == 0){
			alert('Gate is not defined');
		}else{
			 evt.preventDefault();
			 // $.ajax({
    //                url:base_url+'checkCommonAct',
    //                 type: 'POST',
    //                 data:{gate:projGate},
                    
    //                 success: function (data) {
    //                 	if(data.trim()== 'noactivity'){
    //                 		alert('Common activity is not defined for all gate please add activity');
    //                 	}else{
                    		
                    	
			$.ajax({
                   url:base_url+'SaveGate',
                    type: 'POST',
                    data:{gate:projGate},
                    beforeSend: function(){
                    $("#fade").show();
                },
                    success: function (data) {
                    	$("#fade").hide();
                    	$("#SessionProjectNo").val(data);
                    		
                    	}
                
		        });
			
			

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
    document.getElementById("gateInfo").className = "active";
     document.getElementById(divIdA).className = "active";
    $('#'+divIdU).removeClass('active');
		// }
  //   }
                
		//         });
    }

}
$("#saveGate").click(function(evt){
	
	
	var rowCount = $('#allGate tr').length;
	var i;
	var projGate = [];
	for(i=1;i<rowCount;i++){
		var id=i;
		var gate =$("#"+id).val();
		 projGate.push({ val: gate }); 
		
	}
		
		if(projGate.length == 0){
			alert('Gate is not defined');
		}else{
			 evt.preventDefault();
			  // $.ajax({
     //               url:base_url+'checkCommonAct',
     //                type: 'POST',
     //                data:{gate:projGate},
                    
     //                success: function (data) {
     //                	if(data.trim()== 'noactivity'){
     //                		alert('Common activity is not defined for all gate please add activity');
     //                	}else{
			$.ajax({
                   url:base_url+'SaveGate',
                    type: 'POST',
                    data:{gate:projGate},
                    
                    success: function (data) {
                    	if(data.trim()=='noactivity'){
                    		alert('Please define activity for all gate');
                    	}
                    	$("#SessionProjectNo").html(data);
                    
                    }
               
		        });
			// }
   //  }
                
		 //        });
    
    }

});

function saveTemplate(evt, cityName,divIdA,divIdU) {
	
	var temp = $("#temp_id").val();
	var rowCount = $('#allTemplate tr').length;
	if(temp == ""){
		alert('Please add template');

	}else{


		$.ajax({
                   url:base_url+'checkCommonAct',
                    type: 'POST',
                    data:{template:temp},
                    
                    success: function (data) {
                    	if(data.trim()== 'noactivity'){
                    		alert(' activity is not defined for selected template.Please add activity');
                    	}else{
		$.ajax({
                   url:base_url+'getGetInfo',
                    type: 'POST',
                    data:{template:temp},
                    
                    success: function (data) {
                    	$("#gate").html(data);
                    		
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

function saveMaterial(evt, cityName,divIdA,divIdU) {
	
	var template = $("#temp_id").val();
	var rowCount = $('#allMaterial tr').length;
	//if(rowCount == 1){
	// 	alert('Please add material');

	// }else{
		$.ajax({
                   url:base_url+'deptNUser',
                    type: 'POST',
                    data:{template:template},
                    
                    success: function (data) {
                    	$("#deptNUser").html(data);
                    	
                    	
                  	
                  
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
   //}

}

$("#save_template").click(function(){
	var temp = $("#template").val();
	if(temp == ''){
		alert('Please select template');
	}else{

		$.ajax({
                   url:base_url+'checkCommonAct',
                    type: 'POST',
                    data:{template:temp},
                    
                    success: function (data) {
                    	if(data.trim()== 'noactivity'){
                    		alert('Activity is not defined for selected template.Please add activity.');
                    	}else{
		 
        	
       			$.ajax({
                   url:base_url+'SaveTemplate',
                    type: 'POST',
                    data:{template:temp},
                    
                    success: function (data) {
                    	$("#SessionProjectNo").val(data);
                    	
                    	
                   $.ajax({
                   url:base_url+'getTemplate',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#projectTemplate").html(data); 
                    		//document.getElementById("template").disabled=true;
                    	}
               		 });
                 } 
                });
       		}
       	}
       	});
    	}
});

$("#save_material").click(function(){
	var matrl = $("#material").val();
	var temp = $("#temp_id").val();
	if(matrl != ''){
	// 	alert('Please select material');
	// }else{
		 $.ajax({
		 url:base_url+'checkCommodityAct',
        type: 'POST',
        data:{material:matrl,template:temp},
        
        success: function (data) {
        	//$("#projectMaterial").html(data); 
        		if(data.trim()=='noact'){
        			alert('Commodity activity is not defined for this material');
        		}else{
        	
       			$.ajax({
                   url:base_url+'Savematerial',
                    type: 'POST',
                    data:{material:matrl},
                    
                    success: function (data) {
                    	$("#SessionProjectNo").val(data);
                    	
                    	if(data.trim() == 'Material Already added'){
                    		alert(data);
                    	}
                   $.ajax({
                   url:base_url+'getMaterial',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#projectMaterial").html(data); 
                    		
                    	}
               		 });
                  	
                  
                    }
               
		        });
       		}
		 }
    		 });
	}
});
function getAllUser(gate_id){
	
	$.ajax({
                   url:base_url+'getAllUser',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	
                    	document.getElementById('gateclr').style.display = "block";
                    	$("#all_user").html(data); 
                    	$("#hidden_gate").val(gate_id)
                    	
                    		
                    	}
                
		        });
}
function saveDeptNTeam(evt, cityName,divIdA,divIdU) {
	var temp = $("#temp_id").val();
	document.getElementById('gateclr').style.display = "none";
	$.ajax({
                   url:base_url+'clearance',
                    type: 'POST',
                    data:{template:temp},
                    
                    success: function (data) {
                    	$("#gate_clearence_auth").html(data); 
                    	
                    	
                    		
                    	}
                
		        });
	var rowCount = $('#deptUser tr').length;
	var i;
	
	for(i=1;i<rowCount;i++){
		var id='id'+i;

		var user =$("#"+id).val();
		
		
	}
		
		if(user == ''){
			alert('plase select all user');
		}else{
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
$("#finalsave").click(function(){
		    
	var rowCount = $('#clearanceTeam tr').length;
	var i;
	
	for(i=1;i<rowCount;i++){
		var id='gate_id'+i;

		var user =$("#"+id).val();
		
		
	}
		
		if(user == ''){
			alert('please select all user');
		}else{
		$.ajax({
                   url:base_url+'changeFlag',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    		window.location.href = base_url+"newProject";	
                    	}
                
		        });	 
		
	}
});


</script>	
<script>
$(function() {
	  
$( "#datepicker").datepicker({endDate: '<?php echo date('m-d-Y'); ?>'});
$( "#sop_date").datepicker({format: 'mm/dd/yyyy'});
$( "#cust_sop_date").datepicker({format: 'mm/dd/yyyy'});
$( "#cust_proto_date").datepicker({format: 'mm/dd/yyyy'});
$( "#cust_ppap_date").datepicker({format: 'mm/dd/yyyy'});

$('#project_no').keyup(function()
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