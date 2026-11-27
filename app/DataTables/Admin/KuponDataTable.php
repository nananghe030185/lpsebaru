<?php

namespace App\DataTables\Admin;

use App\Models\Kupon;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class KuponDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Kupon> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('masa_berlaku', function($row){
                return Carbon::parse($row->masa_berlaku)->format('d-m-Y');
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'    => 'admin.kupon.destroy',
                    'edit'    => 'admin.kupon.edit',
                    'data'      => $row
                ]);
            })
            ->editColumn('status', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'status',
                    'route' => 'admin.kupon.status',
                    'value' => $row->status,
                ]);
            })
            ->rawColumns([ 'action','checkbox','status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Kupon>
     */
    public function query(Kupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kupon-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        'Add' => [
                            'text' => '<i class="fa fa-plus"></i> Tambah Kupon', // Button text with optional icon
                            'className' => 'btn btn-primary', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.kupon.create') . '";
                            }',
                        ],
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
                                            url: "' . route('admin.kupon.bulk-delete') . '",
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
                        $("#select-all").on("change", function() {
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
                ->exportable(false)
                ->printable(false)
                ->width(10)
                ->addClass('text-center')
                ->title('<div class="form-check"><input class="form-check-input checkbox-primary" id="select-all" type="checkbox"></div>')
                ->orderable(false)
                ->searchable(false),
            Column::make('status')
                ->title('Status')
                ->width(100),
            Column::make('kode')
                ->title('Kode')
                ->width(100),
            Column::make('diskon')
                ->title('Diskon (%)')
                ->width(100),
            Column::make('stok')
                ->title('Stok Kuota')
                ->width(100),
            Column::make('masa_berlaku')
                ->title('Masa Berlaku')
                ->width(100),
            Column::make('keterangan')
                ->title('Keterangan'),
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
        return 'Kupon_' . date('YmdHis');
    }
}
