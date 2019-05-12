<!-- 

        Name:    send_act.php

        Auth:    Ibrahim Sardar

        Desc:    Activation Code sender page of iBoard.com

-->

<!-- include session/globals getter file,
     include back end, php functions,
     include once the mail class,
     include connection once to 'ibsardar' database on mySQL,
     let the server know what page we're on -->
<?php
    include "get_sessions.php";
    include "php/BE_functions.php";
	require_once "mail/mail.class.php";
    include_once "dbconnect.php";
    $g_page = 'send_act';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Activation</title>
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
           
            <!--
            
                    Send Email
            
            -->
            <?php
            
            
            
            //vars
            $err = "";
            $info = "";
            $sent = false;
            $code = get_code(50);
            $subject = "iBoard Account Activation";
            $activate_link = "http://corsair.cs.iupui.edu:20241/final_experimental/activate.php?code=$code&user=$s_uname";  //<-- for my corsair server
            
               ///////////////////////////////
              // set code for this account //
            db_set_acc($con, $s_uname, "A_Code", $code);
            ///////////////////////////////

            // email content
            $body = <<<HERE
            <h2> iBoard Account Activation </h2>
            <h4>
            Thank you for registering at iBoard! <br>
            Click on the link below to activate your account: <br><br>
            <a href=$activate_link> $activate_link </a> <br><br>
            Activation Code: <h3>$code</h3> <br>
            If you did not sign up for an account at iBoard, please ignore and discard this email. <br><br>
             -iBoard Overseer | Auto NO-REPLY Emailer
            </h4>
HERE;

            //send email
            $err = "none";
            $mailer = new Mail();
            if (($mailer->sendMail($s_uname, $s_fname, $subject, $body))==true) {

                //set notification
                $info = "<b>Thank you for registering. An activation email has
                         been sent to the address you have just registered.</b>";

                //indicate email has been sent
                $sent = true;

            } else {

                $err = "Email failed to send. Info: ".$s_uname.', '. $s_fname.', '.$subject.', '.$body;

            }//end send mail

            //append to error list
            if ($err != "none")
                array_push($s_errors, $err);
            
            
            
            ?>
            
            <!-- show the side menu -->
            <script>
                open_menu();
            </script>
            
            <div class="loader" id="loader">
            </div>
        
            <div class="my_center" id="sending">

                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
                <div class="my_vpad"></div>

                <h2>
                    Sending Activation Code...
                </h2>
                
            </div>
            
            <!-- Result Info -->
            <div style="text-align: center; display:none"
                 id="act_out">
            <?php
                print $info;
                print "<br><br>";
                foreach($s_errors as $e){
                    print "<br>" . $e;
                }
            ?>
            </div>
            
            <!--

                    Hide Loading Animation (1.5 s to show info)

            -->
            <script type='text/javascript'>
                function goback() {
                    document.getElementById('loader').style.display='none';
                    document.getElementById('sending').style.display='none';
                    document.getElementById('act_out').style.display='block';
                }
                window.setTimeout(goback, 1500);
            </script>
            
        </div>
        
        
















    </body>
</html>