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
                                <h4 class="m-t-0 m-b-30">Upload Images</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="m-b-30">
                                            <form action="#" class="dropzone">
                                                <div class="fallback">
                                                    <input name="file" type="file" multiple="multiple">
                                                </div>
                                            </form>
                                        </div>
                                        <br>
                                        <div class="m-t-15">
                                            <button type="button" class="btn btn-custom waves-effect waves-light">Add Images</button>
                                            <a href="{{route('h.s.room')}}" class="btn btn-secondary" style="color:black; box-shadow:0px 0px 7px 0.3px grey;">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection