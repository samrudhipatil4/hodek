<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> {{ isset($page['pageTitle']) ? $page['pageTitle'].' | '.CNF_APPNAME : CNF_APPNAME }} </title>
<meta name="keywords" content="{{ CNF_METAKEY }}">
<meta name="description" content="{{ CNF_METADESC }}"/>
<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">	
		{{ HTML::style('sximo/themes/sximone/css/bootstrap.min.css')}}
		
		{{ HTML::style('sximo/themes/sximone/font-awesome/css/font-awesome.min.css')}}
		{{ HTML::style('sximo/css/icons.min.css')}}
		{{ HTML::style('sximo/themes/sximone/js/fancybox/source/jquery.fancybox.css') }}		
		{{ HTML::style('sximo/themes/sximone/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7') }}	
		{{ HTML::style('sximo/js/plugins/select2/select2.css')}}		
		{{ HTML::style('sximo/themes/sximone/css/sximone.css')}}	
		{{ HTML::style('sximo/themes/sximone/css/animate.css')}}	

		
		{{ HTML::script('sximo/themes/sximone/js/jquery.min.js') }}		
		{{ HTML::script('sximo/themes/sximone/js/bootstrap.min.js') }}	
		{{ HTML::script('sximo/themes/sximone/js/fancybox/source/jquery.fancybox.js') }}	
		{{ HTML::script('sximo/themes/sximone/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7s') }}	
		{{ HTML::script('sximo/themes/sximone/js/fancybox/source/jquery.fancybox.js') }}	
		{{ HTML::script('sximo/js/plugins/prettify.js') }}	
		{{ HTML::script('sximo/js/plugins/parsley.js') }}
		{{ HTML::script('sximo/themes/sximone/js/jquery.mixitup.min.js') }}			
		
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->		


	
  	</head>

<body >

<div class="sbox ">
	<div class="sbox-title">
			
				<h3 >{{ CNF_APPNAME }} <small> {{ CNF_APPDESC }} </small></h3>
				
	</div>
	<div class="sbox-content">
	<div class="text-center  animated fadeInDown delayp1">
		<img src="{{ asset('sximo/images/logo-sximo.png')}}" width="70" height="70" />
	</div>	
 
	    	@if(Session::has('message'))
				{{ Session::get('message') }}
			@endif
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>		
		
	<ul class="nav nav-tabs" >
	  <li class="active"><a href="#tab-sign-in" data-toggle="tab">  {{ Lang::get('core.signin'); }} </a></li>
	   <li ><a href="#tab-forgot" data-toggle="tab"> {{ Lang::get('core.forgotpassword'); }} </a></li>
	  
	 
	</ul>	
	<div class="tab-content" >
	<div class="tab-pane active m-t" id="tab-sign-in">
	{{ Form::open(array('url'=>'user/signin', 'class'=>'form-vertical')) }}

	<div class="form-group has-feedback animated fadeInLeft delayp1">
		<label>{{ Lang::get('core.email'); }}	</label>
		{{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address' ,'required'=>'email')) }}
		<i class="icon-users form-control-feedback"></i>
	</div>
	
	<div class="form-group has-feedback  animated fadeInRight delayp1">
		<label>{{ Lang::get('core.password'); }}	</label>
		{{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password' ,'required'=>'')) }}
		<i class="icon-lock form-control-feedback"></i>
	</div>
	@if(CNF_MULTILANG =='1') 
	<div class="form-group has-feedback  animated fadeInLeft delayp1">
		<label class="text-left"> {{ Lang::get('core.language'); }} </label>	
		<select class="form-control" name="language">
			@foreach(SiteHelpers::langOption() as $lang)
			<option value="{{ $lang['folder'] }}" @if(Session::get('lang') ==$lang['folder']) selected @endif>  {{  $lang['name'] }}</option>
			@endforeach

		</select>	
		
		<div class="clr"></div>
	</div>	
 	@endif	


	@if(CNF_RECAPTCHA =='true') 
	<div class="form-group has-feedback  animated fadeInLeft delayp1">
		<label class="text-left"> Are u human ? </label>		
		{{ Form::captcha(array('theme' => 'white')); }}
		<div class="clr"></div>
	</div>	
 	@endif	
	<div class="form-group  has-feedback text-center  animated fadeInLeft delayp1" style=" margin-bottom:20px;" >
		 	 
			<button type="submit" class="btn btn-info btn-sm btn-block" ><i class="fa fa-sign-in"></i> {{ Lang::get('core.signin'); }}</button>
		       

		
	 	<div class="clr"></div>
		
	</div>	
	<div class="animated fadeInUp delayp1">
	
   	{{ Form::close() }}				
	</div>
	</div>
	

	<div class="tab-pane  m-t" id="tab-forgot">	

		{{ Form::open(array('url' => 'user/request', 'class'=>'form-vertical box ','id'=>'fr' )) }}

			
		   <div class="form-group has-feedback">
		   <div class="">
				<label>{{ Lang::get('core.enteremailforgot') }}</label>
			   {{ Form::text('credit_email', null, array('class'=>'form-control', 'placeholder'=> Lang::get('core.email'))) }}
				<i class="icon-envelope form-control-feedback"></i>
			</div> 	
			</div>
			<div class="form-group has-feedback">        
		      <button type="submit" class="btn btn-default pull-right"> {{ Lang::get('core.sb_submit') }} </button>        
		  </div>
		  
		  <div class="clr"></div>

		  
		{{ Form::close() }}	

	
	</div>


	</div>  
	  
	
   
 
	 


  <div class="clr"></div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
$('#or').click(function(){
$('#fr').toggle();
});
});
</script>
<div class="clr"></div>
	




<div id="footer">
	<div class=" container">
		<div class="text-center"> Copyright 2014 {{ CNF_APPNAME }} . ALL Rights Reserved. </div>
		
	</div>	
</div>

<div class="modal fade" id="sximo-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-default">
		
			<button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title">Modal title</h4>
		</div>
		<div class="modal-body" id="sximo-modal-content">
	
		</div>
	</div>
</div>
</div>

	
<script>
	jQuery(document).ready(function() {

		window.prettyPrint && prettyPrint();
	});
</script>	
</body> 
</html>