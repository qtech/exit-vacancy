@extends('layout.layout')

@section('content')
<div class="box-typical" style="padding-left:25px;">
    <h4 class="m-t-lg with-border">King Room Details</h4>
    @php    
        $split = explode(",", $room->king_room_amenity);
    @endphp
    <form id="myform" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="col-md-12">
                <label class="form-label semibold" for="title">Select Amenities</label>
                <select class="select2" name="amenities[]" id="amenities" multiple="multiple">
                        <option
                        @if(in_array('Breakfast', $split))
                            selected
                        @endif
                        value="Breakfast">Breakfast</option>

                        <option
                        @if(in_array('Lunch', $split))
                            selected
                        @endif
                        value="Lunch">Lunch</option>

                        <option
                        @if(in_array('Dinner', $split))
                            selected
                        @endif
                        value="Dinner">Dinner</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Room Amenities</label>
                        @foreach($split as $value)
                            <label class="label label-info">{{$value}}</label>
                        @endforeach
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Price</label>
                    <input type="number" class="form-control" name="price" id="price" value="{{$room->king_room_price}}">
                    <small class="text-muted">Update price of this room</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <label class="form-label semibold" for="title">Rooms Available</label>
                    <input type="number" class="form-control" name="rooms" id="rooms" value="{{$room->king_room}}">
                    <small class="text-muted">Update number of rooms available</small>
                </fieldset>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-7" style="padding-left:30px;">
                    <fieldset class="form-group">
                        <label class="form-label semibold">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <small class="text-muted">Add Image of your room</small>
                    </fieldset>
                </div>
                <div class="col-lg-5">
                    <img style="position:relative; left:100px; box-shadow:0px 0px 5px 3px #00857b" height="100" width="200" src="{{asset('/storage/uploads/'.$room->king_room_image)}}">
                </div>
            </div>
        </div>
        <br>
        <div class="form-group">
            <div class="col-lg-12">
                <fieldset class="form-group">
                    <a href="#" class="btn btn-custom pull-left">View Images</a>
                    <input onclick="updateroom(); event.preventDefault();" type="submit" class="btn btn-custom pull-right" value="Update">
                </fieldset>
            </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function updateroom(){
        var form = document.getElementById("myform");
        var formData = new FormData(form);
        formData.append('image',image.files[0]);
        formData.append('_token','{{csrf_token()}}');

        var ajx = new XMLHttpRequest();
        ajx.onreadystatechange = function () {
            if (ajx.readyState == 4 && ajx.status == 200) {
                var demo = JSON.parse(ajx.responseText);
                if(demo.status == 1)
                {
                    notification('success',demo.msg);
                    setTimeout(function(){
                        window.location.href = "{{route('h.s.room')}}";   
                    },1000);
                }
                else
                {
                    notification('danger',demo.msg);
                }
            }
        };
        ajx.open("POST", "{{route('h.s.update')}}", true);
        //ajx.setRequestHeader("Content-type", "application/json");
        ajx.send(formData);
    }
</script>
@endsection