<?php

namespace App\DataTables\Admin;

use App\Models\Perangkat;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PerangkatDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Perangkat> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'loginwhatsapp' => route('admin.whatsapp.login', $row->name),
                    'sendwhatsapp' => route('admin.whatsapp.send.form', $row->name),
                    'logoutwhatsapp' => route('admin.whatsapp.logout', $row->name),
                    'edit'   => 'admin.whatsapp.edit',
                    'delete' => 'admin.whatsapp.destroy',
                    'data'   => $row
                ]);
            })
            ->editColumn('status', function ($row) {
                if( $row->status == 'connected' ) {
                    return '<span class="badge bg-success p-2">Connected</span>';
                } elseif( $row->status == 'connecting' ) {
                    return '<span class="badge bg-warning p-2">Connecting</span>';
                } else {
                    return '<span class="badge bg-danger p-2">Disconnected</span>';
                }
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Perangkat>
     */
    public function query(Perangkat $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('whatsapp-table')
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1)
                    ->columns($this->getColumns())
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->addAction(['width' => '80px'])
                    ->buttons([
                        'create' => [
                            'text' => '<i class="fa fa-plus"></i> Create',
                            'className' => 'btn btn-success',
                            'action' => 'function ( e, dt, node, config ) {
                                var url = "' . route('admin.whatsapp.create') . '";
                                window.location.href = url;
                            }',
                        ],
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->title('ID')
                ->hidden(),
            Column::make('number')
                ->title('Number'),
            Column::make('name')
                ->title('Name'),
            Column::make('description')
                ->title('Description'),
            Column::make('status')
                ->title('Status'),
           
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Perangkat_' . date('YmdHis');
    }
}
