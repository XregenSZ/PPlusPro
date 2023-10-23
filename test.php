<?php 
require_once 'vendor/autoload.php';
ob_start();

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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <table>
            <tr>
                <td>ชื่อ</td>
                <td>เบอร์โทร</td>
                <td>ที่อยู่</td>
            </tr>
            <tr>
                <td>สิงห์</td>
                <td>99999999</td>
                <td>Thailand</td>
            </tr>
            <tr>
                <td>มิ้น</td>
                <td>123456789</td>
                <td>columbia</td>
            </tr>
        </table>
    </div>
</body>
</html>

<?php 
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->output();

ob_end_flush();
?>