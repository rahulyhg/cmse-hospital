<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemTransaction;
use App\Models\Onhand;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class ItemAdjustmentController extends Controller
{
    public function create($id){
        $item = Item::findOrFail($id);
        return view('items.adjustment', compact('item'));
    }

    public function store(Request $request){

        $this->validate($request,[
            'item_code' => 'required',
            'quantity' => 'required'
        ]);

        $item = Item::where('item_code', '=', $request->input('item_code'))->first();


        DB::transaction(function () use($request, $item) {


            $hospital_id = Auth::user()->hospital_id;
            $item_code = $request->input('item_code');
            $quantity = $request->input('quantity');
            $note = $request->input('note');
            $onhand = $item->onhand($hospital_id)->first();



            if($onhand){
                $onhand->increment('onhand',$quantity);
                $onhand->save();
            }else{
                Onhand::create([
                    'hospital_id' => $hospital_id,
                    'item_code' => $item_code,
                    'onhand' => $quantity
                ]);
            }


            ItemTransaction::create([
                'item_code' => $item_code,
                'transaction_type' => 'adjustment',
                'note' => $note,
                'cost' => $item->cost,
                'quantity' => $quantity,
                'created_by' => Auth::user()->id,
                'hospital_id' => $hospital_id
            ]);

        });



        return \Redirect::action('ItemAdjustmentController@create', ['id' => $item->id])->with('flash_message', 'Adjustment Success!');
    }
}
