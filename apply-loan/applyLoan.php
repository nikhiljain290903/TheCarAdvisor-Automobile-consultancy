<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';
require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/autoload.php';
?>

<head>
    <link rel="stylesheet" href="applyLoanstyle.css">
    <title>Apply Loan</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <?php


            include("config.php");
            if (isset($_POST['submit'])) {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $vno = $_POST['vno'];
                $model = $_POST['model'];
                $vname = $_POST['vname'];
                $loanamt = $_POST['loanamt'];
                $intrate = $_POST['intrate'];
                $tenure = $_POST['tenure'];
                $dateagree = $_POST['dateagree'];

                $dateagreeTimestamp = strtotime($dateagree);  // Convert the date string to timestamp
$dateinc = date("Y-m-d", strtotime("+1 month", $dateagreeTimestamp));


                //Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Enable verbose debug output
                    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;

                    //Send using SMTP
                    $mail->isSMTP();

                    //Set the SMTP server to send through
                    $mail->Host = 'smtp.gmail.com';

                    //Enable SMTP authentication
                    $mail->SMTPAuth = true;

                    //SMTP username
                    $mail->Username = 'mogeshwar@gmail.com';

                    //SMTP password
                    $mail->Password = 'bahozeizcimxhsqg';

                    //Enable TLS encryption;
                    $mail->SMTPSecure = 'ssl';

                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
                    $mail->Port = 465;

                    //Recipients
                    $mail->setFrom('mogeshwar@gmail.com', 'TheCarAdvisor');

                    //Add a recipient
                    $mail->addAddress($email, $name);

                    //Set email format to HTML
                    $mail->isHTML(true);


                    $mail->Subject = 'Loan Application Confirmation';
                    $mail->Body    = '<p>Dear <i><b style="font-size: 18px;">' . $name . '</b></i>,<br>
<b style="color:">Thank you for choosing our loan services. We have successfully received your loan application, and we’re excited to support you with your financial needs.</b><br>
Here are the details of your loan application:<br>
<table style ="border: 1px solid black; border-collapse: collapse">
  <tr style ="border: 1px solid black; border-collapse: collapse">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Name:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $name . '</i></td>
  </tr>
    <tr style ="border: 1px solid black; border-collapse: collapse">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Vehicle Number:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $vno . '</i></td>
  </tr>
    <tr style ="border: 1px solid black; border-collapse: collapse">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Vehicle Name:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $vname . '</i></td>
  </tr>
    <tr style ="border: 1px solid black; border-collapse: collapse">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Loan Amount:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $loanamt . '</i></td>
  </tr>
    <tr style ="border: 1px solid black; border-collapse: collapse">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Interest Rate:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $intrate . '%</i></td>
  </tr>
    <tr style ="border: 1px solid black; border-collapse: collapse">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Tenure:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $tenure . ' months</i></td>
  </tr>
    <tr style ="border: 1px solid black; border-collapse: collapse">
    <th style="font-size: 19px; border: 1px solid black; border-collapse: collapse;">Date of Agreement:</th>
    <td style ="font-size: 17px; border: 1px solid black; border-collapse: collapse;"><i>' . $dateagree . '</i></td>
  </tr>
</table>

Please note that your <b>FIRST INSTALLMENT is due on ' . $dateinc . '</b>.<br>

We’ll keep you updated regarding your loan status. For any questions, feel free to contact us.<br>
<p></p>
<b>Best Regards,</b><br>
TheCarAdvisor</p>';

                    $mail->send();
                    // echo 'Message has been sent';

                    // exit();
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                // Verifying the unique vehicle number
                $verify_query = mysqli_query($con, "SELECT VehicleNo FROM applyloan WHERE VehicleNo='$vno'");
                $verify_query1 = mysqli_query($con, "SELECT Email FROM applyloan WHERE Email='$email'");

                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                <p>Vehicle Number is already Registered!!!</p>
              </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } elseif (mysqli_num_rows($verify_query1) != 0) {
                    echo "<div class='message'>
                <p>Email is already Used!!!</p>
              </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    $intamt = $loanamt * ($intrate / 100) * $tenure;
                    $dueamt = ($loanamt + $intamt) / $tenure;

                    mysqli_query($con, "INSERT INTO applyloan(Name,Email,VehicleNo,Model,VehicleName,LoanAmt,IntRate,Tenure,DateAgree,IntAmt,DueAmt) VALUES('$name','$email','$vno','$model','$vname','$loanamt','$intrate','$tenure','$dateagree','$intamt','$dueamt')") or die("Error Occurred");
                    mysqli_query($con, "CREATE TABLE $vno(SNo int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT, DueAmt int(10) NOT NULL, DueDate date NOT NULL, RecAmt int(10), RecDate date)") or die("Error Occurred");

                    // Adjusting due dates to start from the month following the agreement date
                    $date = new DateTime($dateagree);
                    $date->modify('+1 month'); // Start from the next month

                    for ($i = 1; $i <= $tenure; $i++) {
                        $dueDate = $date->format('Y-m-d');
                        mysqli_query($con, "INSERT INTO $vno(DueAmt, DueDate) VALUES('$dueamt', '$dueDate')") or die("Error Occurred");
                        $date->modify('+1 month');
                    }

                    echo "<div class='message'><p>Interest Amount: $intamt <br> Due Amount: $dueamt </p></div>";

                    echo "<div class='message'>
                <p>Submitted successfully!</p>
              </div> <br>";

                    echo "<a href='../loan-main.php'><button class='btn'>Home Page</button>";
                }
            } else {

            ?>
                <p><a href="http://localhost:8080/thecaradvisor/loan-main.php"><img src="home-button.png" style="width:50px;height:50px;margin-left: auto;
  margin-right: auto;display: block;"></a></p>
                <header>Enter Your Details:</header>
                <form action="" method="post" onsubmit="submitFormReturn();return false;">
                    <div class="field input">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="vno">Vehicle No</label>
                        <input type="text" oninput="this.value = this.value.toUpperCase()" name="vno" id="vno" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="model">Model</label>
                        <input type="text" oninput="this.value = this.value.toUpperCase()" name="model" id="model" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="vname">Vehicle Name</label>
                        <input type="text" oninput="this.value = this.value.toUpperCase()" name="vname" id="vname" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="loanamt">Loan Amount</label>
                        <input type="number" name="loanamt" id="loanamt" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="intrate">Interest Rate</label>
                        <input type="text" name="intrate" id="intrate" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="tenure">Tenure</label>
                        <input type="number" name="tenure" id="tenure" autocomplete="off" required>
                    </div>

                    <div class="field input">
                        <label for="dateagree">Date of Agreement</label>
                        <input type="date" name="dateagree" id="dateagree" autocomplete="off" required>
                    </div>

                    <div class="field">

                        <input type="submit" class="btn" name="submit" value="Submit" required>
                    </div>
                </form>
        </div>
    <?php } ?>
    </div>
</body>

</html>