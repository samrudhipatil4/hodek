
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('GateMaster?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'GateMaster/save/'.SiteHelpers::encryptID($row['id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> Gate Master</legend>
									
								  <div class="form-group hidethis " style="display:none;">
									<label for="commodity Id" class=" control-label col-md-4 text-left"> Commodity Id </label>
									<div class="col-md-6">
									  {{ Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div> 					
								  <div class="form-group  " >
									<label for="Change Type Name" class=" control-label col-md-4 text-left"> Gate Description <span class="asterix"> * </span></label>
									<div class="col-md-6">
									  {{ Form::text('Gate_Description', $row['Gate_Description'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }} 
									 </div> 
									 <div class="col-md-2">
									 	
									 </div>
								  </div>
								  <div class="form-group  " >
							<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix">  </span></label>
							<div class="col-md-6" id="inline_content">

								<label class='radio radio-inline'>
									<input type='radio'  id="active" name='Is_Active' value ='0' checked required @if($row['Is_Active'] == '0') checked="checked" @endif > Inactive </label>
								<label class='radio radio-inline'>
									<input type='radio' id="active" name='Is_Active' value ='1'  required @if($row['Is_Active'] == '1') checked="checked" @endif > Active </label>
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
					<button type="button" onclick="location.href='{{ URL::to('GateMaster?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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