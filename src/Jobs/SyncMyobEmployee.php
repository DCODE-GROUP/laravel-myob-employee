<?php

namespace Dcodegroup\LaravelMyobEmployee\Jobs;

use Dcodegroup\LaravelMyobEmployee\BaseMyobEmployeeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncMyobEmployee implements ShouldQueue
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
    public function __construct(
        protected Model $model
    ) {
        $this->queue = config('laravel-myob-employee.queue');
    }

    public function handle()
    {
        $service = resolve(BaseMyobEmployeeService::class);
        $service->syncMyobEmployee($this->model);
    }
}
