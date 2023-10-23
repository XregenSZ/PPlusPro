<?php
$open_connect = 1;
require('config.php');
require_once 'vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [ // lowercase letters only in font key
        'sarabun' => [
            'R' => 'Sarabun-Regular.ttf',
            'I' => 'Sarabun-Italic.ttf',
        ]
    ],
    'default_font' => 'sarabun'
]);

ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="print.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bill</title>
</head>


<body>
    
    <?php
    $detail_id = $_GET['detail'];
    $query = "SELECT * FROM orders_details as d INNER JOIN product as p ON d.product_id = p.productID WHERE order_id LIKE '%" . $detail_id . "%' ORDER BY detail_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $query = "SELECT * FROM orders as o INNER JOIN orders_detail as d ON o.order_id = d.order_id WHERE order_id LIKE '%" . $detail_id . "%' ORDER BY detail_id";
    $result = mysqli_query($conn, $query);
    ?>
    <div>
        <h2>P Plus Pro</h2>
        <p>ร้านจัดจำหน่ายอุปกรณ์ช่างพีพลัสโปร<br>81 ตำบล ลานตากฟ้า อำเภอนครชัยศรี นครปฐม 73120</p>
    </div>
    <div class="order-item">
        <h3>รายการสั่งซื้อ Order ID</h3>
    </div>
    <table>
        <tr>
            <td><b>รายการสินค้า</b></td>
            <td><b>จำนวน</b></td>
            <td><b>รวม</b></td>
        </tr>
        <tr>
            <td><?php echo $row['productName']?></td>
            <td><?php echo $row['quantity_detail']?></td>
            <td><?php echo $row['total']?></td>
        </tr>
    </table>
</body>
</html>

<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->output();

ob_end_flush();
?>