@extends('layout.layout')

@section('content')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="page-content-wrapper">
            <div class="container">
                <div id="error" class="alert alert-danger alert-dismissible fade in" style="display:none">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div id="success" class="alert alert-success alert-dismissible fade in" style="display:none">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-primary" style="box-shadow:0px 0px 10px 4px #cccccc">
                            <div class="panel-body">
                                <h4 class="m-t-0 m-b-30">Add Notification</h4>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Title</label>
                                        <div class="col-md-10">
                                            <input name="title" id="title" type="text" class="form-control" placeholder="Notification Title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Description</label>
                                        <div class="col-md-10">
                                            <textarea name="message" id="message" style="resize:none" class="form-control" rows="5" placeholder="Notification Message"></textarea>
                                        </div>
                                    </div>
                                    <input onclick="addnotification(); event.preventDefault();" type="submit" class="btn btn-primary" value="Add">
                                    <a href="{{route('notifications')}}" class="btn btn-inverse" style="color:black; box-shadow:0px 0px 7px 0.3px grey;">Cancel</a>
                                </form>      
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                </div> <!-- End row -->
            </div><!-- container -->
        </div> <!-- Page content Wrapper -->
    </div> <!-- content -->
</div>
<script type="text/javascript">
    function addnotification(){
        var title = document.getElementById("title").value;
        var message = document.getElementById("message").value;
        var param = {
            "title":title,
            "message":message,
            "_token":'{{csrf_token()}}'
        }

        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                if(demo.status == 1)
                {
                    document.getElementById('success').style.display = "block";
                    document.getElementById('success').innerHTML = "<strong>"+demo.msg+"</strong>";
                    setTimeout(function(){
                        window.location.href = "{{route('notifications')}}";   
                    },1000);
                }
                else
                {
                    document.getElementById('error').style.display = "block";
                    document.getElementById('error').innerHTML = "<strong>"+demo.msg+"</strong>";
                    setTimeout(function(){
                        window.location.href = "{{route('addnotification')}}";
                    },1000);
                }
            }
        };
        ajx.open("POST", "{{route('storenotification')}}", true);
        ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(JSON.stringify(param));
    }
  </script>
@endsection