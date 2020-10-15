@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-9">
                <h1>Review Questions</h1>
            </div>
            <div class="col-md-3 text-md-right">
              <a href="#" data-toggle="modal" data-target="#add_question" class="btn btn-success round-shape">Add Question</a>
            </div>
        </div>
    </div>

    <div class="card">
       @if(count($data)) 
        @foreach($data as $qus)
        <div class="row p-0">
            <div class="col-md-8">
                <h5 class="font-weight-500"> {{ $qus->question }} <span class="text-muted">( {{ $qus->question_for }} )</span></h5>
            </div>
            <div class="col-md-4 text-right">
                <div class="custom-control custom-switch custom-control-inline">
                    <input type="checkbox" class="custom-control-input change_status" data-id="{{ $qus->id }}" @if($qus->status == 0) checked @endif id="status{{ $qus->id }}" >
                    <label class="custom-control-label" for="status{{ $qus->id }}">Visible</label>
                </div>
                <a href="{{ url('admin/review-question/edit/'.$qus->id)}}" class="h6 text-blue edit-link"><i class="fas fa-pencil-alt"></i>  Edit</a>
                <a href="{{ url('admin/review-question/delete/'.$qus->id)}}" onclick="return confirm('Are You Sure delete user Permanently!')" class=" h6 text-blue ml-3"><i class="fas fa-trash "></i> Delete</a>
                
            </div>
        </div><hr>
          @endforeach  
         <div class="row mt-5">
            <div class="col-">
                {{ $data->links()}}
            </div>
            <div class="ccol- ml-4">
                <span class="text-muted" style="font-size: 14px;">
                    Showing {{count($data)}} of {{$countData}} Results
                </span>
            </div>
        </div>
     @else
       <p>No Result Found!!</p>
     @endif  
    </div>
</div>

<div class="modal fade" id="add_question">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Add Review Questions</h4>
        <form class="add-question-form" method="post" action="{{ url('admin/review-question/add')}}">
          @csrf
          <div class="form-group">
            <label>Questions</label>
            <input type="text" placeholder="Questions" class="form-control" name="question" required="">
          </div>
          <div class="form-group">
            <!-- <label>Short Description</label>
            <input type="text" placeholder="Description" class="form-control" name="description" required=""> -->
             <label>Category</label>
             <select class="form-control" name="category_id">
              <option value="">Select Category</option>
              @foreach($ReviewCategorys as $ReviewCategory)
              <option value="{{ $ReviewCategory->id }}">{{ $ReviewCategory->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
             <label>For</label>
             <select class="form-control" name="question_for">
              <option value="Manager">Manager</option>
              <option value="Peer">Peer</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success round-shape">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="update_question_model">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0">
        <button type="button" class="close px-2 py-1 " data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body px-4">
        <h4>Update Review Questions</h4>
        <form class="update-question-form" method="post" action="{{ url('admin/review-question/edit')}}">
          @csrf
          <input type="hidden" name="id" required="" id="update_id">
          <div class="form-group">
            <label>Questions</label>
            <input type="text" placeholder="Questions" class="form-control" name="question" required="" id="update_question">
          </div>
          <div class="form-group">
            <label>Category</label>
            <!-- <input type="text" placeholder="Description" class="form-control" name="description" required="" id="update_description"> -->
            <select class="form-control" name="category_id" id="update_description">
              <option value="">Select Category</option>
              @foreach($ReviewCategorys as $ReviewCategory)
              <option value="{{ $ReviewCategory->id }}">{{ $ReviewCategory->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
             <label>For</label>
             <select class="form-control" name="question_for" id="update_question_for">
              <option value="Manager">Manager</option>
              <option value="Peer">Peer</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success round-shape">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).on('click','.change_status',function(){
    if(confirm('Are You sure to change status')) {
      var id = $(this).attr('data-id');
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} });
      $.ajax({
            url: "{{ url('admin/review-question/change_status')}}",
            type: "post",
            data: {'id':id},
            success : function(data) { 
               location.reload();
            },
            error : function(data) {}
      });
    }
    return false;
  });

  $(document).on('click','.edit-link',function(e){
      e.preventDefault();
      var href = $(this).attr('href');
      $.ajax({
            url: href,
            type: "get",
            success : function(data) { 
              $('#update_id').val(data.id);
              $('#update_question').val(data.question);
              $('#update_description').val(data.category_id);
              $('#update_question_for').val(data.question_for);
              $('#update_question_model').modal({show:true});
            },
            error : function(data) {}
      });
  });

  jQuery('.add-question-form').validate({
      ignore: [],
      errorClass:"error-message",
      validClass:"green",
      rules:{
          question:{
              required:true,
          },
          category_id:{
              required:true,
          }
      }
  });
  jQuery('.update-question-form').validate({
      ignore: [],
      errorClass:"error-message",
      validClass:"green",
      rules:{
          question:{
              required:true,
          },
          category_id:{
              required:true,
          }
      }
  });
</script>
@endsection