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
                                            <input onclick="addamenity(); event.preventDefault();" type="submit" class="btn btn-success" value="Add">
                                        </div>
                                    </div>
                                </form>      
                            </div> <!-- panel-body -->
                        </div> <!-- panel -->
                    </div> <!-- col -->
                </div>

                <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-primary" style="box-shadow:0px 0px 10px 4px #cccccc">
                                <div class="panel-body">
                                    <h4 class="m-b-30 m-t-0">Available Amenities</h4>
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
    $(document).ready(function(){
        getdata();
    });

    function getdata(){
        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                document.getElementById("demo").innerHTML = "";
                demo.data.forEach(function(data){
                    document.getElementById("demo").innerHTML += 
                    `<div class="col-sm-3">
                        <div class="card text-center">
                            <div class="card-body" style="border:1px solid #00A599; margin-bottom: 15px; padding: 20px; font-weight:900; position:relative;">
                                ${data.amenity_name}
                            </div>
                        </div>
                        
                        <div>
                            <a href="#" data-toggle="modal" data-target="#custom-width-modal${data.amenity_id}" style="position:absolute; color:#00A599; font-size:1.2em; top:0px; right:10px; text-align:center" class="waves-effect">
                                <i class="mdi mdi-close"></i>
                            </a>

<div id="custom-width-modal${data.amenity_id}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none">
    <div class="modal-dialog" style="width:55%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Confirm Action</h4>
            </div>
            <div class="modal-body">
                <h4>Are you sure you want to delete this Amenity: <code>${data.amenity_name}</code> ?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                <a href="#" onclick="deleteamenity(${data.amenity_id});" class="btn btn-danger" data-dismiss="modal">Delete</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

                        </div>
                    </div>`
                });
            }
        };
        ajx.open("GET", "{{route('getamenities')}}", true);
        ajx.send();
    }

    function deleteamenity(id){
        var formdata = new FormData();
        formdata.append('id',id);
        formdata.append('_token','{{csrf_token()}}');
        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                if(demo.status == 1)
                {
                    getdata();
                    document.getElementById('success').style.display = "block";
                    document.getElementById('success').innerHTML = "<strong>"+demo.msg+"</strong>";
                    setTimeout(function(){
                        document.getElementById('success').style.display = "none";
                    },2000);
                }
                else
                {
                    document.getElementById('error').style.display = "block";
                    document.getElementById('error').innerHTML = "<strong>"+demo.msg+"</strong>";
                    setTimeout(function(){
                        document.getElementById('error').style.display = "none";
                    },2000);
                }
            }
        };

        ajx.open("POST", "{{route('deleteamenity')}}", true);
        ajx.send(formdata);
    }

    function addamenity(){
        var form = document.getElementById("myform");
        var formData = new FormData(form);
        formData.append('_token','{{csrf_token()}}');
        
        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                if(demo.status == 1)
                {
                    $('#amenities').tagsinput('removeAll');
                    getdata();
                    document.getElementById('success').style.display = "block";
                    document.getElementById('success').innerHTML = "<strong>"+demo.msg+"</strong>";
                    setTimeout(function(){
                        document.getElementById('success').style.display = "none";
                    },2000);
                }
                else
                {
                    document.getElementById('error').style.display = "block";
                    document.getElementById('error').innerHTML = "<strong>"+demo.msg+"</strong>";
                    setTimeout(function(){
                        document.getElementById('error').style.display = "none";
                    },2000);
                }
            }
        };
        ajx.open("POST", "{{route('addamenity')}}", true);
        // ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection