<?php
    session_start();
    if(!isset($_SESSION['receipt'])){
        die("No receipt found.");
    }
    $receiptData = $_SESSION['receipt'];
    $receipt = $receiptData['cart'];
    $total = $receiptData['total'];
    $payment = $receiptData['payment'];
    $change = $receiptData['change'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Receipt</title>
        <style>
            body{
                font-family:Arial;
                padding:20px;

            }

            .receipt{
                width:300px;
                margin:auto;
                border:1px solid #ccc;
                padding:20px;
            }

            h2{
                text-align:center;
            }

            table{
                width:100%;
                border-collapse:collapse;
            }

            td{
                padding:5px 0;
            }

            .total{
                font-weight:bold;
                border-top:1px solid #000;

            }

            button{
                margin-top:20px;
                width:100%;
                padding:10px;
            }
        </style>
    </head>
    <body>
        <div class="receipt">
            <h2>POS SYSTEM</h2>
            <p>Date:<?php echo date("Y-m-d H:i:s"); ?></p>

            <table>
                <?php
                    $grandTotal = 0;
                    foreach($receipt as $item){
                        $subtotal =
                        $item['price'] *
                        $item['qty'];
                        $grandTotal += $subtotal;
                ?>
                <tr>
                    <td>
                        <?php echo $item['product']; ?> x <?php echo $item['qty']; ?>
                    </td>
                    <td align="right">
                        ₱<?php echo number_format($subtotal, 2); ?>
                    </td>
                </tr>
                <?php } ?>
                <tr class="total">
                    <tr>
                        <td>Payment</td>
                        <td align="right">₱<?php echo number_format($payment, 2); ?></td>
                    </tr>
                    <tr>
                        <td>Change</td>
                        <td align="right">
                            ₱<?php echo number_format($change, 2); ?>
                        </td>
                    </tr>
                    <td>Total</td>
                    <td align="right">
                        ₱<?php echo number_format($grandTotal, 2); ?>
                    </td>
                </tr>
            </table>
            <button onclick="window.print()">Print Receipt</button>
        </div>
    </body>
</html>