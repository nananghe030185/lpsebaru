<?php

namespace App\DataTables\Admin;

use App\Models\Inbox;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class InboxDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Inbox> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
            ->editColumn('status', function($row){
                if($row){
                    return '<span class="text-success"><i class="fa-regular fa-circle-check"></i></span>';
                }else{
                    return '<span class="text-danger"><i class="far fa-times-circle"></i></span>';
                }
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'delete'  => 'admin.inout.outbox.destroy',
                    'data'   => $row
                ]);
            })
            ->addColumn('message', function ($row) {
                return Str::limit($row->message);
            })
            ->editColumn('created_at', function($row){
                return Carbon::parse($row->created_at)->setTimezone('Asia/Jakarta')->translatedFormat('d/m/Y H:i:s');
            })
            ->editColumn('channel', function($row){
                if($row->channel == 'whatsapp'){
                    return '<span class="badge bg-success m-1">Whatsapp</span>';
                }elseif($row->channel == 'telegram'){
                    return '<span class="badge bg-primary m-1">Telegram</span>';
                }else{
                    return '<span class="badge bg-secondary m-1">Unknown</span>';
                }

            })
            ->editColumn('sender', function($row){
                return $this->user($row->sender);
            })
            ->rawColumns(['checkbox','message','channel','status','action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Inbox>
     */
    public function query(Inbox $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('inbox-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->addAction(['width' => '50px', 'addClass' => 'text-center'])
                    ->buttons([
                        'bulk-delete' => [
                            'text' => '<i class="fa fa-trash"></i> Bulk Delete', // Button text with optional icon
                            'className' => 'btn btn-danger', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                var ids = [];
                                $("#inbox-table tbody .row-checkbox:checked").each(function() {
                                    ids.push($(this).val());
                                });
                                if (ids.length > 0) {
                                    if (confirm("Are you sure you want to delete selected Outbox?")) {
                                        $.ajax({
                                            url: "' . route('admin.inout.inbox.bulk-delete') . '",
                                            type: "POST",
                                            data: { 
                                                ids: ids,
                                                _token: "' . csrf_token() . '"
                                            },
                                            success: function(response) {
                                                dt.ajax.reload();
                                                toastr.warning("Selected Outbox deleted successfully.");
                                            },
                                            error: function(xhr) {
                                                toastr.warning("Error deleting Outbox: " + xhr.responseText);
                                            }
                                        });
                                    }
                                } else {
                                    toastr.warning("No Outbox selected for deletion.");
                                }
                            }',
                        ],
                    ])
                    ->initComplete('function() {
                        var api = this.api();

                        // Select Channel
                        var columnChannel = api.column("channel:name").index();
                        var selectUpline = $("<select name=\"filterChannel\" id=\"filterChannel\" class=\"form-control select_channel\"><option value=\"\" class=\"fs-6\">Semua Channel</option></select>")
                            // .appendTo($(api.column(columnChannel).header()).empty())
                            .appendTo(".filter1")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnChannel)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        api.column(columnChannel).data().unique().sort().each(function(d, j) {
                            // Remove HTML tags if present
                            var text = d.replace(/(<([^>]+)>)/gi, "");
                            if (selectUpline.find("option[value=\'" + text + "\']").length === 0) {
                                selectUpline.append("<option value=\"" + text + "\">" + text + "</option>");
                            }
                        });

                        // Select status
                        var columnStatus = api.column("status:name").index();
                        var selectUpline = $("<select name=\"filterStatus\" id=\"filterStatus\" class=\"form-control select_status\"><option value=\"\" class=\"fs-6\">Semua Status</option></select>")
                            // .appendTo($(api.column(columnStatus).header()).empty())
                            .appendTo(".filter2")
                            .on("change", function() {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                api.column(columnStatus)
                                    .search(val ? "^" + val + "$" : "", true, false)
                                    .draw();
                            });
                        // Get unique values and append as options
                        selectUpline.append("<option value=\"true\">Terkirim</option>");
                        selectUpline.append("<option value=\"false\">Gagal</option>");

                        $("#inbox-table").on("change", "#select-all", function() {
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
            Column::make('status')
                ->title('Status')
                ->addClass('text-center'),
            Column::make('created_at')
                ->title('Tanggal'),
            Column::make('sender')
                ->title('Pengirim'),
            Column::make('message')
                ->title('Pesan')
                ->searchable(),
            Column::make('channel')
                ->title('Channel')
                ->searchable(),
         ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Inbox_' . date('YmdHis');
    }

    /**
     * fungsi user by sender
     */
    public function user($sender){
        $user = User::where('whatsapp',$sender)->orWhere('telegram',$sender)->first();
        if($user){
            return $sender . ' - ' . $user->name;
        }else{
            return $sender;
        }
    }
}
