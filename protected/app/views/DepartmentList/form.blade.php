
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('DepartmentList?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'DepartmentList/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend></legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Change Stage Id" class=" control-label col-md-4 text-left"> Change Stage Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								   <div class="form-group  " >
									<label for="plant" class=" control-label col-md-4 text-left"> Plant Code <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='plantCode' rows='5' id='plantCode' code='{$plant_id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								  
								  <div class="form-group  " >
									<label for="stakeholder" class=" control-label col-md-4 text-left"> StakeHolder <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='stakeholder' rows='5' id='stakeholder' code='{$id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  	<div class="form-group  " >
									<label for="change_stage" class=" control-label col-md-4 text-left"> Change Stage <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='change_stage' rows='5' id='change_stage' code='{$id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="department" class=" control-label col-md-4 text-left"> Department <span class="asterix"> * </span></label>
									<div class="col-md-6">



								<select name='department[]' rows='5' multiple id='department'
										required  >


								</select>


							</div>
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  	<div class="form-group">

							<label for="ipt" class=" control-label col-md-4 text-left" > </label>
							<div class="col-md-8">
								Please Press CTRL key for multiple User Role selection.
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
					<button type="button" onclick="location.href='{{ URL::to('DepartmentList?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
   var base_url='<?php echo Request::root(); ?>/';
   window.onload=fetch_group();
	$(document).ready(function() { 
		
		$("#plantCode").jCombo("{{ URL::to('DepartmentList/comboselect?filter=plant_code:plant_id:plant_code') }}",
		{  selected_value : '{{ $row["plantCode"] }}' });
		 
		 

		 $("#stakeholder").jCombo("{{ URL::to('DepartmentList/comboselect?filter=tb_stakeholder:id:name') }}",
		{  selected_value : '{{ $row["stakeholder"] }}' });

		$("#change_stage").jCombo("{{ URL::to('DepartmentList/comboselect?filter=tb_change_stage:change_stage_id:stage_name') }}",
		{  selected_value : '{{ $row["change_stage"] }}' });
		
		  
	});

	function fetch_group()
	{  <?php
		if(isset($row['id']) && !empty($row['id'])){//echo"aasdhello";exit;

			$id=$row['department'];



		}else{

			$id='s';

		}
?>
		$.ajax({
		type:"get",
		cache:false,
		//data: { dep_id: value },
		url:base_url+'DepartmentList/get_department/<?=$id;?>',

		success:function(response){

			$('#department').html(response);
		}
	});


	}
	</script>	