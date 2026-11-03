<?php

namespace App\DataTables\Member;

use App\Models\Klpdi;
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
            ->editColumn('kode_klpd', function ($row){
                $klpdi = Klpdi::where('kode_klpdi', $row->kode_klpd)->first();
                return $klpdi->nama_klpdi;
            })
            // ->addColumn('jenis_klpdi', function ($row){
            //     $klpdi = Klpdi::where('kode_klpdi', $row->kode_klpd)->first();
            //     return $klpdi->jenis_klpdi;
            // })
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
                        // Button::make('excel')
                        //     ->text('<i class="fas fa-file-excel"></i> Export to Excel') // Add icon and custom text
                        //     ->className('btn btn-success btn-sm'), // Apply specific Bootstrap classes
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("klpdi.jenis_klpdi:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control jenis_klpd\"><option value=\"\" class=\"fs-6\">Semua Jenis KLPDI</option></select>")
                            // .appendTo($(api.column(columnIdx).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdx)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                            select.append("<option value=\"KEMENTERIAN\">Kementerian</option>");
                            select.append("<option value=\"PROVINSI\">Provinsi</option>");
                            select.append("<option value=\"KABUPATEN\">Kabupaten</option>");
                            select.append("<option value=\"KOTA\">Kota</option>");
                            select.append("<option value=\"LEMBAGA\">Lembaga</option>");

                        // Get unique values and append as options
                        // api.column(columnIdx).data().unique().sort().each(function(d, j) {
                            // Remove HTML tags if present
                            // var text = d.replace(/(<([^>]+)>)/gi, "");
                            // if (select.find("option[value=\'" + text + "\']").length === 0) {
                            //     select.append("<option value=\"" + text + "\">" + text + "</option>");
                            // }

                        // });
                    }');
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
                  ->orderable(true)
                  ->hidden(),
            Column::make('nama_satker')
                  ->title('Nama Satker')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('kode_klpd')
                  ->title('KLPDI')
                  ->exportable(false)
                  ->searchable(true)
                  ->printable(false) 
                  ->orderable(true),
            Column::computed('klpdi.jenis_klpdi')
                ->name('klpdi.jenis_klpdi')
                ->exportable(false)
                ->searchable(true)
                ->orderable(true)
                ->printable(false)  
                ->title('Jenis KLPDI'),
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
