@extends('frontend.layouts.apps')
@section('content')

<div class="container-fluid">
<div class="card small my-3 d-none d-md-block">
        <div class="row p-0">
            <div class="col-md-6 order-2 order-md-1">
                <h1 class="h2">Departments</h1>
            </div>
            <!-- <div class="col-md-6 order-1 order-md-2">
             <form name="Search" action="{{ url('/department-list-user')}}" method="post">
               @csrf 	
                <div class="input-group mb-1">
                    <input type="text" class="form-control border-right-0"
                        placeholder="Search Departments" name="name" value="{{ $name}}">
                    <div class="input-group-prepend mr-0">
                        <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>
                    </div>
                </div>
              </form>   
            </div> -->
        </div>
    </div>

    <div class="card small mt-3 pb-0 d-block d-md-none sticky-top-mobile">
        <div class="row p-0">
            <div class="col-lg-6 col-md-7 text-md-right sticky-top-mobile">
            <form name="Search" action="{{ url('/department-list-user')}}" method="post">
               @csrf 	
                <div class="input-group mb-1">
                    <input type="text" class="form-control border-right-0"
                        placeholder="Search Departments" name="name" value="{{ $name}}">
                    <div class="input-group-prepend mr-0">
                        <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>    
            </div>
        </div>
    </div>

    <div class="card small mb-3 d-block d-md-none">
        <div class="row p-0">
            <div class="col-lg-6 col-md-5">
                <h1>Search</h1>
            </div>
        </div>
    </div>
    
    <div class="card mt-2">
        <div class="row p-0">
            <div class="col-md-12">
                <!-- <h3 class="mb-3">Departments</h3> -->
            @if(count($data))
             @foreach($data as $datas)
                <a href="{{ url('/department-detail-user/'.$datas->id)}}" class="h5 mb-1 d-block">{{ $datas->name}}</a>
                <p>{{ $datas->description }}</p><hr>
             @endforeach   
            @else
             <p style="margin-left: 5px;">No Result Found!!</p>
            @endif    
            </div>
        </div>
    </div>
</div>


@endsection