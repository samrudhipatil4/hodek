
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('HoldProject?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'ProjectRevisionDate/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}

<div class="col-md-12">
						<fieldset><legend>Project Revision</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="commodity Id" class=" control-label col-md-4 text-left"> Commodity Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 

									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								   <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Project Number <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='old_project_id' rows='5' id='project_no' code='{$id}' 
							class='select2 '  required onchange="getPhase()" ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Phase <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='phase' rows='5' id='phase' onchange="getActivity()" code='{$id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Activity <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='activity' rows='5' id='activity' code='{$id}' 
							class='select2 '  required  onchange="getOldDate()"></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								 		<div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Activity Old Start Date<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('activity_start_date', $row['activity_start_date'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'start_date','data-parsley'=>'second' ,'onkeydown'=>"return false;",'autocomplete'=>"off" )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Activity Old End Date<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('activity_end_date', $row['activity_end_date'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'end_date','data-parsley'=>'second','onkeydown'=>"return false;",'autocomplete'=>"off"  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Activity New Start Date<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('activity_new_start_date', $row['activity_new_start_date'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'new_start_date','data-parsley'=>'second' ,'onkeydown'=>"return false;" ,'onchange'=>"calNewEndDate()" ,'autocomplete'=>"off")) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Activity New End Date<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('activity_new_end_date', $row['activity_new_end_date'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'new_end_date','data-parsley'=>'second' ,'autocomplete'=>"off" )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
									 </div>
									 <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Remark<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('remark', $row['remark'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true','id'=>'remark','data-parsley'=>'second'  )) }} 
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
					<button type="button" onclick="location.href='{{ URL::to('HoldProject?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
    var base_url='<?php echo Request::root(); ?>/';
    $(function() {
	$( "#new_start_date").datepicker({format: 'dd/mm/yyyy'
		
	});
});

	$(document).ready(function() { 
	
		$.ajax({
                   url:base_url+'getRevisionPrj',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#fade").hide();
                    		$("#project_no").html(data);
                    	}
               
		        });
  
	});
		  
	function calNewEndDate() {
		var start_date=$("#new_start_date").val();
		var new_start = start_date.split("/");
		var sdate = new_start[1]+'/'+new_start[0]+'/'+new_start[2];
		var activity=$("#activity").val();
		if(activity == "" || activity ==null){
			alert("please select activity");
		}
		$.ajax({
			url:base_url+'calNewEndDate',
			type:'POST',
			data:{start_date:sdate,activity:activity},
			success:function(data){
				var end_date = data.split("/");
				var edate = end_date[1]+'/'+end_date[0]+'/'+end_date[2];
				$("#new_end_date").val(edate);
			}

		});
	}
	function getPhase(){
		var pid=$("#project_no").val();
			var phase=$("#phase").val();
			var activity=$("#activity").val();
			if( activity != null &&  phase != null && pid != ""){
				getOldDate();
			}	
			$.ajax({
				url:base_url+'checkRevision',
				type :'POST',
				data:{pid:pid},
				success:function(data){
					$("#lblrevision").text(data);
				}
			})
		if(phase == null){
			$.ajax({
				url:base_url+'getPhase',
				type :'POST',
				data:{pid:pid},
				success:function(data){
					$("#phase").html(data);
				}
			})
			
		}
		}

		function getActivity(){
			var pid=$("#project_no").val();
			var phase=$("#phase").val();
			var activity=$("#activity").val();
			if(activity != "")
			{
				$('#activity').select2('val','');
				$("#end_date").val('');
				$("#start_date").val('');
				//$("#activity").html('');
			}

			$.ajax({
				url:base_url+'getRevisionActivity',
				type:'POST',
				data:{pid:pid,phase:phase},
				success:function(data){
					$("#activity").html(data);
				}

			});
		}
		function getOldDate(){
			var pid=$("#project_no").val();
			var phase=$("#phase").val();
			var activity=$("#activity").val();
			var start_date=$("#new_start_date").val();
			if(activity != "" && start_date != ""){
				calNewEndDate();
			}

			$.ajax({
				url:base_url+'getOldDate',
				type:'POST',
				data:{pid:pid,phase:phase,activity:activity},
				success:function(data){
					var start_date = data[0]['activity_start_date'].split("-");
					var sdate = start_date[2]+'/'+start_date[1]+'/'+start_date[0];
					var end_date = data[0]['activity_end_date'].split("-");
					var edate = end_date[2]+'/'+end_date[1]+'/'+end_date[0];
					$("#start_date").val(sdate);
					$("#end_date").val(edate);
				}

			})
		}
	</script>		
	