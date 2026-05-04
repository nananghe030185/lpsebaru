<?php

namespace App\DataTables\Admin;

use App\Helpers\Helpers;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Invoice> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('nomer', function ($row) {
                return Helpers::link(route('admin.invoice.display', $row->nomer),'#' . $row->nomer, false);
            })
            ->editColumn('tanggal_terbit', function ($row) {
                return $row->tanggal_terbit->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s');
                // return Carbon::parse(now())->format('d-m-Y H:i:s');
            })
            ->editColumn('item', function ($row) {
                if($row->status == 'pending') {
                    return $row->item . '<br>' . '<small class="text-sm text-danger">' . $row->keterangan . ' Klik : <a class="pdf" href="' . $row->pdf_url.'" target="_blank"><i class="icofont icofont-file-pdf"></i></a></small>';
                }else{
                    return $row->item;
                }
            })
            ->editColumn('tanggal_bayar', function ($row) {
                return $row->tanggal_bayar ? $row->tanggal_bayar->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') : 'Belum Dibayar';
            })
            ->editColumn('total', function ($row) {
                return 'Rp. ' . number_format($row->total);
            })
            ->editColumn('durasi', function ($row) {
                return $row->durasi / 30;
            })
            ->editColumn('status', function ($row) {
                if($row->status == 'paid') {
                    return '<span class="badge bg-success p-2">Paid</span>';
                } elseif ($row->status == 'unpaid') {
                    return '<span class="badge bg-danger p-2">Unpaid</span>';
                } elseif ($row->status == 'pending') {
                    return '<span class="badge bg-warning p-2">Pending</span>';
                } elseif ($row->status == 'expired') {
                    return '<span class="badge bg-secondary p-2">Expired</span>';
                } elseif ($row->status == 'failed') {
                    return '<span class="badge bg-danger p-2">Failed</span>';
                } elseif ($row->status == 'cancel') {
                    return '<span class="badge bg-secondary p-2">Cancelled</span>';
                } else {
                    return '<span class="badge bg-warning p-2">Pending</span>';
                }
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'    => 'admin.invoice.destroy',
                    'pay'       => 'admin.invoice.pay',
                    'data'      => $row
                ]);
            })
            ->rawColumns(['nomer', 'tanggal_bayar', 'total', 'action','status','item','checkbox'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Invoice>
     */
    public function query(Invoice $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('invoice-table')
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
                        'tiket' => [
                            'text' => '<i class="fa fa-plus"></i> Add New Invoice', // Button text with optional icon
                            'className' => 'btn btn-primary', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.invoice.create') . '";
                            }',
                        ],
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Bulk Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                var ids = [];
                                $("#invoice-table tbody .row-checkbox:checked").each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    if (confirm("Are you sure you want to delete selected invoices?")) {
                                        $.ajax({
                                            url: "' . route('admin.invoice.bulk-delete') . '",
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
                        var columnIdx = api.column("status:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control invoice_status\"><option value=\"\" class=\"fs-6\">Semua Status</option></select>")
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

                        $("#invoice-table").on("change", "#select-all", function() {
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
            Column::make('user.name')
                ->title('Member')
                ->searchable(true)
                ->orderable(true)
                ->width(50),
            Column::make('nomer')
                ->title('Nomor Invoive')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->addClass('text-center'),
            Column::make('tanggal_terbit')
                ->title('Tanggal Terbit')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->addClass('text-center'),
            Column::make('tanggal_bayar')
                ->title('Tanggal Bayar')
                ->searchable(true)
                ->orderable(true)
                ->width(50)
                ->addClass('text-center'),
            Column::make('user_id')
                ->hidden(),
            Column::make('item')
                ->title('Item')
                ->searchable(true)
                ->orderable(true)
                ->width(200),
            Column::make('durasi')
                ->title('Durasi (Bulan)')
                ->searchable(true)
                ->orderable(true)
                ->width(100)
                ->addClass('text-center'),
            Column::make('total')
                ->title('Total')
                ->searchable(true)
                ->orderable(true)
                ->width(100)
                ->addClass('text-end'),
            Column::make('status')
                ->title('Status')
                ->name('status')
                ->searchable(true)
                ->orderable(true)
                ->width(100)
                ->addClass('text-center'),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Invoice_' . date('YmdHis');
    }
}
