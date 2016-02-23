@extends('layout.default')

@section('title')
    Welcome Page @parent
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome to <strong>{!! \Auth::user()->hospital->hospital_name !!}</strong> Operation System</div>

                <div class="panel-body">
                    <h1>This is hospital <strong class="txt-color-green">{!! \Auth::user()->hospital->hospital_name !!}</strong>, if you are at the wrong hospital, please logout now and contact HQ to reassign you to the correct hospital to prevent wrong data entry into wrong hospital.</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
