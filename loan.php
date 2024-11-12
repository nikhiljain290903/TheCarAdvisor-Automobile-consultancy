<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<script>
    function signIn() {
        alert("Please SignIn to the page before using these Features!");
    }
</script>

<head>
    <title>Loan</title>
    <link rel="stylesheet" href="loan.css">
</head>

<body>
    <div class="header">
        <div class="logo">
            <h1>TheCarAdvisor</h1>
        </div>
        <?php
        if (isset($_POST['submit'])) {
            header("Location: login/signIn.php");
        } else {
        ?>
            <form action="" method="post">
                <div class="buttons">
                    <div class="buttons-soln">
                        <button>Loan Solution</button></a>
                    </div>
                    <div class="buttons-apply">
                        <button type="submit" name="submit" required>Sign In</button>
                    </div>
                </div>
    </div>

    <div class="container">
        <div class="center-text">

        </div>

        <div class="about-section">
            <div class="about-text">
                <h1>Digital financing with personal service</h1>
                <p>Simple online experience. Dedicated Loan professionals . Online preApprovals</p>
            </div>
            <div class="about-image">
                <img src="loan.jpg" alt="About Image">
            </div>

        </div>
        <button class="applyButton" type="button" onclick="signIn()">Apply Loan</button>
    </div>
    </div>

    <hr class="line">
    <div class="main2">
        <h2>Our services</h2>
        <div class="p3"><br><br>
            <div class="column"><img src="https://media.istockphoto.com/id/1082529678/photo/womans-hands-with-new-indian-500-rupees-banknotes.jpg?s=612x612&w=0&k=20&c=MZvOzj_jODuze2e6KrY7RqTEzoYWm3Q9p0WUq6aZCxU=" alt="" height="320px" weight="100%"></div>
            <div class="column"><img src="https://media.istockphoto.com/id/1192932553/vector/vector-loan-repayment-calendar-days-flat-color-line-icon.jpg?s=612x612&w=0&k=20&c=XLjIBluhss2ZY_IKD4WI8sKghwWmqtXDRs1_6DtWP2s=" alt="" height="320px" width="430px"></div>
            <div class="column"><img src="https://images.unsplash.com/photo-1666625519749-9556539ac84d?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wyNjI5NjF8MHwxfHNlYXJjaHwzfHx2ZWhpY2xlJTIwZmluYW5jZXxlbnwwfHx8fDE2ODc5Mzg5NzN8MA&ixlib=rb-4.0.3&q=80&w=1080" alt="" height="320px" width="430px"></div>

        </div>
        <div class="themain">
            <div class="main3">
                <h3>Easy vehicle loan approval</h3><br>Get quick and hassle-free approval for your vehicle loan with our streamlined application process and attractive low interest rates. <br><br>
            </div>
            <div class="main3">
                <h3> Flexible Repayment Options</h3><br>Choose from a variety of repayment options that suit your financial situation and make paying back your vehicle loan convenient and stress-free. <br><br>
            </div>
            <div class="main3">
                <h3>Expert Financial Guidance</h3><br>Receive personalized advice and expert guidance from our team of financial professionals to help you make informed decisions regarding your vehicle finance. <br><br>
                <br>
            </div>
        </div>
        <div class="morein"></div>
        <hr class="line">
        <div class="buttons1">
            <button type="button" onclick="signIn()">Apply Loan</button>
            <button type="button" onclick="signIn()">Receive Due Amount</button>
        </div>


        <footer>
            <div class="footer">
                <p>&copy; 2024 Automobile Consultancy. All rights reserved.</p>
            </div>
        </footer>
        </form>
    <?php } ?>
</body>

</html>