@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="row">
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 1])}}">
                <section class="widget widget-simple-sm-fill">
                    <div class="{{Request::is('/1') ? 'blue' : 'grey'}}">
                        <div class="widget-simple-sm-fill-caption">Users with No Bookings</div>
                    </div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 2])}}">
                <section class="widget widget-simple-sm-fill">
                    <div class="{{Request::is('/2') ? 'blue' : 'grey'}}">
                        <div class="widget-simple-sm-fill-caption">Users with bookings this month</div>
                    </div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 3])}}">
                <section class="widget widget-simple-sm-fill">
                    <div class="{{Request::is('/3') ? 'blue' : 'grey'}}">
                        <div class="widget-simple-sm-fill-caption">Users with bookings more than 5</div>
                    </div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 4])}}">
                <section class="widget widget-simple-sm-fill">
                    <div class="{{Request::is('/4') ? 'blue' : 'grey'}}">
                        <div class="widget-simple-sm-fill-caption">Users registered this month</div>
                    </div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
    </div>
</header>
<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Number</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>User Status</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($users as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>
                        <a style="border-bottom:none !important;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname or $value->user->fname}} {{$value->lname or $value->user->lname}}</a>
                    </td>
                    <td>{{$value->email or $value->user->email}}</td>
                    <td>{{$value->customer->number}}</td>
                    <td>
                        @if($value->is_email_verify == 1 || @$value->user->is_email_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td>
                        @if($value->is_mobile_verify == 1 || @$value->user->is_mobile_verify == 1)
                            <label class="label label-success">Verified</label>
                        @else
                            <label class="label label-danger">Not Verified</label>
                        @endif
                    </td>
                    <td>
                        @if($value->user_status == 1 || @$value->user->user_status == 1)
                            <a href="{{route('disableuser',['id' => $value->user_id])}}"><label class="label label-success">Active</label></a>
                        @else
                            <a href="{{route('enableuser',['id' => $value->user_id])}}"><label class="label label-danger">In-Active</label></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection