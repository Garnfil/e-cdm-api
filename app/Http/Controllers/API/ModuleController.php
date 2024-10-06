<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Module\ModuleRequest;
use App\Models\Module;
use Illuminate\Http\Request;

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
        $modules = Module::where('class_id', $class_id)->get();

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
        $module = Module::findOrFail($id);

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
}
