<?php

namespace App\DataTables\Accomodation;

use App\Models\RoomType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class RoomTypesDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->order(function ($query) {
                $query->orderBy('created_at', 'desc');
            })->addIndexColumn()
            ->addColumn('action', function ($roomType) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="' . $roomType->id . '" data-original-title="Edit" id="edit-room-type"
              class="px-3 py-1 border border-success rounded  edit-room-type mx-2">
             <span class="fa fa-pen text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-room-type" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="' . $roomType->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
            <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-room-type" 
           data-toggle="tooltip" data-original-title="View"
            data-id="' . $roomType->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
           <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->editColumn('single_occupancy_rate', function ($roomType) {
            $s_rate = number_format($roomType->single_occupancy_rate);
            return $s_rate;
        })->editColumn('double_occupancy_rate', function ($roomType) {
            $d_rate = number_format($roomType->double_occupancy_rate);
            return $d_rate;
        })->editColumn('created_by', function ($roomType) {
            return Helper::getUserNames($roomType->created_by);
        })->addColumn('checkbox', function ($roomType) {
            $checkBox = '<input type="checkbox" id="' . $roomType->id . '"/>';
            return $checkBox;
        })->rawColumns(['action', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RoomType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RoomType $model)
    {
        return $model->newQuery()->select(
            'id',
            'name',
            'single_occupancy_rate',
            'double_occupancy_rate',
            'created_by'
        );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('rooms/roomtype')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
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
            'id',
            'name',
            'single_occupancy_rate',
            'double_occupancy_rate',
            'created_by'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'RoomTypes_' . date('YmdHis');
    }
}