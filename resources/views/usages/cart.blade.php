<div style="font-size: 2em;text-align:center;font-weight:bold;">Usage List</div>
<br />
<?php $carts=\Cart::instance('usage')->content() ?>
<table class="table table-striped table-bordered table-advance table-hover">
    <tr>
        <th>Item</th>
        <th style="width:50px;">Qty</th>
        <th style="width:20px;"></th>
    </tr>
    @foreach($carts as $cart)

    <tr>
        <td>
            <p><strong>#{!! $cart->id !!}</strong> <br /> <span class="note">{!! $cart->name !!}</span></p>
        </td>
        <td>{!! $cart->qty !!}</td>
        <td><a href="{!! url('cart/removeusage/'.$cart->rowid) !!}"><i class="del-cart-item-btn glyphicon glyphicon-remove-sign" style="cursor:pointer;" item="{!! $cart->rowid !!}" itemName="{!! $cart->name !!}"></i></a></td>

    </tr>


    @endforeach
</table>
<div style="text-align:center">
    <a id="payBtn" href="{!! action('UsageController@create') !!}" class="btn btn-success">
        <i class="glyphicon glyphicon-save"></i>
        Save Usage List
    </a>
</div>


<script>




</script>
