<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Onhand;
use App\Models\Usage;
use App\Models\Ward;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Hospital;
use App\Models\Category;
use App\DataTables\ItemOrderListDT;
use Illuminate\Support\Facades\Input;
use App\Models\ItemTransaction;
use Carbon\Carbon;


class UsageController extends Controller
{
    public function index(){
        //$usages = Usage::whereDate('created_at','=',Carbon::now()->format('Y-m-d'))->get();
        $usages = Usage::whereDate('created_at','=','2016-02-22')->get();
        return view('usages.index', compact('usages'));
    }

    public function create(){
        $carts = \Cart::instance('usage')->content();

        return view('usages.create',compact('carts'));
    }

    public function newusage(ItemOrderListDT $dataTable){
        $nodes = Category::defaultOrder()->get()->linkNodes();

        $categories = [];
        foreach ($nodes as $node){
            $categories += [$node->id => $node->stringPath('&ensp;')];
        }
        $categories = ['' => 'All'] + $categories;

        $category_id = Input::get('cat');
        $dataTable->setCategoryId($category_id);

        $wards = Hospital::findOrFail(Auth::user()->hospital_id)->wards->lists('ward_name','id');

        return $dataTable->render('usages.newusage', compact(['wards','categories']));
    }

    public function store(Request $request){
        $carts = \Cart::instance('usage')->content();




        \DB::transaction(function () use($request, $carts){


            foreach($carts as $cart){
                $usage = Usage::create([
                    'item_code' => $cart->id,
                    'hospital_id' => Auth::user()->hospital_id,
                    'ward_id' => $cart->options->ward,
                    'quantity' => $cart->qty,
                    'taken_by' => $cart->options->takenBy,
                    'note' => $cart->options->note,
                    'taken_at' => $cart->options->takebAt
                ]);

                $itemOnhand = Onhand::where('item_code','=',$cart->id)
                                ->where('hospital_id','=',Auth::user()->hospital_id)->first();

                if($itemOnhand){
                    $itemOnhand->decrement('onhand', $cart->qty);
                }else{
                    Onhand::create([
                        'hospital_id' => Auth::user()->hospital_id,
                        'item_code' => $cart->id,
                        'onhand' => 0-$cart->qty
                    ]);
                }

                ItemTransaction::create([
                    'usage_id' => $usage->id,
                    'item_code' => $cart->id,
                    'transaction_type' => 'usage',
                    'note' => is_null($cart->note) ? '' : $cart->note,
                    'cost' => Item::where('item_code','=',$cart->id)->first()->cost,
                    'quantity' => $cart->qty,
                    'created_by' => Auth::user()->id,
                    'hospital_id' => Auth::user()->hospital_id
                ]);

            }

        });

        \Cart::destroy();

        return \Redirect::action('UsageController@index')->with('flash_message','Request Successfully Send! Please wait for the approval.');


    }
}
