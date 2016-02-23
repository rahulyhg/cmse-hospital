@extends('layout.default')

@section('title')
   Usages @parent
@endsection

@section('breadcrumb')
    @parent
    <li>Usages</li>
@endsection

@section('content')
    <div class="well">
        <h1>Usages Today {!! \Carbon\Carbon::now()->format('d/m/Y') !!}</h1>
        <hr>
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Ward</th>
                <th>Taken By</th>
                <th>Time Taken</th>
                <th>Note</th>
            </tr>
            @foreach($usages as $usage)
                <tr>
                    <td>{!! $usage->item_code !!}<br />{!! $usage->item->name !!}</td>
                    <td>{!! $usage->quantity !!}</td>
                    <td>{!! $usage->ward->ward_name !!}</td>
                    <td>{!! $usage->taken_by !!}</td>
                    <td>{!! \Carbon\Carbon::parse($usage->taken_at)->format('d/m/Y')  !!}</td>
                    <td>{!! $usage->note !!}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection

@section('footer_scripts')

@endsection