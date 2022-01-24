<?php

namespace Dcodegroup\LaravelMyobEmployee;

use Dcodegroup\LaravelMyobOauth\MyobService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use XeroPHP\Application;
use XeroPHP\Models\PayrollAU\Employee;

class BaseMyobEmployeeService extends MyobService
{
    public function __construct(Application $myobClient)
    {
        parent::__construct($myobClient);
    }

    public function getEmployeeByEmail(string $email)
    {
        return $this->searchModel(Employee::class, [
            'Email' => urlencode($email),
        ]);
    }

    public function syncXeroEmployee(Model $user)
    {
        try {
            $employee = $this->getEmployeeByEmail($user->email);

            if ($employee instanceof Employee) {
                $user->xero_employee_id = $employee->getEmployeeID();
                $user->xero_default_earnings_rate_id = $employee->getOrdinaryEarningsRateID();
                $user->xero_default_payroll_calendar_id = $employee->getPayrollCalendarID();
                $user->save();
            } else {
                // not found so clear what is stored
                logger('employee not found with email: ' . $user->email);
                $user->update([
                                  'myob_employee_id' => null,
                              ]);
            }
        } catch (Exception $e) {
            Log::error('Employee not found in myob syncXeroEmployee error: ' . $e->getMessage());
            report($e);

            return false;
        }

        return true;
    }
}
