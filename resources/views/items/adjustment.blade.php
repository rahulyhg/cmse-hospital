@extends('layout.default')

@section('title')
    Item Adjustment @parent
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{!! action('ItemController@index') !!}">Items</a></li>
    <li>Item Adjustment</li>
@endsection

@section('content')
    <div class="well">
        <h1>Item Adjustment</h1>
        <hr>
        {!! Form::open(['route' => 'items.adjustment', 'method' => 'post', 'class' => 'form-horizontal']) !!}
        <fieldset>
            <div class="form-group">
                {!! Form::label('item_code', 'Item code', ['class' => 'control-label col-md-2']) !!}
                <div class="col-md-4">
                {!! Form::text('item_code', $item->item_code, ['class' => 'form-control', 'readOnly']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('name', 'Name', ['class' => 'control-label col-md-2']) !!}
                <div class="col-md-6">
                    {!! Form::text('name', $item->name, ['class' => 'form-control', 'readOnly']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('description', 'Description', ['class' => 'control-label col-md-2']) !!}
                <div class="col-md-10">
                    {!! Form::text('description', $item->description, ['class' => 'form-control', 'readOnly']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('unit', 'Unit', ['class' => 'control-label col-md-2']) !!}
                <div class="col-md-10">
                    {!! Form::text('unit', $item->unit, ['class' => 'form-control', 'readOnly']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('category', 'Category', ['class' => 'control-label col-md-2']) !!}
                <div class="col-md-10">
                    {!! Form::text('category', $item->category->name, ['class' => 'form-control', 'readOnly']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('onhand', 'Onhand', ['class' => 'control-label col-md-2']) !!}
                <div class="col-md-10">
                    {!! Form::text('onhand', ($item->onhand(Auth::user()->hospital_id)->first()) ? $item->onhand(Auth::user()->hospital_id)->first()->onhand : 0, ['class' => 'form-control', 'readOnly']) !!}
                </div>
            </div>


        </fieldset>
        <hr class="simple">
        <fieldset>

            <div class="form-group">




                {!! Form::label('qty', 'Quantity to adjust ', ['class' => 'control-label col-md-2']) !!}
                    <div class="col-md-4">
                    {!! Form::text('quantity', '', ['class' => 'form-control','placeholder' => '1 or -1']) !!}
                    </div><p class="note">* put negative for quantity substraction (eg. -80)</p>



            </div>
            <br />
        <div class="form-group">
        {!! Form::textarea('note', '', ['class' => 'form-control', 'placeholder' => 'write your notes of adjustment here or leave it blank']) !!}
        </div>
        </fieldset>
        <div class="form-actions">
        <button class="btn btn-primary" type="submit">Adjust</button>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
