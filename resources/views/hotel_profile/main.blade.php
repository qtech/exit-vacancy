@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h4 class="m-t-lg with-border">Hotel Profile</h4>
    <form id="myform" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
                <div class="col-lg-7" style="padding-left:32px;">
                    <fieldset class="form-group">
                        <label class="form-label semibold">Hotel Owner's Profile Image</label>
                        <input type="file" class="form-control" name="image" id="image" multiple>
                        <small class="text-muted">Change Hotel owner's profile picture.</small>
                    </fieldset>
                </div>
                <div class="col-lg-5" style="padding-left:100px; padding-top:5px;">
                    @if($getdetails['details']->image != NULL)
                        <img height="80" width="80" src="{{asset('/storage/uploads/'.$getdetails['details']->image)}}">
                    @endif
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Number</label>
                    <input type="text" class="form-control" name="number" id="number" value="{{$getdetails['details']->hotel->number}}">
                    <small class="text-muted">Update number for your Hotel. Please add your country code without '+' as prefix.</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Hotel Class</label>
                    <input type="number" class="form-control" name="hotelclass" id="hotelclass" value="{{$getdetails['details']->hotel->stars}}">
                    <small class="text-muted">Update class for your Hotel</small>
                </fieldset>
            </div>
        </div>
        @php    
            $split = explode(",", $getdetails['details']->hotel->amenities);
        @endphp
        <div class="form-group">
            <div class="col-md-12">
                <label class="form-label semibold" for="title">Select Amenities</label>
                <select class="select2" name="amenities[]" id="amenities" multiple="multiple">
                    @foreach($getdetails['amenities'] as $tmp)
                        <option
                        @if(in_array($tmp->amenity_name, $split))
                            selected
                        @endif
                        value="{{$tmp->amenity_name}}">{{$tmp->amenity_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Amenities</label>
                    @foreach($split as $value)
                        <label class="label label-secondary">{{$value}}</label>
                    @endforeach
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Rooms Available</label>
                        @if($getdetails['details']->hotel->king_room > 0)
                            <label class="label label-info">{{$getdetails['details']->hotel->king_room}} King Rooms</label>
                        @endif 
                        @if($getdetails['details']->hotel->queen_room > 0)
                            <label class="label label-warning">{{$getdetails['details']->hotel->queen_room}} Two-Queen Rooms</label>
                        @endif
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold">Upload Images</label>
                    <input type="file" class="form-control" name="images[]" id="images" multiple>
                    <small class="text-muted">Select multiple images for room by pressing "Ctrl" button</small>
                </fieldset>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <a href="{{route('hotelimages',['id' => Auth()->user()->user_id])}}" class="btn btn-custom pull-left">View Images</a>
                    <input onclick="editprofile(); event.preventDefault();" type="submit" class="btn btn-custom pull-right" value="Update">
                </fieldset>
            </div>
            </div>
        </div>
    </form>
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
                    notification('success',demo.msg);
                    setTimeout(function(){
                        window.location.href = '{{route("hotelprofile")}}';
                    },1500);
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('updatehotelprofile')}}", true);
        // ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection