<?php

namespace App\DataTables\Tenant;

use App\Models\Tenant\Order;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class OrderDataTable extends DataTable
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
        $dataTable->editColumn('created_at', function ($order) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->format('d/m/Y H:i');
        });
        $dataTable->editColumn('sub_total', 'R$ {{number_format($sub_total, 2, ",", ".")}}');
        $dataTable->editColumn('grand_total', 'R$ {{number_format($grand_total, 2, ",", ".")}}');

        return $dataTable->addColumn('action', 'tenant.sales.orders.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tenant\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
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
            ->minifiedAjax(route('orders.index'))
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
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'title' => '#'],
            ['data' => 'channel_name', 'title' => 'Canal'],
            ['data' => 'customer_name', 'title' => 'Nome do comprador'],
            ['data' => 'customer_email', 'title' => 'E-mail do comprador'],
            ['data' => 'sub_total', 'title' => 'Subtotal'],
            ['data' => 'grand_total', 'title' => 'Total'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'created_at', 'title' => 'Data'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'pedidos-' . time();
    }
}
