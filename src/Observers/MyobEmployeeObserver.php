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
        //Artisan::call('laravel-myob-employee:assign-default-earning-rates');

        $model->update([
                           'myob_employee_payroll_details_id' => Configuration::byKey('myob_default_employee_payroll_details_id')
                                                                              ->get()
                                                                              ->pluck('value')
                                                                              ->first(),
                           'myob_employee_payment_details_id' => Configuration::byKey('xero_default_ordinary_earnings_rate_id')
                                                                           ->get()
                                                                           ->pluck('value')
                                                                           ->first(),
                           'myob_employee_standard_pay_id' => Configuration::byKey('myob_default_employee_standard_pay_id')
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
