<?php

namespace Dcodegroup\LaravelMyobEmployee\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-myob-employee:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Laravel MYOB Employee resources';

    /**
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Laravel MYOB Employee Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-myob-employee-config']);

        $this->comment('Publishing Laravel MYOB Employee Migrations');
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-myob-employee-migrations']);

        $this->info('Laravel MYOB Employee scaffolding installed successfully.');
    }
}
