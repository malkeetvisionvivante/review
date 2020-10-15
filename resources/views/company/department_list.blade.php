@extends('admin.admin_layout.admin_app')
@section('content')

<div class="inner-container">
<div class="card my-3 border-bottom">
    <div class="row p-0 justify-content-between">
        <div class="col-md">
            <h1>Departments</h1>
        </div>
        <div class="col-md">
          <form name="search_dep" action="{{ url('company/department/list')}}" method="get">
             @csrf
            <div class="input-group mb-1">
                <input type="text" name="name" value="{{ $name }}" class="form-control border-right-0"
                    placeholder="Search Department">
                <div class="input-group-prepend mr-0">
                    <button type="submit" class="input-group-text form-icon border-left-0"><i class="fas fa-search"></i></button>
                </div>
                <a href="#" data-toggle="modal" data-target="#add_department" class="btn btn-success round-shape ml-2">Add Department</a>
            </form>  
            </div>
        </div>
    </div>
</div>

<div class="card">
 @if(count($data)) 
  @foreach($data as $datas)
     <div class="row p-0">
        <div class="col-md-6 order-1 order-md-1">
            <h4>{{ $datas->name}} </h4>
        </div>
        <div class="col-md-6 order-3 order-md-2 text-right">
            <div class="mb-2">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input change_status" data-id="{{ $datas->id}}" id="status{{$datas->id}}"  @if($datas->status == 0) checked @endif>
                    <label class="custom-control-label" for="status{{$datas->id}}">Visible</label>
                </div>
                    <a href="#" data-id="{{ $datas->id}}" data-toggle="modal" data-target="#update_department"   class="edit_dept h6 text-blue"><i class="fas fa-pencil-alt"></i> Edit</a>
                    <a href="{{ url('/company/delete/dept/'.$datas->id)}}" onclick="return confirm('Are You Sure delete department Permanently!')" class="h6 text-blue ml-3"><i class="fas fa-trash"></i> Delete</a>
                </div>
        </div>
        <div class="col-md-12 order-2 order-md-3">
            <p>{{ $datas->description}}</p>
        </div>
    </div>

    <hr>
  @endforeach  
    <div class="row mt-5">
        <div class="col-md-12">
            <ul class="pagination align-items-center">
                {{ $data->appends(['name'=> $name])->links()}}
            </ul>
        </div>
    </div>
 @else
   <p>No Result Found!!</p>
 @endif   
</div>
</div>

<div class="modal fade" id="update_department">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

         <h4 style="margin-left: 1%;">Update Department</h4>
      <div class="modal-body px-4" id="load_model">

      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_department">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Add Department</h4>
        <form class="add-departmanet-form" method="post" action="{{ url('company/add/newdepartment')}}">
          @csrf
          <div class="form-group">
            <label>Department Name</label>
            <input type="text" placeholder="Department Name" class="form-control" name="name" required="">
          </div>
          <div class="form-group">
            <label>Department Description</label>
            <input type="text" placeholder="Description" class="form-control" name="description" required="">
          </div>
          <button type="submit" class="btn btn-success round-shape">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>



@endsection
@section('scripts')
 <script type="text/javascript">
    $(document).on('click','.change_status',function(){
        if(confirm('Are You sure to change status'))
        {
           var id = $(this).attr('data-id');
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
            $.ajax(
            {
                // url: "{{url('search_filter/admin/quiz')}}",
                url: "{{ url('/company/change_status/dept')}}/"+id,
                type: "post",
                data: {'id':id},
                success : function(data) { 
                   location.reload();
                },
                error : function(data) {

                }
            });
        }
        return false;
        
});
  $(document).on('click','.edit_dept',function(){
    var id =  $(this).attr('data-id');
    var url = "{{ url('/company/get_data_department')}}/" + id;
    $('#load_model').load(url,function(){
        $('#update_department').modal({show:true});
    });
  });


  jQuery('.add-departmanet-form').validate({
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


@endsection