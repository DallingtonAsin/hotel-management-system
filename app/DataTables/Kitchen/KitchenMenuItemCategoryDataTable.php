<?php

namespace App\DataTables\Kitchen;

use App\Models\KitchenMenuItemCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use App\Helpers\Helper;

class KitchenMenuItemCategoryDataTable extends DataTable
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
            ->addColumn('action', function ($menu_item_cat) {

                $btn = '<a href="javascript:void(0)" data-toggle="tooltip" 
                    data-id="' . $menu_item_cat->id . '" data-original-title="Edit" id="edit-menu-item-cat"
                    class="edit-btn edit-menu-item-cat pr-4">
                    <span class="fa fa-pen"></span></a>';

                $btn .= '<a href="javascript:void(0);" id="delete-menu-item-cat" 
                    data-toggle="tooltip" data-original-title="Delete"
                    data-id="' . $menu_item_cat->id . '" class="trash-btn pr-4"">
                    <span class="fa fa-trash-alt" ></span></a>';

                $btn .= '<a href="javascript:void(0);" id="view-menu-item-cat" 
                    data-toggle="tooltip" data-original-title="View"
                        data-id="' . $menu_item_cat->id . '" class="text-info bolded">
                    <i class="fa fa-eye" ></i></a>';

                return $btn;

            })->addColumn('checkbox', function ($menu_item_cat) {
            $checkBox = '<input type="checkbox" id="' . $menu_item_cat->id . '"/>';
            return $checkBox;
        })->editColumn('created_by', function ($menu_item_cat) {
            return Helper::getUserNames($menu_item_cat->created_by);
        })->rawColumns(['checkbox', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\KitchenMenuItemCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(KitchenMenuItemCategory $model)
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
            ->setTableId('kitchenmenuitemcategory-table')
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
            'name'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'KitchenMenuItemCategories_' . date('YmdHis');
    }
}