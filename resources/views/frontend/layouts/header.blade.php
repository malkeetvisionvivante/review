<section class="navbar-outer-div">
    <header>
        <div class="container-fluid">
            <div class="row align-items-center py-2">
                <div class="col-lg-5 col-md-4 col">
                    @if (Auth::check())
                    <a href="{{ url('/reviews') }}"><img src="{{ asset('images/blossom_logo_primary.svg')}}" class="img-fluid logo" alt="blossom_logo"></a>
                    @else
                    <a href="{{ url('/') }}"><img src="{{ asset('images/blossom_logo_primary.svg')}}" class="img-fluid logo" alt="blossom_logo"></a>
                    @endif
                </div>
                
                <div class="col text-right d-inline-block d-md-none">
                    @if (!Auth::check())
                    <a href="{{ url('/login-user') }}" class="btn btn-success ml-2 btn-login">Log In</a>
                    @else
                    <nav class="header-nav">
                        <ul class="navbar-nav">
                        @if(strpos(Request::url(), '/reviews') !== false)
                        <li class="nav-item">
                            <a href="{{ url('/reviews') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Newsfeed">
                              <img src="{{ asset('images/newsfeed-filled.svg')}}" alt="" width="40" height="40"/>
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ url('/reviews') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Newsfeed">
                            <img src="{{ asset('images/newsfeed.svg')}}" alt="" width="40" height="40"/></a>
                        </li>
                        @endif
                        @if(strpos(Request::url(), 'notifications') !== false)
                        <li class="nav-item notification active">
                            <a href="{{ url('/notifications') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Notification"><i class="fas fa-bell"></i></a>
                            <span class="badge">5</span>
                        </li>
                        @else
                        <li class="nav-item notification">
                            <a href="{{ url('/notifications') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Notification"><i class="fas fa-bell"></i></a>
                            <span class="badge">5</span>
                        </li>
                        @endif
                        @if(strpos(Request::url(), 'manager-detail') !== false)
                        <li class="nav-item profile-nav-image active">
                        <a href="{{ url('/manager-detail/'.Auth::user()->id )}}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Profile">
                            @if(!empty(Auth::user()->profile))     
                            <img src="{{ asset('images/users/'.Auth::user()->profile)}}" alt="profile" class="rounded-circle profile-image-style"/>
                              @if(Auth::user()->inCompleteProfileCount() > 0)
                                <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                              @endif
                            @else
                            <img src="{{ asset('images/default/user.png')}}" alt="user-profile" class="rounded-circle profile-image-style"/>
                              @if(Auth::user()->inCompleteProfileCount() > 0)
                                <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                              @endif
                            @endif
                        </a>
                        </li>
                        @else
                        <li class="nav-item profile-nav-image">
                          <a href="{{ url('/manager-detail/'.Auth::user()->id )}}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Profile">
                              @if(!empty(Auth::user()->profile))     
                              <img src="{{ asset('images/users/'.Auth::user()->profile)}}" alt="profile" class="rounded-circle profile-image-style"/>
                                @if(Auth::user()->inCompleteProfileCount() > 0)
                                  <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                                @endif
                              @else
                              <img src="{{ asset('images/default/user.png')}}" alt="user-profile" class="rounded-circle profile-image-style"/>
                                @if(Auth::user()->inCompleteProfileCount() > 0)
                                  <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                                @endif
                              @endif
                          </a>
                          </li>
                          @endif
                         <li class="nav-item dropdown show">
                             <a id="navbarDropdown" class="dropdown-toggle nav-link" href="javascript:void(0)"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <!-- {{ Auth::user()->name }} -->
                             </a>
                             <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/manager-detail/'.Auth::user()->id )}}">My profile</a>
                                <a class="dropdown-item" href="{{ url('/my-profile')}}">Settings</a>
                                <a class="dropdown-item" href="{{ url('/logout-user') }}">{{ __('Logout') }}</a>
                             </div>
                         </li>
                       </ul> 
                     </nav>
                    @endif
                </div>
                <div class="col-lg-7 col-md-8 d-flex corner-image-overlap-section">
                    <form name="serch_home" action="{{ url('search/results') }}" method="get" class="w-100">
                      @csrf
                      <div class=" @if(!strpos(Request::url(), 'home')) input-group  @endif">
                        @if(!strpos(Request::url(), 'home'))
                        @if(isset($_GET['name']))
                        <input type="text" name="name" value="{{ $_GET['name'] }}" class="form-control search-form-control border-right-0" placeholder="Search for companies, managers, colleagues" id="custom_serach_top">
                        @else
                        <input type="text" name="name" class="form-control search-form-control border-right-0" placeholder="Search for companies, managers, colleagues" id="custom_serach_top">
                        @endif
                        
                        <div class="input-group-prepend">
                          <button type="submit" class="input-group-text form-icon form-icon-small border-left-0"><ion-icon name="search-outline"></ion-icon></button>
                        </div>
                        @endif
                      </div>
                    </form>
                      
                      <!-- <input type="text" class="form-control border-right-0"
                          placeholder="Search for companies, managers, colleagues">
                      <div class="input-group-prepend mr-0">
                          <a href="#" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></a>
                      </div> -->
                      <div class="d-none d-md-flex header-tooltip text-nowrap">
                      @if (Auth::check())
                      <nav class="header-nav ml-3">
                       <ul class="navbar-nav">
                       @if(strpos(Request::url(), '/reviews') !== false)
                        <li class="nav-item">
                            <a href="{{ url('/reviews') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Newsfeed">
                              <img src="{{ asset('images/newsfeed-filled.svg')}}" alt="" width="40" height="40"/>
                            </a>
                        </li>
                        @else
                        <li class="nav-item">
                            <a href="{{ url('/reviews') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Newsfeed">
                            <img src="{{ asset('images/newsfeed.svg')}}" alt="" width="40" height="40"/></a>
                        </li>
                        @endif
                        @if(strpos(Request::url(), 'notifications') !== false)
                        <li class="nav-item notification active">
                            <a href="{{ url('/notifications') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Notification"><i class="fas fa-bell"></i></a>
                            <span class="badge">5</span>
                        </li>
                        @else
                        <li class="nav-item notification">
                            <a href="{{ url('/notifications') }}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Notification"><i class="fas fa-bell"></i></a>
                            <span class="badge">5</span>
                        </li>
                        @endif
                        @if(strpos(Request::url(), 'manager-detail') !== false)
                        <li class="nav-item profile-nav-image active">
                        <a href="{{ url('/manager-detail/'.Auth::user()->id )}}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Profile">
                            @if(!empty(Auth::user()->profile))     
                            <img src="{{ asset('images/users/'.Auth::user()->profile)}}" alt="profile" class="rounded-circle profile-image-style"/>
                              @if(Auth::user()->inCompleteProfileCount() > 0)
                                <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                              @endif
                            @else
                            <img src="{{ asset('images/default/user.png')}}" alt="user-profile" class="rounded-circle profile-image-style"/>
                              @if(Auth::user()->inCompleteProfileCount() > 0)
                                <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                              @endif
                            @endif
                        </a>
                        </li>
                        @else
                        <li class="nav-item profile-nav-image">
                          <a href="{{ url('/manager-detail/'.Auth::user()->id )}}" class="nav-link" data-toggle="tooltip" data-placement="top" title="Profile">
                              @if(!empty(Auth::user()->profile))     
                              <img src="{{ asset('images/users/'.Auth::user()->profile)}}" alt="profile" class="rounded-circle profile-image-style"/>
                                @if(Auth::user()->inCompleteProfileCount() > 0)
                                  <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                                @endif
                              @else
                              <img src="{{ asset('images/default/user.png')}}" alt="user-profile" class="rounded-circle profile-image-style"/>
                                @if(Auth::user()->inCompleteProfileCount() > 0)
                                  <span class="badge">{{ Auth::user()->inCompleteProfileCount() }}</span>
                                @endif
                              @endif
                          </a>
                          </li>
                          @endif
                        <li class="nav-item dropdown show mx-0">
                            <a id="navbarDropdown" class="dropdown-toggle nav-link" href="javascript:void(0)"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!-- {{ Auth::user()->name }} -->
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/manager-detail/'.Auth::user()->id )}}">My profile</a>
                                <a class="dropdown-item" href="{{ url('/my-profile')}}">Settings</a>
                                <a class="dropdown-item" href="{{ url('/logout-user') }}">{{ __('Logout') }}</a>
                            </div>
                        </li>
                      </ul> 
                    </nav> 
                      @else

                      @if ($headerData != null && Auth::guest() && Request::path() == 'home')
                      <?php
                        $title = '';
                        if(!$headerData[1]){
                            $title = "You were invited by an anonymous colleague.";
                        }
                        elseif($headerData[0]->mystery_invite == 1){
                            if($headerData[1]->company_id == null || $headerData[1]->department_id == null){
                                $title = "You were invited by an anonymous colleague.";
                            }else{
                                $title = "You were invited by someone working at ";
                                if($headerData[1]->company_id !== null){
                                    $title .= $headerData[1]->companyName($headerData[1]->company_id);
                                }
                                $title .= " in ";
                                if($headerData[1]->department_id !== null){
                                    $title .= $headerData[1]->departmentName();
                                }
                                $title .= ".";
                            }
                        }else{
                            $title = $headerData[1]->name." ".$headerData[1]->last_name;
                            if($headerData[1]->company_id !== null){
                            $title .= " from ".$headerData[1]->companyName($headerData[1]->company_id);
                            }
                            $title .= " invited you to Blossom.";
                        }
                      ?>
                      <span class="header_tooltip_customize">
                        Learn more about who invited you...
                        <sup><a href="#" class="text-muted" data-toggle="tooltip" data-placement="bottom" 
                        title="{{$title}}"><i class="fas fa-info-circle"></i></a></sup>
                      </span>
                      
                      @endif
                      <a href="{{ url('/login-user') }}" class="btn btn-success ml-2 btn-login">Log In</a>
                      @endif
                    </div>
                    <!-- <div class="d-block d-md-none ml-2 text-nowrap">
                        <a href="#" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
                    </div> -->
                </div>
            </div>
        </div>
    </header>
</section>
