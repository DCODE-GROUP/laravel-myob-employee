<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMyobEmployeeFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->after('password', function ($table) {
                $table->uuid('myob_employee_id')->nullable();
                $table->uuid('myob_employee_payroll_details_id')->nullable();
                $table->uuid('myob_employee_payment_details_id')->nullable();
                $table->uuid('myob_employee_standard_pay_id')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                                   'myob_employee_id',
                                   'myob_employee_payroll_details_id',
                                   'myob_employee_payment_details_id',
                                   'myob_employee_standard_pay_id',
                               ]);
        });
    }
}
