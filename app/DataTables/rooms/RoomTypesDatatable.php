<?php

namespace App\DataTables\rooms;

use App\Models\RoomType;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

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
        ->order(function($query){
               $query->orderBy('created_at', 'desc');
        })->addIndexColumn()
        ->addColumn('action', function ($roomType) {
            
            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
            data-id="'.$roomType->id.'" data-original-title="Edit" id="edit-room-type"
              class="edit-btn edit-room-type pr-4">
             <span class="fa fa-pen"></span></a>';
          
            $btn .= '<a href="javascript:void(0);" id="delete-room-type" 
            data-toggle="tooltip" data-original-title="Delete"
             data-id="'.$roomType->id.'" class="trash-btn pr-4"">
            <span class="fa fa-trash-alt" ></span></a>';

           $btn .= '<a href="javascript:void(0);" id="view-room-type" 
           data-toggle="tooltip" data-original-title="View"
            data-id="'.$roomType->id.'" class="text-info bolded">
           <i class="fa fa-eye" ></i></a>';

           return $btn;

        })->addColumn('checkbox', function ($roomType) {
              $checkBox = '<input type="checkbox" id="'.$roomType->id.'"/>';
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
        return 'RoomTypes_' . date('YmdHis');
    }
}
