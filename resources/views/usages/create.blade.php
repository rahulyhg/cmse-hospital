@extends('layout.default')

@section('title')
    Confirm Usage @parent
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{!! action('UsageController@newusage') !!}">Usage Entry</a></li>
    <li>Confirm Usage</li>
@endsection

@section('content')
    <div class="well">
        <h1>Confirm Usage</h1>
        <hr>
        <label class="label label-primary">Usage List</label>
    <table class="table-striped table-bordered dataTable table-hover">
        <tr>
            <th>No. </th>
            <th>Item Code</th>
            <th>Name</th>
            <th>Quantity</th>
            <th>Ward</th>
            <th>Taken By</th>
            <th>Taken At</th>
        </tr>
        <?php $c=0 ?>
        @foreach($carts as $cart)
            <?php
                $c++;
                $ward = \App\Models\Ward::findOrFail($cart->options->ward);
            ?>
            <tr>
                <td>{!! $c !!}</td>
                <td>{!! $cart->id !!}</td>
                <td>{!! $cart->name !!}</td>
                <td>{!! $cart->qty !!}</td>
                <td>{!! $ward->ward_name !!}</td>
                <td>{!! $cart->options->takenBy !!}</td>
                <td>{!! $cart->options->takenAt !!}</td>
            </tr>
        @endforeach

    </table>
        <br />

        {!! Form::open(['route' => 'usages.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-send"> </i> Save Usage</button>
            <a href="{!! action('UsageController@newusage') !!}" class="btn btn-primary">Cancel</a>
        {!! Form::close() !!}
        </div>
        <br /><br />
    </div>

@endsection