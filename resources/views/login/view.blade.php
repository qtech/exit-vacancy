<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ExitVacancy Login</title>

    <script src="{{asset('/n-asset/js/lib/jquery/jquery-3.2.1.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/n-asset/css/separate/pages/login.min.css')}}">
    <link rel="stylesheet" href="{{asset('/n-asset/css/lib/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/n-asset/css/lib/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/n-asset/css/main.css')}}">
</head>
<body>

    <div class="page-center">
        <div class="page-center-in">
            <div class="container-fluid">
                @include('include.msg')
                <form class="sign-box">
                    <header class="sign-title"><strong>ExitVacancy Login</strong></header>
                    <div class="form-group">
                        <input type="text" name="email" id="email" class="form-control" placeholder="E-Mail"/>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                    <input id="button" class="btn btn-rounded btn-success sign-up" type="submit" onclick="checklogin(); event.preventDefault();" value="Login">
                    <!--<button type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                </form>
            </div>
        </div>
    </div><!--.page-center-->

    <script type="text/javascript">
        function checklogin() {
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var param = {
                "email":email,
                "password":password,
                "_token":'{{csrf_token()}}'
            }
            
            var ajx = new XMLHttpRequest();
            ajx.onreadystatechange = function () {
                if (ajx.readyState == 4 && ajx.status == 200) {
                    var demo = JSON.parse(ajx.responseText);
                    if(demo.status == 1)
                    {
                        notification('success',demo.msg);
                        setTimeout(function(){
                            window.location.href = "{{route('dashboard')}}";
                        },1000);
                    }
                    else if(demo.status == 2)
                    {
                        notification('success',demo.msg);
                        setTimeout(function(){
                            window.location.href = "{{route('h.dashboard')}}";
                        },1000);
                    }
                    else
                    {
                        notification('danger',demo.msg);
                    }
                }
            };
            ajx.open("POST", "{{route('checklogin')}}", true);
            ajx.setRequestHeader("Content-type", "application/json");
            ajx.send(JSON.stringify(param));
        }
      </script>

<script src="{{asset('/n-asset/js/lib/popper/popper.min.js')}}"></script>
<script src="{{asset('/n-asset/js/lib/tether/tether.min.js')}}"></script>
<script src="{{asset('/n-asset/js/lib/bootstrap/bootstrap.min.js')}}"></script>
<script src="{{asset('/n-asset/js/plugins.js')}}"></script>

{{-- BOOTSTRAP NOTIFY --}}
<script src="{{asset('/n-asset/js/lib/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('/n-asset/js/lib/bootstrap-notify/bootstrap-notify-init.js')}}"></script>

    <script type="text/javascript" src="{{asset('/n-asset/js/lib/match-height/jquery.matchHeight.min.js')}}"></script>
    <script>
        $(function() {
            $('.page-center').matchHeight({
                target: $('html')
            });

            $(window).resize(function(){
                setTimeout(function(){
                    $('.page-center').matchHeight({ remove: true });
                    $('.page-center').matchHeight({
                        target: $('html')
                    });
                },100);
            });
        });
    </script>
<script src="{{asset('/n-asset/js/app.js')}}"></script>
</body>
</html>