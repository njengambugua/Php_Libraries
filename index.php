<?php

require("./dompdf/autoload.inc.php");
require("./reset/phpmailer/vendor/autoload.php");

use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;

$dompdf = new Dompdf;
$options = $dompdf->getOptions();
$options->setIsPhpEnabled(true);
$options->setIsRemoteEnabled(true);
$options->setChroot("./images");
$dompdf->setOptions($options);
$mail = new PHPMailer();

$print = file_get_contents('./print.php');

$dompdf->loadHtml($print);


$dompdf->render();

$mail->SMTPDebug = 1;                                       //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';             //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'john898mbugua@gmail.com';              //SMTP username
$mail->Password   = 'xbhqldhdsjgwakat';                           //SMTP password
$mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
$mail->Port       = 587;

$mail->setFrom('john898mbugua@gmail.com', 'Njenga');
$mail->addAddress('johnmbuguanjenga898@gmail.com', 'John');

$rint = $dompdf->output();
$mail->addStringAttachment($rint, 'print.pdf');

$mail->isHTML(true);                                  //Set email format to HTML
$mail->Subject = 'DOM pdf';
$mail->Body    = 'Kindly, find attached, DOM';

$mail->send();

?>

<script>
  window.addEventListener("load", (event) => {
    alert('Email(s) Sent Successfully');
    window.close();
  });
</script>