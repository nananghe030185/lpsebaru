<?php

namespace App\DataTables\Admin;

use App\Helpers\Helpers;
use App\Helpers\TableHelper;
use App\Models\Lpse;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LpseDataTable extends DataTable
{
    protected bool $fastExcel = true;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Lpse> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('nama_lpse', function($row){
                return '<div class="text-ellipsis w-96 text-nowrap">'. $row->nama_lpse . '<br>' . '<span class="text-muted small">Slug :' . $row->slug . '</span></div>';
            })
            ->editColumn('link', function($row){
                return Helpers::link($row->link, $row->link);
            })
            ->editColumn('jumlah_paket', function($row){
                return number_format($row->jumlah_paket);
            })
            ->editColumn('jumlah_pagu', function($row){
                return TableHelper::nominal_simple($row->jumlah_pagu);
            })
            ->editColumn('state', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'state',
                    'route' => 'admin.lpse.state',
                    'value' => $row->state,
                ]);
            })
            ->editColumn('scrape', function ($row) {
                return view('admin.inc.action', [
                    'toggle' => $row,
                    'name' => 'scrape',
                    'route' => 'admin.lpse.scrape',
                    'value' => $row->scrape,
                ]);
            })
            ->editColumn('action', function ($row) {
                return view('admin.inc.action', [
                    'edit'   => 'admin.lpse.edit',
                    'data'   => $row
                ]);
            })
            ->rawColumns(['nama_lpse','link','action','state','scrape'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Lpse>
     */
    public function query(Lpse $model): QueryBuilder
    {

        $query = $model->newQuery();

        if (request()->has('status') && request('status') !== '') {
            $query->where('state', request('status'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('lpse-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->scrollX(true)
                    ->responsive(true)
                    ->orderBy(1, 'asc')
                    ->selectStyleSingle()
                    ->parameters($this->getBuilderParameters())
                    ->buttons([
                        Button::make('excel')
                            ->text('<i class="fas fa-file-excel"></i> Export to Excel') // Add icon and custom text
                            ->className('btn btn-success btn-sm'), // Apply specific Bootstrap classes
                        'reload' => [
                            'text' => '<i class="fas fa-sync"></i> Reload LPSE', // Button text with icon
                            'className' => 'btn btn-secondary btn-sm', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.lpse.reload') . '";
                            }',
                        ],
                        'customation' => [
                            'text' => '<i class="fa fa-plus"></i> Add New LPSE', // Button text with optional icon
                            'className' => 'btn btn-primary', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.lpse.create') . '";
                            }',
                        ],
                        'scrape' => [
                            'text' => '<i class="fas fa-sync"></i> Unscrape LPSE', // Button text with icon
                            'className' => 'btn btn-info btn-sm', // CSS class for styling
                            'action' => 'function (e, dt, node, config) {
                                window.location = "' . route('admin.lpse.unscrape-all') . '";
                            }',
                        ],
                    ])
                    ->addAction(['width' => 60, 'className' => 'text-center'])
                    ->addIndex();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->hidden(),
            Column::make('state')
                ->title('Status')
                ->width(50)
                ->className('text-center'),
            Column::make('scrape')
                ->title('Scrape')
                ->width(50)
                ->className('text-center'),
            Column::make('kode_lpse')
                ->title('Kode LPSE')
                ->width(100)
                ->hidden(),
            Column::make('nama_lpse')
                ->title('Nama LPSE')
                ->width(200),
            Column::make('link')
                ->title('Link')
                ->width(200),
            Column::make('jumlah_paket')
                ->title('Jumlah Paket')
                ->width(150)
                ->className('text-end'),
            Column::make('jumlah_pagu')
                ->title('Jumlah Pagu')
                ->width(150)
                ->className('text-end'),
            ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Lpse_' . date('YmdHis');
    }

 
}
