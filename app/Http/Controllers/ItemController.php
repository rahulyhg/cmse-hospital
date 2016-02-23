<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\DataTables\ItemDT;
use Illuminate\Support\Facades\Input;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(ItemDT $dataTable){

        $nodes = Category::defaultOrder()->get()->linkNodes();

        $categories = [];
        foreach ($nodes as $node){
            $categories += [$node->id => $node->stringPath('&ensp;')];
        }
        $categories = ['' => 'All'] + $categories;

        $category_id = Input::get('cat');
        $dataTable->setCategoryId($category_id);

        return $dataTable->render('items.index',compact('categories'));
    }

    public function show($id){
        $item = Item::with('onhand')->findOrFail($id);

        return view('items.show',compact('item'));
    }


}
