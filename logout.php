<!-- 

        Name:    logout.php

        Auth:    Ibrahim Sardar

        Desc:    Logout page of iBoard.com

-->

<!-- include session/globals getter file,
     include custom php utils,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
    $g_page = 'logout';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Accounts</title>
        <link rel="stylesheet" href="css/ibr_custom2.css" type="text/css">
        <script src="js/FE_functions.js" type="text/javascript"></script>
    </head>
    <body>















        
        <!-- include side menu data -->
        <?php
            include "header.php";
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            
            <!-- show side menu -->
            <script>
                open_menu();
            </script>
            
            <!--
                   
                    Show Loading Animation
                    
             -->
            <div class="loader" id="loader">
            </div>
        
            
            <?php
            
            if($s_usertype == "user" || $s_usertype == "admin" || $s_usertype == "super_admin") {
                /*$_SESSION['Account_ID']      = null;
                $_SESSION['Username']        = null;
                $_SESSION['Password']        = null;
                $_SESSION['Email']           = null;
                $_SESSION['About_Me']        = null;
                $_SESSION['Acc_Type_ID']     = null;
                $_SESSION['Acc_Status_ID']   = null;
                $_SESSION['Activated']       = null;
                $_SESSION['Activation_Code'] = null;*/
                session_destroy();
                echo "<div style='text-align:center'>
                      <h2>Logging Out...</h2>
                      </div>";
            } else {
                header("location: lab4.php");
                exit();
            }

            ?>
            
            <!--
                   
                    Hide Loading Animation (1 s to home pg)
                    
            -->
            <script type='text/javascript'>
                function gologin() {
                    document.getElementById('loader').style.display='none';
                    window.location.href = 'login.php';
                }
                window.setTimeout(gologin, 1000);
            </script>
            
            
        </div>

















    </body>
</html>