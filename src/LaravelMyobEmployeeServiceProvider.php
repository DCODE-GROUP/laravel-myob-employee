<?php

namespace Dcodegroup\LaravelMyobEmployee;

use Dcodegroup\LaravelMyobEmployee\Commands\DefaultUserEarningRatesCommand;
use Dcodegroup\LaravelMyobEmployee\Commands\InstallCommand;
use Dcodegroup\LaravelMyobEmployee\Observers\MyobEmployeeObserver;
use Dcodegroup\LaravelMyobOauth\Provider\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LaravelMyobEmployeeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->offerPublishing();
        $this->registerCommands();

        $employeeClass = config('laravel-myob-employee.employee_model');
        $employeeClass::observe(new MyobEmployeeObserver);

        $this->registerRoutes();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-myob-employee.php', 'laravel-myob-employee');

        $this->publishes([__DIR__.'/../config/laravel-myob-employee.php' => config_path('laravel-myob-employee.php')], 'laravel-myob-employee-config');

        $this->app->bind(BaseMyobEmployeeService::class, function () {
            return new BaseMyobEmployeeService(resolve(Application::class));
        });
    }

    protected function offerPublishing()
    {
        $this->publishes([__DIR__.'/../config/laravel-myob-employee.php' => config_path('laravel-myob-employee.php')], 'laravel-xero-employee-config');

        if (Schema::hasTable('users') &&
            ! Schema::hasColumns('users', [
                'myob_employee_id',
                'myob_employee_payroll_details_id',
                'myob_employee_payment_details_id',
                'myob_employee_standard_pay_id',
            ])) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__.'/../database/migrations/add_myob_employee_fields_to_users_table.stub.php' => database_path('migrations/'.$timestamp.'_add_myob_employee_fields_to_users_table.php'),
            ], 'laravel-myob-employee-migrations');
        }
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                //DefaultUserEarningRatesCommand::class,
            ]);
        }
    }

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => config('laravel-myob-employee.path'),
            'as' => Str::slug(config('laravel-myob-employee.path'), '_').'.',
            'middleware' => config('laravel-myob-employee.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/laravel_myob_employee.php');
        });
    }
}
