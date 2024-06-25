<?php

namespace Modules\WorkLocations\Repositories;

use Modules\WorkLocations\App\Http\Resources\ShiftsResource;
use Modules\WorkLocations\App\Interfaces\WorkLocationRepositoryIntrface;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;
use Modules\WorkLocations\App\Models\WorkLocation;
use Modules\WorkLocations\App\Http\Resources\WorkLocationResource;

class WorkLocationRepository implements WorkLocationRepositoryIntrface
{

    protected $model;

    public function __construct(WorkLocation $model)
    {
        $this->model = $model;
    }


    public function index($request)
    {
        $rows = $this->model
            ->whereNULL('deleted_at')
            ->paginate($request['paginate'] ?? 10);

        return [
            'rows'          => WorkLocationResource::collection($rows),
            'paginate'      => Helper::paginate($rows),

        ];
    }

    public function createOrUpdate($request, $id = Null)
    {
        try {
            $row    = (isset($id)) ? $this->model::find(decrypt($id)) : new $this->model;
            $row->name        = $request['name'] ?? NULL;
            $row->latitude  = $request['latitude'] ?? NULL;
            $row->longitude    = $request['longitude'] ?? NULL;
            $row->save();
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * get single resource.
     * @param string enrcypt $id
     * @return array
     */
    public function find($id): array
    {
        $row = $this->model
            ->where('id', decrypt($id))
            ->whereNULL('deleted_at')
            ->first();

        return [
            'row' => new WorkLocationResource($row)
        ];
    }

    /**
     * destroy single resource.
     * @param string enrcypt $id
     * @return bool|string
     */
    public function destroy($id)
    {
        try {
            $this->model->where('id', decrypt($id))->update(['deleted_at' => Carbon::now()]);
            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
