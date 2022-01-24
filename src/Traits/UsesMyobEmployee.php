<?php

namespace Dcodegroup\LaravelMyobEmployee\Traits;

use Illuminate\Database\Eloquent\Builder;

trait UsesMyobEmployee
{
    public function scopeHasEmptyEmployeeId(Builder $query): Builder
    {
        return $query->whereNull('myob_employee_id');
    }

    public function isValidMyobEmployee(): bool
    {
        return $this->myob_employee_id
            && $this->myob_employee_payroll_details_id
            && $this->myob_employee_payment_details_id
            && $this->myob_employee_standard_pay_id;
    }

    public function scopeHasMyobEmployeeId(Builder $query): Builder
    {
        return $query->whereNotNull('myob_employee_id');
    }

    public function scopeMissingMyobEmployeeId(Builder $query): Builder
    {
        return $query->whereNotNull('myob_employee_id');
    }
}
