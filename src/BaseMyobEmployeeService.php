<?php

namespace Dcodegroup\LaravelMyobEmployee;

use Dcodegroup\LaravelMyobOauth\MyobService;
use Dcodegroup\LaravelMyobOauth\Provider\Application;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class BaseMyobEmployeeService extends MyobService
{
    public function __construct(Application $myobClient)
    {
        parent::__construct($myobClient);
    }

    public function getEmployeeByEmail(string $email): array|bool
    {
        $result = $this->myobClient->fetchFirst("/Contact/Employee?\$filter=Addresses/any(x: x/Email eq '".urlencode($email)."')");

        if (is_null($result)) {
            return false;
        }

        return $result;
    }

    public function syncMyobEmployee(Model $user)
    {
        try {
            $data = $this->getEmployeeByEmail($user->email);

            if (is_array($data)) {
                $user->myob_employee_id = data_get($data, 'UID');
                $user->myob_employee_payroll_details_id = data_get($data, 'EmployeePayrollDetails.UID');
                $user->myob_employee_payment_details_id = data_get($data, 'EmployeePaymentDetails.UID');
                $user->myob_employee_standard_pay_id = data_get($data, 'EmployeeStandardPay.UID');
                $user->save();
            } else {
                // not found so clear what is stored
                //logger('employee not found with email: '.$user->email);
                $user->update([
                    'myob_employee_id' => null,
                    'myob_employee_payroll_details_id' => null,
                    'myob_employee_payment_details_id' => null,
                    'myob_employee_standard_pay_id' => null,
                    // might need the other fields here
                ]);
            }
        } catch (Exception $e) {
            Log::error('Employee not found in MYOB syncMyobEmployee error: '.$e->getMessage());
            report($e);

            return false;
        }

        return true;
    }
}
