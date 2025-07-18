<?php

namespace App\DataTables\Tenant;

use App\Models\Tenant\Notification;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use Carbon\Carbon;

class NotificationDataTable extends DataTable
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

        $dataTable->editColumn('created_at', function ($notification) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('d/m/Y H:i');
        });

        $dataTable->editColumn('data', function ($notification) {
            $data = json_decode($notification->getAttribute('data'));
            return 'Canal: ' . $data->channel_name . '';
        });

        $dataTable->editColumn('name', function ($notification) {
            $data = json_decode($notification->getAttribute('data'));
            return $notification->getNotificationTypeName($data->type);
        });

        return $dataTable->addColumn('action', 'tenant.notifications.actions');
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
            ->minifiedAjax(route('notifications.index'))
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'buttons' => [['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner']],
                'language' => ['url' => '/i18n/datatables.portuguese.json'],
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tenant\Notification $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Notification $model)
    {
        return $model->with('tenant')->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'id', 'title' => '#'],
            ['data' => 'name', 'title' => 'Tipo'],
            ['data' => 'data', 'title' => 'Conteúdo'],
            ['data' => 'created_at', 'title' => 'Data'],
        ];
    }
}
