<?php

namespace App\DataTables\Admin;

use App\Models\Keuangan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KeuanganDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Keuangan> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('pemasukan', function($row){
                return 'Rp. ' . number_format($row->pemasukan);
            })
            ->editColumn('pengeluaran', function($row){
                return 'Rp. ' . number_format($row->pengeluaran);
            })
            ->editColumn('tanggal', function($row){
                return Carbon::parse($row->tanggal)->setTimezone('Asia/Jakarta')->translatedFormat('d/m/Y H:i:s');
            })
            ->rawColumns(['pemasukan','pengeluaran', 'tanggal'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Keuangan>
     */
    public function query(Keuangan $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('keuangan-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    // ->addAction()
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

                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("user.name:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control keuangan_member\"><option value=\"\" class=\"fs-6\">Semua Member</option></select>")
                            // .appendTo($(api.column(columnIdx).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdx)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        api.column(columnIdx).data().unique().sort().each(function(d, j) {
                            // Remove HTML tags if present
                            var text = d.replace(/(<([^>]+)>)/gi, "");
                            if (select.find("option[value=\'" + text + "\']").length === 0) {
                                select.append("<option value=\"" + text + "\">" + text + "</option>");
                            }
                        });
                    }');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->exportable(false)
                ->hidden(),
            Column::make('tanggal')
                ->title('Tanggal')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->wordwrap()
                ->addClass('text-center'),
            Column::make('user.name')
                ->title('Member')
                ->name('user.name')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->addClass('text-center'),
            Column::make('keterangan')
                ->title('Keterangan')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->addClass('text-center'),
            Column::make('pemasukan')
                ->title('Pemasukan')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->addClass('text-end'),
            Column::make('pengeluaran')
                ->title('Pengeluaran')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->addClass('text-end'),
            
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Keuangan_' . date('YmdHis');
    }
}
