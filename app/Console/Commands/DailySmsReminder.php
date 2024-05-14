<?php

namespace App\Console\Commands;

use App\Models\Interview;
use App\Notifications\InterviewReminderNotification;
use App\Notifications\InterviewScheduledNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class DailySmsReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-sms-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $interviews = Interview::with(['storeManagerTimeSlot', 'application.vacancy.location'])->whereRelation('storeManagerTimeSlot', 'start', 'LIKE', now()->format('Y-m-d') . "%")->get();

        foreach ($interviews as $interview) {
            $message = "Goedemorgen, vandaag heb je een gesprek bij KiK " . $interview->application->vacancy->location->name . " om " . \Illuminate\Support\Carbon::createFromTimeString($interview->storeManagerTimeSlot->start)->format('H:i') . " met " . $interview->application->vacancy->location->manager->name . ". Tot dan!";
            $this->info($message);
            $interview->application
                ->notify(new InterviewReminderNotification($interview->application, $message));
        }
    }
}
