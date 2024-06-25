<?php

namespace Modules\WorkLocations\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\WorkLocations\Repositories\WorkLocationRepository;
use Illuminate\Http\JsonResponse;
use Modules\WorkLocations\App\Http\Requests\StoreRequest;
use Modules\WorkLocations\App\Http\Requests\UpdateRequest;

class WorkLocationsController extends Controller
{
    protected $repository;

    public function __construct(WorkLocationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->repository->index($request->input());
        return response()->json(['data' => $data], 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('worklocations::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $response = $this->repository->createOrUpdate($request->validated());
            if ($response === true) {
                $data = ['message' => trans('location.created')];
                return response()->json(['data' => $data], 201);
            } else {
                $data = ['message' => trans('location.unableToCreate') . $response];
                return response()->json(['data' => $data], 500);
            }
        } catch (\Exception $e) {
            $data = ['message' => trans('location.somethingWentWrong') . $e->getMessage()];
            return response()->json(['data' => $data], 500);
        }
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $data = $this->repository->find($id);
        return response()->json(['data' => $data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('worklocations::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        try {
            $response = $this->repository->createOrUpdate($request->validated(), $id);
            if ($response === true) {
                $data = ['message' => trans('location.updated')];
                return response()->json(['data' => $data], 200);
            } else {
                $data = ['message' => trans('location.unableToUpdate') . $response];
                return response()->json(['data' => $data], 500);
            }
        } catch (\Exception $e) {
            $data = ['message' => trans('location.somethingWentWrong') . $e->getMessage()];
            return response()->json(['data' => $data], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    { {
            try {
                $response = $this->repository->destroy($id);
                if ($response === true) {
                    $data = ['message' => trans('locaation.deleted')];
                    return response()->json(['data' => $data], 200);
                } else {
                    $data = ['message' => trans('location.unableToDelete') . $response];
                    return response()->json(['data' => $data], 500);
                }
            } catch (\Exception $e) {
                $data = ['message' => trans('location.somethingWentWrong') . $e->getMessage()];
                return response()->json(['data' => $data], 500);
            }
        }
    }
}
