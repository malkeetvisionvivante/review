
<header>
    <div class="container-fluid header">
        <div class="row align-items-center py-1">
            <div class="col-md-8 col-3">
                <a href="{{ url('/admin') }}"><img src="{{ asset('images/blossom_logo_primary.svg') }}" class="img-fluid logo" alt="blossom_logo_primary"></a>
            </div>
            <div class="col-md-4 col-9 text-right">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
              <div class="media align-items-center float-right border-left pl-2">
                  <div class="media-left mr-2">
                    <a href="#" class="h6" id="navbarDropdown h6" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::guard('admin')->user()->name }} {{ Auth::guard('admin')->user()->last_name }}<i class="fas fa-angle-down ml-2"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{ url('admin/profile') }}" >
                          My Profile
                      </a>
                      <a class="dropdown-item" href="{{ url('admin/setting') }}" >
                          Settings
                      </a>
                      <a class="dropdown-item" href="{{ url('/admin/logout') }}"
                         onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                      </a>

                      <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </div>
                  </div>
                  <div class="media-left">
                     @if(Auth::guard('admin')->user()->profile) 
                     <img src="{{ asset('images/users/'.Auth::guard('admin')->user()->profile)}}" alt="Profile" style="width:40px;height:40px;" class="rounded-circle"/>  
                     @else
                      <img src="{{ asset('images/default/user.png')}}" alt="Profile" style="width:40px;height:40px;" class="rounded-circle"/>
                     @endif 
                    <span class="d-inline-block d-lg-none filter_open">
                        <div class="bar1"></div>
                        <div class="bar2"></div>
                        <div class="bar3"></div>
                    </span>
                  </div>
                  
              </div>
              </li>
                </ul> 
            </div>
        </div>
    </div>
    <div class="sidebar">
      @if(Auth::guard('admin')->user()->role == 1)  
        <ul>
            <li><a href="{{ url('admin/dashboard')}}" class="@if(isset($sidebar)) @if($sidebar == 'dashboard') active @endif  @endif"><span class="material-icons">bar_chart</span> Dashboard</a></li>
            <li><a href="{{ url('admin/company/list')}}" class="@if(isset($sidebar)) @if($sidebar == 'company_list') active @endif  @endif"><i class="fas fa-building"></i> Companies</a></li>
            <li><a href="{{ url('admin/department/list')}}"  class="@if(isset($sidebar)) @if($sidebar == 'departments_list') active @endif  @endif"><span class="material-icons">account_tree</span> Departments</a></li>
            <li><a href="{{ url('admin/review-question/list')}}" class="@if(strpos(Request::url(), 'review-question') !== false) active @endif"><i class="fas fa-question-circle"></i> Review Questions</a></li>
            <li><a href="{{ url('admin/users/list')}}" class="@if(strpos(Request::url(), 'admin/users') !== false) active @endif"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="{{ url('admin/profile/users/list')}}" class="@if(strpos(Request::url(), 'admin/profile/users') !== false) active @endif"><i class="fas fa-users"></i> Profile</a></li>
            <li><a href="{{ url('admin/email')}}" class="@if(strpos(Request::url(), 'admin/email') !== false) active @endif"><i class="fas fa-envelope"></i> Email</a></li>
             <li><a href="{{ url('admin/notifications/list')}}" class="@if(strpos(Request::url(), 'admin/notifications') !== false) active @endif"><i class="fas fa-bell"></i> Notifications</a></li>
            <!-- <li><a href="{{ url('admin/reviews')}}" class="@if(strpos(Request::url(), 'admin/reviews') !== false) active @endif"><i class="fas fa-thumbs-up"></i> Reviews</a></li> -->
           <!--  <li><a href="{{ url('admin/setting')}}"  class="@if(strpos(Request::url(), 'setting') !== false) active @endif"><i class="fas fa-cog"></i> Setting</a></li> -->
        </ul>
      @endif
      @if(Auth::guard('admin')->user()->role == 2)  
        <ul>
         <li><a href="{{ url('/company/dashboard')}}" class="@if(isset($sidebar)) @if($sidebar == 'my_profile') active @endif  @endif"><span class="material-icons">bar_chart</span> My Profile</a></li>
            <li><a href="{{ url('/company/department/list')}}"  class="@if(isset($sidebar)) @if($sidebar == 'departments') active @endif  @endif"><span class="material-icons">account_tree</span> Departments</a></li>
            <li><a href="{{ url('/company/managers/list')}}" class="@if(isset($sidebar)) @if($sidebar == 'managers') active @endif  @endif"><i class="fas fa-question-circle"></i>Managers</a></li>
            <li><a href="{{ url('/company/review/list')}}" class="@if(isset($sidebar)) @if($sidebar == 'reviews') active @endif  @endif"><i class="fas fa-question-circle"></i> Reviews</a></li>
        </ul>    

      @endif
    </div>
</header>
    