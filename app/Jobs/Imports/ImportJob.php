<?php

namespace App\Jobs\Imports;

use App\Actions\ImportAction;
use App\Contracts\Importable;
use App\Models\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Create a new job instance.
     */
    public function __construct(
            public Importable $importable,
            public string $url ,
            public Array $pattern,
        )
    {}

    /**
     * Execute the job.
     */
    public function handle(ImportAction $importAction): void
    {
        $importedData = $importAction->execute($this->importable,$this->url, $this->pattern);
    }
}
