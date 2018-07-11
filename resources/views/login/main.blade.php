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
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-body">
                    <h3 class="text-center m-t-0 m-b-15">
                        <a  class="logo logo-admin"><img src="logo.png" height="60" width="120" alt="logo"></a>
                    </h3>
                    <h4 class="text-muted text-center m-t-0"><b>Log In</b></h4>
                    @include('include.msg')
                    <div id="error" class="label label-danger" style="display:none">
                        <strong style="font-weight: 700; font-size: 24px;"></strong>
                    </div>
                    <div id="success" class="label label-info" style="display:none">
                        <strong style="font-weight: 700; font-size: 24px;"></strong>
                    </div>
                    <form class="form-horizontal m-t-20">

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="uname" id="uname" type="text" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" id="password" name="password" type="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40" style="position:relative">
                            <div class="col-xs-12">
                                <input id="button" class="btn btn-primary btn-block btn-lg" type="submit" onclick="checklogin(); event.preventDefault();" value="Login">
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
              var uname = document.getElementById("uname").value;
              var password = document.getElementById("password").value;
              var param = {
                  "uname":uname,
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
                          document.getElementById('success').style.display = "block";
                          document.getElementById('success').innerHTML = demo.msg;
                          setTimeout(function(){
                              window.location.href = "{{route('dashboard')}}";
                          },1000);
                      }
                      else
                      {   
                          document.getElementById('error').style.display = "block";
                          document.getElementById('error').innerHTML = demo.msg;
                          setTimeout(function(){
                              window.location.href = "{{route('login')}}";
                              document.getElementById("button").disabled = false;
                          },3000);
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