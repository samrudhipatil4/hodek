
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

		 {{ Form::open(array('url'=>'HoldProject/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}

<div class="col-md-12">
						<fieldset><legend> Hold Project</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="commodity Id" class=" control-label col-md-4 text-left"> Commodity Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 

									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								 				
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Project Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									   <select name='project_id' rows='5' id='project_id' code='{$id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								   <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left">Hold Project<span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name="hold_project" id="hold_project" rows='5' class='select2 '  required>
									  	<option value="1"  <?php if($row['hold_project']=="1"){ echo "selected='selected'";}?>>Hold Project</option>
									  	<option value="0" <?php if($row['hold_project']=="0"){ echo "selected='selected'";}?>>Release Project</option>
									  </select>
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
	$(document).ready(function() { 

		$.ajax({
                   url:base_url+'getReleasedPrj',
                    type: 'POST',
                    data:{},
                    
                    success: function (data) {
                    	$("#fade").hide();
                    		$("#project_id").html(data);
                    	}
               
		        });
		  
	});
	</script>	
	<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script> 