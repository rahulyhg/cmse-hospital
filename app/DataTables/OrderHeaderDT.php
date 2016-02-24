<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Services\DataTable;
use App\Models\OrderHeader;

class OrderHeaderDT extends DataTable
{
    // protected $printPreview  = 'path.to.print.preview.view';

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected $userid, $status;

    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())

            ->editColumn('status',function($data){
                $status = $data->getStatus();
                if($status == "cancelled")
                    return "Cancelled <a href='orders/".$data->id."/rerequest' class='btn btn-success btn-xs'>Re-request Now</a>";

                if($status == "pending")
                    return "Pending <a href='orders/".$data->id."/cancel' class='btn btn-success btn-xs'>Cancel Now</a>";

                if($status == "approved")
                    return "Approved";

                if($status == "delivering")
                    return "Delivering <a href='orders/".$data->id."' class='btn btn-success btn-xs'>Receive Now</a>";

                if($status == "received")
                    return "Received";
            })

            ->editColumn('approved_by.name',function($data){
                return $data->approvedBy ? $data->approvedBy->name : 'n/a';
            })

            ->editColumn('cancelled_by.name',function($data){
                return $data->cancelledBy ? $data->cancelledBy->name : 'n/a';
            })
            ->editColumn('created_at',function($data){
                return $data->created_at->format('d-m-Y');
            })
            ->editColumn('action',function($data){
                return "<a href='orders/".$data->id."'><button><i class='glyphicon glyphicon-eye-open'></i></button></a>

                ";
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
        //$users = OrderHeader::with(['orderedFrom','orderBy','approvedBy','cancelledBy'])->where('order_by','=',Auth::user()->id);
        $users = OrderHeader::with(['orderedFrom','orderBy','approvedBy','cancelledBy'])->where('ordered_from','=',Auth::user()->hospital_id)->select('*');

        return $this->applyScopes($users);
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
            ->parameters($this->getBuilderParameters())
            ->parameters([

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
            ['data'=>'id','title'=>'Order No.','searchable'=>true,'orderable'=>true],
            //['data'=>'order_by.name', 'name'=>'orderBy.name', 'title'=>'Order By','searchable'=>false,'orderable'=>false],
            //['data'=>'ordered_from.hospital_name', 'name'=>'orderedFrom.hospital_name', 'title'=>'Ordered From','searchable'=>true,'orderable'=>false],
            ['data'=>'status','title'=>'Status','searchable'=>false,'orderable'=>false],
            ['data'=>'approved_by.name', 'name'=>'approvedBy.name', 'title'=>'Approved By','searchable'=>true,'orderable'=>false],
            ['data'=>'cancelled_by.name','name'=>'cancelledBy.name', 'title'=>'Cancelled By','searchable'=>true,'orderable'=>false],
            ['data'=>'created_at','name'=>'created_at','title'=>'Requested At','searchable'=>false,'orderable'=>true],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'orders';
    }

    protected function compileRelationSearch($query, $relation, $column, $keyword)
    {
        $myQuery = clone $this->query;
        $myQuery->orWhereHas($relation, function ($q) use ($column, $keyword, $query) {
            $sql = $q->select($this->connection->raw('count(1)'))
                ->where($column, 'like', $keyword)
                ->toSql();
            $sql = "($sql) >= 1";
            $query->orWhereRaw($sql, [$keyword]);
        });
    }
}
