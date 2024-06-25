<?php

namespace Modules\Employees\Repositories;

use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Support\Carbon;
use Modules\Employees\App\Http\Resources\EmployeeResource;
use Modules\Employees\App\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository implements EmployeeRepositoryInterface
{

    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function index($request)
    {
        $rows = $this->model
            ->whereNULL('deleted_at')
            ->paginate($request['paginate'] ?? 10);

        return [
            'rows'          => EmployeeResource::collection($rows),
            'paginate'      => Helper::paginate($rows),

        ];
    }

    public function createOrUpdate($request, $id = Null)
    {
        try {
            $row    = (isset($id)) ? $this->model::find(decrypt($id)) : new $this->model;

            $row->name       = $request['name'] ?? NULL;
            $row->email      = $request['email'] ?? NULL;
            $row->password   = Hash::make($request['password']) ?? NULL;
            $row->phone      = $request['phone'] ?? NULL;
            $row->position   = $request['position'] ?? NULL;
            $row->shift_id   = $request['shift_id'] ?? NULL;
            $row->work_location_id    = $request['work_location_id'] ?? NULL;
            $row->salary     = $request['salary'] ?? NULL;
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
            'row' => new EmployeeResource($row)
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
