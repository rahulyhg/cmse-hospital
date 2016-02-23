@extends('layout.default')

@section('title')
   View Request @parent
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{!! url('orders') !!}">All My Request</a></li>
    <li>View Request {!! $order->id !!}</li>
@endsection

@section('content')
    <div class="well">
        <h1>View Request #{!! $order->id !!} <label class="label label-info">{!! $order->getStatus() !!}</label></h1>
        <hr>
        <div class="row">
            <div class="col-md-2 text-align-right">Request No. :</div>
            <div class="col-md-10">
                {!! $order->id !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 text-align-right">Requested By :</div>
            <div class="col-md-10">
                {!! $order->orderBy->name !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 text-align-right">Requested From :</div>
            <div class="col-md-10">
                {!! $order->orderedFrom->hospital_name !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 text-align-right">Status :</div>
            <div class="col-md-10">
                {!! $order->getStatus() !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-align-right">Approved By :</div>
            <div class="col-md-10">
                {!! $order->approvedBy ? $order->approvedBy->name : 'n/a'  !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 text-align-right">Cacelled By :</div>
            <div class="col-md-10">
                {!! $order->cancelledBy ? $order->cancelledBy->name : 'n/a' !!}
            </div>
        </div>

        <table class="table dataTable table-bordered table-striped table-hover">
            <tr>
                <th>No.</th>
                <th>Item Code</th>
                <th>Quantity</th>
            </tr>
            <?php $c=0 ?>
            @foreach($order->items as $item)
                <?php $c++ ?>
                <tr>
                    <td>{!! $c !!}</td>
                    <td>{!! $item->item_code !!}</td>
                    <td>{!! $item->quantity !!}</td>
                </tr>
            @endforeach
        </table>
        <p class="note">* Status will be mark as received when the order is set to received at the destination</p>

        <div class="form-actions">
            @if($order->getStatus() == 'approved' || $order->getStatus() == "delivering")
                <a href="{!! action('OrderController@receive',['id' => $order->id]) !!}" class="btn btn-primary">Receive Now</a>
            @endif

            @if($order->getStatus() == 'cancelled')
                <a href="{!! action('OrderController@rerequest',['id' => $order->id]) !!}" class="btn btn-primary">Re-request Now</a>
            @endif



            @if($order->getStatus() == 'pending')
                <a href="{!! action('OrderController@cancel',['id' => $order->id]) !!}" class="btn btn-primary">Cancel Now</a>
            @endif






        </div>


    </div>







@endsection

@section('footer_scripts')

@endsection