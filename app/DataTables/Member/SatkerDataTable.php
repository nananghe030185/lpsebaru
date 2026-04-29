<?php

namespace App\DataTables\Member;

use App\Models\Satker;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SatkerDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Satker> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            
            ->rawColumns(['action','lelang'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Satker>
     */
    public function query(Satker $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('satker-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i> Export to Excel') // Add icon and custom text
                            ->className('btn btn-success btn-sm'), // Apply specific Bootstrap classes
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
            Column::make('kode_satker')
                  ->title('Kode Satker')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('nama_satker')
                  ->title('Nama Satker')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('kode_klpd')
                  ->title('KLPDI')
                  ->searchable(true)
                  ->orderable(true),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Satker_' . date('YmdHis');
    }
}
