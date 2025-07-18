<?php

namespace App\Repositories\Tenant;

use App\Models\Tenant\ChannelSync;
use App\Repositories\BaseRepository;

/**
 * Class ChannelSyncLogRepository
 * @package App\Repositories
 */
class SyncLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = ['code', 'name', 'timezone'];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     */
    public function model()
    {
        return ChannelSync::class;
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param int|string $logId
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allLogResultsQuery($logId, $search = [], $skip = null, $limit = null)
    {
        /** @var ChannelSync $log */
        $log = $this->model::find($logId);
        $query = $log->results()->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!empty($skip)) {
            $query->skip($skip);
        }

        if (!empty($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allLogResults($logId, $search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $query = $this->allLogResultsQuery($logId, $search, $skip, $limit);

        return $query->get($columns);
    }
}
