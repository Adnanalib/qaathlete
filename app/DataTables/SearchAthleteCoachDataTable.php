<?php

namespace App\DataTables;

use App\Enums\UserType;
use App\Models\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SearchAthleteCoachDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query, Request $request)
    {
        return datatables()
            ->eloquent($query)
            ->order(function ($query)  use ($request) {
                if (request()->has('order')) {
                    $orders = $request->order;
                    if (count($orders[0]) > 0) {
                        foreach ($orders as $key => $order) {
                            $order['column'] = $order['column'] == 0 ? 'uuid' : $order['column'];
                            $order['column'] = $order['column'] == 1 ? 'first_name' : $order['column'];
                            $order['column'] = $order['column'] == 2 ? 'last_name' : $order['column'];
                            $order['column'] = $order['column'] == 3 ? 'type' : $order['column'];
                            $order['column'] = $order['column'] == 4 ? 'qr_image_url' : $order['column'];
                            $order['column'] = $order['column'] == 5 ? 'created_at' : $order['column'];
                            $order['column'] = $order['column'] == 6 ? 'uuid' : $order['column'];
                            if (!empty($order['dir'])) {
                                $query->orderBy($order['column'], $order['dir']);
                            }
                        }
                    }
                }
            })
            ->addColumn('qr', function ($query) {
                return '<img src="' . getQRImageSrc($query->qr_image_url) . '" alt="' . $query->qr_url . '" />';
            })
            ->addColumn('type', function ($query) {
                if($query->type == UserType::COACH){
                    return '<span class="badge badge-primary">COACH</span>';
                }else if($query->type == UserType::ATHLETE){
                    return '<span class="badge badge-info">ATHLETE</span>';
                }
                return '<span class="badge badge-secondary">-</span>';
            })
            ->addColumn('action', function ($query) {
                if($query->type == UserType::COACH){
                    return '-';
                }
                return '<a target="_blank" href="' . route('public-profile', ['uuid' => $query->uuid]) . '" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye" aria-hidden="true"></i> </a>';
            })
            ->addColumn('created_at', function ($query) {
                return Carbon::parse($query->created_at)->diffForHumans();
            })
            ->rawColumns(['created_at', 'type', 'qr', 'action', 'short_description', 'long_description']);
    }


    public function filterQuery($model, $request)
    {
        if (!empty($request->search)) {
            $model = $model->where(function ($w) use ($request) {
                $search = $request->search;
                $w->where('uuid', 'LIKE', "%$search%")
                    ->orwhere('full_name', 'LIKE', "%$search%");
            });
        }
        return $model;
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model, Request $request)
    {
        $model = $this->filterQuery($model, $request);
        $model = $model->newQuery();
        return $model;
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }
    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('uuid'),
            Column::make('first_name'),
            Column::make('last_name'),
            Column::make('type'),
            Column::make('qr'),
            Column::make('created_at'),
            Column::make('qr'),
            Column::make('action'),
        ];
    }
}
