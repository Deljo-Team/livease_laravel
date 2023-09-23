<?php

namespace App\DataTables;

use App\Models\VendorApproval;
use App\Models\VendorCompany;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorListDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addColumn('action', function($row){

            // Update Button
            $approveButton = "<a class='btn btn-sm btn-success' href='/vendor/approval/view/".$row->id."' data-id='".$row->id."' ><span class='material-symbols-outlined'>visibility</span></a>";

            // Delete Button
            // $deleteButton = "<button class='btn btn-sm btn-danger delete-button' data-id='".$row->id."'><span class='material-symbols-outlined'>close</span></button>";

            return $approveButton;

       })->addColumn('row_number', function ($row) {
            static $row_number = 0;
            $page = request()->input('start', 1); // Default to page 1
            // Calculate the row number based on the current page and row index
            ++$row_number;
            $rowNumber = $page  + $row_number;
            return $rowNumber;
        })
        ->smart(true)            
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(VendorCompany $model): QueryBuilder
    {
        $model =  $model->select('id','email','phone')->whereNotNull('user_id')->with('user');
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('vendorlist-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    // ->selectStyleSingle();
                    ->buttons([
                        Button::make('excel'),
                        // Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        // Button::make('reset'),
                        Button::make('reload')
                    ])->parameters([
                        // 'drawCallback' => 'function() { test(); }',
                        'initComplete' => 'function() { runAll(); }',
                    ]);
                   
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('row_number')
            ->title('#')
            ->exportable(false)
            ->printable(false)
            ->width(20)
            ->addClass('text-center')
            ->orderable(false)
            ->searchable(false),            Column::make('email'),
            Column::make('phone'),
            Column::make('user.name'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(120)
            ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'VendorList_' . date('YmdHis');
    }
}
