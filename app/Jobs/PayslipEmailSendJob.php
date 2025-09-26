<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\PayslipEmailSend;
use App\Models\Payroll;
use Illuminate\Support\Facades\Mail;

class PayslipEmailSendJob implements ShouldQueue
{
    use Queueable;

    public $id;
    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->id      = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {        $payroll = Payroll::leftJoin('employees', 'employees.id', 'payrolls.employee_id')
                ->leftJoin('countries', 'countries.id', 'employees.country_id')
                ->leftJoin('designations', 'designations.id', 'employees.designation_id')
                ->select('payrolls.*', 'employees.first_name', 'employees.last_name', 'employees.email', 'employees.employee_code', 'employees.image', 'designations.designation', 'countries.country_name')
                ->where('payrolls.id', $this->id)
                ->first();

            $total_earnings = $payroll->basic_salary + $payroll->hra_allow + $payroll->conveyance + $payroll->medical_allow + $payroll->bonus;

            $total_deductions = $payroll->provident_fund + $payroll->professional_tax + $payroll->tds + $payroll->loan_others;

            $net_salary = $total_earnings - $total_deductions;

        Mail::to('hnazmul748@gmail.com')->send(new PayslipEmailSend($payroll, $total_earnings, $total_deductions,  $net_salary));
    }
}
