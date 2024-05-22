<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psy\Util\Str;

class WerkzoekenWebhookController extends Controller
{
    public function __invoke()
    {
        if ((request()->header('X-Webhook-Token') ?? null) !== "lqPzku4biHyaxQ7ptTEr") {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = request()->all();

        Log::info(print_r($data, true));
        $application = new Application();

        $random = rand(1000, 10000);

        $application->kik_id = $random;
        $application->name = $data['name'];
        $application->slug = 'werkzoeken-'.$random;
        $application->title = 'Werkzoeken Sollicitatie #'.$random;
        $application->kik_date = now();
        $application->vacancy_id = $data['jobId'];
        $application->email = $data['email'];
        $application->phone_number = $data['phoneNumber'];
        $application->status_id = 2;

        $resumeBase64 = $data['cv'];
        $resume = base64_decode($resumeBase64);
        $resumeName = \Illuminate\Support\Str::slug($data['name']).'-cv.pdf';
        $resumePath = 'resumes/'.time().'-' . $resumeName;
        Storage::disk('public')->put($resumePath, $resume);

        $application->resume = $resumePath;

        $application->save();

        return $application->id;
    }
}
