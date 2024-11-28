
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('ChangeSubtype?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'ChangeSubtype/save/'.SiteHelpers::encryptID($row['sub_type_id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> changesubtype</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Change Type Id" class=" control-label col-md-4 text-left"> Change Type Id </label>
									<div class="col-md-6">
									  {{ Form::text('sub_type_id', $row['sub_type_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 
								   <div class="form-group  " >
									<label for="change_type" class=" control-label col-md-4 text-left"> Change Type <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  <select name='change_type' id="change_type" rows='5'  code='{$change_type_id}' 
							class='select2 '  required  ></select> 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Change Sub Type Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('sub_type_name', $row['sub_type_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>

								  	<div class="form-group  " >
								<label for="Function" class=" control-label col-md-4 text-left"> Status </label>
								<div class="col-md-6">
									<select name='status' rows='5' id='status'
											class='select2 '    >
										<option value="active" <?php if($row['status']=="active"){ echo "selected='selected'";}?> >Active</option>
										<option value="inactive" <?php if($row['status']=="inactive"){ echo "selected='selected'";}?>>Inactive</option>
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
					<button type="button" onclick="location.href='{{ URL::to('ChangeSubtype?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		 $("#change_type").jCombo("{{ URL::to('ChangeSubtype/comboselect?filter=tbl_change_type:change_type_id:change_type_name') }}",
		{  selected_value : '{{ $row["change_type"] }}' });

	});
	</script>		 