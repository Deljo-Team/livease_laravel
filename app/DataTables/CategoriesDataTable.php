<?php

namespace App\DataTables;

use App\Models\Category;
use App\Models\Countries;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'countries.action')
            ->addColumn('action', function($row){

                // Update Button
                $updateButton = "<a class='btn btn-sm btn-info' data-id='".$row->id."' href='".route('category.edit',$row->id)."' ><span class='material-symbols-outlined'>edit</span></a>";

                // Delete Button
                $deleteButton = "<button class='btn btn-sm btn-danger delete-button' data-url='".route('category.destroy',$row->id)."' data-id='".$row->id."'><span class='material-symbols-outlined'>delete_forever</span></button>";

                return $updateButton." ".$deleteButton;

           }) 
            ->smart(true)
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('categories-table')
                    ->columns($this->getColumns())
                   
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    // ->selectStyleSingle()
                    ->buttons([
                        Button::make('add'),
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])->parameters([
                        'initComplete' => 'function() { runAll(); }',
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            
            Column::make('id'),
            Column::make('name'),
            Column::make('slug'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(120)
                //   ->render('\'<button class="btn btn-sm btn-primary">Edit</button>   <button class="btn btn-sm btn-danger">Delete</button>\'')
                  ->addClass('text-center'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Categories_' . date('YmdHis');
    }
}
