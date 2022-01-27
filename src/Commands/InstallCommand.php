<?php

namespace Dcodegroup\LaravelMyobEmployee\Commands;

use Dcodegroup\LaravelConfiguration\Models\Configuration;
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

    protected string $configurationGroup = 'laravel-myob-employee-config';

    /**
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Laravel MYOB Employee Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-myob-employee-config']);

        $this->comment('Publishing Laravel MYOB Employee Migrations');
        $this->callSilent('vendor:publish', ['--tag' => 'laravel-myob-employee-migrations']);

        if (Configuration::byKey('myob_default_employee_payroll_details_id')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'MYOB default payroll details ID',
                                      'key' => 'myob_default_employee_payroll_details_id',
                                  ]);
        }

        if (Configuration::byKey('myob_default_employee_payment_details_id')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'MYOB default payment details ID',
                                      'key' => 'myob_default_employee_payment_details_id',
                                  ]);
        }

        if (Configuration::byKey('myob_default_employee_standard_pay_id')->doesntExist()) {
            Configuration::create([
                                      'group' => $this->configurationGroup,
                                      'name' => 'MYOB default standard pay ID',
                                      'key' => 'myob_default_employee_standard_pay_id',
                                  ]);
        }

        $this->info('Laravel MYOB Employee Configuration variables installed.');

        $this->info('Laravel MYOB Employee scaffolding installed successfully.');
    }
}
