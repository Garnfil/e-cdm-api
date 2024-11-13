<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FingerprintService;

class FingerprintController extends Controller
{
    protected $fingerprintService;

    // public function __construct(FingerprintService $fingerprintService)
    // {
    //     $this->fingerprintService = $fingerprintService;
    // }

    public function enroll(Request $request)
    {
        dd($request->all());
        $data = $request->input('data');

        if (!$data) {
            return response()->json("error! no data provided in post request", 400);
        }

        $userData = json_decode($data);

        $indexFingerStringArray = $userData->index_finger;
        $middleFingerStringArray = $userData->middle_finger;

        $enrolledIndexFinger = $this->fingerprintService->enrollFingerprint($indexFingerStringArray);
        $enrolledMiddleFinger = $this->fingerprintService->enrollFingerprint($middleFingerStringArray);

        if ($enrolledIndexFinger !== "enrollment failed" && $enrolledMiddleFinger !== "enrollment failed") {
            return response()->json([
                "enrolled_index_finger" => $enrolledIndexFinger,
                "enrolled_middle_finger" => $enrolledMiddleFinger
            ]);
        }

        return response()->json("enrollment failed!", 500);
    }
}
