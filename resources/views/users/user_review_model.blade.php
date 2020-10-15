<div class="bg-light-blue p-3">
  <div class="row">
    <div class="col-7">
      <h6 class="mb-0">{{ $review_data->customer_name($review_data->user_id) }}</h6>
      <small class="text-muted">Manager, {{ $review_data->department_name() }}</small>
    </div>
    <div class="col-5 text-right">
      <small class="text-muted">{{ $review_data->created_at->diffForHumans()}}</small>
    </div>
  </div>
</div>
@php  $reviews = json_decode($review_data->review_value);   @endphp
<table class="table custom-table">
  <tr>
      <th colspan="2" class="text-muted">Assessment on Manager Across key Qualities</th>
  </tr>
  @foreach ($reviews as $key => $rate)
  <tr>
      <td>{{ $review_data->Question($key) }}</td>
      <td style="white-space:nowrap;text-align: right;">
        @include('frontend.user_rating.5_thumb',['rate' => $rate]) 
      </td>
  </tr>
  @endforeach
</table> 
