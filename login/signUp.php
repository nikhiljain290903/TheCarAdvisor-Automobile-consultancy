<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="loginStyle.css">
    <title>SignUp</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">

            <?php

            include("config.php");
            if (isset($_POST['submit'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $phNo = $_POST['phNo'];
                $password = $_POST['password'];
                $password = md5($password);

                //verifying the unique email

                $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");

                if (mysqli_num_rows($verify_query) != 0) {
                    echo "<div class='message'>
                      <p>This email is used, Try another One Please!</p>
                  </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
                } else {

                    mysqli_query($con, "INSERT INTO users(Username,Email,Phone,Password) VALUES('$username','$email','$phNo','$password')") or die("Erroe Occured");

                    echo "<div class='message'>
                      <p>Registration successfully!</p>
                  </div> <br>";
                    echo "<a href='signIn.php'><button class='btn'>Login Now</button>";
                }
            } else {

            ?>

                <header>Sign Up</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="age">Mobile Number</label>
                        <input type="number" name="phNo" id="phNo" autocomplete="off" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="off" required>
                    </div>

                    <div class="field">

                        <input type="submit" class="btn" name="submit" value="Register" required>
                    </div>
                    <div class="links">
                        Already a member? <a href="signIn.php">Sign In</a>
                    </div>
                </form>
        </div>
    <?php }
            session_destroy(); ?>
    </div>
</body>

</html>