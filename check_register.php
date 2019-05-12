<!-- 

        Name:    check_register.php

        Auth:    Ibrahim Sardar

        Desc:    Validates user registration for iBoard.com
        
        Note:    ///  Securities:                  ///
                 ///  1. escape strings            ///
                 ///  2. hashed password           /// ...not used yet
                 ///  3. stored procedures         ///
                 ///  4. avoid duplicate accounts  ///
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
    $g_page = 'check_register';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Registration</title>
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

            <!--
                   
                    Validate
                    
            -->
            <?php
            
            //other vars
            $info = "";
            $sent = false;
            
            //validator vars
            $v_email  = false;  // > is valid email?
            $v_email2 = false;  // > validate using another method
            $v_email3 = false;  // > is existent in db?
            $v_uname  = false;  // > is existent in db?
            $v_pwd    = false;  // > password format correct?
                                //   passwords match?
            $v_agree  = false;  // > user has agreed?
                                //=======================================
                                // > ALSO CHECK IF INPUT IS NOT ILLEGAL
                                //   FOR ALL VALIDATOR VARS
            
            //temp vars
            $email  = "";
            $uname  = "";
            $pwd    = "";
            $vpwd   = "";
            $about  = "";
            $agree  = "";
            
            //get vars
            if (isset($_POST['email']))  $email  = trim($_POST['email']);
            if (isset($_POST['uname']))  $uname  = trim($_POST['uname']);
            if (isset($_POST['pwd']))    $pwd    = trim($_POST['pwd']);
            if (isset($_POST['vpwd']))   $vpwd   = trim($_POST['vpwd']);
            if (isset($_POST['about']))  $about  = trim($_POST['about']);
            if (isset($_POST['agree']))  $agree  = trim($_POST['agree']);
            
            //if user did submit registration info
            if (isset($_POST['submit_register'])) {
                
                  ///////////////////////////////////////////////////
                 ///////////////////////////////////////////////////
                /// SECURITY MEASURE - ESCAPE STRING //////////////
                $email = mysqli_real_escape_string($con,$email);
				$uname = mysqli_real_escape_string($con,$uname);
				$pwd   = mysqli_real_escape_string($con,$pwd);
				$about = mysqli_real_escape_string($con,$about);
                ///////////////////////////////////////////////////
                
                //validate username (8 to 50 chars)
                if (strlen($uname) > 7 && strlen($uname) < 51)
                    $v_uname = true;
                
                //validate username/email
                if (handle_email($email))
                    $v_email = true;
                
                //validate username/email another way
                if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL))
                    array_push($s_errors, "Entered email did not get past filter.");
                else
                    $v_email2 = true;
                  
                  /////////////////////////////////////////
                 /////////////////////////////////////////
                /// SECURITY MEASURE #3, #4 /////////////
                //
                // validate username/email in db
                //
                
                $sql = "select count(*) from ibr_accounts a
                        where a.Email='$email' or a.Username='$uname'";
                
                $arr = db_do($con,$sql);
                
                if ($arr != -1) {
                    if ($arr[0][0] == 0) {
                        $v_email3 = true;
                    } else {
                        array_push($s_errors, "An account with that username or email has been taken.");
                    }
                }
                /////////////////////////////////////////
                
                
                //validate password
                if (handle_pass($pwd,$vpwd))
                    $v_pwd = true;
                
                //manually validate if user agreed to terms
                if ($agree != "yes")
                    array_push($s_errors, "You must agree to the terms and conditions to proceed.");
                else
                    $v_agree = true;
                
                //if submission is valid:
                // - email an activation code w/ link
                // - connect to db
                //   - implement security
                //   - connect to accounts table
                //   - add row to db
                //   - input info as well as activation code and 'F' for active column
                if ($v_email  &&
                    $v_email2 &&
                    $v_email3 &&
                    $v_uname  &&
                    $v_pwd    &&
                    $v_agree) {
                    
                    //vars
                    $hpwd = "";
                    $code = get_code(50);
                    $subject = "iBoard Account Activation";
                    $activate_link = "http://corsair.cs.iupui.edu:20241/final_experimental/activate.php?code=$code&user=$uname";  //<-- for my corsair server

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
                    
                      ///////////////////////////////////////
                     ///////////////////////////////////////
                    /// SECURITY MEASURE - Hash Password //
                    $hpwd = sha1($pwd);
                    ///////////////////////////////////////

                      ///////////////////////////////
                     ///////////////////////////////
                    /// SECURITY MEASURE - SP /////
                    $sql = "call ibr_sp_add_acc(
                            '$uname',
                            '$pwd',
                            '$email',
                            '$about',
                            1, " . /* user */ "
                            2, " . /* locked */ "
                            'no',
                            '$code')";
                    db_do($con,$sql,"insert");
                    ///////////////////////////////
                    
                    //send email
                    $err = "none";
                    $mailer = new Mail();
                    if (($mailer->sendMail($email, /* name */$uname, $subject, $body))==true) {
                        
                        //set notification
                        $info = "<b>Thank you for registering. An activation email has
                                 been sent to the address you have just registered.</b>";
                        
                        //indicate email has been sent
                        $sent = true;
                        
                    } else {
                        
                        $err = 'Email failed to send.<br>Info: <'.$email.', '. $uname.', '.$subject.'>';
                        
                    }//end send mail
                    
                    //append to error list
                    if ($err != "none")
                        array_push($s_errors, $err);
                    
                } else {
                
                    array_push( $s_errors, "<div style='color:red'>Registration Failed.</div>" );
                    
                }//end if all valid
                
                //create confirm message
                $info = $info . <<<HERE
                    <h3>
                    <br><br>
                    <h2>
                    Results: <br>
                    </h2>
                    <br>
                    <br>
                    LOGIN:<br>
                    <br>
                    Username: <h5>$uname</h5> <br>
                    Email:    <h5>$email</h5> <br>
                    Password: <h5>$pwd</h5> <br>
                    <br>
                    <br>
                    PERSONAL:<br>
                    <br>
                    Account Type: <h5>normal</h5> <br>
                    Account Status: <h5>locked (until activated)</h5> <br>
                    About You: <h5>$about</h5> <br>
                    </h3>
HERE;
            
            //if user did not submit anything
            // - go home
            } else {
                header ("location: lab4.php");
                exit();
            }//end if (submit register)
            
            ?>
            
            <div style="text-align: center; display:none"
                 id="reg_out">
            <?php
                print $info;
                print "<br><br>";
                foreach($s_errors as $e){
                    print "<br>" . $e;
                }
            ?>
            </div>
            
            <!--
                   
                    Hide Loading Animation (1 s)
                    
            -->
            <script type='text/javascript'>
                function load() {
                    document.getElementById('loader').style.display='none';
                    document.getElementById('reg_out').style.display='block';
                }
                window.setTimeout(load, 1000);
            </script>
            
        </div>

















    </body>
</html>