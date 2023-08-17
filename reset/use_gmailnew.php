<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once 'php.php';
require_once '../employees/Employees_class.php';
require_once("../../sys/config/Config_class.php");
require_once("../configs/Configs_class.php");
require_once ("../../../dompdf/autoload.inc.php"); //For dompdf
use Dompdf\Dompdf;
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require '../../../phpmailer/vendor/autoload.php';
$db = new DB();

// *****ALpha COmmented this on Dec 2 2022 ********** ?///
// include("PHPMailer_5.2.0/class.phpmailer.php");
// include("class.phpmailer.php");
//include("PHPMailer_5.2.0/class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$emp = $_SESSION['emp'];
$month = $_GET['month'];
$year = $_GET['year'];



// $mail->AddAddress($employees->email,$employees->firstname." ".$employees->middlename." ".$employees->lastname);

$num = count($emp);
$i=0;
while($i<$num){
  $employees = new Employees();
  $fields="*";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='".$emp[$i]."' and email!=''";
  $employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
  $employees=$employees->fetchObject;
  

  // instantiate and use the dompdf class
  $dompdf = new Dompdf(array('enable_remote' => true)); 
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
  //Server settings
  $mail->SMTPDebug = 1;                                       //Enable verbose debug output
  $mail->isSMTP();                                            //Send using SMTP
  $mail->Host       = 'mailer.wisedigits.co.ke';             //Set the SMTP server to send through
  $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
  $mail->Username   = 'hrm@wisedigits.co.ke';              //SMTP username
  $mail->Password   = 'RcKsmMD&H4OU@wise';                           //SMTP password
  $mail->SMTPSecure = "tls";                                  //Enable implicit TLS encryption
  $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

  //Custom Details
  $receipentname = $employees->firstname." ".$employees->middlename." ".$employees->lastname;
  $receipentemail = $employees->email;
  $dateObj   = DateTime::createFromFormat('!m', $month);
  $monthName = $dateObj->format('F');

  //Recipients
  $mail->setFrom('hrm@wisedigits.co.ke', 'Mary Immaculate Kerugoya Hospital');
  $mail->addAddress($receipentemail, $receipentname);     //Add a recipient

  //Attachments
  /*******Alpha added DOM PDF Generator on Dec 8th*****************************/
  // reference the Dompdf namespace
  
  //Generate our url to pdf
  $pdfurl = "http://164.68.98.145/immaculate/modules/hrm/employeepayments/printpayslip.php?year=".$year."&month=".$month."&id=".$emp[$i];
  //load the html file generated from our url
  $pdfhtml=file_get_contents($pdfurl);
  // $dompdf->loadHtmlFile($pdfurl);
  //load our html
  $dompdf->loadHtml($pdfhtml);
  
  // (Optional) Setup the paper size and orientation
  $dompdf->setPaper('A4', 'potrait');
  
  // Render the HTML as PDF
  $dompdf->render();
  
  $pdfString = $dompdf->output();
  $mail->addStringAttachment($pdfString, $receipentname.' payslip.pdf');
  // **************End of DOM PDF Generator*********//
  
  //Content
  $mail->isHTML(true);                                  //Set email format to HTML
  $mail->Subject = 'Payslip for '.$receipentname;
  $mail->Body    = 'Kindly, find attached, your payslip for the month of '.$monthName.', '.$year.' .';
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  $mail->send();
  echo 'Message has been sent';
  } catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }


  $i++;

}
?>
<script>
  window.addEventListener("load", (event) => {
    alert('Email(s) Sent Successfully');
    window.close();
  });
</script>