<?php

namespace Modules\Leaves\Repositories;

use App\Helpers\Helper;
use Illuminate\Support\Carbon;
use Modules\Leaves\App\Http\Resources\LeaveResource;
use Modules\Leaves\App\Interfaces\LeaveRepositoryInterface;
use Modules\Leaves\App\Models\LeaveType;

class LeaveTypeRepository implements LeaveRepositoryInterface
{

    protected $model;

    public function __construct(LeaveType $model)
    {
        $this->model = $model;
    }

    public function index($request)
    {
        $rows = $this->model
            ->whereNULL('deleted_at')
            ->paginate($request['paginate'] ?? 10);

        return [
            'rows'          => LeaveResource::collection($rows),
            'paginate'      => Helper::paginate($rows),

        ];
    }

    public function createOrUpdate($request, $id = Null)
    {
        try {
            $row    = (isset($id)) ? $this->model::find(decrypt($id)) : new $this->model;
            $row->name       = $request['name'] ?? NULL;
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
            'row' => new LeaveResource($row)
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
