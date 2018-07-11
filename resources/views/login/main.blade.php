<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{config('app.name')}} Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendors/iconfonts/puse-icons-feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/vendors/css/vendor.bundle.addons.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('/assets/images/favicon.png')}}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
                    <h2 class="text-center mb-4">Login</h2>
                    <br>
                    <div id="error" class="alert alert-danger" style="display:none">
                        <strong style="font-weight: 700; font-size: 16px;"><i class="fas fa-exclamation-triangle"></i></strong>
                    </div>
                    <div id="success" class="alert alert-success" style="display:none">
                        <strong style="font-weight: 700; font-size: 16px;"><i class="fas fa-check"></i></strong>
                    </div>
              <form>
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="uname" placeholder="Username">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i id="tick1" class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password" placeholder="*********">
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i id="tick2" class="mdi mdi-check-circle-outline"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group" style="position:relative">
                  <input id="button" class="btn btn-primary submit-btn btn-block" onclick="checklogin(); event.preventDefault()" value="Login">
                    <div>
                        <img id='loader' style="display:none;position:absolute;top:0px;left:43%;" class="gifloader" height="45px" width="45px" src='loader.gif'/>
                    </div>
                </div>
              </form>
            </div>
            <br>
        <p class="footer-text text-center">Copyright © 2018 {{config('app.name')}}. All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
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
                    document.getElementById('tick1').style.color = "green";
                    document.getElementById('tick2').style.color = "green";
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
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{asset('/assets/vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('/assets/vendors/js/vendor.bundle.addons.js')}}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{asset('/assets/js/off-canvas.js')}}"></script>
  <script src="{{asset('/assets/js/hoverable-collapse.j')}}s"></script>
  <script src="{{asset('/assets/js/misc.js')}}"></script>
  <script src="{{asset('/assets/js/settings.js')}}"></script>
  <script src="{{asset('/assets/js/todolist.js')}}"></script>
  <!-- endinject -->
</body>

</html>