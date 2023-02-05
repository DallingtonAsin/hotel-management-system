<?php

namespace App\DataTables\Accomodation;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\RoomStatus;

class RoomsDatatable extends DataTable
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
            ->addColumn('action', function ($room) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="' . $room->id . '" data-original-title="Edit" id="edit-room"
              class="px-3 py-1 border border-success rounded  edit-room mx-2">
             <span class="fa fa-pencil text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-room" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="' . $room->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2"">
            <span class="fa fa-trash" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-room" 
           data-toggle="tooltip" data-original-title="View"
            data-id="' . $room->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
           <i class="fa fa-eye" ></i></a>';

                return $btn;
            })->addColumn('checkbox', function ($room) {
                $checkBox = '<input type="checkbox" id="' . $room->id . '"/>';
                return $checkBox;
            })->addColumn('room_type', function ($room) {
                $room_type = RoomType::where('id', $room->type_id)->value('name');
                return $room_type;
            })->addColumn('room_status', function ($room) {
                $room_status = RoomStatus::where('id', $room->status_id)->value('name');
                return $room_status;
            })->editColumn('created_by', function ($room) {
                return Helper::getUserNames($room->created_by);
            })->rawColumns(['action', 'checkbox']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Room $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Room $model)
    {
        return $model->newQuery()->select(
            'id',
            'type_id',
            'number',
            'floor_number',
            'status_id',
            'description',
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
            ->setTableId('rooms/roomsdatatable-table')
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
            'type_id',
            'number',
            'floor_number',
            'status_id',
            'description',
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
        return 'rooms_' . date('YmdHis');
    }
}
