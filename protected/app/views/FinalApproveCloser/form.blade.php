
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('FinalApproveCloser?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'FinalApproveCloser/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend></legend>
									
								  <div class="form-group " style="display:none;">
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
									  <select name='plant_code' rows='5' id='plant_code' code='{$plant_code}' 
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
									class='select2 ' onchange="getchangetype()"  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  	</div>
								     <div class="form-group" id='changetypediv' style="display:none;">
									<label for="change_type" class=" control-label col-md-4 text-left"> Change Type <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='change_type' rows='5' id='change_type' code='{$change_type_id}' 
									  class='select2'></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group" id='userdiv'>
									<label for="stakeholder" class=" control-label col-md-4 text-left"> User Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									<select name='member' rows='5' id='member'
									class='select2'>
									<option value="">--Please Select--</option>
									<?php foreach ($member as $row1) { ?>
									<option value="<?php echo $row1['id'];?>" <?php if($row['member']== $row1['id']){ echo "selected='selected'";}?>><?php echo $row1['name'];?></option>
									<?php } ?>
									</select> 
									</div> 
									<div class="col-md-2">
									</div>
								  </div>
								  	<div class="form-group" id='multiuserdiv' style="display:none;">
									<label for="department" class=" control-label col-md-4 text-left"> User Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									<select name='membermultiple[]' rows='5' multiple id='membermultiple'
										>
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
					<button type="submit" name="submit" class="btn btn-primary btn-sm" onclick="getchangetypesub(event)" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('FinalApproveCloser?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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
		
	$("#plant_code").jCombo("{{ URL::to('FinalApproveCloser/comboselect?filter=plant_code:plant_id:plant_code') }}",
		{  selected_value : '{{ $row["plant_code"] }}' });

		 $("#stakeholder").jCombo("{{ URL::to('FinalApproveCloser/comboselect?filter=tb_stakeholder:id:name') }}",
		{  selected_value : '{{ $row["stakeholder"] }}' });

		$("#change_stage").jCombo("{{ URL::to('FinalApproveCloser/comboselect?filter=tb_change_stage:change_stage_id:stage_name') }}",
		{  selected_value : '{{ $row["change_stage"] }}' });

		$("#change_type").jCombo("{{ URL::to('FinalApproveCloser/comboselect?filter=tbl_change_type:change_type_id:change_type_name') }}",
		{  selected_value : '{{ $row["change_type"] }}' });
		
		  
	});

	function fetch_group()
	{  <?php
		if(isset($row['id']) && !empty($row['id'])){//echo"aasdhello";exit;
			if(!empty($row['membermultiple'])){
			$id=$row['membermultiple'];
		   }else{
		   	$id='s';
		   }
		}else{

			$id='s';

		}
		?>

		$.ajax({
		type:"get",
		cache:false,
		//data: { dep_id: value },
		url:base_url+'get_SteeringComm/<?=$id;?>',

		success:function(response){

			$('#membermultiple').html(response);
		}
	});


	}

	function getchangetype(){
		var c_stage=$('#change_stage').val();
		// alert($('#change_stage').val());
		if(c_stage==1){
			$('#changetypediv').css('display','block');
			$('#multiuserdiv').css('display','block');
			$('#userdiv').css('display','none');
			$('#change_type').attr('required','');
		}else{
			$('#changetypediv').css('display','none');
			$('#multiuserdiv').css('display','none');
			$('#userdiv').css('display','block');
			$('#change_type').removeattr('required');
		}
	}

	function getchangetypesub(e){
		var c_stage=$('#change_stage').val();
		// alert($('#membermultiple').val());
		if(c_stage==1){
			// alert('hiee');
			if($('#change_type').val()==''){
				alert('select change type.');
				e.preventDefault();
			}
			if($('#membermultiple').val()==null){
				alert('select user');
				e.preventDefault();
			}
		}else if(c_stage==2){
			if($('#member').val()==''){
				alert('select user');
				e.preventDefault();
			}
		}
	}
	</script>	