<?php

namespace Modules\Leaves\Repositories;

use Carbon\Carbon;
use App\Helpers\Helper;
use Modules\Leaves\App\Models\LeaveRequest;
use Modules\Leaves\App\Http\Resources\LeaveRequestResource;
use Modules\Leaves\App\Interfaces\LeaveRequestsRepositoryInterface;
use Modules\Leaves\App\Http\Resources\EmployeeLeavesHistoryResource;


class leaveRequestRepository implements LeaveRequestsRepositoryInterface
{
    protected $model;

    public function __construct(LeaveRequest $model)
    {
        $this->model = $model;
    }


    public function index($request)
    {
        $rows = $this->model
            ->whereNULL('deleted_at')
            ->paginate($request['paginate'] ?? 10);

        return [
            'rows'          => LeaveRequestResource::collection($rows),
            'paginate'      => Helper::paginate($rows),

        ];
    }

    public function createOrUpdate($request, $id = Null)
    {
        try {

            $row    = (isset($id)) ? $this->model::find(decrypt($id)) : new $this->model;
            $row->employee_id   =  auth()->user()->id ?? 2;
            $row->leave_type_id = $request['leave_type_id'];
            $row->start_date    = $request['start_date'];
            $row->end_date      = $request['end_date'];
            $row->reason        = $request['reason'] ?? null;
            $row->status        = 'pending';

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
            'row' => new LeaveRequestResource($row)
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


    /**  Mobile*/
    public function findByEmployee($id) // show employee leaves
    {
        $rows = $this->model
            ->whereNULL('deleted_at')
            ->where('employee_id', $id)
            ->paginate($request['paginate'] ?? 10);
        return [
            'rows' =>  EmployeeLeavesHistoryResource::collection($rows)
        ];
    }
}
