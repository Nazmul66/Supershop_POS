<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Stock Received Preview</title>

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
        font-weight: 500;
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
        font-weight: 700;
    }
    .table_box{
        padding: 0 10px;
    }
    .table{
        border: 1px solid #161616;
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
    .table tfoot tr td{
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
        /* span, */
        .btn-success,
        .btn_esc{
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
                <h4 class="fw-bold">Requisition Challan</h4>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6">
                    <h6 class="fw-bold">Metro Shewrapara</h6>
                    <p class="fw-bold mb-1">Vendor: <span class="text-dark">Dhaka</span></p>
                </div>

                <div class="col-lg-6">
                    <p class="heavy_content">+880 1332 561384</p>
                    <p class="heavy_content">REQUISITION NO# Preview</p>
                    <p class="heavy_content">DATE# 15-Feb-2026 &nbsp&nbsp&nbsp 09:41 PM</p>
                </div>
            </div>

            <div class="table_box">
                <div class="table-responsive">
                    <table class="table mb-0 datatables">
                        <thead>
                            <tr>
                                <th>CODE</th>
                                <th>BARCODE</th>
                                <th>NAME</th>
                                <th>CARTOON SIZE</th>
                                <th>CPU</th>
                                <th>MRP</th>
                                <th>CUR. QTY</th>
                                <th>CARTOON Qty</th>
                                <th>REQ. QTY</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A000168</td>
                                <td>8941140150236</td>
                                <td>Sundarban Honey 250gm</td>
                                <td>1.00</td>
                                <td>1.00</td>
                                <td>625.00</td>
                                <td>13.00</td>
                                <td>2.00</td>
                                <td>2.00</td>
                            </tr>

                            <tr>
                                <td>A000167</td>
                                <td>8941140150175</td>
                                <td>Lichu Flower Honey 250gm</td>
                                <td>1.00</td>
                                <td>1.00</td>
                                <td>300.00</td>
                                <td>17.00</td>
                                <td>9.00</td>
                                <td>9.00</td>
                            </tr>

                            <tr>
                                <td>A000128</td>
                                <td>8942240130050</td>
                                <td>Egyptian Medjool Large 1kg</td>
                                <td>1.00</td>
                                <td>1.00</td>
                                <td>2200.00</td>
                                <td>5.00</td>
                                <td>10.00</td>
                                <td>10.00</td>
                            </tr>

                            <tr>
                                <td>A000138</td>
                                <td>8942240130104</td>
                                <td>Egyptian Medjool Medium 1kg</td>
                                <td>1.00</td>
                                <td>1.00</td>
                                <td>2000.00</td>
                                <td>5.00</td>
                                <td>10.00</td>
                                <td>10.00</td>
                            </tr>

                            <tr>
                                <td>A000141</td>
                                <td>8942240180140</td>
                                <td>Laal ata 2kg</td>
                                <td>1.00</td>
                                <td>1.00</td>
                                <td>2000.00</td>
                                <td>6.00</td>
                                <td>4.00</td>
                                <td>4.00</td>
                            </tr>

                            <tr>
                                <td>A000151</td>
                                <td>8942240130074</td>
                                <td>Sukkari Mufattal Malaki Dates 3kg</td>
                                <td>1.00</td>
                                <td>1.00</td>
                                <td>4500.00</td>
                                <td>1.00</td>
                                <td>2.00</td>
                                <td>2.00</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="7"></td>
                                <td>Total:</td>
                                <td>37.00</td>
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