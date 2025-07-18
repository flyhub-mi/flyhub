<?php

namespace App\Http\Controllers\Tenant;

use App\DataTables\Tenant\SyncLogDataTable;
use App\Http\Controllers\BaseController;

class SyncLogController extends BaseController
{
    public function index(SyncLogDataTable $syncLogDataTable)
    {
        return $syncLogDataTable->render('tenant.settings.sync-logs.index');
    }
}
