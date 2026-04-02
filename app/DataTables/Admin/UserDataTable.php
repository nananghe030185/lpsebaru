<?php

namespace App\DataTables\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

class UserDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('masa_berlaku', function ($row) {
                return $row->masa_berlaku->diffForHumans();
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'edit'   => 'admin.user.edit',
                    'delete' => 'admin.user.destroy',
                    'data'   => $row,
                ]);
            })
            ->editColumn('status', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'status',
                    'route' => 'admin.user.status',
                    'value' => $row->status,
                ]);
            })
            ->editColumn('grup.name', function($row){
                if($row->group_id == 1){
                    return '<span class="text-success">Super Admin</span>';
                }else if($row->group_id == 2)
                {
                    return '<span class="text-info">Member</span>';
                }else{
                    return '<span class="text-danger">Non Member</span>';
                }
            })

            ->rawColumns(['masa_berlaku', 'action','status','grup.name']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                ->setTableId('user-table')
                ->columns($this->getColumns())
                ->minifiedAjax()
                ->orderBy(1)
                ->selectStyleSingle()
                ->parameters($this->getBuilderParameters())
                ->buttons([
                        Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i> Export to Excel') // Add icon and custom text
                            ->className('btn btn-success btn-sm'), // Apply specific Bootstrap classes
                    ])
                ->initComplete('function() {
                        var api = this.api();
                        // Target the "user-table" column (adjust index if needed)
                        var columnIdx = api.column("grup.name:name").index();
                        var select = $("<select name=\"filter\" id=\"filter\" class=\"form-control user-table\"><option value=\"\">Semua Group</option></select>")
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
                    ->addAction([
                        'title' => __('Action'),
                        'width' => '80px',
                        'printable' => false,
                        'exportable' => false,
                        'orderable' => false,
                        'searchable' => false,
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->hidden(),
            Column::make('name')
                ->title(__('Name'))
                ->searchable(true)
                ->orderable(true),
            Column::make('email')
                ->title(__('Email'))
                ->searchable(true)
                ->orderable(true),
            Column::make('grup.name')
                ->title(__('Group'))
                ->name('grup.name')
                ->searchable(true)
                ->orderable(true),
            Column::make('masa_berlaku')
                ->title(__('Masa Berlaku'))
                ->searchable(true)
                ->orderable(true),
            Column::make('status')
                ->title(__('Status')),  
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Pengguna_' . date('YmdHis');
    }
}
