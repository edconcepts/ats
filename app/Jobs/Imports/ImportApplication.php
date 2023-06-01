<?php

namespace App\Jobs\Imports;

use App\Actions\ImportAction;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
            public string $url ,
            public array $pattern,
        )
    {}

    /**
     * Execute the job.
     */
    public function handle(ImportAction $importAction): void
    {
        $importedData = $importAction->execute(new Application(), $this->url, $this->pattern);
    }
}
