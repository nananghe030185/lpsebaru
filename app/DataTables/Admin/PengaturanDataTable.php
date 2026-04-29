<?php

namespace App\DataTables\Admin;

use App\Models\Pengaturan;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PengaturanDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Pengaturan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'edit'  => 'admin.applikasi.edit',
                    'data'   => $row
                ]);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Pengaturan>
     */
    public function query(Pengaturan $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pengaturan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(2)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                         Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i> Export to Excel') // Add icon and custom text
                            ->className('btn btn-rounded btn-pill btn-outline-primary'),
                        Button::make('pdf')
                            ->text('<i class="fas fa-file-pdf"></i> Export to PDF')
                            ->className('btn btn-primary btn-sm'),
                        Button::make('print')
                            ->text('<i class="fas fa-print"></i> Print')
                            ->className('btn btn-warning btn-sm'),
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            
            Column::make('id')
                ->hidden(),
            Column::make('order')
                ->title('#'),
            Column::make('key')
                ->title('Key'),
            Column::make('value')
                ->title('Value'),
            Column::make('description')
                ->title('Description'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pengaturan_' . date('YmdHis');
    }
}
