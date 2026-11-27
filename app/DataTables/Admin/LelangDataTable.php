<?php

namespace App\DataTables\Admin;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\Lelang;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
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
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('updated_at', function (Lelang $lelang) {
                return TableHelper::tanggal($lelang->updated_at);
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'fokusLelang'  => 'admin.lelang-sirup.fokus',
                    'data'   => $row,
                    'isfokusLelang' => Helpers::isUserFokusLelang($row)
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
            ->rawColumns(['checkbox','nama_paket'])
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
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                var selectedIds = [];
                                $(".row-checkbox:checked").each(function() {
                                    selectedIds.push($(this).val());
                                });

                                if (selectedIds.length === 0) {
                                    Swal.fire({
                                        icon : "error",
                                        title : "Tidak ada data yang dipilih",
                                        confirmButtonText : "Batal"
                                    });
                                    return
                                }

                                Swal.fire({
                                    icon : "warning",
                                    title : "Anda yakin ingin menghapus data yang dipilih ?",
                                    showCancelButton : true,
                                    confirmButtonText : "Hapus",
                                    cancelButtonText : "Batal",
                                    cancelButtonColor : "#d33",
                                }).then((result) => {
                                    if(result.isConfirmed){
                                        $.ajax({
                                            url: "' . route('admin.lelang-sirup.bulk-delete') . '",
                                            type: "POST",
                                            data: {
                                                ids: selectedIds,
                                                _token: "' . csrf_token() . '"
                                            },
                                            success: function(response) {
                                                dt.ajax.reload(); // Reload the DataTable
                                                Swal.fire({
                                                    toast : true,
                                                    position : "top-end",
                                                    icon : "success",
                                                    text : response.message,
                                                    showConfirmButton : false,
                                                    timer : 3000,
                                                    timerProgressBar : true
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                Swal.fire({
                                                    toast : true,
                                                    position : "top-end",
                                                    icon : "error",
                                                    text : xhr.responseJSON?.message ?? "Terjadi kesalahan saat menghapus data",
                                                    showConfirmButton : false,
                                                    timer : 2000,
                                                    timerProgressBar : true
                                                });
                                            }
                                        });
                                    }
                                });
                            }',
                        ],
                    ])
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
                        select1.append("<option value=\"Jasa Konsultansi\">Jasa Konsultansi</option>");
                        select1.append("<option value=\"Barang\">Barang</option>");
                        select1.append("<option value=\"Pekerjaan Konstruksi\">Pekerjaan Konstruksi</option>");
                        select1.append("<option value=\"Jasa Lainnya\">Jasa Lainnya</option>");

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
                        select2.append("<option value=\"Seleksi\">Seleksi</option>");
                        select2.append("<option value=\"Penunjukan Langsung\">Penunjukan Langsung</option>");
                        select2.append("<option value=\"Tender\">Tender</option>");
                        select2.append("<option value=\"Tender Cepat\">Tender Cepat</option>");
                        select2.append("<option value=\"Dikecualikan\">Dikecualikan</option>");
                        select2.append("<option value=\"Pengadaan Langsung\">Pengadaan Langsung</option>");
                        select2.append("<option value=\"E-Purchasing\">E-Purchasing</option>");

                        $("#select-all").on("click", function() {
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
                ->hidden(),
            Column::computed('checkbox')
                ->title('<div class="form-check"><input class="form-check-input checkbox-primary" id="select-all" type="checkbox"></div>')
                ->footer('<div class="form-check"><input class="form-check-input checkbox-primary" id="select-all-footer" type="checkbox"></div>')
                ->exportable(false)
                ->printable(false)
                ->width(10)
                ->addClass('text-center'),
            Column::make('updated_at')
                  ->title('Tanggal Diperbarui')
                  ->orderable(true),
            Column::make('kode_rup')
                ->title('Kode RUP')
                ->searchable(true)
                ->orderable(true),
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
