@extends('layout.layout')

@section('content')
{{-- <div class="content-page">
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
</div> --}}

<div class="box-typical" style="padding-left:25px;">
    <h5 class="m-t-lg with-border">Add Notification</h5>
    <form>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                    <small class="text-muted">Please give a title to your notification</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="message">Description</label>
                    <textarea rows="4" name="message" id="message" class="form-control" placeholder="Textarea"></textarea>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <input onclick="addnotification(); event.preventDefault();" type="submit" class="btn btn-primary" value="Add">
                <a href="{{route('notifications')}}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
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
                    notification('success',demo.msg);
                    setTimeout(function(){
                        window.location.href = '{{route("notifications")}}';
                    },1500);
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('storenotification')}}", true);
        ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(JSON.stringify(param));
    }
</script>
@endsection