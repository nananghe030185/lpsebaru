<?php

namespace App\DataTables\Member;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\Fokus;
use App\Models\Tender;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class FokusDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Foku> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // add checkbox column for bulk actions
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'unfokus'  => 'app.fokus-paket.unfokus',
                    'data'   => $row
                ]);
            })
            ->editColumn('tender.nama_paket', function ($fokus) {
                $anchor = $fokus->tender->nama_paket;
                return Helpers::link(route('redirect.tender',[$fokus->tender->slug]), $anchor);
            })
            ->editColumn('tender.tahap_tender', function ($fokus) {
                $anchor = $fokus->tender->tahap_tender;
                return Helpers::link(route('redirect.tender.tahapan',[$fokus->tender->slug]), $anchor);
            })
            ->editColumn('tender.hps', function ($fokus) {
                return TableHelper::nominal_simple($fokus->tender->hps);
            })
            ->rawColumns(['checkbox','tender.nama_paket','tender.tahap_tender'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Foku>
     */
    public function query(Fokus $model): QueryBuilder
    {
        return $model->newQuery()->where('fokus', true)->where('user_id', Helpers::getCurrentUserId());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('fokus-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        // add export to excel button
                        Button::make('excel')
                            ->text('<i class="fa fa-file-excel"></i> ' . __('Export Excel'))
                            ->className('btn btn-success'),
                        // add bulk unfokus button
                        'bulk-unfokus' => [
                            'text' => '<i class="fa fa-bullseye"></i> Unfokus',
                            'className' => 'btn btn-danger',
                            'action' => 'function(e, dt, node, config) {
                                var ids = [];
                                $(".row-checkbox:checked").each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    $.ajax({
                                        url: "' . route('app.fokus-paket.bulk-unfokus') . '?ids=" + ids.join(","),
                                        type: "GET",
                                        data: {
                                            _token: "' . csrf_token() . '"
                                        },
                                        success: function(response) {
                                            dt.ajax.reload();
                                            toastr.warning(response.message || "Unfocused successfully!");
                                        },
                                        error: function(xhr) {
                                            toastr.warning("Error unfocusing items: " + xhr.responseText);
                                        }
                                    });
                                } else {
                                    toastr.warning("No items selected for unfocusing.");
                                }
                            }'
                        ],                       
                            
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("tender.tahap_tender:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control tahapan_tender\"><option value=\"\">Semua Tahapan</option></select>")
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

                        $("#fokus-table").on("change", "#select-all", function() {
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
                ->title('<div class="form-check"><input class="form-check-input checkbox-primary" id="select-all" type="checkbox"></div>'),
            Column::make('tender.nama_paket')
                ->title(__('Nama Paket'))
                // ->name('tender.nama_paket')
                ->orderable(true)
                ->searchable(true),
            Column::make('lpse.nama_lpse')
                ->title(__('LPSE'))
                ->orderable(true)
                ->searchable(true),
            Column::make('tender.tahap_tender')
                ->title(__('Tahapan'))
                ->orderable(true)
                ->searchable(true),
            Column::make('tender.hps')
                ->title(__('HPS'))
                ->orderable(true)
                ->searchable(true),
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
        return 'FokusPaket_' . date('YmdHis');
    }
}
