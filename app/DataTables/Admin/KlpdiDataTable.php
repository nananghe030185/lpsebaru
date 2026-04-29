<?php

namespace App\DataTables\Admin;

use App\Models\Klpdi;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KlpdiDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Klpdi> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
           ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'edit'   => 'admin.klpdi.edit',
                    'data'   => $row
                ]);
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Klpdi>
     */
    public function query(Klpdi $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('klpdi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(0, 'asc')
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i> Export to Excel') // Add icon and custom text
                            ->className('btn btn-success btn-sm'), // Apply specific Bootstrap classes
                        'reload' => [
                            'text' => '<i class="fas fa-sync"></i> Reload KLPDI', // Button text with icon
                            'className' => 'btn btn-secondary btn-sm', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.klpdi.reload') . '";
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("jenis_klpdi:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control jenis_klpd\"><option value=\"\" class=\"fs-6 text-uppercase\">Semua Jenis KLPDI</option></select>")
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
                    }')
                    ->addAction([
                        'title' => 'Action',
                        'width' => '80px',
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
            Column::make('nama_klpdi')
                ->title('Nama KLPDI')
                ->searchable(true)
                ->orderable(true)
                ->width(50),
            Column::make('jenis_klpdi')
                ->title('Jenis KLPDI')
                ->name('jenis_klpdi')
                ->searchable(true)
                ->orderable(true)
                ->width(50),
            Column::make('kode_kabupaten')
                ->title('Kode Kab/Kota')
                ->searchable(true)
                ->orderable(true)
                ->width(50),
            Column::make('kode_klpdi')
                ->title('Kode KLPDI')
                ->searchable(true)
                ->orderable(true)
                ->width(50),
            Column::make('kode_provinsi')
                ->title('Kode Provinsi')
                ->searchable(true)
                ->orderable(true)
                ->width(50),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Klpdi_' . date('YmdHis');
    }
}
