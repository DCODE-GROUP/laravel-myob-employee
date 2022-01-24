<?php

namespace Dcodegroup\LaravelMyobEmployee\Observers;

use Dcodegroup\LaravelConfiguration\Models\Configuration;
use Dcodegroup\LaravelMyobEmployee\Jobs\SyncMyobEmployee;
use Illuminate\Database\Eloquent\Model;

class MyobEmployeeObserver
{
    public function created(Model $model)
    {
        /**
         * Set the default values for the xero employee fields incase they have not been set
         */
        //Artisan::call('laravel-xero-employee:assign-default-earning-rates');

        $model->update([
                           'xero_default_payroll_calendar_id' => Configuration::byKey('xero_default_payroll_calendar')
                                                                              ->get()
                                                                              ->pluck('value')
                                                                              ->first(),
                           'xero_default_earnings_rate_id' => Configuration::byKey('xero_default_ordinary_earnings_rate_id')
                                                                           ->get()
                                                                           ->pluck('value')
                                                                           ->first(),
                           'xero_time_and_a_half_earnings_rate_id' => Configuration::byKey('xero_default_time_and_a_half')
                                                                                   ->get()
                                                                                   ->pluck('value')
                                                                                   ->first(),
                           'xero_double_time_earnings_rate_id' => Configuration::byKey('xero_default_double_time')
                                                                               ->get()
                                                                               ->pluck('value')
                                                                               ->first(),
                       ]);

        /**
         * Dispatch the job to sync the model with Xero.
         */
        SyncMyobEmployee::dispatch($model);
    }
}
