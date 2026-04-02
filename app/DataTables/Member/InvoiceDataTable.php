<?php

namespace App\DataTables\Member;

use App\Helpers\Helpers;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
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
            ->editColumn('nomer', function ($row) {
                return Helpers::link(route('app.invoice.display', $row->nomer),'#' . $row->nomer, false);
            })
            ->editColumn('tanggal_terbit', function ($row) {
                return $row->tanggal_terbit->format('d-m-Y H:i:s');
            })
            ->editColumn('item', function ($row) {
                if($row->status == 'pending') {
                    return $row->item . '<br>' . '<small class="text-sm text-danger">' . $row->keterangan . ' Klik : <a class="pdf" href="' . $row->pdf_url.'" target="_blank"><i class="icofont icofont-file-pdf"></i></a></small>';
                }else{
                    return $row->item;
                }
            })
            ->editColumn('tanggal_bayar', function ($row) {
                return $row->tanggal_bayar ? $row->tanggal_bayar->format('d-m-Y H:i:s') : 'Belum Dibayar';
            })
            ->editColumn('total', function ($row) {
                return 'Rp. ' . number_format($row->total);
            })
            ->editColumn('durasi', function ($row) {
                return $row->durasi / 30;
            })
            ->editColumn('status', function ($row) {
                if($row->status == 'paid') {
                    return '<span class="badge bg-success">Paid</span>';
                } elseif ($row->status == 'unpaid') {
                    return '<span class="badge bg-danger">Unpaid</span>';
                } elseif ($row->status == 'pending') {
                    return '<span class="badge bg-warning">Pending</span>';
                } else {
                    return '<span class="badge bg-warning">Pending</span>';
                }
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'   => 'app.invoice.destroy',
                    'pay'      => 'app.invoice.pay',
                    'data'   => $row
                ]);
            })
            ->rawColumns(['nomer','tanggal_terbit', 'tanggal_bayar', 'total', 'action','status','item'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Invoice>
     */
    public function query(Invoice $model): QueryBuilder
    {
        return $model->newQuery()->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc');
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
                                window.location = "' . route('app.invoice.create') . '";
                            }',
                        ],

                    ])
                    ->initComplete('function() {
                        var api = this.api();
                        var columnIdx = api.column("status:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control invoice-status\"><option value=\"\" class=\"fs-6\">Semua Status</option></select>")
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
