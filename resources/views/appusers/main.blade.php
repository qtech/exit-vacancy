@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="row">
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 1])}}">
                <section class="widget widget-simple-sm-fill grey">
                    <div class="widget-simple-sm-fill-caption">Users with No Bookings</div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 2])}}">
                <section class="widget widget-simple-sm-fill grey">
                    <div class="widget-simple-sm-fill-caption">Users with bookings this month</div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 3])}}">
                <section class="widget widget-simple-sm-fill grey">
                    <div class="widget-simple-sm-fill-caption">Users with bookings more than 5</div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
        <div class="col-sm-3">
            <a href="{{route('appusers',['id' => 4])}}">
                <section class="widget widget-simple-sm-fill grey">
                    <div class="widget-simple-sm-fill-caption">Users registered this month</div>
                </section><!--.widget-simple-sm-fill-->
            </a>
        </div>
    </div>
    @if(!empty($users))
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3>Total Users - {{count($users)}}</h3>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($b_thismonth))
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3>Users with Bookings in this month - {{count($b_thismonth)}}</h3>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($nobookings))
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3>Users with No Bookings - {{count($nobookings)}}</h3>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($fivebookings))
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3>Users with Bookings more than 5 - {{count($fivebookings)}}</h3>
                </div>
            </div>
        </div>
    @endif
    @if(!empty($r_thismonth))
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h3>Users with Registered this month - {{count($r_thismonth)}}</h3>
                </div>
            </div>
        </div>
    @endif
</header>
@if(!empty($users))
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
                            <a style="border-bottom:none !important;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname}} {{$value->lname}}</a>
                        </td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->customer->number}}</td>
                        <td>
                            @if($value->is_email_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->is_mobile_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->user_status == 1)
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
@endif
@if(!empty($b_thismonth))
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
                    @foreach($b_thismonth as $value)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                            <a style="border-bottom:none !important;" href="{{route('userbookings',['id' => $value->user->user_id])}}">{{$value->user->fname}} {{$value->user->lname}}</a>
                        </td>
                        <td>{{$value->user->email}}</td>
                        <td>{{$value->customer->number}}</td>
                        <td>
                            @if($value->user->is_email_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->user->is_mobile_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->user->user_status == 1)
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
@endif
@if(!empty($nobookings))
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
                    @foreach($nobookings as $value)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                            <a style="border-bottom:none !important;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname}} {{$value->lname}}</a>
                        </td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->customer->number}}</td>
                        <td>
                            @if($value->is_email_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->is_mobile_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->user_status == 1)
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
@endif
@if(!empty($fivebookings))
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
                    @foreach($fivebookings as $value)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                            <a style="border-bottom:none !important;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname}} {{$value->lname}}</a>
                        </td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->customer->number}}</td>
                        <td>
                            @if($value->is_email_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->is_mobile_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->user_status == 1)
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
@endif
@if(!empty($r_thismonth))
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
                    @foreach($r_thismonth as $value)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                            <a style="border-bottom:none !important;" href="{{route('userbookings',['id' => $value->user_id])}}">{{$value->fname}} {{$value->lname}}</a>
                        </td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->customer->number}}</td>
                        <td>
                            @if($value->is_email_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->is_mobile_verify == 1)
                                <label class="label label-success">Verified</label>
                            @else
                                <label class="label label-danger">Not Verified</label>
                            @endif
                        </td>
                        <td>
                            @if($value->user_status == 1)
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
@endif
@endsection