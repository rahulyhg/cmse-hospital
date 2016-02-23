<?php

namespace App\DataTables;

use App\Models\Item;
use Yajra\Datatables\Services\DataTable;
use App\Models\Category;

class ItemDT extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';
    protected $category_id;

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setCategoryId($id){
        $this->category_id = $id;
    }

    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', function ($item) {
                return '<a href="items/'.$item->id.'"><button><i class="glyphicon glyphicon-eye-open"></i></button></a>';
            })
            ->editColumn('category',function($item){
                return $item->category->name;
            })
            ->editColumn('onhands.onhand',function($item){
                return $item->getOnHand();
            })
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        if($this->category_id != ""){
            $category = Category::findOrFail($this->category_id);
            $categories = $category->descendants()->lists('id');
            $categories[] = $category->getKey();

            $items = Item::with(['category','onhand'])->whereIn('category_id',$categories)->select('*');
        }else{
            $items = Item::query();
        }



        return $this->applyScopes($items);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->ajax('')
            ->addAction(['width' => '100px'])
            ->parameters([
                'dom' => '<"row" <"col-md-6" l><"col-md-6" f>>rtip',


            ]);
    }



    /**
     * Get columns.
     *
     * @return array
     */
    private function getColumns()
    {
        return [
            'item_code',
            'unit',
            'name',
            //'barcode',
            'description',
            ['data'=>'category','name'=>'category','title'=>'Category','searchable'=>false,'orderable'=>false],
            ['data'=>'onhands.onhand','name'=>'onhand.onhand','title'=>'Qty On Hand','searchable'=>false,'orderable'=>false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users';
    }
}
