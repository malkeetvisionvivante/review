@if(Auth::guard('admin')->user()->role == 1)
<form class="update-departmanet-form" method="post" action="{{ url('admin/update/department/'.$data->id)}}">
  @else
   <form class="update-departmanet-form" method="post" action="{{ url('company/update/department/'.$data->id)}}">
  @endif
    @csrf
    <div class="form-group">
      <label>Department Name</label>
      <input type="text" placeholder="Department Name" class="form-control" name="name" required="" value="{{ $data->name}}">
    </div>
    <div class="form-group">
      <label>Department Description</label>
      <input type="text" placeholder="Description" class="form-control" name="description" required="" value="{{ $data->description}}">
    </div>
    <button type="submit" class="btn btn-success round-shape">Save</button>
  </form>

  <script type="text/javascript">
    jQuery('.update-departmanet-form').validate({
        ignore: [],
        errorClass:"error-message",
        validClass:"green",
        rules:{
            name:{
                required:true,
            },
            description:{
                required:true,
            }
        }
    });
  </script>