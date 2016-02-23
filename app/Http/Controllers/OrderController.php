<?php

namespace App\Http\Controllers;

use App\DataTables\ItemOrderListDT;
use App\DataTables\OrderHeaderDT;
use App\Models\Item;
use App\Models\OrderDetail;
use App\Models\OrderHeader;
use App\Models\ItemTransaction;
use App\Models\Onhand;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class OrderController extends Controller
{
    public function index(OrderHeaderDT $dataTable){
        return $dataTable->render('orders.index', compact('request'));
    }

    public function newrequest(ItemOrderListDT $dataTable){
        $nodes = Category::defaultOrder()->get()->linkNodes();

        $categories = [];
        foreach ($nodes as $node){
            $categories += [$node->id => $node->stringPath('&ensp;')];
        }
        $categories = ['' => 'All'] + $categories;

        $category_id = Input::get('cat');
        $dataTable->setCategoryId($category_id);

        return $dataTable->render('orders.newrequest',compact('categories'));
    }

    public function create(Request $request){
        $carts = Cart::content();


        return view('orders.create',compact('carts'));
    }

    public function show($id){
        $order = OrderHeader::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function receive($id){
        $request = OrderHeader::findOrFail($id);



        DB::transaction(function() use($request){
            $request->delivered_at = Carbon::now();
            $request->delivering_at = Carbon::now();
            $request->save();

            $items = $request->items;
            foreach($items as $item){
                $onhand = Onhand::where('item_code','=',$item->item_code)
                            ->where('hospital_id','=',Auth::user()->hospital_id)->first();

                if($onhand){
                    $onhand->increment('onhand',$item->quantity);
                    $onhand->save();
                }else{
                    Onhand::create([
                        'hospital_id' => Auth::user()->hospital_id,
                        'item_code' => $item->item_code,
                        'onhand' => $item->quantity
                    ]);
                }

                ItemTransaction::create([
                    'item_code' => $item->item_code,
                    'transaction_type' => 'received',
                    'note' => '',
                    'cost' => $item->cost,
                    'quantity' => $item->quantity,
                    'created_by' => Auth::user()->id,
                    'hospital_id' => Auth::user()->hospital_id,
                    'order_no' => $request->id
                ]);
            }


        });

        return \Redirect::action('OrderController@index')->with('flash_message', 'Request received, item quantity updated!');


    }

    public function cancel($id){
        $order = OrderHeader::findOrFail($id);
        $order->cancelled_by = Auth::user()->id;
        $order->cancelled_at = Carbon::now();
        if($order->save()) {
            return \Redirect::action('OrderController@show', ['id' => $order->id])->with('flash_message', 'Request is cancelled!');
        }else {
            return \Redirect::action('OrderController@show', ['id' => $order->id])->with('flash_message', 'Error!');
        }
    }

    public function rerequest($id){
        $order = OrderHeader::findOrFail($id);
        $order->cancelled_by = null;
        $order->approved_by = null;
        $order->delivered_at = "0000-00-00 00:00:00";
        $order->delivering_at = "0000-00-00 00:00:00";
        $order->approved_at = "0000-00-00 00:00:00";
        $order->cancelled_at = "0000-00-00 00:00:00";
        if($order->save()) {
            return \Redirect::action('OrderController@show', ['id' => $order->id])->with('flash_message', 'Re-requesting success!');
        }else {
            return \Redirect::action('OrderController@show', ['id' => $order->id])->with('flash_message', 'Error!');
        }
    }

    public function store(Request $request){
        $carts = Cart::content();
        $orderHeader = new OrderHeader;

        \DB::transaction(function () use($request, $carts, $orderHeader){

            $orderHeader->order_by = Auth::user()->id;
            $orderHeader->ordered_from = Auth::user()->hospital_id;
            $orderHeader->notes = $request->input('note');
            $orderHeader->save();

            foreach($carts as $cart){
                OrderDetail::create([
                    'order_id' => $orderHeader->id,
                    'item_code' => $cart->id,
                    'quantity' => $cart->qty,
                    'cost' => $cart->price
                ]);
            }

        });

        Cart::destroy();

        return \Redirect::action('OrderController@show',['id' => $orderHeader->id])->with('flash_message','Request Successfully Send! Please wait for the approval.');




    }
}
