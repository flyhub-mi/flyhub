<?php

namespace App\DataTables\Tenant;

use App\Models\Tenant\Subscriber;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class SubscriberDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'tenant.subscribers.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tenant\Subscriber $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subscriber $model)
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
            ->minifiedAjax(route('subscribers.index'))
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'buttons' => [
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner'],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner'],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner'],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner'],
                ],
                'language' => ['url' => '/i18n/datatables.portuguese.json'],
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
            ['data' => 'email', 'title' => 'E-mail'],
            ['data' => 'is_subscribed', 'title' => 'Inscrito'],
            ['data' => 'channel_id', 'title' => 'Canal'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'inscritos-' . time();
    }
}
