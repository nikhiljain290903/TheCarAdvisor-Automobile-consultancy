<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';
require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/autoload.php';
include("config.php");


$dateToday = date("Y-m-d");

$result = mysqli_query($con, "SELECT * FROM applyloan");
while ($loan = mysqli_fetch_assoc($result)) {
    $vno = $loan['VehicleNo'];

    // Check the due dates for each vehicle number
    // $dueResult = mysqli_query($con, "SELECT * FROM $vno WHERE DueDate = '$dateToday' AND RecAmt IS NULL");
    $dateTenDaysBefore = date('Y-m-d', strtotime($dateToday));

    // Query to get the records where DueDate is within the next 10 days and RecAmt is NULL
    $dueResult = mysqli_query($con, "SELECT * FROM $vno WHERE DueDate = '$dateTenDaysBefore' AND RecAmt IS NULL ORDER BY DueDate ASC");
    if (mysqli_num_rows($dueResult) > 0) {

        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mogeshwar@gmail.com';
            $mail->Password = 'bahozeizcimxhsqg';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('mogeshwar@gmail.com', 'TheCarAdvisor');
            $mail->addAddress($loan['Email'], $loan['Name']);
            $mail->isHTML(true);
            $mail->Subject = 'Loan Installment Due Reminder';

            // Fetch due information
            while ($due = mysqli_fetch_assoc($dueResult)) {
                $mail->Body = '<p>Dear <i><b style="font-size: 18px;">' . $loan['Name'] . '</b></i>,<br></p>
                <p>This is a reminder that your <b style="color:red">Installment Number: <i>' . $due['SNo'] . '</i></b> is due today under this,<br>
                <table style ="border: 1px solid black; border-collapse: collapse; color:red">
  <tr style ="border: 1px solid black; border-collapse: collapse; color:red"">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Vehicle Number:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $vno . '</i></td>
  </tr>
    <tr style ="border: 1px solid black; border-collapse: collapse"; color:red">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Due Amount:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $due['DueAmt'] . '</i></td>
  </tr>
  </table>
                <br>Please make your payment at your earliest convenience...<br><br>
                <b>Best Regards,</b><br>TheCarAdvisor</p>';

                $mail->send();
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
