<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guardian\StoreRequest;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\StudentGuardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $guardians = Guardian::query();

            return DataTables::of($guardians)
                ->addIndexColumn()
                ->addColumn('fullname', function ($row) {
                    return $row->firstname.' '.$row->latname;
                })
                ->addColumn('actions', function ($row) {
                    return '<div class="btn-group">
                        <a href="'.route('admin.guardians.edit', $row->id).'" class="btn btn-primary btn-sm"><i class="bx bx-edit text-white"></i></a>
                        <a class="btn btn-danger btn-sm"><i class="bx bx-trash text-white"></i></a>
                    </div>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin-page.guardians.index-guardians');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::get();

        return view('admin-page.guardians.create-guardian', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $guardian = Guardian::create(array_merge($data, [
            'phone_number' => '+639'.$request->phone_number,
            'password' => Hash::make($request->password),
        ]));

        foreach ($request->student_ids as $key => $student_id) {
            StudentGuardian::create([
                'student_id' => $student_id,
                'guardian_id' => $guardian->id,
            ]);
        }

        return redirect()->route('admin.guardians.index')->withSuccess('Guardian Added Successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}