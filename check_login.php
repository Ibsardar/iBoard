<!-- 

        Name:    check_login.php

        Auth:    Ibrahim Sardar

        Desc:    Validates user login for iBoard.com
        
        Note:    ///  Securities:                  ///
                 ///  1. escape strings            ///
                 ///  2. hashed password           /// ...not used yet
                 ///  3. stored procedures         /// ...not used yet
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
    $g_page = 'check_login';
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

            <!--
                   
                    Validate
                    
            -->
            <?php
            
            //other vars
            $info = "";
            $success = false;
            
            //validator vars
            $v_uname  = false;  // > username match in db
            $v_pwd    = false;  // > password match in db
            
            //vars
            $uname  = "";
            $pwd    = "";
            $active = "";
            
            //get vars
            if (isset($_POST['uname'])) $uname = trim($_POST['uname']);
            if (isset($_POST['pwd']))   $pwd   = trim($_POST['pwd']);
            
            //if user submitted login info
            if (isset($_POST['submit_login'])) {
                
                  ///////////////////////////////////////////////////
                 ///////////////////////////////////////////////////
                /// SECURITY MEASURE #1 ///////////////////////////
                $uname = mysqli_real_escape_string($con,$uname);
				$pwd   = mysqli_real_escape_string($con,$pwd);
                ///////////////////////////////////////////////////
                  
                  /////////////////////////////////////////
                 /////////////////////////////////////////
                /// SECURITY MEASURE #3, #4 /////////////
                //
                // validate username/email in db
                //
                //$rows = db_check_acc($con,"Username",$uname,"Password",$pwd);
                $sql = "select count(*)
                        from ibr_accounts
                        where Username='$uname' and Password='$pwd'";
                $arr = db_do($con,$sql);
                $rows = $arr[0][0];
                
                /*
                 //\\
                //..\\     <- cool house
                ||..||
                ======
                */
                
                //check
                if ($rows == 0)
                    array_push($s_errors, "Incorrect login information.");
                elseif ($rows > 1)
                    array_push($s_errors, "Multiple accounts exist - database is corrupted.");
                elseif ($rows == 1){
                    $v_uname = true;
                    $v_pwd   = true;
                } else
                    array_push($s_errors, "Account check error.");
                /////////////////////////////////////////
                
                //if submission is valid:
                // - Active = yes
                // - Acc_Status_ID != 2 & 3 (not terminated or locked)
                if ($v_uname  &&
                    $v_pwd) {
                    
                    $sql = "select *
                            from ibr_accounts
                            where Username='$uname' and Password='$pwd'";
                    $arr = db_do($con,$sql);
                    $row = $arr[0];
                    
                    //columns to check
                    if ($row["Activated"] == "yes"){
                        if ($row["Acc_Status_ID"] == 1){
                            
                            //record the time at the user login 
                            $_SESSION['timeout'] = time();
                              ///////////////////////////////
                             ///////////////////////////////
                            /// SECURITY MEASURE #2 ///////
                            // note: no salt
                            $hpwd = sha1($pwd);
                            ///////////////////////////////
                            //get cols
                            $a_id     = $row["Account_ID"];
                            $a_un     = $row["Username"];
                            $a_pw     = $row["Password"];
                            $a_em     = $row["Email"];
                            $a_about  = $row["About_Me"];
                            $a_type   = $row["Acc_Type_ID"];
                            $a_status = $row["Acc_Status_ID"];
                            $a_active = $row["Activated"];
                            $a_code   = $row["Activation_Code"];
                            //notify
                            $success = true;
                            $info = "Logging In...";
                            
                            
                        }else{
                            array_push( $s_errors, "<div style='color:red'>Account is either locked or terminated. Contact site administrator for further assistance.</div>" ); }
                    }else{
                        array_push( $s_errors, "<div style='color:red'>Account is not active. Check your email and follow the instructions to activate your account.</div>" ); }
                    
                }//end check if submission valid
            
            //if no submission, go home
            } else {
                header ("location: lab4.php");
                exit();
            }//end if (submit login)
            
            ?>
            
            <!--
                   
                    Page Content
                    
            -->
            <div style="text-align: center;">
            <?php
                
                
                print "<h2> $info </h2>";
                print "<br><br>";
                foreach($s_errors as $e){
                    print "<br>" . $e;
                }
                if($success) {
                    $success = false;
                    
                    $_SESSION['ac_id']     = $a_id;
                    $_SESSION['uname']     = $a_un;
                    $_SESSION['pass']      = $a_pw;
                    $_SESSION['email']     = $a_em;
                    $_SESSION['about']     = $a_about;
                    $_SESSION['ac_type']   = $a_type;
                    $_SESSION['ac_status'] = $a_status;
                    $_SESSION['active']    = $a_active;
                    $_SESSION['a_code']    = $a_code;
                    $_SESSION['user_time'] = time();
                    
                    //for debugging
                    echo
                    "
                    <script type='text/javascript'>
                        console.log( 'Login Success:' );
                        console.log( '  - user ID: ".$_SESSION['ac_id']."' );
                        console.log( '  - user name: ".$_SESSION['uname']."' );
                        console.log( '  - user pass: ".$_SESSION['pass']."' );
                        console.log( '  - user email: ".$_SESSION['email']."' );
                        console.log( '  - user active?: ".$_SESSION['active']."' );
                        console.log( '  - user status: ".$_SESSION['ac_status']."' );
                        console.log( '  - user type: ".$_SESSION['ac_type']."' );
                    </script>
                    ";
                    
                    //wait 1.5 sec to goto home page
                    echo "
                    <script type='text/javascript'>
                        function gohome() {
                            console.log('goin home...');
                            document.getElementById('loader').style.display='none';
                            window.location.href = 'lab4.php';
                        }
                        window.setTimeout(gohome, 1000);
                    </script>
                    ";
                } else {
                    //wait 1.5 sec to hide animation
                    echo "
                    <script type='text/javascript'>
                        function stop() {
                            document.getElementById('loader').style.display='none';
                        }
                        window.setTimeout(stop, 1000);
                    </script>
                    ";
                }
                
            ?>
            </div>
            
        </div>

















    </body>
</html>