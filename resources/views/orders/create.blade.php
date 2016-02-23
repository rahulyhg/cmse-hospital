@extends('layout.default')

@section('title')
    Confirm Request @parent
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{!! action('OrderController@index') !!}">My Requests</a></li>
    <li>Confirm Request</li>
@endsection

@section('content')
    <div class="well">
        <h1>Confirm Request</h1>
        <hr>
        <label class="label label-primary">Request List</label>
    <table class="table-striped table-bordered dataTable table-hover">
        <tr>
            <th>No. </th>
            <th>Item Code</th>
            <th>Name</th>
            <th>Quantity</th>
        </tr>
        <?php $c=0 ?>
        @foreach($carts as $cart)
            <?php $c++ ?>
            <tr>
                <td>{!! $c !!}</td>
                <td>{!! $cart->id !!}</td>
                <td>{!! $cart->name !!}</td>
                <td>{!! $cart->qty !!}</td>
            </tr>
        @endforeach

    </table>
        <br />

        {!! Form::open(['route' => 'orders.store', 'method' => 'post', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
        {!! Form::label('note', 'Notes / Instructions: ', ['class' => 'control-label']) !!}
        {!! Form::textarea('note', '', ['class' => 'form-control']) !!}
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"> <i class="glyphicon glyphicon-send"> </i> Confirm Request</button>
        {!! Form::close() !!}
        </div>
        <br /><br />
    </div>

@endsection