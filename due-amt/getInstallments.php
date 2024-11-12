<?php
include("config.php");

if (isset($_POST['vehicleNo'])) {
    $vno = $_POST['vehicleNo'];
    $total_installments = 50; // Adjust this based on your actual total number of installments.

    // Get the latest paid installment number
    $last_paid_query = mysqli_query($con, "SELECT MAX(SNo) AS LastPaid FROM `$vno` WHERE RecAmt IS NOT NULL AND RecAmt != 0");
    $last_paid_row = mysqli_fetch_array($last_paid_query);
    $last_paid = $last_paid_row ? $last_paid_row['LastPaid'] : 0;

    // Generate options from the next unpaid installment to the total number of installments
    $installments_query = mysqli_query($con, "SELECT SNo, DueDate, DueAmt FROM `$vno` WHERE SNo > '$last_paid' AND SNo <= '$total_installments'");

    while ($row = mysqli_fetch_assoc($installments_query)) {
        $inst_number = $row['SNo'];
        $due_date = $row['DueDate'];
        $due_amount = $row['DueAmt'];
        echo "<option value='$inst_number'>Installment $inst_number - Due on $due_date - Amount: $due_amount</option>";
    }
}
?>
