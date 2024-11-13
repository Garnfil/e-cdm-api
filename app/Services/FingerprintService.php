<?php
namespace App\Services;

class FingerprintService
{
    protected $client;

    public function __construct()
    {
        // Initialize the FingerPrintClient just as it is in the original code
        require_once(__DIR__ . '/../../vendor/autoload.php'); // Adjust path as needed

        $this->client = new FingerPrintClient("fingerprint_engine:4134", [
            "credentials" => ChannelCredentials::createInsecure(),
        ]);
    }

    public function enrollFingerprint(array $preFmdStringArray)
    {
        $enrollmentRequest = new EnrollmentRequest();
        $preEnrolledFmds = [];

        foreach ($preFmdStringArray as $preRegFmd) {
            $preEnrollmentFmd = new PreEnrolledFMD();
            $preEnrollmentFmd->setBase64PreEnrolledFMD($preRegFmd);
            $preEnrolledFmds[] = $preEnrollmentFmd;
        }

        $enrollmentRequest->setFmdCandidates($preEnrolledFmds);

        list($enrolledFmd, $status) = $this->client->EnrollFingerprint($enrollmentRequest)->wait();

        if ($status->code === STATUS_OK) {
            return $enrolledFmd->getBase64EnrolledFMD();
        }

        return "enrollment failed";
    }

    public function checkDuplicate($preFmdString, $enrolledFmdStringList)
    {
        $preEnrolledFmd = new PreEnrolledFMD(['base64PreEnrolledFMD' => $preFmdString]);
        $verificationRequest = new VerificationRequest(['targetFMD' => $preEnrolledFmd]);
        $enrolledFmds = [];

        foreach ($enrolledFmdStringList as $hand) {
            $enrolledFmds[] = new EnrolledFMD(['base64EnrolledFMD' => $hand->indexfinger]);
            $enrolledFmds[] = new EnrolledFMD(['base64EnrolledFMD' => $hand->middlefinger]);
        }

        $verificationRequest->setFmdCandidates($enrolledFmds);

        list($response, $status) = $this->client->CheckDuplicate($verificationRequest)->wait();
        return $response->getIsDuplicate();
    }

    public function verifyFingerprint($preEnrolledFmdString, $enrolledFmdString)
    {
        $preEnrolledFmd = new PreEnrolledFMD();
        $preEnrolledFmd->setBase64PreEnrolledFMD($preEnrolledFmdString);

        $enrolledCandFmd = new EnrolledFMD();
        $enrolledCandFmd->setBase64EnrolledFMD($enrolledFmdString);

        $verificationRequest = new VerificationRequest(['targetFMD' => $preEnrolledFmd]);
        $verificationRequest->setFmdCandidates([$enrolledCandFmd]);

        list($verificationResponse, $status) = $this->client->VerifyFingerprint($verificationRequest)->wait();

        if ($status->code === STATUS_OK) {
            return $verificationResponse->getMatch();
        }

        return "verification failed";
    }
}