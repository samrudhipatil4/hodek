
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('changetype?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'changetype/save/'.SiteHelpers::encryptID($row['change_type_id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> changetype</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="Change Type Id" class=" control-label col-md-4 text-left"> Change Type Id </label>
									<div class="col-md-6">
									  {{ Form::text('change_type_id', $row['change_type_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Change Type Name <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('change_type_name', $row['change_type_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>







							<div class="form-group  " >
								<label for="change_type_cust_mapping" class=" control-label col-md-4 text-left"> Customer Mapping <span class="asterix"> * </span></label>
								<div class="col-md-6">
									<select name='change_type_cust_mapping'  id='change_type_cust_mapping'
											class='select2 ' row='5' required >
										<option value="">--Please Select--</option>
										<option value="Single" <?php if($row['change_type_cust_mapping']=="Single"){ echo "selected='selected'";}?> selected>Single</option>
										<option value="Multiple" <?php if($row['change_type_cust_mapping']=="Multiple"){ echo "selected='selected'";}?>>Multiple</option>
									</select>
								</div>
								<div class="col-md-2">

								</div>
							</div>

							<div class="form-group  " >
								<label for="change_type_cust_mapping" class=" control-label col-md-4 text-left"> Part Mapping <span class="asterix"> * </span></label>
								<div class="col-md-6">
									<select name="change_type_part_mapping"  id='change_type_part_mapping'
											class='select2 ' row='5' required >
										<option value="">--Please Select--</option>
										<option value="Single" <?php if($row['change_type_part_mapping']=="Single"){ echo "selected='selected'";}?> selected>Single</option>
										<option value="Multiple" <?php if($row['change_type_part_mapping']=="Multiple"){ echo "selected='selected'";}?>>Multiple</option>
									</select>
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
					<button type="button" onclick="location.href='{{ URL::to('changetype?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
					</div>	  
			
				  </div> 
		 
		 {{ Form::close() }}
	</div>
</div>		 
</div>	
</div>			 
   <script type="text/javascript">
	$(document).ready(function() { 
		 
	});
	</script>		 