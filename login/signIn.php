<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginStyle.css">
    <title>Login | Page</title>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <?php

            include("config.php");
            require_once("config.php");
            if (isset($_POST['submit'])) {
                $email = mysqli_real_escape_string($con, $_POST['email']);
                $password = mysqli_real_escape_string($con, $_POST['password']);
                $password1 = md5($password);

                $result = mysqli_query($con, "SELECT * FROM users WHERE Email='$email' AND Password='$password1'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);
                // var_dump($row);
                if (is_array($row) && !empty($row)) {
                    $_SESSION['valid'] = $row['Email'];
                    $_SESSION['username'] = $row['Username'];
                    $_SESSION['phone'] = $row['Phone'];
                    $_SESSION['id'] = $row['Id'];
                } else {
                    echo "<div class='message'>
                      <p>Wrong Username or Password</p>
                       </div> <br>";
                    echo "<a href='signIn.php'><button class='btn'>Go Back</button>";
                }
                if (isset($_SESSION['valid'])) {
                    header("Location: ../loan-main.php");
                }
            } else {


            ?>
                <header>Login</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" autocomplete="on" required>
                    </div>

                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" autocomplete="on" required>
                    </div>

                    <div class="field">

                        <input type="submit" class="btn" name="submit" value="Login" required>
                    </div>
                    <div class="links">
                        Don't have account? <a href="signUp.php">Sign Up Now</a>
                    </div>
                </form>
        </div>
    <?php }
    ?>
    </div>
</body>

</html>