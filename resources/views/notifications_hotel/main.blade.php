@extends('layout.layout')

@section('content')
<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
                <h3 class="pull-left">Hotel Notifications</h3>
                <a href="{{route('h.addnotification')}}" class="btn btn-custom pull-right">Send Notification</a>
            </div>
        </div>
    </div>
</header>
<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Time</th>
                <th>Title</th>
                <th>Message</th>
                <th>Recipients</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($notification as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->created_at->format('d-m-y')}}</td>
                    <td>{{$value->created_at->format('H:i')}}</td>
                    <td>{{$value->title}}</td>
                    <td>{{$value->message}}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-custom" data-toggle="modal" data-target="#myModal{{$value->notification_id}}">View <i class="font-icon font-icon-eye"></i></button>
                    
                        <div class="modal fade" id="myModal{{$value->notification_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Recipients</h4>
                                    </div>
                                    <div class="modal-body">
                                        <table class="display table table-striped table-bordered recipients" cellspacing="0" width="100%">
                                            <thead>
                                                <th>Name</th>
                                                <th>Email</th>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $users = explode(',',$value->recipients);
                                                @endphp
                                                @if(!empty($users))
                                                    @foreach($users as $tmp)
                                                        @php
                                                            $user = App\User::where(['user_id' => $tmp])->first();
                                                        @endphp
                                                        <tr>
                                                            <td>{{$user->fname}} {{$user->lname}}</td>
                                                            <td>{{$user->email}}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div><!--.modal-->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<script>
    $(function() {
        $('.recipients').DataTable();
    });
</script>
@endsection