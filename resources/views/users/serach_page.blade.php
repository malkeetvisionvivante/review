@extends('frontend.layouts.apps')
@section('content')
<div class="d-block d-md-none my-2">
  <div class="container-fluid">
    <div class="row w-100 justify-content-between m-0">
        <div class="col"><h4 class="m-0"><a href="#" data-toggle="modal" data-target="#Industry_Filter_Popup">Industry</a></h4></div>
        <div class="col text-right"><h4 class="m-0"><a href="#" data-toggle="modal" data-target="#Sort_Filter_Popup">Sort</a></h4></div>
    </div>
  </div>
</div>

<div class="d-none d-md-block my-3">
  <div class="container-fluid">
    <div class="card card-small">
    <div class="row">
      <form  action="" class="form-inline w-100 d-flex" id="filter1">
        @if(isset($_GET['name']))
        <input type="hidden" name="name" value="{{ $_GET['name'] }}" >
        @endif
          <div class="col-md">
              <div class="form-group">
                  <label class="mt-0 mr-3 h6">Industry</label>
                  <select class="custom-select" id="company_type_filter" name="type">
                      <option value="">---Select----</option>
                      @foreach($companyTypes as $ctype)
                        @if((int)$type == $ctype->id)
                        <option value="{{ $ctype->id }}" selected> {{ $ctype->name }}</option>
                        @else
                        <option value="{{ $ctype->id }}"> {{ $ctype->name }}</option>
                        @endif
                        @endforeach
                  </select>
              </div>
          </div>
          <div class="col-md">
              <div class="form-group justify-content-end">
                  <label class="mt-0 mr-3 h6">Sort by</label>
                  <select class="custom-select" id="sort_filter" name="sort">
                      <option value="name" <?php if($sort == "name") echo "selected"; ?> >Alphabetical</option>
                      <option value="rate_desc" <?php if($sort == "rate_desc") echo "selected"; ?>>Highest rating</option>
                      <option value="rate_asc" <?php if($sort == "rate_asc") echo "selected"; ?>>Lowest rating</option>
                  </select>
              </div>
          </div>
        </form>
      </div>
    </div>
    </div>
</div>


  <div class="row btn-section-sticky-top-all m-0" id="request_new_manager_button_sticky">
    <div class="col-md-12 text-center">
      @if(Auth::check())
        <a href="#" class="btn btn-custom-design" data-toggle="modal" data-target="#request_new_manager">
            Add a new colleague
        </a>
      @else
        <a href="#" class="btn btn-custom-design" id="request_new_manager_not_login">
            Add a new colleague
        </a>
      @endif
    </div>
  </div>


  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <ul class="nav nav-tabs custom-nav-tabs custom-nav-tabs-text-left add-new-colleague-btn" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="manager_tab_menu" data-toggle="tab" href="#menu1">People results</a>
          </li>  
          <li class="nav-item">
            <a class="nav-link" id="company_tab_menu" data-toggle="tab" href="#home">Company results</a>
          </li>           
        </ul>
      </div>
    </div>
  </div>

    
<div class="container-fluid">    
    <div class="tab-content search-outer-row mt-3">
        <div id="home" class="tab-pane">
          <div class="card card-small">
          @if(count($companys) > 0)
          @foreach($companys as $company)
            <div class="row search-row">
                <div class="col-lg-8 col-md-7">
                    <div class="media align-items-md-center">
                        <div class="media-left">
                            <div class="media-img-container">
                                @if($company->logo)
                                <a href="{{ url('/company-detail/'.$company->id) }}"><img src="{{ url('images/company/'.$company->logo) }}" alt="apple" class="img-fluid" /></a>
                                @else
                                 <a href="{{ url('/company-detail/'.$company->id) }}"><img src="{{ asset('images/company/silmarilli.svg')}}" alt="apple" class="img-fluid" /></a>
                                @endif
                            </div>
                        </div>
                        <div class="media-body">
                            <h3 class="mb-1"><a href="{{ url('/company-detail/'.$company->id) }}">{{ $company->company_name }}</a></h3>
                              <h6><a href="{{ url('/company-detail/'.$company->id) }}" class="text-dark">{{ $company->comp_type($company->company_type) }}</a></h6>
                              @if($company->fullAddress())
                              <h6 class="text-muted d-none d-md-block"><i class="fas fa-building"></i> {{ $company->fullAddress() }}</h6>
                              @endif
                              @if($company->no_of_employee)
                              <h6 class="text-muted">Employees: {{ $company->no_of_employee }}</h6>
                              @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-5 text-md-right score">
                    <div class="company-overall-score company-overall-score-vertical mt-2 mt-md-0">
                            <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $company->overallManagerReview(),'text' => 'Overall manager score']) </div>
                            <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $company->overallPeerReview(),'text' => 'Overall peer score']) </div>
                      </div>
                </div>
            </div>
          @endforeach
          @else 
            <div class="card card-small">No results found.</div>
          @endif
          </div>
          <div class="row mt-3">
            <div class="col-md-12 text-center">
              <?php 
                $apendData = ['c_page' => $companys->currentPage()];
                if(isset($_GET['sort'])){
                  $apendData['sort'] = $_GET['sort'];
                }
                if(isset($_GET['type'])){
                  $apendData['type'] = $_GET['type'];
                }
                if(isset($_GET['name'])){
                  $apendData['name'] = $_GET['name'];
                }
                if(isset($_GET['m_page'])){
                  $apendData['m_page'] = $_GET['m_page'];
                }
              ?>
              {{-- $companys->appends($apendData)->links() --}}
              <?php $link_limit = 7; ?>
              @if ($companys->lastPage() > 1)
                <ul class="pagination justify-content-lg-start justify-content-center ">
                  <li class="page-item {{ ($companys->currentPage() == 1) ? ' disabled' : '' }}">
                      <a class="page-link" href="{{ $companys->appends($apendData)->previousPageUrl() }}">‹</a>
                   </li>
                  @for ($i = 1; $i <= $companys->lastPage(); $i++)
                      <?php
                      $half_total_links = floor($link_limit / 2);
                      $from = $companys->currentPage() - $half_total_links;
                      $to = $companys->currentPage() + $half_total_links;
                      if ($companys->currentPage() < $half_total_links) {
                         $to += $half_total_links - $companys->currentPage();
                      }
                      if ($companys->lastPage() - $companys->currentPage() < $half_total_links) {
                          $from -= $half_total_links - ($companys->lastPage() - $companys->currentPage()) - 1;
                      }
                      ?>
                      @if ($from < $i && $i < $to)
                          <li class="page-item {{ ($companys->currentPage() == $i) ? ' active' : '' }}">
                              <a class="page-link" href="{{ $companys->appends($apendData)->url($i) }}">{{ $i }}</a>
                          </li>
                      @endif
                  @endfor
                  <li class="page-item {{ ($companys->currentPage() == $companys->lastPage()) ? ' disabled' : '' }}">
                      <a class="page-link" href="{{ $companys->appends($apendData)->nextPageUrl() }}">›</a>
                  </li>
                </ul>
              @endif
            </div>
          </div>
        </div>
        <div id="menu1" class="tab-pane active">
          <div class="card card-small">
          @if(count($managers) > 0)
            @foreach($managers as $manager)
              <div class="row search-row align-items-center">
                  <div class="col-lg-8 col-md-7 d-md-flex">
                      <div class="media align-items-center">
                          <div class="media-left">
                              <div class="media-img-container p-0 rounded-circle border-0">
                                  @if($manager->profile)
                                  <a href="{{ url('/manager-detail/'.$manager->id)}}"><img src="{{ url('images/users/'.$manager->profile) }}" alt="{{ $manager->name }} {{ $manager->last_name }}" class="img-fluid rounded-circle" /></a>
                                  @else 
                                  <a href="{{ url('/manager-detail/'.$manager->id)}}"><img src="{{ asset('images/default/user.png') }}" alt="{{ $manager->name }} {{ $manager->last_name }}" class="img-fluid rounded-circle" /></a>
                                  @endif
                              </div>
                          </div>
                          <div class="media-body">
                            <div class="d-flex justify-content-between">
                              <h3 class="mb-1"><a href="{{ url('/manager-detail/'.$manager->id)}}"> {{ $manager->name }} {{ $manager->last_name }}</a></h3>
                              </div>
                              <h6 class="text-muted mb-md-0"><a href="{{ url('/company-detail/'.$manager->company_id)}}" class="text-dark">{{ $manager->company_name }}</a></h6>
                              <h6 class="text-muted  d-none d-md-block">{{ $manager->companyType( $manager->company_id) }}</h6>
                              <h6 class="text-muted mt-md-3 mb-1">
                                @if($manager->isDepartment())
                                  @if($manager->departmentIsVisible())
                                   <a href="{{ url('/manager-list/'.$manager->company_id.'/'.$manager->department_id)}}" class="text-dark">{{ $manager->departmentName() }}</a>
                                  @else
                                     <span class="text-dark">{{ $manager->departmentName() }}</span>
                                  @endif
                                @endif
                              </h6>  
                              <div class="d-block d-md-none">
                                <div class="company-overall-score company-overall-score-vertical mt-2 mt-md-0">
                                    <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $manager->managerAvg(),'text' => 'Manager score']) </div>
                                    <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $manager->peerAvg(),'text' => 'Peer score']) </div>
                                </div>
                              </div> 
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-md-5 text-md-right score">
                    <div class="d-none d-md-block">
                      <div class="company-overall-score company-overall-score-vertical mt-2 mt-md-0">
                          <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $manager->managerAvg(),'text' => 'Manager score']) </div>
                          <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $manager->peerAvg(),'text' => 'Peer score']) </div>
                      </div>
                    </div>
                  </div>
              </div>
            @endforeach
          @else 
            <div class="card card-small"> No results found.</div>
          @endif
          </div>
          <div class="row mt-3">
            <div class="col-md-12 text-center">
            <?php 
              $apendData = ['m_page' => $managers->currentPage()];
              if(isset($_GET['sort'])){
                $apendData['sort'] = $_GET['sort'];
              }
              if(isset($_GET['type'])){
                $apendData['type'] = $_GET['type'];
              }
              if(isset($_GET['name'])){
                $apendData['name'] = $_GET['name'];
              }
              if(isset($_GET['c_page'])){
                $apendData['c_page'] = $_GET['c_page'];
              }
            ?>
            {{-- $managers->appends($apendData)->links() --}}

            <?php $link_limit = 7; ?>
            @if ($managers->lastPage() > 1)
              <ul class="pagination justify-content-lg-start justify-content-center ">
                <li class="page-item {{ ($managers->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $managers->appends($apendData)->previousPageUrl() }}">‹</a>
                 </li>
                @for ($i = 1; $i <= $managers->lastPage(); $i++)
                    <?php
                    $half_total_links = floor($link_limit / 2);
                    $from = $managers->currentPage() - $half_total_links;
                    $to = $managers->currentPage() + $half_total_links;
                    if ($managers->currentPage() < $half_total_links) {
                       $to += $half_total_links - $managers->currentPage();
                    }
                    if ($managers->lastPage() - $managers->currentPage() < $half_total_links) {
                        $from -= $half_total_links - ($managers->lastPage() - $managers->currentPage()) - 1;
                    }
                    ?>
                    @if ($from < $i && $i < $to)
                        <li class="page-item {{ ($managers->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $managers->appends($apendData)->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor
                <li class="page-item {{ ($managers->currentPage() == $managers->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $managers->appends($apendData)->nextPageUrl() }}">›</a>
                </li>
              </ul>
            @endif
            </div>
          </div>
      </div>
    </div>
</div>




<!-- Filter popup -->
<div class="modal fade" id="Industry_Filter_Popup">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body pt-0">
        <form  action="" class="form-inline mt-4" id="filter2">
            <div class="form-group w-100">
              @if(isset($_GET['name']))
              <input type="hidden" name="name" value="{{ $_GET['name'] }}" >
              @endif
              <input type="hidden" name="sort" value="{{ $sort }}" >
                <label class="mt-0 mr-3 h6">Industry</label>
                <select class="custom-select" id="company_type_filter1" name="type">
                    <option value="">---Select----</option>
                    @foreach($companyTypes as $ctype)
                      @if((int)$type == $ctype->id)
                      <option value="{{ $ctype->id }}" selected> {{ $ctype->name }}</option>
                      @else
                      <option value="{{ $ctype->id }}"> {{ $ctype->name }}</option>
                      @endif
                      @endforeach
                </select>
            </div>
          </form>
    </div>
  </div>
</div>
</div>


<!-- Filter popup -->
<div class="modal fade" id="Sort_Filter_Popup">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body pt-0">
        <form  action="" class="form-inline mt-4" id="filter3">
          @if(isset($_GET['name']))
            <input type="hidden" name="name" value="{{ $_GET['name'] }}" >
          @endif
          <input type="hidden" name="type" value="{{ $type }}" >
            <div class="form-group justify-content-end w-100">
                <label class="mt-0 mr-3 h6">Sort by</label>
                <select class="custom-select" id="sort_filter1" name="sort">
                    <option value="name" <?php if($sort == "name") echo "selected"; ?> >Alphabetical</option>
                    <option value="rate_desc" <?php if($sort == "rate_desc") echo "selected"; ?>>Highest rating</option>
                    <option value="rate_asc" <?php if($sort == "rate_asc") echo "selected"; ?>>Lowest rating</option>
                </select>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
@if(Auth::check())
@include('users.add_manager_popup')
@endif

<script type="text/javascript">
    
    jQuery(document).ready(function(){
      jQuery('#company_type_filter').change(function(){
        jQuery('#filter1').submit();
      });
      jQuery('#sort_filter').change(function(){
        jQuery('#filter1').submit();
      });
      jQuery('#company_type_filter1').change(function(){
        jQuery('#filter2').submit();
      });
      jQuery('#sort_filter1').change(function(){
        jQuery('#filter3').submit();
      });

      if(localStorage.getItem('currentFilter')){
        var filter = localStorage.getItem('currentFilter');
        if(filter == 'company'){
          jQuery('#company_tab_menu').trigger('click');
          jQuery('#request_new_manager_button_sticky').hide();
        } else {
          jQuery('#manager_tab_menu').trigger('click');
          jQuery('#request_new_manager_button_sticky').show();
        }
      } else {
        localStorage.setItem('currentFilter', 'manager');
        jQuery('#request_new_manager_button_sticky').show();
      }
      jQuery('#company_tab_menu').click(function(){
        localStorage.setItem('currentFilter', 'company');
        jQuery('#request_new_manager_button_sticky').hide();
      });
      jQuery('#manager_tab_menu').click(function(){
        localStorage.setItem('currentFilter', 'manager');
        jQuery('#request_new_manager_button_sticky').show();
      });
    });
    $('#request_new_manager_not_login').click(function(){
        window.location.href = "{{ url('/login-user') }}";
        toastr.error('Please login first.')
    });
</script>
@endsection
