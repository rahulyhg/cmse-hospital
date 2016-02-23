@extends('layout.default')

@section('title')
    Item Profile @parent
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{!! url('items') !!}">Items</a></li>
    <li>Item Profile - {!! $item->name !!}</li>
@endsection
@section('content')
    <div class="well">
        <h1><strong>{!! $item->name !!}</strong> <small>Item Profile</small></h1>
        <hr>
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <td class="col-md-2">Item Code: </td><td>{!! $item->item_code !!}</td>
            </tr>
            <tr>
                <td>Unit: </td><td>{!! $item->unit !!}</td>
            </tr>
            <tr>
                <td>Name: </td><td>{!! $item->name !!}</td>
            </tr>
            <tr>
                <td>Category: </td><td>{!! $item->category->name !!}</td>
            </tr>
            <tr>
                <td>Barcode: </td><td>{!! $item->barcode !!}</td>
            </tr>
            <tr>
                <td>Description: </td><td>{!! $item->description !!}</td>
            </tr>
            <tr>
                <td>Item Cost: </td><td>{!! $item->cost !!}</td>
            </tr>
            <tr>
                <td>GST Code: </td><td>{!! $item->gst_code !!}</td>
            </tr>
            <tr>
                <td>Created At: </td><td>{!! $item->created_at !!}</td>
            </tr>
            <tr>
                <td colspan="2"><div class="divider"></div></td>
            </tr>
            <tr>
                <td>On Hand Quantity: </td><td>{!! $item->getOnHand() !!}</td>
            </tr>
        </table>





        <div class="form-actions">
            <a href="{!! URL::action('ItemAdjustmentController@create',['id'=>$item->id]) !!}"><button class="btn btn-danger">Adjustment</button></a>

        </div>
    </div>
@endsection


