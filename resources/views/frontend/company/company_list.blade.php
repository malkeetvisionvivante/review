@extends('frontend.layouts.apps')
@section('content')
<div class="container-fluid">
    <div class="card small my-3 d-none d-md-block">
        <div class="row p-0">
            <div class="col-lg-6 col-md-5">
                <h1>Companies</h1>
            </div>
            <!-- <div class="col-lg-6 col-md-7 text-md-right">
                 <form name="serch_company" action="{{ url('company-list-user')}}" method="post">
                   @csrf 	
                <div class="input-group mb-1">
                    <input type="text" name="company_name" class="form-control border-right-0"
                        placeholder="Search companies" value="{{ $company_name }}">
                    <div class="input-group-prepend mr-0">
                        <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>   
                    </div>
                </div>
               </form> 
                <span>Don't see your company? <a href="#" class="text-priamry">Let us know!</a></span>
            </div> -->
        </div>

        <div class="row mt-3">
            <div class="col-md">
                <div class="form-group">
                    <label class="mt-1" for="industry" style="font-size: 17px">Industry</label>
                    <select class="form-control custom-select ml-3" name="industry" id="industry" style="width: 30%">
                        <option value="" disabled selected>Select Industry</option>
                        <option value="1">Technology</option>
                        <option value="2">Online MarketPlace</option>
                    </select>
                </div>
            </div>
             <div class="col-md">
                <div class="form-group" style="text-align: end">
                        <label class="mt-1" for="industry" style="font-size: 17px">Sort by</label>
                        <select class="form-control custom-select ml-3" name="rating" id="rating" style="width: 30%">
                            <option value="" disabled selected>Alphabetical</option>
                            <option value="1">Highest Rating</option>
                            <option value="2">Lowest Rating</option>
                        </select>
                </div>
            </div>
        </div>


    </div>

    <div class="card small mt-3 pb-0 d-block d-md-none sticky-top-mobile">
        <div class="row p-0">
            <div class="col-lg-6 col-md-7 text-md-right sticky-top-mobile">
                <div class="input-group mb-1">
                    <input type="text" class="form-control border-right-0"
                        placeholder="Search for companies and managers">
                    <div class="input-group-prepend mr-0">
                        <a href="#" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card small mb-3 d-block d-md-none">
        <div class="row p-0">
            <div class="col-lg-6 col-md-5">
                <h1>Companies</h1>
                <span>Don't see your company? <a href="#" class="text-priamry">Let us know!</a></span>
            </div>
        </div>
    </div>
 @if(count($data))
  @foreach($data as $datas)
    <div class="card small mt-2">
        <div class="row p-0">
            <div class="col-md-9">
                <div class="media align-items-center">
                    <div class="media-left">
                        <div class="media-img-container">
                            <a href="#"><img src="{{ asset('images/company/'.$datas->profile)}}" alt="profile" class="img-fluid" /></a>
                        </div>
                    </div>
                    <div class="media-body">
                        <a href="{{ url('/company-detail-user/'.$datas->id)}}"><h3>{{ $datas->name}}</h3></a>
                        <h6 class="text-muted">{{ $datas->company_type_name}}</h6>
                        <h6 class="d-none d-md-block text-muted"><i class="fas fa-building"></i> {{ $datas->fullAddress() }}</h6>
                        <h6 class="text-muted d-none d-md-block">Employees: {{ $datas->company['no_of_employee']}}</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center text-md-right score">
                <p class="mb-1"><span class="thumb"><i class="fas fa-thumbs-up"></i></span> {{ round($datas->review($datas->id),1)}} Company</p>
                <p class="mb-1"><span class="thumb"><i class="fas fa-thumbs-up"></i></span> {{ round($datas->industry_avg($datas->company['company_type']),1)}} Industry Average</p>
            </div>
        </div>
    </div>
  @endforeach  
      {{ $data->appends(['company_name' => $company_name])->links()}}
 @else
   <p style="margin-left: 5px;">No Result found</p>
 @endif   
</div>


@endsection