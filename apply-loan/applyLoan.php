<!DOCTYPE html>
<html lang="en">

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
                $vno = $_POST['vno'];
                $model = $_POST['model'];
                $vname = $_POST['vname'];
                $loanamt = $_POST['loanamt'];
                $intrate = $_POST['intrate'];
                $tenure = $_POST['tenure'];
                $dateagree = $_POST['dateagree'];

                //verifying the unique vehicle number

                $verify_query = mysqli_query($con, "SELECT VehicleNo FROM applyloan WHERE VehicleNo='$vno'");

                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                      <p>Vehicle Number is already Registered!!!</p>
                  </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {

                    $intamt = $loanamt * ($intrate / 100) * $tenure;
                    $dueamt = ($loanamt + $intamt) / $tenure;

                    mysqli_query($con, "INSERT INTO applyloan(Name,VehicleNo,Model,VehicleName,LoanAmt,IntRate,Tenure,DateAgree,IntAmt,DueAmt) VALUES('$name','$vno','$model','$vname','$loanamt','$intrate','$tenure','$dateagree','$intamt','$dueamt')") or die("Erroe Occured");
                    mysqli_query($con, "CREATE TABLE $vno(SNo int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,DueAmt int(10) NOT NULL,DueDate date NOT NULL, RecAmt int(10) NOT NULL, RecDate date NOT NULL)") or die("Erroe Occured");
                    echo "<div class ='message'><p>Interest Amount: $intamt <br> Due Amount: $dueamt </p></div>" ;

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
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" autocomplete="on" required>
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