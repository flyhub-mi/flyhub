<?php

namespace App\DataTables\Tenant;

use App\Models\Tenant\Shipment;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

class ShipmentDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'tenant.sales.shipments.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tenant\Shipment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shipment $model)
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
            ->minifiedAjax(route('shipments.index'))
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
            ['data' => 'order_id', 'title' => '# Pedido'],
            ['data' => 'customer_id', 'title' => '# Cliente'],
            ['data' => 'status', 'title' => 'Status'],
            ['data' => 'carrier_title', 'title' => 'Transportadora'],
            ['data' => 'track_number', 'title' => 'Número de rastreio'],
        ];
    }
}
