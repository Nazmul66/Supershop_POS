<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Stock Transfer Challan</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('public/admin/assets/css/bootstrap.min.css') }}">

<style>
    body{
        font-family: "Roboto", sans-serif;
        background: #A9A9A9;
    }
    .main_content{
        width: 210mm;
        height: auto;
        margin: 20px auto 0;
        background: #FFF;
        border: 1px solid #000;
        padding: 25px;
        box-shadow: 0px 0px 15px rgba(0,0,0,0.5);
    }
    span{
        display: inline-block;
        font-size: 12px;
    }
    .btn_esc{
        display: inline-block;
        color: red;
        font-size: 12px;
    }
   .a4_main_content{
        height: auto;
        border: 1px dashed #000;
        padding: 5px;
    }
    .light_content{
        font-size: 13px;
        font-weight: 400;
    }
    .heavy_content{
        font-size: 14px;
        font-weight: 700;
        text-align: right;
        margin: 2px 0;
    }
    .signature_by,
    .authorized_by{
        margin: 0;
        border-top: 2px solid #000;
    }
    .table_box{
        padding: 0 10px;
    }
    .table thead tr {
        border-bottom: 2px solid #000;
        border-top: none;
    }
    .table thead tr th,
    .table tbody tr td,
    .table tfoot tr td{
        font-size: 11px;
        border: none;
    }
    .table tfoot tr td:nth-child(2),
    .table tfoot tr td:nth-child(3),
    .table tfoot tr td:nth-child(4),
    .table tfoot tr td:nth-child(5){
        border-top: 2px solid #000 !important;
        font-size: 12px !important;
        font-weight: 700 !important;
    }
    .table>:not(caption)>*>* {
        padding: .15rem .15rem !important;
    }
        

   @media print {
        @page {
            size: A4;
            margin: 2mm;
        }
        .btn_esc,
        .btn-success{
            display: none;
        }
        .main_content{
            width: 210mm;
            height: auto;
            margin: 0 auto 0;
            background: #FFF;
            border: 1px solid #000;
            padding: 25px;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.5);
        }
        .a4_main_content{
            height: auto;
            border: 1px dashed #000;
            padding: 5px;
        }
    }
</style>

</head>
<body>

    <div class="main_content">
        <div class="d-flex align-item-center justify-content-between mb-2">
            <span class="fw-bold btn_esc">( Press ESC to close )</span>
            <button type="button" onclick="printPage()" class="btn btn-sm btn-success">Print</button>
        </div>

        <div class="a4_main_content">
            <div class="d-flex align-item-center justify-content-between">
                <h4 class="fw-bold">Ghorer Bazar</h4>
                <h4 class="fw-bold">Store Transfer Challan</h4>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6">
                    <h6 class="fw-bold">Dhaka</h6>
                    <p class="light_content mb-0">House 5, Road 3, Black B, Rampura Banasree - 1226</p>
                    <p class="light_content mb-1">+880 1332 254136</p>
                    <p class="light_content mb-0">DELIVERY TO: Metro Shewrapara</p>
                    <p class="light_content mb-0">ADDRESS: Shewrapara, Metro Station</p>
                </div>

                <div class="col-lg-6">
                    <p class="heavy_content">CHALLAN# DC10005000011</p>
                    <p class="heavy_content">CHALLAN DATE# 15-Feb-2026</p>
                    <p class="heavy_content">RECEIVE DATE# 15-Feb-2026</p>
                    <p class="heavy_content">REF NO# R100011001000044</p>
                    <p class="heavy_content">TRANSFER BY# Anisur-10766</p>
                </div>
            </div>

            <div class="table_box">
                <div class="table-responsive">
                    <table class="table mb-0 datatables">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>CODE</th>
                                <th>BARCODE</th>
                                <th>Discription</th>
                                <th>Sale Price</th>
                                <th>DEL QTY</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>A000125</td>
                                <td>8941140150236</td>
                                <td>
                                    <div class="">
                                        <p class="mb-0">Sundarban Honey 250gm</p>
                                        <p class="mb-0"> <span class="fw-bold">Vendor:</span> GB Central Warehouse</p>
                                        <p class="mb-0"> <span class="fw-bold">Reason:</span> Damage</p>
                                    </div>
                                </td>
                                <td>625.00</td>
                                <td>10.00</td>
                                <td>10.00</td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>A000128</td>
                                <td>8941140150175</td>
                                <td>
                                    <div class="">
                                        <p class="mb-0">Lichu Flower Honey 250gm</p>
                                        <p class="mb-0"> <span class="fw-bold">Vendor:</span> GB Central Warehouse</p>
                                        <p class="mb-0"> <span class="fw-bold">Reason:</span> Damage</p>
                                    </div>
                                </td>
                                <td>300.00</td>
                                <td>10.00</td>
                                <td>10.00</td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>A000188</td>
                                <td>8942240130050</td>
                                <td>
                                    <div class="">
                                        <p class="mb-0">Egyptian Medjool Large 1kg</p>
                                        <p class="mb-0"> <span class="fw-bold">Vendor:</span> GB Central Warehouse</p>
                                        <p class="mb-0"> <span class="fw-bold">Reason:</span> Damage</p>
                                    </div>
                                </td>
                                <td>2200.00</td>
                                <td>10.00</td>
                                <td>10.00</td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>A000190</td>
                                <td>8942240130104</td>
                                <td>
                                    <div class="">
                                        <p class="mb-0">Egyptian Medjool Medium 1kg</p>
                                        <p class="mb-0"> <span class="fw-bold">Vendor:</span> GB Central Warehouse</p>
                                        <p class="mb-0"> <span class="fw-bold">Reason:</span> Damage</p>
                                    </div>
                                </td>
                                <td>2000.00</td>
                                <td>15.00</td>
                                <td>15.00</td>
                            </tr>

                            <tr>
                                <td>5</td>
                                <td>A000133</td>
                                <td>8942240180140</td>
                                <td>
                                    <div class="">
                                        <p class="mb-0">Laal ata 2kg</p>
                                        <p class="mb-0"> <span class="fw-bold">Vendor:</span> GB Central Warehouse</p>
                                        <p class="mb-0"> <span class="fw-bold">Reason:</span> Damage</p>
                                    </div>
                                </td>
                                <td>200.00</td>
                                <td>4.00</td>
                                <td>4.00</td>
                            </tr>

                            <tr>
                                <td>6</td>
                                <td>A000153</td>
                                <td>8942240130074</td>
                                <td>
                                    <div class="">
                                        <p class="mb-0">Sukkari Mufattal Malaki Dates 3kg</p>
                                        <p class="mb-0"> <span class="fw-bold">Vendor:</span> GB Central Warehouse</p>
                                        <p class="mb-0"> <span class="fw-bold">Reason:</span> Damage</p>
                                    </div>
                                </td>
                                <td>4500.00</td>
                                <td>2.00</td>
                                <td>2.00</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">Total:</td>
                                <td>51.00</td>
                                <td>51.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-end justify-content-between mt-5">
            <div class="">
                <p class="mb-1" style="font-size: 12px;">Nazmul-10693</p>
                <p class="signature_by">Posted By</p>
            </div>
            <p class="signature_by">Store Executive</p>
            <p class="signature_by">Store Manager</p>
            <p class="signature_by">Floor received</p>
            <p class="signature_by">Accounts</p>
            <p class="authorized_by">Authorized By</p>
        </div>
    </div>


    <!-- jQuery -->
<script src="{{ asset('/public/admin/assets/js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap Core JS -->
<script src="{{ asset('public/admin/assets/js/bootstrap.bundle.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $(document).on('keydown', function (e) {
            switch (e.key) {
                case 'Escape':
                    e.preventDefault();
                    window.history.back();
                    break;
            }
        });
    });

    function printPage() {
        window.print();
    }
</script>

</body>
</html>