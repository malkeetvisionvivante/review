@extends('frontend.layouts.apps')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-small pl-0">
            <ul class="nav vertical-nav">
                <li class="nav-item">
                  <a class="nav-link"  href="{{ url('/my-profile')}}">My Profile</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active"  href="{{ url('/referal-detail')}}">Referal Detail</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/my-reviews')}}">My Reviews</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url('/change-password')}}">Change Password</a>
                </li>
              </ul>
            </div>
        </div>

        <div class="col-md-9 mb-5 mt-4 mt-md-0">
            <div class="card card-small">
              <div class="tab-content">
                  <div id="home" class="tab-pane active">
                      <ul class="nav nav-tabs">
                        <li class="active">
                          <a data-toggle="tab" href="#home1"><h3 class="font-weight-600">Referal Detail</h3></a>
                        </li>
                        <li>
                          <a data-toggle="tab" href="#home2"><h3 class="ml-5 font-weight-600">Referal Users</h3></a>
                        </li>
                        <li>
                          <a data-toggle="tab" href="#home3"><h3 class="ml-5 font-weight-600">Invitations</h3></a>
                        </li>
                      </ul>
                      <div class="tab-content">
                        <div id="home1" class="tab-pane active">
                          <div class="row mt-3">
                            <div class="col-md-12">
                              <h6 class="text-dark mb-2">Referal Link: 
                                <span class="text-muted">{{ $url }}</span>
                                <span class="copy-link" onclick="myFunction('{{ $url }}')"><i class="fas fa-copy ml-2"></i></span>
                                </h6>
                              <h6 class="text-dark mb-2">Number of Registerd Users through Referal: <span class="text-muted">{{ $numberOfRegisterUser }}</span></h6>
                              <h6 class="text-dark mb-2">Number of Visitors through Referal Link: <span class="text-muted">{{ $numberOfVisitors }}</span></h6>
                              <h6 class="text-dark mb-2">Number of sent invitations: <span class="text-muted">{{ $numberOfInvitations }}</span></h6>
                              <h6 class="text-dark mb-2">Number of Visitors through Referal Link: <span class="text-muted">{{ $numberOfVisitors }}</span></h6>
                            </div>
                          </div>
                        </div>
                        <div id="home2" class="tab-pane fade">
                             @if(count($referalUser))  
                                @foreach($referalUser as $user)  
                                  <div class="row mt-3">
                                     <div class="col-md-7">
                                         <div class="media">
                                              <div class="media-left">
                                                 <div class="media-img-container small-img-container p-0">
                                                   @if(!empty($user['profile']))
                                                     <a href="{{ url('manager-detail/'.$user['id'])}}"><img src="{{ asset('images/users/'.$user['profile'])}}" alt="profile" class="img-fluid" /></a>
                                                   @else
                                                     <a href="{{ url('manager-detail/'.$user['id'])}}"><img src="{{ asset('images/default/user.png')}}" alt="profile" class="img-fluid" /></a>
                                                   @endif  
                                                 </div>
                                             </div>
                                             <div class="media-body">
                                                <div class="d-flex justify-content-between">
                                                  <h3>
                                                      <a href="{{ url('manager-detail/'.$user['id'])}}">{{ $user['name']}} {{ $user['last_name']}} </a>
                                                  </h3>
                                                </div>
                                                {!! $user->getTitle1() !!}
                                             </div>   
                                         </div>
                                     </div>
                                     <div class="col-md-5 text-right"></div>
                                 </div>
                                 @if(!$loop->last)
                                 <hr>
                                 @endif
                                 <div class="mt-2"> 
                                 {{ $referalUser->links() }}
                                  </div>
                              @endforeach   
                              @else
                                <p style="margin-left: 5px;">No Reviews Found!!</p>
                              @endif     
                        </div>
                        <div id="home3" class="tab-pane fade">
                             
                          <div class="row">
                            <div class="col-md-12 mt-3">
                              <div class="table-responsive">
                                <table class="table custom-table table-striped">
                                  <tbody>
                                    <tr>
                                      <td><b>Send to</b></td>
                                      <td><b>Visit</b></td>
                                      <td><b>Register</b></td>
                                    </tr>
                                    @if(count($invitations))  
                                      @foreach($invitations as $invitation)  
                                        <tr>
                                          <td>{{ $invitation->receiver_email }}</td>
                                          <td>{{ $invitation->visit() }}</td>
                                          <td>{{ $invitation->isRegister() }}</td>
                                        </tr>
                                      @endforeach   
                                    @else
                                      <tr>
                                        <td colspan="3">No Result Found!!</td>
                                      </tr>
                                    @endif   
                                  </tbody>
                                </table>
                                <div class="mt-2"> 
                                 {{ $invitations->links() }}
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                     
                  </div>
              </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
function myFunction(val) {
  let selBox = document.createElement('textarea');
  selBox.style.position = 'fixed';
  selBox.style.left = '0';
  selBox.style.top = '0';
  selBox.style.opacity = '0';
  selBox.value = val;
  document.body.appendChild(selBox);
  selBox.focus();
  selBox.select();
  document.execCommand('copy');
  document.body.removeChild(selBox);
  toastr.success('Copyed successfully!');
}
</script>
<style type="text/css">
  span.copy-link { cursor: pointer; }
</style>
@endsection