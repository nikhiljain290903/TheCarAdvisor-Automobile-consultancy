<?php
include("config.php");

if (isset($_POST['vehicleNo'])) {
    $vno = $_POST['vehicleNo'];
    $total_instalments = 50; // Adjust this to match the total number of installments

    // Get the latest paid installment number
    $last_paid_query = mysqli_query($con, "SELECT MAX(SNo) AS LastPaid FROM `$vno` WHERE RecAmt IS NOT NULL AND RecAmt != 0");
    $last_paid_row = mysqli_fetch_array($last_paid_query);
    $last_paid = $last_paid_row ? $last_paid_row['LastPaid'] : 0;

    // Generate options for installments from the next unpaid installment to the total number of installments
    for ($i = $last_paid + 1; $i <= $total_instalments; $i++) {
        echo "<option value='$i'>$i</option>";
    }
}
?>
