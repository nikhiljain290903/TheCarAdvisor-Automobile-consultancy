<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="dueAmt.css">
    <title>Receive Due | Page</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <?php

            include("config.php");
            if (isset($_POST['submit'])) {
                $vno = $_POST['vno'];
                $dueamt = $_POST['dueamt'];
                $instno = $_POST['instno'];
                $recdate = $_POST['recdate'];
                $rema = $_POST['rema'];

                //verifying the vehicle number is registerd or not

                $verify_query = mysqli_query($con, "SELECT VehicleNo FROM applyloan WHERE VehicleNo='$vno'");

                if (mysqli_num_rows($verify_query) == 0) {
                    echo "<div class='message'>
                      <p>Vehicle Number is Not Registered, So kindly register in Apply Loan!!!</p>
                  </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                    // echo "<a href='../apply-loan/applyLoan.php'><button class='btn'>Apply Loan</button>";
                } else {
                    mysqli_query($con, "INSERT INTO dueamt(VehicleNo,DueAmt,InstNo,RecDate,Rem) VALUES('$vno','$dueamt','$instno','$recdate','$rema')") or die("Erroe Occured");

                    echo "<div class='message'>
                      <p>Submitted successfully!</p>
                  </div> <br>";
                    echo "<a href='../loan-main.php'><button class='btn'>Home Page</button>";
                }
            } else {

            ?>
                <header>Enter Your Details:</header>
                <form action="" method="post" onsubmit="submitFormReturn();return false;">
                    <div class="field input">

                        <div class="field input">
                            <label for="vno">Vehicle No</label>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" name="vno" id="vno" autocomplete="on" required>
                        </div>

                        <div class="field input">
                            <label for="dueamt">Due Amount</label>
                            <input type="number" oninput="this.value = this.value.toUpperCase()" name="dueamt" id="dueamt" autocomplete="off" required>
                        </div>

                        <div class="field input">
                            <label for="instno">Installment Number</label>
                            <input type="number" oninput="this.value = this.value.toUpperCase()" name="instno" id="instno" autocomplete="off" required>
                        </div>

                        <div class="field input">
                            <label for="recdate">Received Date</label>
                            <input type="date" name="recdate" id="recdate" autocomplete="off" required>
                        </div>

                        <div class="field input">
                            <label for="rema">Remarks</label>
                            <input type="text" name="rema" id="rema" autocomplete="off" required>
                        </div>


                </form>
                <div class="field">
                    <input style="background-color: #5527c7; 
                    height:35px; 
                    border: 0; 
                    border-radius: 10px;
                    font-weight: bold; 
                    color: #fff;
                    font-size: 15px;
                    cursor: pointer;
                    transition: all .3s;
                    margin-top: 10px;
                    padding: 0px 10px; 
                    width: 100%; " type="submit" class="btns" name="submit" value="Submit" required>
                </div>
        </div>
    <?php } ?>
    </div>
</body>

</html>