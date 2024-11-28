</!DOCTYPE html>
<html>
<head>

 
<style type="text/css">
	
table, th, td {
    
     padding: 5px 3px 5px 8px;
     font-size: 15px;
    
}
</style>
</head>
<body>
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('changestage?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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
 
		 {{ Form::open(array('url'=>'draftProjectPlan/saveact/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri,'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> Commodity Master</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="commodity Id" class=" control-label col-md-4 text-left"> Commodity Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									  
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 

								  <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Gate<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='gate_id' id="gate_id" rows='5'   
							class='select2 '  required ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									  <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Activity Type<span class="asterix"> * </span></label>
									<div class="col-md-6" >
									<input type="hidden" id="project_id" name="project_id" value="<?php echo $project_id;?>">
									<input type="hidden" name="proj_name1" id="proj_name1" value="<?php echo $proj_name;?>">
									
									  <select name='activity_type' id="activity_type" rows='5'   
										class='select2 '  required  >
										<option value="">--Select activity type--</option>
										<option value="C">Commom</option>
										<option value="M">Commodity</option>>
										</select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									 <div class="form-group  " id="comm" style="display: none">
									<label for="change_type" class=" control-label col-md-4 text-left">Material<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='commodity' id="commodity" rows='5'  code='{$id}' 
							class='select2 '    ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
				
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Activity <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('activity', $row['activity'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Lead Time <span class="asterix"> * </span></label>
									<div class="col-md-6">
									<input type="text" name="lead_time" id="lead_time" class='form-control' required="true">
									  
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Previous Reference Activity<span class="asterix"> * </span></label>
									<div class="col-md-4" style="width: 18%;">
									<label > Gate/Phase<span >  </span></label>
									  <select name='gate_id1' id="gate_id1" rows='5'  code='{$id}' 
							class='select2 '    ></select> 
									 </div> 
									 <div class="col-md-4" style="width: 15%;">
									 <label > Activity Type<span >  </span></label>
									 	 <select name='type_activity' id="type_activity" rows='5'   
							class='select2 '    ></select> 
									 </div>
									  <div class="col-md-4" style="width: 17%;">
									 <label >Material<span >  </span></label>
									 	 <select name='commodity_name' id="commodity_name" rows='5'  code='{$id}' 
							class='select2 '    ></select> 
									 </div>
									
									 </div>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left"><span >  </span></label>
									
									
									  <div class="col-md-6" >
									  <label >Activity<span >  </span></label>
									 	 <select name='previous_reference_activity' id="previous_reference_activity" rows='5'  
							class='select2 '    ></select> 
									 </div>
									 </div>

								  <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Responsible Department<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='responsible_department' id="responsible_department" rows='5'   
							class='select2 '  required></select> 
									 </div> 
									 <div class="col-md-4">
									 	
									 </div>
									 </div>
									 
									<div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">User<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='user' id="user" rows='5'   
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-4">
									 	
									 </div>
									 </div>
									 <div class="form-group  " id="startCal" >
									<label for="change_type" class=" control-label col-md-4 text-left">Activity Start Date<span class="asterix"> * </span></label>
									 <div class="col-md-6" >
									
									 	{{ Form::text('date', $proj_start_date, array('id' => 'datepicker','class' => 'form-control','required'=>'true','onkeydown'=>"return false;",'data-parsley-group'=>'first'))}}
									 </div>
									 <div class="col-md-4">
									 	
									 </div>
									 </div>
									 <div class="form-group  " id="startCal1" style="display: none">
									<label for="change_type" class=" control-label col-md-4 text-left">Activity Start Date<span class="asterix"> * </span></label>
									 <div class="col-md-6" >
									
									 	<input type="text" id="startDate" disabled="true" class = 'form-control'>
									 </div>
									 <div class="col-md-4">
									 	
									 </div>
									 </div>
									 
									 <div class="form-group  " id="endcal1" style="display: block">
									<label for="change_type" class=" control-label col-md-4 text-left">Activity End Date<span class="asterix"> * </span></label>
									 <div class="col-md-6" >
									{{ Form::text('date1', $proj_start_date, array('id' => 'endDate','class' => 'form-control','required'=>'true','onkeydown'=>"return false;",'data-parsley-group'=>'first'))}}
									 	
									 </div>
									 <div class="col-md-4">
									 	
									 </div>
									 </div>

						</fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
					
				  
				  <div class="form-group  " id="allActivity">
				  </div>
				  <div style="clear:both"><br></div>	
				    <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<!-- <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button> -->
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('draftProjectPlan?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
 var base_url='<?php echo Request::root(); ?>/';
var proj_id = $("#proj_name1").val();
var proj_id1 = $("#project_id").val();

	$(document).ready(function() { 

		$.ajax({
                   url:base_url+'get_dropdown',
                    type: 'POST',
                    data:{dept:'tb_departments'},
                    
                    success: function (data) {
                    	$('#responsible_department').html(data);
                  	
                  
                    }
               
		        });
		$.ajax({
                   url:base_url+'get_dropdown',
                    type: 'POST',
                    data:{dept:'tb_departments'},
                    
                    success: function (data) {
                    	$('#responsible_department').html(data);
                  	
                  
                    }
               
		        });
		$.ajax({
                   url:base_url+'get_dropdown1',
                    type: 'POST',
                    data:{dept:'apqp_gate_management_master',field1:'id',field2:'Gate_Description'},
                    
                    success: function (data) {
                    	$('#gate_id1').html(data);
                  	
                  
                    }
               
		        });
		$.ajax({
                   url:base_url+'get_dropdown1',
                    type: 'POST',
                    data:{dept:'apqp_gate_management_master',field1:'id',field2:'Gate_Description'},
                    
                    success: function (data) {
                    	$('#gate_id').html(data);
                  	
                  
                    }
               
		        });
		$.ajax({
                   url:base_url+'get_commodity',
                    type: 'POST',
                    data:{id:proj_id},
                    
                    success: function (data) {
                    	$('#commodity').html(data);
                   }
               
		        });
		$("#lead_time").keyup(function(){
			var id = $("#previous_reference_activity").val();
			var date = $("#datepicker").val();
			var time =$("#lead_time").val();
		if(date != ""){
			$.ajax({
		                   url:base_url+'calDate',
		                    type: 'POST',
		                    data:{date:date,lead_time:time},
		                    
		                    success: function (data) {
		                    	 var res = data.split("@");
		                    	
		                    	$("#endDate").val(data);
		                 
		                   }
		               
				        });
		}
				
			if(id != null){
				if(time == ''){
					alert('Please select lead time')
				}else{
					$.ajax({
		                   url:base_url+'calEndDate1',
		                    type: 'POST',
		                    data:{a_id:id,lead_time:time},
		                    
		                    success: function (data) {
		                    	 var res = data.split("@");
		                    	$("#startDate").val(res[0]);
		                    	$("#endDate").val(res[1]);
		                    $("#startCal").hide();
							$("#startCal1").show();
							 $("#endcal").hide();
							$("#endcal1").show();
		                   }
		               
				        });
				}
		}
			
		});
		$("#previous_reference_activity").change(function(){
				var id = $("#previous_reference_activity").val();
				var time =$("#lead_time").val();
			if(id != null){
				if(time == ''){
					alert('Please select lead time')
				}else{
					$.ajax({
		                   url:base_url+'calEndDate1',
		                    type: 'POST',
		                    data:{a_id:id,lead_time:time},
		                    
		                    success: function (data) {
		                    	 var res = data.split("@");
		                    	$("#startDate").val(res[0]);
		                    	$("#endDate").val(res[1]);
		                    $("#startCal").hide();
							$("#startCal1").show();
							 $("#endcal").hide();
							$("#endcal1").show();
		                   }
		               
				        });
				}
		}
			
		});

		$("#responsible_department").change(function(){
			var dept = $("#responsible_department").val();
		$.ajax({
                   url:base_url+'get_user',
                    type: 'POST',
                    data:{dept:dept},
                    
                    success: function (data) {
                    	$('#user').html(data);
                  	
                  
                    }
               
		        });
		});

		
		
		

		  $("#lead_time").keydown(function (e) {

        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

});
	$("#activity_type").change(function(){
		   var type=$("#activity_type").val(); 
		   if(type == 'M'){
			$("#comm").show();
			}
		});
	 
	$("#type_activity").change(function(){
    var gate=$("#gate_id1").val();
    var type=$("#type_activity").val();
  
      if(type == 'C'){
      	$('#commodity_name').html("");
	    if(gate=='' || gate==null){
	    	alert('Please select gate');
	    }else{
	    $.ajax({
                   url:base_url+'getActivity1',
                    type: 'POST',
                    data:{gate:gate,activity_type:type,proj_id:proj_id1},
                    
                    success: function (data) {
                    	$('#previous_reference_activity').html(data);
                  	
                  
                    }
               
		        });
	    }
	}else{
		 if(gate=='' || gate==null){
	    	alert('Please select gate');
	    }else{
	    	$.ajax({
	                   url:base_url+'get_commodity',
	                    type: 'POST',
	                    data:{id:proj_id},
	                    
	                    success: function (data) {
	                    	$('#commodity_name').html(data);
	                  
	                  
	                    }
	               
			        });
	    }
	}
});

	$("#gate_id1").change(function(){
		var gate=$("#gate_id1").val();
    var type=$("#type_activity").val();
     var comm=$("#commodity_name").val();
   				if(gate != '' ){
    				$.ajax({
	                   url:base_url+'getUserDefinedActivity',
	                    type: 'POST',
	                    data:{gate:gate},
	                    
	                    success: function (data) {
	                    $('#type_activity').html(data);	
	                  
	                  
	                    }
               
		        });
	    	}else{
	    		 $('#type_activity').html("");	
	    	}
	    	if(gate != "" && type != '' && comm == ''){
	    		$.ajax({
                   url:base_url+'getActivity',
                    type: 'POST',
                    data:{gate:gate,activity_type:type},
                    
                    success: function (data) {
                    	$('#previous_reference_activity').html(data);
                  
                  
                    }
               
		        });
	    	}
	    	if(gate != "" && type != '' && comm != ''){
	    		$.ajax({
                   url:base_url+'getActivity1',
                    type: 'POST',
                    data:{gate:gate,activity_type:type,commodity:comm,proj_id:proj_id1},
                    
                    success: function (data) {
                    	$('#previous_reference_activity').html(data);
                  
                  
                    }
               
		        });
	    	}


    	});

	$("#commodity_name").change(function(){
		var gate=$("#gate_id1").val();
    var type=$("#type_activity").val();
     var comm=$("#commodity_name").val();
    if(gate == '' || type==null){
    	alert('Please select gate');
    }
     if(type == ''){
    	alert('Please select activity type');
    }
    if(type == ''){
    	alert('Please select commodity');
    }
    if(type != '' && gate != '' && comm != ''){
    		$.ajax({
                   url:base_url+'getActivity1',
                    type: 'POST',
                    data:{gate:gate,activity_type:type,commodity:comm,proj_id:proj_id1},
                    
                    success: function (data) {
                    	$('#previous_reference_activity').html(data);
                  
                  
                    }
               
		        });
    	}
    	});

	</script>	
	<script>

$(function() {
$( "#datepicker1" ).datepicker();

});
$("#datepicker").datepicker({
dateFormat: 'dd/mm/yyyy'}).on("changeDate", function (e) {
	var date = $("#datepicker").val();
	var time =$("#lead_time").val();
			$.ajax({
		                   url:base_url+'checkHoliday',
		                    type: 'POST',
		                    data:{date:date},
		                    
		                    success: function (data) {
		                    	if(data.trim()== 'same'){
		                    		alert('change date');
		                    	}else{

		                    	
				if(time == ''){
					alert('Please select lead time')
				}else{
					$.ajax({
		                   url:base_url+'calDate',
		                    type: 'POST',
		                    data:{date:date,lead_time:time},
		                    
		                    success: function (data) {
		                    	 var res = data.split("@");
		                    	
		                    	$("#endDate").val(data);
		                 
		                   }
		               
				        });
				}
				}
		        }
		       });
		
});


</script>
</body>

</html>