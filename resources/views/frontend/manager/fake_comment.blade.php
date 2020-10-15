<div class="card small-card mt-3 appendclass">
  <div class="row p-0">
    <div class="col-md-12">
      <h3>Feedback</h3>
      <p class="text-muted mb-2"><i>What advice would you give {{ $data->name}} {{ $data->last_name}} to further improve?</i></p>
    </div>
  </div><hr>
  <div class="d-none d-md-block">
  <div class="row p-md-4">
    <div class="col-md-12">
      <img src="{{ asset('images/comment1-desktop.jpg')}}" alt="" class="img-fluid"/>
    </div>
  </div>
  <hr>
  <div class="row p-md-4">
    <div class="col-md-12">
      <img src="{{ asset('images/comment2-desktop.jpg')}}" alt="" class="img-fluid"/>
    </div>
  </div>
</div>

<div class="d-block d-md-none">
  <div class="row p-md-4">
    <div class="col-md-12">
      <img src="{{ asset('images/comment1-mobile.jpg')}}" alt="" class="img-fluid"/>
    </div>
  </div>
  <hr>
  <div class="row p-md-4">
    <div class="col-md-12">
      <img src="{{ asset('images/comment2-mobile.jpg')}}" alt="" class="img-fluid"/>
    </div>
  </div>
</div>
</div>