@extends('frontend.layouts.apps')
@section('content')
  <div class="container-fluid">
    
    <div class="card mt-2">
        <div class="row p-0">
            <div class="col-md-12">
                <h3 class="mb-3">{{ $data->name}}</h3>
                <p>{{ $data->description}}</p>
            </div>
        </div>
    </div>
</div>
@endsection