<?php

namespace App\DataTables\rooms;

use App\Models\Room;
use App\Models\RoomType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

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
        ->order(function($query){
               $query->orderBy('created_at', 'desc');
        })->addIndexColumn()
        ->addColumn('action', function ($room) {
            
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="'.$room->id.'" data-original-title="Edit" id="edit-room"
              class="edit-btn edit-room pr-4">
             <span class="fa fa-pen"></span></a>';
          
            $btn .= '<a href="javascript:void(0);" id="delete-room" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="'.$room->id.'" class="trash-btn pr-4"">
            <span class="fa fa-trash-alt" ></span></a>';

           $btn .= '<a href="javascript:void(0);" id="view-room" 
           data-toggle="tooltip" data-original-title="View"
            data-id="'.$room->id.'" class="text-info bolded">
           <i class="fa fa-eye" ></i></a>';

           return $btn;

        })->addColumn('checkbox', function ($room) {
              $checkBox = '<input type="checkbox" id="'.$room->id.'"/>';
             return $checkBox;
        })->addColumn('room_type', function ($room) {
            $room_type = RoomType::where('id', $room->room_type_id)->value('name');
            return $room_type;
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
            'room_type_id',
            'room_number',
            'floor_number',
            'description',
            'added_by'
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
            'room_type_id',
            'room_number',
            'floor_number',
            'description',
            'added_by'
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
