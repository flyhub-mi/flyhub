<?php

namespace App\DataTables\Tenant;

use App\Models\Tenant\Product;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ProductDataTable extends DataTable
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
        $dataTable->editColumn('thumbnail', '<img src="//{{$thumbnail}}" class="img-thumbnail img-md" />');
        $dataTable->editColumn('price', 'R$ {{number_format($price, 2, ",", ".")}}');
        $dataTable->rawColumns(['thumbnail', 'action']);

        return $dataTable->addColumn('action', 'tenant.catalog.products.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tenant\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Product $model)
    {
        return $model->newQuery()->where('parent_id', null);
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
            ->minifiedAjax(route('products.index'))
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom' => 'Bfrtip',
                'stateSave' => true,
                'order' => [[0, 'desc']],
                'buttons' => [
                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner'],
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
            ['data' => 'id', 'title' => '#'],
            ['data' => 'thumbnail', 'title' => 'Foto'],
            ['data' => 'sku', 'title' => 'SKU'],
            ['data' => 'attribute_set_id', 'title' => 'Conjunto'],
            ['data' => 'name', 'title' => 'Nome'],
            ['data' => 'price', 'title' => 'Preço'],
            ['data' => 'channels', 'title' => 'Canais'],
            ['data' => 'status', 'title' => 'Status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'produtos-' . time();
    }
}
