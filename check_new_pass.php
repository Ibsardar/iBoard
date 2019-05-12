<!-- 

        Name:    check_new_pass.php

        Auth:    Ibrahim Sardar

        Desc:    Validates a new password for user on iBoard.com
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
    $g_page = 'check_new_pass';
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>iBoard - New Password</title>
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
            
            //validator vars
            $v_uname   = false;
            $v_pwd     = false;
            $v_pwd_new = false;
            
            //temp vars
            $new_pwd  = "";
            $old_pwd  = "";//$s_pwd;
            $my_uname = "";//$s_uname;
            
            //get vars
            if (isset($_POST['uname']))   $my_uname   = trim($_POST['uname']);
            if (isset($_POST['opwd']))    $old_pwd    = trim($_POST['opwd']);
            if (isset($_POST['npwd']))    $new_pwd    = trim($_POST['npwd']);
            
            //if user did submit registration info
            if (isset($_POST['submit_change'])) {
                
                  ///////////////////////////////////////////////////
                 ///////////////////////////////////////////////////
                /// SECURITY MEASURE #1 ///////////////////////////
                $my_uname = mysqli_real_escape_string($con,$my_uname);
				$old_pwd  = mysqli_real_escape_string($con,$old_pwd);
				$new_pwd  = mysqli_real_escape_string($con,$new_pwd);
                ///////////////////////////////////////////////////
                  
                  /////////////////////////////////////////
                 /////////////////////////////////////////
                /// SECURITY MEASURE #3, #4 /////////////
                //
                // validate username/email and pass in db
                //
                
                $sql = "select count(*) from ibr_accounts a
                        where a.Username='$my_uname' and a.Password='$old_pwd'";
                
                $arr = db_do($con,$sql);
                
                if ($arr != -1) {
                    if ($arr[0][0] == 1) {
                        $v_uname = true;
                        $v_pwd   = true;
                    } else {
                        array_push($s_errors, "An account with these credentials does not exist.");
                    }
                }
                /*******
                if (db_check_acc($con,"Email",$my_uname,"Password",$old_pwd) == 1){
                    $v_uname = true;
                    $v_pwd   = true;
                }elseif (db_check_acc($con,"Email",$my_uname) > 1)
                    array_push($s_errors, "Multiple accounts already exist - database is corrupted.");
                elseif (db_check_acc($con,"Email",$my_uname) == 0)
                    array_push($s_errors, "Account does not exist.");
                else
                    array_push($s_errors, "Account check error.");
                *****/
                /////////////////////////////////////////
                
                //validate password
                if (handle_pass($new_pwd,$new_pwd))
                    $v_pwd_new = true;
                
                //if submission is valid:
                // - email/uname is valid
                // - password in same row as email/uname in db
                // - new password in correct format
                if ($v_uname &&
                    $v_pwd   &&
                    $v_pwd_new) {
                    
                    //vars
                    $hpwd = "";
                    
                      ///////////////////////////////
                     /////////////////////////////// **not used yet
                    /// SECURITY MEASURE #2 ///////
                    $hpwd = sha1($new_pwd);
                    ///////////////////////////////
                    
                    //change password
                    $sql = "update ibr_accounts
                            set Password = '$new_pwd'
                            where Username='$my_uname'";
                
                    $arr = db_do($con,$sql,"update");
                    //db_set_acc( $con,$my_uname,"Password",$new_pwd );
                    
                    //update our current session variable
                    $_SESSION['pass'] = $new_pwd;
                
                    //create confirm message
                    $info = "Password successfully changed.";
                    
                } else {
                
                    array_push( $s_errors, "<div style='color:red'>Request Unexpectedly Failed.</div>" );
                    
                }//end if all valid
            
            //if user did not submit anything
            // - go home
            } else {
                header ("location: settings.php");
                exit();
            }//end if (submit register)
            
            ?>
            
            <div style="text-align: center; display:none"
                 id="change_pass_out">
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
                    Show output
                    
            -->
            <script type='text/javascript'>
                function load() {
                    document.getElementById('loader').style.display='none';
                    document.getElementById('change_pass_out').style.display='block';
                }
                window.setTimeout(load, 1000);
            </script>
            
        </div>

















    </body>
</html>