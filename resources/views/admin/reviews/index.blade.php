@extends('admin.admin_layout.admin_app')
@section('content')
<div class="inner-container">
    <div class="card mt-3 border-bottom">
        <div class="row p-0">
            <div class="col-md-12">
                <h1>Reviews</h1>
            </div>
        </div>
    </div>

    <div class="card">
       @if(count($reviews)) 
        @foreach($reviews as $reva)
        @php $reviewer = $reva->customer1($reva->customer_id); @endphp
        <div class="row p-0">
          <div class="col-md-12">
                <p class="mb-0 font-weight-500">
                <span class="text-blue">{{ $reviewer->name }} {{ $reviewer->last_name }}</span> reviewed
                <span class="text-blue">{{ $reva->customer_name($reva->user_id)}}</span></p>
                <small class="text-muted-dark">{{ $reva->created_at}}<span class="ml-3">
                  <i class="fas fa-thumbs-up text-green"></i> {{ round($reva->avg_review,1) }}</span></small>
                    <small class="float-right pt-1">
                        <span class="text-blue show-detail show{{ $reva->id}}" data="{{ $reva->id}}">Reports ({{$reva->_flagCount()}})
                            <i class="fas fa-angle-down"></i>
                        </span>
                        <span class="text-blue hide-detail hide{{ $reva->id}}" data="{{ $reva->id}}">Reports ({{$reva->_flagCount()}})
                            <i class="fas fa-angle-up"></i>
                        </span>
                    </small>
                    <div class="collapse bg-light-blue p-3 p-md-4 mt-3 showreview{{$reva->id}}">
                        <table class="table custom-table table-border-0"> 
                            <tr>
                                <td class="font-size"> uyuu
                                    <i class="fas fa-exclamation-circle"></i>
                                </td>
                                <td class="text-right font-size">
                                    ghfghghgfh
                                </td>
                            </tr>
                        </table>
                  </div>         
              </div>
        </div>
        <hr>
          @endforeach  
         <div class="row mt-5">
            <div class="col-">
                {{ $reviews->links()}}
            </div>
            <div class="ccol- ml-4">
                <span class="text-muted" style="font-size: 14px;">
                    Showing {{count($reviews)}} of {{$countData}} Results
                </span>
            </div>
        </div>
     @else
       <p>No Result Found!!</p>
     @endif  
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.show-detail').click(function(){
            var id = jQuery(this).attr('data');
            jQuery('.showreview'+id).show();
            jQuery('.hide'+id).show();
            jQuery('.show'+id).hide();
        });
        jQuery('.hide-detail').click(function(){
            var id = jQuery(this).attr('data');
            jQuery('.showreview'+id).hide();
            jQuery('.hide'+id).hide();
            jQuery('.show'+id).show();
        });
    });
</script>
@endsection