<?php

namespace App\DataTables\Tenant;

use App\Models\Tenant\ChannelSync;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class SyncLogDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        $dataTable->rawColumns(['action']);
        $dataTable->addColumn('action', 'tenant.settings.sync-logs.actions');

        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tenant\SyncLog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ChannelSync $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax(route('sync-logs.index'))
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'buttons' => [
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner'],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner'],
                ],
                'language' => ['url' => '/i18n/datatables.portuguese.json'],
                'select' => [
                    'style' => 'multi',
                    'selector' => 'td:first-child',
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'channel', 'title' => 'Canal'],
            ['data' => 'resource', 'title' => 'Recurso'],
            ['data' => 'model_id', 'title' => 'Id do Recurso'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'processed', 'title' => 'Processados'],
            ['data' => 'failed', 'title' => 'Falhados'],
            ['data' => 'total', 'title' => 'Total'],
            ['data' => 'error', 'title' => 'Erro', 'class' => 'error'],
        ];
    }
}
