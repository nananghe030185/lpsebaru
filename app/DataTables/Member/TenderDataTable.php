<?php

namespace App\DataTables\Member;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\Tender;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TenderDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Tender> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // Add a checkbox column for bulk actions
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            // Define the action column with buttons
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'fokus'  => 'app.tender-lpse.fokus',
                    'data'   => $row
                ]);
            })
            ->editColumn('hps', function (Tender $tender) {
                return TableHelper::nominal_simple($tender->hps);
            })
            ->editColumn('nama_paket', function (Tender $tender) {
                $link = $tender->lpse->link .'/lelang/' . $tender->tender_id . '/pengumumanlelang';
                $anchor = $tender->nama_paket;
                return Helpers::link(route('redirect.tender', [$tender->slug]), $anchor);
            })
            ->editColumn('tahap_tender', function (Tender $tender) {
                $link = $tender->lpse->link .'/lelang/' . $tender->tender_id . '/jadwal';
                $anchor = $tender->tahap_tender;
                return '<span class="badge badge-light-warning">' . Helpers::link(route('redirect.tender.tahapan', [$tender->slug]), $anchor) . '</span>';
            })
            ->rawColumns(['checkbox','nama_paket','action','tahap_tender'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Tender>
     */
    public function query(Tender $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('tender-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        // add bulk fokus button
                        'bulk-fokus' => [
                            'text' => '<i class="fa fa-bullseye"></i> Fokus',
                            'className' => 'btn btn-primary',
                            'action' => "function(e, dt, node, config) {
                                var ids = [];
                                $('.row-checkbox:checked').each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    window.location = '" . route('app.tender-lpse.bulk-fokus') . "?ids=' + ids.join(',');
                                } else {
                                    toastr.warning('Tidak ada paket yang dipilih.');
                                }
                            }"
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        // Target the "tahap_tender" column (adjust index if needed)
                        var columnIdx = api.column("tahap_tender:name").index();
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

                        $("#tender-table").on("change", "#select-all", function() {
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
            Column::make('tender_id')
                  ->title('Kode')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('nama_paket')
                  ->title('Nama Paket')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('lpse.nama_lpse')
                  ->title('Nama KLPDI')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('tahap_tender')
                  ->title('Tahapan')
                  ->name('tahap_tender')
                  ->searchable(true)
                  ->orderable(true),
            Column::make('hps')
                  ->title('HPS')
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
        return 'Tender_' . date('YmdHis');
    }
}
