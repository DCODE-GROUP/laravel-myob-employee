# Laravel MYOB Timesheet Sync

This package provides the standard MYOB functionality for syncing MYOB Employee ID with users and assigning pay rates to
users.

## Installation

You can install the package via composer:

```bash
composer require dcodegroup/laravel-myob-employee
```

Then run the install command.

```bash
php artsian laravel-myob-employee:install
```

This will publish the configuration and migrations file

Run the migrations

```bash
php artsian migrate
```

## Configuration

After running install the following fields will be added to the users table.

* myob_employee_id
* myob_employee_payroll_details_id
* myob_employee_payment_details_id
* myob_employee_standard_pay_id

You will need to add these fields to your fillable array within the `User::class` model

```php
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
                   'myob_employee_id',
                   'myob_employee_payroll_details_id',
                   'myob_employee_payment_details_id',
                   'myob_employee_standard_pay_id',
                   ...
    ];

```

You also need to add the following interface to the `User::class` model.

```php 

use Dcodegroup\LaravelMyobEmployee\Contracts\MyobEmployeeUserMappings;

class User extends Authenticatable implements MyobEmployeeUserMappings
{
    ...

```

You should then implement the methods defined in the contract.
eg Like below but what ever your using

```php

  public function getMyobEmployeeNameAttribute(): string
  {
    return $this->name;
    //return $this->first_name . ' ' . $this->last_name;
    //return $this->prefered_name;
  }

```

[//]: # (The assumption is you have already synced the payroll details from the [dcodegroup/laravel-xero-payroll-au]&#40;https://github.com/dcodegroup/laravel-xero-payroll-au&#41;.)

[//]: # (There is a second command you can use to automatically populate the fields added for earnings rate to default to those you have already configured within  [dcodegroup/laravel-xero-payroll-au]&#40;https://github.com/dcodegroup/laravel-xero-payroll-au&#41;. )

[//]: # (You can run this multiple times as you get new users as it will only update users that have no values.)

You should add the following trait to the Users model.

```php
class User extends Authenticatable
{
    use UsesMyobEmployee;

```

This package provides a route that can be used to provide an endpoint to dispatch the SyncMyobEmployee job.

[example.com/myob-employee/{user}] xero_employee.sync Please see the config file if you wish to customise the route. This will dispatch the job for the user and sync them to your application.

