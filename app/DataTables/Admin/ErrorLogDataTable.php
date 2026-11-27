<?php

namespace App\DataTables\Admin;

use App\Models\ErrorLog;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ErrorLogDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<ErrorLog> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
             ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'    => 'admin.errorlog.destroy',
                    'data'      => $row
                ]);
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d/m/Y H:i:s');
            })
            ->rawColumns(['action','checkbox'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<ErrorLog>
     */
    public function query(ErrorLog $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('errorlog-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([])
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
                                            url: "' . route('admin.errorlog.bulk-delete') . '",
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
                        $("#errorlog-table").on("change", "#select-all", function() {
                            $(".row-checkbox").prop("checked", this.checked);
                        });
                       
                    }')
                    ->addAction(['width' => 60, 'className' => 'text-center']);
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
            Column::make('created_at')
                ->title('Waktu')
                ->searchable(false),
            Column::make('message')
                ->title('Pesan'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ErrorLog_' . date('YmdHis');
    }
}
