<?php

namespace App\DataTables\Admin;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\Lelang;
use App\View\Components\Table;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class LelangDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Lelang> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'fokus'  => 'admin.lelang-sirup.fokus',
                    'data'   => $row
                ]);
            })
            ->addColumn('nama_paket', function (Lelang $lelang) {
                return Helpers::link(route('redirect.lelang',[$lelang->slug]) ,
                    Str::of($lelang->nama_paket)->limit(100)
                );
            })
            ->editColumn('pagu', function (Lelang $lelang) {
                return TableHelper::nominal_simple($lelang->pagu);
            })
            ->editColumn('is_pdn', function (Lelang $lelang) {
                return $lelang->is_pdn ? 'Produk Dalam Negeri' : 'Bukan Produk Dalam Negeri';
            })
            ->editColumn('is_umk', function (Lelang $lelang) {
                return $lelang->is_umk ? 'Usaha Kecil/Koperasi' : 'Bukan Usaha Kecil/Koperasi';
            })
            ->rawColumns(['nama_paket'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Lelang>
     */
    public function query(Lelang $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('lelang-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("jenis_pengadaan:name").index();
                        var select1 = $("<select name=\"filter\" id=\"filter\" class=\"form-control jenis_pengadaan\"><option value=\"\">Semua Jenis Pengadaan</option></select>")
                            // .appendTo($(api.column(columnIdx).header()).empty())
                            .appendTo(".filter1")
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
                            if (select1.find("option[value=\'" + text + "\']").length === 0) {
                                select1.append("<option value=\"" + text + "\">" + text + "</option>");
                            }
                        });

                        var columnIdm = api.column("metode:name").index();
                        var select2 = $("<select name=\"filter2\" id=\"filter2\" class=\"form-control jenis_metode\"><option value=\"\">Semua Jenis Metode</option></select>")
                            // .appendTo($(api.column(columnIdm).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdm)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        api.column(columnIdm).data().unique().sort().each(function(d, j) {
                            // Remove HTML tags if present
                            var text = d.replace(/(<([^>]+)>)/gi, "");
                            if (select2.find("option[value=\'" + text + "\']").length === 0) {
                                select2.append("<option value=\"" + text + "\">" + text + "</option>");
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
                ->hidden(),
            Column::make('nama_paket')
                ->title('Nama Paket')
                ->searchable(true)
                ->orderable(true),
            Column::make('pagu')
                ->title('Pagu')
                ->searchable(true)
                ->orderable(true),
            Column::make('jenis_pengadaan')
                ->title('Jenis Pengadaan')
                ->name('jenis_pengadaan')
                ->searchable(true)
                ->orderable(true),
            Column::make('is_pdn')
                ->hidden()
                ->title('Produk Dalam Negeri')
                ->searchable(true)
                ->orderable(true),
            Column::make('is_umk')
                ->hidden()
                ->title('Usaha Kecil/Koperasi')
                ->searchable(true)
                ->orderable(true),
            Column::make('metode')
                // ->hidden()
                ->title('Metode')
                ->name('metode')
                ->searchable(true)
                ->orderable(true),
            Column::make('pemilihan')
                ->hidden()
                ->title('Pemilihan')
                ->searchable(true)
                ->orderable(true),
            Column::make('klpdi')
                // ->hidden()
                ->title('KLPDI')
                ->searchable(true)
                ->orderable(true),
            Column::make('satuan_kerja')
                ->title('Satuan Kerja')
                ->searchable(true)
                ->orderable(true),
            Column::make('lokasi')
                ->title('Lokasi')
                ->searchable(true)
                ->orderable(true),
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
        return 'Lelang_' . date('YmdHis');
    }
}
