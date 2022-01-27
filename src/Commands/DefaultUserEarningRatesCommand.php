<?php

namespace Dcodegroup\LaravelMyobEmployee\Commands;

use App\Models\User;
use Dcodegroup\LaravelConfiguration\Models\Configuration;
use Illuminate\Console\Command;

class DefaultUserEarningRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-myob-employee:assign-default-earning-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates users default earning rate assignments';

    /**
     * @return void
     */
    public function handle()
    {
        User::whereNull('myob_employee_payroll_details_id')->update(['myob_employee_payroll_details_id' => Configuration::byKey('myob_default_employee_payroll_details_id')->get()->pluck('value')->first()]);
        User::whereNull('myob_employee_payment_details_id')->update(['myob_employee_payment_details_id' => Configuration::byKey('myob_default_employee_payment_details_id')->get()->pluck('value')->first()]);
        User::whereNull('myob_employee_standard_pay_id')->update(['myob_employee_standard_pay_id' => Configuration::byKey('myob_default_employee_standard_pay_id')->get()->pluck('value')->first()]);
    }
}
