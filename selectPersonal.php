<?php
    include "vendors/components/core.php";
    $_SESSION['userDB']['SelectedPlay']=$_POST['idPlayer'];
    header("Location: index.php");
?>