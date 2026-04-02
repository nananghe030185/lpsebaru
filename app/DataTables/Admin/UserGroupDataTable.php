<?php

namespace App\DataTables\Admin;

use App\Models\Groups;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserGroupDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<UserGroup> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'edit'   => 'admin.user.group.edit',
                    'delete' => 'admin.user.group.destroy',
                    'data'   => $row,
                ]);
            })
            ->editColumn('users_count', function ($row) {
                return User::where('group_id', $row->id)->count();
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<UserGroup>
     */
    public function query(Groups $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('usergroup-table')
                    ->columns($this->getColumns())
                    ->parameters($this->getBuilderParameters())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([])
                    ->addAction([
                        'title' => 'Action',
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
                ->title('Group Name'),
            Column::make('description')
                ->title('Description'),
            // Column::make('users')
            //     ->title('Number of Users')
            //     ->searchable(false)
            //     ->orderable(false)
            //     ->render(function (Groups $group) {
            //         return $group->users->count();
            //     }),
            Column::make('users_count')
                ->title('Jumlah User')
                ->searchable(false)
                ->orderable(false)
                ->className('text-center'),
            Column::make('created_at')
                ->title('Created At'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserGroup_' . date('YmdHis');
    }
}
