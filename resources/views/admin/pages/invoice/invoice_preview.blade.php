<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>POS Receipt</title>

<style>
    body {
        font-family: monospace;
        margin: 0;
        padding: 0;
        font-size: 11px;
    }
    img{
       width: 100%;
       height: 100%;
    }
    .receipt {
        width: 80mm;
        padding: 10px;
        margin: 0 auto;
    }

    .center {
        text-align: center;
    }

    .bold {
        font-weight: 700;
    }

    .line {
        border-top: 1px solid #bfbfbf;
        margin: 2px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
    }

    th, td {
        padding: 2px 0;
    }
    .mb-1{
        margin-bottom : 4px; 
    }
    .mb-2{
        margin-bottom : 8px; 
    }
    .ft-s{
        font-size: 10px;
    }
    .ft-m{
        font-size: 11px;
    }

    .right {
        text-align: right;
    }

    .left {
        text-align: left;
    }

    .footer {
        text-align: left;
        margin-bottom: 4px;
    }
    .pos_table {
        width: 100%;
        border-collapse: collapse;
        font-family: monospace;
        font-size: 10px;
    }

    .pos_table th,
    .pos_table td {
        padding: 1px 2px;   /* 🔥 tight spacing */
        vertical-align: top;
    }

    .pos_table thead th {
        border-bottom: 1px solid #bfbfbf;
        text-align: left;
    }

    /* Column widths (IMPORTANT) */
    .pos_table .sl {
        width: 8%;
    }

    .pos_table .desc {
        width: 42%;
        word-break: break-word;
    }

    .pos_table .qty {
        width: 12%;
        text-align: right;
    }

    .pos_table .mrp {
        width: 18%;
        text-align: right;
    }

    .pos_table .amt {
        width: 20%;
        text-align: right;
    }
    .pos_table .amt_data {
        width: 75%;
        text-align: right;
    }
    .pos_table .amt_price {
        width: 25%;
        text-align: right;
    }
    .payment_info{
        border-bottom: 2px solid #101010;
        width: fit-content;
    }
    .invoice_shadow{
        text-align: center;
        opacity: 0.4;
        margin: 8px 0;
    }

@media print {
    @page {
        size: 80mm auto;   /* IMPORTANT */
        margin: 0;
    }
    html, body {
        margin: 0 !important;
        padding: 0 !important;
    }
    img{
       width: 100%;
       height: 100%;
    }
    .receipt {
            position: absolute;  /* VERY IMPORTANT */
            top: 0;              /* PUSH TO TOP */
            left: 0;
            width: 80mm;
            margin: 0;
            padding: 5px;
        }
    }
</style>

</head>
<body onload="window.print()">

<div class="receipt">

    <div class="">
        <img src="{{ asset('public/admin/assets/images/ghorerbazar.png') }}" alt="">
    </div>

    <!-- Header -->
    <div class="center">
        <div class="bold">Metro Uttara North</div>
        <div class="bold">Uttara North, Metro Station, Dhaka-1230</div>
        <div>Phone: +880 1332 561385</div>
        
        <table style="width:100%; font-size:12px;">
            <tr>
                <td class="bold" style="text-align:left; font-size: 11px;">BIN: 004688135-0202</td>
                <td class="bold" style="text-align:right; font-size: 11px;">Mushok: 6.3</td>
            </tr>
        </table>
    </div>

    <div class="line"></div>

    <!-- Invoice Info -->
    <div>
        <div class="bold">Invoice No.&nbsp;&nbsp;&nbsp;: 0426031700003</div>
        <div class="bold">Invoice Date&nbsp;&nbsp;: 22-Feb-2025&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10:13:32 AM</div>
        <div class="center bold mb-1">DUPLICATE-0</div>
        <div class="ft-s">Name : Walk In</div>
        <div class="ft-s">Address : -</div>
        <div class="ft-s  mb-1">Mobile : 0100000000000</div>
        <div class="bold">Served By : Nazmul-10693</div>
    </div>

    <div class="line"></div>

    <!-- Items -->
    <table class="pos_table">
        <thead>
            <tr>
                <th class="sl">SL</th>
                <th class="desc">Description</th>
                <th class="qty">Qty</th>
                <th class="mrp">MRP</th>
                <th class="amt">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="sl ft-s">1</td>
                <td class="desc ft-s" colspan="4">
                    Lichu Flower Honey 250gm
                </td>
            </tr>
            <tr>
                <td class="sl"></td>
                <td class="desc ft-s">
                    8941140150175
                </td>
                <td class="qty ft-s">1.000</td>
                <td class="mrp ft-s">300.00</td>
                <td class="amt ft-s">300.00</td>
            </tr>

            <tr>
                <td class="sl ft-s">2</td>
                <td class="desc ft-s" colspan="4">
                    Ajwa Premium Dates (Jumbo) 500gm
                </td>
            </tr>
            <tr>
                <td class="sl"></td>
                <td class="desc ft-s">
                    8942240130180
                </td>
                <td class="qty ft-s">1.000</td>
                <td class="mrp ft-s">1250.00</td>
                <td class="amt ft-s">1250.00</td>
            </tr>
        </tbody>
    </table>

    <div class="line"></div>

    <!-- Totals -->
    <table class="pos_table">
        <tr>
            <td class="bold ft-m" colspan="2">SubTotal</td>
            <td class="qty bold ft-m">2.00</td>
            <td class="bold right ft-m" colspan="2">1550.00</td>
    </table>

    <div class="line"></div>

    <table class="pos_table">
        <tr>
            <td class="right amt_data">Discount :</td>
            <td class="right amt_price">150.00</td>
        </tr>
        <tr>
            <td class="right amt_data">VAT :</td>
            <td class="right amt_price">190.00</td>
        </tr>
        <tr class="bold">
            <td class="right amt_data">Net Amount :</td>
            <td class="right amt_price">1400.00</td>
        </tr>
        <tr>
            <td class="right amt_data">Total Payable :</td>
            <td class="right amt_price ">1400.00</td>
        </tr>
        <tr>
            <td class="right amt_data">Paid Amount :</td>
            <td class="right amt_price">1500.00</td>
        </tr>
        <tr class="bold">
            <td class="right amt_data">Change Amount :</td>
            <td class="right amt_price">100.00</td>
        </tr>
    </table>

    <div class="mb-1">
        <span class="bold">Inword:</span> Taka. One Thousand four hundred only.
    </div>

    <div class="bold mb-1 payment_info">Payment Info: </div>

    <!-- Payment Info -->
    <div style="padding: 0px 12px;">
        <table class="pos_table" >
            <thead>
                <tr>
                    <th class="left" style="font-weight: 400;">Description</th>
                    <th style="text-align: right; font-weight: 400;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="ft-s bold left">CASH</td>
                    <td class="ft-s bold right">
                        1400.00
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="invoice_shadow">*** 0426031700003 ***</div>

    <!-- Footer -->
    <div class="footer">
        <p class="bold">N.B.: *VAT Included. Item purchased can be exchanged within 7 days with the Cash Memo and Tag. Exchange is allowed only if the product is in original, unpacked condition.*</p>

        <p class="center bold mb-1">Thank you for shopping</p>
    </div>

    <div class="line"></div>

    <div class="center">Software By: -----------</div>

</div>

<script>
// window.onafterprint = function () {
//     if (window.opener) {
//         window.close();
//     } else {
//         window.history.back();
//     }
// };
</script>

</body>
</html>