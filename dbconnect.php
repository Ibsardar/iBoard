<?php
    /*
     * This file defines database connection. This file is included in any files that needs database connection
     * 
     */

    //connection
    $con = mysqli_connect("localhost","ibsardar","ibsardar","ibsardar");     //<-- for my home
    //$con = mysqli_connect("localhost","ibsardar","ibsardar","ibsardar_db");  //<-- for my corsair

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        echo "<script>console.log('PHP: Failed to connect to {ibsardar\'s} database, MySQL: ".mysqli_connect_error()."');</script>";
    } else {
        echo "<script>console.log('PHP: Connected to {ibsardar\'s} database!');</script>";
    }
?>
