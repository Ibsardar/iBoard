<!-- 

        Name:    email_pass.php

        Auth:    Ibrahim Sardar

        Desc:    Forgotten password sender page of iBoard.com

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
    $g_page = 'email_pass';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - Forgot Password</title>
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
            
                    Send Password via Email
            
            -->
            
            <!-- check if submit -->
            
            <?php
            
            //vars
            $err = "";
            $pwd = "";
            $usr = "";
            $info = "";
            $email = "";
            $sent = false;
            $found = false;
            $checked = false;
            $subject = "iBoard Account Forgot Password";
            
            //get vars
            if (isset($_POST['email']))
                $email  = trim($_POST['email']);
            
            //check submit
            if (isset($_POST['submit'])) {
                
                //escape query string
                $email = mysqli_real_escape_string($con,$email);
                
                // get account password with this email
                $sql = "select Password, Username
                        from ibr_accounts
                        where Email = '$email'";
                    
                $arr = db_do($con, $sql);
                
                if ($arr != -1) {
                    if (count($arr) > 0) {
                        $pwd = $arr[0][0];
                        $usr = $arr[0][1];
                        $found = true;
                    } else {
                        array_push($s_errors, "<span style='color:red'> An account with that email does not exist. </span>");
                    }
                } 
            
                if ($found){
                    //email it
                    // email content
                    $body = <<<HERE
                    <h2> iBoard Account Forgot Password </h2>
                    <h4>
                    This is your password: <br>
                    $pwd<br>
                    <br>
                    <br>
                    If you did not request your password at iBoard, please ignore and discard this email. <br><br>
                     -iBoard Overseer | Auto NO-REPLY Emailer
                    </h4>
HERE;

                    //send email
                    $err = "none";
                    $mailer = new Mail();
                    if (($mailer->sendMail($email, $usr, $subject, $body))==true) {

                        //set notification
                        $info = "<b>Thank you. An email containing your password has been sent.</b>";

                        //indicate email has been sent
                        $sent = true;

                    } else {

                        $err = "Email failed to send. <br> Info: ".$email.', '. $usr.', '.$subject.', '.$body;

                    }//end send mail
                    
                }

                //append to error list
                if ($err != "none")
                    array_push($s_errors, $err);
                
                $checked = true;
                
            }//end check submit
            
            ?>
            
            
            <!-- submission form modal -->
            
            <div id="input_modal" class="modal">
             
                <span onclick="document.getElementById('register_modal').style.display='none';
                               window.location.href='login.php';"
                      class="close"
                      title="Close Modal">&times;</span>

                <!-- Content -->
                <form class="modal-content animate"
                      method="post"
                      action="email_pass.php">
                      
                    <div class="imgcontainer">
                        <img src="user_icon_01.png"
                             alt="Avatar"
                             class="avatar">
                    </div>

                    <div class="container">
                              
                        <label style="text-align:center"></label>
                               
                        <label><b>Email</b></label>
                        <input type="text"
                               pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$"
                               required title="user@domain.institution"
                               placeholder="Enter Email"
                               name="email"
                               required>
                        <br>

                        <button type="submit"
                                name="submit">Send</button>
                        <!--<input type="checkbox"
                               checked="checked"> Remember me-->
                        
                    </div>

                    <div class="container"
                         style="background-color: #f1f1f1">
                         
                        <button type="button"
                                onclick="document.getElementById('input_modal').style.display='none';
                                         window.location.href='login.php';"
                                class="cancelbtn">Cancel</button>
                                
                        <!--<span class="psw">Forgot <a href="#">password?</a></span>-->
                        
                    </div>
                    
                </form>
                
                <!-- show modal -->
                <script>
                    document.getElementById('input_modal').style.display='block';
                </script>
              
            </div>
            <!-- End Of Pop-Up -->
            
            <!-- check if submit -->
            
            <!-- * hide modal -->
            
            <!-- * show email conformation, error messages -->
            
                    
            <!-- Show Loading Animation -->
            <div class="loader" id="loader" style="display:none">
            </div>

            <div class="my_center" id="sending" style="display:none">

                <div class="my_vpad"></div>
                <div class="my_vpad"></div>
                <div class="my_vpad"></div>

                <h2>
                    Sending Password...
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

                    Hide Loading Animation (1.5 s to show info after submit)

            -->
            <?php
            if ($checked) { //(isset($_POST['submit'])) {
                echo "
                <script type='text/javascript'>
                    document.getElementById('loader').style.display='block';
                    document.getElementById('sending').style.display='block';
                    document.getElementById('input_modal').style.display='none';
                    function goback() {
                        document.getElementById('loader').style.display='none';
                        document.getElementById('sending').style.display='none';
                        document.getElementById('act_out').style.display='block';
                    }
                    window.setTimeout(goback, 1500);
                </script>
                ";
            }
            ?>
            
        </div>
        
        
















    </body>
</html>