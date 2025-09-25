<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
	<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
	<meta name="author" content="Dreams Technologies">
	<meta name="robots" content="index, follow">

    <title>Payslip Print</title>

    	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/admin/assets/img/favicon.png') }}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/admin/assets/img/apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;&display=swap" rel="stylesheet">

<style>
    html,body{
        font-family: "Nunito", sans-serif;
    }

    .page-break {
        page-break-after: always;
    }

    header {
        position: fixed;
        top: -100px;
        left: 0;
        right: 0;
        height: 80px;
        text-align: center;
        line-height: 20px;
    }
    @page {
            margin: 60px 40px 80px 40px; /* top, right, bottom, left */
        }
    @media print {
        .no-print { display: none; }
    }
    footer {
        position: fixed;
        bottom: -60px;
        left: 0;
        right: 0;
        height: 50px;
        text-align: center;
        font-size: 12px;
        color: gray;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #444;
        padding: 8px;
        font-size: 12px;
    }

    table th {
        background: #f2f2f2;
    }
    .fs-10 {
        font-size: 0.625rem !important;
    }
    .badge {
        padding: 0.35rem 0.45rem;
        text-transform: capitalize;
        font-weight: 500;
        letter-spacing: 0.5px;
        border-radius: 5px;
    }
    .bg-success {
        background-color: #3EB780 !important;
        color: #ffffff;
    }
    .bg-danger {
        background-color: #EA5455 !important;
        color: #ffffff;
    }
</style>

</head>

@php
    use NumberToWords\NumberToWords;
    $numberToWords = new NumberToWords();
    $numberTransformer = $numberToWords->getNumberTransformer('en');
@endphp

<body onload="window.print()" style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f9f9f9;">

    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border:1px solid #ddd; background:#ffffff;">

        <!-- Footer -->
        <tr>
            <td align="center" bgcolor="#f5f5f5" style="padding:15px; font-size:12px; color:#666;">
                <img src="{{ asset('public/admin/assets/img/logo.svg') }}" width="130" alt="logo">
                <p>Dreams POS</p>
                <p>81, Randall Drive, Hornchurch, RM126TA</p>
            </td>
        </tr>

      <!-- Header -->
      <tr>
        <td align="center" bgcolor="#f5f5f5" style="padding:20px; font-size:18px; font-weight:bold; color:#333;">
          Payslip for the Month of {{ date('M Y', strtotime($payroll->updated_at)) }}
        </td>
      </tr>
  
      <!-- Employee Info -->
      <tr>
        <td style="padding:20px; font-size:14px; color:#333;">
          <p><strong>Employee Name:</strong>{{ $payroll->first_name . ' ' . $payroll->last_name }}</p>
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
    </table>


    <script>
        window.onafterprint = function() {
            // Redirect after printing/canceling print
            window.location.href = "{{ route('admin.hrm.payroll.payslip', $payroll->id) }}";
        };
    </script>
  
  </body>
</html>

