<?php

namespace App\DataTables\Admin;

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
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'fokusTender'  => 'admin.tender-lpse.fokus',
                    'data'   => $row,
                    'isFokusTender' => Helpers::isUserFokusTender($row)
                ]);
            })
            ->editColumn('created_at', function (Tender $tender) {
                return TableHelper::tanggal($tender->created_at);
            })
            ->editColumn('hps', function (Tender $tender) {
                return TableHelper::nominal_simple($tender->hps);
            })
            ->editColumn('nama_paket', function (Tender $tender) {
                $anchor = $tender->nama_paket;
                return Helpers::link(route('redirect.tender', [
                    $tender->slug
                ]), $anchor);
            })
            ->editColumn('tahap_tender', function (Tender $tender) {

                $anchor = '';
                if($tender->tahap_tender == 'Tender Sudah Selesai'){
                    $anchor = '<span class="badge badge-light-danger p-2">' . $tender->tahap_tender . '</span>';
                }else{
                    $anchor = '<span class="badge badge-light-success p-2">' . $tender->tahap_tender . '</span>';
                }
                return Helpers::link(route('redirect.tender.tahapan', [
                    $tender->slug
                ]), $anchor);
            })
            ->rawColumns(['nama_paket','action','tahap_tender', 'checkbox'])
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
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Bulk Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function(e, dt, node, config) {
                                var selectedIds = [];
                                $(".row-checkbox:checked").each(function() {
                                    selectedIds.push($(this).val());
                                });

                                if (selectedIds.length === 0) {
                                    alert("Please select at least one row to delete.");
                                    return;
                                }

                                if (confirm("Are you sure you want to delete the selected rows?")) {
                                    $.ajax({
                                        url: "' . route('admin.tender-lpse.bulk-delete') . '",
                                        type: "POST",
                                        data: {
                                            ids: selectedIds,
                                            _token: "' . csrf_token() . '"
                                        },
                                        success: function(response) {
                                            dt.ajax.reload(); // Reload the DataTable
                                            alert(response.message);
                                        },
                                        error: function(xhr) {
                                            alert("An error occurred while deleting the rows.");
                                        }
                                    });
                                }
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        // Target the "tahap_tender" column (adjust index if needed)
                        var columnIdx = api.column("tahap_tender:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"select2 form-control tahapan_tender\"><option value=\"\">Semua Tahapan</option></select>")
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

                        var lpse = api.column("lpse.nama_lpse:name").index();

                        var select = $("<select name=\"filter\" id=\"filter\" class=\"select2 klpdi form-control \"><option value=\"\">Semua KLPDI</option></select>")
                            // .appendTo($(api.column(lpse).header()).empty())
                            .appendTo(".filter1")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(lpse)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        api.column(lpse).data().unique().sort().each(function(d, j) {
                            // Remove HTML tags if present
                            var text = d.replace(/(<([^>]+)>)/gi, "");
                            if (select.find("option[value=\'" + text + "\']").length === 0) {
                                select.append("<option value=\"" + text + "\">" + text + "</option>");
                            }
                        });

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
                ->exportable(false)
                ->printable(false)
                ->width(10)
                ->addClass('text-center'),
            Column::make('created_at')
                  ->title('Tanggal Dibuat')
                  ->orderable(true),
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
