<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\ModuleRequest;
use App\Models\ClassModule;
use App\Models\Module;
use App\Models\ModuleAttachment;
use App\Services\ExceptionHandlerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    // Get all modules
    public function getAll()
    {
        $modules = Module::all();

        return response()->json(['status' => 'success', 'modules' => $modules]);
    }

    public function classModules(Request $request, $class_id)
    {
        $module_ids = ClassModule::where('class_id', $class_id)->pluck('module_id')->toArray();
        $modules = Module::whereIn('id', $module_ids)->get();

        return response()->json([
            'status' => 'success',
            'modules' => $modules,

        ]);
    }

    // Create a new module
    public function store(ModuleRequest $request)
    {
        $validatedData = $request->validated();

        $module = Module::create($validatedData);

        return response()->json(['status' => 'success', 'module' => $module], 201);
    }

    // Show a specific module
    public function show($id)
    {
        $module = Module::with('attachments')->findOrFail($id);

        return response()->json(['status' => 'success', 'module' => $module]);
    }

    // Update a module
    public function update(ModuleRequest $request, $id)
    {
        $module = Module::findOrFail($id);

        $validatedData = $request->validated();

        $module->update($validatedData);

        return response()->json(['status' => 'success', 'module' => $module]);
    }

    // Delete a module
    public function destroy($id)
    {
        $module = Module::findOrFail($id);
        $module->delete();

        return response()->json(null, 204);
    }

    public function uploadSingleAttachment(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $module = Module::where('id', $request->module_id)->first();
            if (! $module)
            {
                throw new Exception('Module Not Found', 404);
            }

            if ($request->hasFile('attachment') && $request->attachment_type == ModuleAttachment::ATTACHMENT_TYPE_FILE)
            {
                $attachment = $request->file('attachment');

                $path_extension = $attachment->getClientOriginalExtension();

                if (! in_array($path_extension, ['pdf', 'png', 'jpg', 'jpeg', 'webp']))
                {
                    throw new Exception('The requested attachment does not correspond to a recognized file type. The following file types are supported: pdf, png, jpg, jpeg, and webp.', 422);
                }

                $attachment_name = Str::random(7) . '-' . time() . '.' . $attachment->getClientOriginalExtension();

                $file_path = 'modules/';
                Storage::disk('public')->putFileAs($file_path, $attachment, $attachment_name);
            } else
            {
                $attachment_name = $request->attachment;
            }

            ModuleAttachment::create([
                'module_id' => $module->id,
                'attachment_name' => $attachment_name,
                'attachment_type' => $request->attachment_type,
                'status' => 'active',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'School Work Attachment Added Successfully',
            ]);

        } catch (Exception $exception)
        {
            DB::rollBack();
            $exceptionHandlerService = new ExceptionHandlerService;

            return $exceptionHandlerService->__generateExceptionResponse($exception);
        }

    }
}
