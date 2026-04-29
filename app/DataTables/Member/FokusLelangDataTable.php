<?php

namespace App\DataTables\Member;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\FokusLelang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class FokusLelangDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<FokusLelang> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'  => 'app.fokus-lelang.destroy',
                    'data'   => $row
                ]);
            })
            ->editColumn('lelang.pagu', function (FokusLelang $lelang) {
                return TableHelper::nominal_simple($lelang->lelang->pagu);
            })
            ->editColumn('lelang.nama_paket', function (FokusLelang $lelang) {
                return Helpers::link(
                    'https://sirup.lkpp.go.id/sirup/rup/detailPaketPenyedia2020?idPaket=' . $lelang->lelang->kode_rup,
                    Str::of($lelang->lelang->nama_paket)->limit(100)
                );
            })
            ->editColumn('lelang.is_pdn', function (FokusLelang $lelang) {
                return $lelang->is_pdn ? 'Produk Dalam Negeri' : 'Bukan Produk Dalam Negeri';
            })
            ->editColumn('lelang.is_umk', function (FokusLelang $lelang) {
                return $lelang->is_umk ? 'Usaha Kecil/Koperasi' : 'Bukan Usaha Kecil/Koperasi';
            })
            ->rawColumns(['checkbox','lelang.nama_paket','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<FokusLelang>
     */
    public function query(FokusLelang $model): QueryBuilder
    {
        return $model->newQuery()->where('user_id', Helpers::getCurrentUserId());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('fokuslelang-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i> ' . __('Export Excel'))
                            ->className('btn btn-success btn-sm')
                            ->exportOptions(['columns' => ':visible']),
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Bulk Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                var ids = [];
                                $("#fokuslelang-table tbody .row-checkbox:checked").each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    if (confirm("Are you sure you want to delete selected invoices?")) {
                                        $.ajax({
                                            url: "' . route('app.fokus-lelang.bulk-delete') . '",
                                            type: "POST",
                                            data: { 
                                                ids: ids,
                                                _token: "' . csrf_token() . '"
                                            },
                                            success: function(response) {
                                                dt.ajax.reload();
                                                toastr.warning("Selected invoices deleted successfully.");
                                            },
                                            error: function(xhr) {
                                                toastr.warning("Error deleting invoices: " + xhr.responseText);
                                            }
                                        });
                                    }
                                } else {
                                    toastr.warning("No invoices selected for deletion.");
                                }
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("lelang.jenis_pengadaan:name").index();
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

                        var columnIdm = api.column("lelang.metode:name").index();
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

                        $("#fokuslelang-table").on("change", "#select-all", function() {
                            $(".row-checkbox").prop("checked", this.checked);
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
                    ->hidden()
                    ->title(__('ID')),
            Column::computed('checkbox')
                    ->exportable(false)
                    ->printable(false)
                    ->width(10)
                    ->addClass('text-center')
                    ->title('<div class="form-check"><input class="form-check-input checkbox-primary" id="select-all" type="checkbox"></div>'),
            Column::make('lelang.nama_paket')
                    ->title(__('Nama Paket'))
                    ->orderable(true)
                    ->searchable(true),
            Column::make('lelang.pagu')
                    ->title(__('Pagu'))
                    ->orderable(true)
                    ->searchable(true),
             Column::make('lelang.jenis_pengadaan')
                    ->title('Jenis Pengadaan')
                    ->name('lelang.jenis_pengadaan')
                    ->searchable(true)
                    ->orderable(true),
            Column::make('lelang.is_pdn')
                    ->hidden()
                    ->title('Produk Dalam Negeri')
                    ->searchable(true)
                    ->orderable(true),
            Column::make('lelang.is_umk')
                    ->hidden()
                    ->title('Usaha Kecil/Koperasi')
                    ->searchable(true)
                    ->orderable(true),
            Column::make('lelang.metode')
                    ->title('Metode')
                    ->name('lelang.metode')
                    ->searchable(true)
                    ->orderable(true),
            Column::make('lelang.pemilihan')
                    ->title('Pemilihan')
                    ->searchable(true)
                    ->orderable(true),
            Column::make('lelang.klpdi')
                    ->title('KLPDI')
                    ->searchable(true)
                    ->orderable(true),
            Column::make('lelang.satuan_kerja')
                    ->title('Satuan Kerja')
                    ->searchable(true)
                    ->orderable(true),
            Column::make('lelang.lokasi')
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
        return 'FokusLelang_' . date('YmdHis');
    }
}
