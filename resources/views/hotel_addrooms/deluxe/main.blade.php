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
                                <h4 class="m-t-0 m-b-30">Deluxe Room details</h4>
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Amenities</label>
                                        <div class="col-md-10">
                                        <input name="amenities" id="amenities" type="text" class="form-control" value="{{$room->deluxe_room_amenity}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Price</label>
                                        <div class="col-md-10">
                                            <input name="price" id="price" type="number" class="form-control" value="{{$room->deluxe_room_price}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Rooms Available</label>
                                        <div class="col-md-10">
                                            <input name="rooms" id="rooms" type="number" class="form-control" value="{{$room->deluxe_room}}">
                                        </div>
                                    </div>
                                    <br>
                                    <a href="{{route('d.addimages')}}" class="btn btn-warning">Add Images</a>
                                    <input onclick="addnotification(); event.preventDefault();" type="submit" class="btn btn-primary pull-right" value="Update">
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
        var amenity = document.getElementById("amenities").value;
        var price = document.getElementById("price").value;
        var number = document.getElementById("rooms").value;
        var param = {
            "amenity":amenity,
            "price":price,
            "rooms":number,
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
                        window.location.href = "{{route('h.d.room')}}";   
                    },1000);
                }
                else
                {
                    document.getElementById('error').style.display = "block";
                    document.getElementById('error').innerHTML = "<strong>"+demo.msg+"</strong>";
                    setTimeout(function(){
                        window.location.href = "{{route('h.d.room')}}";
                    },1000);
                }
            }
        };
        ajx.open("PUT", "{{route('h.d.update')}}", true);
        ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(JSON.stringify(param));
    }
</script>
@endsection