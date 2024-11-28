
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('GateCommodityActivity?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'GateCommodityActivity/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> Commodity Master</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="commodity Id" class=" control-label col-md-4 text-left"> Commodity Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'', 'id'=>'id'  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								   <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Template<span class="asterix"> * </span></label>
									<div class="col-md-6">
									 @if($row['id'] != "") 
									  <select name='template' id="template" rows='5'  code='{$id}' 
							class='select2 '  required   disabled="disabled"></select>
							{{ Form::hidden('template', $row['template'],array('class'=>'form-control', 'placeholder'=>'','id'=>'template'   )) }} 
						 @else 
								 <select name='template' id="template" rows='5'  code='{$id}' 
							class='select2 '  required ></select>
							 @endif 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div> 	
								  <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Gate<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='gate_id' id="gate_id" rows='5'  code='{$id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Commodity<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='commodity' id="commodity" rows='5'  code='{$id}' 
							class='select2 '  required  ></select> 
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
									  {{ Form::text
									  ('lead_time', $row['lead_time'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id' =>'lead_time' )) }} 
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
									 <label >Commodity<span >  </span></label>
									 	 <select name='commodity_name' id="commodity_name" rows='5'  code='{$id}' 
							class='select2 '    ></select> 
									 </div>
									
									 </div>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left"><span >  </span></label>
									
									
									  <div class="col-md-6" >
									  <label >Activity<span >  </span></label>
									 	 <select name='previous_reference_activity' id="previous_reference_activity" rows='5'  code='{$id}' 
							class='select2 '    ></select> 
									 </div>
									 </div>

								  <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Responsible Department<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='responsible_department' id="responsible_department" rows='5'  code='{$d_id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-4">
									 	
									 </div>
									 </div>
									  <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Sequence Number<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text
									  ('sequence_no', $row['sequence_no'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id' =>'sequence_no' )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									 
									 <div class="form-group  " >
									
									<div class="col-md-6">
									 {{ Form::hidden('activity_type', 'M',array('class'=>'form-control', 'placeholder'=>''  )) }}
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
							<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix">  </span></label>
							<div class="col-md-6" id="inline_content">

								<label class='radio radio-inline'>
									<input type='radio'  id="active" name='active' value ='0' checked required @if($row['active'] == '0') checked="checked" @endif > Inactive </label>
								<label class='radio radio-inline'>
									<input type='radio' id="active" name='active' value ='1'  required @if($row['active'] == '1') checked="checked" @endif > Active </label>
							</div>
							<div class="col-md-2">

							</div>
						</div>

						</fieldset>
			</div>
			
			
			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<!-- <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button> -->
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('GateCommodityActivity?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
 <script type="text/javascript">
 var base_url='<?php echo Request::root(); ?>/';

	$(document).ready(function() { 

		 $("#responsible_department").jCombo("{{ URL::to('GateCommodityActivity/comboselect?filter=tb_departments:d_id:d_name&limit=Where:tb_departments:.d_id:!=11') }}",
		{  selected_value : '{{ $row["responsible_department"] }}' });

		
		 $("#gate_id").jCombo("{{ URL::to('GateCommodityActivity/comboselect?filter=apqp_gate_management_master:id:Gate_Description&limit=Where:apqp_gate_management_master:.Is_Active:=1') }}",
		{  selected_value : '{{ $row["gate_id"] }}' });


		 $("#commodity").jCombo("{{ URL::to('GateCommodityActivity/comboselect?filter=apqp_commodity_master:id:commodity_description') }}",
		{  selected_value : '{{ $row["commodity"] }}' });

		  	 $("#template").jCombo("{{ URL::to('GateCommonActivity/comboselect?filter=apqp_templatemaster:template_id:template_desc') }}",
		{  selected_value : '{{ $row["template"] }}' });


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
		   $("#sequence_no").keydown(function (e) {

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
		   var id = $("#id").val();
		    if(id != ""){
				 $("#fade").show();
			}
		   				$.ajax({
				                   url:base_url+'getAllGate',
				                    type: 'POST',
				                    data:{},
				                    success: function (data) {
				                    	$('#gate_id1').html(data);

				  			var id = $("#id").val();
				    			if(id != ""){
				    				$("#fade").show();
				    				$.ajax({
						                   url:base_url+'getSelGate',
						                    type: 'POST',
						                    data:{id:id},
						                    success: function (data1) {
						                    	if(data1.length > 0){
						                    		$('#gate_id1').val(data1).trigger('change');
						                    		
						                    	}else{
						                    		 $("#fade").hide();
						                    	}
						                    }
						                });
				    			}
				    		}
				    		});
});
	 
	$("#type_activity").change(function(){
    var gate=$("#gate_id1").val();
    var type=$("#type_activity").val();
  var template =$("#template").val();
      if(type == 'C'){
      	$('#commodity_name').html("");
	    if(gate=='' || gate==null){
	    	alert('Please select gate');
	    }else{
	    $.ajax({
                   url:base_url+'getActivity',
                    type: 'POST',
                    data:{gate:gate,activity_type:type,template:template},
                    
                    success: function (data) {
                    	$('#previous_reference_activity').html(data);
                  	var id = $("#id").val();
		    			if(id != ""){
		    				$.ajax({
				                   url:base_url+'getSelActivity',
				                    type: 'POST',
				                    data:{id:id},
				                    success: function (data1) {
				                    	if(data1.length > 0){
				                    		

				                    		$('#previous_reference_activity').val(data1).trigger('change');
				                    		$("#fade").hide();
				                    	}
				                    	
				                    }
				                });
	                    	
	                    }
                  
                    }
               
		        });
	    }
	}else{
		 if(gate=='' || gate==null){
	    	alert('Please select gate');
	    }else{
	    	$.ajax({
	                   url:base_url+'getCommodity',
	                    type: 'POST',
	                    data:{gate:gate},
	                    
	                    success: function (data) {
	                    	$('#commodity_name').html(data);
	                  	var id = $("#id").val();
		    			if(id != ""){
	                    $.ajax({
				                   url:base_url+'getSelCommodity',
				                    type: 'POST',
				                    data:{id:id},
				                    success: function (data1) {
				                    	if(data1.length > 0){
				                    		$("#commodity_name").val(data1).trigger('change');
				                    	}
				                    	
				                    }
				                });
	                }
	                  
	                    }  
	               
			        });
	    }
	}
});

	$("#gate_id1").change(function(){
		var gate=$("#gate_id1").val();
    var type=$("#type_activity").val();
     var comm=$("#commodity_name").val();
     var template = $("#template").val();

   				if(gate != ''){
    				$.ajax({
	                   url:base_url+'getUserDefinedActivity',
	                    type: 'POST',
	                    data:{gate:gate},
	                    
	                    success: function (data) {
	                    $('#type_activity').html(data);	
	                    var id = $("#id").val();
		    			if(id != ""){
		    				 $.ajax({
				                   url:base_url+'getDropdownVal',
				                    type: 'POST',
				                    data:{id:id},
				                    success: function (data1) {
				                    	if(data1.length > 0){
				                    	$('#type_activity').val(data1).trigger('change');
				                    	}
				                    	
				                    }
				                });
	                    	
	                    }
	                  
	                    }
               
		        });
	    	}else{
	    		 $('#type_activity').html("");	
	    	}
	    	if(gate != "" && type != '' && comm == ''){
	    		$.ajax({
                   url:base_url+'getActivity',
                    type: 'POST',
                    data:{gate:gate,activity_type:type,template:template},
                    
                    success: function (data) {
                    	$('#previous_reference_activity').html(data);
                  
                  
                    }
               
		        });
	    	}
	    	if(gate != "" && type != '' && comm != ''){
	    		$.ajax({
                   url:base_url+'getActivity',
                    type: 'POST',
                    data:{gate:gate,activity_type:type,commodity:comm,template:template},
                    
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
     var template=$("#template").val();
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
                   url:base_url+'getActivity',
                    type: 'POST',
                    data:{gate:gate,activity_type:type,commodity:comm,template:template},
                    
                    success: function (data) {
                    	$('#previous_reference_activity').html(data);
                  	var id = $("#id").val();
		    			if(id != ""){
		    				$.ajax({
				                   url:base_url+'getSelActivity',
				                    type: 'POST',
				                    data:{id:id},
				                    success: function (data1) {
				                    	if(data1.length > 0){
				                    		

				                    		$('#previous_reference_activity').val(data1).trigger('change');
				                    		$("#fade").hide();
				                    	}
				                    	
				                    }
				                });
	                    	
	                    }
                  
                    }
               
		        });
    	}
    	});
	</script>	 