@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-7">
                <h1 class="m-0">Account Settings</h1>
            </div>
            <div class="col-md-5 m-10">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0 mb-0 bg-white justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ url('admin/setting') }}" class="text-blue">Settings</a></li>
                        <!-- <li class="breadcrumb-item active" aria-current="page">Add Company</li> -->
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row p-0">
            <div class="col-md-12">
                <div class="tab-content">
                    <div id="company_details" class="tab-pane active"><br>
                       <form class="mainform" action="{{ url('admin/setting/update')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                         @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input id="email" type="text" placeholder="Enter Email" class="form-control @error('email') is-invalid @enderror" name="email" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input id="phone" type="text" placeholder="Phone Number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Facebook Link</label>
                                        <input id="facebook_link" type="text" placeholder="Facebook Link" class="form-control @error('facebook_link') is-invalid @enderror" name="facebook_link" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Twitter Link</label>
                                        <input id="twitter_link" type="text" placeholder="Twitter Link" class="form-control @error('twitter_link') is-invalid @enderror" name="twitter_link" value="">
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Linked-in Link</label>
                                        <input id="linked_in_link" type="text" placeholder="Linked-in Link" class="form-control @error('linked_in_link') is-invalid @enderror" name="linked_in_link" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Instagram Link</label>
                                        <input id="instagram_link" type="text" placeholder="Instagram Link" class="form-control @error('instagram_link') is-invalid @enderror" name="instagram_link" value="">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Pinterest Link</label>
                                        <input id="pinterest_link" type="text" placeholder="Pinterest Link" class="form-control @error('pinterest_link') is-invalid @enderror" name="pinterest_link" value="">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success round-shape">Save</button>
                        </form>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@foreach($data as $value)
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#{{ $value->u_code }}').val('{{ $value->info }}');
	});
</script>
@endforeach

<script type="text/javascript">
	jQuery('.mainform').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            email:{
                email:true,
            },
            phone:{
                number:true,
            },
          }      
      });
</script>


@endsection