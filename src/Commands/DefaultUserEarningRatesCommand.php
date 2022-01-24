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
    protected $signature = 'laravel-xero-employee:assign-default-earning-rates';

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
        User::whereNull('xero_default_payroll_calendar_id')->update(['xero_default_payroll_calendar_id' => Configuration::byKey('xero_default_payroll_calendar')->get()->pluck('value')->first()]);
        User::whereNull('xero_default_earnings_rate_id')->update(['xero_default_earnings_rate_id' => Configuration::byKey('xero_default_ordinary_earnings_rate_id')->get()->pluck('value')->first()]);
        User::whereNull('xero_time_and_a_half_earnings_rate_id')->update(['xero_time_and_a_half_earnings_rate_id' => Configuration::byKey('xero_default_time_and_a_half')->get()->pluck('value')->first()]);
        User::whereNull('xero_double_time_earnings_rate_id')->update(['xero_double_time_earnings_rate_id' => Configuration::byKey('xero_default_double_time')->get()->pluck('value')->first()]);
    }
}
