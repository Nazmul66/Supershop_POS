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

    <title>Create PDF</title>

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
            margin: 120px 40px 80px 40px; /* top, right, bottom, left */
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

{{-- Active sidebar --}}
@section('brands', 'active')

</head>

<body>
    
    <header>
        <h2>Brands List</h2>
        <p>Generated on: {{ date('d-m-Y H:i:A') }}</p>
    </header>

    <footer>
        <p style="text-align: center;">© {{ date('Y') }} ShadhinDeal</p>
    </footer>

    <main>
        <table>
            <thead>
                <tr>
                    <th>Employee Code</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Email</th>
                    <th>Total Earnings</th>
                    <th>Total Deductions</th>
                    <th>Salary</th>
                    <th>Create Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $index => $row)
                    <tr>
                        <td>{{ $row->employee_code }}</td>
                        <td>
                            @if ( !empty($row->image) )
                                <img src="{{ url($row->image) }}" alt="" style="width: 70px;">
                            @endif
                        </td>
                        <td>{{ $row->first_name . ' ' . $row->last_name }}</td>
                        <td>{{ $row->designation }}</td>
                        <td>{{ $row->email }}</td>
                        @php
                            $total_earnings = $row->basic_salary + $row->hra_allow + $row->conveyance + $row->medical_allow + $row->bonus;

                            $total_deductions = $row->provident_fund + $row->professional_tax + $row->tds + $row->loan_others;
                        @endphp
                        <td>${{ $total_earnings }}</td>
                        <td>${{ $total_deductions }}</td>
                        <td>${{ $total_earnings - $total_deductions }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>
                            @if ( $row->status == 1 )
                                <span class="badge bg-success fw-medium fs-10">Active</span>
                            @else
                                <span class="badge bg-danger fw-medium fs-10">Deactive</span>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </main>


</body>
</html>

