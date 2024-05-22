<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IndeedWebhookController extends Controller
{
    public function __invoke()
    {
        Log::info('Indeed webhook called');
        $data = request()->all();

        $application = new Application();

        $random = rand(1000, 10000);

        $application->kik_id = $random;
        $application->name = $data['applicant']['fullName'];
        $application->slug = 'indeed-'.$random;
        $application->title = 'Indeed Sollicitatie #'.$random;
        $application->kik_date = now();
        $application->vacancy_id = $data['job']['jobId'];
        $application->email = $data['applicant']['email'];
        $application->phone_number = $data['applicant']['phoneNumber'];
        $application->status_id = 2;

        $resumeBase64 = $data['applicant']['resume']['file']['data'];
        $resume = base64_decode($resumeBase64);
        $resumeName = $data['applicant']['resume']['file']['fileName'];
        $resumePath = 'resumes/'.time().'-' . $resumeName;
        Storage::disk('public')->put($resumePath, $resume);

        $application->resume = $resumePath;

        $application->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
