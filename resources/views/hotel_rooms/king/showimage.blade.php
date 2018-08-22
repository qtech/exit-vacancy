@extends('layout.layout')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="page-content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <h4 class="m-t-lg with-border">King Room Images <a href="{{route('h.s.room')}}" style="color:white;" class="btn btn-sm btn-custom pull-right">Back</a></h4>
                                <div class="row">
                                    @foreach(json_decode($images->king_room_image) as $image)
                                    <div class="col-sm-3" style="padding-top:25px;">
                                        <img height="115" width="230" style="box-shadow:0px 0px 5px 2px #00857b"src="{{asset('/storage/uploads/'.$image)}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection