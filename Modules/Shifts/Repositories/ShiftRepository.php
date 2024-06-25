<?php

namespace Modules\Shifts\Repositories;

use Modules\Shifts\App\Http\Resources\ShiftsResource;
use Modules\Shifts\App\Models\Shift;
use Modules\Shifts\App\Interfaces\ShiftRepositoryInterface;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;

class ShiftRepository implements ShiftRepositoryInterface
{

    protected $model;

    public function __construct(Shift $model)
    {
        $this->model = $model;
    }


    public function index($request)
    {
        $rows = $this->model
            ->whereNULL('deleted_at')
            ->paginate($request['paginate'] ?? 10);

        return [
            'rows'          => ShiftsResource::collection($rows),
            'paginate'      => Helper::paginate($rows),

        ];
    }

    public function createOrUpdate($request, $id = Null)
    {
        try {
            $row    = (isset($id)) ? $this->model::find(decrypt($id)) : new $this->model;
            $row->name        = $request['name'] ?? NULL;
            $row->start_time  = $request['start_time'] ?? NULL;
            $row->end_time    = $request['end_time'] ?? NULL;
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
            'row' => new ShiftsResource($row)
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
