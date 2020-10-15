@extends('frontend.layouts.apps')
@section('content')
<?php $dataInfo = $data; ?>
<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-muted" href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active text-primary" aria-current="page">Company</li>
      </ol>
    </nav>

    <div class="col-md-12 btn-section-sticky-top text-center">
        <div class="d-block d-md-none">
            <a href="{{ url('add-review-user/'.$dataInfo->id)}}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
        </div>
    </div>

    <div class="card small mt-2">
        <div class="row p-0">
        <div class="col-md-7">
                <div class="media align-items-center">
                    <div class="media-left">
                        <div class="media-img-container">
                            @if($dataInfo->logo)
                            <a href="{{ url('/company-detail/'.$dataInfo->id)}}"><img src="{{ asset('images/company/'.$dataInfo->logo)}}" alt="profile" class="img-fluid" /></a>
                            @else
                             <a href="{{ url('/company-detail/'.$dataInfo->id)}}"><img src="{{ asset('images/company/silmarilli.svg')}}" alt="profile" class="img-fluid" /></a>
                            @endif
                        </div>
                    </div>
                    <div class="media-body">
                        <h3><a href="{{ url('company-detail/'.$dataInfo->id)}}" class="text-dark">{{ $dataInfo->company_name}}</a></h3>
                        <h6 class="text-muted">{{ $dataInfo->company_type_name}}</h6>
                        @if($dataInfo->fullAddress())
                        <h6 class="text-muted"><i class="fas fa-building"></i> {{ $dataInfo->fullAddress() }}</h6>
                        @endif
                        @if($dataInfo->no_of_employee)
                        <h6 class="text-muted">Employees: {{ $dataInfo->no_of_employee }}</h6>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5 text-md-right score mt-3 mt-md-0">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="company-overall-score company-overall-score-vertical">
                            <div class="seprate">@include('frontend.user_rating.1_thumb_manager',['rate' => $dataInfo->overallManagerReview(),'text' => 'Overall manager score']) </div>
                            <div class="seprate"> @include('frontend.user_rating.1_thumb_peer',['rate' => $dataInfo->overallPeerReview(),'text' => 'Overall peer score']) </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="d-none d-md-block">
                            <a href="{{ url('add-review-user/'.$dataInfo->id)}}" class="btn btn-success with-anonymously">Add your review <small class="btn-anonymous-text">(Anonymously)</small></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="text-center">
        <a href="{{ url('add-review-user/'.$dataInfo->id)}}" class="btn btn-primary">Add my review</a>
    </div> -->
    <div class="card small mt-2">
        <div class="row p-0">
            <div class="col-md-12">
                <h4 class="mb-3">Department Score <!-- <span class="float-left float-sm-right small">Have recommendation or edit? 
                    <a href="{{ url('/help') }}">Let us know</a></span> -->
                </h4>
                @if(count($departments))
                <table class="table custom-table">
                    <tr>
                        <th style="vertical-align:bottom;">Department</th>
                        <th>
                            <div class="card-small-score-sec text-center"><img src="{{ asset('images/manager-score-small.png')}}"/> <span class="text-nowrap">Manager score</span></div>
                            <!-- Score -->
                        </th>
                        <th style="width:25%;" class="text-center text-md-right">
                            <div class="card-small-score-sec"><img src="{{ asset('images/peer-score-small.png')}}"/> <span class="text-nowrap">Peer score</span></div>
                            <!-- Industry average -->
                        </th>
                    </tr>
                    @foreach($departments as $department)
                    @if($dataInfo && $dataInfo->comp_type($dataInfo->company_type) != "Consulting" && $department->name == "Consulting, Research & Solutions") @continue @endif
                        <?php $depManagerScore = $department->companyDepartmentManagerScore($dataInfo->id, $department->id); ?>
                        <?php $depPeerScore = $department->companyDepartmentManagerPeerScore($dataInfo->id, $department->id); ?>
                        <tr>
                            <td>
                                <a class="font-weight-bold" href="{{ url('/manager-list/'.$dataInfo->id.'/'.$department->id) }}">
                                    {{ $department->name }} 
                                </a>
                                <sup><a href="javascript:void(0)"><i class="fas fa-info-circle text-muted" data-id="#model_id_{{$department->id}}" ></i></a></sup>
                            </td>
                            <td style="white-space:nowrap;" class="text-center">
                                <div class="table-score">@include('frontend.user_rating.1_thumb_with_url',['rate' => $depManagerScore,'url' => url('/manager-list/'.$dataInfo->id.'/'.$department->id) ])</div>
                            </td>
                            <td style="white-space:nowrap;" class="text-center text-md-right">
                                @include('frontend.user_rating.1_thumb_with_url',['rate' => $depPeerScore,'url' => url('/manager-list/'.$dataInfo->id.'/'.$department->id)])
                            </td>
                        </tr>
                    @endforeach       
                </table>
                @else
                    <p>No Department Found!!</p>
                @endif 
            </div>
        </div>
    </div>
    <div class="small mt-2">
        <div class="row p-0">
            <div class="col-md-12">
                <h4 class="mt-2"><span class="float-left small">Have recommendation or edit? 
                    <a href="{{ url('/let-us-know') }}">Let us know</a></span>
                </h4>
            </div>
        </div>
    </div>

</div>
@foreach($departments as $department)
    <div class="modal-tooltip" id="model_id_{{$department->id}}">
        <div class="modal-body">
            <h4>{{ $department->name }} </h4><hr>
            <p>{{ $department->description }}</p>
        </div>
    </div>
@endforeach

<script type="text/javascript">
   jQuery(document).ready(function(){
     jQuery('table tr td a i').mouseover(function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).show();
     });
     jQuery('table tr td a i').mouseout(function(){
       var id = jQuery(this).attr('data-id');
       jQuery(id).hide();
     });
   });
</script>
@endsection