<?php

namespace App\Console\Commands;

use App\Models\Application;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;

class ApplyAvgPromise extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'avg:apply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Applies the AVG "statement": remove data older than the configured moment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = (int) config('kik.avg.retention.count');
        $unit = config('kik.avg.retention.unit');

        $interval = CarbonInterval::$unit($count);
        // Get the current date and subtract the configured count + unit.
        $date = Carbon::now()->sub($interval);

        Application::withTrashed()
            ->where(function ($query) {
                // All archived listings regardless of whether they're soft deleted or not.
                // All deleted listings that are not hired.
                $query->where('status_id', config('status.archive_status_id'))
                    ->orWhere(fn ($q) => $q->where('status_id', '!=', 9)->whereNotNull('deleted_at'));
            })->where('created_at', '<', $date)
            ->forceDelete();
    }
}
