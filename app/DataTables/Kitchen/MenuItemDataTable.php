<?php

namespace App\DataTables\Kitchen;

use App\Models\KitchenMenuItem;
use App\Models\KitchenMenuItemCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class MenuItemDataTable extends DataTable
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
            ->addColumn('action', function ($menu_item) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
                        data-id="' . $menu_item->id . '" data-original-title="Edit" id="edit-menu-item"
                        class="px-3 py-1 border border-success rounded  edit-menu-item mx-2">
                        <span class="fa fa-pencil text-success"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-menu-item" 
                        data-toggle="tooltip" data-original-title="Delete"
                        data-id="' . $menu_item->id . '" class="px-3 py-1 border border-danger rounded trash-btn mx-2">
                        <span class="fa fa-trash" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-menu-item" 
                        data-toggle="tooltip" data-original-title="View"
                            data-id="' . $menu_item->id . '" class="px-3 py-1 border border-secondary rounded text-secondary bolded">
                        <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('category', function ($menu_item) {
            $category = KitchenMenuItemCategory::find($menu_item->category_id);
            return $category->name;
        })->addColumn('checkbox', function ($menu_item) {
            $checkBox = '<input type="checkbox" id="' . $menu_item->id . '"/>';
            return $checkBox;
        })->editColumn('price', function ($menu_item) {
            return number_format($menu_item->price);
        })->editColumn('created_by', function ($menu_item) {
            return Helper::getUserNames($menu_item->created_by);
        })->rawColumns(['checkbox', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\KitchenMenuItem $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(KitchenMenuItem $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('kitchen/menuitem-table')
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
            'description',
            'price',
            'category_id'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'kitchen_menu_items_' . date('YmdHis');
    }
}