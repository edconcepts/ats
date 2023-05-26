<?php

namespace App\Jobs;

use App\Models\Interview;
use App\Models\Status;
use App\Notifications\InterviewEnded;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEndInterviewEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $interviews = Interview::where('end_email_sent', false)->ended()->with('application','StoreManagerTimeSlot.storeManager')->get();

        // TODO: change this to any status you want store_manager to change
        $possibleStatuses = Status::where('id',2)->orWhere('id',8)->get();

        foreach($interviews as $interview)
        {
            $interview->storeManagerTimeSlot->storeManager->notify(new InterviewEnded($interview->application, $possibleStatuses));
            $interview->update(['end_email_sent' => 1]);
        }
    }
}
