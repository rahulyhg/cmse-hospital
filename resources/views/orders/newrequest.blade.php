@extends('layout.default')

@section('title')
    New Request @parent
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{!! action('OrderController@index') !!}">My Requests</a></li>
    <li>New Request</li>
@endsection

@section('content')

    <div class="well col-md-8">
        <h1>New Request</h1>
        <hr>

        <div class="form-group form-horizontal col-md-4">
            {!! Form::label('category','Filter Category: ',['class' => '']) !!}

            {!! Form::select('category', $categories , app('request')->input('cat') , ['class' => 'form-control']) !!}

        </div>
        {!! $dataTable->table() !!}

    </div>

    <div class="well col-md-4" id="cart">

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                {!! Form::open(['url' => 'cart/add', 'method' => 'post','class' => 'form-horizontal']) !!}
                <div class="modal-body">
                    {!! csrf_field() !!}

                    <fieldset>

                    <div class="form-group">
                        {!! Form::label('item_code', 'Item Code', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('item_code', 'Item_code', ['class' => 'form-control','id' => 'item_code', 'readOnly']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('quantity','Quantity: ',['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-10">
                            {!! Form::text('quantity', null, ['class' => 'form-control', 'id' => 'quantity']) !!}
                        </div>
                    </div>
                        </fieldset>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')

    <link rel="stylesheet" href="/css/buttons.dataTables.min.css">
    <script src="/vendor/datatables/dataTables.buttons.min.js"></script>
    <script src="/vendor/datatables/buttons.server-side.js"></script>
    {!! $dataTable->scripts() !!}

    <script>
        $(function () {
            $('#myModal').on('shown.bs.modal', function () {
                $('#quantity').focus()
            })

            $('#dataTableBuilder').DataTable().on('click', '.btn-add-cart[data-remote]', function (e) {
                var itemCode = $(this).data('remote');
                $('#item_code').val(itemCode);
            });

            $('#category').change(function () {
                window.location.href = '{!! url('orders/newrequest') !!}' + '?cat=' + $(this).val();
            });

            $('#dataTableBuilder').addClass('table-striped table-bordered dataTable table-hover');

            // LOAD CART =========================================
            $.get( '{!! action('CartController@show') !!}', function( data ) {
                $('#cart').html(data);
            });

        });
    </script>
@endsection