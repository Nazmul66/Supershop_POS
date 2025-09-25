<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Payslip</title>
</head>

@php
    use NumberToWords\NumberToWords;
    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getNumberTransformer('en');
@endphp

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f9f9f9;">

  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border:1px solid #ddd; background:#ffffff;">
    <!-- Header -->
    <tr>
      <td align="center" bgcolor="#f5f5f5" style="padding:20px; font-size:18px; font-weight:bold; color:#333;">
        Payslip for the Month of {{ date('M Y', strtotime($payroll->updated_at)) }}
      </td>
    </tr>

    <!-- Employee Info -->
    <tr>
      <td style="padding:20px; font-size:14px; color:#333;">
        <p><strong>Employee Name:</strong>{{ $payroll->first_name Z $payroll->last_name }}</p>
        <p><strong>Employee ID:</strong> {{ $payroll->employee_code }}</p>
        <p><strong>Location:</strong> {{ $payroll->country_name }}</p>
        <p><strong>Pay Period:</strong> {{ date('M Y', strtotime($payroll->updated_at)) }}  ({{ date('h:i A', strtotime($payroll->updated_at)) }})</p>
      </td>
    </tr>

    <!-- Earnings & Deductions -->
    <tr>
      <td style="padding:0 20px 20px 20px;">
        <table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse:collapse; font-size:13px; color:#333;">
          <tr bgcolor="#f5f5f5">
            <th align="left">Earnings</th>
            <th align="left">Amount</th>
            <th align="left">Deductions</th>
            <th align="left">Amount</th>
          </tr>
          <tr>
            <td>Basic Salary</td>
            <td>${{ $payroll->basic_salary }}</td>
            <td>PF</td>
            <td>${{ $payroll->provident_fund }}</td>
          </tr>
          <tr>
            <td>HRA Allowance</td>
            <td>${{ $payroll->hra_allow }}</td>
            <td>Professional Tax</td>
            <td>${{ $payroll->professional_tax }}</td>
          </tr>
          <tr>
            <td>Conveyance</td>
            <td>${{ $payroll->conveyance }}</td>
            <td>TDS</td>
            <td>${{ $payroll->tds }}</td>
          </tr>
          <tr>
            <td>Medical Allowance</td>
            <td>${{ $payroll->medical_allow }}</td>
            <td>Loans & Others</td>
            <td>${{ $payroll->loan_others }}</td>
          </tr>
          <tr>
            <td>Bonus</td>
            <td>${{ $payroll->bonus }}</td>
            <td></td>
            <td></td>
          </tr>
          <tr bgcolor="#f5f5f5" style="font-weight:bold;">
            <td>Total Earnings</td>
            <td>${{ $total_earnings }}</td>
            <td>Total Deductions</td>
            <td>${{ $total_deductions }}</td>
          </tr>
        </table>
      </td>
    </tr>

    <!-- Net Salary -->
    <tr>
      <td style="padding:20px; font-size:14px; color:#333;">
        <p><strong>Net Salary:</strong> ${{ $net_salary }}</p>
        <p><strong>In Words:</strong> {{  ucfirst($numberTransformer->toWords($net_salary)); }} Only</p>
      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td align="center" bgcolor="#f5f5f5" style="padding:15px; font-size:12px; color:#666;">
        Dreams POS<br>
        81, Randall Drive, Hornchurch, RM126TA
      </td>
    </tr>
  </table>

</body>
</html>