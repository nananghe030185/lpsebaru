<?php

namespace App\DataTables\Admin;

use App\Models\Komisi;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KomisiDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Komisi> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'  => 'admin.laporan.komisi.destroy',
                    'data'   => $row
                ]);
            })
            ->editColumn('state', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'status',
                    'route' => 'admin.komisi.status',
                    'value' => $row->state,
                ]);
            })
            ->editColumn('nominal', function($row){
                return 'Rp .' . number_format($row->nominal);
            })
            ->editColumn('pay_date', function($row){
                return Carbon::parse($row->pay_date)->setTimezone('Asia/Jakarta')->translatedFormat('d/m/Y H:i:s');
            })
            ->rawColumns(['nominal','state','checkbox'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Komisi>
     */
    public function query(Komisi $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('komisi-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i> Export to Excel') // Add icon and custom text
                            ->className('btn btn-success'),
                        Button::make('pdf')
                            ->text('<i class="fas fa-file-pdf"></i> Export to PDF') // Add icon and custom text
                            ->className('btn btn-danger'),
                        Button::make('print')
                            ->text('<i class="fas fa-print"></i> Print') // Add icon and custom text
                            ->className('btn btn-info'),
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Bulk Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                var ids = [];
                                $("#komisi-table tbody .row-checkbox:checked").each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    if (confirm("Are you sure you want to delete selected komisi?")) {
                                        $.ajax({
                                            url: "' . route('admin.komisi.bulk-delete') . '",
                                            type: "POST",
                                            data: { 
                                                ids: ids,
                                                _token: "' . csrf_token() . '"
                                            },
                                            success: function(response) {
                                                dt.ajax.reload();
                                                toastr.warning("Selected komisi deleted successfully.");
                                            },
                                            error: function(xhr) {
                                                toastr.warning("Error deleting komisi: " + xhr.responseText);
                                            }
                                        });
                                    }
                                } else {
                                    toastr.warning("No komisi selected for deletion.");
                                }
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();

                        // Select Upline
                        var columnIdxUpline = api.column("upline.name:name").index();
                        var selectUpline = $("<select name=\"filterUpline\" id=\"filterUpline\" class=\"form-control select_upline\"><option value=\"\" class=\"fs-6\">Semua Upline</option></select>")
                            // .appendTo($(api.column(columnIdxUpline).header()).empty())
                            .appendTo(".filter1")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdxUpline)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        api.column(columnIdxUpline).data().unique().sort().each(function(d, j) {
                            // Remove HTML tags if present
                            var text = d.replace(/(<([^>]+)>)/gi, "");
                            if (selectUpline.find("option[value=\'" + text + "\']").length === 0) {
                                selectUpline.append("<option value=\"" + text + "\">" + text + "</option>");
                            }
                        });

                        // Select Downline
                        var columnIdxDownline = api.column("downline.name:name").index();
                        var selectDownline = $("<select name=\"filterDownline\" id=\"filterDownline\" class=\"form-control select_downline\"><option value=\"\" class=\"fs-6\">Semua Downline</option></select>")
                            // .appendTo($(api.column(columnIdxDownline).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnIdxDownline)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        api.column(columnIdxDownline).data().unique().sort().each(function(d, j) {
                            // Remove HTML tags if present
                            var text = d.replace(/(<([^>]+)>)/gi, "");
                            if (selectDownline.find("option[value=\'" + text + "\']").length === 0) {
                                selectDownline.append("<option value=\"" + text + "\">" + text + "</option>");
                            }
                        });

                        $("#komisi-table").on("change", "#select-all", function() {
                            $(".row-checkbox").prop("checked", this.checked);
                        });
                       
                    }')
                    ->addAction(['width' => 60, 'className' => 'text-center']);;
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
            Column::make('state')
                ->title('Status')
                ->searchable(),
            Column::make('upline.name')
                ->title('Upline')
                ->name('upline.name')
                ->searchable(),
            Column::make('downline.name')
                ->title('Member')
                ->name('downline.name')
                ->searchable(),
            Column::make('nominal')
                ->title('Nominal')
                ->searchable(),
            Column::make('pay_date')
                ->title('Tanggal dibayar')
                ->searchable(),
            Column::make('keterangan')
                ->title('Keterangan')
                ->searchable(),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Komisi_' . date('YmdHis');
    }
}
