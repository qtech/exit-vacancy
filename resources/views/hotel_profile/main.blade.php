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
                                <h4 class="m-t-0 m-b-30">Hotel Profile</h4>
                                <form class="form-horizontal" id="myform" method="POST">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Number</label>
                                        <div class="col-md-10">
                                        <input name="number" id="number" type="number" class="form-control" value="{{$getdetails->hotel->number}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Base Price</label>
                                        <div class="col-md-10">
                                            <input name="price" id="price" type="number" class="form-control" value="{{$getdetails->hotel->price}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Class</label>
                                        <div class="col-md-10">
                                            <input name="hotelclass" id="hotelclass" type="number" class="form-control" value="{{$getdetails->hotel->stars}}">
                                        </div>
                                    </div>
                                    @php    
                                        $amenity = App\User::where(['user_id' => 1])->first();
                                        $words = explode(",",$amenity->lname);

                                        $split = explode(",", $getdetails->hotel->amenities);
                                    @endphp
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Select Amenities</label>
                                        <div class="col-md-10">
                                            <select name="amenities[]" id="amenities" class="selectpicker" multiple>
                                                @foreach($words as $tmp)
                                                    <option
                                                    @if(in_array($tmp, $split))
                                                        selected
                                                    @endif
                                                    value="{{$tmp}}">{{$tmp}}</option>
                                                @endforeach
                                            </select>                                                       
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Amenities</label>
                                        <div class="col-md-10" style="padding-top:5px;">
                                            @foreach($split as $value)
                                                <label class="label label-info">{{$value}}</label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Rooms Available</label>
                                        <div class="col-md-10" style="padding-top:5px;">
                                            @if($getdetails->hotel->king_room > 0)
                                            <label class="label label-success">{{$getdetails->hotel->king_room}} King Rooms</label>
                                            @endif 
                                            @if($getdetails->hotel->queen_room > 0)
                                            <label class="label label-warning">{{$getdetails->hotel->queen_room}} Two-Queen Rooms</label>
                                            @endif
                                        </div>
                                    </div>
                                    <br>
                                    <input onclick="editprofile(); event.preventDefault();" type="submit" class="btn btn-primary pull-right" value="Update">
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
    function editprofile(){
        var form = document.getElementById("myform");
        var formData = new FormData(form);
        formData.append('_token','{{csrf_token()}}');
        

        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                if(demo.status == 1)
                {
                    document.getElementById('success').style.display = "block";
                    document.getElementById('success').innerHTML = "<strong>"+demo.msg+"</strong>";
                }
                else
                {
                    document.getElementById('error').style.display = "block";
                    document.getElementById('error').innerHTML = "<strong>"+demo.msg+"</strong>";
                }
            }
        };
        ajx.open("POST", "{{route('updatehotelprofile')}}", true);
        // ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection