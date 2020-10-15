<!doctype html>
<html lang="en">

<head>
    <title>Silmarilli | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- bootstrap-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <!-- custom css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css')}}">
    <!-- fontawsome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>

<body style="background-color:#fafafa;">

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5 mt-5">
            <a href="{{ url('/')}}" class="mb-3 d-block"><i class="fas fa-chevron-left"></i> Back</a>
            <div class="card shadow-sm">
                <img src="{{ asset('images/silmarilli.svg')}}" class="img-fluid logo mb-4" alt="silmarilli">
                <h5 class="mb-3">User Login</h5>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name=""/>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name=""/>
                </div>
                <div class="form-group row mx-0">
                    <div class="custom-control custom-checkbox col-7">
                        <input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
                        <label class="custom-control-label text-muted" for="customCheck">Remember me</label>
                      </div>
                      <div class="col-5 pr-0 text-right">
                          <a href="#" class="text-muted">Forgot Password</a>
                      </div>
                </div>
                <div><button type="submit" class="btn btn-success round-shape">Login</button></div>
            </div>
        </div>
    </div>
</div>

<!--footer end-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>