@extends('layout.layout');

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
                                <h4 class="m-t-0 m-b-30">Common Hotel Amenities</h4>
                                <form class="form-horizontal" id="myform" method="POST">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Add Amenities</label>
                                        <div class="col-md-10">
                                            <input name="amenities[]" id="amenities" data-role="tagsinput" type="text">
                                        </div>
                                    </div>
                                    <br><br>
                                    <input onclick="addamenity(); event.preventDefault();" type="submit" class="btn btn-primary" value="Submit">
                                </form>      
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                </div>

                <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary">
                                <div class="panel-body">
                                    <h4 class="m-b-30 m-t-0">Amenities</h4>
                                    <div class="row">
                                        <div id="demo">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div><!-- container -->
        </div> <!-- Page content Wrapper -->
    </div> <!-- content -->
</div>

<script type="text/javascript">
    function addamenity(){
        var form = document.getElementById("myform");
        var formData = new FormData(form);
        formData.append('_token','{{csrf_token()}}');
        
        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                demo.data.forEach(function(data){
                    document.getElementById("demo").innerHTML += '<button class="btn btn-lg btn-primary">' +data.amenity_name+'</button>&nbsp;&nbsp;&nbsp;&nbsp;';
                });
                if(demo.status == 1)
                {
                    document.getElementById('success').style.display = "block";
                    document.getElementById('success').innerHTML = "<strong>"+demo.msg+"</strong>";
                    // setTimeout(function(){
                    //     window.location.href = "{{route('amenity')}}";   
                    // },1000);
                }
                else
                {
                    document.getElementById('error').style.display = "block";
                    document.getElementById('error').innerHTML = "<strong>"+demo.msg+"</strong>";
                    // setTimeout(function(){
                    //     window.location.href = "{{route('amenity')}}";
                    // },1000);
                }
            }
        };
        ajx.open("POST", "{{route('addamenity')}}", true);
        // ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection