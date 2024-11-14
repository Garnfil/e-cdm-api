<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRequest;
use App\Models\Admin;
use Hash;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $admins = Admin::query();

            return DataTables::of($admins)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->firstname.' '.$row->lastname;
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="'.route('admin.admins.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm remove-btn" id="'. $row->id .'"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);

        }

        return view('admin-page.admins.index-admins');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-page.admins.create-admin');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $admin = Admin::create(array_merge($data, [
            'password' => Hash::make($request->password),
        ]));

        return redirect()->route('admin.admins.index')->withSuccess('Admin Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin-page.admins.edit-admin', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
