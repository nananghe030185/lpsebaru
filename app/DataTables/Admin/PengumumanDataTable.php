<?php

namespace App\DataTables\Admin;

use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PengumumanDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Pengumuman> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'pengumuman.action')
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('expire', function ($row) {
                return Carbon::parse($row->expire)->setTimezone('Asia/Jakarta')->translatedFormat('d/m/Y H:i:s');
            })
            ->editColumn('status', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'status',
                    'route' => 'admin.pengumuman.status',
                    'value' => $row->status,
                ]);
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'   => 'admin.pengumuman.destroy',
                    'edit'  => 'admin.pengumuman.edit',
                    'data'   => $row
                ]);
            })
            ->rawColumns(['status','expire','checkbox'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Pengumuman>
     */
    public function query(Pengumuman $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('pengumuman-table')
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
                            ->className('btn btn-success btn-sm'),
                        'add' => [
                            'text' => '<i class="fa fa-plus"></i> Tambah', // Button text with optional icon
                            'className' => 'btn btn-primary', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.pengumuman.create') . '";
                            }',
                        ],
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                var ids = [];
                                $("#pengumuman-table tbody .row-checkbox:checked").each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    if (confirm("Are you sure you want to delete selected pengumuman?")) {
                                        $.ajax({
                                            url: "' . route('admin.pengumuman.bulk-delete') . '",
                                            type: "POST",
                                            data: { 
                                                ids: ids,
                                                _token: "' . csrf_token() . '"
                                            },
                                            success: function(response) {
                                                dt.ajax.reload();
                                                toastr.warning("Selected pengumuman deleted successfully.");
                                            },
                                            error: function(xhr) {
                                                toastr.warning("Error deleting pengumuman: " + xhr.responseText);
                                            }
                                        });
                                    }
                                } else {
                                    toastr.warning("No pengumuman selected for deletion.");
                                }
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("status:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control pengumuman_status\"><option value=\"\" class=\"fs-6\">Semua Status</option></select>")
                            // .appendTo($(api.column(columnIdx).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdx)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        select.append("<option value=\"true\">Aktif</option>");
                        select.append("<option value=\"false\">Tidak Aktif</option>");

                        $("#pengumuman-table").on("change", "#select-all", function() {
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
            Column::make('status')
                ->title('Status')
                ->name('status')
                ->width(50)
                ->className('text-center'),
            Column::make('message')
                ->title('Pesan'),
            Column::make('expire')
                ->title('Tanggal Kadaluarsa')
                ->width(50)
                ->className('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pengumuman_' . date('YmdHis');
    }
}
