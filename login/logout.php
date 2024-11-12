<?php
      session_start();
      session_destroy();
      header("Location: ../loan.php");
?>