<?php

namespace App\DataTables\Admin;

use App\Models\Blog;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class BlogDataTable extends DataTable
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
        ->addColumn('checkbox', function ($row) {
                return '<div class="form-check"><input type="checkbox" class="form-check-input checkbox-primary row-checkbox" value="' . $row->id . '"></div>';
            })
        ->editColumn('created_at', function ($row) {
                return $row->created_at->diffForHumans();
            })
        ->editColumn('action', function ($row) {
            return view('admin.inc.action', [
                'edit'   => 'admin.blog.edit',
                'delete' => 'admin.blog.destroy',
                'data'   => $row
            ]);
        })
        ->editColumn('status', function ($row) {
            return view('admin.inc.action', [
                'toggle' => $row,
                'name' => 'status',
                'route' => 'admin.blog.status',
                'value' => $row->status,
            ]);
        })
        ->editColumn('title' , function($row){
            $media = $row->getFirstMedia('thumbnail');
            if($media)
                {
                    return '<div class="d-inline-flex gap-2"><img src="' . $media->getUrl() . '" alt="thumbnail" class="img-thumbnail img-fix"><div class="text-ellipsis w-96 text-nowrap">' .$row->title . '<br/><small class="text-muted">'  . $row->slug . '</small></div></div>';
                }
            return '<div class="d-inline-flex gap-1"><img src="' . asset("assets/images/user/user.png") . '" alt="thumbnail" class="img-thumbnail img-fix"><div class="text-ellipsis w-96 text-nowrap">' .$row->title . '<br/><small class="text-muted">'  . $row->slug . '</small></div></div>';
        })
        ->rawColumns(['action', 'created_at','thumbnail','status', 'title','checkbox'])
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Blog $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('blog-table')
        ->columns($this->getColumns())
        ->scrollX(true)
        ->responsive(true)
        ->addAction()
        ->minifiedAjax()
        ->orderBy(1)
        ->selectStyleSingle()
        ->parameters($this->getBuilderParameters())
        ->parameters([
            'language' => [
                'emptyTable' => 'No Records Found',
                'infoEmpty' => '',
                'zeroRecords' => 'No Records Found',
            ],
            'drawCallback' => 'function(settings) {
                if (settings._iRecordsDisplay === 0) {
                    $(settings.nTableWrapper).find(".dataTables_paginate").hide();
                } else {
                    $(settings.nTableWrapper).find(".dataTables_paginate").show();
                }
                feather.replace();
            }',
        ])
        ->buttons([
            Button::make('create')
                ->text('<i class="fas fa-add"></i> Tambah Artikel') // Add icon and custom text
                ->className('btn btn-success btn-sm'), // Apply specific Bootstrap classes,
        ])
        ->initComplete('function() {
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
            Column::make('status')
                ->title('Status'),
            Column::make('created_at')
                ->title('Created At'),
            Column::make('title')
                ->title('Judul')
                ->searchable()
                ->orderable(),

        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Blog_' . date('YmdHis');
    }
}
