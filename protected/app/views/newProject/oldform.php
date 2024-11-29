<html>
<head>
<style>
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
<body onload="openCity(event, 'project_info')">
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('CommodityMaster?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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
  <button style="font-weight: bold;" class="tablinks" >Project Information</button>
  <button style="font-weight: bold;" class="tablinks" >Gate Information</button>
  <button style="font-weight: bold;" class="tablinks" >Material</button>
  <button style="font-weight: bold;" class="tablinks" >Department and Team</button>
  <button style="font-weight: bold;" class="tablinks" >Gate clearance</button>
</div>

<div id="project_info" class="tabcontent">
<form name="project_info">
 	<div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left" style="padding-left: 250px"> Project Number<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('project_no', $row['project_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								 <br> <br>
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left" style="padding-left: 260px"> Project Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('project_no', $row['project_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <br> <br>
								   <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left" style="padding-left: 215px"> manufacturing location <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='mfg_location' id="mfg_location" rows='5'  code='{$id}' 
							class='select2 '  required  ></select>
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								   <br> <br>
								   <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left" style="padding-left: 240px"> Project Start Date <span class="asterix"> * </span></label>
									<div class="col-md-6">
									
 {{ Form::text('date', '', array('id' => 'datepicker','class' => 'form-control'))}}
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <br><br>
		<div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">				  
   <button class="tablinks btn btn-primary btn-sm" >Save</button>
    <button id="gate_infor" class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'gate_info')">Next</button>
    </div>
    </div>
</form>
</div>

<div id="gate_info" class="tabcontent">
  <form name="project_info">
 	<div class="form-group  " id="gate">
									
								  </div>
								
								  <br><br>
		

  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">				  
   <button class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'project_info')">Back</button>
 <button class="tablinks btn btn-primary btn-sm" >Save</button>
<button  class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'material_info')">Next</button>
    </div>
    </div>
</form>
</div>

<div id="material_info" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'gate_info')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" >Save</button>
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'dept_team')">Next</button>
</div>
<div id="dept_team" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'material_info')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" >Save</button>
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'gate_clearance')">Next</button>
</div>
<div id="gate_clearance" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
  <button class="tablinks btn btn-primary btn-sm" onclick="openCity(event, 'dept_team')">Back</button>
  <button class="tablinks btn btn-primary btn-sm" >Save</button>

</div>
			</div>
			
			
			<div style="clear:both"></div>	
				
					
				
		 
		 
	</div>
</div>		 
</div>	
</div>	

   <script type="text/javascript">
   var base_url='<?php echo Request::root(); ?>/';
	$(document).ready(function() { 
		 $("#mfg_location").jCombo("{{ URL::to('newProject/comboselect?filter=plant_code:plant_id:plant_code') }}",
		{  selected_value : '{{ $row["mfg_location"] }}' }); 
	});

$("#gate_infor").click(function(){
	
	$.ajax({
                   url:base_url+'getGate',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#gate").html(data); 
                  
                  
                    }
               
		        });
});
	</script>
	<script>
function openCity(evt, cityName) {
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

    evt.currentTarget.className += " active";
}
</script>	
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>
	</body>
	</html>	 