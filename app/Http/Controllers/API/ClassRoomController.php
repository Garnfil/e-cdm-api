<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassRoom\StoreRequest;
use App\Models\Classroom;
use App\Services\ExceptionHandlerService;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassRoomController extends Controller
{
    private $exceptionHandler;

    public function __construct(ExceptionHandlerService $exceptionHandlerService)
    {
        $this->exceptionHandler = $exceptionHandlerService;
    }

    public function getAll(Request $request) {}

    public function get(Request $request)
    {
        $classes = Classroom::where('status', 'active')->get();

        return response()->json([
            'status' => 'success',
            'classes' => $classes,
        ]);
    }

    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();

            $classCode = Str::random(6);
            $class = Classroom::create(array_merge($data, ['class_code' => $classCode, 'status' => 'active']));

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Class Created Successfully',
                'class' => $class,
            ]);

        } catch (Exception $exception) {
            DB::rollBack();

            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $class = ClassRoom::where('id', $request->id)->firstOrFail();

            $class->update($data);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Class Updated Successfully',
                'class' => $class,
            ]);

        } catch (Exception $exception) {
            DB::rollBack();

            return $this->exceptionHandler->__generateExceptionResponse($exception);
        }
    }

    public function updateCoverPhoto(Request $request) {}

    public function destroy(Request $request) {}
}
