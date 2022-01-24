<?php

namespace Dcodegroup\LaravelMyobEmployee\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncAllMyobEmployees implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue = config('laravel-myob-employee.queue');
    }

    public function handle()
    {
        $xeroModelClass = config('laravel-myob-employee.employee_model');

        $models = $xeroModelClass::hasEmptyEmployeeId()->get();

        $models->each(function ($model) {
            SyncMyobEmployee::dispatch($model);
        });
    }
}
