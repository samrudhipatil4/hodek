<div class="row  ">
        <nav style="margin-bottom: 0;" role="navigation" class="navbar navbar-static-top gray-bg">
        <div class="navbar-header">
            <a href="javascript:void(0)" class="navbar-minimalize minimalize-btn btn btn-primary "><i class="fa fa-bars"></i> </a>
            
        </div>

            <ul class="nav navbar-top-links navbar-right">
            <li>

            </li>
		@if(CNF_MULTILANG ==1)
		<li  class="user dropdown"><a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-flag"></i><i class="caret"></i></a>
			 <ul class="dropdown-menu dropdown-menu-right icons-right">
				@foreach(SiteHelpers::langOption() as $lang)
					<li><a href="{{ URL::to('home/lang/'.$lang['folder'])}}"><i class="icon-flag"></i> {{  $lang['name'] }}</a></li>
				@endforeach	
			</ul>
		</li>	
		@endif
		@if(!Auth::check())  
			<li><a href="{{ URL::to('user/login')}}"><i class="icon-arrow-right12"></i> {{ Lang::get('core.signin'); }}</a></li>   
		@else
		@if(Session::get('gid') ==1)
		<li class="user dropdown"><a class="dropdown-toggle" href="javascript:void(0)"  data-toggle="dropdown"><i class="fa fa-desktop"></i> <span>{{ Lang::get('core.m_controlpanel'); }}</span><i class="caret"></i></a>
		  <ul class="dropdown-menu dropdown-menu-right icons-right">
		  
					<li><a href="{{ URL::to('users')}}"><i class="fa fa-user"></i> {{ Lang::get('core.m_users'); }} </a></li>
					
		  </ul>
		</li>
		@endif	
		<li class="user dropdown"><a class="dropdown-toggle" href="javascript:void(0)"  data-toggle="dropdown"><i class="fa fa-user"></i> <span>{{ Lang::get('core.m_myaccount'); }}</span><i class="caret"></i></a>
		   <ul class="dropdown-menu dropdown-menu-right icons-right">
		  <?php $phase=Session::get('phase');if($phase== 'APQP'){?>?>
		  	<li><a href="{{ URL::to('apqp_dashboard')}}" target="_blank"><i class="fa  fa-laptop"></i>{{ Lang::get('core.m_dashboard'); }}</a></li>
		  <?php }else{ ?>
		  	<li><a href="{{ URL::to('dashboard')}}" target="_blank"><i class="fa  fa-laptop"></i>{{ Lang::get('core.m_dashboard'); }}</a></li>
			<?php } ?>
			<li><a href="{{ URL::to('user/profile')}}"><i class="fa fa-user"></i> {{ Lang::get('core.m_profile'); }}</a></li>
			<li><a href="{{ URL::to('user/logout')}}"><i class="fa fa-sign-out"></i> {{ Lang::get('core.m_logout'); }}</a></li>
		  </ul>
		</li>			
		
	@endif 				
				
            </ul>

        </nav>
        </div>
        <div style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; opacity: 0.3; z-index: 99999; display:none" id="fade"></div>