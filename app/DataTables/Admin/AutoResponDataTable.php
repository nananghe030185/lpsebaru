<?php

namespace App\DataTables\Admin;

use App\Models\AutoRespon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AutoResponDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<AutoRespon> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'    => 'admin.auto-respon.destroy',
                    'edit'    => 'admin.auto-respon.edit',
                    'data'      => $row
                ]);
            })
            ->editColumn('status', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'status',
                    'route' => 'admin.auto-respon.status',
                    'value' => $row->status,
                ]);
            })
            ->editColumn('whatsapp', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'whatsapp',
                    'route' => 'admin.auto-respon.whatsapp',
                    'value' => $row->whatsapp,
                ]);
            })
            ->editColumn('telegram', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'telegram',
                    'route' => 'admin.auto-respon.telegram',
                    'value' => $row->telegram,
                ]);
            })
            ->editColumn('response', function ($row) {
                return '<div class="text-ellipsis w-96 text-nowrap">'. $row->response . '</div>';
            })
            
            ->rawColumns(['checkbox','action','status','response'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<AutoRespon>
     */
    public function query(AutoRespon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('autorespon-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        'add' => [
                            'text' => '<i class="fa fa-plus"></i> Add Auto Respon', // Button text with optional icon
                            'className' => 'btn btn-primary', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.auto-respon.create') . '";
                            }',
                        ],
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                var ids = [];
                                $("#autorespon-table tbody .row-checkbox:checked").each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    if (confirm("Are you sure you want to delete selected autorespon?")) {
                                        $.ajax({
                                            url: "' . route('admin.auto-respon.bulk-delete') . '",
                                            type: "POST",
                                            data: { 
                                                ids: ids,
                                                _token: "' . csrf_token() . '"
                                            },
                                            success: function(response) {
                                                dt.ajax.reload();
                                                toastr.warning("Selected autorespon deleted successfully.");
                                            },
                                            error: function(xhr) {
                                                toastr.warning("Error deleting autorespon: " + xhr.responseText);
                                            }
                                        });
                                    }
                                } else {
                                    toastr.warning("No autorespon selected for deletion.");
                                }
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("status:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control autorespon-status\"><option value=\"\" class=\"fs-6\">Semua Status</option></select>")
                            // .appendTo($(api.column(columnIdx).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdx)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        select.append("<option value=\"true\">Active</option>");
                        select.append("<option value=\"false\">Inactive</option>");

                        $("#autorespon-table").on("change", "#select-all", function() {
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
                ->orderable(false)
                ->searchable(false)
                ->title('<div class="form-check"><input class="form-check-input checkbox-primary" id="select-all" type="checkbox"></div>'),
            Column::make('status')
                ->title('Status')
                ->name('status')
                ->searchable(true)
                ->orderable(true),
            Column::make('keyword')
                ->title('Keyword')
                ->searchable(true)
                ->orderable(true),
            Column::make('response')
                ->title('Response')
                ->searchable(true)
                ->orderable(true),
            Column::make('whatsapp')
                ->title('Whatsapp')
                ->name('whatsapp'),
            Column::make('telegram')
                ->title('Telegram')
                ->name('telegram'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'AutoRespon_' . date('YmdHis');
    }
}
