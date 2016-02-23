@extends('layout.default')

@section('title')
    Items @parent
@endsection

@section('breadcrumb')
    @parent
    <li>Items</li>
@endsection

@section('content')

    <div class="well">
        <h1>Items</h1>

        <hr>
        <div class="form-group form-horizontal col-md-4">
            {!! Form::label('category','Filter Category: ',['class' => '']) !!}

            {!! Form::select('category', $categories , app('request')->input('cat') , ['class' => 'form-control']) !!}

        </div>
        {!! $dataTable->table() !!}

    </div>



@endsection

@section('footer_scripts')

    <link rel="stylesheet" href="/css/buttons.dataTables.min.css">
    <script src="/vendor/datatables/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}

    <script>
        $('#category').change(function(){
            window.location.href = '{!! url('/items') !!}' + '?cat=' + $(this).val();
        });
        $('#dataTableBuilder').DataTable().on('click', '.btn-delete[data-remote]', function (e) {

            e.preventDefault();
            var url = $(this).data('remote');
            confirmation = confirm("Are you sure you wan to delete item?");
            if(confirmation) {
                // confirm then
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE'},
                    headers: {
                        'X-CSRF-TOKEN': '{!! csrf_token() !!}'
                    }
                }).always(function (data) {
                    $('#dataTableBuilder').DataTable().draw(false);
                });
            }
        });
        $('#dataTableBuilder').addClass('table-striped table-bordered dataTable table-hover');
    </script>
@endsection