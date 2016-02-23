@extends('layout.default')

@section('title')
   All Request @parent
@endsection

@section('breadcrumb')
    @parent
    <li>All Request</li>
@endsection

@section('content')
    <div class="well">
        <h1>Requests</h1>
        <hr>
        {!! $dataTable->table() !!}
    </div>
@endsection

@section('footer_scripts')

    <link rel="stylesheet" href="/css/buttons.dataTables.min.css">
    <script src="/vendor/datatables/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}

@endsection