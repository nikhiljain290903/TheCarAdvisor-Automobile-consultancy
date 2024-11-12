<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="dueAmt.css">
    <title>Receive Due | Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to fetch installments once vehicle number is entered
        function fetchInstallments() {
            var vno = $('#vno').val().toUpperCase();
            if (vno) {
                $.ajax({
                    url: 'getInstallments.php',
                    type: 'POST',
                    data: { vehicleNo: vno },
                    success: function(data) {
                        $('#instno').html(data); // Populate the dropdown
                    }
                });
            }
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <?php
            include("config.php");
            require 'C:/xampp/htdocs/TheCarAdvisor/phpmailer/vendor/autoload.php';

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            $successMessage = ''; // Initialize variable for success message

            if (isset($_POST['submit'])) {
                $vno = $_POST['vno'];
                $dueamt = $_POST['dueamt'];
                $instno = $_POST['instno'];
                $recdate = $_POST['recdate'];
                $rema = $_POST['rema'];

                // Verify if the vehicle number is registered
                $verify_query = mysqli_query($con, "SELECT VehicleNo, Email, Name FROM applyloan WHERE VehicleNo='$vno'");
                
                if (mysqli_num_rows($verify_query) == 0) {
                    echo "<div class='message'>
                            <p>Vehicle Number is Not Registered. Please register in Apply Loan.</p>
                          </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {
                    $loanInfo = mysqli_fetch_assoc($verify_query);
                    $email = $loanInfo['Email'];
                    $name = $loanInfo['Name'];

                    // Check for unpaid installments before the selected one
                    $unpaid_installment_query = mysqli_query($con, "SELECT SNo FROM `$vno` WHERE SNo < '$instno' AND (RecAmt = 0 OR RecAmt IS NULL) ORDER BY SNo ASC LIMIT 1");

                    if (mysqli_num_rows($unpaid_installment_query) > 0) {
                        $unpaid_row = mysqli_fetch_array($unpaid_installment_query);
                        $unpaid_inst = $unpaid_row['SNo'];
                        echo "<div class='message'>
                                <p>Installment $unpaid_inst is pending. Please pay installment $unpaid_inst before proceeding with installment $instno.</p>
                              </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                    } else {
                        // Insert the record in the `dueamt` table
                        mysqli_query($con, "INSERT INTO dueamt (VehicleNo, DueAmt, InstNo, RecDate, Rem) VALUES ('$vno', '$dueamt', '$instno', '$recdate', '$rema')") or die("Error Occurred");

                        // Update the selected installment record in the vehicle-specific table
                        mysqli_query($con, "UPDATE `$vno` SET RecAmt='$dueamt', RecDate='$recdate' WHERE SNo='$instno'") or die("Error Occurred");

                        // Set success message
                        $successMessage = "Submitted successfully!";

                        // Send confirmation email
                        $mail = new PHPMailer(true);
                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'mogeshwar@gmail.com'; // Replace with your email
                            $mail->Password = 'bahozeizcimxhsqg'; // Replace with your email password
                            $mail->SMTPSecure = 'ssl';
                            $mail->Port = 465;

                            $mail->setFrom('mogeshwar@gmail.com', 'TheCarAdvisor');
                            $mail->addAddress($email, $name);

                            $mail->isHTML(true);
                            $mail->Subject = 'Payment Received Confirmation';
                            $mail->Body = '<p>Dear <i><b style="font-size: 18px;">' . $name . '</b></i>,<br>
                            <b>Thank you for your payment. Here are the details of your transaction:</b><br>
                            <table style="border: 1px solid black; border-collapse: collapse;">
                              <tr style="border: 1px solid black;">
                                <th style="font-size: 19px; border: 1px solid black; padding: 8px;">Vehicle Number:</th>
                                <td style="font-size: 17px; border: 1px solid black; padding: 8px;">' . $vno . '</td>
                              </tr>
                              <tr style="border: 1px solid black;">
                                <th style="font-size: 19px; border: 1px solid black; padding: 8px;">Installment Number:</th>
                                <td style="font-size: 17px; border: 1px solid black; padding: 8px;">' . $instno . '</td>
                              </tr>
                              <tr style="border: 1px solid black;">
                                <th style="font-size: 19px; border: 1px solid black; padding: 8px;">Amount Received:</th>
                                <td style="font-size: 17px; border: 1px solid black; padding: 8px;">₹' . $dueamt . '</td>
                              </tr>
                              <tr style="border: 1px solid black;">
                                <th style="font-size: 19px; border: 1px solid black; padding: 8px;">Received Date:</th>
                                <td style="font-size: 17px; border: 1px solid black; padding: 8px;">' . $recdate . '</td>
                              </tr>
                            </table><br>
                            <p>Thank you for staying on top of your payments! If you have any questions, please feel free to reach out.</p>
                            <b>Best Regards,</b><br>
                            TheCarAdvisor</p>';

                            $mail->send();
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }
            }
            ?>

            <header>Enter Your Details:</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="vno">Vehicle No</label>
                    <input type="text" oninput="fetchInstallments()" name="vno" id="vno" autocomplete="on" required>
                </div>

                <div class="field input">
                    <label for="dueamt">Receiving Amount</label>
                    <input type="number" name="dueamt" id="dueamt" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="instno">Due Details</label>
                    <select name="instno" id="instno" required>
                        <option value="">Select Installment</option>
                        <!-- Options will be populated here -->
                    </select>
                </div>

                <div class="field input">
                    <label for="recdate">Received Date</label>
                    <input type="date" name="recdate" id="recdate" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="rema">Remarks</label>
                    <input type="text" name="rema" id="rema" autocomplete="off" required>
                </div>

                <div class="field">
                    <input style="background-color: #5527c7; height:35px; border: 0; border-radius: 10px; font-weight: bold; color: #fff; font-size: 15px; cursor: pointer; transition: all .3s; margin-top: 10px; padding: 0px 10px; width: 100%;" type="submit" class="btns" name="submit" value="Submit" required>
                </div>
            </form>

            <?php if ($successMessage): ?>
                <div class='message'>
                    <p><?php echo $successMessage; ?></p>
                    <a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                </div>
            <?php endif; ?>

        </div>
    </div>
</body>

</html>
