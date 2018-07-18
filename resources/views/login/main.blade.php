<!DOCTYPE html>
<html>
<head>
        <title>{{config('app.name')}} Login</title>
        <link rel="shortcut icon" href="{{asset('logo.png')}}">

        <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet" type="text/css">

    </head>


    <body>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages" style="height:410px;">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        <a  class="logo logo-admin"><img src="logo.png" height="60" width="120" alt="logo"></a>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>Log In</b></h4>
                    @include('include.msg')
                    <div id="error" class="alert alert-danger alert-dismissible fade in" style="display:none">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div id="success" class="alert alert-success alert-dismissible fade in" style="display:none">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="form-horizontal m-t-20">

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" id="email" type="text" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40" style="position:relative">
                            <div class="col-xs-12">
                                <input id="button" class="btn btn-primary btn-block btn-lg" type="submit" onclick="checklogin(); event.preventDefault();" style="font-weight:700" value="Login">
                                    <div>
                                        <img id='loader' style="display:none;position:absolute;top:0px;left:45%;" class="gifloader" height="45px" width="45px" src='loader.gif'/>
                                    </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type="text/javascript">
          function checklogin() {
              var email = document.getElementById("email").value;
              var password = document.getElementById("password").value;
              var param = {
                  "email":email,
                  "password":password,
                  "_token":'{{csrf_token()}}'
              }
              document.getElementById("button").disabled = true;
              document.getElementById("button").value = "";
              document.getElementById("loader").style.display = "block";
              var ajx = new XMLHttpRequest();
              ajx.onreadystatechange = function () {
                  if (ajx.readyState == 4 && ajx.status == 200) {
                      var demo = JSON.parse(ajx.responseText);
                      if(demo.status == 1)
                      {
                        document.getElementById("loader").style.display = "none";
                        document.getElementById('success').style.display = "block";
                        document.getElementById('success').innerHTML = "<strong>"+demo.msg+"</strong>";
                        setTimeout(function(){
                            window.location.href = "{{route('dashboard')}}";
                        },1000);
                      }
                      else if(demo.status == 2)
                      {
                        document.getElementById("loader").style.display = "none";
                        document.getElementById('success').style.display = "block";
                        document.getElementById('success').innerHTML = "<strong>"+demo.msg+"</strong>";
                        setTimeout(function(){
                            window.location.href = "{{route('h.dashboard')}}";
                        },1000);
                      }
                      else
                      {
                        document.getElementById("loader").style.display = "none";   
                        document.getElementById('error').style.display = "block";
                        document.getElementById('error').innerHTML = "<strong>"+demo.msg+"</strong>";
                        setTimeout(function(){
                            window.location.href = "{{route('login')}}";
                        },1000);
                      }
                  }
              };
              ajx.open("POST", "{{route('checklogin')}}", true);
              ajx.setRequestHeader("Content-type", "application/json");
              ajx.send(JSON.stringify(param));
          }
        </script>

        <!-- jQuery  -->
        <script src="{{asset('/assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('/assets/js/bootstrap.min.j')}}s"></script>
        <script src="{{asset('/assets/js/modernizr.min.js')}}"></script>
        <script src="{{asset('/assets/js/detect.js')}}"></script>
        <script src="{{asset('/assets/js/fastclick.j')}}s"></script>
        <script src="{{asset('/assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('/assets/js/waves.js')}}"></script>
        <script src="{{asset('/assets/js/wow.min.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('/assets/js/jquery.scrollTo.min.js')}}"></script>

        <script src="{{asset('/assets/js/app.js')}}"></script>

    </body>
</html>