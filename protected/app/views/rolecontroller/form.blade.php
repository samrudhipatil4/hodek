
  <div class="page-content row">
    <!-- Page header -->
    <div class="page-header">
      <div class="page-title">
        <h3> {{ $pageTitle }} <small>{{ $pageNote }}</small></h3>
      </div>
      <ul class="breadcrumb">
        <li><a href="{{ URL::to('dashboard_admin') }}">{{ Lang::get('core.home') }}</a></li>
		<li><a href="{{ URL::to('rolecontroller?md='.$filtermd) }}">{{ $pageTitle }}</a></li>
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

		 {{ Form::open(array('url'=>'rolecontroller/save/'.SiteHelpers::encryptID($row['role_id']).'?md='.$filtermd.$trackUri, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) }}
<div class="col-md-12">
						<fieldset><legend> Role</legend>

								  <div class="form-group hidethis " style="display:none;">
									<label for="Role Id" class=" control-label col-md-4 text-left"> Role Id </label>
									<div class="col-md-6">
									  {{ Form::text('role_id', $row['role_id'],array('class'=>'form-control', 'placeholder'=>'',   )) }}
									 </div>
									 <div class="col-md-2">

									 </div>
								  </div>
								  <div class="form-group  " >
									<label for="Role Name" class=" control-label col-md-4 text-left"> Role Name <span class="asterix"> * </span></label>
									<div class="col-md-3">
									  {{ Form::text('role_name', $row['role_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) }}
									 </div>

								  </div>
							<div class="form-group  " >
								<label for="Permissions" class=" control-label col-md-4 text-left"> Permissions <span class="asterix"> * </span></label>
								<div class="col-md-6">



									<select name='permission[]' rows='9' multiple id='permission' required  >


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
					<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
					<button type="button" onclick="location.href='{{ URL::to('rolecontroller?md='.$masterdetail["filtermd"].$trackUri) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
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

  <script type="text/javascript">
  var base_url='<?php echo Request::root(); ?>/';

	  window.onload=fetch_group();
	  var base_url='<?php echo Request::root(); ?>/';

	  function fetch_group()
	  {<?php
		if(isset($row['role_id']) && !empty($row['role_id'])){

			$id=$row['role_id'];
		}else{

			$id='s';

		}
?>
		$.ajax({
		  type:"get",
		  cache:false,
		  url:base_url+'permission_ajax/<?=$id;?>',
		 // url:'http://192.168.2.99/CM/permission_ajax/<?=$id;?>',

		  success:function(response){

			  $('#permission').html(response);
		  }
	  });


	  }//end function;



  </script>