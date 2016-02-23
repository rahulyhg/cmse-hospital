<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function add(Request $request){
        $this->validate($request,[
            'quantity' => 'required|numeric|min:1',
        ]);

        $item = Item::where('item_code', '=', $request->input('item_code'))->first();

        Cart::add($request->input('item_code'),$item->name,$request->input('quantity'),$item->cost);

        return redirect()->back();

    }

    public function show()
    {
        return view('orders.cart');
    }

    public function remove($id, Request $request)
    {
        Cart::remove($id);
        return redirect()->back();
    }

    public function addusage(Request $request){
        $this->validate($request,[
            'quantity' => 'required|numeric|min:1',
        ]);

        $item = Item::where('item_code', '=', $request->input('item_code'))->first();

        Cart::instance('usage')->add($request->input('item_code'),$item->name,$request->input('quantity'),$item->cost,
            [
                'ward' => $request->input('ward'),
                'note' => $request->input('note'),
                'takenBy' => $request->input('takenBy'),
                'takenAt' => $request->input('takenAt'),
            ]);

        return redirect()->back();

    }

    public function showusage()
    {
        return view('usages.cart');
    }

    public function removeusage($id, Request $request)
    {
        Cart::instance('usage')->remove($id);
        return redirect()->back();
    }

}
