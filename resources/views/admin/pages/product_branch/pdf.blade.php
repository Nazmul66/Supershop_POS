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

    <title>Branch Wise Product PDF</title>

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
        border-spacing: 0;
    }

    table th, table td {
        border: 1px solid #444;
        padding: 8px;
        font-size: 9px !important;
    }

    table th {
        background: #f2f2f2;
    }
    table th td,
    table tr td{
        padding: 2px 8px;
        line-height: 1.1;
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
    .mb-1{
        margin-bottom: 4px;
    }
    .mb-0{
        margin-bottom: 0px;
    }
    .fw-semibold{
        font-weight: 600;
    }
    
    .fw-bold{
        font-weight: 700;
    }
</style>

{{-- Active sidebar --}}
@section('category', 'active')

</head>

<body>

    <header>
        <h2>Branch Wise Product List</h2>
        <p>Generated on: {{ date('d-m-Y H:i:A') }}</p>
    </header>

    <footer>
        <p style="text-align: center;">© {{ date('Y') }} ShadhinDeal</p>
    </footer>

    <main>
        <table>
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Product Name</th>
                    <th>Branch Name</th>
                    <th>Product Bio</th>
                    <th>Discount Bio</th>
                    <th>Created By</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productBranches as $index => $row)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td style="width: 120px;">
                            <table>
                                <tr>
                                    <td style="width: 45px; border: 1px solid transparent; padding: 0px;">
                                        <img src={{ asset($row->thumb_image) }} alt="" style="width: 45px;">
                                    </td>
                                    <td style="border: 1px solid transparent; padding: 0px;">
                                        <p class="text-dark">{{ $row->name }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td>
                            <p class="text-dark">{{ $row->branch_name }}</p>
                        </td>

                        <td>
                            @php
                                $symbol = match ($row->discount_type) {
                                    'fixed' => 'BDT',
                                    'percent' => '%',
                                    default => '',
                                };
                            @endphp
                            <div class="">
                                <p class="mb-1"><span class="text-dark fw-bold">Quantity: </span>{{ $row->qty }} Pcs</p>
                                <p class="mb-1"><span class="text-dark fw-bold">Alert Qty: </span>{{ $row->alert_qty }} Pcs</p>
                                <p class="mb-0"><span class="text-dark fw-bold">MRP:</span> {{ $row->selling_price }}/- BDT</p>

                            </div>
                        </td>


                        <td>
                            @php
                                $dates = explode(' - ', $row->discount_date);
                            @endphp
                            @if( !empty($row->discount_date) )
                                <p class="mb-1"><span class="text-dark fw-bold">Type: </span>{{ Str::title($row->discount_type) }}</p>
                                <p class="mb-1"><span class="text-dark fw-bold">Value: </span>{{ $row->discount_value.' '. $symbol }}</p>

                                <p class="mb-1"><span class="text-dark fw-bold">Start:</span>{{ trim($dates[0] ?? null) }}</p>
                                <p class="mb-1"><span class="text-dark fw-bold">End: </span>{{ trim($dates[1] ?? null) }}</p>
                            @endif
                        </td>

                        @php
                            $adminName = \App\Models\Admin::find($row->created_by)?->name ?? 'Unknown';
                        @endphp
                        <td>
                            <div>
                                <p class="text-dark fw-bold">{{ $adminName }}</p>
                                <p class="mb-1"><span class="text-dark fw-bold">Date: </span>{{ date('d F, Y H:i:s A', strtotime($row->created_at)) }}</p>
                            </div>
                        </td>
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

